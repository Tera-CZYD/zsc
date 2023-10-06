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

    $this->Assessments = TableRegistry::getTableLocator()->get('Assessments');  

    $this->AssessmentSubs = TableRegistry::getTableLocator()->get('AssessmentSubs'); 

    $this->Students = TableRegistry::getTableLocator()->get('Students');

    $this->Accounts = TableRegistry::getTableLocator()->get('Accounts');

    $this->Courses = TableRegistry::getTableLocator()->get('Courses');

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

            'visible'      => 1,

            'college_id'   => $data['college_id'],

            'program_id'   => $data['program_id'],

            'year_term_id' => $data['year_term_id'],

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

            // debug($slot);

            $availableSlot = isset($slot) ? $slot['slot'] - $slot['enrolled_students'] : null;

            $block_sections[] = array(

              'id'         => $value['id'],

              'section_id' => $value['section_id'],

              'section'    => $value['section'],

              'available_slot' => $availableSlot

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

      $query = $this->Assessments->find();

      $query->select(['total' => $query->func()->count('*')]);

      $total = $query->firstOrFail()->total;

      $code = 'ASS-' . str_pad($total + 1, 5, "0", STR_PAD_LEFT);

      $id = $main['id']; 

      $student['Student'] = $this->Students->find()

        ->contain([

          'CollegePrograms' => [

            'conditions' => [

              'CollegePrograms.visible' => 1,

            ]

          ]

        ])

        ->where(['Students.id' => $id])

      ->first();

      $assessment['student_id'] = $main['id'];

      $assessment['code'] = $code;

      $assessment['age'] = $student['Student']['age'];

      $assessment['email'] = $student['Student']['email'];

      $assessment['year_term_id'] = $student['Student']['year_term_id'];

      $assessment['contact_no'] = $student['Student']['contact_no'];

      $assessment['program'] = $student['Student']['college_program']['name'];

      $assessment['student_name'] = $main['student_name'];

      $assessment['student_no'] = $main['student_no'];

      if($student['Student']['year_term_id'] > 3){

        $data = $this->Assessments->newEmptyEntity();
       
        $data = $this->Assessments->patchEntity($data, $assessment);

        if($this->Assessments->save($data)){

          $assessment_id = $data->id;

          $query = $this->BlockSectionCourses->find()

            ->where([

              'visible' => 1,

              'block_section_id' => $main['selected_block_section_id']

            ]);

          $query->select(['total' => $query->func()->count('*')]);

          $courses_count = $query->firstOrFail()->total;

          $query1 = $this->Accounts->find();

          $accounts = $query1->all();

          foreach ($accounts as $item) {          

            $acronym = trim($item->acronym);

            $fees[$acronym] = [

              'amount'  => $item->amount,

            ];

          }

          $assessment_sub['tuition_fee'] = ($courses_count * 3) * 50;

          $assessment_sub['athletics_fee'] = $fees['ATH']['amount'];

          $assessment_sub['cultural_fee'] = $fees['CUL']['amount'];

          $assessment_sub['development_fee'] = null;

          if (trim($student['Student']['college_program']['code']) === 'BSMT' || trim($student['Student']['college_program']['code']) === 'BSME') {

            $assessment_sub['development_fee'] = 150;

          } else {

            $assessment_sub['development_fee'] = $fees['DEVT']['amount'];

          }

          $assessment_sub['guidance_fee'] = $fees['GUI']['amount'];

          $query2 = $this->Courses->find()

            ->where([

              'Courses.laboratory_unit IS NOT' => null,

            ])

          ->matching('BlockSectionCourses', function ($q) use ($main) {

            return $q->where([

              'BlockSectionCourses.visible' => 1,

              'BlockSectionCourses.block_section_id' => $main['selected_block_section_id'],

            ]);

          });

          $query2->select(['total' => $query->func()->count('*')]);

          $courses_laboratory = $query2->firstOrFail()->total;

          $query3 = $this->Courses->find()

            ->where([

                'Courses.is_computer' => 1,

            ])

          ->matching('BlockSectionCourses', function ($q) use ($main) {

              return $q->where([

                'BlockSectionCourses.visible' => 1,

                'BlockSectionCourses.block_section_id' => $main['selected_block_section_id'],

              ]);

          });

          $query3->select(['total' => $query->func()->count('*')]);

          $courses_computer = $query3->firstOrFail()->total;

          $query4 = $this->Courses->find()

            ->where([

                'Courses.is_jeep' => 1,

            ])

          ->matching('BlockSectionCourses', function ($q) use ($main) {

            return $q->where([

                'BlockSectionCourses.visible' => 1,

                'BlockSectionCourses.block_section_id' => $main['selected_block_section_id'],

            ]);

          });

          $query4->select(['total' => $query->func()->count('*')]);

          $courses_jeep = $query4->firstOrFail()->total;

          $assessment_sub['laboratory_fee'] = $fees['LAB']['amount'] * $courses_laboratory;

          $assessment_sub['library_fee'] = $fees['LIB']['amount'];

          $assessment_sub['medical_dental_fee'] = $fees['MED']['amount'];

          $assessment_sub['computer_fee'] =  ($courses_computer > 0) ? $fees['COMP']['amount'] : 0.00;

          $assessment_sub['jeep_fee'] = ($courses_computer > 0) ? $fees['JEEP']['amount'] : 0.00;;

          $assessment_sub['assessment_id'] = $assessment_id;

          $assessment_sub['total'] = $assessment_sub['tuition_fee'] + $assessment_sub['athletics_fee'] + $assessment_sub['cultural_fee'] + $assessment_sub['development_fee'] + $assessment_sub['guidance_fee'] + $assessment_sub['laboratory_fee'] + $assessment_sub['library_fee'] + $assessment_sub['medical_dental_fee'] + $assessment_sub['computer_fee'] + $assessment_sub['jeep_fee'] +  $assessment_sub['assessment_id'];

          $assessment_data = $this->AssessmentSubs->newEmptyEntity();
       
          $assessment_data = $this->AssessmentSubs->patchEntity($assessment_data, $assessment_sub);

          $this->AssessmentSubs->save($assessment_data);

        }

      }

      if($student['Student']['year_term_id'] <= 3){

        $data = $this->Assessments->newEmptyEntity();
       
        $data = $this->Assessments->patchEntity($data, $assessment);

        if($this->Assessments->save($data)){

          $assessment_id = $data->id;

          $query = $this->BlockSectionCourses->find()

            ->where([

              'visible' => 1,

              'block_section_id' => $main['selected_block_section_id']

            ]);

          $courses = $query->all();

          $query->select(['total' => $query->func()->count('*')]);

          $courses_count = $query->firstOrFail()->total;

          $nstp_count = 0;

          foreach($courses as $course){

            if($course->course_id == 14 || $course->course_id == 15 || $course->course_id == 32 || $course->id == 33){

              $nstp_count += 1;

            }

          }

          $query1 = $this->Accounts->find();

          $accounts = $query1->all();

          foreach ($accounts as $item) {          

            $acronym = trim($item->acronym);

            $fees[$acronym] = [

              'amount'  => $item->amount,

            ];

          }


          $assessment_sub['tuition_fee'] = ($courses_count * 3) * 50;

          if($nstp_count > 0){

            $minus = ($nstp_count * 1.5) * 50;

            $assessment_sub['tuition_fee'] = $assessment_sub['tuition_fee'] - $minus;

          }

          if($student['Student']['year_term_id'] == 1){

            $assessment_sub['admission_fee'] = $fees['ADM']['amount'];

          }

          $assessment_sub['handbook_fee'] = $fees['SHB']['amount'];

          $assessment_sub['athletics_fee'] = $fees['ATH']['amount'];

          $assessment_sub['entrance_fee'] = $fees['ENF']['amount'];

          $assessment_sub['registration_fee'] = $fees['REG']['amount'];

          $assessment_sub['school_id_fee'] = $fees['IDC']['amount'];

          $assessment_sub['cultural_fee'] = $fees['CUL']['amount'];

          $assessment_sub['development_fee'] = null;

          if (trim($student['Student']['college_program']['code']) === 'BSMT' || trim($student['Student']['college_program']['code']) === 'BSME') {

            $assessment_sub['development_fee'] = 150;

          } else {

            $assessment_sub['development_fee'] = $fees['DEVT']['amount'];

          }

          $assessment_sub['guidance_fee'] = $fees['GUI']['amount'];

          $query2 = $this->Courses->find()

            ->where([

              'Courses.laboratory_unit IS NOT' => null,

            ])

          ->matching('BlockSectionCourses', function ($q) use ($main) {

            return $q->where([

              'BlockSectionCourses.visible' => 1,

              'BlockSectionCourses.block_section_id' => $main['selected_block_section_id'],

            ]);

          });

          $query2->select(['total' => $query->func()->count('*')]);

          $courses_laboratory = $query2->firstOrFail()->total;

          $query3 = $this->Courses->find()

            ->where([

                'Courses.is_computer' => 1,

            ])

          ->matching('BlockSectionCourses', function ($q) use ($main) {

              return $q->where([

                'BlockSectionCourses.visible' => 1,

                'BlockSectionCourses.block_section_id' => $main['selected_block_section_id'],

              ]);

          });

          $query3->select(['total' => $query->func()->count('*')]);

          $courses_computer = $query3->firstOrFail()->total;

          $query4 = $this->Courses->find()

            ->where([

                'Courses.is_jeep' => 1,

            ])

          ->matching('BlockSectionCourses', function ($q) use ($main) {

            return $q->where([

                'BlockSectionCourses.visible' => 1,

                'BlockSectionCourses.block_section_id' => $main['selected_block_section_id'],

            ]);

          });

          $query4->select(['total' => $query->func()->count('*')]);

          $courses_jeep = $query4->firstOrFail()->total;

          $assessment_sub['laboratory_fee'] = $fees['LAB']['amount'] * $courses_laboratory;

          $assessment_sub['library_fee'] = $fees['LIB']['amount'];

          $assessment_sub['medical_dental_fee'] = $fees['MED']['amount'];

          $assessment_sub['computer_fee'] =  ($courses_computer > 0) ? $fees['COMP']['amount'] : 0.00;

          $assessment_sub['jeep_fee'] = ($courses_computer > 0) ? $fees['JEEP']['amount'] : 0.00;;

          $assessment_sub['assessment_id'] = $assessment_id;

          $admission_fee = 0;

          if(isset($assessment_sub['admission_fee'])){

            $admission_fee = $assessment_sub['admission_fee'];

          }

          $assessment_sub['total'] = $assessment_sub['tuition_fee'] + $assessment_sub['athletics_fee'] + $assessment_sub['cultural_fee'] + $assessment_sub['development_fee'] + $assessment_sub['guidance_fee'] + $assessment_sub['laboratory_fee'] + $assessment_sub['library_fee'] + $assessment_sub['medical_dental_fee'] + $assessment_sub['computer_fee'] + $assessment_sub['jeep_fee'] +  $assessment_sub['assessment_id'] + $admission_fee + $assessment_sub['handbook_fee'] + $assessment_sub['entrance_fee'] + $assessment_sub['registration_fee'] + $assessment_sub['school_id_fee'];

          $assessment_data = $this->AssessmentSubs->newEmptyEntity();
       
          $assessment_data = $this->AssessmentSubs->patchEntity($assessment_data, $assessment_sub);

          $this->AssessmentSubs->save($assessment_data);

        }


      }
      
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

              'block_section_course_id' => $value['id'],

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
