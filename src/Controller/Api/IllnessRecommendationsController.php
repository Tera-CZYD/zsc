<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class IllnessRecommendationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->IllnessRecommendations = TableRegistry::getTableLocator()->get('IllnessRecommendations');

    $this->IllnessRecommendationSubs = TableRegistry::getTableLocator()->get('IllnessRecommendationSubs');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $limit = 25;

    $tmpData = $this->IllnessRecommendations->paginate($this->IllnessRecommendations->getAllIllnessRecommendation($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $illnessRecommendations = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($illnessRecommendations as $illnessRecommendation) {

      $datas[] = array(

        'id'           => $illnessRecommendation['id'],

        'ailment'      => $illnessRecommendation['ailment'],

        'description'  => $illnessRecommendation['description'],

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

    $requestData = $this->request->getData('IllnessRecommendation');

    $data = $this->IllnessRecommendations->newEmptyEntity();
   
    $data = $this->IllnessRecommendations->patchEntity($data, $requestData); 

    $sub = $this->request->getData('IllnessRecommendationSub');

    if ($this->IllnessRecommendations->save($data)) {

      $id = $data->id;

      if(!empty($sub)){
        
        foreach ($sub as $key => $value) {

          $sub[$key]['illness_recommendation_id'] = $id;
          
        }

        $subEntities = $this->IllnessRecommendationSubs->newEntities($sub);

        $this->IllnessRecommendationSubs->saveMany($subEntities);
      
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Illness Recommendation has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Illness Recommendation Management',

          'code' => $requestData['ailment'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Illness Recommendation cannot saved this time.',

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

    $data['IllnessRecommendation'] = $this->IllnessRecommendations->find()

      ->contain([

        'IllnessRecommendationSubs' => [

          'conditions' => ['IllnessRecommendationSubs.visible' => 1]

        ]

      ])

      ->where([

        'IllnessRecommendations.visible' => 1,

        'IllnessRecommendations.id' => $id

      ])

    ->first();

    $data['IllnessRecommendationSub'] = $data['IllnessRecommendation']['illness_recommendation_subs'];

    unset($data['IllnessRecommendation']['illness_recommendation_subs']);

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

    $data = $this->IllnessRecommendations->get($id); 

    $requestData = $this->getRequest()->getData('IllnessRecommendation');

    $this->IllnessRecommendations->patchEntity($data, $requestData); 

    $sub = $this->request->getData('IllnessRecommendationSub');

    if ($this->IllnessRecommendations->save($data)) {

      if(!empty($sub)){
        
        foreach ($sub as $key => $value) {

          $sub[$key]['illness_recommendation_id'] = $id;
          
        }

        $subEntities = $this->IllnessRecommendationSubs->newEntities($sub);

        $this->IllnessRecommendationSubs->saveMany($subEntities);
      
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Illness Recommendation has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Illness Recommendation Management',

          'code' => $requestData['ailment'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Illness Recommendation cannot updated this time.',

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

    $data = $this->IllnessRecommendations->get($id);

    $data->visible = 0;

    if ($this->IllnessRecommendations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Illness Recommendation has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Illness Recommendation Management',

          'code' => $data->ailment,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Illness Recommendation cannot be deleted at this time.'

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
