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

    $this->CurriculumSubs = TableRegistry::getTableLocator()->get('CurriculumSubs');

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

    $subs = $this->request->getData('CurriculumSub');

    $data = $this->Curriculums->newEmptyEntity();
   
    $data = $this->Curriculums->patchEntity($data, $requestData); 

    if ($this->Curriculums->save($data)) {

      $id = $data->id;

      if (count($subs) > 0) {

        foreach ($subs as $sub) {

        $subEntities = $this->CurriculumSubs->newEntity([

          'curriculum_id' => $id,

          'program' => $sub['program'],

          'program_id' => $sub['program_id'],

          'program' => $sub['program']

        ]);

        $this->CurriculumSubs->save($subEntities);

        }

      }

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

<<<<<<< HEAD
    $data = $this->Curriculums->find()
=======
    $data['Curriculum'] = $this->Curriculums->find()
>>>>>>> add5edab7ba288a83f1d2190d5bc2b6cc458fbc5

      ->contain([

        'CurriculumSubs' => [

          'conditions' => ['CurriculumSubs.visible' => 1] 

        ]

      ])

      ->where([

        'Curriculums.visible' => 1,

        'Curriculums.id'      => $id,

      ])

      ->first();

<<<<<<< HEAD
    $data['CurriculumSubs'] = $data['curriculum_subs'];

    unset($data['curriculum_subs']);
=======
    $data['CurriculumSub'] = $data['Curriculum']->curriculum_subs;

    unset($data['Curriculum']->curriculum_subs);
>>>>>>> add5edab7ba288a83f1d2190d5bc2b6cc458fbc5

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

    $this->autoRender = false;

    $requestData = $this->request->getData('Curriculum');

    $subs = $this->request->getData('CurriculumSub');

<<<<<<< HEAD
    $data = $this->Curriculums->newEmptyEntity();
=======
    $data = $this->Curriculums->findById($id)->first();
>>>>>>> add5edab7ba288a83f1d2190d5bc2b6cc458fbc5
   
    $data = $this->Curriculums->patchEntity($data, $requestData); 

    if ($this->Curriculums->save($data)) {

      $id = $data->id;

<<<<<<< HEAD
=======
      $this->Curriculums->CurriculumSubs->deleteAll(['curriculum_id' => $id]);

>>>>>>> add5edab7ba288a83f1d2190d5bc2b6cc458fbc5
      if (count($subs) > 0) {

        foreach ($subs as $sub) {

        $subEntities = $this->CurriculumSubs->newEntity([

          'curriculum_id' => $id,

          'program_id' => $sub['program_id'],

<<<<<<< HEAD
=======
          'program' => $sub['program'],

>>>>>>> add5edab7ba288a83f1d2190d5bc2b6cc458fbc5
        ]);

        $this->CurriculumSubs->save($subEntities);

        }

      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Curriculum has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

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

        'msg' =>'Curriculum cannot updated this time.',

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

    $requestData = $this->request->getData('Curriculum');

    $data = $this->Curriculums->get($id);

    $data->visible = 0;

    if ($this->Curriculums->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Curriculum Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'Curriculum has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Curriculum cannot be deleted at this time.'

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
