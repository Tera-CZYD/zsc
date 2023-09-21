<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class  ClassSchedulesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->ClassSchedules = TableRegistry::getTableLocator()->get('ClassSchedules');

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

      $conditions['year'] = " AND ClassSchedule.school_year_start = '$search_date'"; 

      $dates['year'] = $search_date;

      $conditionsPrint .= '&year='.$search_date;

    }  

    $conditions['semester'] = '';

    if ($this->request->getQuery('semester') != null) {

      $semester = $this->request->getQuery('semester');

      $conditions['semester'] = " AND ClassSchedule.year_term_id = '$semester'"; 

      $conditionsPrint .= '&semester='.$semester;

    }


    $dataTable = TableRegistry::getTableLocator()->get('ClassSchedules');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllClassSchedule($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $classSchedules = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($classSchedules as $classSchedule) {

      $classScheduleDays = TableRegistry::getTableLocator()->get('classScheduleDays');

      $days = $classScheduleDays->find()
        
        ->where([
          
          'visible' => 1,

          'class_schedule_id' => $classSchedule['id'],

        ])

        ->toArray();

      $datas[] = array(

        'id'            => $classSchedule['id'],

        'code'          => $classSchedule['code'],

        'faculty_name'  => $classSchedule['faculty_name'],    

        'college'       => $classSchedule['name'], 

        'program'       => $classSchedule['program'],      

        'year_term'     => $classSchedule['description'],    

        'school_year'   => $classSchedule['school_year_start'].' - '.$classSchedule['school_year_end'],  

        'days'          => $days

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

    $requestData = $this->request->getData('ClassSchedule');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->ClassSchedules->newEmptyEntity();
   
    $data = $this->ClassSchedules->patchEntity($data, $requestData); 

    if ($this->ClassSchedules->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Class Schedule has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Class Schedule',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Class Schedule cannot saved this time.',

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

    $data['ClassSchedule'] = $this->ClassSchedules->find()

      ->where([

        'ClassSchedules.visible' => 1,

        'ClassSchedules.id' => $id

      ])

      ->contain([

        'YearLevelTerms',

        'ClassScheduleDays',

        'ClassScheduleSubs',

        'ClassScheduleTmps',

        'Colleges'

      ])

      ->first();

    $data['YearLevelTerm'] = $data['ClassSchedule']['year_level_term'];

    unset($data['ClassSchedule']['year_level_term']);

    $data['College'] = $data['ClassSchedule']['college'];

    unset($data['ClassSchedule']['college']);

    $data['ClassScheduleDay'] = $data['ClassSchedule']['class_schedule_days'];

    unset($data['ClassSchedule']['class_schedule_days']);

    $data['ClassScheduleSub'] = $data['ClassSchedule']['class_schedule_subs'];

    unset($data['ClassSchedule']['class_schedule_subs']);

    $data['ClassScheduleTmps'] = $data['ClassSchedule']['class_schedule_tmps'];

    unset($data['ClassSchedule']['class_schedule_tmps']);

    $data['ClassSchedule']['active_view'] = $data['ClassSchedule']['active'] ? 'True' : 'False';

    // $data['ClassSchedule']['date'] = $data['ClassSchedule']['date']->format('m/d/Y');

    $data['ClassSchedule']['floors'] = intval($data['ClassSchedule']['floors']);

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

    $building = $this->ClassSchedules->get($id); 

    $requestData = $this->getRequest()->getData('ClassSchedule');

    $this->ClassSchedules->patchEntity($building, $requestData); 

    if ($this->ClassSchedules->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Class Schedule has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Class Schedule',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Class Schedule cannot updated this time.',

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

    $data = $this->ClassSchedules->get($id);

    $data->visible = 0;

    if ($this->ClassSchedules->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Class Schedule Management has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Class Schedule Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Class Schedule Management cannot be deleted at this time.'

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
