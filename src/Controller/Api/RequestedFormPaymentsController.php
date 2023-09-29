<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class RequestedFormPaymentsController extends AppController {

  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->loadComponent('Global');

    $this->RequestedFormPayments = TableRegistry::getTableLocator()->get('RequestedFormPayments');

    $this->RequestedFormPaymentSubs = TableRegistry::getTableLocator()->get('RequestedFormPaymentSubs');

    // $this->StudentApplicationImages = TableRegistry::getTableLocator()->get('StudentApplicationImages');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

  }

  public function index() {

    // default page 1

    $page = $this->request->getQuery('page', 1);

    // default conditions 

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

      $conditions['date'] = " AND DATE(RequestedFormPayment.created) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(RequestedFormPayment.created) >= '$start' AND DATE(RequestedFormPayment.created) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status') != null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND RequestedFormPayment.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }
 
    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student') != null) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND RequestedFormPayment.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->RequestedFormPayments->paginate($this->RequestedFormPayments->getAllRequestedFormPayment($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $requested_form_payments = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

      foreach ($requested_form_payments as $data) {

        $datas[] = array(

          'id'                => $data['id'],

          'code'              => $data['code'],

          'student_no'        => $data['student_no'],

          'student_name'      => $data['student_name'],

          'email'             => $data['email'],

          'contact_no'        => $data['contact_no'],

          'program'           => $data['program'],

          'request'           => $data['request'],

          // 'approve'           => $data['approve'],


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


  public function view($id = null) {

    $data['RequestedFormPayment'] = $this->RequestedFormPayments->find()

      ->contain([

        'RequestedFormPaymentSubs',

        'AffidavitOfLosses' => [
          'conditions' => ['AffidavitOfLosses.visible' => 1]
        ]

      ])

      ->where([

        'RequestedFormPayments.visible' => 1,

        'RequestedFormPayments.id' => $id

      ])

      ->first();

      $data = [

        'RequestedFormPayment' => $data['RequestedFormPayment'],

        'RequestedFormPaymentSub' => $data['RequestedFormPayment']->requested_form_payment_subs,

        'AffidavitOfLoss' =>$data['RequestedFormPayment']->affidavit_of_loss

      ];

      unset($data['RequestedFormPayment']->requested_form_payment_subs);

      unset($data['RequestedFormPayment']->affidavit_of_loss);

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


  public function delete($id){

    $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->RequestedFormPayments->get($id);

    $sub = $this->RequestedFormPaymentSubs->find()

      ->where([

          'requested_form_payment_id' => $id

      ])

      ->all();

    $data->visible = 0;

    if ($this->RequestedFormPayments->save($data)) {

      foreach ($sub as $entity) {

          $entity->visible = 0;

          $this->RequestedFormPaymentSubs->save($entity);

      }

      $response = [

        'ok' => true,

        'msg' => 'Requested Form Payment has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Requested Form Payment Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Requested Form Payment cannot be deleted at this time.'

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

    $data = $this->RequestedFormPayments->get($id);

    $remarks = $this->request->getQuery('remarks');

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    $data->remarks = $remarks;

    if ($this->RequestedFormPayments->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Requested Form Payment has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Requested Form Payment cannot be deleted at this time.'

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