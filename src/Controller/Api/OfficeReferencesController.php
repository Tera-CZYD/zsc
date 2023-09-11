<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class OfficeReferencesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->OfficeReferences = TableRegistry::getTableLocator()->get('OfficeReferences');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('OfficeReferences');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllOfficeReference($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $office_references = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($office_references as $office_reference) {

      $datas[] = array(

        'id'           => $office_reference['id'],

        'module'         => $office_reference['module'],

        'submodule'         => $office_reference['sub_module'],

        'reference_code'     => $office_reference['reference_code'],

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

    $requestData = $this->request->getData('OfficeReference');

    $data = $this->OfficeReferences->newEmptyEntity();
   
    $data = $this->OfficeReferences->patchEntity($data, $requestData); 

    if ($this->OfficeReferences->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Office References has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Office References',

          'code' => $requestData['reference_code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Office References cannot saved this time.',

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

    $data['OfficeReference'] = $this->OfficeReferences->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

    $data['OfficeReference']['active_view'] = $data['OfficeReference']['active'] ? 'True' : 'False';

    $data['OfficeReference']['floors'] = intval($data['OfficeReference']['floors']);

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

    $office_reference = $this->OfficeReferences->get($id); 

    $requestData = $this->getRequest()->getData('OfficeReference');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->OfficeReferences->patchEntity($office_reference, $requestData); 

    if ($this->OfficeReferences->save($office_reference)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Office References has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Office References',

          'code' => $requestData['reference_code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Office References cannot updated this time.',

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

    $data = $this->OfficeReferences->get($id);

    $data->visible = 0;

    if ($this->OfficeReferences->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Office References has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Office References',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Office References cannot be deleted at this time.'

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
