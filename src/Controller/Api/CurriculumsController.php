<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class CurriculumsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Curriculums = TableRegistry::getTableLocator()->get('Curriculums');

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

    $dataTable = TableRegistry::getTableLocator()->get('Curriculums');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllCurriculum($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $curriculums = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($curriculums as $curriculum) {

      $datas[] = array(

        'id'           => $curriculum['id'],

        'description'         => $curriculum['description'],

        'code'         => $curriculum['code'],

      );

    }

    $response = [

      'ok' => true,

      'data' => $datas,

      'paginator' => $paginator,

      'conditionsPrint' => $conditionsPrint,

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function add(){

    $this->autoRender = false;

    $requestData = $this->request->getData('Curriculum');

    $data = $this->Curriculums->newEmptyEntity();
   
    $data = $this->Curriculums->patchEntity($data, $requestData); 

    if ($this->Curriculums->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Curriculum has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Curriculum Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Curriculum cannot saved this time.',

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

    $data = $this->Curriculums->find()

      ->contain([

        'CurriculumSubs',

      ])

      ->where([

        'Curriculums.visible' => 1,

        'Curriculums.id' => $id

      ])

      ->first();

    $response = [

      'ok' => true,

      'data' => [

        'Curriculum' => $data,

        'CurriculumsSub' => $data->college_sub

      ],

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

    $college = $this->Colleges->get($id); 

    $requestData = $this->getRequest()->getData('College');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->Colleges->patchEntity($college, $requestData); 

    if ($this->Colleges->save($college)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'College has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'College Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'College cannot updated this time.',

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

    $requestData = $this->request->getData('College');

    $data = $this->Colleges->get($id);

    $data->visible = 0;

    if ($this->Colleges->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'College Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'College has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'College cannot be deleted at this time.'

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
