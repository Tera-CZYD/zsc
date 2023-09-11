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

  }

  // public $components = array("Global");

  // public $layout = null;

  public function index(){

    $user = $this->Auth->user();

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

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

      $this->set(compact("datas"));

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

        // var_dump($datas);

        // $studentClearances['Clearance']['Employee'] = $studentClearances['Clearance']['employee'];

        // unset($studentClearances['Clearance']['employee']);

        // var_dump($studentClearances['Clearance']);

        
        $response = [

          'ok' => true,

          'data' => $datas,

          'clearance' => $studentClearances,

          'student_subjects' => $student_subjects

        ];

        $this->response->withType('application/json');

        $this->response->getBody()->write(json_encode($response));

        return $this->response;
      
    }

  }

}

