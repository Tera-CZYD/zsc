<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\View\ViewBuilder;
use Cake\View\Helper\UrlHelper;

class DashboardsController extends AppController {

  public function initialize(): void {

    parent::initialize();
   
    $this->StudentLogs = TableRegistry::getTableLocator()->get('StudentLogs');

    $this->Consultations = TableRegistry::getTableLocator()->get('Consultations');

    $this->Prescriptions = TableRegistry::getTableLocator()->get('Prescriptions');

    $this->Dentals = TableRegistry::getTableLocator()->get('Dentals');

    $this->MedicalCertificates = TableRegistry::getTableLocator()->get('MedicalCertificates');

    $this->ReferralRecommendations = TableRegistry::getTableLocator()->get('ReferralRecommendations');

    $this->PropertyLogs = TableRegistry::getTableLocator()->get('PropertyLogs');

    $this->IllnessRecommendations = TableRegistry::getTableLocator()->get('IllnessRecommendations');

    $this->ReferralSlips = TableRegistry::getTableLocator()->get('ReferralSlips');

    $this->CounselingAppointments = TableRegistry::getTableLocator()->get('CounselingAppointments');

    $this->AttendanceCounselings = TableRegistry::getTableLocator()->get('AttendanceCounselings');

    $this->Affidavits = TableRegistry::getTableLocator()->get('Affidavits');

    $this->PromissoryNotes = TableRegistry::getTableLocator()->get('PromissoryNotes');

    $this->GoodMorals = TableRegistry::getTableLocator()->get('GoodMorals');

    $this->GcoEvaluations = TableRegistry::getTableLocator()->get('GcoEvaluations');

    $this->CalendarActivities = TableRegistry::getTableLocator()->get('CalendarActivities');

    $this->CounselingTypes = TableRegistry::getTableLocator()->get('CounselingTypes');

    $this->CounselingIntakes = TableRegistry::getTableLocator()->get('CounselingIntakes');

    $this->ParticipantEvaluationActivities = TableRegistry::getTableLocator()->get('ParticipantEvaluationActivities');

    $this->StudentExits = TableRegistry::getTableLocator()->get('StudentExits');

    $this->Apartelles = TableRegistry::getTableLocator()->get('Apartelles');

    $this->ApartelleImages = TableRegistry::getTableLocator()->get('ApartelleImages');

    $this->Students = TableRegistry::getTableLocator()->get('Students');

    $this->Employees = TableRegistry::getTableLocator()->get('Employees');

    $this->StudentClearances = TableRegistry::getTableLocator()->get('StudentClearances');

    $this->StudentEnrolledSchedules = TableRegistry::getTableLocator()->get('StudentEnrolledSchedules');

    $this->Settings = TableRegistry::getTableLocator()->get('Settings');

  }

  // public $components = array("Global");

  // public $layout = null;

  public function index(){

    $user = $this->Auth->user();

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $roleId = $user["roleId"];

    // var_dump($user);

    if($user["roleId"] == 1){ //ADMIN DASHBOARD

      $student_logs_count = $this->StudentLogs->find()->where([

        "visible" => 1

      ])->count();

      $consultaions_count = $this->Consultations->find()->where([

        "visible" => 1

      ])->count();

      $prescriptions_count = $this->Prescriptions->find()->where([

        "visible" => 1

      ])->count();

      $dentals_count = $this->Dentals->find()->where([

        "visible" => 1

      ])->count();

      $medical_certificate_request_count = $this->MedicalCertificates->find()->where([

        "visible" => 1

      ])->count();

      $referral_recommendation_count = $this->ReferralRecommendations->find()->where([

        "visible" => 1

      ])->count();

      $property_log_count = $this->PropertyLogs->find()->where([

        "visible" => 1

      ])->count();

      $illness_recommendation_count = $this->IllnessRecommendations->find()->where([

        "visible" => 1

      ])->count();

      $referral_slip_count = $this->ReferralSlips->find()->where([

        "visible" => 1

      ])->count();

      $counseling_apppointment_pending_count = $this->CounselingAppointments->find()->where([

        "visible" => 1,

        "approve" => 0,

      ])->count();

      $counseling_apppointment_approved_count = $this->CounselingAppointments->find()->where([

        "visible" => 1,

        "approve" => 1,

      ])->count();

      $counseling_apppointment_confirmed_count = $this->CounselingAppointments->find()->where([

        "visible" => 1,

        "approve" => 4,

      ])->count();

      $counseling_apppointment_disapproved_count = $this->CounselingAppointments->find()->where([

        "visible" => 1,

        "approve" => 2,

      ])->count();

      $counseling_apppointment_cancelled_count = $this->CounselingAppointments->find()->where([

        "visible" => 1,

        "approve" => 3,

      ])->count();

      $counseling_apppointment_total_count = $this->CounselingAppointments->find()->where([

        "visible" => 1,

      ])->count();

      $attendance_counseling_count = $this->AttendanceCounselings->find()->where([

        "visible" => 1,

      ])->count();

      $affidavit_count = $this->Affidavits->find()->where([

        "visible" => 1,

      ])->count();

      $promissory_note_count = $this->PromissoryNotes->find()->where([

        "visible" => 1,

      ])->count();

      $good_moral_count = $this->GoodMorals->find()->where([

        "visible" => 1,

      ])->count();

      $gco_evaluation_count = $this->GcoEvaluations->find()->where([

        "visible" => 1,

      ])->count();

      $calendar_activity_count = $this->CalendarActivities->find()->where([

        "visible" => 1,

      ])->count();

      $counseling_type_count = $this->CounselingTypes->find()->where([

        "visible" => 1,

      ])->count();

      $counseling_intake_count = $this->CounselingIntakes->find()->where([

        "visible" => 1,

      ])->count();

      $participant_evaluation_activity_count = $this->ParticipantEvaluationActivities->find()->where([

        "visible" => 1,

      ])->count();

      $student_exit_count = $this->StudentExits->find()->where([

        "visible" => 1,

      ])->count();

      $datas = array(

        "student_logs_count" => $student_logs_count,

        "consultaions_count" => $consultaions_count,

        "prescriptions_count" => $prescriptions_count,

        "dentals_count" => $dentals_count,

        "medical_certificate_request_count" => $medical_certificate_request_count,

        "referral_recommendation_count" => $referral_recommendation_count,

        "property_log_count" => $property_log_count,

        "illness_recommendation_count" => $illness_recommendation_count,

        "referral_slip_count" => $referral_slip_count,

        "counseling_apppointment_pending_count" => $counseling_apppointment_pending_count,

        "counseling_apppointment_approved_count" => $counseling_apppointment_approved_count,

        "counseling_apppointment_confirmed_count" => $counseling_apppointment_confirmed_count,

        "counseling_apppointment_disapproved_count" => $counseling_apppointment_disapproved_count,

        "counseling_apppointment_cancelled_count" => $counseling_apppointment_cancelled_count,

        "counseling_apppointment_total_count" => $counseling_apppointment_total_count,

        "counseling_apppointment_pending_percentage" => ($counseling_apppointment_pending_count / $counseling_apppointment_total_count) * 100,

        "counseling_apppointment_approved_percentage" => ($counseling_apppointment_approved_count / $counseling_apppointment_total_count) * 100,

        "counseling_apppointment_confirmed_percentage" => ($counseling_apppointment_confirmed_count / $counseling_apppointment_total_count) * 100,

        "counseling_apppointment_disapproved_percentage" => ($counseling_apppointment_disapproved_count / $counseling_apppointment_total_count) * 100,

        "counseling_apppointment_cancelled_percentage" => ($counseling_apppointment_cancelled_count / $counseling_apppointment_total_count) * 100,

        "attendance_counseling_count" => $attendance_counseling_count,

        "affidavit_count" => $affidavit_count,

        "promissory_note_count" => $promissory_note_count,

        "good_moral_count" => $good_moral_count,

        "gco_evaluation_count" => $gco_evaluation_count,

        "calendar_activity_count" => $calendar_activity_count,

        "counseling_type_count" => $counseling_type_count,

        "counseling_intake_count" => $counseling_intake_count,

        "participant_evaluation_activity_count" => $participant_evaluation_activity_count,

        "student_exit_count" => $student_exit_count,

      );

      $response = [

        'ok' => true,

        'data' => $datas,

        'roleId' => $roleId

      ];

      $this->response->withType('application/json');

      $this->response->getBody()->write(json_encode($response));

      return $this->response;

    }elseif($user['roleId'] == 13) { //STUDENT DASHBOARD

      $student_id = $user['studentId'];


      $studentData = $this->Students->find()
      
        ->contain([

          'StudentEnrolledCourses' => [

            'conditions'=>[ 

              'StudentEnrolledCourses.visible' => 1,

              'StudentEnrolledCourses.final_grade >' => 3,

            ],

          ],

        ])

        ->where([

          'Students.visible' => 1,

          'Students.id' => $student_id

        ])

      ->first();

      $year_term = $studentData['year_term_id'];

        $student_subjects = $studentData['student_enrolled_courses'];

        unset($studentData['student_enrolled_courses']);

        $tmp = "

          SELECT

            Apartelle.*

          FROM

            apartelles as Apartelle

          WHERE

            Apartelle.visible = true 

        ";

        $connection = $this->Apartelles->getConnection();

        $apartelle = $connection->execute($tmp)->fetchAll('assoc');

        $datas = array();

        if(!empty($apartelle)){

          foreach ($apartelle as $key => $value) {

            $images = $this->ApartelleImages->find()

              ->where([

                'visible' => 1,

                'apartelle_id' => $value['id']

              ])

            ->all();

            if(!empty($images)){

              foreach($images as $key => $image){

                if (!is_null($image['images'])) {

                  $datas[] = array(

                    'imageSrc' => $base . '/uploads/apartelle/' . $value['id'] . '/' . @$image['images'],

                    'name' => @$image['images'],

                    'id' => @$image['id'],

                  );

                }

              }

            }

          }

        }

      $studentClearances = $this->StudentEnrolledCourses->find()

        ->where([

          'visible' => 1,

          'student_id' => $student_id,

          'clearance_status' => 2,

        ])

        ->all();

      $enrolled_sub = $this->StudentEnrolledCourses->find()

        ->where([

          'student_id' => $student_id,

          'year_term_id' => $year_term,

          'visible' => 1

        ])

        ->all();

        // var_dump($enrolled_sub);
        $total_sub = 0;

        $passed = 0;

        $failed =0;

        $credited = 0; 
        
        $incomplete = 0;

        foreach ($enrolled_sub as $key => $value) {

          $total_sub+=1;

          if($value['final_grade']<=3.00 && $value['final_grade']!=null){

            $passed+=1;

          }else{

            $failed+=1;

          }

          if($value['remarks']=='PASSED'){

            $credited+=1;

          }

          if($value['incomplete']){

            $incomplete=+1;

          }  

        }

        $dayToday = date("l");

        $sched = $this->StudentEnrolledSchedules->find()

          ->where([

            'student_id' => $student_id,

            'year_term_id' => $year_term,

            'visible' => 1,

            'day' => $dayToday

          ])

          ->order(['time_start' => 'DESC'])

          ->all();

        $response = [

          'ok' => true,

          'data' => $datas,

          'clearance' => $studentClearances,

          'student_subjects' => $student_subjects,

          'roleId' => $roleId,

          'total_sub' => $total_sub,

          'passed' => $passed,

          'failed' => $failed,

          'credited' => $credited,

          'incomplete' => $incomplete,

          'scheds' => $sched

        ];

        $this->response->withType('application/json');

        $this->response->getBody()->write(json_encode($response));

        return $this->response;
      
    }elseif($user['roleId'] == 12) { //FACULTY DASHBOARD

      $employeeId = $user['employeeId'];


      $employees = $this->Employees->find()

        ->where([

          'id' => $employeeId,

          'visible' => 1

        ])

        ->first();

      $settings = $this->Settings->find()->offset(9)->first();


      $year_term = $settings['value'];

      $dayToday = date("l");

      $sched = $this->StudentEnrolledSchedules->find()

        ->contain([

          'BlockSectionSchedules' =>[

            'BlockSections'

          ]

        ])

        ->where([

          'StudentEnrolledSchedules.faculty_id' => $employeeId,

          'StudentEnrolledSchedules.year_term_id' => $year_term,

          'StudentEnrolledSchedules.visible' => 1,

          'StudentEnrolledSchedules.day' => $dayToday,

          'StudentEnrolledSchedules.year_term_id' => $year_term

        ])

        ->order(['StudentEnrolledSchedules.time_start' => 'DESC'])

        ->all();


      $datas = array();

      $clearance = $this->StudentEnrolledCourses->find()

        ->where([

          'faculty_id' => $employeeId,

          'year_term_id' => $year_term,

          'visible' => 1

        ])

        ->all();

        $subjects = $this->StudentEnrolledCourses->find()

        ->where([

          'faculty_id' => $employeeId,

          'year_term_id' => $year_term,

          'visible' => 1

        ])

        ->group(['course_id'])

        ->all();

        // var_dump($subjects);

        // $pending = $this->StudentEnrolledCourses->find()

        //   ->select(['course_id', 'count' => 'COUNT(*)'])

        //   ->where([

        //       'clearance_status' => 0,

        //       'faculty_id' => $employeeId,

        //   ])

        //   ->group(['course_id'])

        //   ->toArray();

        // $cleared = $this->StudentEnrolledCourses->find()

        //   ->select(['course_id', 'count' => 'COUNT(*)'])

        //   ->where([

        //       'clearance_remarks' => 'CLEARED',

        //       'clearance_status' => 1,

        //       'faculty_id' => $employeeId,

        //   ])

        //   ->group(['course_id'])

        //   ->toArray();

        // $inc = $this->StudentEnrolledCourses->find()

          // ->select(['course_id', 'count' => 'COUNT(*)'])

          // ->where([

          //     'clearance_remarks !=' => 'CLEARED',

          //     'clearance_remarks IS NOT NULL',

          //     'faculty_id' => $employeeId,

          // ])

          // ->group(['course_id'])

          // ->toArray();

        $pending = 0;

        $cleared = 0;

        $inc = 0;

        $counts = [];

        foreach ($subjects as $k => $data) {

          $pending = 0;

          $cleared = 0;

          $inc = 0;
            
          foreach ($clearance as $key => $value) {

            if($data['course_id']==$value['course_id']){

              if($value['clearance_remarks'] == 'CLEARED' || $value['clearance_remarks'] == 1){

              $cleared += 1;

              }else if($value['clearance_remarks'] != 'CLEARED' && $value['clearance_remarks'] != null){

                $inc += 1;

              }else if($value['clearance_remarks'] == 0){

                $pending += 1;

              }

            }

          }

          $counts[] = array(

            'subject' => $data['course'],

            'pending' => $pending,

            'inc' =>$inc,

            'cleared' => $cleared 

          );

        }

        


        // var_dump($pending);

      

        $response = [

          'ok' => true,

          'scheds' => $sched,

          'counts' => $counts

        ];

        $this->response->withType('application/json');

        $this->response->getBody()->write(json_encode($response));

        return $this->response;
      
    }

  }

}

