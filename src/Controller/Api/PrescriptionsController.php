<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class PrescriptionsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Prescriptions = TableRegistry::getTableLocator()->get('Prescriptions');

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

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Prescription.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Prescription.date) >= '$start' AND DATE(Prescription.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      // $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $dataTable = TableRegistry::getTableLocator()->get('Prescriptions');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllPrescription($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $prescriptions = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($prescriptions as $prescription) {

      $datas[] = array(

        'id'           => $prescription['id'],

        'name'         => $prescription['name'],

        'date'         => fdate($prescription['date'],'m/d/Y'),


      );

    }

    $response = [

      'ok' => true,

      'data' => $datas,

      'paginator' => $paginator,

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function add(){

    $this->autoRender = false;

    $requestData = $this->request->getData('Prescription');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->Prescriptions->newEmptyEntity();
   
    $data = $this->Prescriptions->patchEntity($data, $requestData); 

    if ($this->Prescriptions->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Prescriptions has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Prescriptions',

          'name' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Prescriptions cannot saved this time.',

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

    $data['Prescription'] = $this->Prescriptions->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

    $data['Prescription']['date'] = $data['Prescription']['date']->format('m/d/Y');

    $data['Prescription']['active_view'] = $data['Prescription']['active'] ? 'True' : 'False';

    $data['Prescription']['floors'] = intval($data['Prescription']['floors']);

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

    $building = $this->Prescriptions->get($id); 

    $requestData = $this->getRequest()->getData('Prescription');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->Prescriptions->patchEntity($building, $requestData); 

    if ($this->Prescriptions->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Prescriptions has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Prescriptions',

          'name' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Prescriptions cannot updated this time.',

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

    $data = $this->Prescriptions->get($id);

    $data->visible = 0;

    if ($this->Prescriptions->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Prescriptions has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Prescriptions',

          'name' => $data->name,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Prescriptions cannot be deleted at this time.'

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
