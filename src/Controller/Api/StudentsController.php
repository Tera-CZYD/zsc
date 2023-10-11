<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class StudentsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Student = TableRegistry::getTableLocator()->get('Students');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    $header = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $conditions['search'] = strtolower($search);

      $conditionsPrint .= '&search='.$search;

      $header .= ' SEARCH : '.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Student.created) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

      $header .= ' DATE : '.fdate($search_date,'F d, Y');

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Student.created) >= '$start' AND DATE(Student.created) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

      $header .= ' RANGE : '.fdate($start,'F d, Y').' - '.fdate($end,'F d, Y');

    }

    $conditions['college_id'] = '';

    if ($this->request->getQuery('college_id')) {

      $college_id = $this->request->getQuery('college_id');

      $conditions['college_id'] = "AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

      $collegeData = $this->College->findById($college_id);

      $header .= ' COLLEGE : '.$collegeData['College']['name'];

    }

    $conditions['degree_id'] = '';

    if ($this->request->getQuery('degree_id')) {

      $degree_id = $this->request->getQuery('degree_id');

      $conditions['degree_id'] = "AND Student.degree_id = $degree_id";

      $conditionsPrint .= '&degree_id='.$degree_id;

      $degreeData = $this->Degree->findById($degree_id);

      $header .= ' DEGREE : '.$degreeData['Degree']['name'];

    }

    $limit = 25;

    $tmpData = $this->Student->paginate($this->Student->getAllStudent($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $StudentBehavior = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($StudentBehavior as $data) {

      $datas[] = array(
          
         'id'           => $data['id'],

         'student_no'   => $data['student_no'],

         'first_name'   => $data['first_name'],

         'middle_name'  => $data['middle_name'],

         'last_name'    => $data['last_name'],

         'college'      => $data['c_name'],

         'program_name' => $data['program_name'],

         'year_level'   => $data['year_level'],

         'student_name' => $data['full_name'],

         'regular'      => $data['regular_yes'] ? 'True' : 'False',

         'active'       => $data['active'] ? 'True' : 'False'

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

    $requestData = $this->request->getData('StudentBehavior');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->StudentBehavior->newEmptyEntity();
   
    $data = $this->StudentBehavior->patchEntity($data, $requestData); 

    if ($this->StudentBehavior->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Student Behavior has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Student Behavior Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Behavior cannot saved this time.',

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

    $data['Student'] = $this->Student->find()

      ->contain([

        'YearLevelTerms',

        'Curriculums' => [

          'conditions' => [

            'Curriculums.visible' => 1

          ]

        ],

        'Colleges' => [
       
          'conditions' => [

            'Colleges.visible' => 1

          ]

        ],

        'CollegePrograms' => [
      
            'conditions' => [
      
                'CollegePrograms.visible' => 1
      
            ]
      
        ],
      
        'StudentEnrolledCourses' => [
      
            'conditions' => [
      
                'StudentEnrolledCourses.visible' => 1
      
            ]
      
        ],
      
        'StudentEnrolledUnits' => [
      
            'conditions' => [
      
                'StudentEnrolledUnits.visible' => 1
      
            ]
      
        ],
      
        'StudentEnrolledSchedules' => [
      
            'conditions' => [
      
                'StudentEnrolledSchedules.visible' => 1
      
            ]
      
        ],
      
        'StudentEnrollments' => [
      
            'conditions' => [
      
                'StudentEnrollments.visible' => 1
      
            ]
      
        ]

      ])

      ->where([

        'Students.visible' => 1,

        'Students.id' => $id

      ])

    ->first();

      $data['Student']['date_of_date'] = isset($data['Student']['date_of_date']) ? date('m/d/Y', strtotime($data['Student']['date_of_date'])) : null;

      $data['Student']['full_name'] = $data['Student']['last_name'].', '.$data['Student']['first_name'].' '.$data['Student']['middle_name'];


      $data['YearLevelTerm'] = $data['Student']['year_level_term'];

      $data['Curriculum'] = $data['Student']['curriculum'];

      // $data['StudentProfile'] = $data['Student']['student_profile'];

      $data['College'] = $data['Student']['college'];

      $data['CollegeProgram'] = $data['Student']['college_program'];

      $data['StudentEnrolledCourse'] = $data['Student']['student_enrolled_courses'];

      $data['StudentEnrolledUnit'] = $data['Student']['student_enrolled_units'];

      $data['StudentEnrolledSchedule'] = $data['Student']['student_enrolled_schedules'];

      $data['StudentEnrollment'] = $data['Student']['student_enrollments'];

      unset($data['Student']['year_level_term']);
      
      unset($data['Student']['curriculum']);

      // unset($data['Student']['student_profile']);
      
      unset($data['Student']['college']);

      unset($data['Student']['college_program']);
      
      unset($data['Student']['student_enrolled_courses']);

      unset($data['Student']['student_enrolled_units']);
      
      unset($data['Student']['student_enrolled_schedules']);

      unset($data['Student']['student_enrollments']);

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

    $data = $this->StudentBehavior->get($id); 

    $requestData = $this->getRequest()->getData('StudentBehavior');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->StudentBehavior->patchEntity($data, $requestData); 

    if ($this->StudentBehavior->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' => 'Student Behavior has been successfully updated.',

        'data'=> $requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Student Behavior',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Student Behavior cannot updated this time.',

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

    $data = $this->StudentBehavior->get($id);

    $data->visible = 0;

    if ($this->StudentBehavior->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Behavior has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Behavior cannot be deleted at this time.'

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
