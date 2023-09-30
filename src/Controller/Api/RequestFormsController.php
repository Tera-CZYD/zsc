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

    $this->loadModel('RequestedFormPayments');

    $this->loadModel('RequestedFormPaymentSubs');

    $this->loadModel('Students');    

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

    $requestData = $this->request->getData('data');

    $data = json_decode($requestData, true);

    $data['RequestForm']['date'] = isset($data['RequestForm']['date']) ? fdate($data['RequestForm']['date'],'Y-m-d') : null;

    $data['RequestForm']['claim'] = ($data['RequestForm']['claim'] == true) ? 1 : 0; 

    $uploadedFile = $this->request->getData('file');

      if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

      $data['RequestForm']['image'] = $uploadedFile->getClientFilename();

      }


    $requestForm = $this->RequestForms->newEmptyEntity();
   
    $requestForm = $this->RequestForms->patchEntity($requestForm, $data['RequestForm']); 

    if ($this->RequestForms->save($requestForm)) {


      $request_form_id = $requestForm->id;

        if($data['RequestForm']['claim'] == 1){

            if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

              $data['RequestForm']['image'] = $uploadedFile->getClientFilename();

              // Upload user image

              if (!file_exists('uploads')) {

                mkdir('uploads');

              }

              if (!file_exists('uploads/request-form')) {

                mkdir('uploads/affidavit-of-loss');

              }

              $imagePath = "uploads/request-form/$request_form_id";

              if (!file_exists($imagePath)) {

                mkdir($imagePath);

              }

              $uploadedFilePath = $imagePath . '/' . $uploadedFile->getClientFilename();

              $uploadedFile->moveTo($uploadedFilePath);

            }

        }

      $query = $this->RequestedFormPayments->find();

      $query->select(['total' => $query->func()->count('*')]);

      $total = $query->firstOrFail()->total;

      $code = 'RFP-' . str_pad($total + 1, 5, "0", STR_PAD_LEFT);

      $studentId = $data['RequestForm']['student_id']; 

      $student['Student'] = $this->Students->find()

        ->contain([

          'CollegePrograms' => [

            'conditions' => [

              'CollegePrograms.visible' => 1,

            ]

          ]

        ])

        ->where(['Students.id' => $studentId])

      ->first();

      $payment['student_id'] = $studentId;

      $payment['request_form_id'] = $request_form_id;

      $payment['code'] = $code;

      $payment['student_no'] = $data['RequestForm']['student_no']; 

      $payment['student_name'] = $data['RequestForm']['student_name'];

      $payment['email'] = $student['Student']['email'];

      $payment['contact_no'] = $student['Student']['contact_no'];

      $payment['program'] = $student['Student']['college_program']['name'];

      $payment['request'] = "REQUEST FORMS";

      $data_payment = $this->RequestedFormPayments->newEmptyEntity();
     
      $data_payment = $this->RequestedFormPayments->patchEntity($data_payment, $payment);

      if($this->RequestedFormPayments->save($data_payment)){

        $requested_form_payment_id = $data_payment->id;

        $sub = [];


      if($requestForm['otr'] != null && $requestForm['otr'] == true){

        $otrVal = isset($data['RequestForm']['otrVal']) ? $data['RequestForm']['otrVal'] : 1;

        $sub[] = [

          'name' => 'Transcript Of Records',

          'amount' => 120 * $otrVal

        ];

      }

      if($requestForm['cav'] != null && $requestForm['cav'] == true){

        $sub[] = [

          'name' => 'Certification Authentication Verification',

          'amount' => 100

        ];

      }

      if($requestForm['cert'] != null && $requestForm['cert'] == true){

        $sub[] = [

          'name' => 'Certification',

          'amount' => 50

        ];

      }

      if($requestForm['hon'] != null && $requestForm['hon'] == true){

        $sub[] = [

          'name' => 'Honorable Dismissal',

          'amount' => 100

        ];

      }

      if($requestForm['authGrad'] != null && $requestForm['authGrad'] == true){

        $sub[] = [

          'name' => 'Authentication ( Graduate )',

          'amount' => 50

        ];

      }

      if($requestForm['authUGrad'] != null && $requestForm['authUGrad'] == true){

        $sub[] = [

          'name' => 'Authentication ( Under Graduate )',

          'amount' => 50

        ];

      }

      if($requestForm['dip'] != null && $requestForm['dip'] == true){

        $sub[] = [

          'name' => 'Diploma',

          'amount' => 200

        ];

      }

      if($requestForm['rr'] != null && $requestForm['rr'] == true){

        $sub[] = [

          'name' => 'Red Ribbon',

          'amount' => 100

        ];

      }

      if($requestForm['other'] != null && $requestForm['other'] == true){

        $sub[] = [

          'name' => $requestData['otherVal'],

          'amount' => 100

        ];

      }

      if(!empty($sub)){
        
        foreach ($sub as $key => $value) {

          $sub[$key]['requested_form_payment_id'] = $requested_form_payment_id;

          $sub[$key]['name'] = $value['name'];

          $sub[$key]['amount'] = $value['amount'];
          
        }

        $subEntities = $this->RequestedFormPaymentSubs->newEntities($sub);

        $this->RequestedFormPaymentSubs->saveMany($subEntities);
      
      }

      }      

      $response = array(

        'ok'  =>true,

        'msg' =>'Request Form has been successfully saved.',

        'data'=>$data

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Request Form Management',

          'code' => $data['RequestForm']['code'],

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


  public function edit(){

    $id = $this->request->getParam('id'); 

    $requestForm = $this->RequestForms->get($id); 

    // $requestData = $this->getRequest()->getData('RequestForm');

    $requestData = $this->request->getData('data');

    $data = json_decode($requestData, true);

    $data['RequestForm']['date'] = isset($data['RequestForm']['date']) ? fdate($data['RequestForm']['date'],'Y-m-d') : NULL;

    $data['RequestForm']['claim'] = ($data['RequestForm']['claim'] == true) ? 1 : 0; 

    $uploadedFile = $this->request->getData('file');

      if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

      $data['RequestForm']['image'] = $uploadedFile->getClientFilename();

      }

      if($data['RequestForm']['claim'] == 0){

          $data['RequestForm']['image'] = null;

      }    

    $this->RequestForms->patchEntity($requestForm, $data['RequestForm']); 

    if ($this->RequestForms->save($requestForm)) {

        if($data['RequestForm']['claim'] == 1){

            if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

              $data['RequestForm']['image'] = $uploadedFile->getClientFilename();

              // Upload user image

              if (!file_exists('uploads')) {

                mkdir('uploads');

              }

              if (!file_exists('uploads/request-form')) {

                mkdir('uploads/request-form');

              }

              $imagePath = "uploads/affidavit-of-loss/$id";

              if (!file_exists($imagePath)) {

                mkdir($imagePath);

              }

              $uploadedFilePath = $imagePath . '/' . $uploadedFile->getClientFilename();

              $uploadedFile->moveTo($uploadedFilePath);

            }

        }      

      $response = array(

        'ok'  =>true,

        'msg' => 'Request Form has been successfully updated.',

        'data'=> $data['RequestForm']

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Request Form',

          'code' => $data['RequestForm']['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$data['RequestForm'],

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
