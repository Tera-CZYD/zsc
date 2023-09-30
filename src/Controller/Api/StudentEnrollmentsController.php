<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class StudentEnrollmentsController extends AppController {

  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->StudentEnrollments = TableRegistry::getTableLocator()->get('StudentEnrollments');

    $this->StudentEnrolledCourses = TableRegistry::getTableLocator()->get('StudentEnrolledCourses');

    $this->StudentEnrolledSchedules = TableRegistry::getTableLocator()->get('StudentEnrolledSchedules');

    $this->BlockSectionCourses = TableRegistry::getTableLocator()->get('BlockSectionCourses');

  }

  public function add() {

    $this->autoRender = false;

    $student_enrollment = $this->request->getData('StudentEnrollment');

    $student_enrollment['date'] = date('Y-m-d');

    $student_enrolled_course = $this->request->getData('StudentEnrolledCourse');

    $student_enrolled_schedule = $this->request->getData('StudentEnrolledSchedule');

    $data = $this->StudentEnrollments->newEmptyEntity();
   
    $data = $this->StudentEnrollments->patchEntity($data, $student_enrollment); 

    if($this->StudentEnrollments->save($data)) {
      
      if(!empty($student_enrolled_course)){
        
        foreach ($student_enrolled_course as $key => $value) {

          $block_section_course_id = $value['block_section_course_id'];

          //UPDATE SLOT 

            $tmp = "

              UPDATE 

                block_section_courses

              SET

                enrolled_students = IFNULL(enrolled_students,0) + 1

              WHERE 

                id = $block_section_course_id

            ";

          //END 

          $connection = $this->BlockSectionCourses->getConnection();

          $result = $connection->execute($tmp);
          
        }

        $tmpEntity = $this->StudentEnrolledCourses->newEntities($student_enrolled_course);

        $this->StudentEnrolledCourses->saveMany($tmpEntity);
      
      }

      // if(!empty($student_enrolled_unit)){

      //   $this->StudentEnrolledUnit->savemany($student_enrolled_unit);

      // } 

      if(!empty($student_enrolled_schedule)){
        
        $tmpEntity = $this->StudentEnrolledSchedules->newEntities($student_enrolled_schedule);

        $this->StudentEnrolledSchedules->saveMany($tmpEntity);
      
      } 

      $response = array(

        'ok'  =>true,

        'msg' =>'Enrollment has been successfully saved.',

        'data'=>$student_enrollment

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Self Enrollment',

        'userId' => $this->Auth->user('id'),

        'description' => 'Enrollment',

        'code' => $student_enrollment['student_no'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);
      
    } else {

      $response = array(

        'ok'  =>true,

        'data'=>$student_enrollment,

        'msg' =>'Registration cannot saved this time.',

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