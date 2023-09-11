<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class AwardManagementsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Awards = TableRegistry::getTableLocator()->get('AwardManagements');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $limit = 25;

    $tmpData = $this->Awards->paginate($this->Awards->getAllAwardManagement($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $Awards = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($Awards as $data) {

      $datas[] = array(

         'id'     => $data['id'],

         'name'   => $data['name']
       

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

    $requestData = $this->request->getData('AwardManagement');

    $data = $this->Awards->newEmptyEntity();
   
    $data = $this->Awards->patchEntity($data, $requestData); 

    if ($this->Awards->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Award has been successfully saved.',

        'data'=>$requestData

      );


        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Award Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Award cannot saved this time.',

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

    $data['AwardManagement'] = $this->Awards->find()

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

    $admin = $this->Awards->get($id); 

    $requestData = $this->getRequest()->getData('AwardManagement');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->Awards->patchEntity($admin, $requestData); 

    if ($this->Awards->save($admin)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Award has been successfully updated.',

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

        'msg' =>'Award cannot updated this time.',

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

    $data = $this->Awards->get($id);

    $data->visible = 0;

    if ($this->Awards->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Award has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Award cannot be deleted at this time.'

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
