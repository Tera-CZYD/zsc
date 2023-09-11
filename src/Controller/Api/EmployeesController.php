<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class EmployeesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Employees = TableRegistry::getTableLocator()->get('Employees');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

     $conditions['search'] = '';

     $conditionsPrint = '';

    if ($this->request->getQuery('search')!=null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $conditions['college_id'] = '';

    if($this->request->getQuery('college_id')!=null){

      $college_id = $this->request->getQuery('college_id');

      $conditions['college_id'] = "AND Employee.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['specialization_id'] = '';

    if($this->request->getQuery('specialization_id')!=null){

      $specialization_id = $this->request->getQuery('specialization_id');

      $conditions['specialization_id'] = "AND Employee.specialization_id = $specialization_id";

      $conditionsPrint .= '&specialization_id='.$specialization_id;

    }

    $dataTable = TableRegistry::getTableLocator()->get('Employees');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllEmployee($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $employees = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($employees as $employee) {

      $datas[] = array(

        'id'           => $employee['id'],

        'code'         => $employee['code'],

        'family_name'         => $employee['family_name'],

        'given_name'         => $employee['given_name'],

        'middle_name'         => $employee['middle_name'],

        'gender'         => $employee['family_name'],

        'birthdate'         => $employee['family_name'],

        'academic_rank'         => $employee['family_name'],

        'college'         => $employee['college_id'],

        'specialization'         => $employee['specialization_id'],

        'active' => $employee['active'] == 1 ? 'ACTIVE' : 'NOT ACTIVE',

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

    $requestData = $this->request->getData('Employee');

    $data = $this->Employees->newEmptyEntity();

    $requestData['birthdate'] = date('Y-m-d', strtotime($requestData['birthdate']));
    
   
    $data = $this->Employees->patchEntity($data, $requestData); 

    // var_dump($data);


    if ($this->Employees->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Employee has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Employee Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Employee cannot saved this time.',

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

    $data = $this->Employees->find()

      ->contain([

          'Colleges' => [

            'conditions' => [

              'Colleges.visible' => 1

            ],

          ],


          'Specializations' => [

            'conditions' => [

              'Specializations.visible' => 1

            ],

          ]

      ])

      ->where([

        'Employees.visible' => 1,

        'Employees.id' => $id

      ])

      ->first();


    $data['birthdate'] = !is_null($data['birthdate']) ? date('m/d/Y', strtotime($data['birthdate'])) : null;

    $employeeData = $data->toArray();

    unset($employeeData['College']);

    $data = [

      'Employee' => $employeeData,

      'College'  => $data['College'],

      'Specialization' => $data['specialization'],

    ];

    unset($data['Employee']['specialization']);

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

    $employee = $this->Employees->get($id); 

    $requestData = $this->getRequest()->getData('Employee');

    $requestData['birthdate'] = isset($requestData['birthdate']) ? date('Y-m-d', strtotime($requestData['birthdate'])) : null;

    $this->Employees->patchEntity($employee, $requestData); 

    if ($this->Employees->save($employee)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Employee has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Employee Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Employee cannot updated this time.',

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

    $data = $this->Employees->get($id);

    $data->visible = 0;

    if ($this->Employees->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Employee Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'Employee has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Employee cannot be deleted at this time.'

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
