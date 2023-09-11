<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class SpecializationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Specializations = TableRegistry::getTableLocator()->get('Specializations');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('Specializations');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllSpecialization($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $specialization = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // var_dump($rooms);
    foreach ($specialization as $data) {

      $datas[] = array(

        'id'           => $data['id'],

       'name'         => $data['name'],
       

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

    $requestData = $this->request->getData('Specialization');

    $data = $this->Specializations->newEmptyEntity();
   
    $data = $this->Specializations->patchEntity($data, $requestData); 

    if ($this->Specializations->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Specialization has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Specialization Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Specialization cannot saved this time.',

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

    $data['Specialization'] = $this->Specializations->find()

      ->where([

        'visible' => 1,

        'id' => $id

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

    $Specialization = $this->Specializations->get($id); 

    $requestData = $this->getRequest()->getData('Specialization');

    $this->Specializations->patchEntity($Specialization, $requestData); 

    if ($this->Specializations->save($Specialization)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Specialization has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Specialization Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Specialization cannot updated this time.',

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

    $data = $this->Specializations->get($id);

    $data->visible = 0;

    if ($this->Specializations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Specialization has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Specialization cannot be deleted at this time.'

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
