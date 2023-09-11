<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class StudentAttendancesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->StudentAttendances = TableRegistry::getTableLocator()->get('StudentAttendances');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('StudentAttendances');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllStudentAttendance($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $studentAttendances = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($studentAttendances as $studentAttendance) {

      $datas[] = array(

        'id'          => $studentAttendance['id'],

        'full_name'   => $studentAttendance['full_name'],

        'student_no'  => $studentAttendance['student_no'],

        'college'     => $studentAttendance['college'],

        'program'     => $studentAttendance['program'],
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

    $requestData = $this->request->getData('GoodMoral');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->GoodMorals->newEmptyEntity();
   
    $data = $this->GoodMorals->patchEntity($data, $requestData); 

    if ($this->GoodMorals->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Good Moral Certificate has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Good Moral Certificate',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Good Moral Certificate cannot saved this time.',

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

    $data['StudentAttendance'] = $this->StudentAttendances->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();


    $data['StudentAttendance']['active'] = $data['StudentAttendance']['active'] ? 'True' : 'False';

    // $data['studentAttendance']['date'] = $data['studentAttendance']['date']->format('m/d/Y');

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

    $building = $this->GoodMorals->get($id); 

    $requestData = $this->getRequest()->getData('GoodMoral');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->GoodMorals->patchEntity($building, $requestData); 

    if ($this->GoodMorals->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Good Moral Certificate has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Good Moral Certificate',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Good Moral Certificate cannot updated this time.',

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

    $data = $this->GoodMorals->get($id);

    $data->visible = 0;

    if ($this->GoodMorals->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Good Moral Certificate has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Good Moral Certificate',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Good Moral Certificate cannot be deleted at this time.'

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

  public function api_view_attendance($id = null, $subId = null){

    $blockSectionTable = $this->getTableLocator()->get('BlockSections');

    $data = $blockSectionTable->find()

        ->contain([

            'BlockSectionCourses' => function ($query) use ($subId) {

                return $query->where([

                    'BlockSectionCourses.visible' => 1,

                    'BlockSectionCourses.id' => $subId

                ]);

            },

            'BlockSectionSchedules' => function ($query) use ($subId) {

                return $query->where([

                    'BlockSectionSchedules.visible' => 1,

                    'BlockSectionSchedules.block_section_course_id' => $subId

                ]);

            }

        ])

        ->where([

            'BlockSections.visible' => true,

            'BlockSections.id' => $id

        ])

        ->first();

    $response = [

        'ok' => true,

        'data' => $data,

    ];

    $this->set([

        'response' => $response,

        '_serialize' => 'response'

    ]);

  }

}
