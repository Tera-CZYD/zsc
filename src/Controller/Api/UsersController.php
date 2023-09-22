<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class UsersController extends AppController
{
    // Declare a property to hold the UsersTable instance
   

  // Use dependency injection to get the UsersTable instance
  public function initialize(): void
  {
    parent::initialize();
    
    $this->loadComponent('RequestHandler');

     $this->autoRender = false;

    $this->Users = TableRegistry::getTableLocator()->get('Users');

    $this->Roles = TableRegistry::getTableLocator()->get('Roles');

    $this->UserPermissions = TableRegistry::getTableLocator()->get('UserPermissions');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $conditions['User'] = '';

    if ($this->request->getQuery('User') != null) {

      if ($this->request->getQuery('User') == 'user') {

        $conditions['User'] = "AND User.roleId <> 12 AND User.roleId <> 13 AND User.roleId <> 18";

      }else if ($this->request->getQuery('User') == 'employee') {

        $conditions['User'] = "AND User.roleId = 12";

      }else if ($this->request->getQuery('User') == 'student') {

        $conditions['User'] = "AND User.roleId = 13";

      }
      else if ($this->request->getQuery('User') == 'dean') {

        $conditions['User'] = "AND User.roleId = 24";

      }else if($this->request->getQuery('User') == 'vice') {

        $conditions['User'] = "AND roleId = 25";

      }
      
    }

    $dataTable = TableRegistry::getTableLocator()->get('Users');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllUser($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $users = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($users as $user) {

      $datas[] = array(

        'id'        => $user['id'],

        'name'      => $user['full_name'],

        'username'  => $user['username'],

        'role'     => $user['name'],  

        'active'   => $user['active']==1?'ACTIVE':'NOT ACTIVE'

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

  public function view($id = null) {

    $user['User'] = $this->Users->find()

      ->contain([

        'Employees' => [

          'conditions' => ['Employees.visible' => 1],

        ],

        'Students' => [

          'conditions' => ['Students.visible' => 1],

        ],

        'UserPermissions' => [

          'Permissions',

          'conditions' => ['UserPermissions.visible' => 1],

        ],

        'Roles',

      ])

      ->where(['Users.id' => $id])

      ->firstOrFail();


    // Remove sensitive information
    unset($user->mobile_password);

    // Transform user permission data
    $disabledPermission = [];

    foreach ($user['User']->user_permissions as $k => $data) {

      $disabledPermission[] = @$data->permission->id;

      $user['User']->user_permissions[$k] = [

        'id' => @$data->id,

        'module' => @$data->permission->module,

        'action' => @$data->permission->action,

      ];

    }

    $user['UserPermission'] = $user['User']->user_permissions;

     $permissionSelection = [];

     // var_dump($permissionSelection);

    if (!empty($disabledPermission)) {

      $permissionSelection = $this->Users->UserPermissions->Permissions->find()

      ->where([

        'Permissions.id NOT IN' => $disabledPermission,

        'Permissions.visible' => 1,

      ])

      ->order([

          'Permissions.module' => 'ASC',

          'Permissions.action' => 'ASC',

      ])

      ->all();

    }else{
      $permissionSelection = $this->Users->UserPermissions->Permissions->find()

      ->where([

        'Permissions.visible' => 1,

      ])

      ->order([

          'Permissions.module' => 'ASC',

          'Permissions.action' => 'ASC',

      ])

      ->all();

    }


    $permissionSelectionArray = [];

    foreach ($permissionSelection as $data) {

      $permissionSelectionArray[] = [

        'id' => $data->id,

        'module' => $data->module,

        'action' => $data->action,

      ];

    }


    $user['PermissionSelection'] = $permissionSelection;

    // Set image source
    if ($user['User']->image != null) {

      $user['User']->imageSrc = $this->getRequest()->getAttribute('webroot') . '/uploads/users/' . $id . '/' . $user['User']->image;

    } else {

      $user['User']->imageSrc = $this->getRequest()->getAttribute('webroot') . '/assets/img/user.jpg';

    }


    $response = [

      'ok' => true,

      'data' => $user,

    ];


    // Set response data
    $this->set([

      'response' => $response,

      '_serialize' => 'response',

    ]);


    // Log user view
    $userLogEntity = $this->UserLogs->newEntity([

      'action' => 'View',

      'description' => 'User Management',

    ]);

    $userLogTable = $this->getTableLocator()->get('UserLogs');

    $userLogTable->save($userLogEntity);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;
  }

  public function add()
  {

    if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

      $requestData = $this->request->getData('data');

      $data = json_decode($requestData, true);

      $user = $data['User'];

      // Check and handle uploaded file
      $uploadedFile = $this->request->getData('file');

      if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

        $user['image'] = $uploadedFile->getClientFilename();

      }

      $save = $this->Users->validSave($user);

      $userId = $save['data']['id'];

      if ($save['ok']) {

        if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

          $user['image'] = $uploadedFile->getClientFilename();

          // Upload user image

          if (!file_exists('uploads')) {

            mkdir('uploads');

          }

          if (!file_exists('uploads/users')) {

            mkdir('uploads/users');

          }

          $imagePath = "uploads/users/$userId";

          if (!file_exists($imagePath)) {

            mkdir($imagePath);

          }

          $uploadedFilePath = $imagePath . '/' . $uploadedFile->getClientFilename();

          $uploadedFile->moveTo($uploadedFilePath);

        }

        $role = $this->Roles

          ->find()

          ->contain([

            'RolePermissions' => [

              'conditions' => [

                'RolePermissions.visible' => 1

              ]

            ]

          ])

          ->where([

            'Roles.id' => $user['roleId'],

            'Roles.visible' => 1

          ])

        ->first();

        if (!empty($role['role_permissions'])) {

          foreach ($role['role_permissions'] as $key => $value) {

            // $role['role_permissions'][$key]['id'] = null;

            $role['role_permissions'][$key]['user_id'] = $userId;

          }

          $this->UserPermissions->saveMany($role['role_permissions']);

        }

        // End default user permission



        $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'User Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);


        $response = [

          'ok' => true,

          'msg' => 'User has been successfully saved.',

          'data' => $requestData

        ];


          // ... (rest of the code remains the same)
      } else {

        $response = [

          'ok' => false,

          'data' => $requestData,

          'msg' => $save['msg']

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

  public function edit(){

    $this->request->allowMethod(['post']);

    if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

      $requestData = $this->request->getData('data');

      $data = json_decode($requestData, true);

      $user = $data['User'];

      $sub = $data['UserPermission'];

      $uploadedFile = $this->request->getData('file');
      
      if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

        $user['image'] = $uploadedFile->getClientFilename();

      }

      if (isset($user['password'])) {

        if ($user['password'] == '')

          unset($user['password']);

      }

      $userId = $data['User']['id'];

      $save = $this->Users->validSave($user);
      
      

      if ($save['ok']) {

        if ($uploadedFile instanceof \Laminas\Diactoros\UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {

          $user['image'] = $uploadedFile->getClientFilename();

          // Upload user image

          if (!file_exists('uploads')) {

            mkdir('uploads');

          }

          if (!file_exists('uploads/users')) {

            mkdir('uploads/users');

          }

          $imagePath = "uploads/users/$userId";

          if (!file_exists($imagePath)) {

            mkdir($imagePath);

          }

          $uploadedFilePath = $imagePath . '/' . $uploadedFile->getClientFilename();

          $uploadedFile->moveTo($uploadedFilePath);

        }

      $disabledPermission = [];

      if (!empty($sub)) {

        foreach ($sub as $k => $datax) {

          $disabledPermission[] = $datax['id'];

        }

      }

      $roleQuery = $this->Roles->find()

        ->contain([

            'RolePermissions' => [

                'conditions' => ['RolePermissions.visible' => 1],

            ],

        ])

        ->where([

            'Roles.id' => $user['roleId'],

            'Roles.visible' => 1,

        ]);

      if (!empty($disabledPermission)) {
          $roleQuery->contain('RolePermissions', function ($q) use ($disabledPermission) {
              return $q->where(['RolePermissions.permission_id NOT IN' => $disabledPermission]);
          });
      }

      $role = $roleQuery->first();


      if (!empty($role->role_permissions)) {

        $userPermissionEntities = [];

        foreach ($role->role_permissions as $key => $value) {

          $userPermissionEntities[] = [

            'user_id' => $userId,

            'permission_id' => $value['permission_id'],

          ];

        }

        $userPermissionEntities = $this->UserPermissions->newEntities($userPermissionEntities);

        $this->UserPermissions->saveMany($userPermissionEntities);
      }

      $response = $save;

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'User Management',

          'code' => $user['id'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      } else {

        $response = [

          'ok' => false,

          'data' => $requestData,

          'msg' => 'User could not be saved at this time.'

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
  
  public function delete($id)
  {
    $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->Users->get($id);

    $data->visible = 0;

    if ($this->Users->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'User has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'User cannot be deleted at this time.'

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

  public function api_saveSelectedPermission()
  {

    $this->autoRender = false;

    $requestData = $this->request->getData('data');

    $data = json_decode($requestData, true);

    // var_dump($data);
    if ($this->UserPermissions->saveMany($data['UserPermission'])) {

      $this->response = $this->response->withLocation(['controller' => 'Users', 'action' => 'view']);

      $response = [

        'ok' => true,

        'msg' => 'Permission has been successfully added.',

      ];

      $this->loadModel('UserLog');

      $this->UserLog->addLogs('User Permission', 'Added', ' ');

    } else {

      $response = [

        'ok' => false,

        'data' => $data['UserPermission'],

        'msg' => 'Permission cannot be added at this time.',

      ];

    }


    $this->set([

      'response' => $response,

      '_serialize' => 'response',

    ]);


    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;
  }
}
