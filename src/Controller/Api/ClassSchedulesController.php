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

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->ClassSchedules = TableRegistry::getTableLocator()->get('ClassSchedules');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditions['search'] = '';

    $conditionsPrint = '';

    if ($this->request->getQuery('search')) {

        $search = strtolower($this->request->getQuery('search'));

        $conditions['search'] = $search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

        $search_date = $this->request->getQuery('date');

        $conditions['date'] = " AND DATE(ClassSchedule.created) = '$search_date'";

        $dates['date'] = $search_date;

        $conditionsPrint .= '&date=' . $search_date;

    }

    $conditions['advSearch'] = '';

    if ($this->request->getQuery('faculty')) {

        $faculty_id = $this->request->getQuery('faculty');

        $conditions['advSearch'] .= " AND ClassSchedule.faculty_id = $faculty_id";

        $conditionsPrint .= '&faculty=' . $faculty_id;

    }

    if ($this->request->getQuery('college')) {

        $college_id = $this->request->getQuery('college');

        $conditions['advSearch'] .= " AND ClassSchedule.college_id = $college_id";

        $conditionsPrint .= '&college=' . $college_id;

    }

    if ($this->request->getQuery('program')) {

        $program_id = $this->request->getQuery('program');

        $conditions['advSearch'] .= " AND ClassSchedule.program_id = $program_id";

        $conditionsPrint .= '&program=' . $program_id;

    }

    if ($this->request->getQuery('year_term')) {

        $year_term_id = $this->request->getQuery('year_term');

        $conditions['advSearch'] .= " AND ClassSchedule.year_term_id = $year_term_id";

        $conditionsPrint .= '&year_term=' . $year_term_id;

    }

    if ($this->request->getQuery('school_year')) {

        $school_year = $this->request->getQuery('school_year');

        $conditions['advSearch'] .= " AND ClassSchedule.school_year_start = $school_year";

        $conditionsPrint .= '&school_year=' . $school_year;

    }

    if ($this->request->getQuery('startDate') && $this->request->getQuery('endDate')) {

        $start = $this->request->getQuery('startDate');

        $end = $this->request->getQuery('endDate');

        $conditions['date'] = " AND DATE(ClassSchedule.created) >= '$start' AND DATE(ClassSchedule.created) <= '$end'";

        $dates['startDate'] = $start;

        $dates['endDate'] = $end;

        $conditionsPrint .= '&startDate=' . $start . '&endDate=' . $end;

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

      $datas[] = array(

        'id'            => $classSchedule['id'],

        'code'          => $classSchedule['code'],

        'faculty_name'  => $classSchedule['faculty_name'],    

        'college'       => $classSchedule['name'], 

        'program'       => $classSchedule['program'],      

        'year_term'     => $classSchedule['description'],    

        'school_year'   => $classSchedule['school_year_start'].' - '.$classSchedule['school_year_end'],  

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
