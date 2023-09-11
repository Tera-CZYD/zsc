<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class RolesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Roles = TableRegistry::getTableLocator()->get('Roles');

    $this->RolePermissions = TableRegistry::getTableLocator()->get('RolePermissions');

    $this->Permissions = TableRegistry::getTableLocator()->get('Permissions');

    $this->Users = TableRegistry::getTableLocator()->get('Users');

    $this->UserPermissions = TableRegistry::getTableLocator()->get('UserPermissions');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = $this->Roles;

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllRole($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $roles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($roles as $role) {

      $datas[] = array(

        'id'           => $role['id'],

        'name'         => $role['name'],

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

    $requestData = $this->request->getData('Role');

    $data = $this->Roles->newEmptyEntity();
   
    $data = $this->Roles->patchEntity($data, $requestData); 

    $rolePermission = $this->request->getData('RolePermission');

    $data['code'] = $data['name'];

    if ($this->Roles->save($data)) {

      $id = $data->id;

      if(!empty($rolePermission)){
        
        foreach ($rolePermission as $key => $value) {

          $rolePermission[$key]['role_id'] = $id;
          
        }

        $rolePermissionEntities = $this->RolePermissions->newEntities($rolePermission);

        $this->RolePermissions->saveMany($rolePermissionEntities);
      
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Role has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Role Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Role cannot saved this time.',

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

    $data['Role'] = $this->Roles->find()

    ->contain([

      'RolePermissions' => [

        'conditions' => ['visible' => 1]

      ]

    ])

    ->where([

      'id' => $id,

      'visible' => 1

    ])

    ->first();

    $data['RolePermission'] = $data['Role']['role_permissions'];

    if (!empty($data['RolePermission'])) {

      foreach ($data['RolePermission'] as $key => $rolePermission) {

        $tmp = $this->Permissions->find()

          ->where([

            'Permissions.visible' => true,

            'Permissions.id' => $rolePermission->permission_id

          ])

          ->first();

        if (!empty($tmp)) {

          $data['RolePermission'][$key]['module'] = strtoupper($tmp->module);

          $data['RolePermission'][$key]['action'] = strtoupper($tmp->action);

        }

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

    $role = $this->Roles->get($id); 

    $requestData = $this->getRequest()->getData('Role');

    $requestData['code'] = $requestData['name'];

    $rolePermission = $this->request->getData('RolePermission');

    $this->Roles->patchEntity($role, $requestData); 

    if ($this->Roles->save($role)) {

      $rolesOld = $this->RolePermissions->find()

        ->where([

          'RolePermissions.visible' => 1,

          'RolePermissions.role_id' => $id

        ])

      ->first();

      $this->RolePermissions->updateAll(

        ['visible' => 0],

        ['role_id' => $id]
          
      );

      if(!empty($rolePermission)){

        $user = $this->Users->find()->where([

          "visible" => 1,

          "roleId" => $id

        ])->all();

        if(!empty($user)){

          foreach ($user as $key => $value) {

            $this->UserPermissions->updateAll(

              ['visible' => 0],

              ['user_id' => $value['id']]
                
            );

          }
          
          foreach ($rolePermission as $key => $value) {

            $userPermission = array();

            $rolePermission[$key]['role_id'] = $id;

            foreach ($user as $index => $value) {
            
              $userPermission[$index]['user_id'] = $value['id'];

              $userPermission[$index]['permission_id'] = $rolePermission[$key]['permission_id'];

            }

            $userPermissionEntities = $this->UserPermissions->newEntities($userPermission);

            $this->UserPermissions->saveMany($userPermissionEntities);
            
          }

          $rolePermissionEntities = $this->RolePermissions->newEntities($rolePermission);

          $this->RolePermissions->saveMany($rolePermissionEntities);

        }else{

          foreach ($rolePermission as $key => $value) {

            $rolePermission[$key]['role_id'] = $id;
            
          }

          $rolePermissionEntities = $this->RolePermissions->newEntities($rolePermission);

          $this->RolePermissions->saveMany($rolePermissionEntities);

        }
      
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Role has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Role Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Role cannot updated this time.',

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

    $data = $this->Roles->get($id);

    $data->visible = 0;

    if ($this->Roles->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Role has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Role Management',

          'code' => $data->name,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Role cannot be deleted at this time.'

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
