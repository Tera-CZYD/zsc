<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class YearLevelTermsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->YearLevelTerms = TableRegistry::getTableLocator()->get('YearLevelTerms');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('YearLevelTerms');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllYearLevelTerm($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $tmps = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($tmps as $data) {

      $datas[] = array(

        'id'           => $data['id'],

        'description'  => $data['description'],

        'educational_level'  => $data['educational_level'],

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

    $requestData = $this->request->getData('YearLevelTerm');

    $data = $this->YearLevelTerms->newEmptyEntity();

    $data->description = $requestData['year']. ' - ' . $requestData['semester'];
   
    $data = $this->YearLevelTerms->patchEntity($data, $requestData); 

    if ($this->YearLevelTerms->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Year Level Term has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Year Level Term Management',

          // 'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Year Level Term cannot saved this time.',

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

    $data['YearLevelTerm'] = $this->YearLevelTerms->find()

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

    $year_level_term = $this->YearLevelTerms->get($id); 

    $requestData = $this->getRequest()->getData('YearLevelTerm');

    $requestData['description'] = $requestData['year']. ' - ' . $requestData['semester'];

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->YearLevelTerms->patchEntity($year_level_term, $requestData); 

    if ($this->YearLevelTerms->save($year_level_term)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Year Level Term has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Year Level Term Management',

          // 'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Year Level Term cannot updated this time.',

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

    $data = $this->YearLevelTerms->get($id);

    $data->visible = 0;

    if ($this->YearLevelTerms->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Year Level Term Management',

          // 'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'Year Level Term has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Year Level Term cannot be deleted at this time.'

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
