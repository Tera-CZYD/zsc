<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class ConsultationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Consultations = TableRegistry::getTableLocator()->get('Consultations');

    $this->ConsultationSubs = TableRegistry::getTableLocator()->get('ConsultationSubs');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status') != null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND Consultation.status = $status";

      $conditionsPrint .= '&status='.$status;

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');

      $employee_id = $this->Auth->user('studentId');

      if ($employee_id!='') {

        $conditions['studentId'] = "AND Consultation.student_id = $employee_id";

      }

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->Consultations->paginate($this->Consultations->getAllConsultation($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $consultations = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($consultations as $data) {

      $datas[] = array(

        'id'            => $data['id'],

        'code'          => $data['code'],

        'patient_name'  => $data['student_name'] != null ? $data['student_name'] : $data['employee_name'],

        'date'          => fdate($data['date'],'m/d/Y'),

        'age'           => $data['age'],

        'sex'           => $data['sex'],

        'address'       => $data['address'],
        
        'height'        => $data['height'],

        'weight'        => $data['weight'],

        'nurse_name'    => $data['name']

      );

    }

    // var_dump($conditions);

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

    $requestData = $this->request->getData('Consultation');

    $requestData['date'] = !is_null($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->Consultations->newEmptyEntity();
   
    $data = $this->Consultations->patchEntity($data, $requestData); 

    $sub = $this->request->getData('ConsultationSub');

    if ($this->Consultations->save($data)) {

      $id = $data->id;

      if(!empty($sub)){
        
        foreach ($sub as $key => $value) {

          $sub[$key]['consultation_id'] = $id;

          $sub[$key]['date'] = !is_null($value['date']) ? fdate($value['date'],'Y-m-d') : null;
          
        }

        $subEntities = $this->ConsultationSubs->newEntities($sub);

        $this->ConsultationSubs->saveMany($subEntities);
      
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Consultation has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Consultation Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Consultation cannot saved this time.',

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

    $data['Consultation'] = $this->Consultations->find()

      ->contain([

        'ConsultationSubs' => [

          'conditions' => ['ConsultationSubs.visible' => 1]

        ],

      ])

      ->where([

        'Consultations.visible' => 1,

        'Consultations.id' => $id

      ])

    ->first();

    $data['ConsultationSub'] = $data['Consultation']['consultation_subs'];

    unset($data['Consultation']['consultation_subs']);

    $data['Consultation']['date'] = !is_null($data['Consultation']['date']) ? $data['Consultation']['date']->format('m/d/Y') : 'N/A';

    if(!empty($data['ConsultationSub'])){

      foreach ($data['ConsultationSub'] as $key => $value) {
        
        $data['ConsultationSub'][$key]['date'] = !is_null($value['date']) ? $value['date']->format('m/d/Y') : 'N/A';

      }

    }

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

    $data = $this->Consultations->get($id); 

    $requestData = $this->getRequest()->getData('Consultation');

    $requestData['date'] = !is_null($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $this->Consultations->patchEntity($data, $requestData); 

    $sub = $this->request->getData('ConsultationSub');

    if ($this->Consultations->save($data)) {

      $this->ConsultationSubs->updateAll(

        ['visible' => 0],

        ['consultation_id' => $id]
          
      );

      if(!empty($sub)){
        
        foreach ($sub as $key => $value) {

          $sub[$key]['consultation_id'] = $id;

          $sub[$key]['date'] = !is_null($value['date']) ? fdate($value['date'],'Y-m-d') : null;
          
        }

        $subEntities = $this->ConsultationSubs->newEntities($sub);

        $this->ConsultationSubs->saveMany($subEntities);
      
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Consultation has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Consultation Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Consultation cannot updated this time.',

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

    $data = $this->Consultations->get($id);

    $data->visible = 0;

    if ($this->Consultations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Consultation has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Consultation Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Consultation cannot be deleted at this time.'

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

    $user = $this->Auth->user();

    $this->autoRender = false;

    $app = $this->Consultations->get($id);

    $tmpEntity = $this->Consultations->newEntity([

      'id'              => $id,

      'status'          => 3,

      'approve_by_id'   => $user['id'],

    ]);

    if($this->Consultations->save($tmpEntity)){

      $response = array(

        'ok'   => true,

        'data' => $app,       

        'msg'  => 'Patient successfully marked as Approve.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Approve',

        'description' => 'Consultation Management',

        'code' => $app->code,

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

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

    $user = $this->Auth->user();

    $this->autoRender = false;

    $app = $this->Consultations->get($id);

    $tmpEntity = $this->Consultations->newEntity([

      'id'                 => $id,

      'status'             => 4,

      'disapprove_by_id'   => $user['id'],

      'disapproved_reason' => $this->request->getData('explanation')

    ]);

    if($this->Consultations->save($tmpEntity)){

      $response = array(

        'ok'   => true,

        'data' => $app,       

        'msg'  => 'Patient successfully marked as Disapprove.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Disapprove',

        'description' => 'Consultation Management',

        'code' => $app->code,

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  } 

  public function treated($id = null){

    $user = $this->Auth->user();

    $this->autoRender = false;

    $app = $this->Consultations->get($id);

    $tmpEntity = $this->Consultations->newEntity([

      'id'              => $id,

      'status'          => 1,

      'treat_by_id'     => $user['id'],

    ]);

    if($this->Consultations->save($tmpEntity)){

      $response = array(

        'ok'   => true,

        'data' => $app,       

        'msg'  => 'Patient successfully marked as treated.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Treated',

        'description' => 'Consultation Management',

        'code' => $app->code,

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }  

  public function referred($id = null){

    $user = $this->Auth->user();

    $this->autoRender = false;

    $app = $this->Consultations->get($id);

    $tmpEntity = $this->Consultations->newEntity([

      'id'              => $id,

      'status'          => 2,

      'refer_by_id'     => $user['id'],

    ]);

    if($this->Consultations->save($tmpEntity)){

      $response = array(

        'ok'   => true,

        'data' => $app,       

        'msg'  => 'Patient successfully marked as referred.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Referred',

        'description' => 'Consultation Management',

        'code' => $app->code,

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

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
