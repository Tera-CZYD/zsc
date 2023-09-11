<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class CounselingAppointmentsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->CounselingAppointment = TableRegistry::getTableLocator()->get('CounselingAppointments');

    $this->UserLog = TableRegistry::getTableLocator()->get('UserLogs');

    $this->Student = TableRegistry::getTableLocator()->get('Students');

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

      $conditions['date'] = " AND DATE(CounselingAppointment.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(CounselingAppointment.date) >= '$start' AND DATE(CounselingAppointment.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';
    // var_dump($this->request->getQuery('status'));
    if ($this->request->getQuery('status')!=null) {

      // var_dump($this->request->getQuery('status'));

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND CounselingAppointment.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');

      $employee_id = $this->Auth->user('studentId');

      if ($employee_id!='') {

        $conditions['studentId'] = "AND CounselingAppointment.student_id = $employee_id";

      }

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->CounselingAppointment->paginate($this->CounselingAppointment->getAllCounselingAppointment($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $counselingAppointment = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($counselingAppointment as $data) {

      $datas[] = array(
          
         'id'            => $data['id'],

         'code'          => $data['code'],

         'student_name'  => $data['student_name'],

         'type'          => $data['name'],

         'date'          => fdate($data['date'],'m/d/Y'),

         'time'          => fdate($data['time'],'h:i A'),

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

    $requestData = $this->request->getData('CounselingAppointment');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->CounselingAppointment->newEmptyEntity();
   
    $data = $this->CounselingAppointment->patchEntity($data, $requestData); 

    if ($this->CounselingAppointment->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Attendance to Counseling has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Attendance to Counseling Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Attendance to Counseling cannot saved this time.',

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



    $data['CounselingAppointment'] = $this->CounselingAppointment->find()

    ->contain([

        'CounselingTypes' => [

            'conditions' => ['CounselingTypes.visible' => 1]

        ],

        'Students'

    ])
    ->where([

        'CounselingAppointments.visible' => 1,

        'CounselingAppointments.id' => $id

    ])

    ->first();

      $data['CounselingAppointment']['date'] = isset($data['CounselingAppointment']['date']) ? date('m/d/Y', strtotime($data['CounselingAppointment']['date'])) : null;

      $data['CounselingType'] = $data['CounselingAppointment']['counseling_type'];

      $data['Student'] = $data['CounselingAppointment']['student'];

      unset($data['CounselingAppointment']['counseling_type']);

      unset($data['CounselingAppointment']['student']);

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

    $data = $this->CounselingAppointment->get($id); 

    $requestData = $this->getRequest()->getData('CounselingAppointment');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->CounselingAppointment->patchEntity($data, $requestData); 

    if ($this->CounselingAppointment->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' => 'Attendance to Counseling has been successfully updated.',

        'data'=> $requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Attendance to Counseling',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Attendance to Counseling cannot updated this time.',

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

    $data = $this->CounselingAppointment->get($id);

    $data->visible = 0;

    if ($this->CounselingAppointment->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Attendance to Counseling has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Attendance to Counseling cannot be deleted at this time.'

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

    $data = $this->CounselingAppointment->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->CounselingAppointment->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Attendance to Counseling has been successfully approved'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Attendance to Counseling',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Attendance to Counseling cannot be approved at this time.'

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

  public function confirm($id = null){

    $this->autoRender = false;

    $data = $this->CounselingAppointment->get($id);
    
    $data->approve = 4;

    $data->approve_by_id = $this->currentUser->id;

    if($this->CounselingAppointment->save($data)){

      //EMAIL VERIFICATION

       $student = $this->Student->get($data['student_id']);

        // var_dump($student);

        if(isset($student)){

          $name = @$student['first_name'].' '.@$student['middle_name'].' '.@$student['last_name'];

          $email = @$student['email'];

          // if(isset($email)){

          //   if(!empty($email)){

          //     $Email = new CakeEmail();

          //     $Email->emailFormat('html');

          //     $Email->template('counseling-appointment-confirm', 'mytemplate');

          //     $_SESSION['name'] = @$name; 

          //     $_SESSION['code'] = @$data['code']; 

          //     $_SESSION['student_no'] = @$student['student_no']; 

          //     $_SESSION['counselor_name'] = $data['counselor_name']; 

          //     $_SESSION['date'] = fdate($data['date'],'m/d/Y'); 

          //     $_SESSION['time'] = fdate($data['time'],'h:i A');

          //     $_SESSION['id'] = $id; 

          //     $Email->to($email, $name);

          //     $Email->subject('Counseling Appointment');

          //     $Email->from(array($this->Global->Settings('email') => 'ESMIS'));

          //     $Email->send();

          //   }

          // }

        }

      //EMAIL VERIFICATION

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Counseling Appointment has been successfully confirmed.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Confirm',

          'description' => 'Attendance to Counseling',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Counseling Appointment cannot be confirmed this time.'

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

    $data = $this->CounselingAppointment->get($id);

     $data->approve = 2;

    $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->CounselingAppointment->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Counseling Appointment has been successfully disapproved.'

      );
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Attendance to Counseling',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Counseling Appointment cannot be disapproved this time.'

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

  public function cancel($id = null){

    $this->autoRender = false;

    $data = $this->CounselingAppointment->get($id);

    $data->approve = 3;

    $data->cancelled_by_id = $this->currentUser->id;
    // $requestData = $this->getRequest()->getData('explanation');
    $data->cancelled_reason = $this->getRequest()->getData('explanation');

    if($this->CounselingAppointment->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Counseling Appointment has been successfully cancelled.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Cancel',

          'description' => 'Attendance to Counseling',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Counseling Appointment cannot be cancelled this time.'

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
