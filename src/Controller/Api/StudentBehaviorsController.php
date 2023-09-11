<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class StudentBehaviorsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->StudentBehavior = TableRegistry::getTableLocator()->get('StudentBehaviors');

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

      $conditions['date'] = " AND DATE(StudentBehavior.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentBehavior.date) >= '$start' AND DATE(StudentBehavior.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    
    $conditions['program_id'] = " AND StudentBehavior.course_id = 0";

    if ($this->request->getQuery('program_id')) {

      $program_id = $this->request->getQuery('program_id');

      $conditions['program_id'] = " AND StudentBehavior.course_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

    }

    $conditions['year'] = "";

    if ($this->request->getQuery('year_term_id')) {

      $year = $this->request->getQuery('year_term_id');

      $conditions['year'] = " AND StudentBehavior.year_term_id = '$year' ";

      $conditionsPrint .= '&year='.$year;

    }

    $limit = 25;

    $tmpData = $this->StudentBehavior->paginate($this->StudentBehavior->getAllStudentBehavior($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $StudentBehavior = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($StudentBehavior as $data) {

      $datas[] = array(
          
          'id'          => $data['id'],

          'student_name'   => $data['student_name'],

          'student_no'  => $data['student_no'],

          'program'     => $data['program'],

          'behavior'     => $data['behavior'],

          'date'     => $data['date'],

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

    $requestData = $this->request->getData('StudentBehavior');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->StudentBehavior->newEmptyEntity();
   
    $data = $this->StudentBehavior->patchEntity($data, $requestData); 

    if ($this->StudentBehavior->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Student Behavior has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Student Behavior Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Behavior cannot saved this time.',

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

    $data['StudentBehavior'] = $this->StudentBehavior->find()
    ->contain(['Students', 'CollegePrograms'])
    ->where([
        'StudentBehaviors.visible' => 1,
        'StudentBehaviors.id' => $id
    ])
    ->first();

      $data['StudentBehavior']['date'] = isset($data['StudentBehavior']['date']) ? date('m/d/Y', strtotime($data['StudentBehavior']['date'])) : null;

      $data['Student'] = $data['StudentBehavior']['student'];

      $data['CollegeProgram'] = $data['StudentBehavior']['college_program'];


      unset($data['StudentBehavior']['student']);
      
      unset($data['StudentBehavior']['college_program']);

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

    $data = $this->StudentBehavior->get($id); 

    $requestData = $this->getRequest()->getData('StudentBehavior');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->StudentBehavior->patchEntity($data, $requestData); 

    if ($this->StudentBehavior->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' => 'Student Behavior has been successfully updated.',

        'data'=> $requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Student Behavior',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Behavior cannot updated this time.',

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

    $data = $this->StudentBehavior->get($id);

    $data->visible = 0;

    if ($this->StudentBehavior->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Behavior has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Behavior cannot be deleted at this time.'

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

  public function approve($id = null){

    $this->autoRender = false;

    $data = $this->StudentBehavior->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->StudentBehavior->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Behavior has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Behavior cannot be deleted at this time.'

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
