<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class AcademicRanksController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->AcademicRanks = TableRegistry::getTableLocator()->get('AcademicRanks');

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

    $tmpData = $this->AcademicRanks->paginate($this->AcademicRanks->getAllAcademicRank($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $academicRank = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // var_dump($rooms);
    foreach ($academicRank as $data) {

      $datas[] = array(

        'id'           => $data['id'],

       'rank'         => $data['rank'],
       

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

    $requestData = $this->request->getData('AcademicRank');

    $data = $this->AcademicRanks->newEmptyEntity();
   
    $data = $this->AcademicRanks->patchEntity($data, $requestData); 

    if ($this->AcademicRanks->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Academic Rank has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Academic Rank Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Academic Rank cannot saved this time.',

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

    $data['AcademicRank'] = $this->AcademicRanks->find()

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

    $academicRank = $this->AcademicRanks->get($id); 

    $requestData = $this->getRequest()->getData('AcademicRank');

    $this->AcademicRanks->patchEntity($academicRank, $requestData); 

    if ($this->AcademicRanks->save($academicRank)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Academic Rank has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Academic Rank Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Academic Rank cannot updated this time.',

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

    $data = $this->AcademicRanks->get($id);

    $data->visible = 0;

    if ($this->AcademicRanks->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Academic Rank has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Academic Rank cannot be deleted at this time.'

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
