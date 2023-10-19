<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class ReferralSlipsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->ReferralSlips = TableRegistry::getTableLocator()->get('ReferralSlips');

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

      $conditions['date'] = " AND DATE(ReferralSlip.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(ReferralSlip.date) >= '$start' AND DATE(ReferralSlip.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Session->read('Auth.User.studentId');

      $conditions['studentId'] = "AND ReferralSlip.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->ReferralSlips->paginate($this->ReferralSlips->getAllReferralSlip($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $referral_slips = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($referral_slips as $data) {

      $datas[] = array(

  
          'id'            => $data['id'],
  
          'code'          => $data['code'],

          'full_name'  => $data['full_name'],

          'year'          => $data['year'],

          'reason'       => $data['reason'],

          'course'    => $data['name'],


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

    $requestData = $this->request->getData('ReferralSlip');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->ReferralSlips->newEmptyEntity();
   
    $data = $this->ReferralSlips->patchEntity($data, $requestData); 

    if ($this->ReferralSlips->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Referral Slip has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Referral Slip Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Referral Slip cannot saved this time.',

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

    $data['ReferralSlip'] = $this->ReferralSlips->find()

      ->contain([

          'CollegePrograms' => [

            'conditions' => ['CollegePrograms.visible' => 1]

          ],

          'YearLevelTerms' => [

            'conditions' => ['YearLevelTerms.visible' => 1]

          ]


        ])


      ->where([

        'ReferralSlips.visible' => 1,

        'ReferralSlips.id' => $id

      ])

      ->first();

      $data = [

        'ReferralSlip' => $data['ReferralSlip'],

        'CollegeProgram' => $data['ReferralSlip']->college_program,

        'YearLevelTerm' => $data['ReferralSlip']->year_level_term

      ];

      unset($data['ReferralSlip']->college_program);

      unset($data['ReferralSlip']->year_level_term);

      $data['ReferralSlip']['date'] = isset($data['ReferralSlip']['date']) ? date('m/d/Y', strtotime($data['ReferralSlip']['date'])) : null;
      

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

   $data = $this->ReferralSlips->get($id); 

    $requestData = $this->getRequest()->getData('ReferralSlip');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->ReferralSlips->patchEntity($data, $requestData); 

    if ($this->ReferralSlips->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Referral Slip has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Referral Slip',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Referral Slip cannot updated this time.',

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

    $data = $this->ReferralSlips->get($id);

    $data->visible = 0;

    if ($this->ReferralSlips->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Referral Slip has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Referral Slip cannot be deleted at this time.'

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
