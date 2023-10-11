<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class PaymentsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->Payments = TableRegistry::getTableLocator()->get('Payments');

    $this->StudentLedgers = TableRegistry::getTableLocator()->get('StudentLedgers');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if($this->request->getQuery('search') != null){
  
      $search = $this->request->getQuery('search');
   
      $search = strtolower($search);
   
      $conditions['search'] = $search;
   
      $conditionsPrint .= '&search='.$search;
   
    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date') != null) {
 
      $search_date = $this->request->getQuery('date');
 
      $conditions['date'] = " AND DATE(Payment.date) = '$search_date'"; 
 
      $conditionsPrint .= '&date='.$search_date;
  
    }  

    //advance search

    if ($this->request->getQuery('startDate')) {
 
      $start = $this->request->getQuery('startDate'); 
 
      $end = $this->request->getQuery('endDate');
 
      $conditions['date'] = " AND DATE(Payment.date) >= '$start' AND DATE(Payment.date) <= '$end'";
 
      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;
 
    }
 
    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student') != null) {

      $per_student = $this->request->getQuery('per_student');
      
      $student_id = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND Payment.student_id = $student_id";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->Payments->paginate($this->Payments->getAllPayment($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $main = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($main as $data) {

      $datas[] = array(

        'id'            => $data['id'],
 
        'code'          => $data['code'],
 
        'student_no'    => $data['student_no'],
 
        'student_name'  => $data['student_name'],
 
        'email'         => $data['email'],

        'type'          => $data['type'],

        'program'       => $data['program'],
 
        'date'          => fdate($data['date'],'m/d/Y'),

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

    $requestData = $this->request->getData('Payment');

    $requestData['date'] = date('Y-m-d');

    $data = $this->Payments->newEmptyEntity();
   
    $data = $this->Payments->patchEntity($data, $requestData); 

    if ($this->Payments->save($data)) {
        
      $ledger = $this->StudentLedgers->newEntity([

        'student_id' => $requestData['student_id'],

        'primary_refno' => $requestData['or_no'],

        'payment' => $requestData['amount'],

        'transaction_date' => $requestData['date'],

        'remarks' => $requestData['type'],

      ]);
      
      $this->StudentLedgers->save($ledger);

      $response = array(

        'ok'  =>true,

        'msg' =>'Payment has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Add',

        'userId' => $this->Auth->user('id'),

        'description' => 'Payment Management',

        'code' => $requestData['code'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Payment cannot saved this time.',

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

    $data['Payment'] = $this->Payments->find()

      ->contain([

        'CollegePrograms'

      ])

      ->where([

        'Payments.visible' => 1,

        'Payments.id' => $id

      ])

    ->first();

    $data['Payment']['date'] = !is_null($data['Payment']['date']) ? $data['Payment']['date']->format('m/d/Y') : 'N/A';

    $data['CollegeProgram'] = $data['Payment']['college_program'];

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

    $data = $this->Payments->get($id); 

    $requestData = $this->getRequest()->getData('Payment');

    $requestData['date'] = date('Y-m-d');

    $this->Payments->patchEntity($data, $requestData); 

    if ($this->Payments->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Payment has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Edit',

        'userId' => $this->Auth->user('id'),

        'description' => 'Payment Management',

        'code' => $requestData['code'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Payment cannot updated this time.',

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

    $data = $this->Payments->get($id);

    $data->visible = 0;

    if ($this->Payments->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Payment has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'userId' => $this->Auth->user('id'),

          'description' => 'Payment Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Payment cannot be deleted at this time.'

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
