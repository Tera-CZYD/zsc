<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class ProgramAdvisersController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->ProgramAdvisers = TableRegistry::getTableLocator()->get('ProgramAdvisers');

    $this->BlockSections = TableRegistry::getTableLocator()->get('BlockSections');

    $this->StudentEnrollments = TableRegistry::getTableLocator()->get('StudentEnrollments');

    $this->BlockSectionCourses = TableRegistry::getTableLocator()->get('BlockSectionCourses');

    $this->BlockSectionSchedules = TableRegistry::getTableLocator()->get('BlockSectionSchedules');

    $this->StudentEnrolledSchedules = TableRegistry::getTableLocator()->get('StudentEnrolledSchedules');

    $this->StudentEnrolledCourses = TableRegistry::getTableLocator()->get('StudentEnrolledCourses');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if($this->request->getQuery('search') != null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search'.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')!= null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentApplication.approved_date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')!= null) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentApplication.approved_date) >= '$start' AND DATE(StudentApplication.approved_date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['year_term_id'] = 0; 

    if($this->request->getQuery('year_term_id') != null) {

      $year_term_id = $this->request->getQuery('year_term_id');

      $conditions['year_term_id'] = $year_term_id; 

      $conditionsPrint .= '&year_term_id='.$year_term_id;

    }

    $conditions['status'] = '';

    if($this->request->getQuery('status') != null) {

      $status = $this->request->getQuery('status');

      if($status == 0){

        $conditions['status'] = "AND (StudentEnrollment.enrollmentCount = 0 OR StudentEnrollment.enrollmentCount IS NULL)";

      }else{

        $conditions['status'] = "AND StudentEnrollment.enrollmentCount > 0";

      }

      $conditionsPrint .= '&status='.$status;

    }

    $limit = 25;

    $tmpData = $this->ProgramAdvisers->paginate($this->ProgramAdvisers->getAllProgramAdviser($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $main = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($main as $data) {

      $block_sections = array();

      if($status == 0){

        $tmp_block_sections = $this->BlockSections->find()

          ->where([

            'visible' => 1,

            'college_id' => $data['college_id'],

            'program_id' => $data['program_id'],

          ])

        ->all();

        if(!empty($tmp_block_sections)){

          foreach ($tmp_block_sections as $key => $value) {
            
            $slot = $this->BlockSectionCourses->find()

              ->where([

                'visible' => 1,

                'block_section_id' => $value['id']

              ])

            ->first();

            $block_sections[] = array(

              'id'         => $value['id'],

              'section_id' => $value['section_id'],

              'section'    => $value['section'],

              'available_slot' => $slot['slot'] - $slot['enrolled_students']

            );

          }

        }

      }

      $datas[] = array(

        'id'                => $data['student_id'],

        'student_no'        => $data['student_no'],

        'year_term_id'      => $data['year_term_id'],

        'student_name'      => $data['full_name'],

        'program'           => $data['name'],

        'rate'              => $data['rate'],

        'block_sections'    => $block_sections,

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

  public function enlist($id = null) {

    $this->autoRender = false;

    $main = $this->request->getData();

    //STUDENT ENROLLMENT

      $student_enrollment['student_id'] = $main['id'];

      $student_enrollment['student_no'] = $main['student_no'];

      $student_enrollment['student_name'] = $main['student_name'];

      $student_enrollment['year_term_id'] = $main['year_term_id'];

      $student_enrollment['date'] = date('Y-m-d');

    //END STUDENT ENROLLMENT

    $data = $this->StudentEnrollments->newEmptyEntity();
   
    $data = $this->StudentEnrollments->patchEntity($data, $student_enrollment); 

    if($this->StudentEnrollments->save($data)) {
      
      //STUDENT ENROLLED COURSE

        $block_section_courses = $this->BlockSectionCourses->find()

          ->where([

            'visible' => 1,

            'block_section_id' => $main['selected_block_section_id']

          ])

        ->all();

        $student_enrolled_course = array();

        if(!empty($block_section_courses)){

          foreach ($block_section_courses as $key => $value) {

            $course = $value['course'];

            //STUDENT ENROLLED SCHEDULE

              $block_section_schedules = $this->BlockSectionSchedules->find()

                ->where([

                  'visible' => 1,

                  'block_section_id' => $main['selected_block_section_id'],

                  'block_section_course_id' => $value['id'],

                ])

              ->all();

              $student_enrolled_schedules = array();

              if(!empty($block_section_schedules)){

                foreach ($block_section_schedules as $keys => $values) {

                  $student_enrolled_schedules[] = array(

                    'student_id'                 => $main['id'],

                    'course_id'                  => $value['course_id'],

                    'course'                     => $course,

                    'block_section_schedule_id'  => $values['id'],

                    'faculty_id'                 => $value['faculty_id'],

                    'faculty_name'               => $value['faculty_name'],

                    'year_term_id'               => $main['year_term_id'],

                    'day'                        => $values['day'],

                    'room_id'                    => $value['room_id'],

                    'room'                       => $value['room'],

                    'time_start'                 => $values['time_start'],

                    'time_end'                   => $values['time_end'],

                    'section_id'                 => $main['selected_section_id'],

                    'section'                    => $main['selected_section'],

                  );

                }

                $studentEnrolledSchedulesEntities = $this->StudentEnrolledSchedules->newEntities($student_enrolled_schedules);

                $this->StudentEnrolledSchedules->saveMany($studentEnrolledSchedulesEntities);

              }

            //END STUDENT ENROLLED SCHEDULE

            $student_enrolled_course[] = array(

              'student_id'   => $main['id'],

              'course_id'    => $value['course_id'],

              'course_code'  => $value['course_code'],

              'course'       => $course,

              'year_term_id' => $main['year_term_id'],

              'section_id'   => $main['selected_section_id'],

              'section'      => $main['selected_section'],

              'faculty_id'   => $value['faculty_id'],

              'faculty_name' => $value['faculty_name'],

            );

          }

          $studentEnrolledCourseEntities = $this->StudentEnrolledCourses->newEntities($student_enrolled_course);

          $this->StudentEnrolledCourses->saveMany($studentEnrolledCourseEntities);

        }

      //END STUDENT ENROLLED COURSE

      $response = array(

        'ok'  =>true,

        'msg' =>'Enlistment has been successfully saved.',

        'data'=>$main

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
          
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Enlistment',

        'userId' => $this->Auth->user('id'),

        'description' => 'Program Adviser',

        'code' => $main['student_no'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity); 
      
    } else {

      $response = array(

        'ok'  =>true,

        'data'=>$main,

        'msg' =>'Enlistment cannot saved this time.',

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

}
