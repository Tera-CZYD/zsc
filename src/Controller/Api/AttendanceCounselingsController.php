<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class AttendanceCounselingsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->AttendanceCounseling = TableRegistry::getTableLocator()->get('AttendanceCounselings');

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

      $conditions['date'] = " AND DATE(AttendanceCounseling.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(AttendanceCounseling.date) >= '$start' AND DATE(AttendanceCounseling.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND AttendanceCounseling.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Session->read('Auth.User.studentId');

      $conditions['studentId'] = "AND AttendanceCounseling.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->AttendanceCounseling->paginate($this->AttendanceCounseling->getAllAttendanceCounseling($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $AttendanceCounseling = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($AttendanceCounseling as $data) {

      $datas[] = array(
          
          'id'            => $data['id'],

          'code'          => $data['code'],

          'student_name'  => $data['student_name'],

          'type'          => $data['name'],

          'date'          => fdate($data['date'],'m/d/Y'),

          'time'          => fdate($data['time'],'h:i A'),

          'location'      => $data['location'],

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

    $requestData = $this->request->getData('AttendanceCounseling');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->AttendanceCounseling->newEmptyEntity();
   
    $data = $this->AttendanceCounseling->patchEntity($data, $requestData); 

    if ($this->AttendanceCounseling->save($data)) {

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

    $data['AttendanceCounseling'] = $this->AttendanceCounseling->find()
    ->contain([
        'CounselingAppointments' => [
            'Students',
            'CounselingTypes'
        ]
    ])
    ->where([
        'AttendanceCounselings.visible' => 1,
        'AttendanceCounselings.id' => $id
    ])
    ->first();

      $data['AttendanceCounseling']['date'] = isset($data['AttendanceCounseling']['date']) ? date('m/d/Y', strtotime($data['AttendanceCounseling']['date'])) : null;

      $data['CounselingAppointment'] = $data['AttendanceCounseling']['counseling_appointment'];

      $data['CounselingAppointment']['CounselingType'] = $data['CounselingAppointment']['counseling_type'];


      unset($data['AttendanceCounseling']['counseling_appointment']);
      
      unset($data['CounselingAppointment']['counseling_type']);

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

    $data = $this->AttendanceCounseling->get($id); 

    $requestData = $this->getRequest()->getData('AttendanceCounseling');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->AttendanceCounseling->patchEntity($data, $requestData); 

    if ($this->AttendanceCounseling->save($data)) {

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

    $data = $this->AttendanceCounseling->get($id);

    $data->visible = 0;

    if ($this->AttendanceCounseling->save($data)) {

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

    $data = $this->AttendanceCounseling->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->AttendanceCounseling->save($data)) {

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

}
