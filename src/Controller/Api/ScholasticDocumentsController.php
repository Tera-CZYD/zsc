<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class ScholasticDocumentsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->ScholasticDocuments = TableRegistry::getTableLocator()->get('ScholasticDocuments');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditionsPrint = '';

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $limit = 25;

    $tmpData = $this->ScholasticDocuments->paginate($this->ScholasticDocuments->getAllScholasticDocument($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $scholastic_documents = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($scholastic_documents as $data) {

      $datas[] = array(

        'id'            => $data['id'],

        'code'          => $data['code'],

        'title'   => $data['title'],

        'acronym'   => $data['acronym'],

        'serial'   => $data['serial'],

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

    $requestData = $this->request->getData('ScholasticDocument');

    $data = $this->ScholasticDocuments->newEmptyEntity();
   
    $data = $this->ScholasticDocuments->patchEntity($data, $requestData); 

    if ($this->ScholasticDocuments->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Scholastic Document has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Scholastic Document Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Scholastic Document cannot saved this time.',

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

    $data['ScholasticDocument'] = $this->ScholasticDocuments->find()

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

    $scholastic_document = $this->ScholasticDocuments->get($id); 

    $requestData = $this->getRequest()->getData('ScholasticDocument');

    $requestData['date'] = isset($requestData['date']) ? date('Y-m-d', strtotime($requestData['date'])) : null;

    $this->ScholasticDocuments->patchEntity($scholastic_document, $requestData); 

    if ($this->ScholasticDocuments->save($scholastic_document)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Scholastic Document has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Scholastic Document Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Scholastic Document cannot updated this time.',

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

    $data = $this->ScholasticDocuments->get($id);

    $data->visible = 0;

    if ($this->ScholasticDocuments->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Scholastic Document has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Scholastic Document cannot be deleted at this time.'

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
