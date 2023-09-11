<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class CheckInsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->CheckIns = TableRegistry::getTableLocator()->get('CheckIns');

    $this->CheckInSubs = TableRegistry::getTableLocator()->get('CheckInSubs');

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

      $conditions['date'] = " AND DATE(CheckIn.date_returned) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(CheckIn.date_returned) >= '$start' AND DATE(CheckIn.date_returned) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $dataTable = $this->CheckIns;

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllCheckIn($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $checkIns = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($checkIns as $checkIn) {

      $datas[] = array(

        'id'                 => $checkIn['id'],

        'library_id_number'  => $checkIn['library_id_number'],

        'member_name'        => $checkIn['member_name'],

        'email'              => $checkIn['email'],

        'date_returned'      => fdate($checkIn['date_returned'],'m/d/Y'),

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

    $requestData = $this->request->getData('CheckIn');

    $requestData['date_returned'] = date('Y-m-d');

    $data = $this->CheckIns->newEmptyEntity();
   
    $data = $this->CheckIns->patchEntity($data, $requestData); 

    $sub = $this->request->getData('CheckInSub');

    if ($this->CheckIns->save($data)) {

      $id = $data->id;

      if(!empty($sub)){

        foreach ($sub as $key => $value) {
          
          $sub[$key]['check_in_id'] = $id;

          //UPDATING RETURN STATUS OF CHECK OUT SUB

            $checkOutsEntity = $this->CheckOutSubs->newEntity([

              'id'          => $value['check_out_sub_id'],

              'check_in_id' => $id,

              'returned'    => 1,

            ]);
            
            $this->CheckOutSubs->save($checkOutsEntity);

          //END 

          //UPDATING STATUS OF INVENTORY BIBLIOGRAPHY

            $inventoryBibliographiesEntity = $this->InventoryBibliographies->newEntity([

              'id'           => $value['inventory_bibliography_id'],

              'status'       => 'Returned',

              'returned'     => 1,

              'status_dt'    => date('Y-m-d'),

              'dueback'      => null,

              'check_out_id' => null

            ]);
            
            $this->InventoryBibliographies->save($inventoryBibliographiesEntity);

          //END 

        }

        $subEntities = $this->CheckInSubs->newEntities($sub);

        $this->CheckInSubs->saveMany($subEntities);

      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Check-in has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Check In',

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

        'msg' =>'Check-in cannot saved this time.',

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

    $data['CheckIn'] = $this->CheckIns->find()

      ->contain([

        'CheckInSubs' => [

          'conditions' => ['CheckInSubs.visible' => 1]

        ]

      ])

      ->where([

        'CheckIns.visible' => 1,

        'CheckIns.id' => $id

      ])

    ->first();

    $data['CheckInSub'] = $data['CheckIn']['check_in_subs'];

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

    $checkIn = $this->CheckIns->get($id); 

    $requestData = $this->getRequest()->getData('CheckIn');

    $requestData['date_returned'] = date('Y-m-d');

    $this->CheckIns->patchEntity($checkIn, $requestData); 

    $sub = $this->request->getData('CheckInSub');

    if ($this->CheckIns->save($checkIn)) {

      //RETURN OLD STATUS OF CHECK OUT SUB

        $tmp = "

          UPDATE 

            check_out_subs

          SET 

            check_in_id = null, returned = 0

          WHERE 

            check_in_id = $id

        ";

        $connection = $this->CheckOutSubs->getConnection();

        $result = $connection->execute($tmp)->fetchAll('assoc');

      //END 

      //RETURN OLD STATUS OF INVENTORY BIBLIOGRAPHY

        $tmp = $this->CheckInSubs->find()->where([

          "visible" => 1,

          "check_in_id" => $id

        ])->all();

        if(!empty($tmp)){

          foreach ($tmp as $key => $value) {

            $inventory_bibliography_id = $value['inventory_bibliography_id'];

            $dueback = $value['check_out_dueback'];

            $inventory_bibliographies = "

              UPDATE 

                inventory_bibliographies

              SET 

                status = 'Borrowed', returned = 0, status_dt = null, dueback = '$dueback'

              WHERE 

                id = $inventory_bibliography_id

            ";

            $connection = $this->CheckOutSubs->getConnection();

            $result = $connection->execute($inventory_bibliographies)->fetchAll('assoc');

          }

        }

      //END 

      $this->CheckInSubs->updateAll(

        ['visible' => 0],

        ['check_in_id' => $id]
          
      );

      if(!empty($sub)){

        foreach ($sub as $key => $value) {
          
          $sub[$key]['check_in_id'] = $id;

          unset($sub[$key]['id']); 

          //UPDATING STATUS OF INVENTORY BIBLIOGRAPHY
        
            $inventoryBibliographyEntity = $this->InventoryBibliographies->newEntity([

              'id'           => $value['inventory_bibliography_id'],

              'status'       => 'Returned',

              'returned'     => 1,

              'status_dt'    => null,

              'dueback'      => null,

              'check_out_id' => null

            ]);
            
            $this->InventoryBibliographies->save($inventoryBibliographyEntity);

          //END

          //UPDATING STATUS OFCHECK OUT SUB
        
            $checkOutSubsEntity = $this->CheckOutSubs->newEntity([

              'id'          => $value['check_out_sub_id'],

              'check_in_id' => $id,

              'returned'    => 1,

            ]);
            
            $this->CheckOutSubs->save($checkOutSubsEntity);

          //END 

        }

        $subEntities = $this->CheckInSubs->newEntities($sub);

        $this->CheckInSubs->saveMany($subEntities);

      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Check-in has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Check In',

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

        'msg' =>'Check-in cannot updated this time.',

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

    $data = $this->CheckIns->get($id);

    $data->visible = 0;

    if ($this->CheckIns->save($data)) {

      $this->CheckInSubs->updateAll(

        ['visible' => 0],

        ['check_in_id' => $id]
          
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

        'msg' => 'Check-In has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Check-In Management',

          'code' => '',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Check-In cannot be deleted at this time.'

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
