<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class PropertyLogsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->PropertyLogs = TableRegistry::getTableLocator()->get('PropertyLogs');

    $this->InventoryProperties = TableRegistry::getTableLocator()->get('InventoryProperties');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditionsPrint = '';

    $conditions = [];

    $conditions['search'] = '';

    // search conditions

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(PropertyLog.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    $conditions['type'] = '';

    if ($this->request->getQuery('type')) {

      $type = $this->request->getQuery('type');

      $conditions['type'] = "AND PropertyLog.type = '$type'";

      $conditionsPrint .= '&type='.$type;

    }

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $limit = 25;

    $tmpData = $this->PropertyLogs->paginate($this->PropertyLogs->getAllPropertyLog($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $propertyLogs = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($propertyLogs as $propertyLog) {

      $datas[] = array(

        'id'               => $propertyLog['id'],

        'property_name'    => $propertyLog['property_name'],

        'type'             => $propertyLog['type'],

        'date'             => fdate($propertyLog['date'],'m/d/Y'),

        'manufacturing_date'  => fdate($propertyLog['manufacturing_date'],'m/d/Y'),

        'expiration_date'   => fdate($propertyLog['expiration_date'],'m/d/Y'),

        'batch_no'         => $propertyLog['batch_no']

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

    $requestData = $this->request->getData('PropertyLog');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $requestData['manufacturing_date'] = isset($requestData['manufacturing_date']) ? fdate($requestData['manufacturing_date'],'Y-m-d') : null;

    $requestData['expiration_date'] = isset($requestData['expiration_date']) ? fdate($requestData['expiration_date'],'Y-m-d') : null;

    $data = $this->PropertyLogs->newEmptyEntity();
   
    $data = $this->PropertyLogs->patchEntity($data, $requestData); 

    if ($this->PropertyLogs->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Property Log has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Property Log Management',

          'code' => $requestData['property_name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Property Log cannot saved this time.',

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

    $data['PropertyLog'] = $this->PropertyLogs->find()

      ->contain([

        'InventoryProperties' => [

          'conditions' => ['InventoryProperties.visible' => 1]

        ]

      ])

      ->where([

        'PropertyLogs.visible' => 1,

        'PropertyLogs.id' => $id

      ])

    ->first();

    $data['PropertyLog']['date'] = !is_null($data['PropertyLog']['date']) ? fdate($data['PropertyLog']['date'],'m/d/Y') : 'N/A';

    $data['PropertyLog']['manufacturing_date'] = !is_null($data['PropertyLog']['manufacturing_date']) ? $data['PropertyLog']['manufacturing_date']->format('m/d/Y') : 'N/A';

    $data['PropertyLog']['expiration_date'] = !is_null($data['PropertyLog']['expiration_date']) ? $data['PropertyLog']['expiration_date']->format('m/d/Y') : 'N/A';

    $data['InventoryProperty'] = $data['PropertyLog']['inventory_properties'];

    unset($data['PropertyLog']['inventory_properties']);

    if(!empty($data['InventoryProperty'])){

      foreach ($data['InventoryProperty'] as $key => $value) {
        
        $data['InventoryProperty'][$key]['expiry_date'] = !is_null($value['expiry_date']) ? $value['expiry_date']->format('m/d/Y') : 'N/A';

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

    $data = $this->PropertyLogs->get($id); 

    $requestData = $this->getRequest()->getData('PropertyLog');

    $this->PropertyLogs->patchEntity($data, $requestData);

    if ($this->PropertyLogs->save($data)) {


      $response = array(

        'ok'  =>true,

        'msg' =>'Property Log has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Property Log Management',

          'code' => $requestData['property_name '],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Property Log cannot updated this time.',

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

    $data = $this->PropertyLogs->get($id);

    $data->visible = 0;

    if ($this->PropertyLogs->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Property Log has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Property Log Management',

          'code' => $data->property_name,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Property Log cannot be deleted at this time.'

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

  public function api_manual($id = null){

    $this->autoRender = false;

    $data = $this->request->getData();

    if(!empty($data)){

      $tmpEntity = $this->InventoryProperties->newEntity([

        'id'               => @$data['id'],

        'property_log_id'  => $data['property_log_id'],

        'expiry_date'       => fdate($data['expiry_date'],'Y-m-d'),

        'stocks'      => $data['stocks'],

        'remarks'        => $data['remarks'],

      ]);
      
      $this->InventoryProperties->save($tmpEntity);

    }

    $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
    $userLogEntity = $userLogTable->newEntity([

      'action' => 'Add',

      'description' => 'Inventory Property',

      'code' => $data['property_log_id'],

      'created' => date('Y-m-d H:i:s'),

      'modified' => date('Y-m-d H:i:s')

    ]);
    
    $userLogTable->save($userLogEntity);

    $response = array(

      'ok'   => true,

      'msg'  => 'Inventory Property has been successfully saved.',

      'data' => $data,

    );

    $this->set(array(

      'response'=>$response, 

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function api_manual_delete($id = null){

    $this->autoRender = false;

    $data = $this->request->getData();

    if(!empty($data)){

      $tmpEntity = $this->InventoryProperties->newEntity([

        'id'       => @$data['id'],

        'visible'  => 0

      ]);
      
      $this->InventoryProperties->save($tmpEntity);

      $response = [

        'ok' => true,

        'msg' => 'Inventory Property has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Delete',

        'description' => 'Inventory Property',

        'code' => $data['property_log_id'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Inventory Property cannot be deleted at this time.'

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
