<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class InterviewRequestsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->InterviewRequests = TableRegistry::getTableLocator()->get('InterviewRequests');

    $this->Student = TableRegistry::getTableLocator()->get('Students');

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

    }

     $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(InterviewRequest.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }
    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(InterviewRequest.date) >= '$start' AND DATE(InterviewRequest.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }


    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND InterviewRequest.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND InterviewRequest.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $dataTable = TableRegistry::getTableLocator()->get('InterviewRequests');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllInterviewRequest($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $interviewRequests = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($interviewRequests as $data) {

      $datas[] = array(
      
        'id'            => $data['id'],

        'code'          => $data['code'],

        'student_name'  => $data['student_name'],

        'course'        => $data['name'],

        'year_level_term'        => $data['description'],

        'date'          => fdate($data['date'],'m/d/Y'),

        'status'        => $data['approve'],

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

    $requestData = $this->request->getData('InterviewRequest');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'], 'Y-m-d') : null;

    $data = $this->InterviewRequests->newEmptyEntity();

    $data = $this->InterviewRequests->patchEntity($data, $requestData);

    if ($this->InterviewRequests->save($data)) {

        $response = [

          'ok' => true,

          'msg' => 'Interview Request has been successfully saved.',

          'data' => $requestData

        ];

        $userLogTable = $this->getTableLocator()->get('UserLogs');

        $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Interview Request',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'data' => $requestData,

        'msg' => 'Interview Request cannot be saved at this time.'

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

  public function view($id = null){

    $data['InterviewRequest'] = $this->InterviewRequests->find()
    
    ->contain([
      
        'Students',
        
        'CollegePrograms',

        'YearLevelTerms'
        
    ])
    
    ->where([
      
        'InterviewRequests.visible' => 1,
        
        'InterviewRequests.id' => $id
        
    ])
    
    ->first();

    $data['InterviewRequest']['date'] = isset($data['InterviewRequest']['date']) ? date('m/d/Y', strtotime($data['InterviewRequest']['date'])) : null;

    $data['Student'] = $data['InterviewRequest']['student'];

    $data['CollegeProgram'] = $data['InterviewRequest']['college_program'];

    $data['InterviewRequest']['year'] = $data['InterviewRequest']['year_level_term']['description'];

    unset($data['InterviewRequest']['student']);

    unset($data['InterviewRequest']['college_program']);

    unset($data['InterviewRequest']['year_level_term']);

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

    $data = $this->InterviewRequests->get($id); 

    $requestData = $this->getRequest()->getData('InterviewRequest');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->InterviewRequests->patchEntity($data, $requestData); 

    if ($this->InterviewRequests->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Interview Request has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Interview Request',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Interview Request cannot updated this time.',

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

    $data = $this->InterviewRequests->get($id);

    $data->visible = 0;

    if ($this->InterviewRequests->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Interview Request has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Interview Request',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Interview Request cannot be deleted at this time.'

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

    $data = $this->InterviewRequests->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if($this->InterviewRequests->save($data)){

      //EMAIL VERIFICATION

        $student = $this->Student->get($data['student_id']);

        $name = $student['first_name'].' '.substr($student['middle_name'],0,1).'. '.$student['last_name'];

        $email = $student['email'];

        // if(isset($email)){

        //   if(!empty($email)){

        //     if($email != ''){

        //       $Email = new CakeEmail();

        //       $Email->emailFormat('html');

        //       $Email->template('scholarship-application-approve', 'mytemplate');

        //       $_SESSION['name'] = @$name; 

        //       $_SESSION['code'] = @$app['ScholarshipApplication']['code']; 

        //       $_SESSION['student_no'] = @$app['ScholarshipApplication']['student_no']; 

        //       $_SESSION['type'] = @$app['ScholarshipApplication']['scholarship_type']; 

        //       $_SESSION['id'] = $id; 

        //       $Email->to($email, $name);

        //       $Email->subject('Scholarship Application Status');

        //       $Email->from(array($this->Global->Settings('email') => 'ESMIS'));

        //       $Email->send();

        //     }

        //   }

        // }

      //EMAIL VERIFICATION

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Interview Request has been successfully approved.'

      );


      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Interview Request',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);

      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Interview Request cannot be approved this time.'

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

  public function disapprove($id = null){

    $this->autoRender = false;

    $data = $this->InterviewRequests->get($id);

     $data->approve = 2;

    $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->InterviewRequests->save($data)){

      //EMAIL VERIFICATION

        $student = $this->Student->get($data['student_id']);

        $name = $student['first_name'].' '.substr($student['middle_name'],0,1).'. '.$student['last_name'];

        $email = $student['email'];

        // if(isset($email)){

        //   if(!empty($email)){

        //     if($email != ''){

        //       $Email = new CakeEmail();

        //       $Email->emailFormat('html');

        //       $Email->template('scholarship-application-disapprove', 'mytemplate');

        //       $_SESSION['name'] = @$name; 

        //       $_SESSION['code'] = @$app['ScholarshipApplication']['code']; 

        //       $_SESSION['student_no'] = @$app['ScholarshipApplication']['student_no']; 

        //       $_SESSION['type'] = @$app['ScholarshipApplication']['scholarship_type']; 

        //       $_SESSION['disapproved_reason'] = $data['disapproved_reason']; 

        //       $_SESSION['id'] = $id; 

        //       $Email->to($email, $name);

        //       $Email->subject('Scholarship Application Status');

        //       $Email->from(array($this->Global->Settings('email') => 'ESMIS'));

        //       $Email->send();

        //     }

        //   }

        // }

      //EMAIL VERIFICATION

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Interview Request has been successfully disapproved.'

      );


      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Interview Request',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Interview Request cannot be disapproved this time.'

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
