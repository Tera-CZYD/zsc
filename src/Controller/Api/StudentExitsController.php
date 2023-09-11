<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class StudentExitsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->StudentExits = TableRegistry::getTableLocator()->get('StudentExits');

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

    $tmpData = $this->StudentExits->paginate($this->StudentExits->getAllStudentExit($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $student_exits = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // var_dump($RequestForms);
    foreach ($student_exits as $data) {

      $datas[] = array(

  
          'id'             => $data['id'],
  
          'student_name'   => $data['student_name'],

          'course'         => $data['name'],

          'email'          => $data['email'],

          'contact_no'     => $data['contact_no'],

          'date'           => date('m/d/Y',strtotime($data['date'])),

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

    $requestData = $this->request->getData('StudentExit');

    $requestData['date'] = isset($requestData['date']) ? date('Y-m-d', strtotime($requestData['date'])) : null;

    $data = $this->StudentExits->newEmptyEntity();
   
    $data = $this->StudentExits->patchEntity($data, $requestData); 

    if ($this->StudentExits->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Student Exit has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Student Exit Management',

          'code' => $requestData['student_name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Exit cannot saved this time.',

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

    $data['StudentExit'] = $this->StudentExits->find()

      ->contain([

        'CollegePrograms'

        ])

      ->where([

        'StudentExits.visible' => 1,

        'StudentExits.id' => $id

      ])

      ->first();

      $data = [

        'StudentExit' => $data['StudentExit'],

        'CollegeProgram'  => $data['StudentExit']->CollegeProgram,

      ];

      unset($data['StudentExit']->CollegeProgram);


      $data['StudentExit']['date'] = isset($data['StudentExit']['date']) ? date('m/d/Y', strtotime($data['StudentExit']['date'])) : null;

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

    $data = $this->StudentExits->get($id); 

    $requestData = $this->getRequest()->getData('StudentExit');

    $requestData['date'] = isset($requestData['date']) ? date('Y-m-d', strtotime($requestData['date'])) : NULL;

    $this->StudentExits->patchEntity($data, $requestData); 

    if ($this->StudentExits->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Student Exit has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Student Exit',

          'code' => $requestData['id'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Exit cannot updated this time.',

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

    $data = $this->StudentExits->get($id);

    $data->visible = 0;

    if ($this->StudentExits->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Exit has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Exit cannot be deleted at this time.'

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
