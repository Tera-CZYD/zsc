<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class NurseProfilesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->NurseProfiles = TableRegistry::getTableLocator()->get('NurseProfiles');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('NurseProfiles');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllNurseProfile($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $nurse_profiles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($nurse_profiles as $nurse_profile) {

      $datas[] = array(

        'id'           => $nurse_profile['id'],

        'name'         => $nurse_profile['name'],

        'address'         => $nurse_profile['address'],

        'age'     => $nurse_profile['age'],

        'birthdate'               => fdate($nurse_profile['birthdate'],'m/d/Y'),

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

    $requestData = $this->request->getData('NurseProfile');

    $requestData['birthdate'] = isset($requestData['birthdate']) ? fdate($requestData['birthdate'],'Y-m-d') : NULL;

    $data = $this->NurseProfiles->newEmptyEntity();
   
    $data = $this->NurseProfiles->patchEntity($data, $requestData); 

    if ($this->NurseProfiles->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Nurse Profile has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Nurse Profile',

          'name' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Chart of Accounts cannot saved this time.',

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

    $data['NurseProfile'] = $this->NurseProfiles->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

    $data['NurseProfile']['birthdate'] = $data['NurseProfile']['birthdate']->format('m/d/Y');

    $data['NurseProfile']['active_view'] = $data['NurseProfile']['active'] ? 'True' : 'False';

    $data['NurseProfile']['floors'] = intval($data['NurseProfile']['floors']);

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

    $building = $this->NurseProfiles->get($id); 

    $requestData = $this->getRequest()->getData('NurseProfile');

    $requestData['birthdate'] = isset($requestData['birthdate']) ? fdate($requestData['birthdate'],'Y-m-d') : NULL;

    $this->NurseProfiles->patchEntity($building, $requestData); 

    if ($this->NurseProfiles->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Nurse Profile has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Nurse Profile',

          'name' => $requestData['name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Nurse Profile cannot updated this time.',

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

    $data = $this->NurseProfiles->get($id);

    $data->visible = 0;

    if ($this->NurseProfiles->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Nurse Profile has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Nurse Profile',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Nurse Profile cannot be deleted at this time.'

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
