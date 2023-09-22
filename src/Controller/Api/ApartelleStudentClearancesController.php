<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class ApartelleStudentClearancesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->ApartelleStudentClearances = TableRegistry::getTableLocator()->get('ApartelleStudentClearances');

    $this->ApartelleRegistrations = TableRegistry::getTableLocator()->get('ApartelleRegistrations');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    $condition['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND ApartelleStudentClearance.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')!=null) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND ApartelleStudentClearance.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $dataTable = TableRegistry::getTableLocator()->get('ApartelleStudentClearances');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllApartelleStudentClearance($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $apartelleStudentClearances = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($apartelleStudentClearances as $apartelleStudentClearances) {

      $datas[] = array(

        'id'                       => $apartelleStudentClearances['id'],

        'code'                     => $apartelleStudentClearances['code'],

        'student_name'             => $apartelleStudentClearances['student_name'],

        'course'                   => $apartelleStudentClearances['name'],

        'year_level'               => $apartelleStudentClearances['description'],

        'status'                   => $apartelleStudentClearances['approve'],
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

    $requestData = $this->request->getData('ApartelleStudentClearance');

    $data = $this->ApartelleStudentClearances->newEmptyEntity();
   
    $data = $this->ApartelleStudentClearances->patchEntity($data, $requestData); 

    if ($this->ApartelleStudentClearances->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Apartelle Student Clearance has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Apartelle Student Clearance',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Apartelle Student Clearance cannot saved this time.',

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

    $data['ApartelleStudentClearance'] = $this->ApartelleStudentClearances->find()
      ->contain([
          'CollegePrograms',
          'YearLevelTerms'
      ])
      ->where([
          'ApartelleStudentClearances.visible' => 1,
          'ApartelleStudentClearances.id' => $id
      ])
      ->first();

    $data['CollegeProgram'] = $data['ApartelleStudentClearance']['college_program'];

    $data['YearLevelTerm'] = $data['ApartelleStudentClearance']['year_level_term'];

    unset($data['ApartelleStudentClearance']['course']);

    unset($data['ApartelleStudentClearance']['year_level_term']);

    $data['ApartelleStudentClearance']['active_view'] = $data['ApartelleStudentClearance']['active'] ? 'True' : 'False';

    // $data['ApartelleRegistration']['date_of_birth'] = $data['ApartelleRegistration']['date_of_birth']->format('m/d/Y');

    $data['ApartelleStudentClearance']['floors'] = intval($data['ApartelleStudentClearance']['floors']);

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

    $building = $this->ApartelleStudentClearances->get($id); 

    $requestData = $this->getRequest()->getData('ApartelleStudentClearance');

    $this->ApartelleStudentClearances->patchEntity($building, $requestData); 

    if ($this->ApartelleStudentClearances->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Apartelle Student Clearances has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Apartelle Student Clearances',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Apartelle Student Clearances cannot updated this time.',

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

    $data = $this->ApartelleStudentClearances->get($id);

    $data->visible = 0;

    if ($this->ApartelleStudentClearances->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Apartelle Student Clearances has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Apartelle Student Clearances',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Apartelle Student Clearances cannot be deleted at this time.'

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

    $data = $this->ApartelleStudentClearances->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->ApartelleStudentClearances->save($data)) {

      $current_registration = $this->ApartelleRegistrations->find()

        ->where([

          'visible' => 1,

          'approve' => 1

        ])

        ->order([

          'id' => 'DESC'

        ])

      ->first();
        
      $tmpEntity = $this->ApartelleRegistrations->newEntity([

        'id' => $current_registration['id'],

        'active' => 0,

      ]);
      
      $this->ApartelleRegistrations->save($tmpEntity);

      $response = [

        'ok' => true,

        'msg' => 'Apartelle Student Clearances has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Apartelle Student Clearances',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Apartelle Student Clearances cannot be deleted at this time.'

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

  public function disapprove($id = null){

    $this->autoRender = false;

    $data = $this->ApartelleStudentClearances->get($id);

    $data->approve = 2;

    $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->ApartelleStudentClearances->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Apartelle Student Clearances has been successfully disapproved.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Apartelle Student Clearances',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Apartelle Student Clearances cannot be disapproved this time.'

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

}
