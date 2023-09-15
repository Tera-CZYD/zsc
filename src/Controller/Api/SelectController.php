<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Controller\Controller;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

use App\Model\Table\UsersTable;
use App\Model\Table\StudentLogsTable;
use App\Model\Table\ConsultationsTable;
use App\Model\Table\PrescriptionsTable;
use App\Model\Table\DentalsTable;
use App\Model\Table\RoomssTable;
use App\Model\Table\RoomTypesTable;
use App\Model\Table\MedicalCertififcatesTable;
use App\Model\Table\ReferralRecommendationsTable;
use App\Model\Table\PropertyLogsTable;
use App\Model\Table\IllnessRecommendationsTable;
use App\Model\Table\ReferralSlipsTable;
use App\Model\Table\CounselingAppointmentsTable;
use App\Model\Table\AttendanceCounselingsTable;
use App\Model\Table\AffidavitsTable;
use App\Model\Table\PromissoryNotesTable;
use App\Model\Table\GoodMoralsTable;
use App\Model\Table\GcoEvaluationsTable;
use App\Model\Table\CalendarActivitiesTable;
use App\Model\Table\CounselingTypesTable;
use App\Model\Table\CounselingIntakesTable;
use App\Model\Table\ParticipantEvaluationActivitiesTable;
use App\Model\Table\StudentExitsTable;
use App\Model\Table\RolesTable;

class SelectController extends AppController {

	public $layout = null;

  public function initialize(): void{

    parent::initialize();

    $this->autoRender = false;

    $this->loadComponent('RequestHandler');

    $this->loadModel('Checkouts');

    $this->loadModel("Colleges");

    $this->loadModel("AcademicRanks");

    $this->loadModel("Employees");

    $this->loadModel("ClassSchedules");

    $this->loadModel("AddingDroppingSubjects");

    $this->loadModel("Courses");

    $this->loadModel("Sections");

    $this->loadModel("CollegePrograms");

    $this->loadModel("StudentLedgers");

    $this->loadModel("Specializations");

    $this->loadModel("CollegeProgramCourses");

    $this->loadModel("StudentEnrollments");

    $this->loadModel("StudentApplications");

    $this->loadModel("RequestForms");

    $this->loadModel("Completions");

    $this->loadModel("Dentals");

    $this->loadModel("ScholarshipApplications");

    $this->loadModel("ScholarshipNames");

    $this->loadModel("CounselingAppointments");

    $this->loadModel("Users");

    $this->loadModel("AwardeeManagements");

    $this->loadModel("AwardManagements");

    $this->loadModel("Rooms");

    $this->loadModel("RoomTypes");

    $this->loadModel("StudentLogs");

    $this->loadModel("Prescriptions");

    $this->loadModel("Dentals");

    $this->loadModel("MedicalCertificates");

    $this->loadModel("ReferralRecommendations");

    $this->loadModel("CounselingAppointments");

    $this->loadModel("AttendanceCounselings");

    $this->loadModel("Affidavits");

    $this->loadModel("GoodMorals");

    $this->loadModel("StudentExits");

    $this->loadModel("Roles");

    $this->loadModel("Students");

    //sir raymond

    $this->loadModel("Buildings");

    $this->loadModel("Consultations");

    $this->loadModel("PropertyLogs");

    $this->loadModel("IllnessRecommendations");

    $this->loadModel("LearningResourceMembers");

    $this->loadModel("MaterialTypes");

    $this->loadModel("CollectionTypes");

    $this->Bibliographies = TableRegistry::getTableLocator()->get('Bibliographies');

    $this->InventoryBibliographies = TableRegistry::getTableLocator()->get('InventoryBibliographies');

    $this->Prescriptions = TableRegistry::getTableLocator()->get('Prescriptions');

    $this->IllnessRecommendations = TableRegistry::getTableLocator()->get('IllnessRecommendations');

    $this->NurseProfiles = TableRegistry::getTableLocator()->get('NurseProfiles');

    $this->IllnessRecommendationSubs = TableRegistry::getTableLocator()->get('IllnessRecommendationSubs');


    //sir leo

    $this->loadModel("ReferralSlips");

    $this->loadModel("Affidavits");

    $this->loadModel("PromissoryNotes");

    $this->loadModel("GcoEvaluations");

    $this->loadModel("CalendarActivities");

    $this->loadModel("CounselingTypes");

    $this->loadModel("CounselingIntakes");

    $this->loadModel("ParticipantEvaluationActivities");

    $this->loadModel("StudentExits");

    $this->loadModel('AppointmentSlips');

    $this->loadModel('CalendarActivities');

    $this->loadModel("FacultyClearances");

    $this->loadModel("StudentClearances");

    $this->loadModel("Permissions");

    $this->loadModel("Schools");

    $this->loadModel("Provinces");

    $this->loadModel("Municipalities");

    $this->loadModel("Barangays");
    

    //sir raf

    $this->loadModel("Apartelles");

    $this->loadModel("ApartelleRegistrations");

    $this->loadModel("GoodMorals");

    $this->loadModel("MedicalEmployeeProfiles");

    $this->loadModel("NurseProfiles");

    $this->loadModel("ItemIssuances");

    $this->MedicalStudentProfiles = TableRegistry::getTableLocator()->get('MedicalStudentProfiles');

    $this->loadModel('ApartelleStudentClearances');

    $this->loadModel('Purposes');

    //sir gerald

    $this->loadModel("StudentClubs");

    $this->loadModel("Clubs");

    $this->loadModel("InterviewRequests");

  }
	
  public function beforeFilter(\Cake\Event\EventInterface $event){

    parent::beforeFilter($event);

    $this->Auth->allow('index','application');

  }

	public function index ($arr = array()) {

    $this->responseType = 'json';

    $datas = array();
    
    $code  = null;
    
    // $year = $this->Global->Settings('active_year');
      
    $code = !is_null($this->request->getQuery('code')) ? $this->request->getQuery('code') : "";

    if($code == 'all-permissions'){

      $tmp = $this->Permissions->find()

        ->where(['Permissions.visible' => 1])

        ->order(['Permissions.module' => 'ASC'])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'   => $data['id'],

            'module' =>  $data['module'],

            'action' =>  $data['action'],

          );

        }

      }

    }else if ($code == 'roles') {
     
      $tmp = $this->Roles->find()->where([

        "visible" => 1,

      ])->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['name'],

          );

        }

      }

    } else if ($code == 'campus-list') {
     
      $tmp = $this->Campuses->find()
            ->where(['visible' => 1])
            ->orderAsc('id')
            ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code'].' - '.$data['name'],

          );

        }

      }

    }else if ($code == 'interview-request-code'){

      $tmp = $this->InterviewRequests->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'REQ-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'college-list') {
     
      $tmp = $this->Colleges->find()
        ->where(['visible' => 1])

        ->order(['id' => 'ASC'])

        ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code'].' - '.$data['name'],

          );

        }

      }

    }else if ($code == 'academic-rank-list') {
     
      $tmp = $this->AcademicRanks->find()
        ->where(['visible' => 1])

        ->order(['id' => 'ASC'])

        ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['rank'],

          );

        }

      }

    }else if ($code == 'specialization-list') {
     
      $tmp = $this->Specializations->find()
        ->where(['visible' => 1])

        ->order(['id' => 'ASC'])

        ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['name'],

          );

        }

      }

    }  else if ($code == 'medical-student-profile-code'){

      $tmp = $this->MedicalStudentProfiles->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'MSP-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    }else if ($code == 'employee-list') {

      $this->loadModel('Employees');
  
      $tmp = $this->Employees

          ->find()

          ->where([

              'visible' => 1,

          ])

          ->order([

              'code' => 'ASC',

          ])

          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code']. " - " . $data['family_name']. " , " .  $data['given_name'] . "  ". $data['middle_name'],

          );

        }

      }

    } else if ($code == 'medical-employee-profile-code'){

      $tmp = $this->MedicalEmployeeProfiles->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'MEP-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'room-list') {
     
      $tmp = $this->Rooms->find()

            ->where(['visible' => 1])

            ->order(['id' => 'ASC']);

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code'].' - '.$data['name'],

          );

        }

      }

    } else if ($code == 'department-list') {
     
      $tmp = $this->Department->find('all', array(

        'conditions' => array(

          'Department.visible' => true

        ),

        'order' => array(

          'Department.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Department']['id'],

            'value' => $data['Department']['code'].' - '.$data['Department']['name'],

          );

        }

      }

    } else if ($code == 'nurse-profile-list') {
     
      $tmp = $this->NurseProfiles->find()

      ->where([

        'visible' => 1

      ])

      ->order([

        'id' => 'ASC'

      ])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['name'],

          );

        }

      }

    } else if ($code == 'program-term-list') {
     
      $tmp = $this->ProgramTerm->find('all', array(

        'conditions' => array(

          'ProgramTerm.visible' => true

        ),

        'order' => array(

          'ProgramTerm.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['ProgramTerm']['id'],

            'value' => $data['ProgramTerm']['term'],

          );

        }

      }

    } else if ($code == 'academic-term-list') {

      $conditions = array();

      $conditions['AcademicTerm.visible'] = true;

      if(isset($this->request->query['id'])){

        $id = $this->request->query['id'];

        $conditions['AcademicTerm.id != '] = $id;

      }
     
      $tmp = $this->AcademicTerm->find('all', array(

        'conditions' => $conditions,

        'order' => array(

          'CAST(AcademicTerm.chronological_order AS DECIMAL)' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['AcademicTerm']['id'],

            'value' => $data['AcademicTerm']['school_year'].' - '.$data['AcademicTerm']['semester'].($data['AcademicTerm']['active'] ? '(active semester)' : ''),

          );

        }

      }

    } else if ($code == 'search-student') {

      $page = $this->request->getQuery('page', 1);

      $conditions = [];

      if ($this->request->getQuery('search')) {

        $search = $this->request->getQuery('search');

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      $studentsTable = TableRegistry::getTableLocator()->get('Students');

      $limit = 25;

      $studentsData = $studentsTable->paginate($studentsTable->getAllStudent($conditions, $limit, $page), [

        'extra' => [

          'conditions' => $conditions

        ],

        'page' => $page,

        'limit' => $limit

      ]);

      $students = $studentsData['data'];

      $paginator = $studentsData['pagination'];

      $datas = [];

      foreach ($students as $student) {

        $datas[] = array(

          'id' => $student['id'],
       
          'code' => $student['student_no'],
       
          'name' => $student['full_name'],
       
          'email' => $student['email'],
       
          'college_id' => $student['college_id'],
       
          'program_id' => $student['program_id'],
       
          'year_term_id' => $student['year_term_id'],

          'date_of_birth' => $student['date_of_birth'],

        );

      }

      $datas = array(

        'result'     => $datas,

        'paginator' => $paginator

      );

    } else if ($code == 'search-admin') {

      $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

      $conditions = array();

      $conditions['search'] = '';

      // search conditions

      if(isset($this->request->query['search'])){

        $search = $this->request->query['search'];

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      // Setting up paging parameters

      $this->paginate = array('Admin'=>array(

        'limit'      => 25,

        'page'       => $page,

        'extra'      => array('conditions'=>$conditions)

      ));

      $tmpData = $this->paginate('Admin');

      $datas = array();

      if(!empty($tmpData)){

        foreach ($tmpData as $key => $value) {

          $datas[] = array(

            'id'     => $value['Admin']['id'],

            'code'   =>  $value['Admin']['employee_no'],

            'name'   =>  $value[0]['full_name'],

          );

        }

      }

      $datas = array(

        'result'     => $datas,

        'paginator'  => $this->request->params['paging']['Admin']

      );

    } else if ($code == 'search-learning-resource-member') {

      $page = $this->request->getQuery('page', 1);

      $conditions = [];

      if ($this->request->getQuery('search')) {

        $search = $this->request->getQuery('search');

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      $learningResourceMembersTable = TableRegistry::getTableLocator()->get('LearningResourceMembers');

      $limit = 25;

      $learningResourceMembersData = $learningResourceMembersTable->paginate($learningResourceMembersTable->getAllLearningResourceMember($conditions, $limit, $page), [

        'extra' => [

          'conditions' => $conditions

        ],

        'page' => $page,

        'limit' => $limit

      ]);

      $learningResourceMembers = $learningResourceMembersData['data'];

      $paginator = $learningResourceMembersData['pagination'];

      $datas = array();

      if(!empty($learningResourceMembers)){

        foreach ($learningResourceMembers as $key => $value) {

          $member_name = '';

          if($value['classification'] == 'STUDENT'){

            $member_name = $value['student_name'];

          }elseif($value['classification'] == 'FACULTY'){

            $member_name = $value['employee_name'];

          }elseif($value['classification'] == 'ADMIN'){

            $member_name = $value['admin_name'];

          }

          $datas[] = array(

            'id'                => $value['id'],

            'code'              => $value['code'],

            'library_id_number' => $value['library_id_number'],

            'member_name'       => $member_name,

            'contact_no'        => $value['contact_no'],

            'date'              => fdate($value['date'],'m/d/Y'),

            'email'             => $value['email']

          );

        }

      }

      $datas = array(

        'result'     => $datas,

        'paginator' => $paginator

      );

    } else if ($code == 'available-books-list') {

      if($this->request->getQuery('id')){

        $id = $this->request->getQuery('id');

        $condition = "AND (InventoryBibliography.status = 'Available' OR InventoryBibliography.status = 'Returned' OR InventoryBibliography.check_out_id = $id)";

      }else{

        $id = 0;

        $condition = "AND (InventoryBibliography.status = 'Available' OR InventoryBibliography.status = 'Returned')";

      }

      $tmp = "

        SELECT 

          Bibliography.title,

          Bibliography.author,
         
          InventoryBibliography.id,
         
          InventoryBibliography.barcode_no,
         
          InventoryBibliography.description,
         
          InventoryBibliography.check_out_id

        FROM  
       
          inventory_bibliographies as InventoryBibliography LEFT JOIN

          bibliographies as Bibliography ON InventoryBibliography.bibliography_id = Bibliography.id

        WHERE 

          Bibliography.visible = true AND 

          InventoryBibliography.visible = true $condition

        ORDER BY 

          InventoryBibliography.barcode_no DESC

      ";

      $connection = $this->InventoryBibliographies->getConnection();

      $result = $connection->execute($tmp)->fetchAll('assoc');

      if(!empty($result)){

        foreach ($result as $k => $data) {

          $datas[] = array(

            'id'          => $data['id'],

            'title'       => $data['title'],

            'author'      => $data['author'],

            'barcode_no'  => $data['barcode_no'],

            'description' => $data['description'],

            'selected'    => $data['check_out_id'] == $id ? true : false

          );

        }

      }

    } else if ($code == 'borrowed-books-list') {

      $learning_resource_member_id = $this->request->getQuery('learning_resource_member_id');

      $condition = '';

      if($this->request->getQuery('id')){

        $id = $this->request->getQuery('id');

        $condition = "AND (CheckOutSub.returned = 0 OR CheckOutSub.check_in_id = $id)";

      }else{

        $id = 0;

        $condition = "AND CheckOutSub.returned = 0";

      }

      $tmp = "

        SELECT 

          CheckOutSub.*

        FROM  

          check_out_subs as CheckOutSub LEFT JOIN 

          check_outs as CheckOut ON CheckOut.id = CheckOutSub.check_out_id

        WHERE 

          CheckOut.visible = true $condition AND 

          CheckOut.learning_resource_member_id = $learning_resource_member_id AND 

          CheckOutSub.visible = true

        ORDER BY 

          CheckOutSub.id ASC 

      ";

      $connection = $this->InventoryBibliographies->getConnection();

      $result = $connection->execute($tmp)->fetchAll('assoc');

      if(!empty($result)){

        foreach ($result as $k => $data) {

          $datas[] = array(

            'id'                        => $data['id'],

            'check_out_id'              => $data['check_out_id'],

            'inventory_bibliography_id' => $data['inventory_bibliography_id'],

            'title'                     => $data['title'],

            'author'                    => $data['author'],

            'barcode_no'                => $data['barcode_no'],

            'description'               => $data['description'],

            'dueback'                   => $data['dueback'],

            'selected'                  => $data['check_in_id'] == $id ? true : false

          );

        }

      }

    } else if ($code == 'search-student-application') {

      $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

      $conditions = array();

      $conditions['search'] = '';

      // search conditions

      if(isset($this->request->query['search'])){

        $search = $this->request->query['search'];

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      // Setting up paging parameters

      $this->paginate = array('StudentApplication'=>array(

        'limit'      => 25,

        'page'       => $page,

        'extra'      => array('conditions'=>$conditions)

      ));

      $tmpData = $this->paginate('StudentApplication');

      $datas = array();

      if(!empty($tmpData)){

        foreach ($tmpData as $key => $value) {

          $datas[] = array(

            'id'     => $value['StudentApplication']['id'],

            'code'   =>  $value['StudentApplication']['student_no'],

            'name'   =>  $value['StudentApplication']['last_name']. ', ' .$value['StudentApplication']['first_name']. ' ' .$value['StudentApplication']['middle_name'],

            'email'  =>  $value['StudentApplication']['email'],

            'program' => $value['CollegeProgram']['name'],

            'gender' => $value['StudentApplication']['gender'],

            'contact_no'  => $value['StudentApplication']['contact_no']

          );

        }

      }

      $datas = array(

        'result'     => $datas,

        'paginator'  => $this->request->params['paging']['StudentApplication']

      );

    } else if ($code == 'search-program-adviser') {

      $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

      $conditions = array();

      $conditions['search'] = '';

      // search conditions

      if(isset($this->request->query['search'])){

        $search = $this->request->query['search'];

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      // Setting up paging parameters

      $this->paginate = array('ProgramAdviser'=>array(

        'limit'      => 25,

        'page'       => $page,

        'extra'      => array('conditions'=>$conditions)

      )); 

      $tmpData = $this->paginate('ProgramAdviser');

      $datas = array();

      if(!empty($tmpData)){

        foreach ($tmpData as $key => $value) {

          $datas[] = array(

            'id'     => $value['ProgramAdviser']['id'],

            'name'   =>  $value['ProgramAdviser']['student_name'],

            'email'  =>  $value['ProgramAdviser']['email'],

            'program' => $value['ProgramAdviser']['program'],

            'gender' => $value['ProgramAdviser']['gender'],

            'contact_no'  => $value['ProgramAdviser']['contact_no'],

            'age'     => $value['ProgramAdviser']['age']

          );

        }

      }

      $datas = array(

        'result'     => $datas,

        'paginator'  => $this->request->params['paging']['ProgramAdviser']

      );

    } else if ($code == 'account-list-all') {

      $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

      $conditions = array();

      $conditions['search'] = '';

      // search conditions

      if(isset($this->request->query['search'])){

        $search = $this->request->query['search'];

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      // Setting up paging parameters

      $this->paginate = array('Account'=>array(

        'limit'      => 25,

        'page'       => $page,

        'extra'      => array('conditions'=>$conditions)

      )); 

      $tmpData = $this->paginate('Account');

      $datas = array();

      if(!empty($tmpData)){

        foreach ($tmpData as $key => $data) {

          $datas[] = array(

            'id'    => $data['Account']['id'],

            'code'  => $data['Account']['code'],

            'name' => $data['Account']['name'],

            'amount' => $data['Account']['amount'],

            'unit' => $data['Account']['unit']

          );

        }

      }

      $datas = array(

        'result'     => $datas,

        'paginator'  => $this->request->params['paging']['Account']

      );

    } else if ($code == 'search-approval-course') {

      $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

      $conditions = array();

      $conditions['search'] = '';

      // search conditions

      if(isset($this->request->query['search'])){

        $search = $this->request->query['search'];

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      // Setting up paging parameters

      $this->paginate = array('ApprovalEnrolledCourse'=>array(

        'limit'      => 25,

        'page'       => $page,

        'extra'      => array('conditions'=>$conditions)

      )); 

      $tmpData = $this->paginate('ApprovalEnrolledCourse');

      $datas = array();

      if(!empty($tmpData)){

        foreach ($tmpData as $key => $value) {

          $datas[] = array(

            'id'     => $value['ApprovalEnrolledCourse']['id'],

            'name'   =>  $value['ApprovalEnrolledCourse']['student_name'],

            'email'  =>  $value['ApprovalEnrolledCourse']['email'],

            'program' => $value['ApprovalEnrolledCourse']['program'],

            'gender' => $value['ApprovalEnrolledCourse']['gender'],

            'contact_no'  => $value['ApprovalEnrolledCourse']['contact_no'],

            'age'     => $value['ApprovalEnrolledCourse']['age']

          );

        }

      }

      $datas = array(

        'result'     => $datas,

        'paginator'  => $this->request->params['paging']['ApprovalEnrolledCourse']

      );

    } else if ($code == 'student-academic-term-list') {

      $conditions = array();

      $conditions['AcademicTerm.visible'] = true;

      $conditions['AcademicTerm.active'] = true;

      if(isset($this->request->query['id'])){

        $id = $this->request->query['id'];

        $conditions['AcademicTerm.id != '] = $id;

      }
     
      $tmp = $this->AcademicTerm->find('all', array(

        'conditions' => $conditions,

        'order' => array(

          'AcademicTerm.id' => 'ASC',

        ),

        'limit' => 1

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['AcademicTerm']['id'],

            'value' => $data['AcademicTerm']['school_year'].' - '.$data['AcademicTerm']['semester'],

          );

        }

      }

    } else if ($code == 'college-department-list') {
      
      $id = $this->request->query['id'];

      $tmp = $this->CollegeDepartment->find('all', array(

        'contain' => array(
        
          'College' => array(

            'conditions' => array(

              'College.visible' => true

            ),

          ),
          
          'Department' => array(

            'conditions' => array(

              'Department.visible' => true

            ),

          ),

        ),

        'conditions' => array(

          'CollegeDepartment.visible' => true,

          'CollegeDepartment.college_id' => $id

        ),

        'order' => array(

          'CollegeDepartment.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['CollegeDepartment']['id'],

            'value' => $data['Department']['code'],

          );

        }

      }

    } else if ($code == 'school-name-list') {
     
      $tmp = $this->School->find('all', array(

        'conditions' => array(

          'School.visible' => true

        ),

        'order' => array(

          'School.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['School']['id'],

            'value' => $data['School']['school_name'],

            'school_address' => $data['School']['school_address'],

          );

        }

      }

    } else if ($code == 'scholarship-name-list') {
           
      $tmp = $this->ScholarshipNames->find()
          ->where(['visible' => 1])
          ->order(['id' => 'ASC'])
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['scholarship_name']

          );

        }

      }

    } else if ($code == 'college-department-program-list') {
      
      $id = $this->request->query['id'];

      $tmp = $this->CollegeDepartmentProgram->find('all', array(

        'contain' => array(
        
          'CollegeProgram' => array(

            'conditions' => array(

              'CollegeProgram.visible' => true

            ),

          ),

        ),

        'conditions' => array(

          'CollegeDepartmentProgram.visible' => true,

          'CollegeDepartmentProgram.college_department_id' => $id

        ),

        'order' => array(

          'CollegeDepartmentProgram.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['CollegeDepartmentProgram']['id'],

            'value' => $data['CollegeProgram']['short_name'],

          );

        }

      }

    } else if ($code == 'department-program-list') {
      
      $tmp = $this->CollegeDepartmentProgram->find('all', array(

        'contain' => array(
        
          'CollegeProgram' => array(

            'conditions' => array(

              'CollegeProgram.visible' => true

            ),

          ),
        
          'CollegeDepartment' => array(

            'College' => array(

              'conditions' => array(

                'College.visible' => true

              ),

            ),

            'Department' => array(

              'conditions' => array(

                'Department.visible' => true

              ),

            ),

            'conditions' => array(

              'CollegeDepartment.visible' => true

            ),

          ),

        ),

        'conditions' => array(

          'CollegeDepartmentProgram.visible' => true

        ),

        'order' => array(

          'CollegeDepartmentProgram.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['CollegeDepartmentProgram']['id'],

            'value' => '['.($k + 1).']'.$data['CollegeDepartment']['College']['code'].'::'.$data['CollegeDepartment']['Department']['short_name'].'::'.$data['CollegeProgram']['name']

          );

        }

      }

    } else if ($code == 'year-term-list') {

        $conditions = [];

        // $conditions['YearLevelTerm.visible'] = 1;

        if ($this->request->getQuery('educational_level')) {

            $educationalLevel = $this->request->getQuery('educational_level');

            $conditions['YearLevelTerm.educational_level'] = $educationalLevel;

        }

        if ($this->request->getQuery('id')) {

            $id = $this->request->getQuery('id');

            $conditions['YearLevelTerm.id !='] = $id;

        }

        $yearLevelTermTable = TableRegistry::getTableLocator()->get('YearLevelTerms');

        $query = $yearLevelTermTable->find()

            ->select(['id', 'description'])

            ->where(['visible' => 1])

            ->order(['chronological_order' => 'ASC']);

        $results = $query->all();

        $datas = [];

        foreach ($results as $data) {

            $datas[] = [

                'id' => $data->id,

                'value' => $data->description,

            ];

        }

    }else if ($code == 'account-group-list') {

      $tmp = $this->AccountGroup->find('all', array(

        'conditions' => array(

          'AccountGroup.visible' => true,

        ),

        'order' => array(

          'AccountGroup.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['AccountGroup']['id'],

            'value' => $data['AccountGroup']['name'],

          );

        }

      }

    } else if ($code == 'account-classification-list') {

      $tmp = $this->AccountClassification->find('all', array(

        'conditions' => array(

          'AccountClassification.visible' => true,

        ),

        'order' => array(

          'AccountClassification.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['AccountClassification']['id'],

            'value' => $data['AccountClassification']['name'],

          );

        }

      }

    } else if ($code == 'account-category-list') {

      $tmp = $this->AccountCategory->find('all', array(

        'conditions' => array(

          'AccountCategory.visible' => true,

        ),

        'order' => array(

          'AccountCategory.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['AccountCategory']['id'],

            'value' => $data['AccountCategory']['name'],

          );

        }

      }

    } else if ($code == 'account-set-list') {

      $tmp = $this->AccountSet->find('all', array(

        'conditions' => array(

          'AccountSet.visible' => true,

        ),

        'order' => array(

          'AccountSet.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['AccountSet']['id'],

            'value' => $data['AccountSet']['name'],

          );

        }

      }

    } else if ($code == 'account-list') {

      $tmp = $this->ChartOfAccount->find('all', array(

        'conditions' => array(

          'ChartOfAccount.visible' => true,

        ),

        'order' => array(

          'ChartOfAccount.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['ChartOfAccount']['id'],

            'value' => $data['ChartOfAccount']['name'],

          );

        }

      }

    } else if ($code == 'account-item-list') {

      $tmp = $this->AccountFee->find('all', array(

        'contain' => array(

          'ChartOfAccount' => array(

            'conditions' => array(

              'ChartOfAccount.visible' => true

            ),

          ),

        ),

        'conditions' => array(

          'AccountFee.visible' => true,

        ),

        'order' => array(

          'AccountFee.account_id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['ChartOfAccount']['id'],

            'value'   => $data['ChartOfAccount']['code'].' :: '.$data['ChartOfAccount']['name'].' :: Php '.$data['AccountFee']['amount'],

            'name'    => $data['ChartOfAccount']['code'].' :: '.$data['ChartOfAccount']['name'],

            'code'    => $data['ChartOfAccount']['code'],

            'amount'  => $data['AccountFee']['amount'],

          );

        }

      }

    } else if ($code == 'course-list') {

      $tmp = $this->Courses->find()

            ->select(['id','code','title'])

            ->order(['code' => 'ASC', 'id' => 'ASC'])

            ->where(['visible' => 1]);

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['code'].' - '.$data['title']

          );

        }

      }

    } else if ($code == 'school-list') {

             
      $tmp = $this->Schools->find()
          ->where(['visible' => 1])
          ->order(['school_name' => 'ASC'])
          ->all();


      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['school_name'],

            'school_address'   => $data['school_address']

          );

        }

      }

    } else if ($code == 'section-list') {

      $tmp = $this->Sections->find()
        ->where(['visible' => 1])

        ->order(['id' => 'ASC'])

        ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['name']

          );

        }

      }

    } else if ($code == 'get-prerequisite-list') {

      $program = '';

      if(isset($this->request->query['id'])){

        $id = $this->request->query['id'];

        $program = "AND CollegeProgramCourse.college_program_id = $id";

      }

      $year_term = '';

      if(isset($this->request->query['year_term_id'])){

        $year_term_id = $this->request->query['year_term_id'];

        $yearData = $this->YearLevelTerm->findById($year_term_id);

        $order = $yearData['YearLevelTerm']['chronological_order'];

        $year_term = "AND YearLevelTerm.chronological_order < $order";

      }

      $this->loadModel('YearLevelTerms');
      $tmp = $this->YearLevelTerms->query("

        SELECT 

          Course.*,

          CollegeProgramCourse.course_id

        FROM

          courses as Course LEFT JOIN

          college_program_courses AS CollegeProgramCourse ON Course.id = CollegeProgramCourse.course_id LEFT JOIN

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = CollegeProgramCourse.year_term_id

        WHERE

          Course.visible = true $program $year_term AND

          CollegeProgramCourse.visible = true AND

          YearLevelTerm.visible = true

        GROUP BY

          Course.id

        ORDER BY

          CAST(YearLevelTerm.chronological_order AS DECIMAL) ASC,

          Course.code ASC

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data->id,

            'value' => $data->code.' - '.$data->title

          );

        }

      }

    }else if ($code == 'get-corerequisite-list') {

      $program = '';

      if(isset($this->request->query['id'])){

        $id = $this->request->query['id'];

        $program = "AND CollegeProgramCourse.college_program_id = $id";

      }

      $year_term = '';

      if(isset($this->request->query['year_term_id'])){

        $year_term_id = $this->request->query['year_term_id'];

        $yearData = $this->YearLevelTerm->findById($year_term_id);

        $order = $yearData['YearLevelTerm']['chronological_order'];

        $year_term = "AND YearLevelTerm.chronological_order < $order";

      }

      $this->loadModel('YearLevelTerms');
      $tmp = $this->YearLevelTerms->query("

        SELECT 

          Course.*,

          CollegeProgramCourse.course_id

        FROM

          courses as Course LEFT JOIN

          college_program_courses AS CollegeProgramCourse ON Course.id = CollegeProgramCourse.course_id LEFT JOIN

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = CollegeProgramCourse.year_term_id

        WHERE

          Course.visible = true $program $year_term AND

          CollegeProgramCourse.visible = true AND

          YearLevelTerm.visible = true

        GROUP BY

          Course.id

        ORDER BY

          CAST(YearLevelTerm.chronological_order AS DECIMAL) ASC,

          Course.code ASC

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data->id,

            'value' => $data->code.' - '.$data->title

          );

        }

      }

    }else if ($code == 'curriculum-course-list') {
        $yearTermId = $this->request->getQuery('year_term_id');

        $programId = $this->request->getQuery('id');

        $collegeProgramCourseTable = TableRegistry::getTableLocator()->get('CollegeProgramCourses');

        $query = $collegeProgramCourseTable->find()

            ->select(['id', 'course_id'])

            ->contain([

                'Courses' => function ($q) {

                    return $q->select(['id', 'code', 'title']);

                },

                'YearLevelTerms' => function ($q) {

                    return $q->select(['id', 'description']);

                }

            ])

            ->where([

                'CollegeProgramCourses.visible' => 1,

                'CollegeProgramCourses.college_program_id' => $programId,

                'CollegeProgramCourses.year_term_id' => $yearTermId

            ]);


        $results = $query->all();

        $datas = [];
        foreach ($results as $data) {

            $datas[] = [

                'id' => $data->id,

                'code' => $data->course_data->code,

                'title' => $data->course_data->title,

                'year_level_term' => $data->YearLevelTerm->description

            ];
        }

    }else if ($code == 'fee-list') {

      $tmp = $this->AccountFee->query("

        SELECT

          AccountFee.*,

          ChartOfAccount.*

        FROM

          account_fees as AccountFee LEFT JOIN

          chart_of_accounts as ChartOfAccount ON ChartOfAccount.id = AccountFee.account_id

        WHERE

          AccountFee.visible = true AND

          ChartOfAccount.visible = true

        GROUP BY

          AccountFee.id

        ORDER BY

          ChartOfAccount.code ASC

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['AccountFee']['id'],

            'value'   => $data['ChartOfAccount']['code'].' - '.$data['ChartOfAccount']['name'].'(P'.fnumber($data['AccountFee']['amount'],2).')'

          );

        }

      }

    } else if ($code == 'table-of-fees-list') {

      $tmp = $this->TableOfFee->find('all', array(

        'conditions' => array(

          'TableOfFee.visible' => true,

          'TableOfFee.active' => true,

          'LOWER(TableOfFee.remarks) LIKE' => '%default%',

        ),

        'order' => array(

          'TableOfFee.code' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['TableOfFee']['id'],

            'value'   => $data['TableOfFee']['code'].' :: '.$data['TableOfFee']['description']

          );

        }

      }

    } else if ($code == 'building-list') {
      $tmp = $this->Buildings->find()->where([

        "visible" => 1,

      ])
      ->order(['code' => "ASC"])
      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['code'].' :: '.$data['name']

          );

        }

      }

    } else if ($code == 'room-type-list') {

      $tmp = $this->RoomTypes->find()->where([

        "visible" => 1,

      ])
      ->order(['id' => "ASC"])
      ->all();


      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['room_type']

          );

        }

      }

    } else if ($code == 'program-list') {

      $tmp = $this->CollegePrograms->find()
          ->where(['visible' => 1])
          ->orderAsc('id')
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['code'].' :: '.$data['name']

          );

        }

      }

    } else if ($code == 'program-course-list') {

      $id = $this->request->getQuery('id');

      $tmp = $this->CollegeProgramCourses->find()
          ->where([
              'visible' => 1,
              'college_program_id' => $id
          ])
          ->order(['id' => 'ASC'])
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $course = $this->Courses->get($data['course_id']);

          $datas[] = array(

            'id'          => $data['id'],

            'course_id'   => $data['course_id'],

            'course_code' => @$course['code'],

            'value'       => $data['course'],

          );

        }

      }

    } else if ($code == 'application-program-list') {

      $college_id = $this->request->getQuery('college_id');

      $tmp = $this->Colleges->find()
          ->contain([
              'CollegeSub' => [
                  'conditions' => ['CollegeSub.visible' => 1],
              ],
          ])
          ->where([
              'Colleges.visible' => 1,
              'Colleges.id' => $college_id,
          ])
          ->order([
              'Colleges.id' => 'ASC',
          ])
          ->first();

      $datas = [];
      if (!empty($tmp->college_sub)) {
          foreach ($tmp->college_sub as $data) {
              $datas[] = [
                  'id' => $data->program_id,
                  'value' => $data->program,
              ];
          }
      }

    } else if ($code == 'application-program-list-offered') {

      $application_id = $this->request->getQuery('id');

      $student = $this->StudentApplications->get($application_id);

      $program_list = $this->CollegePrograms->find()
          ->where([

              'visible' => 1,

              'passing_rate <=' => $student['rate']

          ])

          ->all();

      if(!empty($program_list)){

        foreach ($program_list as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['name']

          );

        }

      }

    } else if ($code == 'student-application-details') {

      $application_id = $this->request->getQuery('id');

      $datas['StudentApplication'] = $this->StudentApplications->get($application_id);

    } else if ($code == 'prescription-list') {


      $tmp = $this->Prescriptions->find()

        ->where([

          "visible" => 1,

        ])

        ->order([

          'id' => 'ASC'

        ])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['name']

          );

        }

      }

    } else if ($code == 'employee-designation-category-list') {

      $tmp = $this->EmployeeDesignationCategory->find('all', array(

        'conditions' => array(

          'EmployeeDesignationCategory.visible' => true,

        ),

        'order' => array(

          'EmployeeDesignationCategory.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['EmployeeDesignationCategory']['id'],

            'value'   => $data['EmployeeDesignationCategory']['name']

          );

        }

      }

    } else if ($code == 'degree-list') {

      $tmp = $this->Degree->find('all', array(

        'conditions' => array(

          'Degree.visible' => true,

        ),

        'order' => array(

          'Degree.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['Degree']['id'],

            'value'   => $data['Degree']['code'].' - '.$data['Degree']['name']

          );

        }

      }

    } else if ($code == 'income-list') {

      $tmp = $this->StudentMonthlyFamilyIncome->find('all', array(

        'conditions' => array(

          'StudentMonthlyFamilyIncome.visible' => true,

        ),

        'order' => array(

          'StudentMonthlyFamilyIncome.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['StudentMonthlyFamilyIncome']['id'],

            'value'   => $data['StudentMonthlyFamilyIncome']['monthly_income']

          );

        }

      }

    } else if ($code == 'province-list') {

      $tmp = $this->Provinces->find()
          ->where(['visible' => 1])
          ->order(['provDesc' => 'ASC'])
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['provDesc']

          );

        }

      }

    } else if ($code == 'town-list') {

      $conditions = array();

      $conditions['visible'] = 1;

      if($this->request->getQuery('province_id')){

        $province_id = $this->request->getQuery('province_id');

        $provinceData = $this->Provinces->get($province_id);

        $conditions['provCode'] = $provinceData['provCode'];

      }

      $tmp = $this->Municipalities->find()
          ->where($conditions)
          ->order(['citymunDesc' => 'ASC'])
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['citymunDesc']

          );

        }

      }

    } else if ($code == 'barangay-list') {

      $conditions = array();

      $conditions['visible'] = 1;

      if($this->request->getQuery('town_id')){

        $town_id = $this->request->getQuery('town_id');

        $townData = $this->Municipalities->get($town_id);

        $conditions['citymunCode'] = $townData['citymunCode'];

      }

      $tmp = $this->Barangays->find()
          ->where($conditions)
          ->order(['brgyDesc' => 'ASC'])
          ->all();


      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['brgyDesc']

          );

        }

      }

    }else if ($code == 'check-transaction') {

      $purpose = $this->request->getQuery('purpose');

      $student_id = $this->request->getQuery('student_id');
     
      $tmp = $this->RequestForms->find()

        ->where([

          'visible' => 1,

          'approve' => 0,

          'purpose' => $purpose,

          'student_id' => $student_id

        ])

      ->count();

      if($tmp == 0){

        $datas = 1;

      }else{

        $datas = 0;

      }

    }else if ($code == 'check-student-ledger') {

      $student_id = $this->request->getQuery('student_id');
     
      $tmp = $this->StudentLedgers->find()

        ->where([

          'visible' => 1,

          'student_id' => $student_id,

          'balance >' => 0,

          'status IS' => NULL

        ])

      ->count();

      if($tmp > 1){

        $datas = 0;

      }else{

        $datas = 1;

      }

    }else if ($code == 'check-student-check-outs') {

      $student_id = $this->request->getQuery('student_id');

      $lrm = $this->LearningResourceMembers->find()

          ->where([

            'visible' => 1,

            'student_id' => $student_id

          ])

          ->first();

      $lrm_id = $lrm['id'];
     
      $tmp = $this->Checkouts->find()

        ->contain([

          'CheckOutSubs' => [

            'conditions' => [

              'CheckOutSubs.visible' => 1,

              'CheckOutSubs.returned' => 0

            ],

          ],

        ])

        ->where([

          'Checkouts.visible' => 1,

          'Checkouts.learning_resource_member_id' => $lrm_id

        ])

      ->first();

      // var_dump($tmp['check_out_subs']);

      if(count($tmp['check_out_subs']) > 0){

        $datas = 0;

      }else{

        $datas = 1;

      }

    }else if ($code == 'check-user') {

      $for_medical_interview = 0;

      $for_schedule = 0;

      $show_self_enrollment = 0;

      $enrolment_count = 0;

      $grades = array();

      $user = $this->Auth->user();

      $student_data = $this->Students->get($user['studentId']);

      if($user['roleId'] == 13){ // STUDENT

        $id='';

        $term =0;

        $id = $user['id'];

        $term = $student_data['year_term_id'];

        $student_id = $student_data['id'];

        $tmp = "

          SELECT

            StudentEnrolledCourse.*

          FROM

            student_enrolled_courses as StudentEnrolledCourse

          WHERE

            StudentEnrolledCourse.visible = true AND

            StudentEnrolledCourse.year_term_id = $term AND

            StudentEnrolledCourse.student_id = $student_id

        ";

        $connection = $this->StudentEnrolledCourses->getConnection();

        $grades = $connection->execute($tmp)->fetchAll('assoc');

        $tmp = "

          SELECT 

            StudentApplication.*

          FROM  

            students as Student LEFT JOIN 

            student_applications as StudentApplication ON StudentApplication.id = Student.student_applicant_id 

          WHERE 

            Student.id = $student_id

        ";

        $connection = $this->StudentApplications->getConnection();

        $student_details = $connection->execute($tmp)->fetchAll('assoc');

        $for_medical_interview = $student_details[0]['approve'] == 1 ? 1 : 0;

        $for_schedule = $student_details[0]['status'] == 'REQUESTED' ? 1 : 0;

        //CHECKING IF STUDENT HAS PENDING PAYMENT IN APARTELLE

          $pending_payment_apartelle = $this->StudentLedgers->find()->where([

            "StudentLedgers.visible" => 1,

            'StudentLedgers.student_id' => $student_id,

            "StudentLedgers.status IS" => NULL,

            'StudentLedgers.remarks' => 'Apartelle/Dormitory Balance'

          ])->count();

        //END

        //FOR CHECKING IF STUDENT IS REGULAR OR IRREGULAR

          $student_data = $this->Students->get($student_id);

          if($student_data['status'] == 'IRREGULAR' || $student_data['status'] == 'INCOMPLETE'){

            $show_self_enrollment = 1;

          }

        //END 

        //CHECKING IF STUDENT IS ALREADY ENROLLED

          $student_data = $this->Students->get($user['studentId']);

          $year_term_id = $student_data['year_term_id'];

          $enrolment_count = $this->StudentEnrollments->find()

            ->where([

              'visible' => 1,

              'student_id' => $user['studentId'],

              'year_term_id' => $year_term_id

            ])

          ->count();

        //END

        $datas = array(

          'grades' => $grades,

          'for_medical_interview' => $for_medical_interview,

          'for_schedule' => $for_schedule,

          'pending_payment_apartelle' => $pending_payment_apartelle

        );

      }

    } else if ($code == 'zip-list') {

      $conditions = array();

      $conditions['visible'] = 1;

      if($this->request->getQuery('town_id')){

        $town_id = $this->request->getQuery('town_id');

        $townData = $this->Municipalities->get($town_id);
        
        $conditions['LOWER(citymunDesc)'] = strtolower($townData['citymunDesc']);

      }

      $tmp = $this->ZipCodes->find()
          ->where($conditions)
          ->first();

      if(!empty($tmp)){

        $datas = $tmp['zip_code'];

      }

    } else if ($code == 'student-department-list') {

      $tmp = $this->AccountFee->query("

        SELECT

          CollegeDepartmentProgram.id,

          Department.code,

          CollegeProgram.name

        FROM

          college_departments as CollegeDepartment LEFT JOIN

          college_department_programs as CollegeDepartmentProgram ON CollegeDepartmentProgram.college_department_id = CollegeDepartment.id LEFT JOIN

          departments as Department ON Department.id = CollegeDepartment.department_id LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = CollegeDepartmentProgram.program_id

        WHERE

          CollegeDepartment.active = true AND

          CollegeDepartment.visible = true AND

          CollegeDepartmentProgram.visible = true AND

          Department.visible = true AND

          CollegeProgram.visible = true

        GROUP BY

          CollegeProgram.id

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['CollegeDepartmentProgram']['id'],

            'value'   => $data['Department']['code'].'::'.$data['CollegeProgram']['name']

          );

        }

      }

    } else if ($code == 'student-program-list') {

      $tmp = $this->AccountFee->query("

        SELECT

          CollegeProgram.id,

          CollegeProgram.code,

          CollegeProgram.name

        FROM

          college_department_programs as CollegeDepartmentProgram LEFT JOIN

          college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = CollegeDepartmentProgram.program_id

        WHERE

          CollegeDepartmentProgram.visible = true AND

          CollegeDepartment.visible = true AND

          CollegeProgram.visible = true

        GROUP BY

          CollegeDepartmentProgram.id

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['CollegeProgram']['id'],

            'value'   => $data['CollegeProgram']['code'].'::'.$data['CollegeProgram']['name']

          );

        }

      }

    } else if ($code == 'student-curriculum-list') {

      $tmp = $this->AccountFee->query("

        SELECT

          Curriculum.id,

          CollegeProgram.code,

          Curriculum.description,

          Curriculum.code

        FROM

          college_department_programs as CollegeDepartmentProgram LEFT JOIN

          college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = CollegeDepartmentProgram.program_id LEFT JOIN

          curriculums as Curriculum ON Curriculum.id = CollegeDepartmentProgram.curriculum_id

        WHERE

          CollegeDepartmentProgram.active = true AND

          CollegeDepartmentProgram.visible = true AND

          CollegeDepartment.visible = true AND

          CollegeProgram.visible = true AND

          Curriculum.visible = true

        GROUP BY

          Curriculum.id

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['Curriculum']['id'],

            'value'   => $data['CollegeProgram']['code'].'::'.$data['Curriculum']['description'].'('.$data['Curriculum']['code'].')'

          );

        }

      }

    } else if ($code == 'search-employees') {

      $page = $this->request->getQuery('page', 1);

      $conditions = [];

      if ($this->request->getQuery('search')) {

        $search = $this->request->getQuery('search');

        $search = strtolower($search);

        $conditions['search'] = $search;

      }

      $employeesTable = TableRegistry::getTableLocator()->get('Employees');

      $limit = 25;

      $employeeData = $employeesTable->paginate($employeesTable->getAllEmployee($conditions, $limit, $page), [

        'extra' => [

          'conditions' => $conditions

        ],

        'page' => $page,

        'limit' => $limit

      ]);

      $employees = $employeeData['data'];

      $paginator = $employeeData['pagination'];

      $datas = [];

      foreach ($employees as $employee) {

        $datas[] = array(

          'id'   => $employee['id'],

          'code' =>  $employee['code'],

          'name' =>  $employee['full_name'],

          'college_id' =>  $employee['college_id'],

        );

      }

      $datas = array(

        'result'     => $datas,

        'paginator' => $paginator

      );

    } else if ($code == 'close-student-curriculum-course-list') {

      $set = $this->Global->EnrollmentSettings('class_schedule_by_campus');

      $conditions = array();

      $curriculum = '';

      if(isset($this->request->query['curriculum_id'])){

        $curriculum_id = $this->request->query['curriculum_id'];

        $curriculum = "AND CurriculumCourse.curriculum_id = $curriculum_id";

      }

      $academic_term = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

        $academic_term = "AND CourseSchedule.academic_term_id = $academic_term_id";

      }

      $student = '';

      $campus = '';

      $college = '';

      $year_level = '';

      $studentData = array();

      $check = false;

      if(!is_null($this->Session->read('Auth.User.studentId'))){

        $student_id = $this->Session->read('Auth.User.studentId');

        $studentData = $this->Student->find('first', array(

          'contain' => array(
          
            'College' => array(

              'conditions' => array(

                'College.visible' => true

              ),

            ),

          
            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

        $campus_id = $studentData['College']['campus_id'];

        if(!is_null($campus_id)){

          $campus = "AND College.campus_id = $campus_id";

        }

        $college_id = $studentData['College']['id'];

        if(!is_null($college_id)){
            
          $college = "AND CollegeDepartment.college_id = $college_id";

        }

        if(!empty($studentData)){

          if($studentData['Degree']['close']){

            $check = true;

          }

          $stud_yl = $studentData['Student']['year_level'];

          $year_level_term = $this->YearLevelTerm->find('first',array(

            'conditions' => array(

              'YearLevelTerm.year_level' => $stud_yl,

              'YearLevelTerm.semester' => $academicData['AcademicTerm']['semester']

            ),

          ));

          if(!empty($year_level_term)){

            $year_level_term_id = $year_level_term['YearLevelTerm']['id'];

            $year_level = "AND CurriculumCourse.year_term_id = $year_level_term_id";

          }

        }

      }

      $tmp = $this->YearLevelTerm->query("

        SELECT

          YearLevelTerm.id,

          YearLevelTerm.description

        FROM

          curriculum_courses as CurriculumCourse LEFT JOIN

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = CurriculumCourse.year_term_id

        WHERE

          CurriculumCourse.visible = true AND

          YearLevelTerm.visible = true $curriculum

        GROUP BY

          CurriculumCourse.year_term_id

      ");
      
      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $year_term_id = $data['YearLevelTerm']['id'];
          
          $subjects = $this->CurriculumCourse->query("SELECT * FROM (

            SELECT 

              CurriculumCourse.*,

              CONCAT(Course.code,'::',Course.title) as title

            FROM

              curriculum_courses as CurriculumCourse LEFT JOIN

              courses as Course ON Course.id = CurriculumCourse.course_id LEFT JOIN

              (

                SELECT

                  CourseSchedule.course_id,

                  count(*) as total

                FROM

                  course_schedules AS CourseSchedule

                WHERE

                  CourseSchedule.visible = true

              ) as CourseSchedule ON CourseSchedule.course_id = CurriculumCourse.id LEFT JOIN

              (

                SELECT

                  CourseSchedule.course_id,

                  count(*) as total

                FROM

                  course_schedules AS CourseSchedule LEFT JOIN

                  subject_lists as SubjectList ON SubjectList.course_schedule_id = CourseSchedule.id

                WHERE

                  CourseSchedule.visible = true AND

                  SubjectList.visible = true AND

                  SubjectList.remarks = 'PASSED'

              ) as SubjectList ON SubjectList.course_id = CurriculumCourse.id

            WHERE 

              CurriculumCourse.visible  = true AND

              Course.visible = true AND

              Course.visible = true AND

              CurriculumCourse.year_term_id = $year_term_id $curriculum 

              -- AND

              -- IFNULL(CourseSchedule.total,0) > 0 AND

              -- IFNULL(SubjectList.total,0) <= 0
 
          ) as CurriculumCourse ");

          if(!empty($subjects)){

            foreach ($subjects as $key => $value) {

              $course_id = $value['CurriculumCourse']['course_id'];

              if(!$check){

                $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                  SELECT 

                    CourseSchedule.id,

                    IFNULL(CourseSchedule.class_name,'-') AS class_name,

                    CurriculumCourse.course_id,

                    CourseSchedule.max_size

                  FROM

                    course_schedules as CourseSchedule LEFT JOIN

                    curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id

                  WHERE 

                    CourseSchedule.visible = true AND

                    CurriculumCourse.visible = true AND

                    CourseSchedule.is_active = true AND

                    CurriculumCourse.active = true AND

                    CourseSchedule.active = true $academic_term $curriculum AND

                    CourseSchedule.course_id = $course_id

                  ORDER BY

                    CourseSchedule.course_id

                ) AS CourseSchedule "));

                if(!empty($schedule)){

                  foreach ($schedule as $s => $scheds) {

                    $course_schedule_id = $scheds['id'];

                    $course_id = $scheds['course_id'];

                    $sched = '';

                    $checkSchedule = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        class_schedules as ClassSchedule

                      WHERE 

                        ClassSchedule.visible = true AND

                        ClassSchedule.active = true AND

                        ClassSchedule.course_schedule_id = $course_schedule_id

                    ");

                    $count = $checkSchedule[0][0]['total'];

                    if($count > 0){

                      $classname = $scheds['class_name'];

                      $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                    }

                    $checkCurriculum = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        curriculum_courses as CurriculumCourse

                      WHERE 

                        CurriculumCourse.visible = true $curriculum AND

                        CurriculumCourse.course_id = $course_id

                    ");

                    $countCurriculum = $checkCurriculum[0][0]['total'];

                    if($countCurriculum > 0){

                      $numofenrolledstudents = 0;

                      $countPreSubjects = $this->PreregistrationSubject->query("

                        SELECT 

                          count(*) as total

                        FROM

                          preregistration_subjects as PreregistrationSubject

                        WHERE 

                          PreregistrationSubject.visible = true AND

                          PreregistrationSubject.course_schedule_id = $course_schedule_id

                      ");

                      $countSubjectList = $this->SubjectList->query("

                        SELECT 

                          count(*) as total

                        FROM

                          subject_lists as SubjectList

                        WHERE 

                          SubjectList.visible = true AND

                          SubjectList.course_schedule_id = $course_schedule_id

                      ");

                      $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                      $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                      $classSchedules = $this->ClassSchedule->query("

                        SELECT 

                          ClassSchedule.id,

                          IFNULL(Room.name,'') as room_name,

                          ClassSchedule.start_time,

                          ClassSchedule.end_time,

                          ClassSchedule.day,

                          Employee.full_name,

                          CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                        FROM

                          class_schedules as ClassSchedule LEFT JOIN

                          (

                            SELECT

                              Room.id,

                              Room.name

                            FROM

                              rooms as Room

                          ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                          (

                            SELECT

                              Employee.id,

                              CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                            FROM

                              employees as Employee

                          ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                        WHERE 

                          ClassSchedule.visible = true AND

                          ClassSchedule.active = true AND

                          ClassSchedule.course_schedule_id = $course_schedule_id

                        GROUP BY

                          groupings

                      ");

                      if(!empty($classSchedules)){

                        foreach ($classSchedules as $k => $cs) {

                          $timestring1 = $cs['ClassSchedule']['start_time'];

                          $count1 = strlen($timestring1);

                          if($count1 == 3){

                            $hour1 = '0'.substr($timestring1,0,1);

                            $minute1 = substr($timestring1,1,3);

                          }else{

                            $hour1 = substr($timestring1,0,2);

                            $minute1 = substr($timestring1,2,4);

                          }

                          $timestring2 = $cs['ClassSchedule']['end_time'];

                          $count2 = strlen($timestring2);

                          if($count2 == 3){

                            $hour2 = '0'.substr($timestring2,0,1);

                            $minute2 = substr($timestring2,1,3);

                          } else {

                            $hour2 = substr($timestring2,0,2);

                            $minute2 = substr($timestring2,2,4);

                          }

                          $start = $hour1.':'.$minute1;      

                          $end = $hour2.':'.$minute2;

                          $d1 = fdate($start,'h:i A');

                          $d2 = fdate($end,'h:i A');

                          $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                        }

                      }

                    }

                    $schedule[$s]['sched'] = $sched;

                  }

                }

                $subjects[$key]['Schedule'] = !empty($schedule) ? $schedule : array();
              
              }else{

                if($set == 1){

                  $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                    SELECT

                      CourseSchedule.id,

                      IFNULL(CourseSchedule.class_name,'-') AS class_name,

                      CurriculumCourse.course_id,

                      CourseSchedule.max_size

                    FROM

                      course_schedules as CourseSchedule LEFT JOIN

                      curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id LEFT JOIN

                      college_blocks as CollegeBlock ON CollegeBlock.id = CourseSchedule.block_id LEFT JOIN

                      college_department_programs as CollegeDepartmentProgram ON CollegeDepartmentProgram.id = CollegeBlock.program_id LEFT JOIN

                      college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

                      colleges as College ON College.id = CollegeDepartment.college_id

                    WHERE 

                      CourseSchedule.visible = true AND

                      CurriculumCourse.visible = true AND

                      CollegeBlock.visible = true AND

                      CollegeDepartment.visible = true AND

                      CollegeDepartmentProgram.visible = true AND

                      CourseSchedule.is_active = true AND

                      CurriculumCourse.active = true AND

                      CourseSchedule.active = true $academic_term $curriculum $campus AND

                      CourseSchedule.course_id = $course_id

                    ORDER BY

                      CourseSchedule.course_id ASC

                  ) AS CourseSchedule "));

                  if(!empty($schedule)){

                    foreach ($schedule as $s => $scheds) {

                      $course_schedule_id = $scheds['id'];

                      $course_id = $scheds['course_id'];

                      $sched = '';

                      $checkSchedule = $this->ClassSchedule->query("

                        SELECT 

                          count(*) as total

                        FROM

                          class_schedules as ClassSchedule

                        WHERE 

                          ClassSchedule.visible = true AND

                          ClassSchedule.active = true AND

                          ClassSchedule.course_schedule_id = $course_schedule_id

                      ");

                      $count = $checkSchedule[0][0]['total'];

                      if($count > 0){

                        $classname = $scheds['class_name'];

                        $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                      }

                      $checkCurriculum = $this->ClassSchedule->query("

                        SELECT 

                          count(*) as total

                        FROM

                          curriculum_courses as CurriculumCourse

                        WHERE 

                          CurriculumCourse.visible = true $curriculum AND

                          CurriculumCourse.course_id = $course_id

                      ");

                      $countCurriculum = $checkCurriculum[0][0]['total'];

                      if($countCurriculum > 0){

                        $numofenrolledstudents = 0;

                        $countPreSubjects = $this->PreregistrationSubject->query("

                          SELECT 

                            count(*) as total

                          FROM

                            preregistration_subjects as PreregistrationSubject

                          WHERE 

                            PreregistrationSubject.visible = true AND

                            PreregistrationSubject.course_schedule_id = $course_schedule_id

                        ");

                        $countSubjectList = $this->SubjectList->query("

                          SELECT 

                            count(*) as total

                          FROM

                            subject_lists as SubjectList

                          WHERE 

                            SubjectList.visible = true AND

                            SubjectList.course_schedule_id = $course_schedule_id

                        ");

                        $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                        $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                        $classSchedules = $this->ClassSchedule->query("

                          SELECT 

                            ClassSchedule.id,

                            IFNULL(Room.name,'') as room_name,

                            ClassSchedule.start_time,

                            ClassSchedule.end_time,

                            ClassSchedule.day,

                            Employee.full_name,

                            CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                          FROM

                            class_schedules as ClassSchedule LEFT JOIN

                            (

                              SELECT

                                Room.id,

                                Room.name

                              FROM

                                rooms as Room

                            ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                            (

                              SELECT

                                Employee.id,

                                CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                              FROM

                                employees as Employee

                            ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                          WHERE 

                            ClassSchedule.visible = true AND

                            ClassSchedule.active = true AND

                            ClassSchedule.course_schedule_id = $course_schedule_id

                          groupings

                        ");

                        if(!empty($classSchedules)){

                          foreach ($classSchedules as $k => $cs) {

                            $timestring1 = $cs['ClassSchedule']['start_time'];

                            $count1 = strlen($timestring1);

                            if($count1 == 3){

                              $hour1 = '0'.substr($timestring1,0,1);

                              $minute1 = substr($timestring1,1,3);

                            }else{

                              $hour1 = substr($timestring1,0,2);

                              $minute1 = substr($timestring1,2,4);

                            }

                            $timestring2 = $cs['ClassSchedule']['end_time'];

                            $count2 = strlen($timestring2);

                            if($count2 == 3){

                              $hour2 = '0'.substr($timestring2,0,1);

                              $minute2 = substr($timestring2,1,3);

                            } else {

                              $hour2 = substr($timestring2,0,2);

                              $minute2 = substr($timestring2,2,4);

                            }

                            $start = $hour1.':'.$minute1;      

                            $end = $hour2.':'.$minute2;

                            $d1 = fdate($start,'h:i A');

                            $d2 = fdate($end,'h:i A');

                            $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                          }

                        }

                      }

                      $schedule[$s]['sched'] = $sched;

                    }

                  }

                  $subjects[$key]['Schedule'] = !empty($schedule) ? $schedule : array();

                }else{

                  $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                    SELECT 

                      CourseSchedule.id,

                      IFNULL(CourseSchedule.class_name,'-') AS class_name,

                      CurriculumCourse.course_id,

                      CourseSchedule.max_size

                    FROM

                      course_schedules as CourseSchedule LEFT JOIN

                      curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id LEFT JOIN

                      college_blocks as CollegeBlock ON CollegeBlock.id = CourseSchedule.block_id LEFT JOIN

                      college_department_programs as CollegeDepartmentProgram ON CollegeDepartmentProgram.id = CollegeBlock.program_id LEFT JOIN

                      college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

                      colleges as College ON College.id = CollegeDepartment.college_id

                    WHERE 

                      CourseSchedule.visible = true AND

                      CurriculumCourse.visible = true AND

                      CollegeBlock.visible = true AND

                      CollegeDepartment.visible = true AND

                      CollegeDepartmentProgram.visible = true AND

                      CourseSchedule.is_active = true AND

                      CurriculumCourse.active = true AND

                      CourseSchedule.active = true $academic_term $curriculum $college AND

                      CourseSchedule.course_id = $course_id

                    ORDER BY

                      CourseSchedule.course_id ASC

                  ) AS CourseSchedule "));

                  if(!empty($schedule)){

                    foreach ($schedule as $s => $scheds) {

                      $course_schedule_id = $scheds['id'];

                      $course_id = $scheds['course_id'];

                      $sched = '';

                      $checkSchedule = $this->ClassSchedule->query("

                        SELECT 

                          count(*) as total

                        FROM

                          class_schedules as ClassSchedule

                        WHERE 

                          ClassSchedule.visible = true AND

                          ClassSchedule.active = true AND

                          ClassSchedule.course_schedule_id = $course_schedule_id

                      ");

                      $count = $checkSchedule[0][0]['total'];

                      if($count > 0){

                        $classname = $scheds['class_name'];

                        $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                      }

                      $checkCurriculum = $this->ClassSchedule->query("

                        SELECT 

                          count(*) as total

                        FROM

                          curriculum_courses as CurriculumCourse

                        WHERE 

                          CurriculumCourse.visible = true $curriculum AND

                          CurriculumCourse.course_id = $course_id

                      ");

                      $countCurriculum = $checkCurriculum[0][0]['total'];

                      if($countCurriculum > 0){

                        $numofenrolledstudents = 0;

                        $countPreSubjects = $this->PreregistrationSubject->query("

                          SELECT 

                            count(*) as total

                          FROM

                            preregistration_subjects as PreregistrationSubject

                          WHERE 

                            PreregistrationSubject.visible = true AND

                            PreregistrationSubject.course_schedule_id = $course_schedule_id

                        ");

                        $countSubjectList = $this->SubjectList->query("

                          SELECT 

                            count(*) as total

                          FROM

                            subject_lists as SubjectList

                          WHERE 

                            SubjectList.visible = true AND

                            SubjectList.course_schedule_id = $course_schedule_id

                        ");

                        $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                        $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                        $classSchedules = $this->ClassSchedule->query("

                          SELECT 

                            ClassSchedule.id,

                            IFNULL(Room.name,'') as room_name,

                            ClassSchedule.start_time,

                            ClassSchedule.end_time,

                            ClassSchedule.day,

                            Employee.full_name,

                            CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                          FROM

                            class_schedules as ClassSchedule LEFT JOIN

                            (

                              SELECT

                                Room.id,

                                Room.name

                              FROM

                                rooms as Room

                            ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                            (

                              SELECT

                                Employee.id,

                                CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                              FROM

                                employees as Employee

                            ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                          WHERE 

                            ClassSchedule.visible = true AND

                            ClassSchedule.active = true AND

                            ClassSchedule.course_schedule_id = $course_schedule_id

                          groupings

                        ");

                        if(!empty($classSchedules)){

                          foreach ($classSchedules as $k => $cs) {

                            $timestring1 = $cs['ClassSchedule']['start_time'];

                            $count1 = strlen($timestring1);

                            if($count1 == 3){

                              $hour1 = '0'.substr($timestring1,0,1);

                              $minute1 = substr($timestring1,1,3);

                            }else{

                              $hour1 = substr($timestring1,0,2);

                              $minute1 = substr($timestring1,2,4);

                            }

                            $timestring2 = $cs['ClassSchedule']['end_time'];

                            $count2 = strlen($timestring2);

                            if($count2 == 3){

                              $hour2 = '0'.substr($timestring2,0,1);

                              $minute2 = substr($timestring2,1,3);

                            } else {

                              $hour2 = substr($timestring2,0,2);

                              $minute2 = substr($timestring2,2,4);

                            }

                            $start = $hour1.':'.$minute1;      

                            $end = $hour2.':'.$minute2;

                            $d1 = fdate($start,'h:i A');

                            $d2 = fdate($end,'h:i A');

                            $sched .= ' '.dayview($cs['ClassSchedule']['day']).' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                          }

                        }

                      }

                      $schedule[$s]['sched'] = $sched;

                    }

                  }

                  $subjects[$key]['Schedule'] = !empty($schedule) ? $schedule : array();

                }

              }

            }

          }

          $datas[] = array(

            'id'         => $data['YearLevelTerm']['id'],

            'value'      => $data['YearLevelTerm']['description'],

            'subjects'   => !empty($subjects) ? $subjects : array()

          );

        }

      }

    } else if ($code == 'open-student-curriculum-course-list') {

      $set = $this->Global->EnrollmentSettings('class_schedule_by_campus');

      $conditions = array();

      $curriculum = '';

      $curriculum_advising = '';

      $campus = '';

      $college = '';

      if(isset($this->request->query['curriculum_id'])){

        $curriculum_id = $this->request->query['curriculum_id'];

        $curriculum = "AND CurriculumCourse.curriculum_id = $curriculum_id";

        $curriculum_advising = "AND StudentAdvising.curriculum_id = $curriculum_id";

      }

      $academic_term = '';

      $academic_term_advising = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

        $academic_term_advising = "AND StudentAdvising.academic_term_id = $academic_term_id";

        $academic_term = "AND CourseSchedule.academic_term_id = $academic_term_id";

      }

      $studentData = array();

      $studreg = false;

      $student = '';

      $student_adivising = '';

      $year_level = '';

      $check = false;

      if(!is_null($this->Session->read('Auth.User.studentId'))){

        $student_id = $this->Session->read('Auth.User.studentId');

        $student_adivising = "AND StudentAdvising.student_id = $student_id";

        $studentData = $this->Student->find('first', array(

          'contain' => array(
          
            'College' => array(

              'conditions' => array(

                'College.visible' => true

              ),

            ),

          
            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

        if(!empty($studentData)){

          if($studentData['Student']['regular_yes']){

            $studreg = true;

          }

          $campus_id = $studentData['College']['campus_id'];

          if(!is_null($campus_id)){

            $campus = "AND College.campus_id = $campus_id";

          }

          $college_id = $studentData['College']['id'];

          if(!is_null($college_id)){
              
            $college = "AND CollegeDepartment.college_id = $college_id";

          }

          if($studentData['Degree']['close']){

            $check = true;

          }

          $year_level = '';

          $stud_yl = $studentData['Student']['year_level'];

          $year_level_term = $this->YearLevelTerm->find('first',array(

            'conditions' => array(

              'YearLevelTerm.year_level' => $stud_yl,

              'YearLevelTerm.semester' => $academicData['AcademicTerm']['semester']

            ),

          ));

          if(!empty($year_level_term)){

            $year_level_term_id = $year_level_term['YearLevelTerm']['id'];

            $year_level = "AND CurriculumCourse.year_term_id = $year_level_term_id";

          }

        }

      }

      if($studreg){
      
        $tmp = $this->CurriculumCourse->query("

          SELECT

            CurriculumCourse.id,

            Course.name,

            CurriculumCourse.course_id

          FROM

            curriculum_courses as CurriculumCourse LEFT JOIN

            (

              SELECT

                Course.id,

                CONCAT(Course.code,'::',Course.title) as name

              FROM

                courses as Course
              
              WHERE

                Course.visible = true

            ) as Course ON Course.id = CurriculumCourse.course_id

          WHERE

            CurriculumCourse.visible = true $curriculum $year_level

          GROUP BY

            CurriculumCourse.id

        ");

        if(!empty($tmp)){

          foreach ($tmp as $k => $data) {

            $course_id = $data['CurriculumCourse']['course_id'];

            if(!$check){

              $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                SELECT 

                  CourseSchedule.id,

                  IFNULL(CourseSchedule.class_name,'-') AS class_name,

                  CurriculumCourse.course_id,

                  CourseSchedule.max_size

                FROM

                  course_schedules as CourseSchedule LEFT JOIN

                  curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id

                WHERE 

                  CourseSchedule.visible = true AND

                  CurriculumCourse.visible = true AND

                  CourseSchedule.is_active = true AND

                  CurriculumCourse.active = true AND

                  CourseSchedule.active = true $academic_term $curriculum AND

                  CourseSchedule.course_id = $course_id

                ORDER BY

                  CourseSchedule.course_id

              ) AS CourseSchedule "));

              if(!empty($schedule)){

                foreach ($schedule as $key => $scheds) {

                  $course_schedule_id = $scheds['id'];

                  $course_id = $scheds['course_id'];

                  $sched = '';

                  $checkSchedule = $this->ClassSchedule->query("

                    SELECT 

                      count(*) as total

                    FROM

                      class_schedules as ClassSchedule

                    WHERE 

                      ClassSchedule.visible = true AND

                      ClassSchedule.active = true AND

                      ClassSchedule.course_schedule_id = $course_schedule_id

                  ");

                  $count = $checkSchedule[0][0]['total'];

                  if($count > 0){

                    $classname = $scheds['class_name'];

                    $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                  }

                  $checkCurriculum = $this->ClassSchedule->query("

                    SELECT 

                      count(*) as total

                    FROM

                      curriculum_courses as CurriculumCourse

                    WHERE 

                      CurriculumCourse.visible = true $curriculum AND

                      CurriculumCourse.course_id = $course_id

                  ");

                  $countCurriculum = $checkCurriculum[0][0]['total'];

                  if($countCurriculum > 0){

                    $numofenrolledstudents = 0;

                    $countPreSubjects = $this->PreregistrationSubject->query("

                      SELECT 

                        count(*) as total

                      FROM

                        preregistration_subjects as PreregistrationSubject

                      WHERE 

                        PreregistrationSubject.visible = true AND

                        PreregistrationSubject.course_schedule_id = $course_schedule_id

                    ");

                    $countSubjectList = $this->SubjectList->query("

                      SELECT 

                        count(*) as total

                      FROM

                        subject_lists as SubjectList

                      WHERE 

                        SubjectList.visible = true AND

                        SubjectList.course_schedule_id = $course_schedule_id

                    ");

                    $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                    $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                    $classSchedules = $this->ClassSchedule->query("

                      SELECT 

                        ClassSchedule.id,

                        IFNULL(Room.name,'') as room_name,

                        ClassSchedule.start_time,

                        ClassSchedule.end_time,

                        ClassSchedule.day,

                        Employee.full_name,

                        CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                      FROM

                        class_schedules as ClassSchedule LEFT JOIN

                        (

                          SELECT

                            Room.id,

                            Room.name

                          FROM

                            rooms as Room

                        ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                        (

                          SELECT

                            Employee.id,

                            CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                          FROM

                            employees as Employee

                        ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                      WHERE 

                        ClassSchedule.visible = true AND

                        ClassSchedule.active = true AND

                        ClassSchedule.course_schedule_id = $course_schedule_id

                      groupings

                    ");

                    if(!empty($classSchedules)){

                      foreach ($classSchedules as $key => $cs) {

                        $timestring1 = $cs['ClassSchedule']['start_time'];

                        $count1 = strlen($timestring1);

                        if($count1 == 3){

                          $hour1 = '0'.substr($timestring1,0,1);

                          $minute1 = substr($timestring1,1,3);

                        }else{

                          $hour1 = substr($timestring1,0,2);

                          $minute1 = substr($timestring1,2,4);

                        }

                        $timestring2 = $cs['ClassSchedule']['end_time'];

                        $count2 = strlen($timestring2);

                        if($count2 == 3){

                          $hour2 = '0'.substr($timestring2,0,1);

                          $minute2 = substr($timestring2,1,3);

                        } else {

                          $hour2 = substr($timestring2,0,2);

                          $minute2 = substr($timestring2,2,4);

                        }

                        $start = $hour1.':'.$minute1;      

                        $end = $hour2.':'.$minute2;

                        $d1 = fdate($start,'h:i A');

                        $d2 = fdate($end,'h:i A');

                        $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                      }

                    }

                  }

                  $schedule[$key]['sched'] = $sched;

                }

              }
            
            }else{

              if($set == 1){

                $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                  SELECT

                    CourseSchedule.id,

                    IFNULL(CourseSchedule.class_name,'-') AS class_name,

                    CurriculumCourse.course_id,

                    CourseSchedule.max_size

                  FROM

                    course_schedules as CourseSchedule LEFT JOIN

                    curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id LEFT JOIN

                    college_blocks as CollegeBlock ON CollegeBlock.id = CourseSchedule.block_id LEFT JOIN

                    college_department_programs as CollegeDepartmentProgram ON CollegeDepartmentProgram.id = CollegeBlock.program_id LEFT JOIN

                    college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

                    colleges as College ON College.id = CollegeDepartment.college_id

                  WHERE 

                    CourseSchedule.visible = true AND

                    CurriculumCourse.visible = true AND

                    CollegeBlock.visible = true AND

                    CollegeDepartment.visible = true AND

                    CollegeDepartmentProgram.visible = true AND

                    CourseSchedule.is_active = true AND

                    CurriculumCourse.active = true AND

                    CourseSchedule.active = true $academic_term $curriculum $campus AND

                    CourseSchedule.course_id = $course_id

                  ORDER BY

                    CourseSchedule.course_id ASC

                ) AS CourseSchedule "));

                if(!empty($schedule)){

                  foreach ($schedule as $key => $scheds) {

                    $course_schedule_id = $scheds['id'];

                    $course_id = $scheds['course_id'];

                    $sched = '';

                    $checkSchedule = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        class_schedules as ClassSchedule

                      WHERE 

                        ClassSchedule.visible = true AND

                        ClassSchedule.active = true AND

                        ClassSchedule.course_schedule_id = $course_schedule_id

                    ");

                    $count = $checkSchedule[0][0]['total'];

                    if($count > 0){

                      $classname = $scheds['class_name'];

                      $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                    }

                    $checkCurriculum = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        curriculum_courses as CurriculumCourse

                      WHERE 

                        CurriculumCourse.visible = true $curriculum AND

                        CurriculumCourse.course_id = $course_id

                    ");

                    $countCurriculum = $checkCurriculum[0][0]['total'];

                    if($countCurriculum > 0){

                      $numofenrolledstudents = 0;

                      $countPreSubjects = $this->PreregistrationSubject->query("

                        SELECT 

                          count(*) as total

                        FROM

                          preregistration_subjects as PreregistrationSubject

                        WHERE 

                          PreregistrationSubject.visible = true AND

                          PreregistrationSubject.course_schedule_id = $course_schedule_id

                      ");

                      $countSubjectList = $this->SubjectList->query("

                        SELECT 

                          count(*) as total

                        FROM

                          subject_lists as SubjectList

                        WHERE 

                          SubjectList.visible = true AND

                          SubjectList.course_schedule_id = $course_schedule_id

                      ");

                      $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                      $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                      $classSchedules = $this->ClassSchedule->query("

                        SELECT 

                          ClassSchedule.id,

                          IFNULL(Room.name,'') as room_name,

                          ClassSchedule.start_time,

                          ClassSchedule.end_time,

                          ClassSchedule.day,

                          Employee.full_name,

                          CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                        FROM

                          class_schedules as ClassSchedule LEFT JOIN

                          (

                            SELECT

                              Room.id,

                              Room.name

                            FROM

                              rooms as Room

                          ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                          (

                            SELECT

                              Employee.id,

                              CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                            FROM

                              employees as Employee

                          ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                        WHERE 

                          ClassSchedule.visible = true AND

                          ClassSchedule.active = true AND

                          ClassSchedule.course_schedule_id = $course_schedule_id

                        groupings

                      ");

                      if(!empty($classSchedules)){

                        foreach ($classSchedules as $key => $cs) {

                          $timestring1 = $cs['ClassSchedule']['start_time'];

                          $count1 = strlen($timestring1);

                          if($count1 == 3){

                            $hour1 = '0'.substr($timestring1,0,1);

                            $minute1 = substr($timestring1,1,3);

                          }else{

                            $hour1 = substr($timestring1,0,2);

                            $minute1 = substr($timestring1,2,4);

                          }

                          $timestring2 = $cs['ClassSchedule']['end_time'];

                          $count2 = strlen($timestring2);

                          if($count2 == 3){

                            $hour2 = '0'.substr($timestring2,0,1);

                            $minute2 = substr($timestring2,1,3);

                          } else {

                            $hour2 = substr($timestring2,0,2);

                            $minute2 = substr($timestring2,2,4);

                          }

                          $start = $hour1.':'.$minute1;      

                          $end = $hour2.':'.$minute2;

                          $d1 = fdate($start,'h:i A');

                          $d2 = fdate($end,'h:i A');

                          $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                        }

                      }

                    }

                    $schedule[$key]['sched'] = $sched;

                  }

                }

              }else{

                $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                  SELECT 

                    CourseSchedule.id,

                    IFNULL(CourseSchedule.class_name,'-') AS class_name,

                    CurriculumCourse.course_id,

                    CourseSchedule.max_size

                  FROM

                    course_schedules as CourseSchedule LEFT JOIN

                    curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id LEFT JOIN

                    college_blocks as CollegeBlock ON CollegeBlock.id = CourseSchedule.block_id LEFT JOIN

                    college_department_programs as CollegeDepartmentProgram ON CollegeDepartmentProgram.id = CollegeBlock.program_id LEFT JOIN

                    college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

                    colleges as College ON College.id = CollegeDepartment.college_id

                  WHERE 

                    CourseSchedule.visible = true AND

                    CurriculumCourse.visible = true AND

                    CollegeBlock.visible = true AND

                    CollegeDepartment.visible = true AND

                    CollegeDepartmentProgram.visible = true AND

                    CourseSchedule.is_active = true AND

                    CurriculumCourse.active = true AND

                    CourseSchedule.active = true $academic_term $curriculum $college AND

                    CourseSchedule.course_id = $course_id

                  ORDER BY

                    CourseSchedule.course_id ASC

                ) AS CourseSchedule "));

                if(!empty($schedule)){

                  foreach ($schedule as $key => $scheds) {

                    $course_schedule_id = $scheds['id'];

                    $course_id = $scheds['course_id'];

                    $sched = '';

                    $checkSchedule = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        class_schedules as ClassSchedule

                      WHERE 

                        ClassSchedule.visible = true AND

                        ClassSchedule.active = true AND

                        ClassSchedule.course_schedule_id = $course_schedule_id

                    ");

                    $count = $checkSchedule[0][0]['total'];

                    if($count > 0){

                      $classname = $scheds['class_name'];

                      $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                    }

                    $checkCurriculum = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        curriculum_courses as CurriculumCourse

                      WHERE 

                        CurriculumCourse.visible = true $curriculum AND

                        CurriculumCourse.course_id = $course_id

                    ");

                    $countCurriculum = $checkCurriculum[0][0]['total'];

                    if($countCurriculum > 0){

                      $numofenrolledstudents = 0;

                      $countPreSubjects = $this->PreregistrationSubject->query("

                        SELECT 

                          count(*) as total

                        FROM

                          preregistration_subjects as PreregistrationSubject

                        WHERE 

                          PreregistrationSubject.visible = true AND

                          PreregistrationSubject.course_schedule_id = $course_schedule_id

                      ");

                      $countSubjectList = $this->SubjectList->query("

                        SELECT 

                          count(*) as total

                        FROM

                          subject_lists as SubjectList

                        WHERE 

                          SubjectList.visible = true AND

                          SubjectList.course_schedule_id = $course_schedule_id

                      ");

                      $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                      $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                      $classSchedules = $this->ClassSchedule->query("

                        SELECT 

                          ClassSchedule.id,

                          IFNULL(Room.name,'') as room_name,

                          ClassSchedule.start_time,

                          ClassSchedule.end_time,

                          ClassSchedule.day,

                          Employee.full_name,

                          CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                        FROM

                          class_schedules as ClassSchedule LEFT JOIN

                          (

                            SELECT

                              Room.id,

                              Room.name

                            FROM

                              rooms as Room

                          ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                          (

                            SELECT

                              Employee.id,

                              CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                            FROM

                              employees as Employee

                          ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                        WHERE 

                          ClassSchedule.visible = true AND

                          ClassSchedule.active = true AND

                          ClassSchedule.course_schedule_id = $course_schedule_id

                        groupings

                      ");

                      if(!empty($classSchedules)){

                        foreach ($classSchedules as $key => $cs) {

                          $timestring1 = $cs['ClassSchedule']['start_time'];

                          $count1 = strlen($timestring1);

                          if($count1 == 3){

                            $hour1 = '0'.substr($timestring1,0,1);

                            $minute1 = substr($timestring1,1,3);

                          }else{

                            $hour1 = substr($timestring1,0,2);

                            $minute1 = substr($timestring1,2,4);

                          }

                          $timestring2 = $cs['ClassSchedule']['end_time'];

                          $count2 = strlen($timestring2);

                          if($count2 == 3){

                            $hour2 = '0'.substr($timestring2,0,1);

                            $minute2 = substr($timestring2,1,3);

                          } else {

                            $hour2 = substr($timestring2,0,2);

                            $minute2 = substr($timestring2,2,4);

                          }

                          $start = $hour1.':'.$minute1;      

                          $end = $hour2.':'.$minute2;

                          $d1 = fdate($start,'h:i A');

                          $d2 = fdate($end,'h:i A');

                          $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                        }

                      }

                    }

                    $schedule[$key]['sched'] = $sched;

                  }

                }

              }

            }

            $datas[] = array(

              'id'         => $data['CurriculumCourse']['course_id'],

              'course_id'  => $data['CurriculumCourse']['course_id'],

              'name'       => @$data[0]['name'],

              'schedule'   => !empty($schedule) ? $schedule : array()

            );

          }

        }

      }else{

        $tmp = $this->StudentAdvising->query("

          SELECT

            StudentAdvising.id,

            Course.name,

            StudentAdvising.course_id

          FROM

            student_advisings as StudentAdvising LEFT JOIN

            (

              SELECT

                Course.id,

                CONCAT(Course.code,'::',Course.title) as name

              FROM

                courses as Course
              
              WHERE

                Course.visible = true

            ) as Course ON Course.id = StudentAdvising.course_id

          WHERE

            StudentAdvising.visible = true $curriculum_advising $student_adivising $academic_term_advising AND 

            StudentAdvising.active = true

          GROUP BY

            StudentAdvising.id

        ");

        if(!empty($tmp)){

          foreach ($tmp as $k => $data) {

            $course_id = $data['StudentAdvising']['course_id'];

            if(!$check){

              $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                SELECT 

                  CourseSchedule.id,

                  IFNULL(CourseSchedule.class_name,'-') AS class_name,

                  CurriculumCourse.course_id,

                  CourseSchedule.max_size

                FROM

                  course_schedules as CourseSchedule LEFT JOIN

                  curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id

                WHERE 

                  CourseSchedule.visible = true AND

                  CurriculumCourse.visible = true AND

                  CourseSchedule.is_active = true AND

                  CurriculumCourse.active = true AND

                  CourseSchedule.active = true $academic_term $curriculum AND

                  CourseSchedule.course_id = $course_id

                ORDER BY

                  CourseSchedule.course_id

              ) AS CourseSchedule "));

              if(!empty($schedule)){

                foreach ($schedule as $key => $scheds) {

                  $course_schedule_id = $scheds['id'];

                  $course_id = $scheds['course_id'];

                  $sched = '';

                  $checkSchedule = $this->ClassSchedule->query("

                    SELECT 

                      count(*) as total

                    FROM

                      class_schedules as ClassSchedule

                    WHERE 

                      ClassSchedule.visible = true AND

                      ClassSchedule.active = true AND

                      ClassSchedule.course_schedule_id = $course_schedule_id

                  ");

                  $count = $checkSchedule[0][0]['total'];

                  if($count > 0){

                    $classname = $scheds['class_name'];

                    $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                  }

                  $checkCurriculum = $this->ClassSchedule->query("

                    SELECT 

                      count(*) as total

                    FROM

                      curriculum_courses as CurriculumCourse

                    WHERE 

                      CurriculumCourse.visible = true $curriculum AND

                      CurriculumCourse.course_id = $course_id

                  ");

                  $countCurriculum = $checkCurriculum[0][0]['total'];

                  if($countCurriculum > 0){

                    $numofenrolledstudents = 0;

                    $countPreSubjects = $this->PreregistrationSubject->query("

                      SELECT 

                        count(*) as total

                      FROM

                        preregistration_subjects as PreregistrationSubject

                      WHERE 

                        PreregistrationSubject.visible = true AND

                        PreregistrationSubject.course_schedule_id = $course_schedule_id

                    ");

                    $countSubjectList = $this->SubjectList->query("

                      SELECT 

                        count(*) as total

                      FROM

                        subject_lists as SubjectList

                      WHERE 

                        SubjectList.visible = true AND

                        SubjectList.course_schedule_id = $course_schedule_id

                    ");

                    $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                    $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                    $classSchedules = $this->ClassSchedule->query("

                      SELECT 

                        ClassSchedule.id,

                        IFNULL(Room.name,'') as room_name,

                        ClassSchedule.start_time,

                        ClassSchedule.end_time,

                        ClassSchedule.day,

                        Employee.full_name,

                        CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                      FROM

                        class_schedules as ClassSchedule LEFT JOIN

                        (

                          SELECT

                            Room.id,

                            Room.name

                          FROM

                            rooms as Room

                        ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                        (

                          SELECT

                            Employee.id,

                            CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                          FROM

                            employees as Employee

                        ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                      WHERE 

                        ClassSchedule.visible = true AND

                        ClassSchedule.active = true AND

                        ClassSchedule.course_schedule_id = $course_schedule_id

                      groupings

                    ");

                    if(!empty($classSchedules)){

                      foreach ($classSchedules as $key => $cs) {

                        $timestring1 = $cs['ClassSchedule']['start_time'];

                        $count1 = strlen($timestring1);

                        if($count1 == 3){

                          $hour1 = '0'.substr($timestring1,0,1);

                          $minute1 = substr($timestring1,1,3);

                        }else{

                          $hour1 = substr($timestring1,0,2);

                          $minute1 = substr($timestring1,2,4);

                        }

                        $timestring2 = $cs['ClassSchedule']['end_time'];

                        $count2 = strlen($timestring2);

                        if($count2 == 3){

                          $hour2 = '0'.substr($timestring2,0,1);

                          $minute2 = substr($timestring2,1,3);

                        } else {

                          $hour2 = substr($timestring2,0,2);

                          $minute2 = substr($timestring2,2,4);

                        }

                        $start = $hour1.':'.$minute1;      

                        $end = $hour2.':'.$minute2;

                        $d1 = fdate($start,'h:i A');

                        $d2 = fdate($end,'h:i A');

                        $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                      }

                    }

                  }

                  $schedule[$key]['sched'] = $sched;

                }

              }
            
            }else{

              if($set == 1){

                $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                  SELECT

                    CourseSchedule.id,

                    IFNULL(CourseSchedule.class_name,'-') AS class_name,

                    CurriculumCourse.course_id,

                    CourseSchedule.max_size

                  FROM

                    course_schedules as CourseSchedule LEFT JOIN

                    curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id LEFT JOIN

                    college_blocks as CollegeBlock ON CollegeBlock.id = CourseSchedule.block_id LEFT JOIN

                    college_department_programs as CollegeDepartmentProgram ON CollegeDepartmentProgram.id = CollegeBlock.program_id LEFT JOIN

                    college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

                    colleges as College ON College.id = CollegeDepartment.college_id

                  WHERE 

                    CourseSchedule.visible = true AND

                    CurriculumCourse.visible = true AND

                    CollegeBlock.visible = true AND

                    CollegeDepartment.visible = true AND

                    CollegeDepartmentProgram.visible = true AND

                    CourseSchedule.is_active = true AND

                    CurriculumCourse.active = true AND

                    CourseSchedule.active = true $academic_term $curriculum $campus AND

                    CourseSchedule.course_id = $course_id

                  ORDER BY

                    CourseSchedule.course_id ASC

                ) AS CourseSchedule "));

                if(!empty($schedule)){

                  foreach ($schedule as $key => $scheds) {

                    $course_schedule_id = $scheds['id'];

                    $course_id = $scheds['course_id'];

                    $sched = '';

                    $checkSchedule = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        class_schedules as ClassSchedule

                      WHERE 

                        ClassSchedule.visible = true AND

                        ClassSchedule.active = true AND

                        ClassSchedule.course_schedule_id = $course_schedule_id

                    ");

                    $count = $checkSchedule[0][0]['total'];

                    if($count > 0){

                      $classname = $scheds['class_name'];

                      $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                    }

                    $checkCurriculum = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        curriculum_courses as CurriculumCourse

                      WHERE 

                        CurriculumCourse.visible = true $curriculum AND

                        CurriculumCourse.course_id = $course_id

                    ");

                    $countCurriculum = $checkCurriculum[0][0]['total'];

                    if($countCurriculum > 0){

                      $numofenrolledstudents = 0;

                      $countPreSubjects = $this->PreregistrationSubject->query("

                        SELECT 

                          count(*) as total

                        FROM

                          preregistration_subjects as PreregistrationSubject

                        WHERE 

                          PreregistrationSubject.visible = true AND

                          PreregistrationSubject.course_schedule_id = $course_schedule_id

                      ");

                      $countSubjectList = $this->SubjectList->query("

                        SELECT 

                          count(*) as total

                        FROM

                          subject_lists as SubjectList

                        WHERE 

                          SubjectList.visible = true AND

                          SubjectList.course_schedule_id = $course_schedule_id

                      ");

                      $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                      $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                      $classSchedules = $this->ClassSchedule->query("

                        SELECT 

                          ClassSchedule.id,

                          IFNULL(Room.name,'') as room_name,

                          ClassSchedule.start_time,

                          ClassSchedule.end_time,

                          ClassSchedule.day,

                          Employee.full_name,

                          CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                        FROM

                          class_schedules as ClassSchedule LEFT JOIN

                          (

                            SELECT

                              Room.id,

                              Room.name

                            FROM

                              rooms as Room

                          ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                          (

                            SELECT

                              Employee.id,

                              CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                            FROM

                              employees as Employee

                          ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                        WHERE 

                          ClassSchedule.visible = true AND

                          ClassSchedule.active = true AND

                          ClassSchedule.course_schedule_id = $course_schedule_id

                        groupings

                      ");

                      if(!empty($classSchedules)){

                        foreach ($classSchedules as $key => $cs) {

                          $timestring1 = $cs['ClassSchedule']['start_time'];

                          $count1 = strlen($timestring1);

                          if($count1 == 3){

                            $hour1 = '0'.substr($timestring1,0,1);

                            $minute1 = substr($timestring1,1,3);

                          }else{

                            $hour1 = substr($timestring1,0,2);

                            $minute1 = substr($timestring1,2,4);

                          }

                          $timestring2 = $cs['ClassSchedule']['end_time'];

                          $count2 = strlen($timestring2);

                          if($count2 == 3){

                            $hour2 = '0'.substr($timestring2,0,1);

                            $minute2 = substr($timestring2,1,3);

                          } else {

                            $hour2 = substr($timestring2,0,2);

                            $minute2 = substr($timestring2,2,4);

                          }

                          $start = $hour1.':'.$minute1;      

                          $end = $hour2.':'.$minute2;

                          $d1 = fdate($start,'h:i A');

                          $d2 = fdate($end,'h:i A');

                          $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                        }

                      }

                    }

                    $schedule[$key]['sched'] = $sched;

                  }

                }

              }else{

                $schedule = Set::extract('{}.CourseSchedule',$this->CourseSchedule->query("SELECT * FROM (

                  SELECT 

                    CourseSchedule.id,

                    IFNULL(CourseSchedule.class_name,'-') AS class_name,

                    CurriculumCourse.course_id,

                    CourseSchedule.max_size

                  FROM

                    course_schedules as CourseSchedule LEFT JOIN

                    curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = CourseSchedule.course_id LEFT JOIN

                    college_blocks as CollegeBlock ON CollegeBlock.id = CourseSchedule.block_id LEFT JOIN

                    college_department_programs as CollegeDepartmentProgram ON CollegeDepartmentProgram.id = CollegeBlock.program_id LEFT JOIN

                    college_departments as CollegeDepartment ON CollegeDepartment.id = CollegeDepartmentProgram.college_department_id LEFT JOIN

                    colleges as College ON College.id = CollegeDepartment.college_id

                  WHERE 

                    CourseSchedule.visible = true AND

                    CurriculumCourse.visible = true AND

                    CollegeBlock.visible = true AND

                    CollegeDepartment.visible = true AND

                    CollegeDepartmentProgram.visible = true AND

                    CourseSchedule.is_active = true AND

                    CurriculumCourse.active = true AND

                    CourseSchedule.active = true $academic_term $curriculum $college AND

                    CourseSchedule.course_id = $course_id

                  ORDER BY

                    CourseSchedule.course_id ASC

                ) AS CourseSchedule "));

                if(!empty($schedule)){

                  foreach ($schedule as $key => $scheds) {

                    $course_schedule_id = $scheds['id'];

                    $course_id = $scheds['course_id'];

                    $sched = '';

                    $checkSchedule = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        class_schedules as ClassSchedule

                      WHERE 

                        ClassSchedule.visible = true AND

                        ClassSchedule.active = true AND

                        ClassSchedule.course_schedule_id = $course_schedule_id

                    ");

                    $count = $checkSchedule[0][0]['total'];

                    if($count > 0){

                      $classname = $scheds['class_name'];

                      $sched = $scheds['class_name'].':: ['.$course_schedule_id.']::';

                    }

                    $checkCurriculum = $this->ClassSchedule->query("

                      SELECT 

                        count(*) as total

                      FROM

                        curriculum_courses as CurriculumCourse

                      WHERE 

                        CurriculumCourse.visible = true $curriculum AND

                        CurriculumCourse.course_id = $course_id

                    ");

                    $countCurriculum = $checkCurriculum[0][0]['total'];

                    if($countCurriculum > 0){

                      $numofenrolledstudents = 0;

                      $countPreSubjects = $this->PreregistrationSubject->query("

                        SELECT 

                          count(*) as total

                        FROM

                          preregistration_subjects as PreregistrationSubject

                        WHERE 

                          PreregistrationSubject.visible = true AND

                          PreregistrationSubject.course_schedule_id = $course_schedule_id

                      ");

                      $countSubjectList = $this->SubjectList->query("

                        SELECT 

                          count(*) as total

                        FROM

                          subject_lists as SubjectList

                        WHERE 

                          SubjectList.visible = true AND

                          SubjectList.course_schedule_id = $course_schedule_id

                      ");

                      $numofenrolledstudents = intval($countPreSubjects[0][0]['total']) + intval($countSubjectList[0][0]['total']);

                      $sched .= '('.$numofenrolledstudents.' of '.$scheds['max_size'].')::';

                      $classSchedules = $this->ClassSchedule->query("

                        SELECT 

                          ClassSchedule.id,

                          IFNULL(Room.name,'') as room_name,

                          ClassSchedule.start_time,

                          ClassSchedule.end_time,

                          ClassSchedule.day,

                          Employee.full_name,

                          CONCAT(ClassSchedule.start_time,' - ',ClassSchedule.end_time,' - ',Room.id,' - ',Employee.id) as groupings

                        FROM

                          class_schedules as ClassSchedule LEFT JOIN

                          (

                            SELECT

                              Room.id,

                              Room.name

                            FROM

                              rooms as Room

                          ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

                          (

                            SELECT

                              Employee.id,

                              CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

                            FROM

                              employees as Employee

                          ) as Employee ON Employee.id = ClassSchedule.faculty_id 

                        WHERE 

                          ClassSchedule.visible = true AND

                          ClassSchedule.active = true AND

                          ClassSchedule.course_schedule_id = $course_schedule_id

                        groupings

                      ");

                      if(!empty($classSchedules)){

                        foreach ($classSchedules as $key => $cs) {

                          $timestring1 = $cs['ClassSchedule']['start_time'];

                          $count1 = strlen($timestring1);

                          if($count1 == 3){

                            $hour1 = '0'.substr($timestring1,0,1);

                            $minute1 = substr($timestring1,1,3);

                          }else{

                            $hour1 = substr($timestring1,0,2);

                            $minute1 = substr($timestring1,2,4);

                          }

                          $timestring2 = $cs['ClassSchedule']['end_time'];

                          $count2 = strlen($timestring2);

                          if($count2 == 3){

                            $hour2 = '0'.substr($timestring2,0,1);

                            $minute2 = substr($timestring2,1,3);

                          } else {

                            $hour2 = substr($timestring2,0,2);

                            $minute2 = substr($timestring2,2,4);

                          }

                          $start = $hour1.':'.$minute1;      

                          $end = $hour2.':'.$minute2;

                          $d1 = fdate($start,'h:i A');

                          $d2 = fdate($end,'h:i A');

                          $sched .= ' '.$cs['ClassSchedule']['day'].' '.$d1.'-'.$d2.' '.$cs[0]['room_name'].'::'.$cs['Employee']['full_name']; 

                        }

                      }

                    }

                    $schedule[$key]['sched'] = $sched;

                  }

                }

              }

            }

            $datas[] = array(

              'id'         => $data['StudentAdvising']['course_id'],

              'course_id'  => $data['StudentAdvising']['course_id'],

              'name'       => @$data[0]['name'],

              'schedule'   => !empty($schedule) ? $schedule : array()

            );

          }

        }

      }

    } else if ($code == 'validate-registration') {

      $conditions = array();

      $conditions['StudentRegistration.visible'] = true;

      if(isset($this->request->query['student_id'])){

        $student_id = $this->request->query['student_id'];

        $conditions['StudentRegistration.student_id'] = $student_id;

      }
      
      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

        $conditions['StudentRegistration.academic_term_id'] = $academic_term_id;

      }

      $count = $this->StudentRegistration->find('count',array(

        'conditions' => $conditions,

      ));

      $year_term_id = '';

      if(!is_null($this->Session->read('Auth.User.studentId'))){

        $student_id = $this->Session->read('Auth.User.studentId');

        $student_adivising = "AND StudentAdvising.student_id = $student_id";

        $studentData = $this->Student->find('first', array(

          'contain' => array(
          
            'College' => array(

              'conditions' => array(

                'College.visible' => true

              ),

            ),

          
            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

        if(!empty($studentData)){

          $stud_yl = $studentData['Student']['year_level'];

          $year_level_term = $this->YearLevelTerm->find('first',array(

            'conditions' => array(

              'YearLevelTerm.year_level' => $stud_yl,

              'YearLevelTerm.semester' => $academicData['AcademicTerm']['semester']

            ),

          ));

          if(!empty($year_level_term)){

            $year_term_id = $year_level_term['YearLevelTerm']['id'];

          }

        }

      }

      if($count > 0){

        $datas = array(

          'ok'       => false,

          'msg'      => 'Already registered! Unable to add another subject.'

        );

      }else{

        $datas = array(

          'ok'       => true,

          'msg'      => 'Subject has been successfully added.',

          'year_term_id' => $year_term_id

        );

      }

    } else if ($code == 'validate-prereg-max-unit') {

      $conditions = array();
      
      $academic_term_id = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

      }

      $year_term_id = '';

      $max_units = 0;

      $totalcurrent_units = 0;

      if(isset($this->request->query['student_id'])){

        $student_id = $this->request->query['student_id'];

        $student_adivising = "AND StudentAdvising.student_id = $student_id";

        $studentData = $this->Student->find('first', array(

          'contain' => array(

            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

        $year_term_id = '';

        if(!empty($studentData)){

          $stud_yl = $studentData['Student']['year_level'];

          $year_level_term = $this->YearLevelTerm->find('first',array(

            'conditions' => array(

              'YearLevelTerm.year_level' => $stud_yl,

              'YearLevelTerm.semester' => @$academicData['AcademicTerm']['semester']

            ),

          ));

          if(!empty($year_level_term)){

            $year_term_id = $year_level_term['YearLevelTerm']['id'];

          }

          if($studentData['Degree']['id'] == 1){

            if(is_null($studentData['Student']['max_load']) || $studentData['Student']['max_load'] == '' || $studentData['Student']['max_load'] == 0){

              if($year_term_id == ''){
    
                $max_units = $this->Global->EnrollmentSettings('undergrad_max_units');

              }else{

                $yeartermloadempty = $this->CurriculumYearLevelTermLoad->find('first',array(

                  'conditions' => array(

                    'CurriculumYearLevelTermLoad.visible' => true,

                    'CurriculumYearLevelTermLoad.curriculum_id' => $studentData['Student']['curriculum_id'],

                    'CurriculumYearLevelTermLoad.year_term_id' => $year_term_id

                  ),

                ));

                if(!empty($yeartermloadempty)){
    
                  $max_units = $yeartermloadempty['CurriculumYearLevelTermLoad']['max_load'];

                }else{
    
                  $max_units = $this->Global->EnrollmentSettings('undergrad_max_units');

                }

              }

            }else{
    
              $max_units = $studentData['Student']['max_load'];

            }

          }else if($studentData['Degree']['id'] == 2){

            if(is_null($studentData['Student']['max_load']) || $studentData['Student']['max_load'] == '' || $studentData['Student']['max_load'] == 0){
    
              $max_units = $this->Global->EnrollmentSettings('master_max_units');

            }else{
    
              $max_units = $studentData['Student']['max_load'];

            }

          }else if($studentData['Degree']['id'] == 3){

            if(is_null($studentData['Student']['max_load']) || $studentData['Student']['max_load'] == '' || $studentData['Student']['max_load'] == 0){
    
              $max_units = $this->Global->EnrollmentSettings('doctorate_max_units');

            }else{
    
              $max_units = $studentData['Student']['max_load'];

            }

          }else if($studentData['Degree']['id'] == 7){

            if(is_null($studentData['Student']['max_load']) || $studentData['Student']['max_load'] == '' || $studentData['Student']['max_load'] == 0){
    
              $max_units = $this->Global->EnrollmentSettings('master_max_units');

            }else{
    
              $max_units = $studentData['Student']['max_load'];

            }

          }else if($studentData['Degree']['id'] == 6){

            if(is_null($studentData['Student']['max_load']) || $studentData['Student']['max_load'] == '' || $studentData['Student']['max_load'] == 0){
    
              $max_units = $this->Global->EnrollmentSettings('doctorate_max_units');

            }else{
    
              $max_units = $studentData['Student']['max_load'];

            }

          }else{

            if(is_null($studentData['Student']['max_load']) || $studentData['Student']['max_load'] == '' || $studentData['Student']['max_load'] == 0){
    
              $max_units = $this->Global->EnrollmentSettings('medicine_max_units');

            }else{
    
              $max_units = $studentData['Student']['max_load'];

            }

          }

          $subject_check = $this->PreregistrationSubject->query("

            SELECT

              PreregistrationSubject.id,

              IFNULL(SUM(Course.credit_unit),0) as credit_unit

            FROM

              preregistration_subjects as PreregistrationSubject LEFT JOIN

              courses as Course ON Course.id = PreregistrationSubject.course_id

            WHERE 

              PreregistrationSubject.visible = true AND

              Course.visible = true AND

              PreregistrationSubject.academic_term_id = $academic_term_id AND

              PreregistrationSubject.student_id = $student_id

          ");

          if(!empty($subject_check)){

            $totalcurrent_units = $subject_check[0][0]['credit_unit'];

          }else{

            $totalcurrent_units = 0;

          }

        }

      }
      
      $subjectcredit_units = 0;

      if(isset($this->request->query['schedule_id'])){

        $schedule_id = $this->request->query['schedule_id'];

        $csub = $this->CourseSchedule->query("

          SELECT

            CourseSchedule.id,

            IFNULL(Course.credit_unit,0) as credit_unit

          FROM

            course_schedules as CourseSchedule LEFT JOIN

            courses as Course ON Course.id = CourseSchedule.course_id

          WHERE 

            CourseSchedule.visible = true AND

            Course.visible = true AND

            CourseSchedule.id = $schedule_id

        ");

        $subjectcredit_units = $csub[0][0]['credit_unit'];

      }

      $total_max_units = floatval($max_units);

      $total_temp_load_units = floatval($totalcurrent_units) + floatval($subjectcredit_units);

      if ($total_temp_load_units > $total_max_units){

        $datas = array(

          'ok'       => false,

          'msg'      => 'Unable to add subject. Maximum required load(units) has been reach.'

        );

      }else{

        $datas = array(

          'ok'       => true,

          'msg'      => 'Subject has been successfully added.'

        );

      }

    } else if ($code == 'validate-duplicate-course') {

      $conditions = array();
      
      $course_id = '';

      if(isset($this->request->query['course_id'])){

        $course_id = $this->request->query['course_id'];

      }

      $academic_term_id = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

      }

      $year_term_id = '';

      if(isset($this->request->query['year_term_id'])){

        $year_term_id = $this->request->query['year_term_id'];

      }

      $results = array();

      if(isset($this->request->query['student_id'])){

        $student_id = $this->request->query['student_id'];

        $studentData = $this->Student->find('first', array(

          'contain' => array(

            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

        if($studentData['Degree']['id'] == 1){

          $results = $this->PreregistrationSubject->query("

            SELECT

              PreregistrationSubject.id

            FROM

              preregistration_subjects as PreregistrationSubject LEFT JOIN

              course_schedules as CourseSchedule ON CourseSchedule.id = PreregistrationSubject.course_schedule_id

            WHERE 

              PreregistrationSubject.visible = true AND

              CourseSchedule.visible = true AND

              PreregistrationSubject.academic_term_id = $academic_term_id AND

              PreregistrationSubject.student_id = $student_id AND

              PreregistrationSubject.course_id = $course_id AND

              PreregistrationSubject.year_term_id = $year_term_id

          ");

        }else{

          $results = $this->PreregistrationSubject->query("

            SELECT

              PreregistrationSubject.id

            FROM

              preregistration_subjects as PreregistrationSubject LEFT JOIN

              course_schedules as CourseSchedule ON CourseSchedule.id = PreregistrationSubject.course_schedule_id

            WHERE 

              PreregistrationSubject.visible = true AND

              CourseSchedule.visible = true AND

              PreregistrationSubject.academic_term_id = $academic_term_id AND

              PreregistrationSubject.student_id = $student_id AND

              PreregistrationSubject.course_id = $course_id

          ");

        }

      }

      $subjecttaken = $this->PreregistrationSubject->query("

        SELECT

          SubjectList.id,

          SubjectList.isdropped

        FROM

          subject_lists as SubjectList LEFT JOIN

          course_schedules as CourseSchedule ON CourseSchedule.id = SubjectList.course_schedule_id

        WHERE 

          SubjectList.visible = true AND

          CourseSchedule.visible = true AND

          SubjectList.student_id = $student_id AND

          CourseSchedule.course_id = $course_id

      ");

      $returnvalue = '';

      if(empty($results)){

        if(!empty($subjecttaken)){

          if(@$subjecttaken[0]['SubjectList']['isdropped']){

            $returnvalue = 'True;Clear';

          }else{

            if(@$subjecttaken[0]['SubjectList']['remarks'] == "DROPPED" || @$subjecttaken[0]['SubjectList']['remarks'] == "FAILED"  || @$subjecttaken[0]['SubjectList']['remarks'] == "" || is_null(@$subjecttaken[0]['SubjectList']['remarks']) || @$subjecttaken[0]['SubjectList']['remarks'] == "INCOMPLETE"){

              $returnvalue = 'True;Clear';

            }else{

              $returnvalue = "True;Subject already taken last ".$academicData['AcademicTerm']['school_year']." ".$academicData['AcademicTerm']['semester'].".";

            }

          }

        }else{

          $returnvalue = 'True;Clear';

        }

      }else{

        $returnvalue = 'False;The subject you are about to add is already in your subject list.';

      }


      $datas = array(

        'ok'       => true,

        'value'    => $returnvalue

      );

    } else if ($code == 'validate-schedule') {

      $conditions = array();
      
      $course_schedule_id = '';

      if(isset($this->request->query['course_schedule_id'])){

        $course_schedule_id = $this->request->query['course_schedule_id'];

      }

      $academic_term_id = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

      }

      $year_term_id = '';

      if(isset($this->request->query['year_term_id'])){

        $year_term_id = $this->request->query['year_term_id'];

      }

      $row = array();

      if(isset($this->request->query['student_id'])){

        $student_id = $this->request->query['student_id'];

        $studentData = $this->Student->find('first', array(

          'contain' => array(

            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

        $rows = $this->PreregistrationSubject->query("

          SELECT

            PreregistrationSubject.id,

            ClassSchedule.day,

            ClassSchedule.start_time,

            ClassSchedule.end_time,

            ClassSchedule.course_schedule_id

          FROM

            preregistration_subjects as PreregistrationSubject LEFT JOIN

            class_schedules as ClassSchedule ON ClassSchedule.id = PreregistrationSubject.course_schedule_id

          WHERE 

            PreregistrationSubject.visible = true AND

            ClassSchedule.visible = true AND

            ClassSchedule.active = true AND

            PreregistrationSubject.student_id = $student_id AND

            PreregistrationSubject.academic_term_id = $academic_term_id AND

            PreregistrationSubject.year_term_id = $year_term_id

        ");

      }

      $rowscurrentcourse = $this->PreregistrationSubject->query("

        SELECT

          ClassSchedule.id,

          ClassSchedule.day,

          ClassSchedule.start_time,

          ClassSchedule.end_time,

          ClassSchedule.course_schedule_id

        FROM

          class_schedules as ClassSchedule

        WHERE 

          ClassSchedule.visible = true AND

          ClassSchedule.active = true AND

          ClassSchedule.course_schedule_id = $course_schedule_id

      ");

      $results = 'True';

      $csid = '';

      if(!empty($rowscurrentcourse)){

        foreach ($rowscurrentcourse as $key => $value) {

          if(!empty($rows)){

            foreach ($rows as $keys => $values) {

              $rstarttime = intval($value['ClassSchedule']['start_time']);

              $rendtime = intval($value['ClassSchedule']['end_time']);
            
              $r2starttime = intval($values['ClassSchedule']['start_time']);

              $r2endtime = intval($values['ClassSchedule']['end_time']);

              if($value['ClassSchedule']['day'] == $values['ClassSchedule']['day'] && $value['ClassSchedule']['start_time'] == $values['ClassSchedule']['start_time']){

                $results = 'False';

                $csid = $values['ClassSchedule']['course_schedule_id'];

              }

              if ($value['ClassSchedule']['day'] == $values['ClassSchedule']['day']){

                if(($rstarttime > $r2starttime) && ($rstarttime < $r2endtime)){

                  $results = 'False';

                  $csid = $values['ClassSchedule']['course_schedule_id'];

                }

                if(($rendtime > $r2starttime) && ($rendtime < $r2endtime)){

                  $results = 'False';

                  $csid = $values['ClassSchedule']['course_schedule_id'];

                }

              }

            }

          }

        }

      }

      if($csid == ''){

        $results = $results.';None';

      }else{

        $sched = "";

        $rowscurrentcourse = $this->PreregistrationSubject->query("

          SELECT 

            ClassSchedule.id,

            IFNULL(Room.name,'') as room_name,

            ClassSchedule.start_time,

            ClassSchedule.end_time,

            ClassSchedule.day,

            Employee.full_name

          FROM

            class_schedules as ClassSchedule LEFT JOIN

            (

              SELECT

                Room.id,

                Room.name

              FROM

                rooms as Room

            ) as Room ON Room.id = ClassSchedule.room_id LEFT JOIN

            (

              SELECT

                Employee.id,

                CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name

              FROM

                employees as Employee

            ) as Employee ON Employee.id = ClassSchedule.faculty_id 

          WHERE 

            ClassSchedule.visible = true AND

            ClassSchedule.active = true AND

            ClassSchedule.course_schedule_id = $csid

        ");

        if(!empty($rowscurrentcourse)){

          foreach ($rowscurrentcourse as $key => $classsched) {

            $cs = $this->CourseSchedule->findById($csid);

            $sub = $this->Course->findById($cs['CourseSchedule']['course_id']);

            $ccode = $sub['Course']['code'];

            $ctitle = $sub['Course']['title'];

            $timestring1 = $classsched['ClassSchedule']['start_time'];

            $count1 = strlen($timestring1);

            if($count1 == 3){

              $hour1 = '0'.substr($timestring1,0,1);

              $minute1 = substr($timestring1,1,3);

            }else{

              $hour1 = substr($timestring1,0,2);

              $minute1 = substr($timestring1,2,4);

            }

            $timestring2 = $classsched['ClassSchedule']['end_time'];

            $count2 = strlen($timestring2);

            if($count2 == 3){

              $hour2 = '0'.substr($timestring2,0,1);

              $minute2 = substr($timestring2,1,3);

            } else {

              $hour2 = substr($timestring2,0,2);

              $minute2 = substr($timestring2,2,4);

            }

            $start = $hour1.':'.$minute1;      

            $end = $hour2.':'.$minute2;

            $d1 = fdate($start,'h:i A');

            $d2 = fdate($end,'h:i A');

            $sched .= ' '.dayview($classsched['ClassSchedule']['day']).' '.$d1.'-'.$d2.' '.$classsched[0]['room_name'].'::'.$classsched['Employee']['full_name']; 

            $results .= ';'.$sched;

          }

        }

      }

      $datas = array(

        'ok'       => true,

        'result'    => $results

      );

    } else if ($code == 'validate-course-size') {

      $conditions = array();
      
      $course_schedule_id = '';

      if(isset($this->request->query['course_schedule_id'])){

        $course_schedule_id = $this->request->query['course_schedule_id'];

      }

      $result = false;

      $maxsize = 0;

      $numofenrolledstudents = 0;

      $countprereg = $this->PreregistrationSubject->find('count',array(

        'conditions' => array(

          'PreregistrationSubject.visible' => true,

          'PreregistrationSubject.course_schedule_id' => $course_schedule_id

        ),

      ));

      $countsubject = $this->SubjectList->find('count',array(

        'conditions' => array(

          'SubjectList.visible' => true,

          'SubjectList.course_schedule_id' => $course_schedule_id

        ),

      ));
    
      $numofenrolledstudents = $countprereg + $countsubject;

      $coursesched = $this->CourseSchedule->findById($course_schedule_id);

      if (is_null($coursesched['CourseSchedule']['max_size'])){

        $maxsize = $this->Global->EnrollmentSettings('default_max_size');

      } else {

        $maxsize = $coursesched['CourseSchedule']['max_size'];

      }
      
      if ($numofenrolledstudents >= $maxsize){

        $result = True;

      }

      if($result){

        $datas = array(

          'ok'       => false,

          'result'    => $result

        );

      }else{

        $datas = array(

          'ok'       => true,

          'result'    => $result

        );

      }

    } else if ($code == 'get-month-attendance') {

      $currentMonth = date('n');

      $month = date('F');
      $currentYear = date('Y');

      // Get the first day of the month
      $firstDay = date('D', strtotime("$currentYear-$currentMonth-01"));

      // Calculate the number of days in the current month
      $daysInMonth = date('t', strtotime("$currentYear-$currentMonth-01"));

       $daysInMonth = date('t', strtotime("$currentYear-$currentMonth-01"));

       $header = array();

        // Loop through each day of the month and display day of the week headers
        for ($day = 1; $day <= $daysInMonth; $day++) {

            $date = strtotime("$currentYear-$currentMonth-$day");

            $dayName = date('D', $date);

            $header[] = array(

              'dayName' => $dayName

            );
        }


      // var_dump($currentMonth.'<br>'.$currentYear.'<br>'.$firstDay.'<br>'.$daysInMonth);

        $datas[] = array(

          'month' => $month,

          'year' => $currentYear,

          'header' => $header,

          'days' => $daysInMonth

        );

    
    } else if ($code == 'schedule-list-attendance') {

      $conditions = array();

      $conditions['BlockSectionSchedule.visible'] = true;

      if(isset($this->request->query['block_section_id'])){

        $class_schedule_id = $this->request->query['class_schedule_id'];

        $conditions['BlockSectionSchedule.block_section_id'] = $class_schedule_id;

      }

      if(isset($this->request->query['class_schedule_sub_id'])){

        $class_schedule_sub_id = $this->request->query['class_schedule_sub_id'];

        $conditions['BlockSectionSchedule.block_section_course_id'] = $class_schedule_sub_id;

      }

      if(isset($this->request->query['faculty_id'])){

        $faculty_id = $this->request->query['faculty_id'];

      }

      $tmp = $this->BlockSectionSchedule->find('all', array(

        'conditions' => $conditions,

        'order' => array(

          'BlockSectionSchedule.day' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $data['BlockSectionSchedule']['time_start'] = date("g:i A", strtotime($data['BlockSectionSchedule']['time_start']));

          $data['BlockSectionSchedule']['time_end'] = date("g:i A", strtotime($data['BlockSectionSchedule']['time_end']));

          $datas[] = array(

            'id'    => $data['BlockSectionSchedule']['id'],

            'value' => $data['BlockSectionSchedule']['day'].' : '.$data['BlockSectionSchedule']['time_start'].' - '.$data['BlockSectionSchedule']['time_end'],

          );

        }

      }

    }else if ($code == 'schedule-list-students') {

      $conditions = array();

      $conditions['StudentEnrolledCourse.visible'] = true;

      if(isset($this->request->query['block_section_schedule_id'])){

        $block_section_schedule_id = $this->request->query['block_section_schedule_id'];

        $conditions['StudentEnrolledCourse.block_section_schedule_id'] = $block_section_schedule_id;

      }

      if(isset($this->request->query['course_id'])){

        $course_id = $this->request->query['course_id'];

        $conditions['StudentEnrolledCourse.course_id'] = $course_id;

      }


      $tmp = $this->Student->query("

        SELECT 


          StudentEnrolledSchedule.id,

          Student.first_name,

          Student.last_name,

          Student.middle_name,

          Student.id as student_id

        FROM 

          students as Student LEFT JOIN 

          student_enrolled_schedules as StudentEnrolledSchedule ON StudentEnrolledSchedule.student_id = Student.id 

        WHERE  

          StudentEnrolledSchedule.visible = true AND 

          StudentEnrolledSchedule.block_section_schedule_id = $block_section_schedule_id AND

          StudentEnrolledSchedule.course_id = $course_id AND

          Student.visible = true

      ");

      if(!empty($tmp)){

            foreach ($tmp as $key => $value) {
              
              $datas[] = array(

                'id'               => $value['StudentEnrolledSchedule']['id'],

                'name'             => $value['Student']['last_name'].' '.$value['Student']['first_name'].' '.$value['Student']['middle_name'] ,

                'student_id'       => $value['Student']['student_id'],


              );

            }

          }

    }else if ($code == 'student-attendance-date') {


      if(isset($this->request->query['block_section_schedule_id'])){

        $block_section_schedule_id = $this->request->query['block_section_schedule_id'];

      }

      $tmp = $this->StudentAttendance->find('all', array(


      'conditions' => array(

        'StudentAttendance.visible' => true,

        'StudentAttendance.block_section_schedule_id' => $block_section_schedule_id

      )

    ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['StudentAttendance']['id'],

            'value' => fdate($data['StudentAttendance']['date'], 'm/d/y'),

          );

        }

      }



    }else if ($code == 'student-list-attendance') {


      if(isset($this->request->query['student_attendance_id'])){

        $student_attendance_id = $this->request->query['student_attendance_id'];


        $tmp = $this->StudentAttendanceSub->find('all', array(


      'conditions' => array(

        'StudentAttendanceSub.visible' => true,

        'StudentAttendanceSub.student_attendance_id' => $student_attendance_id

      )

    ));

      }

      

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'is_present'    => $data['StudentAttendanceSub']['is_present'],

            'student_name' => $data['StudentAttendanceSub']['student_name'],

          );

        }

      }



    }else if ($code == 'student-attendance') {


      if(isset($this->request->query['id'])){

        $id = $this->request->query['id'];


        $tmp = $this->StudentAttendance->find('first', array(

        'contain' => array(
        
        'StudentAttendanceSub' => array(

          'conditions' => array(

            'StudentAttendanceSub.visible' => true

          ),

        ),

      ),

      'conditions' => array(

        'StudentAttendance.visible' => true,

        'StudentAttendance.id' => $id

      )

    ));

      }

      $datas = $tmp;

    } else if ($code == 'get-class-schedule') {

      $faculty_id = $this->request->query['faculty_id'];

      $program_id = $this->request->query['program_id'];

      // $year_term_id = $this->request->query['year_term_id'];

     
     
      $tmp = $this->BlockSection->query("

        SELECT 

          BlockSection.*,

          BlockSectionCourse.*,

          YearLevelTerm.year,

          YearLevelTerm.semester





        FROM 

          block_section_courses as BlockSectionCourse LEFT JOIN

          block_sections as BlockSection ON BlockSectionCourse.block_section_id = BlockSection.id LEFT JOIN 

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = BlockSection.year_term_id

        WHERE  

          BlockSectionCourse.visible = true AND 

          BlockSectionCourse.faculty_id = $faculty_id AND 

          BlockSection.program_id = $program_id


      ");

      if(!empty($tmp)){

            foreach ($tmp as $key => $value) {
              
              $datas[] = array(

                'block_section_id'                  => $value['BlockSection']['id'],

                'block_section_course_id'                  => $value['BlockSectionCourse']['id'],

                'faculty_id'                  => $faculty_id,

                'course'             => $value['BlockSectionCourse']['course'],

                'course_id'          => $value['BlockSectionCourse']['course_id'],

                'section'                  => $value['BlockSection']['section'],

                'year_term'           => $value['YearLevelTerm']['year'].' - '.$value['YearLevelTerm']['semester'],

              );

            }

          }

    }  else if ($code == 'get-student_enrolled') {

      $faculty_id = $this->request->getQuery('faculty_id');

      // $course_id = $this->request->query['course_id'];

      // $year_term_id = $this->request->query['year_term_id'];

      $tmp = "

        SELECT 

          StudentEnrollment.*,

          IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name,

          Course.code as course

        FROM

          students as Student LEFT JOIN

          student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN 

          courses as Course ON Course.id = StudentEnrolledCourse.course_id  

        WHERE

          Student.visible = true  AND

          StudentEnrollment.visible = true  


      ";

      $connection = $this->StudentEnrollments->getConnection();

      $result = $connection->execute($tmp)->fetchAll('assoc');

      if(!empty($result)){

            foreach ($result as $key => $value) {

              var_dump($value);
              
              $datas[] = array(

                'StudentEnrollment'   => $value['id'],

                'faculty_id'          => $faculty_id,

                'course'              => $value['course'],

                // 'course_id'           => $value['StudentAttendance']['course_id'],

              );

            }

          }

    }else if ($code == 'validate-delete-subject') {
      
      $conditions = array();

      $academic_term_id = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

      }

      $student_id = '';

      if(isset($this->request->query['student_id'])){

        $student_id = $this->request->query['student_id'];

        $studentData = $this->Student->find('first', array(

          'contain' => array(

            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

      }

      $result = true;

      $checkifenrolled = $this->StudentRegistration->find('count',array(

        'conditions' => array(

          'StudentRegistration.student_id' => $student_id,

          'StudentRegistration.academic_term_id' => $academic_term_id

        ),

      ));

      if($checkifenrolled > 0){

        $result = false;

      }

      if($result){

        $datas = array(

          'ok'     => true,

          'result' => $result

        );
      
      }else{

        $datas = array(

          'ok'      => false,

          'result' => $result,

          'msg'    => 'Already registered! Unable to remove subject.'

        );

      }

    } else if ($code == 'get-total-list') {

      $conditions = array();

      $student = '';

      $conditions['PreregistrationSubject.visible'] = true;

      if(isset($this->request->query['student_id'])){

        $student_id = $this->request->query['student_id'];

        $conditions['PreregistrationSubject.student_id'] = $student_id;

        $student = "AND PreregistrationSubject.student_id = $student_id";

      }
      
      $academic_term = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

        $academicData = $this->AcademicTerm->findById($academic_term_id);

        $conditions['PreregistrationSubject.academic_term_id'] = $academic_term_id;

        $student = "AND PreregistrationSubject.academic_term_id = $academic_term_id";

      }

      $ffsemcount = $this->PreregistrationSubject->find('count',array(

        'conditions' => $conditions,

      ));

      $total = $this->PreregistrationSubject->query("

        SELECT 

          IFNULL(SUM(Course.credit_unit),0) as cunits_total,

          IFNULL(SUM(Course.lecture_unit),0) as lecunits_total,

          IFNULL(SUM(Course.laboratory_unit),0) as labunits_total

        FROM

          preregistration_subjects as PreregistrationSubject LEFT JOIN

          courses as Course ON Course.id = PreregistrationSubject.course_id

        WHERE

          PreregistrationSubject.visible = true $student $academic_term AND

          Course.visible = true 

      ");

      $datas = array(

        'ok'              => true,

        'ffsemcount'      => $ffsemcount,

        'cunits_total'    => $total[0][0]['cunits_total'],

        'lecunits_total'  => $total[0][0]['lecunits_total'],

        'labunits_total'  => $total[0][0]['labunits_total']

      );

    } else if ($code == 'provider-list') {
     
      $tmp = $this->Provider->find('all', array(

        'conditions' => array(

          'Provider.visible' => true

        ),

        'order' => array(

          'Provider.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Provider']['id'],

            'value' => $data['Provider']['name'],

          );

        }

      }

    } else if ($code == 'category-list') {
     
      $tmp = $this->Category->find('all', array(

        'conditions' => array(

          'Category.visible' => true

        ),

        'order' => array(

          'Category.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Category']['id'],

            'value' => $data['Category']['name'],

          );

        }

      }

    } else if ($code == 'second-college-department-list') {

      $tmp = $this->CollegeDepartment->find('all', array(

        'contain' => array(
        
          'College' => array(

            'conditions' => array(

              'College.visible' => true

            ),

          ),
          
          'Department' => array(

            'conditions' => array(

              'Department.visible' => true

            ),

          ),

        ),

        'conditions' => array(

          'CollegeDepartment.visible' => true

        ),

        'order' => array(

          'CollegeDepartment.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['CollegeDepartment']['id'],

            'value' => $data['College']['name'].'::'.$data['Department']['name'],

          );

        }

      }

    } else if ($code == 'curriculum-list') {

      $tmp = $this->Curriculum->find('all', array(

        'conditions' => array(

          'Curriculum.visible' => true

        ),

        'order' => array(

          'Curriculum.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Curriculum']['id'],

            'value' => $data['Curriculum']['description'].'('.$data['Curriculum']['code'].')',

          );

        }

      }

    } else if ($code == 'student-assessment-list') {

      $conditions = array();

      $fees = '';

      $conditions['TableOfFee.visible'] = true;

      if(isset($this->request->query['feesID'])){

        $feesID = $this->request->query['feesID'];

        $conditions['TableOfFee.id'] = $feesID;

      }

      $academic_term_id = '';

      if(isset($this->request->query['academic_term_id'])){

        $academic_term_id = $this->request->query['academic_term_id'];

      }

      if(isset($this->request->query['yeartermID'])){

        $yeartermID = $this->request->query['yeartermID'] !== '' ? $this->request->query['yeartermID'] : 1;

      }

      $student_id = '';

      $studentData = array();

      if(isset($this->request->query['student_id'])){

        $student_id = $this->request->query['student_id'];

        $studentData = $this->Student->find('first', array(

          'contain' => array(
          
            'College' => array(

              'conditions' => array(

                'College.visible' => true

              ),

            ),

          
            'Degree' => array(

              'conditions' => array(

                'Degree.visible' => true

              ),

            ),

          ),

          'conditions' => array(

            'Student.visible' => true,

            'Student.id'      => $student_id,

          )

        ));

      }

      $curcourse = $this->PreregistrationSubject->query("
        
        SELECT

          IFNULL(SUM(Course.credit_unit),0) as cunits_total

        FROM

          preregistration_subjects as PreregistrationSubject LEFT JOIN

          courses as Course ON Course.id = PreregistrationSubject.course_id

        WHERE 

          PreregistrationSubject.visible = true AND

          Course.visible = true AND

          PreregistrationSubject.student_id = $student_id AND

          PreregistrationSubject.academic_term_id = $academic_term_id

      ");
      
      $cunits_total = $curcourse[0][0]['cunits_total'];

      $tmp = $this->TableOfFee->find('first', array(

        'contain' => array(

          'TableOfFeeItem' => array(

            'ChartOfAccount' => array(

              'conditions' => array(

                'ChartOfAccount.visible' => true

              ),

            ),

            'conditions' => array(

              'TableOfFeeItem.visible' => true

            ),

          ),

        ),

        'conditions' => $conditions,

        'order' => array(

          'TableOfFee.id' => 'ASC',

        )

      ));

      $holder = array();

      $total = 0;

      if(!empty($tmp)){

        if(!empty($tmp['TableOfFeeItem'])){

          foreach ($tmp['TableOfFeeItem'] as $key => $value) {
            
            $default_tuition = 0;

            $account_id = $value['account_id'];

            $searchSetting = $this->OrsSetting->query("

              SELECT

                count(*) as total 

              FROM

                ors_settings as OrsSetting

              WHERE

                OrsSetting.visible = true AND

                OrsSetting.active = true AND

                OrsSetting.value = $account_id AND

                OrsSetting.code LIKE '%default_tuition%'

            ");
            
            if($searchSetting[0][0]['total'] <= 0){

              $default_tuition = $value['account_id'];

            }

            if($value['account_id'] == $default_tuition){

              $value['amount'] = floatval($value['amount']) * floatval($cunits_total);

            }

            $total += $value['amount'];

            $holder[] = array(

              'code'                   => $value['ChartOfAccount']['code'].'::'.$value['ChartOfAccount']['name'],

              'table_of_fee_id'        => $tmp['TableOfFee']['id'],

              'table_of_fee_item_id'   => $value['id'],

              'account_fees_id'        => $value['account_id'],

              'fee_amount'             => $value['amount'],

              'student_id'             => $student_id,

              'transaction_type_id'    => 1,

              'enrollment_transaction' => 'E',

              'term_id'                => $academic_term_id,

              'year_term_id'           => $yeartermID

            );
          
          }

        }

      }

      $row2 = array();

      if(!empty($studentData)){

        if($studentData['Degree']['id'] == 1){

          $row2 = $this->PreregistrationSubject->query("

            SELECT 

              PreregistrationSubject.id,

              PreregistrationSubject.course_id

            FROM

              preregistration_subjects as PreregistrationSubject LEFT JOIN

              courses as Course ON PreregistrationSubject.course_id = Course.id

            WHERE

              PreregistrationSubject.visible = true AND

              Course.visible = true AND

              PreregistrationSubject.year_term_id = $yeartermID AND

              PreregistrationSubject.student_id = $student_id AND

              PreregistrationSubject.academic_term_id = $academic_term_id

          ");
        
        }else{

          $row2 = $this->PreregistrationSubject->query("

            SELECT 

              PreregistrationSubject.id,

              PreregistrationSubject.course_id

            FROM

              preregistration_subjects as PreregistrationSubject LEFT JOIN

              courses as Course ON PreregistrationSubject.course_id = Course.id

            WHERE

              PreregistrationSubject.visible = true AND

              Course.visible = true AND

              PreregistrationSubject.student_id = $student_id AND

              PreregistrationSubject.academic_term_id = $academic_term_id

          ");

        }

      }

      if(!empty($row2)){

        foreach ($row2 as $key => $value) {

          $coursecheck = $this->CurriculumCourse->find('first',array(

            'conditions' => array(
                
              'CurriculumCourse.visible' => true,

              'CurriculumCourse.active' => true,

              'CurriculumCourse.course_id' => $value['PreregistrationSubject']['course_id']

            ),

          ));
          
          if(!empty($coursecheck)){

            $checkifempty = $this->CourseSpecialFee->find('all',array(

              'conditions' => array(

                'CourseSpecialFee.active' => true,

                'CourseSpecialFee.course_id' => $coursecheck['CurriculumCourse']['course_id']

              ),

            ));
            
            if(!empty($checkifempty)){

              foreach ($checkifempty as $key => $valuex) {
                
                $chart = $this->AccountFee->find('first',array(

                  'contain' => array(

                    'ChartOfAccount' => array(

                      'conditions' => array(

                        'ChartOfAccount.visible' => true,

                      ),

                    ),

                  ),

                  'conditions' => array(

                    'AccountFee.id' => $valuex['CourseSpecialFee']['account_fees_id'],

                    'AccountFee.visible' => true,

                    'AccountFee.visible' => true,

                  ),

                ));

                $total += $valuex['CourseSpecialFee']['course_fee'];

                $holder[] = array(

                  'code'                   => $chart['ChartOfAccount']['code'].'::'.$chart['ChartOfAccount']['name'],

                  'table_of_fee_id'        => $tmp['TableOfFee']['id'],

                  'table_of_fee_item_id'   => $valuex['CourseSpecialFee']['id'],

                  'account_fees_id'        => $valuex['CourseSpecialFee']['account_fees_id'],

                  'fee_amount'             => $valuex['CourseSpecialFee']['course_fee'],

                  'student_id'             => $student_id,

                  'transaction_type_id'    => 1,

                  'enrollment_transaction' => 'E',

                  'term_id'                => $academic_term_id,

                  'year_term_id'           => $yeartermID

                );

              }

            }

          }

        }
        
      }

      $datas = array(

        'id'             => @$tmp['TableOfFee']['id'],

        'TableOfFeeItem' => $holder,

        'total'          => $total,

      );

    } else if ($code == '_get_curr_courses') {
      
      $curriculum = '';

      if(isset($this->request->query['curriculum_id'])){

        $curriculum_id = $this->request->query['curriculum_id'];

        $curriculum = "AND Curriculum.id = $curriculum_id";

      }

      $tmp = $this->Curriculum->query("

        SELECT

          Course.id,

          Course.code,

          YearLevelTerm.description

        FROM

          courses as Course LEFT JOIN

          curriculum_courses as CurriculumCourse ON CurriculumCourse.course_id = Course.id LEFT JOIN

          curriculums as Curriculum ON Curriculum.id = CurriculumCourse.curriculum_id LEFT JOIN

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = CurriculumCourse.year_term_id

        WHERE

          Course.visible = true $curriculum AND

          CurriculumCourse.visible = true AND

          Curriculum.visible = true AND

          CurriculumCourse.active = true

        GROUP BY

          Course.id

        ORDER BY

          CAST(YearLevelTerm.chronological_order AS DECIMAL) ASC,

          Course.code ASC

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Course']['id'],

            'value' => $data['Course']['code'],

            'year_level_term' => $data['YearLevelTerm']['description'],

          );

        }

      }

    } else if ($code == 'block-list') {

      $tmp = $this->CollegeBlock->find('all', array(

        'conditions' => array(

          'CollegeBlock.visible' => true

        ),

        'order' => array(

          'CollegeBlock.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['CollegeBlock']['id'],

            'value' => $data['CollegeBlock']['description'].'('.$data['Curriculum']['code'].')',

          );

        }

      }

    } else if ($code == 'class-event-list') {

      $tmp = $this->ClassEvent->find('all', array(

        'conditions' => array(

          'ClassEvent.visible' => true

        ),

        'order' => array(

          'ClassEvent.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['ClassEvent']['id'],

            'value' => $data['ClassEvent']['class_event'],

          );

        }

      }

    } else if ($code == 'room-list') {

      $tmp = $this->Room->query("

        SELECT  

          Room.id,

          Room.code,

          Room.name,

          CONCAT(Building.code,' - ',Building.name) as building

        FROM

          rooms as Room LEFT JOIN

          buildings as Building ON Room.building_id = Building.id

        WHERE

          Room.visible = true AND

          Building.visible = true

        ORDER BY

          Building.code ASC,

          Room.code ASC

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Room']['id'],

            'value' => $data['Room']['code'],

            'building' => $data[0]['building'],

          );

        }

      }

    } else if ($code == 'evaluation-a-list') {

      $datas[] = array(

        'id'        => 1,

        'value'     => 'Demonstrate sensitivity to students\' ability to attend and absorb content information.',

        'label'     => 'Choose an answer for question #1'

      );

      $datas[] = array(

        'id'        => 2,

        'value'     => 'Integrates sensitively his/her learning objectives with those of the students in a collaborative process.',

        'label'     => 'Choose an answer for question #2'

      );

      $datas[] = array(

        'id'        => 3,

        'value'     => 'Shows concern for the welfare of the students by making himself available beyond official time referring their needs to other concerned units/persons/authorities.',

        'label'     => 'Choose an answer for question #3'

      );

      $datas[] = array(

        'id'        => 4,

        'value'     => 'Comes to class on time.',

        'label'     => 'Choose an answer for question #4'

      );

      $datas[] = array(

        'id'        => 5,

        'value'     => 'Shows enthusiasm for teaching and learning and for the subject being taught.',

        'label'     => 'Choose an answer for question #5'

      );

    } else if ($code == 'evaluation-b-list') {

      $datas[] = array(

        'id'        => 1,

        'value'     => 'Demonstrate mastery of the subject matter.',

        'label'     => 'Choose an answer for question #1'

      );

      $datas[] = array(

        'id'        => 2,

        'value'     => 'Draws and shares information on the state of the art theory and practice in his/her discipline.',

        'label'     => 'Choose an answer for question #2'

      );

      $datas[] = array(

        'id'        => 3,

        'value'     => 'Integrates subject to practical circumstances and learning purposes of students.',

        'label'     => 'Choose an answer for question #3'

      );

      $datas[] = array(

        'id'        => 4,

        'value'     => 'Explain the relevance of present topics to the previous lessons; relates the subject matter to relevant current issues and daily life activities.',

        'label'     => 'Choose an answer for question #4'

      );

      $datas[] = array(

        'id'        => 5,

        'value'     => 'Demonstrate up-to-date knowledge and/or awareness on current trends and issues on the subject.',

        'label'     => 'Choose an answer for question #5'

      );

    } else if ($code == 'evaluation-c-list') {

      $datas[] = array(

        'id'        => 1,

        'value'     => 'Creates teaching strategies that allow students to practice using concepts they need to understand (interactive discussion).',

        'label'     => 'Choose an answer for question #1'

      );

      $datas[] = array(

        'id'        => 2,

        'value'     => 'Enhances students\' self-esteem and recognizes their abilities and performance.',

        'label'     => 'Choose an answer for question #2'

      );

      $datas[] = array(

        'id'        => 3,

        'value'     => 'Allows students to create their own course with objectives and realistically defined student-professor rules and makes them accountable for their performance.',

        'label'     => 'Choose an answer for question #3'

      );

      $datas[] = array(

        'id'        => 4,

        'value'     => 'Allows students to think independently and make their own decisions and holds them accountable for their performance based largely on their success in executing decisions.',

        'label'     => 'Choose an answer for question #4'

      );

      $datas[] = array(

        'id'        => 5,

        'value'     => 'Encourages students to learn beyond what is required and provides activities that develop analytical thinking.',

        'label'     => 'Choose an answer for question #5'

      );

    } else if ($code == 'evaluation-d-list') {

      $datas[] = array(

        'id'        => 1,

        'value'     => 'Creates opportunities for intensive and/or extensive contribution of students in the class activities (e.g. breaks class into dyads, triads, or buzz/task groups).',

        'label'     => 'Choose an answer for question #1'

      );

      $datas[] = array(

        'id'        => 2,

        'value'     => 'Assumes roles as facilitators, resource person, coach, inquisitor, integrator, referee in drawing students to contribute to knowledge and understanding of the concepts at hand.',

        'label'     => 'Choose an answer for question #2'

      );

      $datas[] = array(

        'id'        => 3,

        'value'     => 'Designs and implements learning conditions and experience that promotes healthy exchange and/or confrontations.',

        'label'     => 'Choose an answer for question #3'

      );

      $datas[] = array(

        'id'        => 4,

        'value'     => 'Structures/re-structures learning and teaching/learning context to enhance attainment of collective learning objectives.',

        'label'     => 'Choose an answer for question #4'

      );

      $datas[] = array(

        'id'        => 5,

        'value'     => 'Use of instructional materials such as audio/video materials, films/computers, multi-media, etc. to reinforce learning processes.',

        'label'     => 'Choose an answer for question #5'

      );

    } else if ($code == 'counseling-apporintment-code'){

      $tmp = $this->CounselingAppointments->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'CA-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'approval-enrolled-course-code'){

      $tmp = $this->ApprovalEnrolledCourse->query("

        SELECT 

          count(*) as total

        FROM 

          approval_enrolled_courses as ApprovalEnrolledCourse

      ");
   
      $datas = 'AEC-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'payment-code'){

      $tmp = $this->Payment->query("

        SELECT 

          count(*) as total

        FROM 

          payments as Payment

      ");
   
      $datas = 'PAY-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'award-list') {

      $tmp = $this->AwardManagements->find()
        ->where(['visible' => 1])

        ->order(['id' => 'ASC'])

        ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['name']

          );

        }

      }

    } else if ($code == 'awardee-management-code'){

      $tmp = $this->AwardeeManagements->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'ALI-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'filtered-section-list') {

      $year_term_id = $this->request->query['year_term_id'];

      $tmp = $this->Section->find('all', array(

        'conditions' => array(

          'Section.visible' => true,

          'Section.year_term' =>$year_term_id,

        ),

        'order' => array(

          'Section.name' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['Section']['id'],

            'value'   => $data['Section']['name']

          );

        }

      }

    } else if ($code == 'club-list') {

      $tmp = $this->Clubs->find()

          ->where(['visible' => 1])

          ->order(['code' => 'ASC'])

          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['code'].' - '.$data['title']

          );

        }

      }

    } else if ($code == 'student-club-code'){

      $tmp = $this->StudentClubs->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'STC-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'faculty-evaluation-code'){

      $tmp = $this->FacultyEvaluation->query("

        SELECT 

          count(*) as total

        FROM 

          faculty_evaluations as FacultyEvaluation

      ");
   
      $datas = 'FAE-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'gco-evaluation-code'){

      $tmp = $this->GcoEvaluations->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'GCE-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'attendance-counseling-code'){

     $tmp = $this->AttendanceCounselings->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'ATC-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'referral-slip-code'){

      $tmp = $this->ReferralSlips->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'RS-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'appointment-slip-code'){

      $tmp = $this->AppointmentSlips->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'AS-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'promissory-note-code'){

      $tmp = $this->PromissoryNotes->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'PNW-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'good-moral-code'){

      $tmp = $this->GoodMoral->query("

        SELECT 

          count(*) as total

        FROM 

          good_morals as GoodMoral

      ");
   
      $datas = 'GM-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'affidavit-code'){

      $tmp = $this->Affidavits->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'ALI-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'calendar-activity-code'){

      $tmp = $this->CalendarActivities->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'COA-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    }  else if ($code == 'learning-resource-member-code'){

      $tmp = $this->LearningResourceMembers->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'LRM-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'bibliography-code'){

      $tmp = $this->Bibliography->query("

        SELECT 

          count(*) as total

        FROM 

          bibliographies as Bibliography

      ");
   
      $datas = 'BBG-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'referral-recommendation-code'){

      $tmp = $this->ReferralRecommendations->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'RR-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'dental-code'){

      $tmp = $this->Dentals->find()->where([

        "visible" => 1

      ])->count();
   
   
      $datas = 'DEN-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    }else if ($code == 'medical-consent-code'){

      $tmp = $this->MedicalConsent->query("

        SELECT 

          count(*) as total

        FROM 

          medical_consents as MedicalConsent

      ");
   
      $datas = 'MDC-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    }else if ($code == 'apartelle-code'){

      $tmp = $this->Apartelles->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'APT-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    }else if ($code == 'apartelle-student-clearance-code'){

      $tmp = $this->ApartelleStudentClearances->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'ASC-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    }else if($code == 'student-clearance-code'){

      $tmp = $this->StudentClearances->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'STC-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'consultation'){

      $tmp = $this->Consultations->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'CST-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'completions'){

      $tmp = $this->Completions->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'CPT-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'request-form-code'){

      $this->loadModel('RequestForms');
      
      $tmp = $this->RequestForms->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'REQ-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'faculty-clearance-code'){

      $tmp = $this->FacultyClearances->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'FC-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'apartelle-registration-code'){

      $tmp = $this->ApartelleRegistrations->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'ADR-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'item-issuance-code'){

      $tmp = $this->ItemIssuances->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'ISM-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'add-drop-subject'){

      $tmp = $this->AddingDroppingSubjects->find()->where([

        "visible" => 1,

      ])->count();
   
      $datas = 'ADS-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'medical-certificate-code'){

      $tmp = $this->MedicalCertificate->query("

        SELECT 

          count(*) as total

        FROM 

          medical_certificates as MedicalCertificate

      ");
   
      $datas = 'MCR-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'customer-satisfaction-code'){

      $tmp = $this->CustomerSatisfaction->query("

        SELECT 

          count(*) as total

        FROM 

          customer_satisfactions as CustomerSatisfaction

      ");
   
      $datas = 'CS-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'program-adviser-code'){

      $tmp = $this->ProgramAdviser->query("

        SELECT 

          count(*) as total

        FROM 

          program_advisers as ProgramAdviser

      ");
   
      $datas = 'PA-' . str_pad($tmp[0][0]['total'] + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'counseling-appointment-list') {

      $conditions = '';

      if($this->request->getQuery('id')==null){

        $conditions = "AND CounselingAppointment.attendance_counseling_id IS NULL";

      }
      
     
      $tmp = "

        SELECT 

          CounselingAppointment.*,

          CounselingType.name

        FROM 

          counseling_appointments as CounselingAppointment LEFT JOIN 

          counseling_types as CounselingType ON CounselingType.id = CounselingAppointment.counseling_type_id

        WHERE 

          CounselingAppointment.visible = 1 $conditions AND 

          CounselingAppointment.approve = 4 AND 

          CounselingType.visible = 1

      ";
      
      $connection = $this->CounselingAppointments->getConnection();

      $result = $connection->execute($tmp)->fetchAll('assoc');

      if(!empty($result)){

        foreach ($result as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code'].'( '.$data['student_name'].' :: '.$data['name'].' )',

          );

        }

      }


    } else if ($code == 'counseling-attendance-list') {

      $student_id = $this->Auth->user('studentId');

      $tmp = "

        SELECT 

          AttendanceCounseling.*,

          CounselingAppointment.counselor_name

        FROM 

          attendance_counselings as AttendanceCounseling LEFT JOIN 

          counseling_appointments as CounselingAppointment ON CounselingAppointment.id = AttendanceCounseling.counseling_appointment_id

        WHERE 

          AttendanceCounseling.visible = true AND 

          AttendanceCounseling.gco_evaluation_id IS NULL AND 

          CounselingAppointment.visible = true AND 

          CounselingAppointment.student_id = $student_id

      ";

      $connection = $this->AttendanceCounselings->getConnection();

      $result = $connection->execute($tmp)->fetchAll('assoc');

      if(count($result)>0){

        foreach ($result as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code'].'( '.$data['counselor_name'].' :: '.fdate($data['date'],'m/d/Y').' :: '.fdate($data['time'],'h:i A').' )',

          );

        }

      }

    } else if ($code == 'counseling-type-list') {
     
      $tmp = $this->CounselingTypes->find()
              ->where(['visible' => 1])
              ->orderAsc('name')
              ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['name'],

          );

        }

      }

    } else if ($code == 'material-type-list') {

      $tmp = $this->MaterialTypes->find()

      ->where([

        "visible" => 1,

      ])

      ->order([

        "name" => "ASC",

      ])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['name'],

          );

        }

      }

    } else if ($code == 'apartelle-list') {
     
      $tmp = $this->Apartelles->find()

        ->where(['visible' => 1])

        ->order(['id' => 'ASC']);

      $result = $tmp->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $id =$data['id'];
          
          $query = $this->ApartelleRegistrations->find()

            ->where([

                'visible' => 1,

                'apartelle_id' => $id

            ])

            ->count();

          // var_dump($query);

          $counter = 0;

          // var_dump($query);

          if(is_numeric($data['capacity'])){

            $counter = $data['capacity'] - $query;

          }else{

            $counter = 0;

          }

          if($counter>0){

            $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['building_no']. ' - ' .$data['room_no']. ' - Capacity : ' .$counter,

            'capacity' => $counter

            );

          }

        }

      }


    } else if ($code == 'collection-type-list') {
     
      $tmp = $this->CollectionTypes->find()

      ->where([

        "visible" => 1,

      ])

      ->order([

        "name" => "ASC",

      ])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['name'],

          );

        }

      }

    } else if ($code == 'calendar-activities') {

      $datas = array();

      $employee_id = $this->Session->read('Auth.User.employeeId');

      $today = date('Y-m-d');

      $tmp = $this->CalendarActivity->query("

        SELECT

          CalendarActivity.*

        FROM

          calendar_activities as CalendarActivity

        WHERE

          CalendarActivity.visible = true

        ORDER BY

          CalendarActivity.code DESC

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $url = '#/guidance/calendar-activities/view/';

          $color = '#5cb85c';

          $end = date('Y-m-d', strtotime ('+1 day',strtotime($data['CalendarActivity']['endDate'])));

          $datas[] = array(

            'title'     => $data['CalendarActivity']['title']."\n".'Opening : '.fdate($data['CalendarActivity']['startDate'],'F d, Y')."\n".'Closing : '.fdate($data['CalendarActivity']['endDate'],'F d, Y'),

            'start'     => $data['CalendarActivity']['startDate'],

            'end'       => $end,

            'date_from' => $data['CalendarActivity']['startDate'],

            'date_to'   => $data['CalendarActivity']['endDate'],

            'url'       => $url . $data['CalendarActivity']['id'],

            'color'     => $color

          );

        }

      }

    } else if ($code == 'validate-class-schedule') {

      $conditions['ClassSchedule.visible'] = true;

      if(isset($this->request->query['schedule_id'])){

        $conditions['ClassSchedule.id !='] = $this->request->query['schedule_id'];

      }

      $faculty = $this->request->query['faculty'];

      $day = $this->request->query['day'];

      $room = $this->request->query['room'];

      $time_start = strtotime(fdate($this->request->query['time_start'],'H:i'));

      $time_end = strtotime(fdate($this->request->query['time_end'],'H:i'));
     
      $tmpData = $this->ClassSchedule->find('all', array(

        'contain' => array(
        
          'ClassScheduleSub' => array(

            'conditions' => array(

              'ClassScheduleSub.visible' => true

            ),

          ),

        ),

        'conditions' => $conditions

      ));

      if(!empty($tmpData)){

        foreach ($tmpData as $key => $value) {
          
          if(!empty($tmpData)){

            foreach ($value['ClassScheduleSub'] as $key => $values) {

              if($value['ClassSchedule']['faculty_id'] == $faculty){

                if($values['day'] == $day){

                  if($values['room_id'] == $room){

                    if ($time_start >= strtotime($values['time_start']) && $time_start <= strtotime($values['time_end'])) {
                      
                      $datas = array(

                        'ok' => false,

                        'msg' => 'Faculty is conflict to selected room and time to Class Schedule '.$value['ClassSchedule']['code']

                      );

                    }elseif($time_end >= strtotime($values['time_start']) && $time_end <= strtotime($values['time_end'])){

                      $datas = array(

                        'ok' => false,

                        'msg' => 'Faculty is conflict to selected room and time to Class Schedule '.$value['ClassSchedule']['code']

                      );

                    }else{

                      $datas = array(

                        'ok' => true,

                        'msg' => ''

                      );

                    }

                  }else{

                    if ($time_start >= strtotime($values['time_start']) && $time_start <= strtotime($values['time_end'])) {
                      
                      $datas = array(

                        'ok' => false,

                        'msg' => 'Faculty is conflict to selected room and time to Class Schedule '.$value['ClassSchedule']['code']

                      );

                    }elseif($time_end >= strtotime($values['time_start']) && $time_end <= strtotime($values['time_end'])){

                      $datas = array(

                        'ok' => false,

                        'msg' => 'Faculty is conflict to selected room and time to Class Schedule '.$value['ClassSchedule']['code']

                      );

                    }else{

                      $datas = array(

                        'ok' => true,

                        'msg' => ''

                      );

                    }

                  }

                }else{

                  $datas = array(

                    'ok' => true,

                    'msg' => ''

                  );

                }

              }else{

                if($values['day'] == $day){

                  if($values['room_id'] == $room){

                    if ($time_start >= strtotime($values['time_start']) && $time_start <= strtotime($values['time_end'])) {
                      
                      $datas = array(

                        'ok' => false,

                        'msg' => 'Faculty is conflict to selected room and time to Class Schedule '.$value['ClassSchedule']['code']

                      );

                    }elseif($time_end >= strtotime($values['time_start']) && $time_end <= strtotime($values['time_end'])){

                      $datas = array(

                        'ok' => false,

                        'msg' => 'Faculty is conflict to selected room and time to Class Schedule '.$value['ClassSchedule']['code']

                      );

                    }else{

                      $datas = array(

                        'ok' => true,

                        'msg' => ''

                      );

                    }

                  }else{

                    $datas = array(

                      'ok' => true,

                      'msg' => ''

                    );
                    
                  }

                }else{

                  $datas = array(

                    'ok' => true,

                    'msg' => ''

                  );

                }

              }
              
            }

          }

        }

      }else{

        $datas = array(

          'ok' => true,

          'msg' => ''

        );

      }

    } else if ($code == 'block-section-list') {

      $college_id = $this->request->query['college_id'];

      $program_id = $this->request->query['program_id'];

      $year_term_id = $this->request->query['year_term_id'];

      $tmp = $this->BlockSection->find('all', array(

        'conditions' => array(

          'BlockSection.visible' => true,

          'BlockSection.college_id' => $college_id,

          'BlockSection.program_id' => $program_id,

          'BlockSection.year_term_id' => $year_term_id,

        ),

        'order' => array(

          'BlockSection.section' => 'ASC'

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $courses = Set::extract('{}.BlockSectionCourse',$this->BlockSectionCourse->find('all', array(

            'conditions' => array(

              'BlockSectionCourse.visible' => true,

              'BlockSectionCourse.block_section_id' => $data['BlockSection']['id']

            )

          )));

          $datas[] = array(

            'id'       => $data['BlockSection']['id'],

            'section'  => $data['BlockSection']['section'],

            'courses'  => $courses

          );

        }

      }

    } else if ($code == 'block-section-enrollment') {

      $block_section_id = $this->request->query['block_section_id'];

      $tmp = $this->BlockSection->query("

        SELECT 

          BlockSectionCourse.*

        FROM 

          block_sections as BlockSection LEFT JOIN 

          block_section_courses as BlockSectionCourse ON BlockSectionCourse.block_section_id = BlockSection.id 

        WHERE 

          BlockSection.visible = true AND 

          BlockSection.id = $block_section_id AND 

          BlockSectionCourse.visible = true 

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $schedules = Set::extract('{}.BlockSectionSchedule',$this->BlockSectionSchedule->find('all', array(

            'conditions' => array(

              'BlockSectionSchedule.visible' => true,

              'BlockSectionSchedule.block_section_course_id' => $data['BlockSectionCourse']['id']

            )

          )));

          $courses = $this->Course->findById($data['BlockSectionCourse']['course_id']);

          $btn_status = 0;

          if(empty($schedules)){

            $btn_status = 1;

          }

          if($data['BlockSectionCourse']['slot'] <= $data['BlockSectionCourse']['enrolled_students']){

            $btn_status = 1;

          }

          $datas[] = array(

            'id'               => $data['BlockSectionCourse']['id'],
 
            'faculty_id'       => $data['BlockSectionCourse']['faculty_id'],

            'faculty_name'     => $data['BlockSectionCourse']['faculty_name'],
 
            'slot'             => $data['BlockSectionCourse']['slot'] - $data['BlockSectionCourse']['enrolled_students'],
 
            'room_id'          => $data['BlockSectionCourse']['room_id'],

            'room'             => $data['BlockSectionCourse']['room'],
 
            'schedules'        => $schedules,
 
            'btn_status'       => $btn_status,

            'course_id'        => $courses['Course']['id'],

            'course_code'      => $courses['Course']['code'],

            'course'           => $courses['Course']['title'],
 
            'credit_unit'      => $courses['Course']['credit_unit'] != null ? $courses['Course']['credit_unit'] : 0,
 
            'lecture_unit'     => $courses['Course']['lecture_unit'] != null ? $courses['Course']['lecture_unit'] : 0,

            'laboratory_unit'  => $courses['Course']['laboratory_unit'] != null ? $courses['Course']['laboratory_unit'] : 0,

            'lecture_hours'    => $courses['Course']['lecture_hours'] != null ? $courses['Course']['lecture_hours'] : 0,

            'laboratory_hours' => $courses['Course']['laboratory_hours'] != null ? $courses['Course']['laboratory_hours'] : 0,

          );

        }

      }

    }else if ($code == 'student-enrolled-courses') {

      if($this->Auth->user('employeeId')!=null){

        $employee_id = $this->Auth->user('employeeId');

        $tmp = $this->StudentEnrolledCourses->find()

        ->where([

          'visible' => 1,

          'faculty_id' => $employee_id,

        ])

        ->group([ 'course_id' ])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['course_id'],

            'value'   => $data['course'],

          );

        }

      }


      }


    }else if ($code == 'purpose-list') {

      $tmp = $this->Purposes->find()

          ->where(['visible' => 1])

          ->order(['code' => 'ASC'])

          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['id'],

            'value'   => $data['code'].' - '.$data['purpose']

          );

        }

      }

    } else if ($code == 'student-enrollment-course') {

      $college_id = $this->request->query['college_id'];

      $program_id = $this->request->query['program_id'];

      $year_term_id = $this->request->query['year_term_id'];

      $tmpData = $this->College->query("

        SELECT 

          CollegeSub.*

        FROM

          college_subs as CollegeSub LEFT JOIN

          colleges as College ON College.id = CollegeSub.college_id

        WHERE 

          College.visible = true AND 

          College.id = $college_id AND 

          CollegeSub.visible = true AND 

          CollegeSub.program_id = $program_id

      ");

      if(!empty($tmpData)){

        foreach ($tmpData as $k => $data) {

          $courses = $this->CollegeProgramCourse->find('all', array(

            'contain' => array(

              'Course' => array(

                'conditions' => array(

                  'Course.visible' => true

                )

              )

            ),

            'conditions' => array(

              'CollegeProgramCourse.visible' => true,

              'CollegeProgramCourse.college_program_id' => $data['CollegeSub']['program_id'],

              'CollegeProgramCourse.year_term_id' => $year_term_id,

            )

          ));

          if(!empty($courses)){

            foreach ($courses as $key => $value) {

              $course_id = $value['CollegeProgramCourse']['course_id'];

              $schedule = array();

              $schedules = $this->ClassScheduleSub->query("

                SELECT 

                  ClassSchedule.id,

                  ClassSchedule.code,

                  ClassSchedule.faculty_name,

                  ClassSchedule.faculty_id,

                  ClassScheduleSub.id as sub_id

                FROM

                  class_schedules as ClassSchedule LEFT JOIN 

                  class_schedule_subs as ClassScheduleSub ON ClassScheduleSub.class_schedule_id = ClassSchedule.id

                WHERE 

                  ClassSchedule.visible = true AND 

                  ClassScheduleSub.visible = true AND 

                  ClassScheduleSub.course_id = $course_id

              ");

              if(!empty($schedules)){

                foreach ($schedules as $keys => $dat) {

                  $schedule_days = $this->ClassScheduleDay->find('all', array(

                    'conditions' => array(

                      'ClassScheduleDay.visible' => true,

                      'ClassScheduleDay.class_schedule_id' => $dat['ClassSchedule']['id'],

                      'ClassScheduleDay.class_schedule_sub_id' => $dat['ClassScheduleSub']['sub_id'],

                    )

                  ));

                  if(!empty($schedule_days)){

                    foreach ($schedule_days as $index => $values) {
                      
                      $schedule[] = array(

                        'id'           => $dat['ClassSchedule']['id'],

                        'sub_id'       => $dat['ClassScheduleSub']['sub_id'],

                        'day_id'       => $values['ClassScheduleDay']['id'],

                        'code'         => $dat['ClassSchedule']['code'],

                        'faculty_id'   => $dat['ClassSchedule']['faculty_id'],

                        'faculty_name' => $dat['ClassSchedule']['faculty_name'],

                        'day'          => $values['ClassScheduleDay']['day'],

                        'room'         => $values['ClassScheduleDay']['room'],

                        'room_id'      => $values['ClassScheduleDay']['room_id'],

                        'slot'         => $values['ClassScheduleDay']['slot'],

                        'section_id'   => $values['ClassScheduleDay']['section_id'],

                        'section'      => $values['ClassScheduleDay']['section'],

                        'time_start'   => $values['ClassScheduleDay']['time_start'],

                        'time_end'     => $values['ClassScheduleDay']['time_end'],

                        'time'         => fdate($values['ClassScheduleDay']['time_start'],'h:i A').' - '.fdate($values['ClassScheduleDay']['time_end'],'h:i A'),

                      );

                    }

                  }

                }

              }
              
              $datas[] = array(

                'id'          => $value['CollegeProgramCourse']['id'],

                'course_id'   => $value['CollegeProgramCourse']['course_id'],

                'course_code' => $value['Course']['code'],

                'course'      => $value['Course']['title'],

                'schedule'    => $schedule

              );

            }

          }          

        }

      }

    } else if ($code == 'block-section-course-list') {

      $block_section_id = $this->request->query['block_section_id'];

      $tmp = $this->BlockSectionCourse->find('all', array(

        'conditions' => array(

          'BlockSectionCourse.visible' => true,

          'BlockSectionCourse.block_section_id' => $block_section_id

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'      => $data['BlockSection']['id'],

            'value'   => $data['BlockSectionCourse']['course'],

          );

        }

      }

    } else if ($code == 'get-course-unit') {

      $course_id = $this->request->query['course_id'];

      $tmp = $this->Course->findById($course_id);

      $datas[] = array(

        'credit_unit' => $tmp['Course']['credit_unit'] != null ? $tmp['Course']['credit_unit'] : 0,

        'lecture_unit' => $tmp['Course']['lecture_unit'] != null ? $tmp['Course']['lecture_unit'] : 0,

        'lecture_hours' => $tmp['Course']['lecture_hours'] != null ? $tmp['Course']['lecture_hours'] : 0,

        'laboratory_unit' => $tmp['Course']['laboratory_unit'] != null ? $tmp['Course']['laboratory_unit'] : 0,

        'laboratory_hours' => $tmp['Course']['laboratory_hours'] != null ? $tmp['Course']['laboratory_hours'] : 0,

      );

    } else if ($code == 'validate-enrollment-registration') {

      $student_id = $this->request->query['student_id'];

      $year_term_id = $this->request->query['year_term_id'];

      $tmp = $this->StudentEnrollment->find('count', array(

        'conditions' => array(

          'StudentEnrollment.visible' => true,

          'StudentEnrollment.student_id' => $student_id,

          'StudentEnrollment.year_term_id' => $year_term_id,

        )

      ));

      if($tmp > 0){

        $datas = array(

          'ok'       => false,

          'msg'      => 'Already registered.'

        );

      }else{

        $datas = array(

          'ok'       => true,

        );

      }

    }  else if ($code == 'faculty-list') {

      $id = $this->request->getQuery('id');
     
      $tmp = $this->Employees->find()

        -> where([

          'visible' => 1

        ])

        -> order([

          'id' => 'ASC'

        ]);

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['family_name'].', '.$data['given_name'].' '.(!is_null($data['middle_name']) ? $data['middle_name'] : ''),

          );

        }

      }

    } else if ($code == 'get-enrolled-courses') {

      $program_id = $this->request->getQuery('program_id');

      $course_id = $this->request->getQuery('course_id');

      $section_id = $this->request->getQuery('section_id');

      $year_term_id = $this->request->getQuery('year_term_id');

      $faculty_id = $this->request->getQuery('faculty_id');

      $student = "

        SELECT 

          Student.*,

          Student.id as student_id,

          StudentEnrolledCourse.id,

          StudentEnrolledCourse.section,

          StudentEnrolledCourse.course,

          StudentEnrolledCourse.midterm_grade,

          StudentEnrolledCourse.finalterm_grade,

          StudentEnrolledCourse.final_grade,

          StudentEnrolledCourse.remarks,

          StudentEnrolledCourse.midterm_submitted,

          StudentEnrolledCourse.finalterm_submitted,

          StudentEnrolledCourse.incomplete,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name

        FROM  

          students as Student LEFT JOIN 

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id

        WHERE 

          Student.visible = true AND 

          StudentEnrolledCourse.visible = true AND 

          StudentEnrolledCourse.year_term_id = $year_term_id AND 

          StudentEnrolledCourse.course_id = $course_id AND 

          StudentEnrolledCourse.section_id = $section_id

      ";

      $connection = $this->Students->getConnection();

      $result = $connection->execute($student)->fetchAll('assoc');

      if(!empty($result)){

        foreach ($result as $key => $value) {
          
          $datas[] = array(

            'id'                  => $value['id'],

            'code'                => $value['course'].' :: '.$value['section'],

            'student_id'          => $value['student_id'],

            'student_no'          => $value['student_no'],

            'student_name'        => $value['full_name'],

            'year_term_id'        => $value['year_term_id'],

            'midterm_grade'       => $value['midterm_grade'],

            'finalterm_grade'     => $value['finalterm_grade'],

            'final_grade'         => $value['final_grade'],

            'remarks'             => $value['remarks'],

            'midterm_submitted'   => $value['midterm_submitted'],

            'finalterm_submitted' => $value['finalterm_submitted'],

            'incomplete'          => $value['incomplete'],

          );

        }

      }

    }else if ($code == 'scholarship-application-code'){
    
      $tmp = $this->ScholarshipApplications->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = 'SCA-' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'college-program-requirements') {

      $program_id = $this->request->query['program_id'];
     
      $tmp = $this->CollegeProgramSub->find('all', array(

        'conditions' => array(

          'CollegeProgramSub.visible' => true,

          'CollegeProgramSub.college_program_id' => $program_id

        ),

        'order' => array(

          'CollegeProgramSub.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['CollegeProgramSub']['id'],

            'value' => $data['CollegeProgramSub']['requirement'],

          );

        }

      }

    } else if ($code == 'schedule-list') {

      $condition = '';

      if($this->request->getQuery('id')){

        $id = $this->request->query['id'];

        $condition .= "AND ClassScheduleDay.class_schedule_id <> $id"; 

      }

      if($this->request->getQuery('year_term_id')){

        $year_term_id = $this->request->getQuery('year_term_id');

        $condition .= "AND ClassSchedule.year_term_id = $year_term_id "; 

      }

      if($this->request->getQuery('school_year_start') && $this->request->getQuery('school_year_end')){

        $school_year_start = strval($this->request->getQuery('school_year_start'));

        $school_year_end = strval($this->request->getQuery('school_year_end'));

        $condition .= "AND ClassSchedule.school_year_start = $school_year_start "; 
        
        $condition .= "AND ClassSchedule.school_year_end = $school_year_end "; 

      }

      $tmp = $this->ClassSchedules->query("

        SELECT 

          ClassSchedule.code as schedule_code,

          ClassSchedule.id as schedule_id,

          ClassScheduleTmp.id as tmp_id,

          ClassScheduleDay.*

        FROM  

          class_schedules as ClassSchedule LEFT JOIN

          class_schedule_days as ClassScheduleDay ON ClassSchedule.id = ClassScheduleDay.class_schedule_id LEFT JOIN

          class_schedule_tmps as ClassScheduleTmp ON ClassScheduleDay.class_schedule_id = ClassScheduleTmp.class_schedule_id AND ClassScheduleTmp.class_schedule_sub_id = ClassScheduleDay.class_schedule_sub_id

        WHERE 

          ClassSchedule.visible = true AND 

          ClassScheduleTmp.visible = true AND 

          ClassScheduleTmp.day = ClassScheduleDay.day AND

          ClassScheduleDay.visible = true $condition

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'         => $data['id'],

            'code'       => $data['schedule_code'],

            'day'        => $data['day'],

            'time_start' => fdate($data['time_start'],'h:i A'),

            'time_end'   => fdate($data['time_end'],'h:i A'),

            'room_id'    => $data['room_id'],

            'room'       => $data['room'],

            'section_id'    => $data['section_id'],

            'section'    => $data['section'],

            'schedule_id'    => $data['schedule_id'],

            'tmp_id'    => $data['tmp_id'],


          );

        }

      }

    } else if ($code == 'ailment-list') {
     
      $tmp = $this->IllnessRecommendations->find()

        ->where([

          "visible" => 1,

        ])

        ->order([

          'ailment' => 'ASC'

        ])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['ailment']

          );

        }

      }

    } else if ($code == 'item-list') {

      $type = $this->request->query['type'];
     
      $tmp = $this->PropertyLog->find('all', array(

        'conditions' => array(

          'PropertyLog.visible' => true,

          'PropertyLog.type' => $type

        ),

        'order' => array(

          'PropertyLog.property_name' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['PropertyLog']['id'],

            'value' => $data['PropertyLog']['property_name']

          );

        }

      }

    } else if ($code == 'dental-list') {
     
       $tmp = $this->Dentals
          ->find()
          ->where([
              'visible' => 1,
          ])
          ->order([
              'code' => 'ASC',
          ])
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code'],

          );

        }

      }

    } else if ($code == 'consultation-list') {
     
       $tmp = $this->Consultations
          ->find()
          ->where([
              'visible' => 1,
          ])
          ->order([
              'code' => 'ASC',
          ])
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['code'],

          );

        }

      }

    } else if ($code == 'faculty-list-all') {

      $tmp = $this->Employee->find('all', array(

        'conditions' => array(

          'Employee.visible' => true

        ),

        'order' => array(

          'Employee.family_name' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Employee']['id'],

            'value' => $data['Employee']['family_name'].', '.$data['Employee']['given_name'].' '.(!is_null($data['Employee']['middle_name']) ? $data['Employee']['middle_name'] : ''),

          );

        }

      }

    }else if ($code == 'college-list-all') {

      $tmp = $this->College->find('all', array(

        'conditions' => array(

          'College.visible' => true

        ),

        'order' => array(

          'College.code' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['College']['id'],

            'value' => $data['College']['name'],

          );

        }

      }

    } else if ($code == 'college-program-list-all') {
  
      $tmp = $this->CollegePrograms
          ->find()
          ->where([
              'visible' => 1,
          ])
          ->order([
              'name' => 'ASC',
          ])
          ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['name'],

          );

        }

      }

    }else if ($code == 'class-schedule-code'){

      $tmp = $this->ClassSchedules->find()->where([

        "visible" => 1

      ])->count();
   
      $datas = '2023BSME' . str_pad($tmp + 1, 5, "0", STR_PAD_LEFT);

    } else if ($code == 'class-schedule-list') {
  
      $tmp = $this->ClassScheduleDay->find('all', array(

        'conditions' => array(

          'ClassScheduleDay.visible' => true,

        ),

        'order' => array(

          'ClassScheduleDay.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['ClassScheduleDay']['id'],

            'value' => $data['ClassScheduleDay']['day']. ' - ' .$data['ClassScheduleDay']['time_start']. ' - ' . $data['ClassScheduleDay']['time_end']

          );

        }

      }

    } else if ($code == 'ailment-prescription-list') {

      $id = $this->request->getQuery('id');

      $tmp = $this->IllnessRecommendationSubs->find()

        ->where([

          'visible' => 1,

          'illness_recommendation_id' => $id

        ])

        ->order([

          'prescription' => 'ASC'

        ])

      ->all();

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['id'],

            'value' => $data['prescription']

          );

        }

      }

    }else if ($code == 'major-list') {
     
      $tmp = $this->Major->find('all', array(

        'conditions' => array(

          'Major.visible' => true

        ),

        'order' => array(

          'Major.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Major']['id'],

            'value' => $data['Major']['name'],

          );

        }

      }

      } else if ($code == 'campus-list') {
     
      $tmp = $this->Campus->find('all', array(

        'conditions' => array(

          'Campus.visible' => true

        ),

        'order' => array(

          'Campus.id' => 'ASC',

        )

      ));

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $datas[] = array(

            'id'    => $data['Campus']['id'],

            'value' => $data['Campus']['code'].' - '.$data['Campus']['name'],

          );

        }

      }

    } else if ($code == 'block-section-courses') {

      $block_section_id = $this->request->query['block_section_id'];

      $block_section = $this->BlockSection->find('first', array(

        'conditions' => array(

          'BlockSection.visible' => true,

          'BlockSection.id' => $block_section_id

        )

      ));

      $year_term_id = $block_section['BlockSection']['year_term_id'];

      $program_id = $block_section['BlockSection']['program_id'];
     
      $tmp = $this->CollegeProgramCourse->query("

        SELECT 

          Course.*

        FROM 

          college_program_courses as CollegeProgramCourse LEFT JOIN 

          courses as Course ON Course.id = CollegeProgramCourse.course_id 

        WHERE 

          CollegeProgramCourse.visible = true AND 

          CollegeProgramCourse.college_program_id = $program_id AND 

          CollegeProgramCourse.year_term_id = $year_term_id AND 

          Course.visible = true

        ORDER BY 

          Course.title ASC

      ");

      if(!empty($tmp)){

        foreach ($tmp as $k => $data) {

          $block_section_courses = $this->BlockSectionCourse->find('count', array(

            'conditions' => array(

              'BlockSectionCourse.visible' => true,

              'BlockSectionCourse.block_section_id' => $block_section_id,

              'BlockSectionCourse.course_id' => $data['Course']['id']

            )

          ));

          if($block_section_courses == 0){

            $datas[] = array(

              'block_section_id'  => $block_section_id,

              'course_id'         => $data['Course']['id'],

              'course_code'       => $data['Course']['code'],

              'course_title'      => $data['Course']['title'],

              'selected'          => 0,

            );

          }

        }

      }

    } else {

      $datas = array();

    }

    if($code == 'calendar-activities'){

      $response = $datas;

    }else{

      $user = $this->Auth->user();

      $response = array(

        'ok'          => true,

        'data'        => $datas,

        // 'employeeId'  => $this->Session->read('Auth.User.employeeId'),

        // 'studentId'   => $this->Session->read('Auth.User.studentId')

        'employeeId'  => @$user['employeeId'],

        'studentId'   => @$user['studentId']

      );

    }
  
    // $this->set(array(

    //   'response'   => $response,

    //   '_serialize' => 'response',

    // ));

    $this->response->withType('application/json');
    $this->response->getBody()->write(json_encode($response));
    return $this->response;

  }
  
}

