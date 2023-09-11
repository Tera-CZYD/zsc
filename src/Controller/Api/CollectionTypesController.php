<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class CollectionTypesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->CollectionTypes = TableRegistry::getTableLocator()->get('CollectionTypes');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $limit = 25;

    $tmpData = $this->CollectionTypes->paginate($this->CollectionTypes->getAllCollectionType($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $collectionTypes = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($collectionTypes as $collectionType) {

      $datas[] = array(

        'id'     => $collectionType['id'],

        'name'   => $collectionType['name'],

      );

    }

    $response = [

      'ok' => true,

      'data' => $datas,

      'paginator' => $paginator

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function add(){

    $this->autoRender = false;

    $requestData = $this->request->getData('CollectionType');

    $data = $this->CollectionTypes->newEmptyEntity();
   
    $data = $this->CollectionTypes->patchEntity($data, $requestData); 

    if ($this->CollectionTypes->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Collection Type has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Collection Type Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Collection Type cannot saved this time.',

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

    $data['CollectionType'] = $this->CollectionTypes->find()

      ->where([

        'CollectionTypes.visible' => 1,

        'CollectionTypes.id' => $id

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

    $material = $this->CollectionTypes->get($id); 

    $requestData = $this->getRequest()->getData('CollectionType');

    $this->CollectionTypes->patchEntity($material, $requestData); 

    if ($this->CollectionTypes->save($material)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Collection Type has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Collection Type Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Collection Type cannot updated this time.',

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

    $data = $this->CollectionTypes->get($id);

    $data->visible = 0;

    if ($this->CollectionTypes->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Collection Type has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Collection Type Management',

          'code' => '',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Collection Type cannot be deleted at this time.'

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
