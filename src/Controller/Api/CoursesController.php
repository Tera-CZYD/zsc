<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class CoursesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->Courses = TableRegistry::getTableLocator()->get('Courses');

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

    $conditions['year'] = '';

    if ($this->request->getQuery('year')) {

      $search_date = $this->request->getQuery('year');

      $conditions['year'] = " AND Course.year_implementation = '$search_date'"; 

      $dates['year'] = $search_date;

      $conditionsPrint .= '&year='.$search_date;

    }  

    $conditions['semester'] = '';

    if ($this->request->getQuery('semester') != null) {

      $semester = $this->request->getQuery('semester');

      $conditions['date'] = " AND Course.year_term_id = '$semester'"; 

      $conditionsPrint .= '&semester='.$semester;

    }

    //advance search

    $dataTable = TableRegistry::getTableLocator()->get('Courses');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllCourse($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $courses = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($courses as $course) {

      $datas[] = array(

        'id'           => $course['id'],

        'code'         => $course['code'],

        'title'         => $course['title'],

        'year_implementation'          =>$course['year_implementation'],

        'semester'      => $course['yearDescription']

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

    $requestData = $this->request->getData('Course');

    $data = $this->Courses->newEmptyEntity();
   
    $data = $this->Courses->patchEntity($data, $requestData); 

    if ($this->Courses->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Course has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Course Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Course cannot saved this time.',

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

    $data['Course'] = $this->Courses->find()

      ->contain([

        'YearLevelTerms'

      ])

      ->where([

        'Courses.visible' => 1,

        'Courses.id' => $id

      ])

      ->first();

      $data['YearTermLevel'] = $data['Course']['year_level_term'];

      unset($data['Course']['year_level_term']);

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

    $course = $this->Courses->get($id); 

    $requestData = $this->getRequest()->getData('Course');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->Courses->patchEntity($course, $requestData); 

    if ($this->Courses->save($course)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Course has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Course Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Course cannot updated this time.',

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

    $data = $this->Courses->get($id);

    $data->visible = 0;

    if ($this->Courses->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Course Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'Course has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Course cannot be deleted at this time.'

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
