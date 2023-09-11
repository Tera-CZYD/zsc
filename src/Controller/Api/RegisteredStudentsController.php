<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class RegisteredStudentsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->RegisteredStudents = TableRegistry::getTableLocator()->get('RegisteredStudents');

    $this->Students = TableRegistry::getTableLocator()->get('Students');

    $this->StudentEnrolledSchedules = TableRegistry::getTableLocator()->get('StudentEnrolledSchedules');

  }

  public $uses = array(

    'RegisteredStudent',

    'Student',

    'ClassSchedule',

    'ClassScheduleSub',

    'ClassScheduleDay',

    'StudentEnrolledSchedule',

  );
  
  public function index(){

    // default page 1

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1; 
    
    // default conditions

    $conditionsPrint = '';

    $conditions = array();

    $conditions['search'] = '';

    // search conditions

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    if ($this->request->getQuery('year_term_id')) {

      $year_term_id = $this->request->getQuery('year_term_id');

      $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

      $conditionsPrint .= '&year_term_id=' . $year_term_id;
      
    }

    $dataTable = TableRegistry::getTableLocator()->get('RegisteredStudents');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllRegisteredStudent($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $registered_students = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($registered_students as $data) {

      $datas[] = array(

        'id'          => $data['student_id'],

        'full_name'   => $data['full_name'],

        'student_no'  => $data['student_no'],

        'college'     => $data['college'],

        'program'     => $data['program'],

        'email'     => $data['email'],

        'contact_no'     => $data['contact_no'],

        'description'     => $data['description'],

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

  public function view($id = null){

    $student = $this->Students->find()
    ->contain([
        'YearLevelTerms',

        'Colleges' => function ($q) {

            return $q->where(['Colleges.visible' => 1]);

        },

        'CollegePrograms' => function ($q) {

            return $q->where(['CollegePrograms.visible' => 1]);

        },

        'StudentEnrolledCourses' => function ($q) {

            return $q->where(['StudentEnrolledCourses.visible' => 1]);

        },

        'StudentEnrolledUnits' => function ($q) {

            return $q->where(['StudentEnrolledUnits.visible' => 1]);

        },

        'StudentEnrollments' => function ($q) {

            return $q->where(['StudentEnrollments.visible' => 1]);

        },

    ])

    ->where([

        'Students.visible' => 1,

        'Students.id' => $id,

    ])

    ->first();

        // debug($student);

        if ($student) {

            $data['YearLevelTerm'] = $student->year_level_term;

            $data['CollegeProgram'] = $student->college_program;

            $data['StudentEnrolledCourse'] = $student->student_enrolled_courses;

            $data['StudentEnrolledUnit'] = $student->student_enrolled_units;

            $data['StudentEnrollment'] = $student->student_enrollments;

            $data['College'] = $student->college;

            unset($student->year_level_term);

            unset($student->college_program);

            unset($student->student_enrolled_course);

            unset($student->student_enrolled_unit);

            unset($student->student_enrollment);

            unset($student->college);

            $data['Student'] = $student;

          }

      if (!empty($data['StudentEnrolledCourse'])) {

          foreach ($data['StudentEnrolledCourse'] as $key => $value) {

              $schedule = $this->StudentEnrolledSchedules->find()

                  ->where([

                      'visible' => 1,

                      'course_id' => $value['course_id'],

                      'student_id' => $id,

                  ])

                  ->all();

              $subs = [];

              if (!empty($schedule)) {

                  foreach ($schedule as $keys => $values) {

                      $subs[] = [

                          'days' => $values->day,

                          'time' => date('h:i A', strtotime($values->time_start))

                              . ' - ' . date('h:i A', strtotime($values->time_end)),

                          'room' => $values->room,

                          'faculty_name' => $values->faculty_name,

                      ];

                  }

              }

              $data['StudentEnrolledCourse'][$key]['subs'] = $subs;

          }

      }


    $response = array(

      'ok'   => true,

      'data' => $data,

    );

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }
   
}