<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class CheckOutsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->CheckOuts = TableRegistry::getTableLocator()->get('CheckOuts');

    $this->CheckOutSubs = TableRegistry::getTableLocator()->get('CheckOutSubs');

    $this->InventoryBibliographies = TableRegistry::getTableLocator()->get('InventoryBibliographies');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditionsPrint = '';

    $conditions = [];

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(CheckOut.date_borrowed) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(CheckOut.date_borrowed) >= '$start' AND DATE(CheckOut.date_borrowed) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $dataTable = $this->CheckOuts;

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllCheckOut($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $checkOuts = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($checkOuts as $checkOut) {

      $datas[] = array(

        'id'                 => $checkOut['id'],

        'library_id_number'  => $checkOut['library_id_number'],

        'member_name'        => $checkOut['member_name'],

        'email'              => $checkOut['email'],

        'date_borrowed'      => fdate($checkOut['date_borrowed'],'m/d/Y'),

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

    $requestData = $this->request->getData('CheckOut');

    $requestData['date_borrowed'] = date('Y-m-d');

    $data = $this->CheckOuts->newEmptyEntity();
   
    $data = $this->CheckOuts->patchEntity($data, $requestData); 

    $sub = $this->request->getData('CheckOutSub');

    if ($this->CheckOuts->save($data)) {

      $id = $data->id;

      if(!empty($sub)){

        foreach ($sub as $key => $value) {
          
          $sub[$key]['check_out_id'] = $id;

          //UPDATING STATUS OF INVENTORY BIBLIOGRAPHY

            $inventoryBibliographyTable = TableRegistry::getTableLocator()->get('InventoryBibliographies');
        
            $inventoryBibliographyEntity = $inventoryBibliographyTable->newEntity([

              'id'           => $value['inventory_bibliography_id'],

              'status'       => 'Borrowed',

              'status_dt'    => date('Y-m-d'),

              'dueback'      => $value['dueback'],

              'check_out_id' => $id

            ]);
            
            $inventoryBibliographyTable->save($inventoryBibliographyEntity);

          //END 

        }

        $subEntities = $this->CheckOutSubs->newEntities($sub);

        $this->CheckOutSubs->saveMany($subEntities);

      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Check-out has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Check Out',

        'description' => 'Learning Resource Center',

        'code' => $requestData['library_id_number'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Check-out cannot saved this time.',

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

    $data['CheckOut'] = $this->CheckOuts->find()

      ->contain([

        'CheckOutSubs' => [

          'conditions' => ['CheckOutSubs.visible' => 1]

        ]

      ])

      ->where([

        'CheckOuts.visible' => 1,

        'CheckOuts.id' => $id

      ])

    ->first();

    $data['CheckOutSub'] = $data['CheckOut']['check_out_subs'];

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

    $checkOut = $this->CheckOuts->get($id); 

    $requestData = $this->getRequest()->getData('CheckOut');

    $requestData['date_borrowed'] = date('Y-m-d');

    $this->CheckOuts->patchEntity($checkOut, $requestData); 

    $sub = $this->request->getData('CheckOutSub');

    if ($this->CheckOuts->save($checkOut)) {

      $this->CheckOutSubs->updateAll(

        ['visible' => 0],

        ['check_out_id' => $id]
          
      );

      $tmp = "

        UPDATE 

          inventory_bibliographies

        SET 

          status = 'Available', returned = 0, status_dt = NULL, dueback = NULL, check_out_id = NULL

        WHERE 

          check_out_id = $id

      ";

      $connection = $this->InventoryBibliographies->getConnection();

      $result = $connection->execute($tmp)->fetchAll('assoc');

      if(!empty($sub)){

        foreach ($sub as $key => $value) {
          
          $sub[$key]['check_out_id'] = $id;

          unset($sub[$key]['id']); 

          //UPDATING STATUS OF INVENTORY BIBLIOGRAPHY

            $inventoryBibliographyTable = TableRegistry::getTableLocator()->get('InventoryBibliographies');
        
            $inventoryBibliographyEntity = $inventoryBibliographyTable->newEntity([

              'id'           => $value['inventory_bibliography_id'],

              'status'       => 'Borrowed',

              'status_dt'    => date('Y-m-d'),

              'dueback'      => $value['dueback'],

              'check_out_id' => $id

            ]);
            
            $inventoryBibliographyTable->save($inventoryBibliographyEntity);

          //END 

        }

        $subEntities = $this->CheckOutSubs->newEntities($sub);

        $this->CheckOutSubs->saveMany($subEntities);

      }





      $response = array(

        'ok'  =>true,

        'msg' =>'Check-out has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Check Out',

        'description' => 'Learning Resource Center',

        'code' => $requestData['library_id_number'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Check-out cannot updated this time.',

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

    $data = $this->CheckOuts->get($id);

    $data->visible = 0;

    if ($this->CheckOuts->save($data)) {

      $this->CheckOutSubs->updateAll(

        ['visible' => 0],

        ['check_out_id' => $id]
          
      );

      $tmp = "

        UPDATE 

          inventory_bibliographies

        SET 

          status = 'Available', returned = 0, status_dt = NULL, dueback = NULL, check_out_id = NULL

        WHERE 

          check_out_id = $id

      ";

      $connection = $this->InventoryBibliographies->getConnection();

      $result = $connection->execute($tmp)->fetchAll('assoc');

      $response = [

        'ok' => true,

        'msg' => 'Check-Out has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Check-Out Management',

          'code' => '',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Check-Out cannot be deleted at this time.'

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
