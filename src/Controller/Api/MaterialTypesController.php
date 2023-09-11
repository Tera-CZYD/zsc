<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class MaterialTypesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->MaterialTypes = TableRegistry::getTableLocator()->get('MaterialTypes');

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

    $tmpData = $this->MaterialTypes->paginate($this->MaterialTypes->getAllMaterialType($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $materials = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($materials as $material) {

      $datas[] = array(

        'id'     => $material['id'],

        'name'   => $material['name'],

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

    $requestData = $this->request->getData('MaterialType');

    $data = $this->MaterialTypes->newEmptyEntity();
   
    $data = $this->MaterialTypes->patchEntity($data, $requestData); 

    if ($this->MaterialTypes->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Material Type has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Material Type Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Material Type cannot saved this time.',

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

    $data['MaterialType'] = $this->MaterialTypes->find()

      ->where([

        'MaterialTypes.visible' => 1,

        'MaterialTypes.id' => $id

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

    $material = $this->MaterialTypes->get($id); 

    $requestData = $this->getRequest()->getData('MaterialType');

    $this->MaterialTypes->patchEntity($material, $requestData); 

    if ($this->MaterialTypes->save($material)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Material Type has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Material Type Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Material Type cannot updated this time.',

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

    $data = $this->MaterialTypes->get($id);

    $data->visible = 0;

    if ($this->MaterialTypes->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Material Type has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Material Type Management',

          'code' => '',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Material Type cannot be deleted at this time.'

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
