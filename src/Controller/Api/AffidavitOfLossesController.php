<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class AffidavitOfLossesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->AffidavitOfLosses = TableRegistry::getTableLocator()->get('AffidavitOfLosses');

    $this->loadModel('RequestedFormPayments');

    $this->loadModel('Students');

  }
  
  public function index(){

    // default page 1

    $page = ($this->request->getQuery('page'))? $this->request->getQuery('page') : 1; 
    
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

      $conditions['date'] = " AND DATE(AffidavitOfLoss.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    } 

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(AffidavitOfLoss.date) >= '$start' AND DATE(AffidavitOfLoss.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND AffidavitOfLoss.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND AffidavitOfLoss.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->AffidavitOfLosses->paginate($this->AffidavitOfLosses->getAllAffidavitOfLoss($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $affidavit_of_losses = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($affidavit_of_losses as $data) {

      $datas[] = array(

        'id'            => $data['id'],
  
        'code'          => $data['code'],

        'student_name'  => $data['student_name'],

        'date'  => date('m/d/Y',strtotime($data['date'])),

        'form'  => $data['form'],


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

    $data['AffidavitOfLoss'] = $this->AffidavitOfLosses->find()

      ->contain([

        'Students',

        'CollegePrograms' => [

          'conditions' => [

            'CollegePrograms.visible' => 1

          ]

        ]

      ])

      ->where([

        'AffidavitOfLosses.visible' => 1,

        'AffidavitOfLosses.id' => $id

      ])

      ->first();

      $data = [

        'AffidavitOfLoss' => $data['AffidavitOfLoss'],

        'Student' => $data['AffidavitOfLoss']->student,

        'CollegeProgram' => $data['AffidavitOfLoss']->college_program

      ];

      unset($data['AffidavitOfLoss']->student);

      unset($data['AffidavitOfLoss']->college_program);

      $data['AffidavitOfLoss']['date'] = isset($data['AffidavitOfLoss']['date']) ? date('m/d/Y', strtotime($data['AffidavitOfLoss']['date'])) : null;

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

   $requestData = $this->request->getData('data');

    $data = json_decode($requestData, true);

    $data['AffidavitOfLoss']['claim'] = ($data['AffidavitOfLoss']['claim'] == true) ? 1 : 0;  

    $data['AffidavitOfLoss']['date'] = isset($data['AffidavitOfLoss']['date']) ? date('Y-m-d', strtotime($data['AffidavitOfLoss']['date'])) : null;

    $uploadedFile = $this->request->getData('file');

      if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

      $data['AffidavitOfLoss']['image'] = $uploadedFile->getClientFilename();

      }
 
    $affidavit = $this->AffidavitOfLosses->newEmptyEntity();
   
    $affidavit = $this->AffidavitOfLosses->patchEntity($affidavit, $data['AffidavitOfLoss']); 

        if ($this->AffidavitOfLosses->save($affidavit)) {

          $id = $affidavit->id;

        if($data['AffidavitOfLoss']['claim'] == 1){

            if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

              $data['AffidavitOfLoss']['image'] = $uploadedFile->getClientFilename();

              // Upload user image

              if (!file_exists('uploads')) {

                mkdir('uploads');

              }

              if (!file_exists('uploads/affidavit-of-loss')) {

                mkdir('uploads/affidavit-of-loss');

              }

              $imagePath = "uploads/affidavit-of-loss/$id";

              if (!file_exists($imagePath)) {

                mkdir($imagePath);

              }

              $uploadedFilePath = $imagePath . '/' . $uploadedFile->getClientFilename();

              $uploadedFile->moveTo($uploadedFilePath);

            }

        }



        $response = [

          'ok' => true,

          'msg' => 'Affidavit Of Loss has been successfully saved.',

          'data' => $data

        ];

        $userLogTable = $this->getTableLocator()->get('UserLogs');

        $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Affidavit Of Loss Management',

          'code' => $affidavit['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'data' => $affidavit,

        'msg' => 'Affidavit Of Loss cannot be saved at this time.'

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

  // public function edit(){

  //   $id = $this->request->getParam('id');

  //   $affidavit = $this->AffidavitOfLosses->get($id); 

  //   // $requestData = $this->getRequest()->getData('Affidavit');

  //   $requestData = $this->request->getData('data');

  //   $data = json_decode($requestData, true);

  //   $data['AffidavitOfLoss']['claim'] = ($data['AffidavitOfLoss']['claim'] == true) ? 1 : 0;  

  //   $data['AffidavitOfLoss']['date'] = isset($data['AffidavitOfLoss']['date']) ? date('Y-m-d', strtotime($data['AffidavitOfLoss']['date'])) : null;

  //   $uploadedFile = $this->request->getData('file');

  //     if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

  //     $data['AffidavitOfLoss']['image'] = $uploadedFile->getClientFilename();

  //     }

  //   if($data['AffidavitOfLoss']['claim'] == 0){

  //       $data['AffidavitOfLoss']['image'] = null;

  //   }


  //   $this->AffidavitOfLosses->patchEntity($affidavit, $data['AffidavitOfLoss']); 

  //   if ($this->AffidavitOfLosses->save($affidavit)) {

  //       if($data['AffidavitOfLoss']['claim'] == 1){

  //           if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

  //             $data['AffidavitOfLoss']['image'] = $uploadedFile->getClientFilename();

  //             // Upload user image

  //             if (!file_exists('uploads')) {

  //               mkdir('uploads');

  //             }

  //             if (!file_exists('uploads/affidavit-of-loss')) {

  //               mkdir('uploads/affidavit-of-loss');

  //             }

  //             $imagePath = "uploads/affidavit-of-loss/$id";

  //             if (!file_exists($imagePath)) {

  //               mkdir($imagePath);

  //             }

  //             $uploadedFilePath = $imagePath . '/' . $uploadedFile->getClientFilename();

  //             $uploadedFile->moveTo($uploadedFilePath);

  //           }

  //       }

  //     $response = array(

  //       'ok'  =>true,

  //       'msg' =>'Affidavit Of Loss has been successfully updated.',

  //       'data'=>$data

  //     );
        
  //     $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
  //     $userLogEntity = $userLogTable->newEntity([

  //         'action' => 'Edit',

  //         'description' => 'Affidavit Of Loss Management',

  //         'code' => $data['AffidavitOfLoss']['code'],

  //         'created' => date('Y-m-d H:i:s'),

  //         'modified' => date('Y-m-d H:i:s')

  //     ]);
      
  //     $userLogTable->save($userLogEntity);

  //   }else {

  //     $response = array(

  //       'ok'  =>true,

  //       'data'=>$data,

  //       'msg' =>'Afffidavit Of Loss cannot updated this time.',

  //     );

  //   }

  //   $this->set(array(

  //     'response'=>$response,

  //     '_serialize'=>'response'

  //   ));

  //   $this->response->withType('application/json');

  //   $this->response->getBody()->write(json_encode($response));

  //   return $this->response;


  // }

  public function delete($id = null){

	  $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->AffidavitOfLosses->get($id);

    $data->visible = 0;

    if ($this->AffidavitOfLosses->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Affidavit Of Loss has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Affidavit Of Loss cannot be deleted at this time.'

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

    $data = $this->AffidavitOfLosses->get($id);

    $data->approve = 1;

    $data->approved_by_id = $this->currentUser->id;


    if ($this->AffidavitOfLosses->save($data)) {

      $affidavit_of_loss_id = $data->id;

      $query = $this->RequestedFormPayments->find();

      $query->select(['total' => $query->func()->count('*')]);

      $total = $query->firstOrFail()->total;

      $code = 'RFP-' . str_pad($total + 1, 5, "0", STR_PAD_LEFT);

      $studentId = $data->student_id; 

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

      $payment['affidavit_of_loss_id'] = $affidavit_of_loss_id;

      $payment['code'] = $code;

      $payment['student_no'] = $data['student_no']; 

      $payment['student_name'] = $data['student_name'];

      $payment['email'] = $student['Student']['email'];

      $payment['contact_no'] = $student['Student']['contact_no'];

      $payment['program'] = $student['Student']['college_program']['name'];

      $payment['request'] = "AFFIDAVIT OF LOSS";

      $data_payment = $this->RequestedFormPayments->newEmptyEntity();
     
      $data_payment = $this->RequestedFormPayments->patchEntity($data_payment, $payment);

      $this->RequestedFormPayments->save($data_payment);

      $response = [

        'ok' => true,

        'msg' => 'Affidavit Of Loss has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Affidavvit Of Loss',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Affidavit Of Loss cannot be deleted at this time.'

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

    $data = $this->AffidavitOfLosses->get($id);

     $data->approve = 2;

    $data->disapproved_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->AffidavitOfLosses->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Affidavit Of Loss has been successfully disapproved.'

      );
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Affidavit Of Loss',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Affidavit Of Loss cannot be disapproved this time.'

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