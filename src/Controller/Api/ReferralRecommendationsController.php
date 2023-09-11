<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class ReferralRecommendationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->ReferralRecommendations = TableRegistry::getTableLocator()->get('ReferralRecommendations');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditions['search'] = '';

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

      $conditions['date'] = " AND DATE(ReferralRecommendation.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(ReferralRecommendation.date) >= '$start' AND DATE(ReferralRecommendation.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND ReferralRecommendation.status = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');

      $employee_id = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND ReferralRecommendation.student_id = $employee_id";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $dataTable = TableRegistry::getTableLocator()->get('ReferralRecommendations');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllReferralRecommendation($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    // var_dump($conditions);

    $referralRecommendations = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($referralRecommendations as $referralRecommendation) {

      $datas[] = array(
      
        'id'                => $referralRecommendation['id'],

        'code'              => $referralRecommendation['code'],

        'patient_name'      => $referralRecommendation['student_name'] != null ? $referralRecommendation['student_name'] : $referralRecommendation['employee_name'],

        'date'              => fdate($referralRecommendation['date'],'m/d/Y'),

        'complaints'        => $referralRecommendation['complaints'],

        'recommendations'   => $referralRecommendation['recommendations'],

        'nurse_name'        => $referralRecommendation['name'],

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

    $requestData = $this->request->getData('ReferralRecommendation');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->ReferralRecommendations->newEmptyEntity();
   
    $data = $this->ReferralRecommendations->patchEntity($data, $requestData); 

    if ($this->ReferralRecommendations->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Referral Recommendation has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Referral Recommendation',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Referral Recommendation cannot saved this time.',

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

    $data['ReferralRecommendation'] = $this->ReferralRecommendations->find()

      ->where([

        'ReferralRecommendations.visible' => 1,

        'ReferralRecommendations.id' => $id

      ])

      ->contain([

        'NurseProfiles'

      ])

      ->first();


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

    $building = $this->ReferralRecommendations->get($id); 

    $requestData = $this->getRequest()->getData('ReferralRecommendation');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->ReferralRecommendations->patchEntity($building, $requestData); 

    if ($this->ReferralRecommendations->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Referral Recommendation has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Referral Recommendation',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Referral Recommendation cannot updated this time.',

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

    $data = $this->ReferralRecommendations->get($id);

    $data->visible = 0;

    if ($this->ReferralRecommendations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Referral Recommendation has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Referral Recommendation',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Referral Recommendation cannot be deleted at this time.'

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

    $data = $this->ReferralRecommendations->get($id);

    $data->status = 3;

    if ($this->ReferralRecommendations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Referral Recommendation has been successfully approved'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Referral Recommendation',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Referral Recommendation cannot be approved at this time.'

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

    $data = $this->ReferralRecommendations->get($id);

     $data->status = 4;

    // $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->ReferralRecommendations->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Referral Recommendation has been successfully disapproved.'

      );
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Referral Recommendation',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Referral Recommendation cannot be disapproved this time.'

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
