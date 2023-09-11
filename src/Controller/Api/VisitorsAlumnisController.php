<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class VisitorsAlumnisController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->VisitorsAlumnis = TableRegistry::getTableLocator()->get('VisitorsAlumnis');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditionsPrint = '';

    $conditions = [];

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $dataTable = $this->VisitorsAlumnis;

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllVisitorsAlumni($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $alumnis = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($alumnis as $alumni) {

      $datas[] = array(

        'id'     => $alumni['id'],

        'name'   => $alumni['name'],

        'school' => $alumni['name_of_school']

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

    $requestData = $this->request->getData('VisitorsAlumni');

    $data = $this->VisitorsAlumnis->newEmptyEntity();
   
    $data = $this->VisitorsAlumnis->patchEntity($data, $requestData); 

    if ($this->VisitorsAlumnis->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Visitor Alumni has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Visitor Alumni Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Visitor Alumni cannot saved this time.',

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

    $data['VisitorsAlumni'] = $this->VisitorsAlumnis->find()

      ->where([

        'VisitorsAlumnis.visible' => 1,

        'VisitorsAlumnis.id' => $id

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

    $member = $this->VisitorsAlumnis->get($id); 

    $requestData = $this->getRequest()->getData('VisitorsAlumni');

    $this->VisitorsAlumnis->patchEntity($member, $requestData); 

    if ($this->VisitorsAlumnis->save($member)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Visitor Alumni has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Visitor Alumni Management',

          'code' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Visitor Alumni cannot updated this time.',

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

    $data = $this->VisitorsAlumnis->get($id);

    $data->visible = 0;

    if ($this->VisitorsAlumnis->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Visitor Alumni has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Visitor Alumni Management',

          'code' => '',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Visitor Alumni cannot be deleted at this time.'

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
