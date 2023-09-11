<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class StudentLogsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->StudentLogs = TableRegistry::getTableLocator()->get('StudentLogs');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('StudentLogs');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllStudentLog($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $studentLogs = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($studentLogs as $studentLog) {

      $member_name = '';

      if($studentLog['student_name'] != null){

        $member_name = $studentLog['student_name'];

      }elseif($studentLog['employee_name'] != null){

        $member_name = $studentLog['employee_name'];

      }elseif($studentLog['admin_name'] != null){

        $member_name = $studentLog['admin_name'];

      }

      $datas[] = array(

        'id'           => $studentLog['id'],

        'patient_name'         => $member_name,

        'date'               => fdate($studentLog['date'],'m/d/Y'),

        'time'     => $studentLog['time'],

        'concern'   => $studentLog['concern'],

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

    $requestData = $this->request->getData('StudentLog');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->StudentLogs->newEmptyEntity();
   
    $data = $this->StudentLogs->patchEntity($data, $requestData); 

    if ($this->StudentLogs->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Student Log has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Student Log',

          'member_name' => $requestData['student_name'] != null ? $requestData['student_name'] : $requestData['employee_name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Log cannot saved this time.',

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

    $data['StudentLog'] = $this->StudentLogs->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

    $data['StudentLog']['active_view'] = $data['StudentLog']['active'] ? 'True' : 'False';

    $data['StudentLog']['floors'] = intval($data['StudentLog']['floors']);

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

    $studentLogs = $this->StudentLogs->get($id); 

    $requestData = $this->getRequest()->getData('StudentLog');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->StudentLogs->patchEntity($studentLogs, $requestData); 

    if ($this->StudentLogs->save($studentLogs)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Student Logs has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Student Logs',

          'member_name' => $requestData['student_name'] != null ? $requestData['student_name'] : $requestData['employee_name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Logs cannot updated this time.',

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

    $data = $this->StudentLogs->get($id);

    $data->visible = 0;

    if ($this->StudentLogs->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Logs has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Student Logs',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Logs cannot be deleted at this time.'

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
