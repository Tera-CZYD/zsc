<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class AdminsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->Admins = TableRegistry::getTableLocator()->get('Admins');

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

    $limit = 25;

    $tmpData = $this->Admins->paginate($this->Admins->getAllAdmin($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $Admins = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($Admins as $data) {

      $datas[] = array(

         'id'             => $data['id'],

         'employee_no'    => $data['employee_no'],

         'employee_name'  => $data['full_name'],

         'department'     => $data['department'],
       

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

    $requestData = $this->request->getData('Admin');

    $data = $this->Admins->newEmptyEntity();
   
    $data = $this->Admins->patchEntity($data, $requestData); 

    if ($this->Admins->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Admin has been successfully saved.',

        'data'=>$requestData

      );


        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Admin Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Admin cannot saved this time.',

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

    $data['Admin'] = $this->Admins->find()

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

    $admin = $this->Admins->get($id); 

    $requestData = $this->getRequest()->getData('Admin');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->Admins->patchEntity($admin, $requestData); 

    if ($this->Admins->save($admin)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Admin has been successfully updated.',

        'data'=>$requestData

      );
        
      $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Edit',

          'description' => 'admin Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Admin cannot updated this time.',

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

    $data = $this->Admins->get($id);

    $data->visible = 0;

    if ($this->Admins->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Admin has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Admin cannot be deleted at this time.'

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
