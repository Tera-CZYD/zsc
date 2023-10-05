<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;


class ScholarshipApplicationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->ScholarshipApplication = TableRegistry::getTableLocator()->get('ScholarshipApplications');

    $this->ScholarshipName = TableRegistry::getTableLocator()->get('ScholarshipNames');

    $this->Student = TableRegistry::getTableLocator()->get('Students');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

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


    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(ScholarshipApplication.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(ScholarshipApplication.date) >= '$start' AND DATE(ScholarshipApplication.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = " AND ScholarshipApplication.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = " AND ScholarshipApplication.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->ScholarshipApplication->paginate($this->ScholarshipApplication->getAllScholarshipApplication($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $ScholarshipApplication = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // print_r($ScholarshipApplication);
    foreach ($ScholarshipApplication as $data) {

      $datas[] = array(

          'id'            => $data['id'],

          'code'          => $data['code'],

          'student_name'  => $data['student_name'],

          'date'          => fdate($data['date'],'m/d/Y'),

          'program'       => $data['name'],

          'scholarship_name'       => $data['scholarship_name'],

          'sex'           => $data['sex'],

          'age'           => $data['age'],
       
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

    $requestData = $this->request->getData('ScholarshipApplication');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $requestData['birthdate'] = isset($requestData['birthdate']) ? fdate($requestData['birthdate'],'Y-m-d') : null;

    $data = $this->ScholarshipApplication->newEmptyEntity();
   
    $data = $this->ScholarshipApplication->patchEntity($data, $requestData); 

    if ($this->ScholarshipApplication->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Scholarship Application has been successfully saved.',

        'data'=>$requestData

      );


        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Scholarship Application Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Scholarship Application cannot saved this time.',

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

    $data['ScholarshipApplication'] = $this->ScholarshipApplications->find()
    
    ->contain([
      
        'Students',
        
        'CollegePrograms',

        'YearLevelTerms',

        'Schools' => ['fields' => ['school_name']],
        
        'ScholarshipNames' => ['fields' => ['scholarship_name']]
        
    ])
    
    ->where([
      
        'ScholarshipApplications.visible' => 1,
        
        'ScholarshipApplications.id' => $id
        
    ])
    
    ->first();

    $data['ScholarshipApplication']['date'] = isset($data['ScholarshipApplication']['date']) ? date('m/d/Y', strtotime($data['ScholarshipApplication']['date'])) : null;

    $data['ScholarshipApplication']['birthdate'] = isset($data['ScholarshipApplication']['birthdate']) ? date('m/d/Y', strtotime($data['ScholarshipApplication']['birthdate'])) : null;

    $data['Student'] = $data['ScholarshipApplication']['student'];

    $data['CollegeProgram'] = $data['ScholarshipApplication']['college_program'];

    $data['School']['school_name'] = $data['ScholarshipApplication']['school']['school_name'];

    $data['ScholarshipName'] = $data['ScholarshipApplication']['scholarship_name'];

    $data['ScholarshipApplication']['year'] = $data['ScholarshipApplication']['year_level_term'];

    unset($data['ScholarshipApplication']['student']);

    unset($data['ScholarshipApplication']['college_program']);

    unset($data['ScholarshipApplication']['school']);

    unset($data['ScholarshipApplication']['scholarship_name']);

    unset($data['ScholarshipApplication']['year_level_term']);

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

    $ScholarshipApplication = $this->ScholarshipApplication->get($id); 

    $requestData = $this->getRequest()->getData('ScholarshipApplication');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $requestData['birthdate'] = isset($requestData['birthdate']) ? fdate($requestData['birthdate'],'Y-m-d') : null;

    $data = $this->ScholarshipApplication->patchEntity($ScholarshipApplication, $requestData); 

    // debug($data);

    if ($this->ScholarshipApplication->save($ScholarshipApplication)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Scholarship Application has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Edit',

          'description' => 'Scholarship Application Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $this->UserLogs->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'ScholarshipApplication cannot updated this time.',

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

    $data = $this->ScholarshipApplication->get($id);

    $data->visible = 0;

    if ($this->ScholarshipApplication->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'ScholarshipApplication has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'ScholarshipApplication cannot be deleted at this time.'

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

  public function approve($id = null){
    $this->autoRender = false;

    $data = $this->ScholarshipApplication->get($id);

    $data->approve = 4;

    $data->approve_by_id = $this->currentUser->id;

    if($this->ScholarshipApplication->save($data)){

      //EMAIL VERIFICATION

        $student = $this->Student->get($data['student_id']);

        $name = $student['first_name'].' '.substr($student['middle_name'],0,1).'. '.$student['last_name'];

        $email = $student['email'];

        // if(isset($email)){

        //   if(!empty($email)){

        //     if($email != ''){

        //       $Email = new CakeEmail();

        //       $Email->emailFormat('html');

        //       $Email->template('scholarship-application-approve', 'mytemplate');

        //       $_SESSION['name'] = @$name; 

        //       $_SESSION['code'] = @$app['ScholarshipApplication']['code']; 

        //       $_SESSION['student_no'] = @$app['ScholarshipApplication']['student_no']; 

        //       $_SESSION['type'] = @$app['ScholarshipApplication']['scholarship_type']; 

        //       $_SESSION['id'] = $id; 

        //       $Email->to($email, $name);

        //       $Email->subject('Scholarship Application Status');

        //       $Email->from(array($this->Global->Settings('email') => 'ESMIS'));

        //       $Email->send();

        //     }

        //   }

        // }

      //EMAIL VERIFICATION

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Scholarship Application has been successfully approved.'

      );


      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Scholarship Application',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);

      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Scholarship Application cannot be approved this time.'

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

  public function confirm($id = null){

    $this->autoRender = false;

    $data = $this->ScholarshipApplication->get($id);

    $data->approve = 4;

    $data->approve_by_id = $this->currentUser->id;

    if($this->ScholarshipApplication->save($data)){

      //EMAIL VERIFICATION

        $student = $this->Student->get($data['student_id']);

        $name = $student['first_name'].' '.substr($student['middle_name'],0,1).'. '.$student['last_name'];

        $email = $student['email'];

        // if(isset($email)){

        //   if(!empty($email)){

        //     if($email != ''){

        //       $Email = new CakeEmail();

        //       $Email->emailFormat('html');

        //       $Email->template('scholarship-application-confirm', 'mytemplate');

        //       $_SESSION['name'] = @$name; 

        //       $_SESSION['code'] = @$app['ScholarshipApplication']['code']; 

        //       $_SESSION['student_no'] = @$app['ScholarshipApplication']['student_no']; 

        //       $_SESSION['type'] = @$app['ScholarshipApplication']['scholarship_type']; 

        //       $_SESSION['id'] = $id; 

        //       $Email->to($email, $name);

        //       $Email->subject('Scholarship Application Status');

        //       $Email->from(array($this->Global->Settings('email') => 'ESMIS'));

        //       $Email->send();

        //     }

        //   }

        // }

      //EMAIL VERIFICATION

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Scholarship Application has been successfully confirmed.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Scholarship Application',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);

      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Counseling Appointment cannot be confirmed this time.'

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

  public function disapprove($id = null){

    $this->autoRender = false;

    $data = $this->ScholarshipApplication->get($id);

     $data->approve = 2;

    $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->ScholarshipApplication->save($data)){

      //EMAIL VERIFICATION

        $student = $this->Student->get($data['student_id']);

        $name = $student['first_name'].' '.substr($student['middle_name'],0,1).'. '.$student['last_name'];

        $email = $student['email'];

        // if(isset($email)){

        //   if(!empty($email)){

        //     if($email != ''){

        //       $Email = new CakeEmail();

        //       $Email->emailFormat('html');

        //       $Email->template('scholarship-application-disapprove', 'mytemplate');

        //       $_SESSION['name'] = @$name; 

        //       $_SESSION['code'] = @$app['ScholarshipApplication']['code']; 

        //       $_SESSION['student_no'] = @$app['ScholarshipApplication']['student_no']; 

        //       $_SESSION['type'] = @$app['ScholarshipApplication']['scholarship_type']; 

        //       $_SESSION['disapproved_reason'] = $data['disapproved_reason']; 

        //       $_SESSION['id'] = $id; 

        //       $Email->to($email, $name);

        //       $Email->subject('Scholarship Application Status');

        //       $Email->from(array($this->Global->Settings('email') => 'ESMIS'));

        //       $Email->send();

        //     }

        //   }

        // }

      //EMAIL VERIFICATION

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Scholarship Application has been successfully disapproved.'

      );


      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Attendance to Counseling',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Scholarship Application cannot be disapproved this time.'

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

  public function viewGrade($id = null){

    $data['ScholarshipApplication'] = $this->ScholarshipApplication->find()
      ->contain([

          'Students'

      ])

      ->where([

          'Students.visible' => 1,

          'ScholarshipApplications.visible' => 1,

          'ScholarshipApplications.id' => $id

      ])

      ->first();


    $data['ScholarshipApplication']['year_term_id'] = isset($data['ScholarshipApplication']['year_term_id']) ? $data['ScholarshipApplication']['year_term_id'] : '';

    $data['Student']= $data['ScholarshipApplication']['student'];

    unset($data['ScholarshipApplication']['student']);

    $year = $data['ScholarshipApplication']['year_term_id'];

    $studentId = $data['ScholarshipApplication']['student_id'];


    $data['StudentEnrolledCourse'] = "

        SELECT StudentEnrolledCourse.* FROM

          student_enrolled_courses as StudentEnrolledCourse

        WHERE

          StudentEnrolledCourse.visible = true AND StudentEnrolledCourse.year_term_id = $year AND StudentEnrolledCourse.student_id = $studentId

      ";

    $connection = $this->ScholarshipApplication->getConnection();

    $result = $connection->execute($data['StudentEnrolledCourse'])->fetchAll('assoc');

    $data['StudentEnrolledCourse'] = $result;

    $gwa = 0.0;

    $counter = 0;

    foreach ($result as $key => $value) {

      $gwa+=$result[$key]['final_grade'];

      $result[$key]['final_grade'] = isset($result[$key]['final_grade']) ? $result[$key]['final_grade'] : 'N/A';

      $counter+=1;

    }

    if($counter == 0 || $gwa == 0){

      $gwa = 0;

    }

    else{

          $gwa = $gwa/$counter;

    }

    $data['grade'] = $gwa;

    $data['date_of_birth'] = isset($data['date_of_birth']) ? fdate($data['date_of_birth'], 'm/d/Y') : 'N/A';

    $response = array(

      'ok'   => true,

      'data' => $data,

    );
      
    $this->set(array(

      'response'   => $response,

      '_serialize' => 'response'

   ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;
  }


  public function requestData($id = null,$name=null){
    $this->autoRender = false;

    $data = $this->ScholarshipApplication->get($id);

    $student = $this->Student->get($data['student_id']);

    $ScholarshipName = $this->ScholarshipName->get($data['scholarship_name_id']);
    // EMAIL
    $name = $student['first_name'].' '.substr($student['middle_name'],0,1).'. '.$student['last_name'];

    $email = $data['email'];

    // if(isset($email)){

    //   if(!empty($email)){

    //     if($email != ''){

    //       $Email = new CakeEmail();

    //       $Email->emailFormat('html');

    //       $Email->template('scholarship-requirement', 'mytemplate');

    //       $_SESSION['name'] = @$name; 

    //       $_SESSION['code'] = @$app['ScholarshipApplication']['code']; 

    //       $_SESSION['student_no'] = @$app['ScholarshipApplication']['student_no']; 

    //       $_SESSION['name'] = @$app['ScholarshipApplication']['student_name']; 

    //       $_SESSION['type'] = $ScholarshipName['ScholarshipName']['scholarship_name']; 

    //       $_SESSION['id'] = $id; 

    //       $Email->to($email, $name);

    //       $Email->subject('Scholarship Application Requirements');

    //       $Email->from(array($this->Global->Settings('email') => 'ESMIS'));

    //       $Email->send();

    //     }

    //   }

    // }

    //EMAIL

    $response = array(

      'ok'   => true,

      'data' => $data,       

      'msg'  => 'Scholarship Requirements has been successfully Requested.'

    );

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  } 

}
