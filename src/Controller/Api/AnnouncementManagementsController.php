<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class AnnouncementManagementsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->AnnouncementManagements = TableRegistry::getTableLocator()->get('AnnouncementManagements');

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

    $tmpData = $this->AnnouncementManagements->paginate($this->AnnouncementManagements->getAllAnnouncementManagement($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $announce = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($announce as $data) {

      $datas[] = array(

         'id'     => $data['id'],

         'title'   => $data['title'],

         'date'   => fdate($data['date_start'],'m/d/Y'). " - ". fdate($data['date_end'],'m/d/Y'),

         'time'   => $data['time_start']. " - ". $data['time_end'],
       

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

    $requestData = $this->request->getData('AnnouncementManagement');

    // var_dump($this->request->getData());

    $requestData['date_start'] = isset($requestData['date_start']) ? fdate($requestData['date_start'],'Y-m-d') : NULL;

    $requestData['date_end'] = isset($requestData['date_end']) ? fdate($requestData['date_end'],'Y-m-d') : NULL;

    // var_dump($requestData);

    $data = $this->AnnouncementManagements->newEmptyEntity();
   
    $data = $this->AnnouncementManagements->patchEntity($data, $requestData); 

    if ($this->AnnouncementManagements->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Announcement has been successfully saved.',

        'data'=>$requestData

      );


        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Announcement Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Announcement cannot saved this time.',

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

    $data['AnnouncementManagement'] = $this->AnnouncementManagements->find()

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

    $admin = $this->AnnouncementManagements->get($id); 

    $requestData = $this->getRequest()->getData('AnnouncementManagement');

    $requestData['date_start'] = isset($requestData['date_start']) ? fdate($requestData['date_start'],'Y-m-d') : NULL;

    $requestData['date_end'] = isset($requestData['date_end']) ? fdate($requestData['date_end'],'Y-m-d') : NULL;

    $this->AnnouncementManagements->patchEntity($admin, $requestData); 

    if ($this->AnnouncementManagements->save($admin)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Announcement has been successfully updated.',

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

        'msg' =>'Announcement cannot updated this time.',

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

    $data = $this->AnnouncementManagements->get($id);

    $data->visible = 0;

    if ($this->AnnouncementManagements->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Announcement has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Announcement cannot be deleted at this time.'

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
