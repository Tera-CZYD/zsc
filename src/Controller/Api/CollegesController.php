<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class CollegesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Colleges = TableRegistry::getTableLocator()->get('Colleges');

    $this->CollegeSubs = TableRegistry::getTableLocator()->get('CollegeSubs');

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

    $dataTable = TableRegistry::getTableLocator()->get('Colleges');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllCollege($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $colleges = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($colleges as $college) {

      $datas[] = array(

        'id'           => $college['id'],

        'name'         => $college['name'],

        'code'         => $college['code'],

        'acronym'         => $college['acronym'],

        'year_established'         => $college['year_established'],

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

    $requestData = $this->request->getData('College');

    $data = $this->Colleges->newEmptyEntity();
   
    $data = $this->Colleges->patchEntity($data, $requestData); 

    $sub = $this->request->getData('CollegeSub');

    if ($this->Colleges->save($data)) {

       $id = $data->id;

      if(!empty($sub)){
        
        foreach ($sub as $key => $value) {

          $sub[$key]['college_id'] = $id;
          
        }

        $subEntities = $this->CollegeSubs->newEntities($sub);

        $this->CollegeSubs->saveMany($subEntities);
      
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'College has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

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

        'msg' =>'College cannot saved this time.',

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

    $data = $this->Colleges->find()

      ->contain([

              'CollegeSub' => function ($q) {

                  return $q->where(['visible' => 1]);

              },
    
      ])
      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

    $response = [

      'ok' => true,

      'data' => [

        'College' => $data,
        'CollegeSub' => $data->college_sub
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

    $sub = $this->request->getData('CollegeSub');

    if ($this->Colleges->save($college)) {

      $this->CollegeSubs->updateAll(

        ['visible' => 0],

        ['college_id' => $id]
          
      );

      if(!empty($sub)){
        
        foreach ($sub as $key => $value) {

          $sub[$key]['college_id'] = $id;
          
        }

        $subEntities = $this->CollegeSubs->newEntities($sub);

        $this->CollegeSubs->saveMany($subEntities);
      
      }

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
