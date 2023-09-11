<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;


class AwardeeManagementsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Awardee = TableRegistry::getTableLocator()->get('AwardeeManagements');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(AwardeeManagement.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(AwardeeManagement.date) >= '$start' AND DATE(AwardeeManagement.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $limit = 25;

    $tmpData = $this->Awardee->paginate($this->Awardee->getAllAwardeeManagement($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $Awardee = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // print_r($Awardee);
    foreach ($Awardee as $data) {

      $datas[] = array(

          'id'            => $data['id'],

          'code'          => $data['code'],

          'student_name'  => $data['student_name'],

          'date'          => Time::parse($data['date'])->format('m/d/Y'),

          'program'       => $data['program'],

          'year'          => $data['year'],

          'award_name'      => $data ['award_id'],

          'course_id'     => $data ['course_id']
       
      );

    }

    $response = [

      'ok' => true,

      'data' => $datas,

      'paginator' => $paginator,

      'conditionsPrint' => $conditionsPrint

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function add(){

    $this->autoRender = false;

    $requestData = $this->request->getData('AwardeeManagement');

    $data = $this->Awardee->newEmptyEntity();
   
    $data = $this->Awardee->patchEntity($data, $requestData); 

    if ($this->Awardee->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Awardee has been successfully saved.',

        'data'=>$requestData

      );


        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Awardee Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Awardee cannot saved this time.',

      );

    }

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function view($id = null){

    $data['AwardeeManagement'] = $this->AwardeeManagements
    ->find()
    ->contain([
        'Courses'=> [
            'conditions' => ['Courses.visible' => 1],
          ],
        'Sections'=> [
          'conditions' => ['Sections.visible' => 1],
        ],
        'Colleges'=> [
            'conditions' => ['Colleges.visible' => 1],
        ],
        'CollegePrograms'=> [
            'conditions' => ['CollegePrograms.visible' => 1],
        ],
        'AwardManagements'=> [
            'conditions' => ['AwardManagements.visible' => 1],
        ]
      ])
    ->where([
        'AwardeeManagements.visible' => 1,
        'AwardeeManagements.id' => $id,
    ])
    ->first();

    $data['Course'] = $data['AwardeeManagement']['course'];

    $data['Section'] = $data['AwardeeManagement']['section'];

    $data['College'] = $data['AwardeeManagement']['college'];

    $data['CollegeProgram'] = $data['AwardeeManagement']['college_program'];

    $data['AwardManagement'] = $data['AwardeeManagement']['award_management'];

    unset($data['AwardeeManagement']['course']);
    unset($data['AwardeeManagement']['section']);
    unset($data['AwardeeManagement']['college']);
    unset($data['AwardeeManagement']['college_program']);
    unset($data['AwardeeManagement']['award_management']);



    $response = [

      'ok' => true,

      'data' => $data

    ];

    $this->set([

      'response' => $response,

      '_serialize' => 'response'

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }


  public function edit($id){

    $awardee = $this->Awardee->get($id); 

    $requestData = $this->getRequest()->getData('AwardeeManagement');
    // var_dump($requestData);
    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $data = $this->Awardee->patchEntity($awardee, $requestData); 

    // debug($data);

    if ($this->Awardee->save($awardee)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Awardee has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Edit',

          'description' => 'Awardee Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Awardee cannot updated this time.',

      );

    }

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function delete($id){

    $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->Awardee->get($id);

    $data->visible = 0;

    if ($this->Awardee->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Awardee has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Awardee cannot be deleted at this time.'

      ];

    }

    $this->set([

      'response' => $response,

      '_serialize' => 'response'

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

}
