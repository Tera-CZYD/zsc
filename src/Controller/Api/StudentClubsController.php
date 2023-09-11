<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class StudentClubsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->StudentClubs = TableRegistry::getTableLocator()->get('StudentClubs');

  }
  
  public function index(){

    // default page 1

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1; 
    
    // default conditions

    $conditionsPrint = '';

    $conditions = array();

    $conditions['search'] = '';

    // search conditions

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentClub.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    } 

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentClub.date) >= '$start' AND DATE(StudentClub.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND StudentClub.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND StudentClub.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $dataTable = TableRegistry::getTableLocator()->get('StudentClubs');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllStudentClub($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $student_clubs = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($student_clubs as $student_clubs) {

      $datas[] = array(

        'id'            => $student_clubs['id'],
  
        'code'          => $student_clubs['code'],

        'student_name'  => $student_clubs['student_name'],

        'date'          => fdate($student_clubs['date'],'m/d/Y'),

        'club_title'        => $student_clubs['title'],

        'position'        => $student_clubs['position'],

        'status'        => $student_clubs['approve'],

      );

    }

    $response = [

      'ok' => true,

      'data' => $datas,

      'paginator' => $paginator,

      'conditionsPrint' => $conditionsPrint,

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }  
 
  public function view($id = null){

    $data['StudentClub'] = $this->StudentClubs->find()

      ->contain([

        'Students',

        'Clubs'

      ])

      ->where([

        'StudentClubs.visible' => 1,

        'StudentClubs.id' => $id

      ])

      ->first();

      $data = [

        'StudentClub' => $data['StudentClub'],

        'Student' => $data['StudentClub']->student,

        'Club' => $data['StudentClub']->club,

      ];

      unset($data['StudentClub']->student);

      unset($data['StudentClub']->club);

      $data['StudentClub']['date'] = isset($data['StudentClub']['date']) ? date('m/d/Y', strtotime($data['StudentClub']['date'])) : null;

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

  public function add(){

    $this->autoRender = false;

    $requestData = $this->request->getData('StudentClub');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'], 'Y-m-d') : null;

    $data = $this->StudentClubs->newEmptyEntity();

    $data = $this->StudentClubs->patchEntity($data, $requestData);

    if ($this->StudentClubs->save($data)) {

        $response = [

          'ok' => true,

          'msg' => 'Club has been successfully saved.',

          'data' => $requestData

        ];

        $userLogTable = $this->getTableLocator()->get('UserLogs');

        $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Club Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'data' => $requestData,

        'msg' => 'Club cannot be saved at this time.'

      ];

    }

    $this->set([

        'response' => $response,

        '_serialize' => 'response'

    ]);

    $this->response = $this->response->withType('application/json');

    $this->response = $this->response->withStringBody(json_encode($response));

    return $this->response;

	} 

  public function edit($id = null){

    
    $data = $this->StudentClubs->get($id); 

    $requestData = $this->getRequest()->getData('StudentClub');

    $requestData['date'] = isset($requestData['date']) ? date('Y-m-d', strtotime($requestData['date'])) : null;

    $this->StudentClubs->patchEntity($data, $requestData); 

    if ($this->StudentClubs->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Club has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Student Club Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Club cannot updated this time.',

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

  public function delete($id = null){

	  $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->StudentClubs->get($id);

    $data->visible = 0;

    if ($this->StudentClubs->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Club has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Club cannot be deleted at this time.'

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

    $data = $this->StudentClubs->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->StudentClubs->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Club has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Student Club',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Club cannot be deleted at this time.'

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

    $data = $this->StudentClubs->get($id);

     $data->approve = 2;

    $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->StudentClubs->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Student Club has been successfully disapproved.'

      );
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Student Club',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Student Club cannot be disapproved this time.'

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