<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class ItemIssuancesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->ItemIssuances = TableRegistry::getTableLocator()->get('ItemIssuances');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

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

      $conditions['date'] = " AND DATE(ItemIssuance.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(ItemIssuance.date) >= '$start' AND DATE(ItemIssuance.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    //advance search

    if (isset($this->request->query['startDate'])) {

      $start = $this->request->query['startDate']; 

      $end = $this->request->query['endDate'];

      $conditions['date'] = " AND DATE(ItemIssuance.date) >= '$start' AND DATE(ItemIssuance.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND ItemIssuance.status = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $dataTable = TableRegistry::getTableLocator()->get('ItemIssuances');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllItemIssuance($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $item_issuances = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($item_issuances as $item_issuance) {

      $datas[] = array(

        'id'        => $item_issuance['id'],

        'code'      => $item_issuance['code'],

        'type'      => $item_issuance['dental'] != null ? $item_issuance['dental'] : $item_issuance['consultation'],

        'date'      => fdate($item_issuance['date'],'m/d/Y'),

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

    $requestData = $this->request->getData('ItemIssuance');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->ItemIssuances->newEmptyEntity();
   
    $data = $this->ItemIssuances->patchEntity($data, $requestData); 

    if ($this->ItemIssuances->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Item Issuance has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Item Issuance',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Item Issuance cannot saved this time.',

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

    $data['ItemIssuance'] = $this->ItemIssuances->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

    $data['ItemIssuance']['active_view'] = $data['ItemIssuance']['active'] ? 'True' : 'False';

    $data['ItemIssuance']['date'] = $data['ItemIssuance']['date']->format('m/d/Y');

    $data['ItemIssuance']['floors'] = intval($data['ItemIssuance']['floors']);

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

    $building = $this->ItemIssuances->get($id); 

    $requestData = $this->getRequest()->getData('ItemIssuance');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->ItemIssuances->patchEntity($building, $requestData); 

    if ($this->ItemIssuances->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Item Issuance has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Item Issuance',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Item Issuance cannot updated this time.',

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

    $data = $this->ItemIssuances->get($id);

    $data->visible = 0;

    if ($this->ItemIssuances->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Item Issuance has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Item Issuance',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Item Issuance cannot be deleted at this time.'

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
