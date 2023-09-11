<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class RoomsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Rooms = TableRegistry::getTableLocator()->get('Rooms');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('Rooms');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllRoom($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $rooms = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // var_dump($rooms);
    foreach ($rooms as $room) {

      $datas[] = array(

        'id'           => $room['id'],

       'code'         => $room['code'],

       'name'         => $room['name'],

       'short_name'   => $room['short_name'],  

       'building'     => $room['building_name'],

       'room_type'    => $room['room_type'],

       'size'     => $room['size'],

       'college' => $room['CollegeName'],

       'capacity'     => $room['capacity'],

       'remarks'      => $room['remarks'],

       'active'       => $room['active'] ? 'True' : 'False',
       

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

    $requestData = $this->request->getData('Room');

    $data = $this->Rooms->newEmptyEntity();
   
    $data = $this->Rooms->patchEntity($data, $requestData); 

    if ($this->Rooms->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'room has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Room Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'room cannot saved this time.',

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

    $data['Room'] = $this->Rooms->find()

      ->where([

        'Rooms.visible' => 1,

        'Rooms.id' => $id

      ])

      ->contain([

        'Buildings',

        'RoomTypes'

      ])

      ->first();

    // var_dump($data['Room']);
      $data['Building'] = $data['Room']['building'];
      $data['RoomType'] = $data['Room']['room_type'];

      unset($data['Room']['building']);

      unset($data['Room']['room_type']);
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

    $room = $this->Rooms->get($id); 

    $requestData = $this->getRequest()->getData('Room');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->Rooms->patchEntity($room, $requestData); 

    if ($this->Rooms->save($room)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'room has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'room Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'room cannot updated this time.',

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

    $data = $this->Rooms->get($id);

    $data->visible = 0;

    if ($this->Rooms->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'room has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'room cannot be deleted at this time.'

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
