<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class ProspectusesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Prospectuses = TableRegistry::getTableLocator()->get('Prospectuses');

    $this->Students = TableRegistry::getTableLocator()->get('Students');

    $this->YearLevelTerms = TableRegistry::getTableLocator()->get('YearLevelTerms');

    $this->CollegeProgramCourses = TableRegistry::getTableLocator()->get('CollegeProgramCourses');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditions['search'] = '';

    $conditionsPrint = '';

       if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->query['endDate'];

      $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['college_id'] = '';

    if ($this->request->getQuery('college_id')) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['program_id'] = '';

    if ($this->request->getQuery('program_id')) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND Student.program_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

    }

    $conditions['year_term_id'] = '';

    if ($this->request->getQuery('year_term_id')) {

      $year_term_id = $this->request->getQuery('year_term_id'); 

      $conditions['year_term_id'] = " AND StudentEnrollment.year_term_id = $year_term_id";

      $conditionsPrint .= '&year_term_id='.$year_term_id;

    }

    $dataTable = TableRegistry::getTableLocator()->get('Prospectuses');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllProspectus($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $prospectuses = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($prospectuses as $prospectus) {

      $datas[] = array(

        'id'          => $prospectus['student_id'],

        'full_name'   => $prospectus['full_name'],

        'student_no'  => $prospectus['student_no'],

        'college'     => $prospectus['college'],

        'program'     => $prospectus['program'],

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

  public function view($id = null){

    $data['Student'] = $this->Students->find()

      ->contain([

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

    $data['Student']['proper_name'] = $data['Student']['last_name'].', '.$data['Student']['first_name'].' '.$data['Student']['middle_name'];

    $data['College'] = $data['Student']['college'];

    $data['CollegeProgram'] = $data['Student']['college_program'];

    $data['StudentEnrolledCourse'] = $data['Student']['student_enrolled_courses'];

    $data['StudentEnrolledUnit'] = $data['Student']['student_enrolled_units'];

    $data['StudentEnrollment'] = $data['Student']['student_enrollments'];

    unset($data['Student']['college']);

    unset($data['Student']['college_program']);
    
    unset($data['Student']['student_enrolled_courses']);

    unset($data['Student']['student_enrolled_units']);

    unset($data['Student']['student_enrollments']);

    $prospectus = array();

    $year_term = $this->YearLevelTerms->find()

      ->where([

        'YearLevelTerms.visible' => 1,

        'YearLevelTerms.active_prospectus' => 1

      ])

    ->all();

    if($year_term != null){

      foreach ($year_term as $keys => $values) {

        $subs = array();
        
        if($data['StudentEnrolledCourse']!=null){

          foreach ($data['StudentEnrolledCourse'] as $key => $value) {
            
            if($values['id'] == $value['year_term_id']){

              $program_id = $data['Student']['program_id'];

              $course_id = $value['course_id'];

              $year_term_id = $value['year_term_id'];              

              $result = "

                SELECT 

                  CollegeProgramPrerequisite.course_id

                FROM  

                  college_program_courses as CollegeProgramCourse LEFT JOIN 

                  college_program_prerequisites as CollegeProgramPrerequisite ON CollegeProgramPrerequisite.college_program_course_id = CollegeProgramCourse.id 

                WHERE 

                  CollegeProgramCourse.visible = true AND 

                  CollegeProgramCourse.course_id = $course_id AND 

                  CollegeProgramCourse.college_program_id = $program_id AND 

                  CollegeProgramCourse.year_term_id = $year_term_id AND 

                  CollegeProgramPrerequisite.visible = true

              ";

              $course_prerequisites = array();

              $connection = $this->CollegeProgramCourses->getConnection();

              $prerequisites = $connection->execute($result)->fetchAll('assoc');


              if($prerequisites!=null){

                foreach ($prerequisites as $index => $datas) {

                  $courses = $this->Courses->get($datas['CollegeProgramPrerequisite']['course_id']);
                  
                  $course_prerequisites[] = array(

                    'course'            => $courses['Course']['title'],

                  );

                }

              }

              $subs[] = array(

                'final'            => $value['final_grade'],

                'course_code'      => $value['course_code'],

                'course'           => $value['course'],

                'lecture_hours'    => $value['lecture_hours'],

                'laboratory_hours' => $value['laboratory_hours'],

                'credit_unit'      => $value['credit_unit'],

                'course_prerequisites' => $course_prerequisites

              );

            }

          }

        }

        $prospectus[] = array(

          'semester' => $values['semester'],

          'year'     => $values['year'],

          'subs'     => $subs,

        );

      }

    }


    $response = [

      'ok' => true,

      'data' => $data,

      'prospectus' => $prospectus,

    ];

    $this->set([

      'response' => $response,

      '_serialize' => 'response'

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

}