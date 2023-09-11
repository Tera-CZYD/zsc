<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class AppointmentSlipsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->AppointmentSlips = TableRegistry::getTableLocator()->get('AppointmentSlips');

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

      $conditions['date'] = " AND DATE(AppointmentSlip.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(AppointmentSlip.date) >= '$start' AND DATE(AppointmentSlip.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Session->read('Auth.User.studentId');

      $conditions['studentId'] = "AND AppointmentSlip.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->AppointmentSlips->paginate($this->AppointmentSlips->getAllAppointmentSlip($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $appointment_slips = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($appointment_slips as $data) {

      $datas[] = array(

  
          'id'            => $data['id'],
  
          'code'          => $data['code'],

          'student_name'  => $data['student_name'],

          'date'          => fdate($data['date'],'m/d/Y'),

          'time'       => fdate($data['time'],'h:i A'),

          'location'    => $data['location'],


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

    $requestData = $this->request->getData('AppointmentSlip');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->AppointmentSlips->newEmptyEntity();
   
    $data = $this->AppointmentSlips->patchEntity($data, $requestData); 

    if ($this->AppointmentSlips->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Appointment Slip has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Appointment Slip Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Appointment Slip cannot saved this time.',

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

    $data = $this->AppointmentSlips->find()
      ->contain([
          'Students'
        ])

      ->where([

        'AppointmentSlips.visible' => 1,

        'AppointmentSlips.id' => $id

      ])

      ->first();

      $AppointmentSlip = $data->toArray();

      unset($AppointmentSlip['Student']);

      $data = [

        'AppointmentSlip' => $AppointmentSlip,

        'Student' => $data['Student'],

      ];

      $data['AppointmentSlip']['date'] = isset($data['AppointmentSlip']['date']) ? date('m/d/Y', strtotime($data['AppointmentSlip']['date'])) : null;
      

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

   $data = $this->AppointmentSlips->get($id); 

    $requestData = $this->getRequest()->getData('AppointmentSlip');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->AppointmentSlips->patchEntity($data, $requestData); 

    if ($this->AppointmentSlips->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Appointment Slip has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'RAppointment Slip',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Appointment Slip cannot updated this time.',

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

    $data = $this->AppointmentSlips->get($id);

    $data->visible = 0;

    if ($this->AppointmentSlips->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Appointment Slip has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Appointment Slip cannot be deleted at this time.'

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
