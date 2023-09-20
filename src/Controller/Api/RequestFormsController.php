<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class RequestFormsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->RequestForms = TableRegistry::getTableLocator()->get('RequestForms');

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

      $conditions['date'] = " AND DATE(RequestForm.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(RequestForm.date) >= '$start' AND DATE(RequestForm.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND RequestForm.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND RequestForm.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->RequestForms->paginate($this->RequestForms->getAllRequestForm($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $RequestForms = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // var_dump($RequestForms);
    foreach ($RequestForms as $data) {

      $datas[] = array(

  
          'id'            => $data['id'],
  
          'code'          => $data['code'],
  
          'or_no'          => $data['or_no'],
  
          'student_name'  => $data['student_name'],
  
          'course'        => $data['course'],
  
          'date'          => fdate($data['date'],'m/d/Y'),
  
          'purpose'   => $data['purpose'],
  
          'remarks'   => $data['remarks'],
  
          'year'          => $data['year'],
  
          'status'        => $data['approve'],

          'date_retrieved'   => fdate($data['date_retrieved'],'m/d/Y'),

          'date_completed'   => fdate($data['date_completed'],'m/d/Y'),

          'date_released'    => fdate($data['date_released'],'m/d/Y'),

          'date_returned'    => fdate($data['date_returned'],'m/d/Y'),

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

    $requestData = $this->request->getData('RequestForm');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->RequestForms->newEmptyEntity();
   
    $data = $this->RequestForms->patchEntity($data, $requestData); 

    if ($this->RequestForms->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Request Form has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Request Form Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Request Form cannot saved this time.',

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

    $data['RequestForm'] = $this->RequestForms->find()
      ->contain([
          'CollegePrograms'=> [
              'conditions' => ['CollegePrograms.visible' => 1],
            ]
        ])

      ->where([

        'RequestForms.visible' => 1,

        'RequestForms.id' => $id

      ])

      ->first();

      $data['RequestForm']['date'] = isset($data['RequestForm']['date']) ? date('m/d/Y', strtotime($data['RequestForm']['date'])) : null;
      $data['CollegeProgram'] = $data['RequestForm']['college_program'];

      unset($data['RequestForm']['college_program']);

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

    $data = $this->RequestForms->get($id); 

    $requestData = $this->getRequest()->getData('RequestForm');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->RequestForms->patchEntity($data, $requestData); 

    if ($this->RequestForms->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' => 'Request Form has been successfully updated.',

        'data'=> $requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Request Form',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Request Form cannot updated this time.',

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

    $data = $this->RequestForms->get($id);

    $data->visible = 0;

    if ($this->RequestForms->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Request Form has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Request Form cannot be deleted at this time.'

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

    $data = $this->RequestForms->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->RequestForms->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Request Form has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Request Form cannot be deleted at this time.'

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

  public function paid($id = null){

    $this->autoRender = false;

    $data = $this->RequestForms->get($id);

    $data->approve = 2;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->RequestForms->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Request Form has been successfully paid'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Request Form cannot be transact at this time.'

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

  public function updateDocument($id = null){

    $data = $this->request->getData();

    $tmp['id'] = $data['id'];

    $tmp['date_retrieved'] = isset($data['date_retrieved']) ? fdate($data['date_retrieved'],'Y-m-d') : null;

    $tmp['date_completed'] = isset($data['date_completed']) ? fdate($data['date_completed'],'Y-m-d') : null;

    $tmp['date_released'] = isset($data['date_released']) ? fdate($data['date_released'],'Y-m-d') : null;

    $tmp['date_returned'] = isset($data['date_returned']) ? fdate($data['date_returned'],'Y-m-d') : null;

    $data = $this->RequestForms->newEmptyEntity();
   
    $data = $this->RequestForms->patchEntity($data, $tmp); 

    if ($this->RequestForms->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Document data has been successfully update'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Document data cannot be deleted at this time.'

      ];

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
