<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Controller\Controller;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\View\ViewBuilder;
use Cake\View\Helper\UrlHelper;
use Cake\Collection\Collection;

class PrintController extends AppController {

  public function initialize(): void{

	parent::initialize();

	$this->loadComponent('RequestHandler');

	$this->loadComponent('Global');

	// $this->LearningResourceMembers = TableRegistry::getTableLocator()->get('LearningResourceMembers');

	$this->Completion = TableRegistry::getTableLocator()->get('Completions');

	$this->RequestForm = TableRegistry::getTableLocator()->get('RequestForms');

	$this->AttendanceCounseling = TableRegistry::getTableLocator()->get('AttendanceCounselings');

	$this->CounselingAppointment = TableRegistry::getTableLocator()->get('CounselingAppointments');

	$this->StudentBehaviors = TableRegistry::getTableLocator()->get('StudentBehaviors');

	$this->ScholarshipName = TableRegistry::getTableLocator()->get('ScholarshipNames');

	$this->ScholarshipApplication = TableRegistry::getTableLocator()->get('ScholarshipApplications');

	$this->StudentEnrolledSchedules = TableRegistry::getTableLocator()->get('StudentEnrolledSchedules');

	$this->AddingDroppingSubjectSubs = TableRegistry::getTableLocator()->get('AddingDroppingSubjectSubs');

	$this->Transferees = TableRegistry::getTableLocator()->get('Transferees');

	$this->ProgramAdvisers = TableRegistry::getTableLocator()->get('ProgramAdvisers');

	$this->Tors = TableRegistry::getTableLocator()->get('Tors');

	$this->loadModel('Students');

	$this->loadModel('ScholasticDocuments');

	$this->loadModel('RequestedFormPayments');

	$this->loadModel('AddingDroppingSubjects');

	$this->loadModel('ClassSchedules');

	$this->loadModel('BlockSections');

	$this->loadModel('ApartelleStudentClearances');

	$this->loadModel('Assessments');

	$this->loadModel('ParticipantEvaluationActivities');

	$this->loadModel('Payments');

	$this->loadModel('AddingDroppingSubjects');

	$this->loadModel('InterviewRequests');

	$this->loadModel('ScholarshipApplications');

	$this->loadModel('StudentProfiles');

	$this->loadModel('Dentals');

	$this->loadModel('YearLevelTerms');

	$this->loadModel('CollegeProgramCourses');

	$this->loadModel('StudentApplications');

	$this->loadModel('Sections');

	$this->loadModel('BlockSections');

	$this->loadModel('Clubs');

	$this->loadModel('StudentClubs');

	$this->loadModel('Bibliographies');

	$this->loadModel('AddingDroppingSubjectSubs');

	$this->loadModel('Tors');

	$this->Courses = TableRegistry::getTableLocator()->get('Courses');

	$this->Colleges = TableRegistry::getTableLocator()->get('Colleges');

	$this->CollegePrograms = TableRegistry::getTableLocator()->get('CollegePrograms');

	$this->FacultyClearances = TableRegistry::getTableLocator()->get('FacultyClearances');

	$this->loadModel('Affidavits');

	$this->loadModel('ReferralSlips');

	$this->loadModel('AppointmentSlips');

	$this->loadModel('CalendarActivities');

	$this->loadModel('CounselingIntakes');

	$this->loadModel('ParticipantEvaluationActivities');

	$this->loadModel('StudentExits');

	$this->loadModel('GcoEvaluations');

	$this->loadModel('CounselingAppointments');

	$this->loadModel('AttendanceCounselings');

	$this->loadModel('Employees');

	$this->loadModel('AffidavitOfLosses');

	$this->loadModel('Curriculums');

	$this->loadModel('Ptcs');

	$this->InventoryProperties = TableRegistry::getTableLocator()->get('InventoryProperties');

	$this->LearningResourceMembers = TableRegistry::getTableLocator()->get('LearningResourceMembers');

	$this->Bibliographies = TableRegistry::getTableLocator()->get('Bibliographies');

	$this->InventoryBibliographies = TableRegistry::getTableLocator()->get('InventoryBibliographies');

	$this->CheckOuts = TableRegistry::getTableLocator()->get('CheckOuts');

	$this->CheckOutSub = TableRegistry::getTableLocator()->get('CheckOutSubs');

	$this->CheckIns = TableRegistry::getTableLocator()->get('CheckIns');

	$this->IllnessRecommendations = TableRegistry::getTableLocator()->get('IllnessRecommendations');

	$this->PropertyLogs = TableRegistry::getTableLocator()->get('PropertyLogs');

	$this->Consultations = TableRegistry::getTableLocator()->get('Consultations');

	$this->loadModel("GoodMorals");

	$this->loadModel("NurseProfiles");

	$this->loadModel('StudentLogs');

	$this->loadModel('Prospectuses');


	$this->GoodMorals = TableRegistry::getTableLocator()->get('GoodMorals');

	$this->Apartelles = TableRegistry::getTableLocator()->get('Apartelles');

	$this->Prescriptions = TableRegistry::getTableLocator()->get('Prescriptions');

	$this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

	$this->CounselingIntakeSubs = TableRegistry::getTableLocator()->get('CounselingIntakeSubs');

	$this->MedicalEmployeeProfiles = TableRegistry::getTableLocator()->get('MedicalEmployeeProfiles');

	$this->ReferralRecommendations = TableRegistry::getTableLocator()->get('ReferralRecommendations');

	$this->ItemIssuances = TableRegistry::getTableLocator()->get('ItemIssuances');

	$this->MedicalCertificates = TableRegistry::getTableLocator()->get('MedicalCertificates');

	$this->ApartelleRegistrations = TableRegistry::getTableLocator()->get('ApartelleRegistrations');

	$this->MedicalStudentProfiles = TableRegistry::getTableLocator()->get('MedicalStudentProfiles');

	$this->BlockSectionCourses = TableRegistry::getTableLocator()->get('BlockSectionCourses');

	$this->CheckInSub = TableRegistry::getTableLocator()->get('CheckInSubs');

	$this->loadModel('Reports');

	$this->loadModel('MedicalEmployeeProfiles');

	$this->loadModel('RegisteredStudents');

	$this->viewBuilder = new ViewBuilder();

	$this->view = $this->viewBuilder->build();

	$this->urlHelper = new UrlHelper($this->view);

	$this->base = $this->urlHelper->build('/', ['fullBase' => true]);

  }

  public function course(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search') != null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->Courses->getAllCoursePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Course Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(5,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CODE',1,0,'C',1);
	$pdf->Cell(90,5,'COURSE TITLE',1,0,'C',1);
	$pdf->Cell(40,5,'YEAR IMPLEMENTATION',1,0,'C',1);
	$pdf->Cell(25,5,'CATEGORY',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(5,35,90,40,25));
	$pdf->SetAligns(array('C','C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['title'],

		  $data['year_implementation'],

		  $data['category'],

		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+83,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+112,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function curriculum(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->Curriculums->getAllCurriculumPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Curriculum Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CODE',1,0,'C',1);
	$pdf->Cell(145,5,'DESCRIPTION',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,35,145));
	$pdf->SetAligns(array('C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['description'],

		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+83,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+112,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }  

  public function campus(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->Campus->query($this->Campus->getAllCampus($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Campus Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(40,5,'Campus Code',1,0,'C',1);
	$pdf->Cell(90,5,'Campus Name',1,0,'C',1);
	$pdf->Cell(85,5,'Short Name',1,0,'C',1);
	$pdf->Cell(85,5,'Address',1,0,'C',1);
	$pdf->Cell(30,5,'Active?',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,40,90,85,85,30));
	$pdf->SetAligns(array('C','C','L','L','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Campus'];

		if($tmp['active']){

		  $status  = 'True';

		}else{

		  $status  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  strtoupper($tmp['name']),

		  strtoupper($tmp['short_name']),

		  strtoupper($tmp['address']),

		  $status,

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function college(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->Colleges->getAllCollegePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'College Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'NO',1,0,'C',1);
	$pdf->Cell(30,5,'COLLEGE CODE',1,0,'C',1);
	$pdf->Cell(95,5,'COLLEGE NAME',1,0,'C',1);
	$pdf->Cell(30,5,'ACRONYM',1,0,'C',1);
	$pdf->Cell(30,5,'YEAR ESTABLISHED',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,30,95,30,30));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['name'],

		  $data['acronym'],

		  $data['year_established'],

		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+83,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+114,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function buildings(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['college_id'] = '';

	if(isset($this->request->query['college_id'])){

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Building.college_id = $college_id";

	}

	$tmpData = $this->Building->query($this->Building->getAllBuilding($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Building Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(100,5,'Building Code',1,0,'C',1);
	$pdf->Cell(230,5,'Building Name',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,100,230));
	$pdf->SetAligns(array('C','C','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Building'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  strtoupper($tmp['name'])

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function rooms(){
	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['college_id'] = '';

	if(isset($this->request->query['college_id'])){

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Building.college_id = $college_id";

	}

	$conditions['building_id'] = '';

	if(isset($this->request->query['building_id'])){

	  $building_id = $this->request->query['building_id'];

	  $conditions['building_id'] = "AND Room.building_id = $building_id";

	}

	$tmpData = $this->Room->query($this->Room->getAllRoom($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Room Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(100,5,'Room Code',1,0,'C',1);
	$pdf->Cell(230,5,'Room Name',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,100,230));
	$pdf->SetAligns(array('C','C','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Room'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  strtoupper($tmp['name'])

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function rooms_utilization(){
	
	// default page 1

	$page = isset($this->request->query['page'])? $this->request->query['page'] : 1;
	
	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['building_id'] = '';

	$building = '';

	if(isset($this->request->query['building_id'])){

	  $building_id = $this->request->query['building_id'];

	  $buildingData = $this->Building->findById($building_id);

	  $building = $buildingData['Building']['code'].' - '.$buildingData['Building']['name'];
	  
	  $conditions['building_id'] = "AND Room.building_id = $building_id";

	}

	$conditions['academic_term_id'] = '';

	if(isset($this->request->query['academic_term_id'])){

	  $academic_term_id = $this->request->query['academic_term_id'];

	  $conditions['academic_term_id'] = "AND CourseSchedule.academic_term_id = $academic_term_id";

	}

	$this->loadModel('ScheduleCourseRoomUtilization');

	$tmpData = $this->ScheduleCourseRoomUtilization->query($this->ScheduleCourseRoomUtilization->getAllUtilization($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Room Utilization',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(65,10,'ROOM',1,0,'C',1);
	$pdf->Cell(280,5,'UTITILIZATION (hrs/day)',1,0,'L',1);
	$pdf->Ln();
	$pdf->Cell(65,5,'',0,0,'C',);
	$pdf->Cell(35,5,'SUNDAY',1,0,'C',1);
	$pdf->Cell(35,5,'MONDAY',1,0,'C',1);
	$pdf->Cell(35,5,'TUESDAY',1,0,'C',1);
	$pdf->Cell(35,5,'WEDNESDAY',1,0,'C',1);
	$pdf->Cell(35,5,'THURSDAY',1,0,'C',1);
	$pdf->Cell(35,5,'FRIDAY',1,0,'C',1);
	$pdf->Cell(35,5,'SATURDAY',1,0,'C',1);
	$pdf->Cell(35,5,'TOTAL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(65,35,35,35,35,35,35,35,35));
	$pdf->SetAligns(array('L','C','C','C','C','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $datas){

		$tmp = $datas['Room'];

		$subData = explode(",",$datas['ClassSchedule']['subData']);

		$sunday = 0;

		$monday = 0;

		$tuesday = 0;

		$wednesday = 0;

		$thursday = 0;

		$friday = 0;

		$saturday = 0;

		$total = 0;

		if(!empty($subData)){

		  foreach ($subData as $k => $v) {

			$time = explode("$",$v);

			$startTime = @$time[0];

			$endTime = @$time[1];

			$day = @$time[2];

			$startHours = floatval(@$time[0]) / 100;

			$endHours = floatval(@$time[1]) / 100;
			
			$difference = $endHours - $startHours;

			if($startTime != '' && $startTime !== ''){

			  if ($startTime % 100 == 30 && $endTime % 100 == 0){
				
				$difference -= 0.5;
			  
			  }else if ($startTime % 100 == 0 && $endTime % 100 == 30){

				$difference += 0.5;

			  }

			  if($day == 1){

				$sunday += $difference;

			  } else if($day == 2){

				$monday += $difference;

			  } else if($day == 3){

				$tuesday += $difference;

			  } else if($day == 4){

				$wednesday += $difference;

			  } else if($day == 5){

				$thursday += $difference;

			  } else if($day == 6){

				$friday += $difference;

			  } else if($day == 7){

				$saturday += $difference;

			  }

			}

		  }

		  $total = (floatval($sunday) + floatval($monday) + floatval($tuesday) + floatval($wednesday) + floatval($thursday) + floatval($friday)  + floatval($saturday));

		}

		$pdf->RowLegalL(array(

		  $datas['Room']['code'].' - '.$datas['Room']['name'],

		  $sunday,

		  $monday,

		  $tuesday,

		  $wednesday,

		  $thursday,

		  $friday,

		  $saturday,

		  $total

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function department(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->Department->query($this->Department->getAllDepartment($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Department Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(40,5,'Department Code',1,0,'C',1);
	$pdf->Cell(135,5,'Department Name',1,0,'C',1);
	$pdf->Cell(125,5,'Short Name',1,0,'C',1);
	$pdf->Cell(30,5,'Active?',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,40,135,125,30));
	$pdf->SetAligns(array('C','C','L','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Department'];

		if($tmp['active']){

		  $status  = 'True';

		}else{

		  $status  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  strtoupper($tmp['name']),

		  strtoupper($tmp['short_name']),

		  $status,

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function college_department(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->CollegeDepartment->query($this->CollegeDepartment->getAllCollegeDepartment($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'College Department Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(150,5,'College Name',1,0,'C',1);
	$pdf->Cell(150,5,'Department Name',1,0,'C',1);
	$pdf->Cell(30,5,'Active?',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,150,150,30));
	$pdf->SetAligns(array('C','L','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['CollegeDepartment'];

		if($tmp['active']){

		  $status  = 'True';

		}else{

		  $status  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  strtoupper($tmp['college_name']),

		  strtoupper($tmp['department_name']),

		  $status,

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function collegePrograms(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['college_id'] = '';

	if($this->request->getQuery('college_id')){

	  $college_id = $this->request->getQuery('college_id');

	  $conditions['college_id'] = "AND College.id = $college_id";

	}

	$tmpData = $this->CollegePrograms->getAllCollegeProgramPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Program Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(45,5,'Code',1,0,'C',1);
	$pdf->Cell(150,5,'Program',1,0,'C',1);
	$pdf->Cell(40,5,'Program ID',1,0,'C',1);
	$pdf->Cell(40,5,'Acronym',1,0,'C',1);
	$pdf->Cell(40,5,'Capacity',1,0,'C',1);
	// $pdf->Cell(30,5,'Term',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,45,150,40,40,40,30));
	$pdf->SetAligns(array('C','L','L','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['name'],

		  $data['program_name'],

		  $data['acronym'],

		  $data['capacity'],

		  // strtoupper($tmp['term']),

		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+182,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function curriculums(){

	// default conditions

	$conditions = array();

	$conditionsPrint = '';

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['program_id'] = '';

	if(isset($this->request->query['program_id'])){

	  $program_id = $this->request->query['program_id'];

	  $conditions['program_id'] = "AND CollegeProgram.id = $program_id";

	}

	$this->loadModel('ScheduleCourseCurriculum');

	$tmpData = $this->ScheduleCourseCurriculum->query($this->ScheduleCourseCurriculum->getAllCurriculum($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Curriculum Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(165,5,'Curriculum Code',1,0,'C',1);
	$pdf->Cell(165,5,'Curriculum Description',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,165,165));
	$pdf->SetAligns(array('C','L','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Curriculum'];

		if($tmp['active']){

		  $status  = 'True';

		}else{

		  $status  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  strtoupper($tmp['code']),

		  strtoupper($tmp['description']),

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function faculty_class(){
	
	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['faculty_id'] = '';

	$faculty = '';

	if(isset($this->request->query['faculty_id'])){

	  $faculty_id = $this->request->query['faculty_id'];

	  $facultyData = $this->Employee->findById($faculty_id);

	  $faculty = (is_null($facultyData['Employee']['code']) ? '(No employee number)' : $facultyData['Employee']['code']).' - '.$facultyData['Employee']['proper_name1'];
	  
	  $conditions['faculty_id'] = "AND CourseSchedule.faculty_id = $faculty_id";

	}

	$conditions['academic_term_id'] = '';

	if(isset($this->request->query['academic_term_id'])){

	  $academic_term_id = $this->request->query['academic_term_id'];

	  $conditions['academic_term_id'] = "AND CourseSchedule.academic_term_id = $academic_term_id";

	}

	$this->loadModel('ScheduleCourseSchedule');

	$tmpData = $this->ScheduleCourseSchedule->query($this->ScheduleCourseSchedule->getAllCurriculum($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Faculty Schedule - '.$faculty,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(165,5,'Course',1,0,'C',1);
	$pdf->Cell(165,5,'Class Name',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,165,165));
	$pdf->SetAligns(array('C','L','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['CourseSchedule'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['Course']['code'].' - '.$data['Course']['title'],

		  strtoupper($data['CourseSchedule']['class_name']),

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function faculty_class_taught(){
	
	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['faculty_id'] = '';

	$faculty = '';

	if(isset($this->request->query['faculty_id'])){

	  $faculty_id = $this->request->query['faculty_id'];

	  $facultyData = $this->Employee->findById($faculty_id);

	  $faculty = (is_null($facultyData['Employee']['code']) ? '(No employee number)' : $facultyData['Employee']['code']).' - '.$facultyData['Employee']['proper_name1'];
	  
	  $conditions['faculty_id'] = "AND CourseSchedule.faculty_id = $faculty_id";

	}

	$conditions['academic_term_id'] = '';

	if(isset($this->request->query['academic_term_id'])){

	  $academic_term_id = $this->request->query['academic_term_id'];

	  $conditions['academic_term_id'] = "AND CourseSchedule.academic_term_id = $academic_term_id";

	}

	$this->loadModel('ScheduleCourseClass');

	$tmpData = $this->ScheduleCourseClass->query($this->ScheduleCourseClass->getAllCurriculum($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Faculty Class Taught - '.$faculty,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'No.',1,0,'C',1);
	$pdf->Cell(50,5,'Course',1,0,'C',1);
	$pdf->Cell(50,5,'Class Name',1,0,'C',1);
	$pdf->Cell(45,5,'Event',1,0,'C',1);
	$pdf->Cell(30,5,'Days',1,0,'C',1);
	$pdf->Cell(30,5,'Start Time',1,0,'C',1);
	$pdf->Cell(30,5,'End Time',1,0,'C',1);
	$pdf->Cell(60,5,'Building',1,0,'C',1);
	$pdf->Cell(40,5,'Room',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,50,50,45,30,30,30,60,40));
	$pdf->SetAligns(array('C','L','L','L','C','C','C','L','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$timestring1 = $data['ClassSchedule']['start_time'];

		$count1 = strlen($timestring1);

		if($count1 == 3){

		  $hour1 = '0'.substr($timestring1,0,1);

		  $minute1 = substr($timestring1,1,3);

		}else{

		  $hour1 = substr($timestring1,0,2);

		  $minute1 = substr($timestring1,2,4);

		}

		$timestring2 = $data['ClassSchedule']['end_time'];

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

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['Course']['code'].' - '.$data['Course']['title'],

		  strtoupper($data['CourseSchedule']['class_name']),

		  $data['ClassEvent']['class_event'],

		  $data[0]['day'],

		  $d1,

		  $d2,

		  $data['Building']['code'].' - '.$data['Building']['name'],

		  $data['Room']['code'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function by_room_classes(){
	
	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['room_id'] = '';

	$room = '';

	if(isset($this->request->query['room_id'])){

	  $room_id = $this->request->query['room_id'];

	  $roomData = $this->Room->findById($room_id);

	  $room = $roomData['Room']['code'];
	  
	  $conditions['room_id'] = "AND Room.id = $room_id";

	}

	$conditions['academic_term_id'] = '';

	if(isset($this->request->query['academic_term_id'])){

	  $academic_term_id = $this->request->query['academic_term_id'];

	  $conditions['academic_term_id'] = "AND CourseSchedule.academic_term_id = $academic_term_id";

	}

	$this->loadModel('ScheduleCourseRoomSchedule');

	$tmpData = $this->ScheduleCourseRoomSchedule->query($this->ScheduleCourseRoomSchedule->getAllCurriculum($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Classes - '.$room,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'No.',1,0,'C',1);
	$pdf->Cell(70,5,'Course',1,0,'C',1);
	$pdf->Cell(50,5,'Event',1,0,'C',1);
	$pdf->Cell(50,5,'Days',1,0,'C',1);
	$pdf->Cell(35,5,'Start Time',1,0,'C',1);
	$pdf->Cell(35,5,'End Time',1,0,'C',1);
	$pdf->Cell(95,5,'Instructor',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,70,50,50,35,35,95));
	$pdf->SetAligns(array('C','L','L','C','C','C','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$timestring1 = $data['ClassSchedule']['start_time'];

		$count1 = strlen($timestring1);

		if($count1 == 3){

		  $hour1 = '0'.substr($timestring1,0,1);

		  $minute1 = substr($timestring1,1,3);

		}else{

		  $hour1 = substr($timestring1,0,2);

		  $minute1 = substr($timestring1,2,4);

		}

		$timestring2 = $data['ClassSchedule']['end_time'];

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

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['Course']['code'].' - '.$data['Course']['title'],

		  $data['ClassEvent']['class_event'],

		  $data[0]['day'],

		  $d1,

		  $d2,

		  $data[0]['full_name'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function college_blocks(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['term_id'] = '';

	if (isset($this->request->query['term_id'])) {

	  $term_id = $this->request->query['term_id'];

	  $conditions['term_id'] = "AND CollegeBlock.term_id = $term_id";

	}

	$conditions['college_id'] = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND CollegeBlock.college_id = $college_id";

	}

	$conditions['department_id'] = '';

	if (isset($this->request->query['department_id'])) {

	  $department_id = $this->request->query['department_id'];

	  $conditions['department_id'] = "AND CollegeBlock.term_id = $department_id";

	}

	$conditions['program_id'] = '';

	if (isset($this->request->query['program_id'])) {

	  $program_id = $this->request->query['program_id'];

	  $conditions['program_id'] = "AND CollegeBlock.program_id = $program_id";

	}

	$tmpData = $this->CollegeBlock->query($this->CollegeBlock->getAllCollegeBlock($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'College Block Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(55,5,'Code',1,0,'C',1);
	$pdf->Cell(95,5,'Year Level',1,0,'C',1);
	$pdf->Cell(95,5,'Block Type',1,0,'C',1);
	$pdf->Cell(85,5,'Term',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,55,95,95,85));
	$pdf->SetAligns(array('C','C','L','L','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['CollegeBlock'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  $tmp['year_level'],

		  $tmp['type'],

		  $tmp['term'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function chart_of_accounts(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->ChartOfAccount->query($this->ChartOfAccount->getAllChartOfAccount($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Chart of Account Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(30,5,'Code',1,0,'C',1);
	$pdf->Cell(55,5,'Account Name',1,0,'C',1);
	$pdf->Cell(50,5,'Short Name',1,0,'C',1);
	$pdf->Cell(30,5,'Fixed Amount ?',1,0,'C',1);
	$pdf->Cell(45,5,'Account Group',1,0,'C',1);
	$pdf->Cell(45,5,'Account Classification',1,0,'C',1);
	$pdf->Cell(45,5,'Account Set',1,0,'C',1);
	$pdf->Cell(30,5,'Active ?',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,30,55,50,30,45,45,45,30));
	$pdf->SetAligns(array('C','C','L','L','C','L','L','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['ChartOfAccount'];

		if($tmp['fixed_amount']){

		  $fixed_amount  = 'True';

		}else{

		  $fixed_amount  = 'False';

		}

		if($tmp['active']){

		  $active  = 'True';

		}else{

		  $active  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  $tmp['name'],

		  $tmp['short_name'],

		  $fixed_amount,

		  $tmp['group_name'],

		  $tmp['classification_name'],

		  $tmp['account_set'],

		  $active,

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function table_of_fees(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->TableOfFee->query($this->TableOfFee->getAllTableOfFee($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Table of Fees',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(40,5,'Code',1,0,'C',1);
	$pdf->Cell(55,5,'Description',1,0,'C',1);
	$pdf->Cell(50,5,'Year Level',1,0,'C',1);
	$pdf->Cell(40,5,'Academic Term',1,0,'C',1);
	$pdf->Cell(55,5,'Remarks',1,0,'C',1);
	$pdf->Cell(60,5,'Department Program',1,0,'C',1);
	$pdf->Cell(30,5,'Active ?',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,40,55,50,40,55,60,30));
	$pdf->SetAligns(array('C','C','L','C','L','L','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['TableOfFee'];

		if($tmp['active']){

		  $active  = 'True';

		}else{

		  $active  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  $tmp['description'],

		  $tmp['year_level'],

		  $data['AcademicTerm']['academic_term'],

		  $tmp['remarks'],

		  $data['CollegeDepartmentProgram']['department_program'],

		  $active,

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function table_of_fees_view($id = null){

	$data = $this->TableOfFee->find('first', array(

	  'contain' => array(
		
		'TableOfFeeItem' => array(

		  'conditions' => array(

			'TableOfFeeItem.visible' => true

		  ),

		),
		
		'AcademicTerm' => array(

		  'conditions' => array(

			'AcademicTerm.visible' => true

		  ),

		),
		
		'CollegeDepartmentProgram' => array(

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

		  'conditions' => array(

			'CollegeDepartmentProgram.visible' => true

		  ),

		),

	  ),

	  'conditions' => array(

		'TableOfFee.visible' => true ,

		'TableOfFee.id'      => $id,

	  )

	));

	$data['TableOfFee']['active_view'] = $data['TableOfFee']['active'] ? 'True' : 'False';

	$data['TableOfFee']['academic_term'] = $data['AcademicTerm']['school_year'].' - '.$data['AcademicTerm']['semester'];

	$data['TableOfFee']['department_program'] = @$data['CollegeDepartmentProgram']['CollegeDepartment']['College']['code'].'::'.@$data['CollegeDepartmentProgram']['CollegeDepartment']['Department']['short_name'].'::'.@$data['CollegeDepartmentProgram']['CollegeProgram']['name'];

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->AddPage("P", "A4", 0);
	$pdf->SetFont("Arial", 'B',12);
	$pdf->Cell(0,5,'Selected Template : '.$data['TableOfFee']['code'],0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont("Arial", 'B',9);
	$pdf->Cell(0,5,'Description : '.$data['TableOfFee']['description'],0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont("Arial", 'B',9);
	$pdf->Cell(0,5,'College : '.@$data['CollegeDepartmentProgram']['CollegeDepartment']['College']['code'],0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont("Arial", 'B',9);
	$pdf->Cell(0,5,'Program : '.@$data['CollegeDepartmentProgram']['CollegeProgram']['code'],0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont("Arial", 'B',9);
	$pdf->Cell(0,5,'Year Level : '.$data['TableOfFee']['year_level'],0,0,'L');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", '',8);
	$pdf->Cell(0,5,count($data['TableOfFeeItem']).' record(s) found.',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont("Arial", 'B',8);
	$pdf->Cell(100,5,'Account',0,0,'C');
	$pdf->Cell(20,5,'Amount',0,0,'C');
	$pdf->Ln(5);

	if(!empty($data['TableOfFeeItem'])){

	  foreach ($data['TableOfFeeItem'] as $key => $value) {

		$pdf->SetFont("Arial", '',8);
		$pdf->CellFitScale(100,5,$value['code'],0,0,'L');
		$pdf->CellFitScale(20,5,fnumber($value['amount'],2),0,0,'R');
		$pdf->Ln(5);

	  }

	}
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'B',9);
	$pdf->Cell(0,5,'Total : Php '.fnumber($data['TableOfFee']['total'],2),0,0,'L');
	$pdf->Ln(10);

	$pdf->Ln(5);
	$pdf->output();
	exit();

  }

  public function curriculum_requisites($id = null){

	$data = $this->Curriculum->find('first', array(

	  'contain' => array(

		'CurriculumCourse' => array(

		  'CurriculumCoursePrerequisite' => array(

			'Course' => array(

			  'conditions' => array(

				'Course.visible' => true

			  ),

			),

			'conditions' => array(

			  'CurriculumCoursePrerequisite.visible' => true,

			  'CurriculumCoursePrerequisite.active' => true,

			),

		  ),

		  'CurriculumCourseCorequisite' => array(

			'Course' => array(

			  'conditions' => array(

				'Course.visible' => true

			  ),

			),

			'conditions' => array(

			  'CurriculumCourseCorequisite.visible' => true,

			  'CurriculumCourseCorequisite.active' => true,

			),

		  ),

		  'CurriculumCourseEquivalency' => array(

			'Course' => array(

			  'conditions' => array(

				'Course.visible' => true

			  ),

			),

			'conditions' => array(

			  'CurriculumCourseEquivalency.visible' => true,

			  'CurriculumCourseEquivalency.active' => true,

			),

		  ),

		  'Course' => array(

			'conditions' => array(

			  'Course.visible' => true

			),

		  ),

		  'conditions' => array(

			'CurriculumCourse.active' => true,

			'CurriculumCourse.visible' => true

		  ),

		),

	  ),
	  
	  'conditions' => array(

		'Curriculum.visible' => true ,

		'Curriculum.id'      => $id,

	  )

	));

	$data['Curriculum']['active_view'] = $data['Curriculum']['active'] ? 'True' : 'False';

	$data['Curriculum']['locked_view'] = $data['Curriculum']['locked'] ? 'True' : 'False';

	$data['Curriculum']['curriculum_view'] = $data['Curriculum']['code'].' - '.$data['Curriculum']['description'];

	$year_term = $this->YearLevelTerm->find('all', array(

	  'conditions' => array(
		  
		'YearLevelTerm.visible' => true,

		'YearLevelTerm.educational_level' => $data['Curriculum']['educational_level']

	  ),

	  'order' => array(

		'CAST(YearLevelTerm.chronological_order AS DECIMAL)' => 'ASC',

	  )

	));
	
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(0,5,$data['Curriculum']['description'],0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(40,10,'SUBJECT CODE',0,0,'C');
	$pdf->Cell(80,10,'DESCRIPTIVE TITLE',0,0,'C');
	$pdf->Cell(30,5,'HOUR',0,0,'C');
	$pdf->Cell(45,5,'UNIT',0,0,'C');
	$pdf->Cell(50,10,'PRE-REQUISITE',0,0,'C');
	$pdf->Cell(50,10,'CO-REQUISITE',0,0,'C');
	$pdf->Cell(50,10,'EQUIVALENCY',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(40,5,'',0,0,'C');
	$pdf->Cell(80,5,'',0,0,'C');
	$pdf->Cell(15,5,'LAB',0,0,'C');
	$pdf->Cell(15,5,'LEC',0,0,'C');
	$pdf->Cell(15,5,'LAB',0,0,'C');
	$pdf->Cell(15,5,'LEC',0,0,'C');
	$pdf->Cell(15,5,'CREDIT',0,0,'C');
	$pdf->Ln(5);

	if(!empty($year_term)){

	  foreach ($year_term as $key => $value) {

		$pdf->SetFont("Times", 'BU', 10);
		$pdf->Cell(0,5,$value['YearLevelTerm']['description'],0,0,'L');
		$pdf->Ln(5);

		if(!empty($data['CurriculumCourse'])){

		  foreach ($data['CurriculumCourse'] as $keys => $values) {

			if($value['YearLevelTerm']['id'] == $values['year_term_id']){

			  $pdf->SetFont("Times", '', 10);
			  $pdf->CellFitScale(40,5,$values['Course']['code'],0,0,'L');
			  $pdf->CellFitScale(80,5,$values['Course']['title'],0,0,'L');
			  $pdf->CellFitScale(15,5,$values['Course']['laboratory_hours'] > 0 ? fnumber($values['Course']['laboratory_hours'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(15,5,$values['Course']['lecture_hours'] > 0 ? fnumber($values['Course']['lecture_hours'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(15,5,$values['Course']['laboratory_unit'] > 0 ? fnumber($values['Course']['laboratory_unit'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(15,5,$values['Course']['lecture_unit'] > 0 ? fnumber($values['Course']['lecture_unit'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(15,5,$values['Course']['credit_unit'] > 0 ? fnumber($values['Course']['credit_unit'],2) : '0.00',0,0,'C');

			  $prerequisite = ' ';

			  if(!empty($values['CurriculumCoursePrerequisite'])){

				foreach ($values['CurriculumCoursePrerequisite'] as $k => $pre) {
				  
				  $prerequisite .= $pre['Course']['code'] . ',';

				}

				$prerequisite = trim($prerequisite, ',');

			  }

			  $pdf->CellFitScale(50,5,$prerequisite,0,0,'C');

			  $corerequisite = ' ';

			  if(!empty($values['CurriculumCourseCorequisite'])){

				foreach ($values['CurriculumCourseCorequisite'] as $k => $pre) {
				  
				  $corerequisite .= $pre['Course']['code'] . ',';

				}

				$corerequisite = trim($corerequisite, ',');
				
			  }

			  $pdf->CellFitScale(50,5,$corerequisite,0,0,'C');

			  $equivalency = ' ';

			  if(!empty($values['CurriculumCourseEquivalency'])){

				foreach ($values['CurriculumCourseEquivalency'] as $k => $pre) {
				  
				  $equivalency .= $pre['Course']['code'] . ',';

				}

				$equivalency = trim($equivalency, ',');
				
			  }

			  $pdf->CellFitScale(50,5,$equivalency,0,0,'C');
			  $pdf->Ln(5);

			}

		  }

		}

	  }

	}

	$pdf->Ln(5);
	$pdf->output();
	exit();

  }

  public function curriculum_fees($id = null){

	$data = $this->Curriculum->find('first', array(

	  'contain' => array(

		'CurriculumCourse' => array(

		  'CurriculumCoursePrerequisite' => array(

			'Course' => array(

			  'conditions' => array(

				'Course.visible' => true

			  ),

			),

			'conditions' => array(

			  'CurriculumCoursePrerequisite.visible' => true,

			  'CurriculumCoursePrerequisite.active' => true,

			),

		  ),

		  'CurriculumCourseCorequisite' => array(

			'Course' => array(

			  'conditions' => array(

				'Course.visible' => true

			  ),

			),

			'conditions' => array(

			  'CurriculumCourseCorequisite.visible' => true,

			  'CurriculumCourseCorequisite.active' => true,

			),

		  ),

		  'CurriculumCourseEquivalency' => array(

			'Course' => array(

			  'conditions' => array(

				'Course.visible' => true

			  ),

			),

			'conditions' => array(

			  'CurriculumCourseEquivalency.visible' => true,

			  'CurriculumCourseEquivalency.active' => true,

			),

		  ),

		  'CurriculumCourseFee' => array(

			'AccountFee' => array(

			  'ChartOfAccount' => array(

				'conditions' => array(

				  'ChartOfAccount.visible' => true

				),

			  ),

			  'conditions' => array(

				'AccountFee.visible' => true

			  ),

			),

			'conditions' => array(

			  'CurriculumCourseFee.visible' => true,

			  'CurriculumCourseFee.active' => true,

			),

		  ),

		  'Course' => array(

			'conditions' => array(

			  'Course.visible' => true

			),

		  ),

		  'conditions' => array(

			'CurriculumCourse.active' => true,

			'CurriculumCourse.visible' => true

		  ),

		),

	  ),
	  
	  'conditions' => array(

		'Curriculum.visible' => true ,

		'Curriculum.id'      => $id,

	  )

	));

	$data['Curriculum']['active_view'] = $data['Curriculum']['active'] ? 'True' : 'False';

	$data['Curriculum']['locked_view'] = $data['Curriculum']['locked'] ? 'True' : 'False';

	$data['Curriculum']['curriculum_view'] = $data['Curriculum']['code'].' - '.$data['Curriculum']['description'];

	$year_term = $this->YearLevelTerm->find('all', array(

	  'conditions' => array(
		  
		'YearLevelTerm.visible' => true,

		'YearLevelTerm.educational_level' => $data['Curriculum']['educational_level']

	  ),

	  'order' => array(

		'CAST(YearLevelTerm.chronological_order AS DECIMAL)' => 'ASC',

	  )

	));
	
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(0,5,$data['Curriculum']['description'],0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(40,10,'SUBJECT CODE',0,0,'C');
	$pdf->Cell(80,10,'DESCRIPTIVE TITLE',0,0,'C');
	$pdf->Cell(30,5,'HOUR',0,0,'C');
	$pdf->Cell(45,5,'UNIT',0,0,'C');
	$pdf->Cell(150,10,'SPECIAL FEE',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(40,5,'',0,0,'C');
	$pdf->Cell(80,5,'',0,0,'C');
	$pdf->Cell(15,5,'LAB',0,0,'C');
	$pdf->Cell(15,5,'LEC',0,0,'C');
	$pdf->Cell(15,5,'LAB',0,0,'C');
	$pdf->Cell(15,5,'LEC',0,0,'C');
	$pdf->Cell(15,5,'CREDIT',0,0,'C');
	$pdf->Ln(5);

	if(!empty($year_term)){

	  foreach ($year_term as $key => $value) {

		$pdf->SetFont("Times", 'BU', 10);
		$pdf->Cell(0,5,$value['YearLevelTerm']['description'],0,0,'L');
		$pdf->Ln(5);

		if(!empty($data['CurriculumCourse'])){

		  foreach ($data['CurriculumCourse'] as $keys => $values) {

			if($value['YearLevelTerm']['id'] == $values['year_term_id']){

			  $pdf->SetFont("Times", '', 10);
			  $pdf->CellFitScale(40,5,$values['Course']['code'],0,0,'L');
			  $pdf->CellFitScale(80,5,$values['Course']['title'],0,0,'L');
			  $pdf->CellFitScale(15,5,$values['Course']['laboratory_hours'] > 0 ? fnumber($values['Course']['laboratory_hours'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(15,5,$values['Course']['lecture_hours'] > 0 ? fnumber($values['Course']['lecture_hours'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(15,5,$values['Course']['laboratory_unit'] > 0 ? fnumber($values['Course']['laboratory_unit'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(15,5,$values['Course']['lecture_unit'] > 0 ? fnumber($values['Course']['lecture_unit'],2) : '0.00',0,0,'C');
			  $pdf->CellFitScale(20,5,$values['Course']['credit_unit'] > 0 ? fnumber($values['Course']['credit_unit'],2) : '0.00',0,0,'C');

			  $fee = ' ';

			  if(!empty($values['CurriculumCourseFee'])){

				foreach ($values['CurriculumCourseFee'] as $k => $pre) {
				  
				  $fee .= $pre['AccountFee']['ChartOfAccount']['code'].' : '.$pre['AccountFee']['ChartOfAccount']['name'].' ('.fnumber($pre['amount'],2).'), ';

				}

				$fee = trim($fee, ',');
				
			  }
			  $pdf->MultiCell(145,4,$fee,0,1);

			}

		  }

		}

	  }

	}

	$pdf->Ln(5);
	$pdf->output();
	exit();

  }

  public function program_major(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->ProgramMajor->query($this->ProgramMajor->getAllProgramMajor($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Program Major Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(80,5,'Program',1,0,'C',1);
	$pdf->Cell(50,5,'Code',1,0,'C',1);
	$pdf->Cell(50,5,'Short Name',1,0,'C',1);
	$pdf->Cell(60,5,'Discipline',1,0,'C',1);
	$pdf->Cell(60,5,'Description',1,0,'C',1);
	$pdf->Cell(30,5,'Active?',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,80,50,50,60,60,30));
	$pdf->SetAligns(array('C','L','C','C','L','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['ProgramMajor'];

		if($tmp['active']){

		  $status  = 'True';

		}else{

		  $status  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['name'],

		  $tmp['code'],

		  $tmp['short_name'],

		  $tmp['discipline'],

		  $tmp['description'],

		  $status,

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function faculty(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')!=null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['college_id'] = '';

	if($this->request->getQuery('college_id')!=null){

	  $college_id = $this->request->getQuery('college_id');

	  $conditions['college_id'] = "AND Employee.college_id = $college_id";

	}

	$conditions['specialization_id'] = '';

	if($this->request->getQuery('specialization_id')!=null){

	  $specialization_id = $this->request->getQuery('specialization_id');

	  $conditions['specialization_id'] = " AND Employee.specialization_id = $specialization_id ";

	}

	$tmpData = $this->Employees->getAllEmployeePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Faculty Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(40,5,'Employee No.',1,0,'C',1);
	$pdf->Cell(40,5,'Family Name',1,0,'C',1);
	$pdf->Cell(40,5,'Given Name',1,0,'C',1);
	$pdf->Cell(30,5,'Middle Name',1,0,'C',1);
	$pdf->Cell(30,5,'Gender',1,0,'C',1);
	$pdf->Cell(40,5,'Academic Rank',1,0,'C',1);
	$pdf->Cell(78,5,'College',1,0,'C',1);
	$pdf->Cell(30,5,'Active?',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,40,40,40,30,30,40,78,30,30));
	$pdf->SetAligns(array('C','C','L','L','L','C','L','L','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		if($data['active']){

		  $status  = 'True';

		}else{

		  $status  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['family_name'],

		  $data['given_name'],

		  $data['middle_name'],

		  $data['gender'],

		  $data['academic_rank'],

		  $data['college'],

		  $status,

		));

	  }

	}else{

	  $pdf->Cell(343,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+343,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function print_faculty_accounts(){

	$conditions['college_id'] = '';

	if(isset($this->request->query['college_id'])){

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Employee.college_id = $college_id";

	}

	$tmpData = $this->Employee->query($this->Employee->getAllFaculty($conditions));

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'FACULTY CENTER ACCOUNTS',0,0,'C');
	$pdf->Ln(8);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(125,5,'ACCOUNT DETAILS',1,0,'L');
	$pdf->Cell(20,5,'NO.',1,0,'L');
	$pdf->Cell(70,5,'LAST NAME',1,0,'L');
	$pdf->Cell(70,5,'FIRST NAME',1,0,'L');
	$pdf->Cell(60,5,'SIGNATURE',1,0,'L');
	$pdf->Ln(5);

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $value) {

		$y = $pdf->getY();

		$pdf->SetFont("Arial", 'B', 10);
		$pdf->Cell(125,5,'ORS GRADE ENCODING',1,0,'C');
		$pdf->Ln(5);
		$pdf->SetFont("Arial", '', 10);
		$pdf->Cell(50,5,'Username : ',1,0,'L');
		$pdf->Cell(75,5,$value['Employee']['email'],1,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont("Arial", '', 10);
		$pdf->Cell(50,5,'Password : ',1,0,'L');
		$pdf->Cell(75,5,$value['Employee']['password_tmp'],1,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont("Arial", '', 10);
		$pdf->Cell(50,5,'Grade Encoding Link : ',1,0,'L');
		$pdf->SetFont("Arial", 'B', 10);
		$pdf->Cell(75,5,'fc.bicol-u.edu.ph',1,0,'L');
		$pdf->setXY(130,$y);
		$pdf->SetFont("Arial", '', 10);
		$pdf->Cell(20,20,($key + 1),1,0,'L');
		$pdf->Cell(70,20,utf8_decode(properCase($value['Employee']['family_name'])),1,0,'L');
		$pdf->Cell(70,20,utf8_decode(properCase($value['Employee']['given_name'])),1,0,'L');
		$pdf->Cell(60,20,'',1,0,'L');
		$pdf->Ln(20);

	  }
	}

	$pdf->output();
	exit();
 
  }

  public function student_admission(){

	$conditions = array();

	$header = '';

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $conditions['search'] = strtolower($search);

	  $header .= ' SEARCH : '.$search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(StudentApplicant.date) = '$search_date'"; 

	  $header .= ' DATE : '.fdate($search_date,'F d, Y');

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(StudentApplicant.date) >= '$start' AND DATE(StudentApplicant.date) <= '$end'";

	  $header .= ' RANGE : '.fdate($start,'F d, Y').' - '.fdate($end,'F d, Y');

	}

	$conditions['college_id'] = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND StudentApplicant.college_id = $college_id";

	  $collegeData = $this->College->findById($college_id);

	  $header .= ' COLLEGE : '.$collegeData['College']['name'];

	}

	$conditions['degree_id'] = '';

	if (isset($this->request->query['degree_id'])) {

	  $degree_id = $this->request->query['degree_id'];

	  $conditions['degree_id'] = "AND StudentApplicant.degree_id = $degree_id";

	  $degreeData = $this->Degree->findById($degree_id);

	  $header .= ' DEGREE : '.$degreeData['Degree']['name'];

	}

	$tmpData = $this->StudentApplicant->query($this->StudentApplicant->getAllStudentApplicant($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Student Admission Management',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'I', 10);
	$pdf->Cell(0,5,$header,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(45,5,'Application No.',1,0,'C',1);
	$pdf->Cell(70,5,'Last Name',1,0,'C',1);
	$pdf->Cell(70,5,'First Name',1,0,'C',1);
	$pdf->Cell(70,5,'Middle Name',1,0,'C',1);
	$pdf->Cell(75,5,'College',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,45,70,70,70,75));
	$pdf->SetAligns(array('C','C','L','L','L','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['StudentApplicant'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['code'],

		  $tmp['last_name'],

		  $tmp['first_name'],

		  $tmp['middle_name'],

		  $tmp['c_name']

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function import_student(){

	$datas = array();
	
	$this->set(compact('datas'));

  }

  public function students(){

	$conditions = array();

	$header = '';

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $conditions['search'] = strtolower($search);

	  $header .= ' SEARCH : '.$search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(Student.created) = '$search_date'"; 

	  $header .= ' DATE : '.fdate($search_date,'F d, Y');

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(Student.created) >= '$start' AND DATE(Student.created) <= '$end'";

	  $header .= ' RANGE : '.fdate($start,'F d, Y').' - '.fdate($end,'F d, Y');

	}

	$conditions['college_id'] = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Student.college_id = $college_id";

	  $collegeData = $this->College->findById($college_id);

	  $header .= ' COLLEGE : '.$collegeData['College']['name'];

	}

	$conditions['degree_id'] = '';

	if (isset($this->request->query['degree_id'])) {

	  $degree_id = $this->request->query['degree_id'];

	  $conditions['degree_id'] = "AND Student.degree_id = $degree_id";

	  $degreeData = $this->Degree->findById($degree_id);

	  $header .= ' DEGREE : '.$degreeData['Degree']['name'];

	}

	$tmpData = $this->Student->query($this->Student->getAllStudent($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Student Details Management',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'I', 10);
	$pdf->Cell(0,5,$header,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(25,5,'Student No.',1,0,'C',1);
	$pdf->Cell(25,5,'Last Name',1,0,'C',1);
	$pdf->Cell(30,5,'First Name',1,0,'C',1);
	$pdf->Cell(25,5,'Middle Name',1,0,'C',1);
	$pdf->Cell(35,5,'College',1,0,'C',1);
	$pdf->Cell(35,5,'Program',1,0,'C',1);
	$pdf->Cell(35,5,'Department',1,0,'C',1);
	$pdf->Cell(30,5,'Year Level',1,0,'C',1);
	$pdf->Cell(30,5,'# of Registration',1,0,'C',1);
	$pdf->Cell(30,5,'Regular',1,0,'C',1);
	$pdf->Cell(30,5,'Active',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,25,25,30,25,35,35,35,30,30,30,30));
	$pdf->SetAligns(array('C','C','L','L','L','L','L','L','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Student'];

		if($tmp['regular_yes']){

		  $regular  = 'True';

		}else{

		  $regular  = 'False';

		}

		if($tmp['active']){

		  $active  = 'True';

		}else{

		  $active  = 'False';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['student_no'],

		  $tmp['last_name'],

		  $tmp['first_name'],

		  $tmp['middle_name'],

		  $tmp['c_name'],

		  $tmp['program_name'],

		  $tmp['department_name'],

		  $tmp['year_level'],

		  $tmp['no_registration'],

		  $regular,

		  $active

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function view_by_students(){

	$conditions = array();

	$header = '';

	$conditions['search'] = '';

	$conditions['view_by_student'] = true;

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $conditions['search'] = strtolower($search);

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(Student.created) = '$search_date'"; 

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(Student.created) >= '$start' AND DATE(Student.created) <= '$end'";

	}

	$conditions['college_id'] = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Student.college_id = $college_id";

	  $collegeData = $this->College->findById($college_id);

	}

	$conditions['degree_id'] = '';

	if (isset($this->request->query['degree_id'])) {

	  $degree_id = $this->request->query['degree_id'];

	  $conditions['degree_id'] = "AND Student.degree_id = $degree_id";

	  $degreeData = $this->Degree->findById($degree_id);

	}

	$tmpData = $this->Student->query($this->Student->getAllStudent($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Student Management',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'I', 10);
	$pdf->Cell(0,5,$header,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(55,5,'Student No.',1,0,'C',1);
	$pdf->Cell(275,5,"Student's Name",1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,55,275));
	$pdf->SetAligns(array('C','C','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Student'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['student_no'],

		  $data['Student']['full_name'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function qce_student(){

	$conditions = array();

	$header = '';

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $conditions['search'] = strtolower($search);

	}

	$this->loadModel('QceAdminStudent');
	
	$tmpData = $this->QceAdminStudent->query($this->QceAdminStudent->getAllStudent($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Faculty Evaluation Admin',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'I', 10);
	$pdf->Cell(0,5,$header,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(55,5,'Student No.',1,0,'C',1);
	$pdf->Cell(275,5,"Student's Name",1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,55,275));
	$pdf->SetAligns(array('C','C','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Student'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['student_no'],

		  $data['Student']['full_name'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function grades($id = null){

	$student_id = $id;
	
	$data = $this->Student->find('first', array(

	  'contain' => array(
		
		'Curriculum' => array(

		  'conditions' => array(

			'Curriculum.visible' => true

		  ),

		),
		
		'SubjectList' => array(
		
		  'AcademicTerm' => array(

			'conditions' => array(

			  'AcademicTerm.visible' => true

			),

		  ),
		
		  'CourseSchedule' => array(
		
			'Course' => array(

			  'conditions' => array(

				'Course.visible' => true

			  ),

			),

			'conditions' => array(

			  'CourseSchedule.visible' => true

			),

		  ),

		  'conditions' => array(

			'SubjectList.visible' => true

		  ),

		),
		
		'StudentProfile' => array(

		  'conditions' => array(

			'StudentProfile.visible' => true

		  ),

		),
		
		'College' => array(
		
		  'Campus' => array(

			'conditions' => array(

			  'Campus.visible' => true

			),

		  ),

		  'conditions' => array(

			'College.visible' => true

		  ),

		),
		
		'CollegeProgram' => array(

		  'conditions' => array(

			'CollegeProgram.visible' => true

		  ),

		),
		
		'StudentMonthlyFamilyIncome' => array(

		  'conditions' => array(

			'StudentMonthlyFamilyIncome.visible' => true

		  ),

		),
		
		'Degree' => array(

		  'conditions' => array(

			'StudentMonthlyFamilyIncome.visible' => true

		  ),

		),
		
		'PreregistrationSubject' => array(
		
		  'Course' => array(

			'conditions' => array(

			  'Course.visible' => true

			),

		  ),
		
		  'CourseSchedule' => array(

			'conditions' => array(

			  'CourseSchedule.visible' => true,

			  'CourseSchedule.active' => true

			),

		  ),

		  'conditions' => array(

			'PreregistrationSubject.visible' => true

		  ),

		),

	  ),

	  'conditions' => array(

		'Student.visible' => true,

		'Student.id'      => $id,

	  )

	));

	$newlist = array();

	if(!empty($data['SubjectList'])){

	  $prev = "";

	  $curr = "";

	  $counter = -1;

	  foreach ($data['SubjectList'] as $key => $value) {

		$prev = $curr;

		$curr = $value['academic_term_id'];

		$all_semesters = $this->AcademicTerm->find('all',array(
			
		  'conditions' => array(

			'AcademicTerm.visible' => true

		  ),

		));  

		$sem = array();

		if(!empty($all_semesters)){

		  foreach ($all_semesters as $k => $v) {

			$schedules = $this->SubjectList->query("

			  SELECT 

				SubjectList.id,

				CourseSchedule.course_id

			  FROM

				subject_lists as SubjectList LEFT JOIN

				course_schedules as CourseSchedule ON CourseSchedule.id =  SubjectList.course_schedule_id LEFT JOIN

				class_schedules as ClassSchedule ON ClassSchedule.course_schedule_id =  CourseSchedule.id

			  WHERE

				SubjectList.visible = true AND

				CourseSchedule.visible = true AND

				ClassSchedule.visible = true AND

				CourseSchedule.active = true AND

				ClassSchedule.active = true AND

				SubjectList.student_id = $student_id AND

				SubjectList.academic_term_id = $curr

			");

			if(!empty($schedules)){

			  foreach ($schedules as $s => $sched) {

				$academic_term_id = $v['AcademicTerm']['id'];

				$course_id = $sched['CourseSchedule']['course_id'];

				$qe = $this->QuestionnaireEvaluated->query("

				  SELECT 

					QuestionnaireEvaluated.id

				  FROM

					questionnaire_evaluateds as QuestionnaireEvaluated LEFT JOIN

					class_schedules as ClassSchedule ON ClassSchedule.faculty_id =  QuestionnaireEvaluated.faculty_id

				  WHERE

					QuestionnaireEvaluated.visible = true AND

					ClassSchedule.visible = true AND

					QuestionnaireEvaluated.academic_term_id = $academic_term_id AND

					QuestionnaireEvaluated.course_id = $course_id AND

					QuestionnaireEvaluated.student_id = $student_id

				");

				if(empty($qe)){

				  $sem[] = $v;

				}

			  }

			}

		  }

		}

		$x = false;

		if(!empty($sem)){

		  foreach ($sem as $i => $sems) {

			if($value['academic_term_id'] == $sems['AcademicTerm']['id']){

			  $x = true;

			}

		  }

		}

		if($x){

		  if($value['remarks'] == 'INCOMPLETE'){

			$course_id = $value['CourseSchedule']['course_id'];

			$evaluation = $this->Evaluation->query("

			  SELECT 

				Evaluation.id,

				Evaluation.grade

			  FROM

				evaluations as Evaluation 

			  WHERE 

				Evaluation.visible = true AND

				Evaluation.student_id = $student_id AND

				Evaluation.course_id = $course_id AND

				(

				  Evaluation.remarks = 'IPASS' OR

				  Evaluation.remarks = 'PASS' OR

				  Evaluation.remarks = 'PASSED' OR

				  Evaluation.remarks = 'FAIL'

				)

			"); 

			if(!empty($evaluation)){

			  $grade = $evaluation[0]['Evaluation']['grade'];

			}else{

			  $grade = $value['final_grade'];

			}

		  }else{

			$grade = $value['final_grade'];

		  }

		}else{

		  $grade = 'Please evaluate all subjects in this semester '.$value['AcademicTerm']['school_year'].' '.$value['AcademicTerm']['semester'];

		}

		if ($prev != $curr){

		  $counter ++;

		  $newlist[$counter] = array(

			'school_year' => $value['AcademicTerm']['school_year'],

			'semester'    => $value['AcademicTerm']['semester']

		  );

		  $newlist[$counter]['Sub'][] = array(

			'code'  => $value['CourseSchedule']['Course']['code'],

			'title' => $value['CourseSchedule']['Course']['title'],

			'grade' => $grade,

		  );

		}else{

		  $newlist[$counter]['Sub'][] = array(

			'code'  => $value['CourseSchedule']['Course']['code'],

			'title' => $value['CourseSchedule']['Course']['title'],

			'grade' => $grade,

		  );

		}
	  
	  }

	}

	$data['SubjectList'] = $newlist;

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ACADEMIC GRADES',0,0,'C');
	$pdf->Ln(10);

	if(!empty($data['SubjectList'])){

	  foreach ($data['SubjectList'] as $key => $value) {

		$pdf->SetFont("Times", 'B', 12);
		$pdf->Cell(345,5,'SY '.$value['school_year'].' - '.$value['semester'],1,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(15,5,'#',1,0,'C');
		$pdf->Cell(70,5,'Course Code',1,0,'C');
		$pdf->Cell(210,5,'Title',1,0,'C');
		$pdf->Cell(50,5,'Final Grade',1,0,'C');
		$pdf->Ln(5);

		if(!empty($value['Sub'])){

		  foreach ($value['Sub'] as $keys => $valuex) {

			$pdf->SetFont("Times", '', 12);
			$pdf->Cell(15,5,$keys + 1,1,0,'C');
			$pdf->Cell(70,5,$valuex['code'],1,0,'C');
			$pdf->Cell(210,5,properCase($valuex['title']),1,0,'L');
			$pdf->Cell(50,5,fnumber($valuex['grade'],2),1,0,'C');
			$pdf->Ln(5);

		  }

		}

	  }
	}


	$pdf->output();
	exit();
  
  }

  public function student_ledgers($id = null){

	$data = $this->Student->find('first', array(

	  'contain' => array(
		
		'Curriculum' => array(

		  'conditions' => array(

			'Curriculum.visible' => true

		  ),

		),
		
		'StudentRegistration' => array(
		
		  'AcademicTerm' => array(

			'conditions' => array(

			  'AcademicTerm.visible' => true

			),

		  ),

		  'conditions' => array(

			'StudentRegistration.visible' => true

		  ),

		  'order' => array(

			'StudentRegistration.id' => 'ASC'

		  ),

		),
		
		'StudentLedger' => array(

		  'conditions' => array(

			'StudentLedger.visible' => true,

			'StudentLedger.is_active' => true

		  ),

		),

	  ),

	  'conditions' => array(

		'Student.visible' => true,

		'Student.id'      => $id,

	  )

	));

	if(!empty($data['StudentRegistration'])){

	  foreach ($data['StudentRegistration'] as $key => $value) {

		$data['StudentRegistration'][$key]['title'] = $value['AcademicTerm']['school_year'].' '.$value['AcademicTerm']['semester'];

		if(!empty($data['StudentLedger'])){

		  foreach ($data['StudentLedger'] as $keys => $values) {

			if($value['academic_term_id'] == $values['term_id']){

			  $values['transaction_date'] = !is_null($values['transaction_date']) ? fdate($values['transaction_date']) : null;

			  $values['remarks_tmp'] = $values['remarks'].' ('.$values['transaction_code'].')';

			  if($values['balance'] >= 0){

				$values['balance'] = fnumber($values['balance'],2);

			  }else{

				$values['balance'] = '('.fnumber(($values['balance'] * -1),2).')';

			  }

			  $data['StudentRegistration'][$key]['StudentLedger'][] = $values;

			}

		  }

		}

	  }

	}

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT LEDGER',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(15,5,'#',1,0,'C');
	$pdf->Cell(55,5,'REFERENCE NO.',1,0,'C');
	$pdf->Cell(50,5,'TRANSACTION DATE',1,0,'C');
	$pdf->Cell(50,5,'DEBIT',1,0,'C');
	$pdf->Cell(50,5,'CREDIT',1,0,'C');
	$pdf->Cell(50,5,'BALANCE',1,0,'C');
	$pdf->Cell(75,5,'TRANSACTION',1,0,'C');
	$pdf->Ln(5);

	if(!empty($data['StudentRegistration'])){

	  foreach ($data['StudentRegistration'] as $key => $value) {

		$pdf->SetFont("Times", 'B', 10);
		$pdf->Cell(345,5,$value['title'],1,0,'C');
		$pdf->Ln(5);

		if(!empty($value['StudentLedger'])){

		  foreach ($value['StudentLedger'] as $keys => $valuex) {

			$pdf->SetFont("Times", '', 10);
			$pdf->Cell(15,5,$keys + 1,1,0,'C');
			$pdf->Cell(55,5,$valuex['primary_refno'],1,0,'C');
			$pdf->Cell(50,5,$valuex['transaction_date'],1,0,'C');
			$pdf->Cell(50,5,fnumber($valuex['debit'],2),1,0,'R');
			$pdf->Cell(50,5,fnumber($valuex['credit'],2),1,0,'R');
			$pdf->Cell(50,5,$valuex['balance'],1,0,'R');
			$pdf->CellFitScale(75,5,$valuex['remarks_tmp'].' ',1,0,'L');
			$pdf->Ln(5);

		  }

		}

	  }

	}else{

	  $pdf->SetFont("Times", '', 10);
	  $pdf->Cell(345,5,'No data available.',1,0,'C');
	  $pdf->Ln(5);

	}

	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(15,5,'#',1,0,'C');
	$pdf->Cell(55,5,'REFERENCE NO.',1,0,'C');
	$pdf->Cell(50,5,'TRANSACTION DATE',1,0,'C');
	$pdf->Cell(50,5,'DEBIT',1,0,'C');
	$pdf->Cell(50,5,'CREDIT',1,0,'C');
	$pdf->Cell(50,5,'BALANCE',1,0,'C');
	$pdf->Cell(75,5,'TRANSACTION',1,0,'C');
	$pdf->Ln(5);


	$pdf->output();
	exit();
  
  }

  public function qce_admin_faculty(){
	
	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['college_id'] = '';

	$college = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Employee.college_id = $college_id";

	  $collegeData = $this->College->findById($college_id);

	  $college = $collegeData['College']['name'];

	}

	$this->loadModel('QceAdminFaculty');

	$tmpData = $this->QceAdminFaculty->query($this->QceAdminFaculty->getAllEmployee($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'Faculy Management - '.$college,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(55,5,'Employee No.',1,0,'C',1);
	$pdf->Cell(275,5,'Employee Name',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,55,275));
	$pdf->SetAligns(array('C','C','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['Employee']['employee_no'],

		  $data['Employee']['full_name'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function qce_admin_faculty_results(){

	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['college_id'] = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Student.college_id = $college_id";

	}

	$conditions['faculty_id'] = '';

	$faculty = '';

	if (isset($this->request->query['faculty_id'])) {

	  $faculty_id = $this->request->query['faculty_id'];

	  $conditions['faculty_id'] = "AND QuestionnaireEvaluated.faculty_id = $faculty_id";

	  $employeeData = $this->Employee->findById($faculty_id);

	  $faculty = $employeeData['Employee']['full_name'];

	}

	$conditions['academic_term_id'] = '';

	if (isset($this->request->query['academic_term_id'])) {

	  $academic_term_id = $this->request->query['academic_term_id'];

	  $conditions['academic_term_id'] = "AND QuestionnaireEvaluated.academic_term_id = $academic_term_id";

	}

	$this->loadModel('QceAdminFacultyEvaluation');

	$tmpData = $this->QceAdminFacultyEvaluation->query($this->QceAdminFacultyEvaluation->getAllEvaluation($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');



	$average = array(

	  'a1'           => round(Set::extract('0.0.a1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'a2'           => round(Set::extract('0.0.a2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'a3'           => round(Set::extract('0.0.a3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'a4'           => round(Set::extract('0.0.a4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'a5'           => round(Set::extract('0.0.a5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'b1'           => round(Set::extract('0.0.b1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'b2'           => round(Set::extract('0.0.b2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'b3'           => round(Set::extract('0.0.b3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'b4'           => round(Set::extract('0.0.b4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'b5'           => round(Set::extract('0.0.b5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'c1'           => round(Set::extract('0.0.c1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'c2'           => round(Set::extract('0.0.c2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'c3'           => round(Set::extract('0.0.c3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'c4'           => round(Set::extract('0.0.c4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'c5'           => round(Set::extract('0.0.c5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'd1'           => round(Set::extract('0.0.d1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'd2'           => round(Set::extract('0.0.d2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'd3'           => round(Set::extract('0.0.d3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'd4'           => round(Set::extract('0.0.d4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'd5'           => round(Set::extract('0.0.d5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'a'            => round(Set::extract('0.0.a1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'b'            => round(Set::extract('0.0.a1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'c'            => round(Set::extract('0.0.a1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	  'd'            => round(Set::extract('0.0.a1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)),2),

	);

	$average['a'] = (floatval(Set::extract('0.0.a1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.a2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.a3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.a4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.a5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)))) / 5;

	$average['b'] = (floatval(Set::extract('0.0.b1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.b2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.b3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.b4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.b5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)))) / 5;

	$average['c'] = (floatval(Set::extract('0.0.c1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.c2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.c3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.c4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.c5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)))) / 5;

	$average['d'] = (floatval(Set::extract('0.0.d1',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.d2',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.d3',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.d4',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions))) + floatval(Set::extract('0.0.d5',$this->QceAdminFacultyEvaluation->getAllEvaluationAverage($conditions)))) / 5;

	$average['total'] = round((floatval($average['a']) + floatval($average['b']) + floatval($average['c']) + floatval($average['d'])) / 4,2);

	$average['a'] = round($average['a'],2);

	$average['b'] = round($average['b'],2);

	$average['c'] = round($average['c'],2);

	$average['d'] = round($average['d'],2);

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'QCE ADMIN - '.$faculty,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(0,5,'OVERALL RATING : '.$average['total'].' ('.count($tmpData).') RESULTS',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,10,'#',1,0,'C');
	$pdf->Cell(50,5,'A',1,0,'C');
	$pdf->Cell(50,5,'B',1,0,'C');
	$pdf->Cell(50,5,'C',1,0,'C');
	$pdf->Cell(50,5,'D',1,0,'C');
	$pdf->Cell(90,10,'COMMENT',1,0,'C');
	$pdf->Cell(45,10,'EVALUATED ON',1,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(10,5,'Q1',1,0,'C');
	$pdf->Cell(10,5,'Q2',1,0,'C');
	$pdf->Cell(10,5,'Q3',1,0,'C');
	$pdf->Cell(10,5,'Q4',1,0,'C');
	$pdf->Cell(10,5,'Q5',1,0,'C');
	$pdf->Cell(10,5,'Q1',1,0,'C');
	$pdf->Cell(10,5,'Q2',1,0,'C');
	$pdf->Cell(10,5,'Q3',1,0,'C');
	$pdf->Cell(10,5,'Q4',1,0,'C');
	$pdf->Cell(10,5,'Q5',1,0,'C');
	$pdf->Cell(10,5,'Q1',1,0,'C');
	$pdf->Cell(10,5,'Q2',1,0,'C');
	$pdf->Cell(10,5,'Q3',1,0,'C');
	$pdf->Cell(10,5,'Q4',1,0,'C');
	$pdf->Cell(10,5,'Q5',1,0,'C');
	$pdf->Cell(10,5,'Q1',1,0,'C');
	$pdf->Cell(10,5,'Q2',1,0,'C');
	$pdf->Cell(10,5,'Q3',1,0,'C');
	$pdf->Cell(10,5,'Q4',1,0,'C');
	$pdf->Cell(10,5,'Q5',1,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,90,45));
	$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $datas){

		$results = explode(",",$datas['QuestionnaireEvaluated']['results']);

		$a1 = 0;$a2 = 0;$a3 = 0;$a4 = 0;$a5 = 0;

		$b1 = 0;$b2 = 0;$b3 = 0;$b4 = 0;$b5 = 0;

		$c1 = 0;$c2 = 0;$c3 = 0;$c4 = 0;$c5 = 0;

		$d1 = 0;$d2 = 0;$d3 = 0;$d4 = 0;$d5 = 0;

		if(!empty($results)){

		  foreach ($results as $k => $v) {

			$eval = explode("$",$v);

			$question  = @$eval[0];

			$rating = @$eval[1];

			$type = @$eval[2];

			if($type == 'A'){

			  if($question == '1'){

				$a1 = floatval($rating);

			  }

			  if($question == '2'){

				$a2 = floatval($rating);

			  }

			  if($question == '3'){

				$a3 = floatval($rating);

			  }

			  if($question == '4'){

				$a4 = floatval($rating);

			  }

			  if($question == '5'){

				$a5 = floatval($rating);

			  }

			}else if($type == 'B'){

			  if($question == '1'){

				$b1 = floatval($rating);

			  }

			  if($question == '2'){

				$b2 = floatval($rating);

			  }

			  if($question == '3'){

				$b3 = floatval($rating);

			  }

			  if($question == '4'){

				$b4 = floatval($rating);

			  }

			  if($question == '5'){

				$b5 = floatval($rating);

			  }

			}else if($type == 'C'){

			  if($question == '1'){

				$c1 = floatval($rating);

			  }

			  if($question == '2'){

				$c2 = floatval($rating);

			  }

			  if($question == '3'){

				$c3 = floatval($rating);

			  }

			  if($question == '4'){

				$c4 = floatval($rating);

			  }

			  if($question == '5'){

				$c5 = floatval($rating);

			  }

			}else if($type == 'D'){

			  if($question == '1'){

				$d1 = floatval($rating);

			  }

			  if($question == '2'){

				$d2 = floatval($rating);

			  }

			  if($question == '3'){

				$d3 = floatval($rating);

			  }

			  if($question == '4'){

				$d4 = floatval($rating);

			  }

			  if($question == '5'){

				$d5 = floatval($rating);

			  }

			}

		  }

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $a1,

		  $a2,

		  $a3,

		  $a4,

		  $a5,

		  $b1,

		  $b2,

		  $b3,

		  $b4,

		  $b5,

		  $c1,

		  $c2,

		  $c3,

		  $c4,

		  $c5,

		  $d1,

		  $d2,

		  $d3,

		  $d4,

		  $d5,

		  $datas['QuestionnaireEvaluated']['comment'],

		  fdate($datas['QuestionnaireEvaluated']['created'],'m/d/Y h:i A')

		));

	  }

	  $pdf->SetFont("Arial", 'B', 8);
	  $pdf->Cell(10,5,'Avg',1,0,'C');
	  $pdf->SetFont("Arial", 'I', 8);
	  $pdf->Cell(10,5,$average['a1'],1,0,'C');
	  $pdf->Cell(10,5,$average['a2'],1,0,'C');
	  $pdf->Cell(10,5,$average['a3'],1,0,'C');
	  $pdf->Cell(10,5,$average['a4'],1,0,'C');
	  $pdf->Cell(10,5,$average['a5'],1,0,'C');
	  $pdf->Cell(10,5,$average['b1'],1,0,'C');
	  $pdf->Cell(10,5,$average['b2'],1,0,'C');
	  $pdf->Cell(10,5,$average['b3'],1,0,'C');
	  $pdf->Cell(10,5,$average['b4'],1,0,'C');
	  $pdf->Cell(10,5,$average['b5'],1,0,'C');
	  $pdf->Cell(10,5,$average['c1'],1,0,'C');
	  $pdf->Cell(10,5,$average['c2'],1,0,'C');
	  $pdf->Cell(10,5,$average['c3'],1,0,'C');
	  $pdf->Cell(10,5,$average['c4'],1,0,'C');
	  $pdf->Cell(10,5,$average['c5'],1,0,'C');
	  $pdf->Cell(10,5,$average['d1'],1,0,'C');
	  $pdf->Cell(10,5,$average['d2'],1,0,'C');
	  $pdf->Cell(10,5,$average['d3'],1,0,'C');
	  $pdf->Cell(10,5,$average['d4'],1,0,'C');
	  $pdf->Cell(10,5,$average['d5'],1,0,'C');
	  $pdf->Cell(90,5,'',1,0,'C');
	  $pdf->Cell(45,5,'',1,0,'C');
	  $pdf->Ln();
	  $pdf->Cell(10,5,'',1,0,'C');
	  $pdf->SetFont("Arial", 'BI', 8);
	  $pdf->Cell(50,5,$average['a'],1,0,'C');
	  $pdf->Cell(50,5,$average['b'],1,0,'C');
	  $pdf->Cell(50,5,$average['c'],1,0,'C');
	  $pdf->Cell(50,5,$average['d'],1,0,'C');
	  $pdf->Cell(90,5,'',1,0,'C');
	  $pdf->Cell(45,5,'',1,0,'C');
	  $pdf->Ln();

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();

  }

  public function qce_admin_faculty_evaluator(){
	
	// default conditions

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['college_id'] = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Student.college_id = $college_id";

	}

	$conditions['faculty_id'] = '';

	if (isset($this->request->query['faculty_id'])) {

	  $faculty_id = $this->request->query['faculty_id'];

	  $conditions['faculty_id'] = "AND QuestionnaireEvaluated.faculty_id = $faculty_id";

	}

	$conditions['academic_term_id'] = '';

	if (isset($this->request->query['academic_term_id'])) {

	  $academic_term_id = $this->request->query['academic_term_id'];

	  $conditions['academic_term_id'] = "AND QuestionnaireEvaluated.academic_term_id = $academic_term_id";

	}

	$conditions['course_id'] = '';

	if (isset($this->request->query['course_id'])) {

	  $course_id = $this->request->query['course_id'];

	  $conditions['course_id'] = "AND QuestionnaireEvaluated.course_id = $course_id";

	}

	$this->loadModel('QceAdminFacultyEvaluator');

	$tmpData = $this->QceAdminFacultyEvaluator->query($this->QceAdminFacultyEvaluator->getAllEvaluator($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'QCE ADMIN - EVALUATORS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(55,5,'ID NUMBER',1,0,'C',1);
	$pdf->Cell(275,5,'NAME',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,55,275));
	$pdf->SetAligns(array('C','C','L'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $datas){

		$tmp = $datas['QceAdminFacultyEvaluator'];

		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['student_no'],

		  $tmp['full_name'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function qce_admin_faculty_turnout(){
	
	// default page 1

	$page = isset($this->request->query['page'])? $this->request->query['page'] : 1;
	
	// default conditions

	$conditions = array();

	$conditionsPrint = '';

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	  $conditionsPrint .= '&search='.$search;

	}

	$conditions['college_id'] = '';

	$college = '';

	if (isset($this->request->query['college_id'])) {

	  $college_id = $this->request->query['college_id'];

	  $conditions['college_id'] = "AND Student.college_id = $college_id";

	  $conditionsPrint .= '&college_id='.$college_id;

	  $collegeData = $this->College->findById($college_id);

	  $college = $collegeData['College']['name'];

	}

	$conditions['faculty_id'] = '';

	$no_enrollees = '';

	$faculty = '';

	if (isset($this->request->query['faculty_id'])) {

	  $faculty_id = $this->request->query['faculty_id'];

	  $conditions['faculty_id'] = "AND QuestionnaireEvaluated.faculty_id = $faculty_id";

	  $conditions['no_enrollees'] = "AND ClassSchedule.faculty_id = $faculty_id";

	  $conditionsPrint .= '&faculty_id='.$faculty_id;

	  $employeeData = $this->Employee->findById($faculty_id);

	  $faculty = $employeeData['Employee']['full_name'];

	}

	$conditions['academic_term_id'] = '';

	$acad_no_enrollees = '';

	if (isset($this->request->query['academic_term_id'])) {

	  $academic_term_id = $this->request->query['academic_term_id'];

	  $conditions['academic_term_id'] = "AND QuestionnaireEvaluated.academic_term_id = $academic_term_id";

	  $conditions['acad_no_enrollees'] = "AND CourseSchedule.academic_term_id = $academic_term_id";

	  $conditionsPrint .= '&academic_term_id='.$academic_term_id;

	}

	$conditions['course_id'] = '';

	if (isset($this->request->query['course_id'])) {

	  $course_id = $this->request->query['course_id'];

	  $conditions['course_id'] = "AND QuestionnaireEvaluated.course_id = $course_id";

	  $conditionsPrint .= '&course_id='.$course_id;

	}

	$this->loadModel('QceAdminFacultyTurnout');

	$tmpData = $this->QceAdminFacultyTurnout->query($this->QceAdminFacultyTurnout->getAllEvaluator($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/bu-logo.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'QCE ADMIN - TURNOUT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(135,5,'COURSE',1,0,'C',1);
	$pdf->Cell(65,5,'TOTAL NO.OF ENROLLEES',1,0,'C',1);
	$pdf->Cell(65,5,'NO. OF EVALUATORS',1,0,'C',1);
	$pdf->Cell(65,5,'PERCENTAGE TURNOUT',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,135,65,65,65));
	$pdf->SetAligns(array('C','L','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $datas){

		$course_id = $datas['QceAdminFacultyTurnout']['course_id'];

		$enrolees = Set::extract('0.0.no_enrollees',$this->QceAdminFacultyTurnout->query("

		  SELECT 

			count(*) as no_enrollees

		  FROM 

			subject_lists as SubjectList LEFT JOIN

			course_schedules as CourseSchedule ON SubjectList.course_schedule_id = CourseSchedule.id

		  WHERE

			SubjectList.visible = true $no_enrollees $acad_no_enrollees AND

			CourseSchedule.visible = true AND

			SubjectList.active = true AND

			CourseSchedule.course_id = $course_id

		"));

		$academic_term_id = @$conditions['academic_term_id'];

		$college_id = @$conditions['college_id'];

		$faculty_id = @$conditions['faculty_id'];

		$evaluator = Set::extract('0.0.no_evaluator',$this->QceAdminFacultyTurnout->query("

		  SELECT

			count(*) as no_evaluator

		  FROM

			questionnaire_evaluateds as QuestionnaireEvaluated LEFT JOIN

			students as Student ON Student.id = QuestionnaireEvaluated.student_id LEFT JOIN

			courses as Course on Course.id = QuestionnaireEvaluated.course_id

		  WHERE

			QuestionnaireEvaluated.visible = true $college_id $academic_term_id $faculty_id AND

			Student.visible = true AND

			Course.visible = true AND

			Course.id = $course_id

		"));

		$pdf->RowLegalL(array(

		  $key + 1,

		  $datas['QceAdminFacultyTurnout']['course'],

		  $enrolees,

		  $evaluator,

		  round(($evaluator / ($enrolees > 0 ? $enrolees : 1)) * 100,2)

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function logs(){
  
	// default page 1

	$page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

	// default conditions

	$this->UserLogs->recursive = 0;

	$conditions = array();

	$conditions['search'] = '';

	if (isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $date = date('Y-m-d', strtotime($this->request->query['date']));

	  $conditions['date'] = "AND DATE(UserLog.created) = '$date'"; 

	}  

	if (isset($this->request->query['startDate'])) {

	  $start = date('Y-m-d', strtotime($this->request->query['startDate'])); 

	  $end = date('Y-m-d', strtotime($this->request->query['endDate']));

	  $conditions['date'] = "AND DATE(UserLog.created) >= '$start' AND DATE(UserLog.created) <= '$end'";

	}

	$tmpData = $this->UserLogs->getAllUserLogPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25 ,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'User Logs Management',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'DATE AND TIME',1,0,'C',1);
	$pdf->Cell(35,5,'FULL NAME',1,0,'C',1);
	$pdf->Cell(30,5,'ACTION',1,0,'C',1);
	$pdf->Cell(25,5,'REFERENCE NO',1,0,'C',1);
	$pdf->Cell(60,5,'DESCRIPTION',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,35,30,25,60));
	$pdf->SetAligns(array('C','C','C','C','C','L'));

	if(count($tmpData) > 0){

	  $count = 0;

	  foreach ($tmpData as $key => $data){

		$pdf->Row2(array(

		  $key + 1,

		  date('M d, Y h:i:s A', strtotime($data['created'])),

		  $data['full_name'],

		  $data['action'],

		  $data['code'],

		  $data['description'],

		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(23,5,'Prepared By:',0,0,'L');
	$pdf->Cell(165,5,$full_name,0,0,'L');

	$pdf->output();
	exit();
  
  }

  public function studentLog(){

	$conditions = array();

	$conditions['search'] = '';

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$tmpData = $this->StudentLogs->getAllStudentLogPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT LOG',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(100,5,'Student Name',1,0,'C',1);
	$pdf->Cell(65,5,'Date',1,0,'C',1);
	$pdf->Cell(65,5,'Time',1,0,'C',1);
	$pdf->Cell(100,5,'Concern',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,100,65,65,100));
	$pdf->SetAligns(array('C','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['student_name'],

		  $data['date'],

		  $data['time'],

		  $data['concern'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+10,$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+330,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function informedConsentForm($id = null){

	$office_reference = $this->Global->OfficeReference('Counseling Appointment');

	$data = $this->CounselingAppointment->find()

	->contain([

		'Students',

		'CounselingTypes' => [

			'conditions' => ['CounselingTypes.visible' => 1]

		]

	])

	->where([

		'CounselingAppointments.visible' => 1,

		'CounselingAppointments.id' => $id

	])

	->first();

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,5,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetFont("Times", '', 12);
	// $pdf->Image($this->base .'/assets/img/informed_consent_form.png',0,0,215.9,355.6);
	$pdf->Image($this->base .'/assets/img/zam.png',6,20.5,23,23);
	$pdf->Image($this->base .'/assets/img/iso.png',187,20.5,20,25);
	$pdf->Ln(22);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph  email: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,187,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,187,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(15.5,$pdf->GetY() + 3.5,38,17);
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST - '. @$office_reference['OfficeReference']['counselee_informed_consent_reference'],0,0,'L');
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(50,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 15);
	$pdf->Cell(50,19,'COUNSELEE INFORMED CONSENT FORM',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(20.5);
	$pdf->SetFont("Arial", 'I', 10.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'As a general rule, all of the information shared during counseling sessions must be confidential, unless',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'there is a written consent to disclose certain information from the client.',0,0,'L');
	$pdf->Ln(9);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'However, confidentiality cannot be maintained ONLY when:',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,'l',0,0,'L');
	$pdf->SetFont("Arial", 'I', 10.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'You tell a plan to cause serious harm or death to yourself and/or to someone else.',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,'l',0,0,'L');
	$pdf->SetFont("Arial", 'I', 10.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'You are doing things that could cause serious harm to you or someone else.',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,'l',0,0,'L');
	$pdf->SetFont("Arial", 'I', 10.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'You tell me you are being abused – physically, sexually or emotionally.',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,'l',0,0,'L');
	$pdf->SetFont("Arial", 'I', 10.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'You are involved in a court case and a request is made for information about your counseling or',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(65,5,'therapy.  If this happens, I will not disclose information without your written agreement unless',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(65,5,'the court requires me to.',0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'Signing below indicates that you have reviewed the policies described above and understand the limits to',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'confidentiality.  If you have any questions as we progress with the counseling, you may ask your',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'counselor anytime.',0,0,'L');
	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(33,5,'',0,0,'L');
	$pdf->Cell(24,5,$data['student']['first_name'].' '.$data['student']['middle_name'].' '.$data['student']['last_name'],0,0,'C');
	$pdf->Cell(55,5,'',0,0,'L');
	$pdf->Cell(50,5,date('m/d/Y'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Line(25,$pdf->getY(),85,$pdf->getY());
	$pdf->Line(127,$pdf->getY(),163,$pdf->getY());
	$pdf->Cell(33,5,'',0,0,'L');
	$pdf->Cell(24,5,"Signature of Client over Printed Name",0,0,'C');
	$pdf->Cell(55,5,'',0,0,'L');
	$pdf->Cell(50,5,"Date",0,0,'C');
	$pdf->Ln(19);
	$pdf->SetDash(1,2);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(25,$pdf->getY(),195,$pdf->getY());
	$pdf->SetLineWidth(0.2);
	$pdf->SetDash(0,0);
	$pdf->Ln(7);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(24,5,"For the Counselor and Parent/Guardian Agreement",0,0,'L');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(24,5,"The parent/guardian of the client will refrain from requesting detailed information about individual",0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(24,5,"counseling session with his/her child.",0,0,'L');
	$pdf->Ln(10.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(24,5,"Although the parent/guardian has the legal right to request written records/session notes, he or she will",0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(24,5,"agree NOT to request these records in order to respect the confidentiality of his/her child.",0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(24,5,"The decision to breach confidentiality is up to the counselor's professional judgment.",0,0,'L');
	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(33,5,'',0,0,'L');
	$pdf->Cell(24,5,'',0,0,'C');
	$pdf->Cell(55,5,'',0,0,'L');
	$pdf->Cell(50,5,date('m/d/Y'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Line(25,$pdf->getY(),89,$pdf->getY());
	$pdf->Line(127,$pdf->getY(),163,$pdf->getY());
	$pdf->Cell(35,6,'',0,0,'L');
	$pdf->Cell(24,6,"Parent/Guardian's Name over Signature",0,0,'C');
	$pdf->Cell(53,6,'',0,0,'L');
	$pdf->Cell(50,6,"Date",0,0,'C');
	$pdf->Ln(26);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(33,5,'',0,0,'L');
	$pdf->Cell(24,5,'',0,0,'C');
	$pdf->Cell(55,5,'',0,0,'L');
	$pdf->Cell(50,5,date('m/d/Y'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Line(25,$pdf->getY(),89,$pdf->getY());
	$pdf->Line(127,$pdf->getY(),163,$pdf->getY());
	$pdf->Cell(35,6,'',0,0,'L');
	$pdf->Cell(24,6,"Counselor's Name over Signature",0,0,'C');
	$pdf->Cell(53,6,'',0,0,'L');
	$pdf->Cell(50,6,"Date",0,0,'C');
	
	$pdf->output();
	exit();

  }

  public function releaseInfoForm($id = null){

	$office_reference = $this->Global->OfficeReference('Counseling Appointment');

	$data = $this->CounselingAppointment->find()

	  ->contain([

		  'Students',

		  'CounselingTypes' => [

			  'conditions' => ['CounselingTypes.visible' => 1]

		  ]

	  ])

	  ->where([

		  'CounselingAppointments.visible' => 1,

		  'CounselingAppointments.id' => $id

	  ])

	  ->first();

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,5,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetFont("Times", '', 12);
	// $pdf->Image($this->base .'/assets/img/release_info_form.png',0,0,215.9,355.6);
	$pdf->Image($this->base .'/assets/img/zam.png',6,5.5,23,23);
	$pdf->Image($this->base .'/assets/img/iso.png',187,5.5,20,25);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph  email: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,187,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,187,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(14.5,$pdf->GetY() + 3.5,31,14.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST - '. @$office_reference['OfficeReference']['release_information_reference'] ,0,0,'L');
	$pdf->SetFont("Times", 'B', 14);
	$pdf->Cell(50,5.5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", 'B', 14);
	$pdf->Cell(50,11,'RELEASE INFORMATION FORM',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(14.5);
	$pdf->SetFont("Arial", '', 11.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'In order to safeguard your right to  confidentiality, your  written permission  is required if  you request',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'information  to  be  released to  another person  or  agency.  Guidance  and  Testing  Unit records  are kept',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'separated  from you  from your educational  record for  confidentiality  purpose.  However, letters written  to',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'faculty, parent/guardian for petitions, for recommendations or other such released information becomes the',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(65,5,'property of the college and some cases may become a part of your educational record.',0,0,'L');
	$pdf->Ln(12);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(65,5,'This form permits the Guidance and Testing Unit to release information concerning',0,0,'L');
	$pdf->Ln(10.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(26,5,"Client's Name:",0,0,'L');
	$pdf->Cell(83,5,utf8_decode($data['student']['first_name'].' '.$data['student']['middle_name'].' '.$data['student']['last_name']),0,0,'L');
	$pdf->Cell(13,5,"ID No.:",0,0,'L');
	$pdf->Cell(28,5,$data['student']['student_no'],0,0,'L');
	$pdf->Line(39,$pdf->getY()+5,118,$pdf->getY()+5);
	$pdf->Line(134,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(5.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(28,5,"Course & Year:",0,0,'L');
	$pdf->Line(40,$pdf->getY()+5,118,$pdf->getY()+5);
	$pdf->Ln(5.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(25,5,"Home Address:",0,0,'L');
	$pdf->Line(40,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(25,5,"A. To the following person/agency:",0,0,'L');
	$pdf->Ln(6);
	$pdf->Cell(7,5,'',0,0,'L');
	$pdf->Cell(25,5,"Name :",0,0,'L');
	$pdf->Line(32,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Cell(7,5,'',0,0,'L');
	$pdf->Cell(25,5,"Address :",0,0,'L');
	$pdf->Line(35,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(25,5,"B. For the use of:",0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(25,5,"(   ) AACCUP",0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(25,5,"(   ) ISO",0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(25,5,"(   ) CHED MARINA",0,0,'L');
	$pdf->Ln(11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(25,5,"C. Court Cases",0,0,'L');
	$pdf->Ln(11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'Such information  may include  a summary  of any diagnostic, treatment or  testing information that  is my file  at',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'the Guidance and Testing Unit.',0,0,'L');
	$pdf->Ln(17);
	$pdf->Cell(89,5,'',0,0,'C');
	$pdf->Cell(50,5,date('m/d/Y'),0,0,'C');
	$pdf->Ln(4.5);
	$pdf->Line(12.5,$pdf->getY(),70.5,$pdf->getY());
	$pdf->Line(102,$pdf->getY(),148,$pdf->getY());
	$pdf->Ln(1.5);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(24,5,"Client's Signature",0,0,'C');
	$pdf->Cell(50,5,'',0,0,'L');
	$pdf->Cell(50,5,"Date",0,0,'C');

	$pdf->output();
	exit();

  }

  public function noHarmContractForm($id = null){

	$office_reference = $this->Global->OfficeReference('Counseling Appointment');

	$data = $this->CounselingAppointment->find()

	->contain([

		'Students',

		'CounselingTypes' => [

			'conditions' => ['CounselingTypes.visible' => 1]

		]

	])

	->where([

		'CounselingAppointments.visible' => 1,

		'CounselingAppointments.id' => $id

	])

	->first();

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,5,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetFont("Times", '', 12);
	// $pdf->Image($this->base .'/assets/img/no_harm_contract.png',0,0,215.9,355.6);
	$pdf->Image($this->base .'/assets/img/zam.png',6,5.5,23,23);
	$pdf->Image($this->base .'/assets/img/iso.png',187,5.5,20,25);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph  email: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,187,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,187,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(14.5,$pdf->GetY() + 3.5,31,14.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 14);
	$pdf->Cell(50,5.5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 14);
	$pdf->Cell(50,11,'NO-HARM CONTRACT',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Line(16.5,$pdf->getY()+4,117,$pdf->getY()+4);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'I,',0,0,'L');
	$pdf->Cell(103,5,$data['student_name'],0,0,'L');
	$pdf->Cell(65,5,'agree  not to  harm  myself in  any way,  attempt  to',0,0,'L');
	$pdf->Ln(5);
	$pdf->Line(94,$pdf->getY()+4,132,$pdf->getY()+4);
	$pdf->Line(138,$pdf->getY()+4,177,$pdf->getY()+4);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->Cell(121,5,'commit suicide, kill myself during the period from',0,0,'L');
	$pdf->Cell(45,5,'to',0,0,'L');
	$pdf->Cell(65,5,'(the time of my',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->Cell(121,5,'next appointment).',0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->MultiCell(192.2,5,'I agree that, for any reason, if the appointment session postponed, cancelled, etc., that this time period is extended until the next schedule session with my guidance counselor.  In this period of time, I decided to take care of myself, to eat well, avoid drinking liquor, coffee or anything that will cause me to experience insomnia and sleep well.',0);
	
	$pdf->Ln(6);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->Cell(121,5,'I agree to make social/family contact with the following individuals:',0,0,'L');

	$pdf->Ln(14);
	$pdf->Line(13,$pdf->getY(),109,$pdf->getY());
	$pdf->Line(13,$pdf->getY()+5,109,$pdf->getY()+5);
	$pdf->Line(13,$pdf->getY()+10,109,$pdf->getY()+10);

	$pdf->Ln(16.5);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->MultiCell(192.2,5,'I come to agreement to get rid of all things that I could use to harm or kill myself.  I agree that, if I am having a rough time and come to a point where I feel tension, fast or irregular heartbeat or I may break any of my promises, I will call and make significant contact with any of the following:',0);

	$pdf->SetFont("Arial", '', 10);
	$pdf->Ln(5);
	$pdf->Cell(106,5,'',0,0,'L');
	$pdf->Cell(121,5,'Contact No.',0,0,'L');
	$pdf->Line(13,$pdf->getY()+4,109,$pdf->getY()+4);
	$pdf->Line(136,$pdf->getY()+4,176.5,$pdf->getY()+4);
	
	$pdf->Ln(5);
	$pdf->Cell(106,5,'',0,0,'L');
	$pdf->Cell(121,5,'Contact No.',0,0,'L');
	$pdf->Line(13,$pdf->getY()+4,109,$pdf->getY()+4);
	$pdf->Line(136,$pdf->getY()+4,176.5,$pdf->getY()+4);

	$pdf->Ln(10);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->Cell(121,5,'Or if I cannot contact these individuals, I will immediately call my guidance counselor.',0,0,'L');
	$pdf->Ln(11);
	$pdf->Cell(106,5,'',0,0,'L');
	$pdf->Cell(121,5,'Contact No.',0,0,'L');
	$pdf->Line(13,$pdf->getY()+4,109,$pdf->getY()+4);
	$pdf->Line(136,$pdf->getY()+4,176.5,$pdf->getY()+4);

	$pdf->Ln(10);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->MultiCell(192.2,5,'I agree that these conditions are important, worth doing and come to understanding I am willing to make and keep. By my word and honor, I intend to keep this contract.',0);

	$pdf->Ln(15.5);
	$pdf->Line(13,$pdf->getY()+4,65,$pdf->getY()+4);
	$pdf->Ln(5);
	$pdf->Cell(18,5,'',0,0,'L');
	$pdf->Cell(20,5,"Client's Signature",0,0,'C');

	$pdf->Ln(5);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->Cell(20,5,"Course & Year:",0,0,'L');
	$pdf->Line(37,$pdf->getY()+4,75,$pdf->getY()+4);
	$pdf->Ln(5);
	$pdf->Cell(1.5,5,'',0,0,'L');
	$pdf->Cell(20,5,"Date:",0,0,'L');
	$pdf->Line(22,$pdf->getY()+4,75,$pdf->getY()+4);

	$pdf->output();
	exit();

  }

  public function attendanceCounseling(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(AttendanceCounseling.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(AttendanceCounseling.date) >= '$start' AND DATE(AttendanceCounseling.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->AttendanceCounseling->getAllAttendanceCounselingPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ATTENDANCE TO COUNSELING',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CODE',1,0,'C',1);
	$pdf->Cell(60,5,'TYPE',1,0,'C',1);
	$pdf->Cell(100,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(50,5,'DATE',1,0,'C',1);
	$pdf->Cell(40,5,'TIME',1,0,'C',1);
	$pdf->Cell(50,5,'LOCATION',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,60,100,50,40,50));
	$pdf->SetAligns(array('C','C','C','L','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['name'],

		  mb_convert_encoding($data['student_name'], 'UTF-8', 'ISO-8859-1'),

		  // utf8_decode($data['student_name']),

		  fdate($data['date'],'m/d/Y'),

		  fdate($data['time'],'h:i A'),

		  $data['location'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function attendanceCounselingForm($id = null){

	$office_reference = $this->Global->OfficeReference('Attendance to Counseling');

	$data = $this->AttendanceCounseling->find()

	->contain([

		'CounselingAppointments' => [

			'Students',

			'CounselingTypes'

		]

	])

	->where([

		'AttendanceCounselings.visible' => 1,

		'AttendanceCounselings.id' => $id

	])

	->first();

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 9);
	// $pdf->Image($this->base .'/assets/img/attendance_counseling.png',0,0,215.9,355.6);
	$pdf->Image($this->base .'/assets/img/zam.png',20,6,20,20);
	$pdf->Image($this->base .'/assets/img/iso.png',178,6,15,20);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 9.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,197,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,197,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(15.5,$pdf->GetY() + 3.5,31,14.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(45,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 13.5);
	$pdf->Cell(45,20,'ATTENDANCE TO COUNSELING',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(12);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'Date',0,0,'L');
	$pdf->Cell(65,5,date('m/d/Y'),0,0,'L');
	$pdf->Line(21,$pdf->getY()+5,65,$pdf->getY()+5);
	$pdf->Ln(10.5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'This is to certify that',0,0,'L');
	$pdf->Cell(98.5,5,$data['student_name'],0,0,'L');
	$pdf->Line(45,$pdf->getY()+4,142,$pdf->getY()+4);
	$pdf->Cell(32,5,'have attended the counseling session ',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(5,5,'on',0,0,'L');
	$pdf->Cell(60.5,5,$data['date']->format('m/d/Y').' '.fdate($data['time'],'h:i A'),0,0,'L');
	$pdf->Line(18,$pdf->getY()+4,77,$pdf->getY()+4);
	$pdf->Cell(5,5,'at',0,0,'L');
	$pdf->Cell(92,5,$data['location'],0,0,'L');
	$pdf->Line(83,$pdf->getY()+4,175,$pdf->getY()+4);
	$pdf->Cell(5,5,'.',0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Recommendation:',0,0,'L');
	$pdf->Line(13,$pdf->getY()+10,203,$pdf->getY()+10);
	$pdf->Line(13,$pdf->getY()+15,203,$pdf->getY()+15);
	$pdf->Ln(5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->MultiCell(190,5,$data['recommendation'],0);
	$pdf->Ln(10);
	$pdf->Line(13,$pdf->getY(),80,$pdf->getY());
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(48,6,'Guidance Counselor',0,0,'C');
	$pdf->Ln(13);
	$pdf->SetFont("Arial", '', 14);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(48,6,'***********************************************************************************************',0,0,'L');

	$pdf->Ln(5.5);
	$pdf->Image($this->base .'/assets/img/zam.png',20,$pdf->getY(),20,20);
	$pdf->Image($this->base .'/assets/img/iso.png',178,$pdf->getY(),15,20);
	$pdf->SetFont("Times", '', 9);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 9.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,197,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,197,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(15.5,$pdf->GetY() + 3.5,31,14.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-'. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(45,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 13.5);
	$pdf->Cell(45,20,'ATTENDANCE TO COUNSELING',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(12);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'Date',0,0,'L');
	$pdf->Cell(65,5,date('m/d/Y'),0,0,'L');
	$pdf->Line(21,$pdf->getY()+5,65,$pdf->getY()+5);
	$pdf->Ln(10.5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'This is to certify that',0,0,'L');
	$pdf->Cell(98.5,5,$data['student_name'],0,0,'L');
	$pdf->Line(45,$pdf->getY()+4,142,$pdf->getY()+4);
	$pdf->Cell(32,5,'have attended the counseling session ',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(5,5,'on',0,0,'L');
	$pdf->Cell(60.5,5,$data['date']->format('m/d/Y').' '.fdate($data['time'],'h:i A'),0,0,'L');
	$pdf->Line(18,$pdf->getY()+4,77,$pdf->getY()+4);
	$pdf->Cell(5,5,'at',0,0,'L');
	$pdf->Cell(92,5,$data['location'],0,0,'L');
	$pdf->Line(83,$pdf->getY()+4,175,$pdf->getY()+4);
	$pdf->Cell(5,5,'.',0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Recommendation:',0,0,'L');
	$pdf->Line(13,$pdf->getY()+10,203,$pdf->getY()+10);
	$pdf->Line(13,$pdf->getY()+15,203,$pdf->getY()+15);
	$pdf->Ln(5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->MultiCell(190,5,$data['recommendation'],0);
	$pdf->Ln(10);
	$pdf->Line(13,$pdf->getY(),80,$pdf->getY());
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(48,6,'Guidance Counselor',0,0,'C');
	$pdf->Ln(13);
	$pdf->SetFont("Arial", '', 14);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(48,6,'***********************************************************************************************',0,0,'L');
	
	$pdf->Ln(5.5);
	$pdf->Image($this->base .'/assets/img/zam.png',20,$pdf->getY(),20,20);
	$pdf->Image($this->base .'/assets/img/iso.png',178,$pdf->getY(),15,20);
	$pdf->SetFont("Times", '', 9);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 9.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,197,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,197,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(15.5,$pdf->GetY() + 3.5,31,14.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-'. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(45,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 13.5);
	$pdf->Cell(45,20,'ATTENDANCE TO COUNSELING',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(7.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(12);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'Date',0,0,'L');
	$pdf->Cell(65,5,date('m/d/Y'),0,0,'L');
	$pdf->Line(21,$pdf->getY()+5,65,$pdf->getY()+5);
	$pdf->Ln(10.5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'This is to certify that',0,0,'L');
	$pdf->Cell(98.5,5,$data['student_name'],0,0,'L');
	$pdf->Line(45,$pdf->getY()+4,142,$pdf->getY()+4);
	$pdf->Cell(32,5,'have attended the counseling session ',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(5,5,'on',0,0,'L');
	$pdf->Cell(60.5,5,$data['date']->format('m/d/Y').' '.fdate($data['time'],'h:i A'),0,0,'L');
	$pdf->Line(18,$pdf->getY()+4,77,$pdf->getY()+4);
	$pdf->Cell(5,5,'at',0,0,'L');
	$pdf->Cell(92,5,$data['location'],0,0,'L');
	$pdf->Line(83,$pdf->getY()+4,175,$pdf->getY()+4);
	$pdf->Cell(5,5,'.',0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Recommendation:',0,0,'L');
	$pdf->Line(13,$pdf->getY()+10,203,$pdf->getY()+10);
	$pdf->Line(13,$pdf->getY()+15,203,$pdf->getY()+15);
	$pdf->Ln(5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->MultiCell(190,5,$data['recommendation'],0);
	$pdf->Ln(10);
	$pdf->Line(13,$pdf->getY(),80,$pdf->getY());
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(48,6,'Guidance Counselor',0,0,'C');

	$pdf->output();
	exit();

  }

  public function referralSlip($id = null){

	$office_reference = $this->Global->OfficeReference('Referral/Appointment Slip');

	$data = $this->ReferralSlips->find()

	->contain([

	  'Students',

	  'CollegePrograms'

	])

	->where([

	  'ReferralSlips.visible' => 1,

	  'ReferralSlips.id' => $id

	])

	->first();

	$ReferralSlip = $data->toArray();

	unset($ReferralSlip['CollegeProgram']);

	unset($ReferralSlip['Student']);

	$data = [

	  'ReferralSlip' => $ReferralSlip,

	  'CollegeProgram' => $data['CollegeProgram'],

	  'Student' => $data['Student']

	];

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(60,10,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 8);
	// $pdf->Image($this->base .'/assets/img/referral_slip.png',0,0,215.9,355.6);
	$pdf->Image($this->base.'/assets/img/zam.png',59,15,13,13);
	$pdf->Image($this->base.'/assets/img/iso.png',145,14,11,15);

	$pdf->Rect(59.5,$pdf->GetY() + 2.5,96.5,321.5);

	$pdf->Ln(2);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 8.2);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES',0,0,'C');

	$pdf->Ln(4);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'AND TECHNOLOGY',0,0,'C');

	$pdf->Ln(3.6);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,$this->Global->Settings('address'),0,0,'C');

	$pdf->Ln(4.5);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph',0,0,'C');

 
	$pdf->Ln(8.5);
	$pdf->SetFont("Times", 'B', 13);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'GUIDANCE AND COUNSELING OFFICE',0,0,'C');

	$pdf->Rect(62,$pdf->GetY() + 7,31,15.5);

	$pdf->Ln(8);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(25,5,'ZSCMST - ' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", '', 13);
	$pdf->Cell(57,9,'REFERRAL SLIP',0,0,'C');

	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(25,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');

	$pdf->Ln(3);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'],0,0,'L');

	$pdf->Ln(3);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');

	$pdf->Ln(22);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(54,5,'',0,0,'L');
	$pdf->Cell(15,5,'Date: ',0,0,'L');
	$pdf->Cell(94,5,date('m/d/Y'),0,0,'L');

	$pdf->Line(125,$pdf->getY()+5,150,$pdf->getY()+5);

	$pdf->Ln(13.5);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(50,5,'To the Guidance Counselor,',0,0,'L');

	$pdf->Ln(11.5);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(50,5,'May I refer the student for counseling.',0,0,'L');

	$pdf->Ln(11.5);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(50,5,'Name of student:',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(50,5,$data['ReferralSlip']['student_name'],0,0,'L');

	$pdf->Line(62,$pdf->getY()+5,150,$pdf->getY()+5);

	$pdf->Ln(12);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(50,5,'Course, Year & Section:',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 9);
	$y = $pdf->GetY();
	$pdf->MultiCell(100,5,$data['CollegeProgram']['name'].' - '.$data['ReferralSlip']['year'],0,1);
	$pdf->setXY(3,$y);
	$pdf->Line(62,$pdf->getY(),127,$pdf->getY());

	$pdf->Line(62,$pdf->getY()+5,147,$pdf->getY()+5);

	$pdf->Ln(12);
	$pdf->SetFont("Arial", 'I', 11);
	$pdf->Cell(1,5,'',0,0,'L');

	$pdf->Cell(50,5,'For the reason of:',0,0,'L');

	$check1 = '';
	$check2 = '';
	$check3 = '';
	$check4 = '';
	$check5 = '';
	$check6 = '';
	$check7 = '';
	$check8 = '';
	$check9 = '';
	$check10 = '';
	$check11 = '';
	$check12 = '';
	$check13 = '';
	$check14 = '';
	$check15 = '';

	$others = '';
	$remarks = '';

	if($data['ReferralSlip']['reason'] == 'Absenteeism'){

	  $check1 = 4;

	  $remarks = $data['ReferralSlip']['remarks'];

	}elseif($data['ReferralSlip']['reason'] == 'Forgery'){

	  $check2 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Tardiness'){

	  $check3 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Fist Fighting'){

	  $check4 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Cutting Classes'){

	  $check5 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Slandering'){

	  $check6 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Incomplete Grades'){

	  $check7 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Stealing'){

	  $check8 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Failing Grades'){

	  $check9 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Dating'){

	  $check10 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Family Problem'){

	  $check11 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Cheating'){

	  $check12 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Smoking'){

	  $check13 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Vandalism'){

	  $check14 = 4;

	}elseif($data['ReferralSlip']['reason'] == 'Others, please specify'){

	  $check15 = 4;

	  $others = $data['ReferralSlip']['others'];

	}

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check1,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Absenteeism',0,0,'L');
	$pdf->Cell(45,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check2,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Forgery',0,0,'L');
	$pdf->Cell(48.5,5,'',0,0,'L');


	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check3,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Tardiness',0,0,'L');
	$pdf->Cell(45,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check4,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Fist Fighting',0,0,'L');
	$pdf->Cell(48.5,5,'',0,0,'L');


	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check5,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Cutting Classes',0,0,'L');
	$pdf->Cell(45,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check6,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Slandering',0,0,'L');
	$pdf->Cell(48.5,5,'',0,0,'L');


	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check7,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Incomplete Grades',0,0,'L');
	$pdf->Cell(45,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check8,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Stealing',0,0,'L');
	$pdf->Cell(48.5,5,'',0,0,'L');


	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check9,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Failing Grades',0,0,'L');
	$pdf->Cell(45,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check10,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Dating',0,0,'L');
	$pdf->Cell(48.5,5,'',0,0,'L');


	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check11,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Family Problem',0,0,'L');
	$pdf->Cell(45,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check12,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Cheating',0,0,'L');
	$pdf->Cell(48.5,5,'',0,0,'L');


	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check13,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Smoking',0,0,'L');
	$pdf->Cell(45,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check14,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Vandalism',0,0,'L');
	$pdf->Cell(48.5,5,'',0,0,'L');


	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check15,0,0,'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'Others, please specify:',0,0,'L');
	$pdf->Cell(101.5,5,'',0,0,'L');


	$pdf->Ln(11);
	$pdf->Line(80.5,$pdf->getY(),147.5,$pdf->getY());
	$pdf->Line(80.5,$pdf->getY()+5.5,147.5,$pdf->getY()+5.5);
	$pdf->Line(80.5,$pdf->getY()+11,147.5,$pdf->getY()+11);
	$pdf->Line(80.5,$pdf->getY()+17,147.5,$pdf->getY()+17);
	$pdf->Line(80.5,$pdf->getY()+22.5,147.5,$pdf->getY()+22.5);


	$pdf->Ln(-5);
	$pdf->SetFont("Arial", '', 9);
	$y = $pdf->GetY();
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->MultiCell(68,5.5,$others,0);
	$pdf->SetXY(132,$y);
	$pdf->MultiCell(68,5.5,$others,0);

	if($pdf->GetY() == 202.6){
	  $pdf->Ln(29);
	}elseif($pdf->GetY() == 208.1){
	  $pdf->Ln(23.5);
	}elseif($pdf->GetY() == 213.6){
	  $pdf->Ln(18);
	}elseif($pdf->GetY() == 219.1){
	  $pdf->Ln(12.5);
	}elseif($pdf->GetY() >= 224.6){
	  $pdf->Ln(7);
	}
	
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'I', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(50,5,'Remarks:',0,0,'L');
	$pdf->Ln(6);
	$pdf->SetFont("Arial", 'I', 8.2);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(50,5,'(for ABSENTEEISM, kindly indicate the specific dates of the absences):',0,0,'L');
	$pdf->Ln(9);
	$pdf->Line(70,$pdf->getY(),147.5,$pdf->getY());
	$pdf->Line(70,$pdf->getY()+4.5,147.5,$pdf->getY()+4.5);
	$pdf->Line(70,$pdf->getY()+9,147.5,$pdf->getY()+9);
	$pdf->Line(70,$pdf->getY()+14,147.5,$pdf->getY()+14);
	$pdf->Line(70,$pdf->getY()+18.5,147.5,$pdf->getY()+18.5);


	$pdf->Ln(-5);
	$pdf->SetFont("Arial", '', 9);
	$y = $pdf->GetY();
	$pdf->Cell(9,5,'',0,0,'L');
	$pdf->MultiCell(78,5,$remarks,0);


	if($pdf->GetY() == 246.6){
	  $pdf->Ln(20);
	}elseif($pdf->GetY() == 251.6){
	  $pdf->Ln(15);
	}elseif($pdf->GetY() == 256.6){
	  $pdf->Ln(10);
	}elseif($pdf->GetY() == 261.6){
	  $pdf->Ln(5);
	}

	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');

	$pdf->Cell(50,5,'Referred by:',0,0,'L');

	$pdf->Ln(11.5);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(92,5,$full_name,0,0,'C');

	$pdf->Ln(5);
	$pdf->Line(84,$pdf->getY(),133,$pdf->getY());

	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1,7,'',0,0,'L');
	$pdf->Cell(92,7,'Signature over Printed Name',0,0,'C');

	$pdf->Ln(5);
	$pdf->Cell(1,7,'',0,0,'L');
	$pdf->Cell(92,7,'Instructor/Professor',0,0,'C');


	$pdf->Ln(18);
	$pdf->Cell(1,5,'',0,0,'L');

	$pdf->Cell(50,5,'College:',0,0,'L');
	$pdf->Line(77,$pdf->getY()+5,119,$pdf->getY()+5);


	$pdf->output();
	exit();

  }

  public function appointmentSlip($id = null){


	$data = $this->AppointmentSlips->find()

	->contain(['Students'])

	->where([

	  'AppointmentSlips.visible' => 1,

	  'AppointmentSlips.id' => $id

	])

	->first();

	$AppointmentSlip = $data->toArray();

	unset($AppointmentSlip['Student']);

	$data = [

	  'AppointmentSlip' => $AppointmentSlip,

	  'Student' => $data['Student']

	];

	// debug($data);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(57,10,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 6);
	// $pdf->Image($this->base .'/assets/img/appointment_slip.png',0,0,215.9,355.6);
	$pdf->Image($this->base.'/assets/img/zam.png',63,18,12,12);
	$pdf->Image($this->base.'/assets/img/iso.png',145,18,8,12);

	$pdf->Rect(62.5,$pdf->GetY() + 4,91,121);

	$pdf->Ln(3);
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(50,5,'Republic of the Philippines',0,0,'C');

	$pdf->Ln(3);
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(50,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',0,0,'C');

	$pdf->Ln(3);
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(50,5,'Fort Pilar, Zamboanga City 7000',0,0,'C');

	$pdf->Ln(3.5);
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(50,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph',0,0,'C');

	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 8);
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(50,5,'GUIDANCE AND COUNSELING OFFICE',0,0,'C');

	
 
	$pdf->Ln(5);
	$pdf->Rect(67,$pdf->GetY()+1,27,12);

	$pdf->Ln(1);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(23,6,'ZSCMST-GTU-3.4.9.5',0,0,'L');
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(52,6,'APPOINTMENT SLIP',0,0,'C');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(25,5,'Adopted Date: January 2012',0,0,'L');

	$pdf->Ln(2.5);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Status: 0',0,0,'L');

	$pdf->Ln(2.5);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Date: 0',0,0,'L');


	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(66,5,'',0,0,'L');
	$pdf->Cell(10,5,'Date: ',0,0,'L');
	$pdf->Cell(91.5,5,date('m/d/Y'),0,0,'L');
	$pdf->Line(133,$pdf->getY()+4,150,$pdf->getY()+4);

  
	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(7,5,'',0,0,'L');
	$pdf->Cell(7,5,'Dear: ',0,0,'L');
	$pdf->SetFont("Arial", 'U', 7);
	$pdf->Cell(94.5,5,$data['AppointmentSlip']['student_name'].',',0,0,'L');

	$pdf->Ln(7.5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(18,5,'',0,0,'L');
	$pdf->Cell(30,5,'I would like to see you on',0,0,'L');
	// debug($data['AppointmentSlip']['date']);
	$pdf->Cell(40,5,$data['AppointmentSlip']['date'].' '.fdate($data['AppointmentSlip']['time'],'h:i A'),0,0,'L');
	$pdf->Line(105,$pdf->getY()+4,145,$pdf->getY()+4);

	$pdf->Cell(30,5,'at',0,0,'L');
	$pdf->Ln(4);
	$pdf->Line(65,$pdf->getY()+4,100,$pdf->getY()+4);

	$pdf->Cell(7,5,'',0,0,'L');
	$pdf->Cell(38.5,5,$data['AppointmentSlip']['location'],0,0,'L');
	$pdf->Cell(7,5,'for a consultation on:',0,0,'L');


	$check1 = '';
	$check2 = '';
	$check3 = '';
	$check4 = '';
	$check5 = '';
	$others = '';

	if($data['AppointmentSlip']['purpose'] == 'Academic Issues'){
	  $check1 = 4;
	}elseif($data['AppointmentSlip']['purpose'] == 'Career Issues'){
	  $check2 = 4;
	}elseif($data['AppointmentSlip']['purpose'] == 'Financial Issues'){
	  $check3 = 4;
	}elseif($data['AppointmentSlip']['purpose'] == 'Personal IssuesIssues'){
	  $check4 = 4;
	}elseif($data['AppointmentSlip']['purpose'] == 'Others, please specify'){
	  $check5 = 4;
	  $others = $data['AppointmentSlip']['others'];
	}

	$pdf->Ln(7);
	$pdf->Cell(18.5,5,'',0,0,'L');
	$pdf->Cell(2.5,5,'_____',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,$check1,0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(5,5,'Academic Issues',0,0,'L');
	$pdf->Cell(88,5,'',0,0,'L');

	$pdf->Ln(4);
	$pdf->Cell(18.5,5,'',0,0,'L');
	$pdf->Cell(2.5,5,'_____',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,$check2,0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(5,5,'Career Issues',0,0,'L');
	$pdf->Cell(88,5,'',0,0,'L');

	$pdf->Ln(3.5);
	$pdf->Cell(18.5,5,'',0,0,'L');
	$pdf->Cell(2.5,5,'_____',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,$check3,0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(5,5,'Financial Issues',0,0,'L');
	$pdf->Cell(88,5,'',0,0,'L');

	$pdf->Ln(4);
	$pdf->Cell(18.5,5,'',0,0,'L');
	$pdf->Cell(2.5,5,'_____',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,$check4,0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(5,5,'Personal IssuesIssues',0,0,'L');
	$pdf->Cell(88,5,'',0,0,'L');

	$pdf->Ln(3.5);
	$pdf->Cell(18.5,5,'',0,0,'L');
	$pdf->Cell(2.5,5,'_____',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(5,5,$check5,0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(1,5,'',0,0,'L');
	$pdf->Cell(5,5,'Others, please specify',0,0,'L');
	$pdf->Cell(88,5,'',0,0,'L');

	$pdf->Ln(3.5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(50,5,$others,0,0,'L');
	$pdf->Line(93,$pdf->getY()+4,145,$pdf->getY()+4);

	$pdf->Ln(15);
	$pdf->Cell(9,5,'',0,0,'L');
	$pdf->Cell(50,5,$full_name,0,0,'C');
	$pdf->Line(65,$pdf->getY()+4,115,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(9,5,'',0,0,'L');
	$pdf->Cell(50,5,"Counselor's signature over printed name",0,0,'C');


	$pdf->output();
	exit();

  }

  public function promissoryNoteForm($id = null){

	$office_reference = $this->Global->OfficeReference('Promissory Note Waiver');

	$this->loadModel('PromissoryNotes');

	$data = $this->PromissoryNotes->find()

	->contain([

	  'Students',

	  'CollegePrograms',

	  'YearLevelTerms'

	])

	->where([

	  'PromissoryNotes.visible' => 1,

	  'PromissoryNotes.id'      => $id

	])

	->first();

	$PromissoryNote = $data->toArray();

	unset($PromissoryNote['Student']);

	unset($PromissoryNote['CollegeProgram']);

	unset($PromissoryNote['YearLevelTerm']);

	$data = [

	  'PromissoryNote' => $PromissoryNote,

	  'Student' => $data['Student'],

	  'CollegeProgram' => $data['CollegeProgram'],

	  'YearLevelTerm' => $data['YearLevelTerm'],

	];

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,4,5);
	$pdf->AddPage("P", "A4", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11.5);
	// $pdf->Image($this->base .'/assets/img/promissory_note.png',0,0,210,297);
	$pdf->Image($this->base.'/assets/img/zam.png',12,4,22,22);
	$pdf->Image($this->base.'/assets/img/iso.png',190,5,15,20);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 8);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph   email: zscmstguidance@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,205,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,205,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(12,$pdf->GetY() + 3.5,31,13);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,4,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 14);
	$pdf->Cell(45,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", 'B', 14.5);
	$pdf->Cell(45,20,'PROMISSORY NOTE/WAIVER',0,0,'C');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(30);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(82,5,date('m/d/Y'),0,0,'C');
	$pdf->Line(25,$pdf->getY()+5,67,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(82,5,'Date',0,0,'C');
	$pdf->Ln(21);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'I',0,0,'L');
	$pdf->Cell(100,5,$data['PromissoryNote']['student_name'],0,0,'L');
	$pdf->Cell(3,5,',',0,0,'L');
	$pdf->Line(28,$pdf->getY()+4,128,$pdf->getY()+4);
	$pdf->Cell(45.5,5,$data['CollegeProgram']['code'].'/'.$data['YearLevelTerm']['year'],0,0,'L');
	$pdf->Line(131,$pdf->getY()+4,176,$pdf->getY()+4);
	$pdf->Cell(3.5,5,', hereby',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(51,5,'',0,0,'L');
	$pdf->Cell(10.5,5,'(complete name)',0,0,'L');
	$pdf->Cell(67,5,'',0,0,'L');
	$pdf->Cell(10.5,5,'(course/year/section)',0,0,'L');
	$pdf->Ln(10.5);
	$pdf->Line(43,$pdf->getY()+4,197,$pdf->getY()+4);
	$pdf->Line(25,$pdf->getY()+9.5,197,$pdf->getY()+9.5);
	$pdf->Line(25,$pdf->getY()+15,197,$pdf->getY()+15);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->MultiCell(173,5.5,'promise to   '.$data['PromissoryNote']['description'],0);

	if($pdf->GetY() == 114.5){
	  $pdf->Ln(15);
	}elseif($pdf->GetY() == 120){
	  $pdf->Ln(9);
	}elseif($pdf->GetY() >= 125.5){
	  $pdf->Ln(4);
	}

	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->MultiCell(173,5.5,'I further agree to the corresponding disciplinary measure/sanction that will be imposed upon for my failure to heed to the conditions set forth by the Zamboanga State College of Marine Sciences and Technology after having been fully informed by the Guidance Counselor.',0);
	
	$pdf->Ln(15);
	$pdf->Cell(133,5,'',0,0,'L');
	$pdf->Cell(50,5,$data['PromissoryNote']['student_name'],0,0,'C');
	$pdf->Ln(4);
	$pdf->Line(131,$pdf->getY(),195,$pdf->getY());
	$pdf->Cell(133,5,'',0,0,'L');
	$pdf->Cell(50,7,'Signature over Printed Name of Student',0,0,'C');

	$pdf->Ln(16);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(50,5,'',0,0,'L');
	$pdf->Ln(4);
	$pdf->Line(25,$pdf->getY(),110,$pdf->getY());
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(50,7,'Signature over Printed Name of Parent/Guardian',0,0,'L');
	$pdf->Ln(16);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(50,7,'Noted:',0,0,'L');
	$pdf->Ln(26);
	$pdf->Line(25,$pdf->getY(),100,$pdf->getY());
	$pdf->Cell(30,5,'',0,0,'L');
	$pdf->Cell(50,7,'Guidance Counselor',0,0,'C');
	$pdf->Ln(15);
	$pdf->Line(25,$pdf->getY(),100,$pdf->getY());
	$pdf->Cell(30,5,'',0,0,'L');
	$pdf->Cell(50,7,'Program Adviser',0,0,'C');
	$pdf->Ln(15);
	$pdf->Line(25,$pdf->getY(),100,$pdf->getY());
	$pdf->Cell(30,5,'',0,0,'L');
	$pdf->Cell(50,7,'College Dean',0,0,'C');
	
	$pdf->output();
	exit();

  }

  public function referralSlipManagement(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(ReferralSlip.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ReferralSlip.date) >= '$start' AND DATE(ReferralSlip.date) <= '$end'";

	}



	$tmpData = $this->ReferralSlips->getAllReferralSlipPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'REFERRAL / APPOINTMENT SLIP',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(110,5,'COLLEGE PROGRAM',1,0,'C',1);
	$pdf->Cell(60,5,'YEAR',1,0,'C',1);
	$pdf->Cell(65,5,'REASON',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,50,110,60,65));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['name'],  

		  $data['year'],

		  $data['reason'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function appointmentSlipManagement(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(AppointmentSlip.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(AppointmentSlip.date) >= '$start' AND DATE(AppointmentSlip.date) <= '$end'";

	}

	$tmpData = $this->AppointmentSlips->getAllAppointmentSlipPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'REFERRAL / APPOINTMENT SLIP',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(100,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(60,5,'DATE',1,0,'C',1);
	$pdf->Cell(60,5,'TIME',1,0,'C',1);
	$pdf->Cell(65,5,'LOCATION',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,100,60,60,65));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'],'m/d/Y'),

		  fdate($data['time'],'h:i A'),

		  $data['location'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }


  public function counselingAppointment(){
	$conditions = [];

	$conditionsPrint = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(CounselingAppointment.date) = '$search_date'"; 

	  $dates['date'] = $search_date;


	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(CounselingAppointment.date) >= '$start' AND DATE(CounselingAppointment.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;


	}

	$conditions['status'] = '';
	// var_dump($this->request->getQuery('status'));
	if ($this->request->getQuery('status')!=null) {

	  // var_dump($this->request->getQuery('status'));

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND CounselingAppointment.approve = $status";



	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');

	  $employee_id = $this->Auth->user('studentId');

	  if ($employee_id!='') {

		$conditions['studentId'] = "AND CounselingAppointment.student_id = $employee_id";

	  }

	}

	$tmpData = $this->CounselingAppointment->getAllCounselingAppointmentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'COUNSELING APPOINTMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(45,5,'Control No.',1,0,'C',1);
	$pdf->Cell(50,5,'Type',1,0,'C',1);
	$pdf->Cell(100,5,'Student Name',1,0,'C',1);
	$pdf->Cell(60,5,'Date',1,0,'C',1);
	$pdf->Cell(45,5,'Time',1,0,'C',1);
	$pdf->Cell(35,5,'Status',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,45,50,100,60,45,35));
	$pdf->SetAligns(array('C','C','C','L','C','C','C'));

	if(count($tmpData)>0){

	  $approve = '';

	  foreach ($tmpData as $key => $data){ 

		if($data['approve'] == 0){

		  $approve = 'PENDING';

		}else if($data['approve'] == 2){

		  $approve = 'DISAPPROVED';

		}else if($data['approve'] == 1){

		  $approve = 'APPROVED';

		}else if($data['approve'] == 3){

		  $approve = 'CANCELLED';

		}else if($data['approve'] == 4){

		  $approve = 'CONFIRMED';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['name'],

		  strtoupper($data['student_name']),  

		  fdate($data['date'],'m/d/Y'),

		  fdate($data['time'],'h:i A'),

		  $approve

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function affidavit(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Affidavit.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Affidavit.date) >= '$start' AND DATE(Affidavit.date) <= '$end'";

	}

	$this->loadModel('Affidavits');

	$tmpData = $this->Affidavits->getAllAffidavitPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'AFFIDAVIT FOR LOST',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(65,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(30,5,'DATE',1,0,'C',1);
	$pdf->Cell(150,5,'COLLEGE PROGRAM',1,0,'C',1);
	$pdf->Cell(50,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,65,30,150,50));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  date('m/d/Y', strtotime($data['date'])),

		  $data['name'],  

		  $data['year'],


		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function affidavitForm($id = null){

	$office_reference = $this->Global->OfficeReference('Affidavit for Lost ID/Passbook');

	$data = $this->Affidavits->find()

	->contain([

		'CollegePrograms' => [

			'conditions' => ['CollegePrograms.visible' => 1]
		]

	])

	->where([

	  'Affidavits.visible' => 1,

	  'Affidavits.id' => $id

	])

	->first();



	$Affidavit = $data->toArray();

	unset($Affidavit['CollegeProgram']);

	$data = [

	  'Affidavit' => $Affidavit,

	  'CollegeProgram' => $data['CollegeProgram']

	];

	$data['Affidavit']['amount'] = floatval($data['Affidavit']['amount']);

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,5,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 12);
	// $pdf->Image($this->base .'/assets/img/affidavit_form.png',0,0,215.9,355.6);
	$pdf->Image($this->base.'/assets/img/zam.png',8,6,20,20);
	$pdf->Image($this->base.'/assets/img/iso.png',188,6,15,20);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph   email: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,205,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,205,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(12,$pdf->GetY() + 3.5,31,14.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(3.5,5,'',0,0,'L');
	$pdf->Cell(70,5,'ZSCMST - ' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(45,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(3.5,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(45,23,'AFFIDAVIT FOR LOST PASSBOOK/ID',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(3.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(3.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(32);
	
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(32,5,'Republic of the Philippines',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(32,5,'City of Zamboanga (       ) S.S',0,0,'L');

	$pdf->Ln(17);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(3,5,'I,',0,0,'L');
	$pdf->Cell(88,5,$data['Affidavit']['student_name'],0,0,'L');
	$pdf->Line(28,$pdf->getY()+4,114,$pdf->getY()+4);
	$pdf->Cell(20,5,'single/married,    of    legal    age,    residing   at',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(91,5,$data['Affidavit']['address'],0,0,'L');
	$pdf->Line(25,$pdf->getY()+5,114,$pdf->getY()+5);
	$pdf->Cell(20,5,'after   being   duly   sworn   in  accordance  with',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(91,5,'the law, do hereby depose and say:',0,0,'L');

	$pdf->Ln(11);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(91,5,'1. That I am a student of this College, SY 20___-___, 1st/2nd semester',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(91,5,'2. That as such student, I was issued Student Passbook/ID',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(91,5,'3. That I have lost my said School Passbook/ID (state circumstances)',0,0,'L');
	
	$pdf->Ln(5.5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->MultiCell(132,5.5,$data['Affidavit']['description'],0);

	if($pdf->GetY() == 139.5){
	  $pdf->Ln(18);
	}elseif($pdf->GetY() == 145){
	  $pdf->Ln(12);
	}elseif($pdf->GetY() >= 150.5){
	  $pdf->Ln(6);
	}

	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(91,5,'4. That I have searched for the said Student Passbook/ID',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(91,5,'5. That I make this statement for the purpose of including the College to issue me a',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(31,5,'',0,0,'L');
	$pdf->Cell(91,5,'new Student Passbook/ID is found, I will return it immediately to the College',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(31,5,'',0,0,'L');
	$pdf->Cell(91,5,'for cancellation.',0,0,'L');

	$pdf->Ln(10);
	$pdf->Line(135,$pdf->getY()+6,183,$pdf->getY()+6);
	$pdf->Ln(7);
	$pdf->Cell(110,5,'',0,0,'L');
	$pdf->Cell(91,5,"Student's Signature",0,0,'C');

	$pdf->Ln(10);
	$pdf->Line(135,$pdf->getY()+6,183,$pdf->getY()+6);
	$pdf->Cell(110,5,'',0,0,'L');
	$pdf->Cell(91,5,$data['CollegeProgram']['code'].' '.$data['Affidavit']['year'],0,0,'C');
	$pdf->Ln(7);
	$pdf->Cell(110,5,'',0,0,'L');
	$pdf->Cell(91,5,"Course and Year",0,0,'C');

	$pdf->Ln(22);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(11,5,'O.R.#',0,0,'L');
	$pdf->Cell(91,5,$data['Affidavit']['or_no'],0,0,'L');
	$pdf->Line(35,$pdf->getY()+5,70,$pdf->getY()+5);
	$pdf->Ln(5.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(11,5,'Date :',0,0,'L');
	$pdf->Cell(91,5,date('m/d/Y',strtotime($data['Affidavit']['date'])),0,0,'L');
	$pdf->Line(35,$pdf->getY()+5,70,$pdf->getY()+5);
	$pdf->Ln(5.5);
	$pdf->Cell(14,5,'',0,0,'L');
	$pdf->Cell(18,5,'Amount : P',0,0,'L');
	$pdf->Cell(91,5,fnumber($data['Affidavit']['amount'],2),0,0,'L');
	$pdf->Line(43,$pdf->getY()+5,70,$pdf->getY()+5);

	$pdf->Ln(23);
	$pdf->Cell(0,5,'_______________________________',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,'Guidance Counselor',0,0,'C');
	

	$pdf->output();
	exit();

  }

  public function promissoryNote(){

	$this->loadModel('PromissoryNotes');

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('startDate')){

	  $search = $this->request->getQuery('startDate');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(PromissoryNote.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(PromissoryNote.date) >= '$start' AND DATE(PromissoryNote.date) <= '$end'";

	}

	$tmpData = $this->PromissoryNotes->getAllPromissoryNotePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PROMISSORY NOTE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(40,5,'DATE',1,0,'C',1);
	$pdf->Cell(130,5,'COLLEGE PROGRAM',1,0,'C',1);
	$pdf->Cell(80,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,50,40,130,80));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'],'m/d/Y'),

		  $data['name'],  

		  $data['description'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function goodMoral(){

	$conditions = array();

	$conditions['search'] = '';

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$dataTable = $this->GoodMorals;

	$tmpData = $dataTable->getAllGoodMoralPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam2.png',15,10,25,25);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'GOOD MORAL CERTIFICATE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(25,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(70,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'DATE',1,0,'C',1);
	$pdf->Cell(45,5,'REMARKS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,25,70,55,45));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'],'m/d/Y'),

		  $data['remarks'],


		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+118,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function gcoEvaluation(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(GcoEvaluation.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(GcoEvaluation.date) >= '$start' AND DATE(GcoEvaluation.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  // $student_id = $this->Session->read('Auth.User.studentId');

	  $conditions['studentId'] = "AND GcoEvaluation.student_id = $per_student";

	}

	$tmpData = $this->GcoEvaluations->getAllGcoEvaluationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'GCO EVALUATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(85,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(50,5,'ATTENDANCE TO COUNSELING',1,0,'C',1);
	$pdf->Cell(25,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,85,50,25));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  strtoupper($data['student_name']),

		  $data['attendanceCode'],

		  fdate($data['date'],'m/d/Y'),


		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+118,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }


  public function gcoEvaluationForm($id = null){

	$office_reference = $this->Global->OfficeReference('Gco Evaluation');

	$data['GcoEvaluation'] = $this->GcoEvaluations->find()

	  ->contain([

		'Students',

		'AttendanceCounselings' => [

				'CounselingAppointments' => [

				  'conditions' => ['CounselingAppointments.visible' => 1]

				],

			'conditions' => ['AttendanceCounselings.visible' => 1]

		]

		])

	  ->where([

		'GcoEvaluations.visible' => 1,

		'GcoEvaluations.id' => $id

	  ])

	  ->first();

	  $data = [

		'GcoEvaluation' => $data['GcoEvaluation'],

		'Student'  => $data['GcoEvaluation']->student,

		'AttendanceCounseling'  => $data['GcoEvaluation']->attendance_counseling,

		'CounselingAppointment'  => $data['GcoEvaluation']->attendance_counseling->counseling_appointment,

	  ];

	  unset($data['GcoEvaluation']->student);

	  unset($data['GcoEvaluation']->attendance_counseling);

	  unset($data['GcoEvaluation']->attendance_counseling->counseling_appointment);

	  // debug($data);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(56,10,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 6.5);
	// $pdf->Image($this->base .'/assets/img/gco_evaluation.png',0,0,215.9,355.6);
	$pdf->Image($this->base.'/assets/img/zam.png',55.5,10.5,15,15);
	$pdf->Image($this->base.'/assets/img/iso.png',145.5,10.5,10,14);

  
	$pdf->Ln(3);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(50,5,'Republic of the Philippines',0,0,'C');

	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(50,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',0,0,'C');

	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 6.5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(50,5,'Fort Pilar, Zamboanga City 7000',0,0,'C');

	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(50,5,'GUIDANCE AND COUNSELING OFFICE',0,0,'C');

 
	$pdf->Ln(5.5);
	$pdf->Rect(58.5,$pdf->GetY(),32.5,14.5);

	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(27,6,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", '', 11.5);
	$pdf->Cell(52,12,'GCO EVALUATION',0,0,'C');
	$pdf->Cell(22.5,5,'',0,0,'L');

	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(25,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');

	$pdf->Ln(2.5);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');

	$pdf->Ln(2.5);
	$pdf->Cell(4,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'L');


	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(6.5,5,'',0,0,'L');
	$pdf->Cell(15.5,5,'Counselor : ',0,0,'L');
	$pdf->Cell(86,5,$data['CounselingAppointment']['counselor_name'],0,0,'L');

	$pdf->Line(79,$pdf->getY()+4,140,$pdf->getY()+4);

	
	$pdf->Ln(8);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(6.5,5,'',0,0,'L');
	$pdf->Cell(15.5,5,'Rate your visit on a 5 to 1 scale, where:',0,0,'L');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 6.5);
	$pdf->Cell(6.5,5,'',0,0,'L');
	$pdf->Cell(15.5,5,'5 - Outstanding     4 - Very Satisfactory     3 - Satisfactory    2 - Fair         1 - Poor',0,0,'L');

	$a1 = '';
	$b1 = '';
	$c1 = '';
	$d1 = '';
	$e1 = '';
	$f1 = '';
	$g1 = '';
	$h1 = '';
	$i1 = '';

	$a2 = '';
	$b2 = '';
	$c2 = '';
	$d2 = '';
	$e2 = '';
	$f2 = '';
	$g2 = '';
	$h2 = '';
	$i2 = '';

	$a3 = '';
	$b3 = '';
	$c3 = '';
	$d3 = '';
	$e3 = '';
	$f3 = '';
	$g3 = '';
	$h3 = '';
	$i3 = '';

	$a4 = '';
	$b4 = '';
	$c4 = '';
	$d4 = '';
	$e4 = '';
	$f4 = '';
	$g4 = '';
	$h4 = '';
	$i4 = '';

	$a5 = '';
	$b5 = '';
	$c5 = '';
	$d5 = '';
	$e5 = '';
	$f5 = '';
	$g5 = '';
	$h5 = '';
	$i5 = '';

	// A 

	  if($data['GcoEvaluation']['a'] == 1){

		$a1 = 4;

	  }elseif($data['GcoEvaluation']['a'] == 2){

		$a2 = 4;

	  }elseif($data['GcoEvaluation']['a'] == 3){

		$a3 = 4;

	  }elseif($data['GcoEvaluation']['a'] == 4){

		$a4 = 4;

	  }elseif($data['GcoEvaluation']['a'] == 5){

		$a5 = 4;

	  }

	// END A

	// B

	  if($data['GcoEvaluation']['b'] == 1){

		$b1 = 4;

	  }elseif($data['GcoEvaluation']['b'] == 2){

		$b2 = 4;

	  }elseif($data['GcoEvaluation']['b'] == 3){

		$b3 = 4;

	  }elseif($data['GcoEvaluation']['b'] == 4){

		$b4 = 4;

	  }elseif($data['GcoEvaluation']['b'] == 5){

		$b5 = 4;

	  }

	// END B

	// C

	  if($data['GcoEvaluation']['c'] == 1){

		$c1 = 4;

	  }elseif($data['GcoEvaluation']['c'] == 2){

		$c2 = 4;

	  }elseif($data['GcoEvaluation']['c'] == 3){

		$c3 = 4;

	  }elseif($data['GcoEvaluation']['c'] == 4){

		$c4 = 4;

	  }elseif($data['GcoEvaluation']['c'] == 5){

		$c5 = 4;

	  }

	// END C

	// D

	  if($data['GcoEvaluation']['d'] == 1){

		$d1 = 4;

	  }elseif($data['GcoEvaluation']['d'] == 2){

		$d2 = 4;

	  }elseif($data['GcoEvaluation']['d'] == 3){

		$d3 = 4;

	  }elseif($data['GcoEvaluation']['d'] == 4){

		$d4 = 4;

	  }elseif($data['GcoEvaluation']['d'] == 5){

		$d5 = 4;

	  }

	// END D

	// E

	  if($data['GcoEvaluation']['e'] == 1){

		$e1 = 4;

	  }elseif($data['GcoEvaluation']['e'] == 2){

		$e2 = 4;

	  }elseif($data['GcoEvaluation']['e'] == 3){

		$e3 = 4;

	  }elseif($data['GcoEvaluation']['e'] == 4){

		$e4 = 4;

	  }elseif($data['GcoEvaluation']['e'] == 5){

		$e5 = 4;

	  }

	// END E

	// F

	  if($data['GcoEvaluation']['f'] == 1){

		$f1 = 4;

	  }elseif($data['GcoEvaluation']['f'] == 2){

		$f2 = 4;

	  }elseif($data['GcoEvaluation']['f'] == 3){

		$f3 = 4;

	  }elseif($data['GcoEvaluation']['f'] == 4){

		$f4 = 4;

	  }elseif($data['GcoEvaluation']['f'] == 5){

		$f5 = 4;

	  }

	// END F

	// G

	  if($data['GcoEvaluation']['g'] == 1){

		$g1 = 4;

	  }elseif($data['GcoEvaluation']['g'] == 2){

		$g2 = 4;

	  }elseif($data['GcoEvaluation']['g'] == 3){

		$g3 = 4;

	  }elseif($data['GcoEvaluation']['g'] == 4){

		$g4 = 4;

	  }elseif($data['GcoEvaluation']['g'] == 5){

		$g5 = 4;

	  }

	// END G

	// H

	  if($data['GcoEvaluation']['h'] == 1){

		$h1 = 4;

	  }elseif($data['GcoEvaluation']['h'] == 2){

		$h2 = 4;

	  }elseif($data['GcoEvaluation']['h'] == 3){

		$h3 = 4;

	  }elseif($data['GcoEvaluation']['h'] == 4){

		$h4 = 4;

	  }elseif($data['GcoEvaluation']['h'] == 5){

		$h5 = 4;

	  }

	// END H

	// I

	  if($data['GcoEvaluation']['i'] == 1){

		$i1 = 4;

	  }elseif($data['GcoEvaluation']['i'] == 2){

		$i2 = 4;

	  }elseif($data['GcoEvaluation']['i'] == 3){

		$i3 = 4;

	  }elseif($data['GcoEvaluation']['i'] == 4){

		$i4 = 4;

	  }elseif($data['GcoEvaluation']['i'] == 5){

		$i5 = 4;

	  }

	// END I

	//EVALUATION TABLE

	  $pdf->Ln(4);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->Cell(5.5,5,'',1,0,'C');
	  $pdf->Cell(61,5,'',1,0,'C');
	  $pdf->Cell(5,5,'5',1,0,'C');
	  $pdf->Cell(5,5,'4',1,0,'C');
	  $pdf->Cell(5,5,'3',1,0,'C');
	  $pdf->Cell(5,5,'2',1,0,'C');
	  $pdf->Cell(5,5,'1',1,0,'C');


	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,9,'a',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,4.5,'How was your experience today with your counselor?',1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$a5,1,0,'C');
	  $pdf->Cell(5,9,$a4,1,0,'C');
	  $pdf->Cell(5,9,$a3,1,0,'C');
	  $pdf->Cell(5,9,$a2,1,0,'C');
	  $pdf->Cell(5,9,$a1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(9);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,9,'b',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,4.5,'Accessibility  of  the  location  of  the  office',1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$b5,1,0,'C');
	  $pdf->Cell(5,9,$b4,1,0,'C');
	  $pdf->Cell(5,9,$b3,1,0,'C');
	  $pdf->Cell(5,9,$b2,1,0,'C');
	  $pdf->Cell(5,9,$b1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(9);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,5,'c',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,5,'Comfort of the counseling area',1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$c5,1,0,'C');
	  $pdf->Cell(5,5,$c4,1,0,'C');
	  $pdf->Cell(5,5,$c3,1,0,'C');
	  $pdf->Cell(5,5,$c2,1,0,'C');
	  $pdf->Cell(5,5,$c1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,9,'d',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,4.5,'Welcoming manner and warmth of the attending counselor',1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$d5,1,0,'C');
	  $pdf->Cell(5,9,$d4,1,0,'C');
	  $pdf->Cell(5,9,$d3,1,0,'C');
	  $pdf->Cell(5,9,$d2,1,0,'C');
	  $pdf->Cell(5,9,$d1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(9);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,5,'e',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,5,'The way the counselor listened to me',1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$e5,1,0,'C');
	  $pdf->Cell(5,5,$e4,1,0,'C');
	  $pdf->Cell(5,5,$e3,1,0,'C');
	  $pdf->Cell(5,5,$e2,1,0,'C');
	  $pdf->Cell(5,5,$e1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,9,'f',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,4.5,"The counselor's ability to answer my questions",1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$f5,1,0,'C');
	  $pdf->Cell(5,9,$f4,1,0,'C');
	  $pdf->Cell(5,9,$f3,1,0,'C');
	  $pdf->Cell(5,9,$f2,1,0,'C');
	  $pdf->Cell(5,9,$f1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(9);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,9,'g',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,4.5,"The way the counselor allowed me to express my concerns and ideas",1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$g5,1,0,'C');
	  $pdf->Cell(5,9,$g4,1,0,'C');
	  $pdf->Cell(5,9,$g3,1,0,'C');
	  $pdf->Cell(5,9,$g2,1,0,'C');
	  $pdf->Cell(5,9,$g1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(9);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,9,'h',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,4.5,"Communication of confidentiality information",1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$h5,1,0,'C');
	  $pdf->Cell(5,9,$h4,1,0,'C');
	  $pdf->Cell(5,9,$h3,1,0,'C');
	  $pdf->Cell(5,9,$h2,1,0,'C');
	  $pdf->Cell(5,9,$h1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	  $pdf->Ln(9);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $pdf->Cell(5.5,9,'i',1,0,'C');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(61,4.5,"Clarity  regarding  the  services  of  the  office",1,1);
	  $pdf->SetXY(128.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$i5,1,0,'C');
	  $pdf->Cell(5,9,$i4,1,0,'C');
	  $pdf->Cell(5,9,$i3,1,0,'C');
	  $pdf->Cell(5,9,$i2,1,0,'C');
	  $pdf->Cell(5,9,$i1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);


	// END EVALUATION TABLE

	$pdf->Ln(12);
	$pdf->Line(79,$pdf->getY()+4,150,$pdf->getY()+4);

	$pdf->Line(63.5,$pdf->getY()+9,150,$pdf->getY()+9);

	$pdf->Line(63.5,$pdf->getY()+13,150,$pdf->getY()+13);

	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(6.5,5,'',0,0,'L');
	$pdf->Cell(1,5,'Comments:',0,0,'L');
	$y = $pdf->GetY();
	$pdf->SetFont("Arial", '', 6);
	$pdf->MultiCell(90,5,'                         '.$data['GcoEvaluation']['comments'],0,'L');
	$pdf->SetXY(113.5,$y);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Ln(5);

	if($pdf->GetY() >= 154){

	  $pdf->Ln(-1);

	}elseif($pdf->GetY() ==  149){

	  $pdf->Ln(4);

	}elseif($pdf->GetY() ==  144){

	  $pdf->Ln(9);

	}

	$pdf->Line(79,$pdf->getY()+4,150,$pdf->getY()+4);

	$pdf->Line(84,$pdf->getY()+8,150,$pdf->getY()+8);

	$pdf->Line(72,$pdf->getY()+12,150,$pdf->getY()+12);


	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(6.5,5,'',0,0,'L');
	$pdf->Cell(15,5,'Signature :',0,0,'L');

	$pdf->Ln(4);
	$pdf->Cell(6.5,5,'',0,0,'L');
	$pdf->Cell(15,5,'Course & Year:',0,0,'L');

	$pdf->Ln(4);
	$pdf->Cell(6.5,5,'',0,0,'L');
	$pdf->Cell(15,5,'Date : '.date('m/d/Y', strtotime($data['GcoEvaluation']['date'])),0,0,'L');


	$pdf->output();
	exit();

  }

  public function medicalCertificate(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(MedicalCertificate.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(MedicalCertificate.date) >= '$start' AND DATE(MedicalCertificate.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND MedicalCertificate.status = $status";
	  
	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $employee_id = $this->Session->read('Auth.User.studentId');

	  $conditions['studentId'] = "AND MedicalCertificate.student_id = $employee_id";

	}

	$dataTable = $this->MedicalCertificates;

	$tmpData = $dataTable->getAllMedicalCertificatePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true; 
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'MEDICAL CERTIFICATE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(95,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'DATE',1,0,'C',1);
	$pdf->Cell(70,5,'COURSE',1,0,'C',1);
	$pdf->Cell(80,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,95,55,70,80));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'],'m/d/Y'),

		  $data['code'],  

		  $data['description'],


		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function medicalCertificateForm($id = null){

	$office_reference = $this->Global->OfficeReference('Medical Certificate Request');

	$data['MedicalCertificate'] = $this->MedicalCertificates->find()

	  ->where([

		'MedicalCertificates.visible' => 1,

		'MedicalCertificates.id' => $id

	  ])

	  ->contain([

		'Students',

		'Employees',

		'CollegePrograms',

		'YearLevelTerms'

	  ])

	  ->first();

	$data['MedicalCertificate']['active_view'] = $data['MedicalCertificate']['active'] ? 'True' : 'False';

	$data['MedicalCertificate']['date'] = $data['MedicalCertificate']['date']->format('m/d/Y');

	$data['MedicalCertificate']['floors'] = intval($data['MedicalCertificate']['floors']);

	$data['Student'] = $data['MedicalCertificate']['student'];

	$data['Employee'] = $data['MedicalCertificate']['employee'];

	$data['CollegeProgram'] = $data['MedicalCertificate']['college_program'];

	$data['YearLevelTerm'] = $data['MedicalCertificate']['year_level_term'];

	unset($data['MedicalCertificate']['year_level_term']);

	unset($data['MedicalCertificate']['college_program']);

	unset($data['MedicalCertificate']['student']);

	unset($data['MedicalCertificate']['employee']);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,8,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Arial", '', 11.5);
	// $pdf->Image($this->base .'/assets/img/medical_certificate_form.png',0,0,210,297);
	$pdf->Image($this->base .'/assets/img/zam.png',8,11,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',180,13,18,21);
	$pdf->Ln(3.5);
	
	$pdf->Ln(4.5);
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph ',0,0,'C');
	$pdf->Ln(21);
	
	$pdf->Rect(165.5,$pdf->GetY() -7,31.5,13);
	$pdf->Ln(4);
	$pdf->SetY($pdf->getY()- 10.6);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(154);
	$pdf->Cell(68,4,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(-154);
	$pdf->Cell(45,5,'HEALTH AND MEDICAL SERVICES',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: '. @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(-154);
	$pdf->Cell(45,20,'MEDICAL CERTIFICATE',0,0,'C');
	$pdf->Line(82,$pdf->getY()+12,125.5,$pdf->getY()+12);
	$pdf->Ln(2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(18);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(82,5,'To whom it may concern: ',0,0,'C');
   
	$pdf->Ln(13);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'This is to certify that Mr./Ms.',0,0,'L');
	$pdf->Cell(45);
	$pdf->Cell(57,5, $data['MedicalCertificate']['student_name'] != null ? strtoupper($data['MedicalCertificate']['student_name']) : strtoupper($data['MedicalCertificate']['employee_name']),0,0,'L');
	
	$pdf->Line(73,$pdf->getY()+4.5,128,$pdf->getY()+4.5);
	// $pdf->Cell(-17);
	$pdf->Cell(5,5,'a',0,0,'L');
	// $pdf->Cell(60);
	// $pdf->SetY($pdf->getY()+6);
	// $pdf->Cell(19.5);
	$pdf->Cell(45.5,5,$data['CollegeProgram']['code'].'/'.$data['YearLevelTerm']['year'],0,0,'L');
	$pdf->Line(135,$pdf->getY()+4.5,170,$pdf->getY()+4.5);
	$pdf->Ln(6);
	$pdf->Cell(19);
	$pdf->Cell(10.5,5,'(course & year) student has been examined by a physician and  was found to be',0,0,'L');
	
	
	$pdf->Ln(6);
	$pdf->Cell(67,5,'',0,0,'L');
	
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(-67);
	$pdf->Cell(19,5.5,'phisically fit.',0);
	$pdf->Ln(13);
	$pdf->Cell(19,5,'',0,0,'L');
	
	$pdf->Cell(19,5.5,'Issued upon the request of the student for whatever purpose it may serve.',0);
	
	$pdf->Ln(12.5);
	$pdf->Line(62,$pdf->getY()+12,146.5,$pdf->getY()+12);
	$pdf->SetY($pdf->getY()+13);
	$pdf->Cell(98);
	$pdf->Cell(3.5,5,'Physician',0,0,'C');
	
	$pdf->SetLineWidth(0.6);
	$pdf->Line(25,$pdf->getY()+19.3,185,$pdf->getY()+19.3);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(25);
	
	//Second page

	$pdf->Image($this->base .'/assets/img/zam.png',8,156,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',180,159,18,21);
	$pdf->Ln(3.5);
	
	$pdf->Ln(4.5);
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph ',0,0,'C');
	$pdf->Ln(21);
	
	$pdf->Rect(165.5,$pdf->GetY() -7,31.5,13);
	$pdf->Ln(4);
	$pdf->SetY($pdf->getY()- 10.6);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(154);
	$pdf->Cell(68,4,'ZSCMST-GTU-3.4.9.2',0,0,'L');
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(-154);
	$pdf->Cell(45,5,'HEALTH AND MEDICAL SERVICES',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: January 2010',0,0,'L');
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(-154);
	$pdf->Cell(45,20,'MEDICAL CERTIFICATE',0,0,'C');
	$pdf->Line(82,$pdf->getY()+12,125.5,$pdf->getY()+12);
	$pdf->Ln(2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: 0',0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: 0',0,0,'L');
	$pdf->Ln(18);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(82,5,'To whom it may concern: ',0,0,'C');
	
	$pdf->Ln(13);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'This is to certify that Mr./Ms.',0,0,'L');
	$pdf->Cell(45);
	$pdf->Cell(57,5, $data['MedicalCertificate']['student_name'] != null ? strtoupper($data['MedicalCertificate']['student_name']) : strtoupper($data['MedicalCertificate']['employee_name']),0,0,'L');
	
	$pdf->Line(73,$pdf->getY()+4.5,128,$pdf->getY()+4.5);
	// $pdf->Cell(-17);
	$pdf->Cell(5,5,'a',0,0,'L');
	// $pdf->Cell(60);
	// $pdf->SetY($pdf->getY()+6);
	// $pdf->Cell(19.5);
	$pdf->Cell(45.5,5,$data['CollegeProgram']['code'].'/'.$data['YearLevelTerm']['year'],0,0,'L');
	$pdf->Line(135,$pdf->getY()+4.5,170,$pdf->getY()+4.5);
	$pdf->Ln(6);
	$pdf->Cell(19);
	$pdf->Cell(10.5,5,'(course & year) student has been examined by a physician and  was found to be',0,0,'L');
	
	
	$pdf->Ln(6);
	$pdf->Cell(67,5,'',0,0,'L');
	
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(-67);
	$pdf->Cell(19,5.5,'phisically fit.',0);
	$pdf->Ln(13);
	$pdf->Cell(19,5,'',0,0,'L');
	
	$pdf->Cell(19,5.5,'Issued upon the request of the student for whatever purpose it may serve.',0);
	
	$pdf->Ln(12.5);
	$pdf->Line(62,$pdf->getY()+12,146.5,$pdf->getY()+12);
	$pdf->SetY($pdf->getY()+13);
	$pdf->Cell(98);
	$pdf->Cell(3.5,5,'Physician',0,0,'C');
	
	$pdf->output();
	exit();

  }

  public function referralRecommendation(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(ReferralRecommendation.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(ReferralRecommendation.date) >= '$start' AND DATE(ReferralRecommendation.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND ReferralRecommendation.status = $status";



	}


	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $employee_id = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND ReferralRecommendation.student_id = $employee_id";

	}

	

	$tmpData = $this->ReferralRecommendations->getAllReferralRecommendationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'REFERRAL RECOMMENDATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(95,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'DATE',1,0,'C',1);
	$pdf->Cell(70,5,'COMPLAINTS',1,0,'C',1);
	$pdf->Cell(80,5,'RECOMMENDATIONS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,95,55,70,80));
	$pdf->SetAligns(array('C','C','L','C','L','L'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'] != null ? strtoupper($data['student_name']) : strtoupper($data['employee_name']),

		  fdate($data['date'],'m/d/Y'),

		  $data['complaints'],  

		  $data['recommendations'],


		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

 public function referralRecommendationForm($id = null){

	$office_reference = $this->Global->OfficeReference('Referral Recommendation');

	$data['ReferralRecommendation'] = $this->ReferralRecommendations->find()

		->contain([

			'Students',

			'NurseProfiles'

		])

		->where([

			'ReferralRecommendations.visible' => 1,

			'ReferralRecommendations.id' => $id

		])

		->first();


		$data['Student'] = $data['ReferralRecommendation']['student'];

		$data['NurseProfile'] = $data['ReferralRecommendation']['nurse_profile'];

		unset($data['ReferralRecommendation']['student']);

		unset($data['ReferralRecommendation']['nurse_profile']);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
		
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,4,5);
	$pdf->AddPage("P", "A4", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11.5);
	// $pdf->Image($this->base .'/assets/img/referral_recommendation_form.png',0,0,210,297);
	$pdf->Image($this->base .'/assets/img/zam.png',7,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',180,10,20,25);
	$pdf->Ln(11.5);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5.5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777  http://www.zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->SetLineWidth(0.7);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(165.7,$pdf->GetY() + 9,31,13);
	$pdf->Ln(10);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3,5,'',0,0,'L');
	$pdf->Cell(65,3.5,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');

	$pdf->SetFont("Times", 'B', 13);
	$pdf->Cell(-258,3.5,'HEALTH AND MEDICAL SERVICES',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3, 4.5,'',0,0,'L');
	$pdf->Cell(65,2,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(-256,17,'MEDICAL-DENTAL REFERRAL/ RECOMMENDATION',0,0,'C');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3,4.5,'',0,0,'L');
	$pdf->Cell(65,3.5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3,4.5,'',0,0,'L');
	$pdf->Cell(65,3.5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');

	$pdf->Ln(16.5);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(19.3,5,'',0,0,'L');
	$pdf->Cell(25,5,'To  whom   it  may  concern:',0,0,'L');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(32,3,'',0,0,'L');
	$pdf->Cell(10,3,'This is to refer to you',0,0,'L');
	$pdf->Cell(145,3,$data['ReferralRecommendation']['student_name'],0,0,'C');
	$pdf->Cell(-23,3,'who',0,0,'C');
	$pdf->Line(72, $pdf->getY()+3, 176, $pdf->getY()+3);

	$pdf->SetFont("Arial", '', 7);
	$pdf->Ln(5);
	$pdf->Cell(233,3,'(Name of Client/ Age/ Course & Year/ Section)',0,0,'C');
	$pdf->Ln(3);

	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(9,5,'visited the clinic with the chief complaints of',0,0,'L');
	$pdf->Cell(200,5,$data['ReferralRecommendation']['complaints'],0,0,'C');
	$pdf->Line(94, $pdf->getY()+4, 182, $pdf->getY()+4);
	$pdf->Ln(8);

	$pdf->SetFont("Arial", '', 10);
	$pdf->Line(112,$pdf->getY()+4,182,$pdf->getY()+4);
	$pdf->Line(25,$pdf->getY()+13,182,$pdf->getY()+13);
	$pdf->Cell(19,1,'',0,0,'C');
	$pdf->MultiCell(173,5.5,'Medications ( ) given ( ) not given. He/she is advised to '.$data['ReferralRecommendation']['recommendations'],0, 'L');
	
	if($pdf->GetY() == 114.5){
	  $pdf->Ln(15);
	}elseif($pdf->GetY() == 120){
	  $pdf->Ln(9);
	}
	// elseif($pdf->GetY() >= 125.5){
	//   $pdf->Ln(4);
	// }
	$pdf->Ln(20);
	$pdf->Cell(117);
	$pdf->Cell(60,5,$data['NurseProfile']['name'],0,0,'C');
	$pdf->Ln(2);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(9,5,'Thank you.',0,0,'L');



	$pdf->Ln(9);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Line(120,$pdf->getY(),184,$pdf->getY());
	$pdf->Cell(129.5,5,'',0,0,'L');
	$pdf->Cell(35,7,'Signature of College Dentist/Nurse',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(48,6,'______________________________________________________________________________',0,0,'L');
	
	$pdf->Ln(7);
	$pdf->Image($this->base .'/assets/img/zam.png',7,$pdf->GetY()+5,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',180,$pdf->GetY()+5,20,25);
	$pdf->Ln(11.5);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5.5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777  http://www.zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->SetLineWidth(0.7);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(165.7,$pdf->GetY() + 9,31,13);
	$pdf->Ln(10);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3,5,'',0,0,'L');
	$pdf->Cell(65,3.5,'ZSCMST - ' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');

	$pdf->SetFont("Times", 'B', 13);
	$pdf->Cell(-258,3.5,'HEALTH AND MEDICAL SERVICES',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3, 4.5,'',0,0,'L');
	$pdf->Cell(65,2,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(-256,17,'MEDICAL-DENTAL REFERRAL/ RECOMMENDATION',0,0,'C');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3,4.5,'',0,0,'L');
	$pdf->Cell(65,3.5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(162.3,4.5,'',0,0,'L');
	$pdf->Cell(65,3.5,'Revision Status: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');

	$pdf->Ln(16.5);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(19.3,5,'',0,0,'L');
	$pdf->Cell(25,5,'To  whom   it  may  concern:',0,0,'L');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(32,3,'',0,0,'L');
	$pdf->Cell(10,3,'This is to refer to you',0,0,'L');
	$pdf->Cell(145,3,$data['ReferralRecommendation']['student_name'],0,0,'C');
	$pdf->Cell(-23,3,'who',0,0,'C');
	$pdf->Line(72, $pdf->getY()+3, 176, $pdf->getY()+3);

	$pdf->SetFont("Arial", '', 7);
	$pdf->Ln(5);
	$pdf->Cell(233,3,'(Name of Client/ Age/ Course & Year/ Section)',0,0,'C');
	$pdf->Ln(3);

	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(9,5,'visited the clinic with the chief complaints of',0,0,'L');
	$pdf->Cell(200,5,$data['ReferralRecommendation']['complaints'],0,0,'C');
	$pdf->Line(94, $pdf->getY()+4, 182, $pdf->getY()+4);
	$pdf->Ln(8);

	$pdf->SetFont("Arial", '', 10);
	$pdf->Line(112,$pdf->getY()+4,182,$pdf->getY()+4);
	$pdf->Line(25,$pdf->getY()+13,182,$pdf->getY()+13);
	// $pdf->Line(25,$pdf->getY()+15,197,$pdf->getY()+15);
	$pdf->Cell(19,1,'',0,0,'C');
	$pdf->MultiCell(173,5.5,'Medications ( ) given ( ) not given. He/she is advised to '.$data['ReferralRecommendation']['recommendations'],0, 'L');

	if($pdf->GetY() == 114.5){
	  $pdf->Ln(15);
	}elseif($pdf->GetY() == 120){
	  $pdf->Ln(9);
	}
	// elseif($pdf->GetY() >= 125.5){
	//   $pdf->Ln(4);
	// }
	$pdf->Ln(16);
	$pdf->Cell(117);
	$pdf->Cell(60,5,$data['NurseProfile']['name'],0,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(9,5,'Thank you.',0,0,'L');

	$pdf->Ln(14);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Line(120,$pdf->getY(),184,$pdf->getY());
	$pdf->Cell(129.5,5,'',0,0,'L');
	$pdf->Cell(35,7,'Signature of College Dentist/Nurse',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(48,6,'______________________________________________________________________________',0,0,'L');

	
	$pdf->output();
	exit();

  }

  public function dental(){
	
	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Dental.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Dental.date) >= '$start' AND DATE(Dental.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}


	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  // var_dump($status);

	  $conditions['status'] = "AND Dental.status = $status";

	}

	

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

		$per_student = $this->request->getQuery('per_student');

		$employee_id = $this->Auth->user('studentId');

		if (!empty($employee_id)) {

			$conditions['studentId'] = "AND Dental.student_id = $employee_id";

		}

	}


	$tmpData = $this->Dentals->getAllDentalPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'DENTAL INFORMATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'No.',1,0,'C',1);
	$pdf->Cell(50,5,'CODE',1,0,'C',1);
	$pdf->Cell(150,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(45,5,'DATE',1,0,'C',1);
	$pdf->Cell(45,5,'COURSE',1,0,'C',1);
	$pdf->Cell(40,5,'YEAR',1,0,'C',1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,150,45,45,40));
	$pdf->SetAligns(array('C','C','L','C','C','C'));
	$conditions = array();

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  strtoupper($data['student_name']),

		  fdate($data['date'],'m/d/Y'),

		  $data['program_code'],  

		  $data['year'],
		  
		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }


   public function dentalForm($id = null){

	$office_reference = $this->Global->OfficeReference('Dental');

	$data['Dental'] = $this->Dentals

	  ->find()

	  ->contain([

		  'DentalImages' => [

			  'conditions' => ['DentalImages.visible' => 1]

		  ],

		  'CollegePrograms' => [

			  'conditions' => ['CollegePrograms.visible' => 1]

		  ]

	  ])

	  ->where([

		  'Dentals.visible' => 1,

		  'Dentals.id' => $id

	  ])

	  ->first();

	  // var_dump($id);


	$data['DentalImage'] = $data['Dental']['dental_images'];

	unset($data['Dental']['dental_images']);

	$data['CollegeProgram'] = $data['Dental']['college_program'];

	unset($data['Dental']['college_program']);

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 9);
	// $pdf->Image($this->base .'/assets/img/dental_form1.png',0,0,215.9,355.6);
	$pdf->Image($this->base .'/assets/img/zam.png',20,6,20,20);
	$pdf->Image($this->base .'/assets/img/iso.png',178,6,15,20);
	$pdf->Ln(3);
	$pdf->SetFont("Times", 'B', 9.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(8);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(167,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(114,5,'',0,0,'R');
	$pdf->Cell(68,5,'Adopted Date: '. @$office_reference['OfficeReference']['adopted'],0,0,'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(123,5,'',0,0,'R');
	$pdf->Cell(59,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'R');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(126,5,'',0,0,'R');
	$pdf->Cell(60,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'R');
	$pdf->Ln(1);
	$pdf->SetFont("Arial", 'U', 10);
	$pdf->Cell(0,5,'DENTAL EXAMINATION RECORD',0,0,'C');
	$pdf->Ln(1);
	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'NAME: ',0,0,'L');
	$pdf->Cell(65,5,$data['Dental']['student_name'],0,0,'L');
	$pdf->Line(25,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(47,5,'',0,0,'L');
	$pdf->Cell(15,5,'Date: ',0,0,'L');
	$pdf->Cell(65,5,$data['Dental']['date']->format('m/d/Y'),0,0,'L');
	$pdf->Line(190,$pdf->getY()+5,135,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(29,5,'COURSE AND YEAR: ',0,0,'L');
	$pdf->Cell(47,5,strtoupper($data['Dental']['year']." - ".$data['CollegeProgram']['code']),0,0,'R');
	$pdf->Line(47,$pdf->getY()+5,90,$pdf->getY()+5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(38,5,'',0,0,'L');
	$pdf->Cell(12,5,'AGE: ',0,0,'L');
	$pdf->Cell(65,5,$data['Dental']['age'],0,0,'L');
	$pdf->Line(150,$pdf->getY()+5,135,$pdf->getY()+5);
	$pdf->Ln(13);
	$pdf->SetFont("Arial", 'U', 12);
	$pdf->Cell(0,5,'Medical History',0,0,'C');
	$pdf->Ln(15);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(0,5,'Please "X" each box if the answer is YES, leave blank  if NO',0,0,'L');
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(0,5,'Have you had...',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['exam'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'A recent physical exam',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['sin'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Sinusitis',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['hea'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Any heart problem',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['dia'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Diabetes',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['high'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'High blood pressure',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['epi'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Epilepsy',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['low'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Low blood pressure',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['mal'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Malignancies',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['cir'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Circulatory problems',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['rheu'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Rheumatic Fever',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['nerv'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Nervous problems',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['thy'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Thyroid',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['rad'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Radiation Treatments',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['tb'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Tuberculosis',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['ex'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Excessive Breathing',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['hep'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Hepatitis',0,0,'L');
	$pdf->SetX(100);

	$pdf->Ln(8);
	$pdf->Cell(22,5,'',0,0,'L');
	$check = "";
	if($data['Dental']['ane'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Anemia',0,0,'L');
	$pdf->SetX(100);
	$pdf->Cell(15,5,'',0,0,'L');
	if($data['Dental']['ven'] == true)
	  $check = "8"; else $check = "";
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(32,5,'Venereal disease',0,0,'L');
	$pdf->Ln(15);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(0,5,'On previous dental visits:',0,0,'L');
	$pdf->Ln(6);

	$pdf->Cell(0,5,'Have you had any outward reaction during or after dental procedure?',0,0,'L');
	$pdf->Ln(5);
	$pdf->Line(11,$pdf->getY()+5,205,$pdf->getY()+5);
	$pdf->Ln(6);

	$pdf->Cell(0,5,'Were X-ray given?',0,0,'L');
	$pdf->Line(43,$pdf->getY()+5,205,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Cell(0,5,'Were there any special problems?',0,0,'L');
	$pdf->Line(70,$pdf->getY()+5,205,$pdf->getY()+5);
	$pdf->Ln(10);
	$pdf->Cell(0,5,'ALLERGY TO:',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Cell(0,5,'Penicillin',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Cell(0,5,'Local Aesthetics (Novacain, Procaine, etc.)',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Cell(0,5,'Any other, please specify',0,0,'L');
	$pdf->Line(58 ,$pdf->getY()+5,205,$pdf->getY()+5);
	$pdf->Ln(10);
	$pdf->Cell(0,5,'Please describe any current medical treatment, including drugs, impending operations, pregnancies, or other',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(0,5,'information regarding your present health status that the doctor should be aware of it',0,0,'L');
	$pdf->Ln(4);
	$pdf->Line(10,$pdf->getY()+5,205,$pdf->getY()+5);
	$pdf->Ln(7);
	$pdf->Line(10,$pdf->getY()+5,205,$pdf->getY()+5);
	$pdf->Ln(13);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->Cell(0,5,'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',0,0,'c');
	$pdf->Ln(12);
	$pdf->SetFont("Arial", 'U', 13);
	$pdf->Cell(0,5,'Medical History',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(0,5,'CHIEF COMPLAINTS: ',0,0,'L');
	$pdf->Line(58,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(0,5,'HISTORY OF CHIEF COMPLAINTS: ',0,0,'L');
	$pdf->Line(80,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(0,5,'CLINICAL FINDINGS: ',0,0,'L');
	$pdf->Line(58,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(0,5,'X-RAY: ',0,0,'L');
	$pdf->Line(35,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(0,5,'DIAGNOSIS: ',0,0,'L');
	$pdf->Line(43,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(0,5,'TREATMENT: ',0,0,'L');
	$pdf->Line(43,$pdf->getY()+5,180,$pdf->getY()+5);
	$pdf->Ln(13);
	$pdf->Cell(115,5,'',0,0,'L');
	$pdf->Cell(0,5,'DR. CAROLINE O. GIMONY, DMD',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(130,5,'',0,0,'L');
	$pdf->Cell(0,5,'College Dentist',0,0,'L');
	$pdf->SetMargins(10,10,10);
	$pdf->AddPage("P", "Legal", 0);
	// $pdf->Image($this->base .'/assets/img/dental_form2.png',0,0,215.9,355.6);

	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(35,5,'',0,0,'L');
	$pdf->Cell(10,5,'ORAL HEALTH CONDITION',0,0,'C');
	$pdf->Cell(101,5,'',0,0,'L');
	$pdf->Cell(10,5,'DENTAL HEALTH CONDITION',0,0,'C');
	$pdf->Ln(10);

	  $dentalImages = [];

	  if (!empty($data['DentalImage'])) {
		  foreach ($data['DentalImage'] as $image) {
			  if (!is_null($image['images'])) {
				  $dentalImages[] = [
					  'imageSrc' => '/uploads/dental/' . $id . '/' . $image['images'],
					  'name' => $image['images'],
					  'id' => $image['student_profile_id'] ?? null,
				  ];
			  }
		  }
	  }

	  function isImageFile($file)
		{
			$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
			$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			return in_array($fileExtension, $allowedExtensions) && getimagesize('../webroot' . $file['imageSrc']);
		}

		$xPosition = 125;
		$yPosition = 30;
		$imageCount = 0;
		$imageLimit = 2; // Set the limit to 2 images

		if (!empty($dentalImages)) {
			foreach ($dentalImages as $img) {
				if (isImageFile($img)) {
					$imageCount++;
					$pdf->Image($this->base . $img['imageSrc'], $xPosition, $yPosition, 70, 35);
					$yPosition += 37;
					if ($imageCount == $imageLimit) {
						break; // Stop adding images after reaching the limit
					}
					if ($imageCount % 2 === 0) {
						// $xPosition = 115;
						$yPosition += 37;
					}
				}
			}
		}

	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(41,8,' DATE:',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CARIES',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' GINGIVITIS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' P. POCKETS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' DEBRIS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CALCULUS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' NEOPLASM',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CLEFT LIP',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' OTHERS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->SetFont("Arial", 'B', 8.5);
	$pdf->Ln(70);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(9,5,utf8_decode('Ø'),0,0,'L');
	$pdf->Cell(10,5,'CAVITY',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(10,5,'O',0,0,'L');
	$pdf->Cell(10,5,'FILLING',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(19,5,'/',0,0,'L');
	$pdf->Cell(10,5,'INDICATED FOR EXO',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(13,5,'X',0,0,'L');
	$pdf->Cell(10,5,'EXTRACTED',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(11,5,'S',0,0,'L');
	$pdf->Cell(10,5,'SEALANT',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(15,5,'T.F.',0,0,'L');
	$pdf->Cell(10,5,'TEMP. FILLING',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(13,5,'UN',0,0,'L');
	$pdf->Cell(10,5,'UNRUPTED',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(13,5,'3',0,0,'L');
	$pdf->SetFont("Arial", 'B', 8.5);
	$pdf->Cell(10,5,'CARIES FREE',0,0,'C');


	$pdf->output();
	exit();

  }

  public function propertyLog(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search') != null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(PropertyLog.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if ($this->request->getQuery('startDate') != null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery['endDate'];

	  $conditions['date'] = " AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}
	$conditions['type'] = '';

	if ($this->request->getQuery('type') != null) {

	  $type = $this->request->getQuery('type');

	  $conditions['type'] = "AND PropertyLog.type = '$type'";

	}

	$tmpData = $this->PropertyLogs->getAllPropertyLogPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PROPERTY LOG',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(40, 5, 'PROPERTY NAME', 1, 0, 'C', 1);
	$pdf->Cell(35, 5, 'DATE', 1, 0, 'C', 1);
	$pdf->Cell(40, 5, 'MANUFACTURING DATE', 1, 0, 'C', 1);
	$pdf->Cell(30, 5, 'BATCH NUMBER', 1, 0, 'C', 1);
	$pdf->Cell(35, 5, 'EXPIRATION DATE', 1, 0, 'C', 1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,40,35,40,30,35));
	$pdf->SetAligns(array('C','C','C','C','C','C'));
 
	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  strtoupper($data['property_name']),

		  fdate($data['date'],'m/d/Y'),

		  fdate($data['manufacturing_date'],'m/d/Y'),

		  strtoupper($data['batch_no']),

		  fdate($data['expiration_date'],'m/d/Y'),

		));

	  }
	 
	}

	else{
	 
	  $pdf->Cell(195,5,'No data available.',1,1,'C');
  
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+85,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+111,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);

	$pdf->output();
	exit();

  }

  public function studentMember(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('college')) {

	  $college_id = $this->request->getQuery('college');

	  $conditions['advSearch'] = "AND LearningResourceMember.college_id = $college_id";

	}

	if ($this->request->getQuery('program')) {

	  $program_id = $this->request->getQuery('program');

	  $conditions['advSearch'] = "AND LearningResourceMember.program_id = $program_id";

	}

	$conditions['classification'] = '';

	if ($this->request->getQuery('classification')) {

	  $classification = $this->request->getQuery('classification');

	  $conditions['classification'] = "AND LearningResourceMember.classification = '$classification'";

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) >= '$start' AND DATE(LearningResourceMember.date) <= '$end'";

	}

	$dataTable = $this->LearningResourceMembers;

	$tmpData = $dataTable->getAllLearningResourceMemberPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam2.png',70,10,25,25);
	$pdf->Image($this->base.'/assets/img/iso.png',260,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT MEMBERS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(40,5,'LIBRARY ID NUMBER',1,0,'C',1);
	$pdf->Cell(50,5,'MEMBER NAME',1,0,'C',1);
	$pdf->Cell(50,5,'PATRON TYPE',1,0,'C',1);
	$pdf->Cell(100,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(50,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Cell(40,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,40,50,50,100,50,40));
	$pdf->SetAligns(array('C','C','L','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['library_id_number'],

		  $data['student_name'],

		  $data['classification'],

		  $data['college_program'],

		  $data['year_level'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function adminMember(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('college')) {

	  $college_id = $this->request->getQuery('college');

	  $conditions['advSearch'] = "AND LearningResourceMember.college_id = $college_id";

	}

	if ($this->request->getQuery('program')) {

	  $program_id = $this->request->getQuery('program');

	  $conditions['advSearch'] = "AND LearningResourceMember.program_id = $program_id";

	}

	$conditions['classification'] = '';

	if ($this->request->getQuery('classification')) {

	  $classification = $this->request->getQuery('classification');

	  $conditions['classification'] = "AND LearningResourceMember.classification = '$classification'";

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) >= '$start' AND DATE(LearningResourceMember.date) <= '$end'";

	}

	$dataTable = $this->LearningResourceMembers;

	$tmpData = $dataTable->getAllLearningResourceMemberPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "letter", 0);
	$pdf->Image($this->base.'/assets/img/zam2.png',35,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'ADMIN MEMBERS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(40,5,'LIBRARY ID NUMBER',1,0,'C',1);
	$pdf->Cell(60,5,'MEMBER NAME',1,0,'C',1); 
	$pdf->Cell(130,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(30,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,40,60,130,30));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['library_id_number'],

		  $data['admin_name'],

		  $data['college_program'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(270,5,'No data available.',1,1,'C');

	}

	$pdf->output();

	exit();

  }

  public function facultyMember(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('college')) {

	  $college_id = $this->request->getQuery('college');

	  $conditions['advSearch'] = "AND LearningResourceMember.college_id = $college_id";

	}

	if ($this->request->getQuery('program')) {

	  $program_id = $this->request->getQuery('program');

	  $conditions['advSearch'] = "AND LearningResourceMember.program_id = $program_id";

	}

	$conditions['classification'] = '';

	if ($this->request->getQuery('classification')) {

	  $classification = $this->request->getQuery('classification');

	  $conditions['classification'] = "AND LearningResourceMember.classification = '$classification'";

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) >= '$start' AND DATE(LearningResourceMember.date) <= '$end'";

	}

	$dataTable = $this->LearningResourceMembers;

	$tmpData = $dataTable->getAllLearningResourceMemberPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'FACULTY MEMBERS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'LIBRARY ID NUMBER',1,0,'C',1);
	$pdf->Cell(100,5,'MEMBER NAME',1,0,'C',1);
	$pdf->Cell(50,5,'FACULTY STATUS',1,0,'C',1);
	$pdf->Cell(90,5,'OFFICE',1,0,'C',1);
	$pdf->Cell(45,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,50,100,50,90,45));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['library_id_number'],

		  $data['employee_name'],

		  $data['faculty_status'],

		  $data['office'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();

	exit();

  }

  public function medical_consent(){
	
	$conditions = array();
  
	$conditions['search'] = '';
  
	if(isset($this->request->query['search'])){
  
	  $search = $this->request->query['search'];
  
	  $search = strtolower($search);
  
	  $conditions['search'] = $search;
  
	}
  
	$conditions['date'] = '';
  
	if (isset($this->request->query['date'])) {
  
	  $search_date = $this->request->query['date'];
  
	  $conditions['date'] = " AND DATE(MedicalConsent.date) = '$search_date'";
  
	}  
  
	//advance search
  
	if (isset($this->request->query['startDate'])) {
  
	  $start = $this->request->query['startDate']; 
  
	  $end = $this->request->query['endDate'];
  
	  $conditions['date'] = " AND DATE(MedicalConsent.date) >= '$start' AND DATE(MedicalConsent.date) <= '$end'";
  
	}

	$conditions['studentId'] = '';

	if (isset($this->request->query['per_student'])) {

	  $per_student = $this->request->query['per_student'];
	  
	  $student_id = $this->Session->read('Auth.User.studentId');

	  $conditions['studentId'] = "AND MedicalConsent.student_id = $student_id";

	}
  
	$tmpData = $this->MedicalConsent->query($this->MedicalConsent->getAllMedicalConsent($conditions));
  
	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'MEDICAL CONSENT INFORMATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'No.',1,0,'C',1);
	$pdf->Cell(50,5,'CODE',1,0,'C',1);
	$pdf->Cell(120,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(120,5,'GUARDIAN',1,0,'C',1);
	$pdf->Cell(45,5,'DATE',1,0,'C',1);
  
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,50,120,120,45));
	$pdf->SetAligns(array('C','C','L','L','C'));
	$conditions = array();
	if(!empty($tmpData)){
  
	  foreach ($tmpData as $key => $data){
	
		$tmp = $data['MedicalConsent'];
	
		$pdf->RowLegalL(array(
	
		  $key + 1,
	
		  $tmp['code'],
	
		  $tmp['student_name'],
	
		  $tmp['guardian'],
	
		  fdate($tmp['date'],'m/d/Y'),

		));
  
	  }
  
	}else{
  
	  $pdf->Cell(345,5,'No data available.',1,1,'C');
  
	}
  
	$pdf->output();
	exit();

  }

  public function medical_consent_form($id = null){

	$data = $this->MedicalConsent->find('first', array(
  
	  'contain' => array(
   
		'Student',
   
		'Course'
   
	  ),
   
	  'conditions' => array(
   
		'MedicalConsent.visible' => true,
   
		'MedicalConsent.id' => $id,
   
	  )
   
	));

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 9);
	// $pdf->Image($this->base .'/assets/img/medicalconsent.png',0,0,215.9,355.6);
	$pdf->Ln(14);
	$pdf->Image($this->base .'/assets/img/zam.png',8,21,30,30);
	$pdf->Image($this->base .'/assets/img/iso.png',180,22,25,30);
	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph',0,0,'C');
	$pdf->Rect(170,55,32,15.5);
	$pdf->Ln(8);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(162,5,'',0,0,'L');
	$pdf->Cell(60,25,'ZSCMST-MDU-3.4.4-3',0,0,'L');
	$pdf->Ln(3);
	$pdf->Cell(129.5,5,'',0,0,'R');
	$pdf->Cell(60,25,'Adopted Date: 05-2005',0,0,'R');
	$pdf->Ln(3);
	$pdf->Cell(140.5,5,'',0,0,'R');
	$pdf->Cell(51,25,'Revision Date: May 2015',0,0,'R');
	$pdf->Ln(3);
	$pdf->Cell(129,5,'',0,0,'R');
	$pdf->Cell(55,25,'Revision Status: 1',0,0,'R');
	$pdf->Ln(1);
	$pdf->SetFont("Arial", 'B', 13);
	$pdf->Cell(0,5,'HEALTH AND MEDICAL SERVICES',0,0,'C');
	$pdf->Ln(12);
	$pdf->SetFont("Arial", 'U', 13);
	$pdf->Cell(0,5,'CONSENT FOR MEDICAL/DENTAL PROCEDURE',0,0,'C');
	$pdf->Ln(18);
	$pdf->SetFont("Arial", '', 12);
	$pdf->Line(30,$pdf->getY()+5,115,$pdf->getY()+5);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(10,5,'I,',0,0,'L');
	$pdf->Cell(90,5,$data['MedicalConsent']['guardian'],0,0,'L');
	$pdf->Cell(60,5,' father/       mother/      guardian       of',0,0,'L');
	$pdf->Line(26,$pdf->getY()+12,130,$pdf->getY()+12);
	$pdf->Ln(7);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(1,5,$data['MedicalConsent']['student_name']." ".$data['Course']['code']." - ".$data['MedicalConsent']['year'],0,0,'L');
	$pdf->Cell(105,5,'',0,0,'L');
	$pdf->Cell(60,5,'(Name of Student, Course and Year)',0,0,'L');
	$pdf->Ln(8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'do hereby agree to submit my son/ daughter/ ward to undergo Medical/ Dental/ procedure/s',0,0,'L');
	$pdf->Ln(8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'to be done at the Zamboanga State College of Marine Sciences and Technology Clinic.',0,0,'L');
	$pdf->Ln(31);
	$pdf->Line(65,$pdf->getY()+5,150,$pdf->getY()+5);
	$pdf->Ln(7);
	$pdf->Cell(53,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'Signature of Parent/Guardian over printed name',0,0,'L');
	$pdf->Ln(23);
	$pdf->Line(10,$pdf->getY()+5,205,$pdf->getY()+5);
	$pdf->Ln(18);


	$pdf->Image($this->base .'/assets/img/zam.png',8,185,30,30);
	$pdf->Image($this->base .'/assets/img/iso.png',180,185,25,30);
	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(6);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph',0,0,'C'); 
	$pdf->Rect(170,55,32,15.5);
	$pdf->Ln(8);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(162,5,'',0,0,'L');
	$pdf->Cell(60,25,'ZSCMST-MDU-3.4.4-3',0,0,'L');
	$pdf->Ln(3);
	$pdf->Cell(129.5,5,'',0,0,'R');
	$pdf->Cell(60,25,'Adopted Date: 05-2005',0,0,'R');
	$pdf->Ln(3);
	$pdf->Cell(140.5,5,'',0,0,'R');
	$pdf->Cell(51,25,'Revision Date: May 2015',0,0,'R');
	$pdf->Ln(3);
	$pdf->Cell(129,5,'',0,0,'R');
	$pdf->Cell(55,25,'Revision Status: 1',0,0,'R');
	$pdf->Ln(1);
	$pdf->SetFont("Arial", 'B', 13);
	$pdf->Cell(0,5,'HEALTH AND MEDICAL SERVICES',0,0,'C');
	$pdf->Ln(12);
	$pdf->SetFont("Arial", 'U', 13);
	$pdf->Cell(0,5,'CONSENT FOR MEDICAL/DENTAL PROCEDURE',0,0,'C');
	$pdf->Ln(18);
	$pdf->SetFont("Arial", '', 12);
	$pdf->Line(30,$pdf->getY()+5,115,$pdf->getY()+5);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'I,',0,0,'L');
	$pdf->Cell(90,5,$data['MedicalConsent']['guardian'],0,0,'L');
	$pdf->Cell(60,5,' father/       mother/      guardian       of',0,0,'L');
	$pdf->Line(26,$pdf->getY()+12,102,$pdf->getY()+12);
	$pdf->Line(26,$pdf->getY()+12,130,$pdf->getY()+12);
	$pdf->Ln(7);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(1,5,$data['MedicalConsent']['student_name']." ".$data['Course']['code']." - ".$data['MedicalConsent']['year'],0,0,'L');
	$pdf->Cell(105,5,'',0,0,'L');
	$pdf->Cell(60,5,'(Name of Student, Course and Year)',0,0,'L');
	$pdf->Ln(8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'do hereby agree to submit my son/ daughter/ ward to undergo Medical/ Dental/ procedure/s',0,0,'L');
	$pdf->Ln(8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'to be done at the Zamboanga State College of Marine Sciences and Technology Clinic.',0,0,'L');
	$pdf->Ln(31);
	$pdf->Line(65,$pdf->getY()+5,150,$pdf->getY()+5);
	$pdf->Ln(7);
	$pdf->Cell(53,5,'',0,0,'L');
	$pdf->Cell(3.5,5,'Signature of Parent/Guardian over printed name',0,0,'L');
  
	$pdf->output();
	exit();

  }

  public function learning_resource_member(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) = '$search_date'"; 

	} 

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) >= '$start' AND DATE(LearningResourceMember.date) <= '$end'";

	}

	$tmpData = $this->LearningResourceMember->query($this->LearningResourceMember->getAllLearningResourceMember($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'LEARNING RESOURCE MEMBER',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(25,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(70,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'CONTACT NO',1,0,'C',1);
	$pdf->Cell(45,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,25,70,55,45));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['LearningResourceMember'];

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['LearningResourceMember']['code'],

		  strtoupper($data['LearningResourceMember']['student_name'] != null ? $data['LearningResourceMember']['student_name'] : $data['LearningResourceMember']['employee_name']),

		  $data['LearningResourceMember']['contact_no'],

		  fdate($data['LearningResourceMember']['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->output();

	exit();

  }

  public function bibliography(){

	$conditions = [];

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	}
	
	$tmpData = $this->Bibliographies->getAllBibliographyPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam2.png',70,10,25,25);
	$pdf->Image($this->base.'/assets/img/iso.png',260,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'BIBLIOGRAPHY',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(95,5,'TITLE',1,0,'C',1);
	$pdf->Cell(55,5,'MATERIAL TYPE',1,0,'C',1);
	$pdf->Cell(70,5,'COLLECTION TYPE',1,0,'C',1);
	$pdf->Cell(80,5,'PUBLISHED DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,95,55,70,80));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  strtoupper($data['title']),

		  $data['material_type'],  

		  $data['collection_type'],

		  fdate($data['date_of_publication'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function transferee(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search') != null){
  
	  $search = $this->request->getQuery('search');
   
	  $search = strtolower($search);
   
	  $conditions['search'] = $search;
   
	  $conditionsPrint .= '&search='.$search;
   
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {
 
	  $search_date = $this->request->getQuery('date');
 
	  $conditions['date'] = " AND DATE(Transferee.date) = '$search_date'"; 
 
	  $conditionsPrint .= '&date='.$search_date;
  
	}  

	//advance search

	if ($this->request->getQuery('startDate')) {
 
	  $start = $this->request->getQuery('startDate'); 
 
	  $end = $this->request->getQuery('endDate');
 
	  $conditions['date'] = " AND DATE(Transferee.date) >= '$start' AND DATE(Transferee.date) <= '$end'";
 
	  $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;
 
	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student') != null) {

	  $per_student = $this->request->getQuery('per_student');

	  $student_id = $this->Auth->user('studentId');

	  if ($student_id!=null) {

		$conditions['studentId'] = "AND Transferee.student_id = $student_id";

	  }

	}

	$tmpData = $this->Transferees->getAllTransfereePrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'SCHOOL TRANSFER REQUEST',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'STUDENT ID',1,0,'C',1);
	$pdf->Cell(75,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(35,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Cell(70,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(60,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(60,5,'APPLICATION DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,75,35,70,60,60));
	$pdf->SetAligns(array('C','L','L','C','C','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['student_no'],

		  strtoupper($data['full_name']),

		  $data['year'],  

		  $data['program'],

		  $data['email'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+188,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function listRequestedForm(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(RequestForm.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(RequestForm.date) >= '$start' AND DATE(RequestForm.date) <= '$end'";

	}
	
	$tmpData = $this->Reports->getAllRequestedFormPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF REQUESTED FORMS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,'STUDENT NUMBER',1,0,'C',1);
	$pdf->Cell(70,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(80,5,'REQUESTED FORM',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,30,70,80));
	$pdf->SetAligns(array('C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$forms = [];

	  if ($data['otr'] != null && $data['otr'] == 1) {
		  $forms[] = "Transcript of Records";
	  }

	  if ($data['cav'] != null && $data['cav'] == 1) {
		  $forms[] = "Certification Authentication Verification";
	  }

	  if ($data['cert'] != null && $data['cert'] == 1) {
		  $forms[] = "Certification";
	  }

	  if ($data['hon'] != null && $data['hon'] == 1) {
		  $forms[] = "Honorable Dismissal";
	  }

	  if ($data['authGrad'] != null && $data['authGrad'] == 1) {
		  $forms[] = "Authorization Graduate";
	  }

	  if ($data['authUGrad'] != null && $data['authUGrad'] == 1) {
		  $forms[] = "Authorization Undergraduate";
	  }

	  if ($data['dip'] != null && $data['dip'] == 1) {
		  $forms[] = "Diploma";
	  }

	  if ($data['rr'] != null && $data['rr'] == 1) {
		  $forms[] = "Red Ribbon";
	  }

	  if ($data['other'] != null && $data['rr'] == 1) {
		  $forms[] = $data['otherVal'];
	  }

	  $forms = implode(', ', $forms);

		$pdf->Cell(10);

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['student_name'],

		  $forms

		));

	  }

	}else{
	  $pdf->Cell(60);
	  $pdf->Cell(150,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+10,$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+200,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function requestedFormPayment (){

	$conditions = [];

	$conditionsPrint = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(RequestedFormPayment.created) = '$search_date'";

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(RequestedFormPayment.created) >= '$start' AND DATE(RequestedFormPayment.created) <= '$end'";

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND RequestedFormPayment.approve = $status";

	}
 
	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student') != null) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $studentId = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND RequestedFormPayment.student_id = $studentId";

	}
	
	$tmpData = $this->RequestedFormPayments->getAllRequestedFormPaymentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF REQUESTED FORMS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(20,5,'CODE',1,0,'C',1);
	$pdf->Cell(30,5,'STUDENT NUMBER',1,0,'C',1);
	$pdf->Cell(55,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(40,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(40,5,'CONTACT NUMBER',1,0,'C',1);
	$pdf->Cell(90,5,'COLLEGE PROGRAM',1,0,'C',1);
	$pdf->Cell(40,5,'REQUEST',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,20,30,55,40,40,90,40));
	$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->Cell(10);

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['student_no'],

		  $data['student_name'],

		  $data['email'],

		  $data['contact_no'],

		  $data['program'],

		  $data['request']

		));

	  }

	}else{
	  $pdf->Cell(60);
	  $pdf->Cell(150,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function studentApplication(){

	$conditions = [];

	if($this->request->getQuery('search') != null){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 
	}  

	//advance search

	if ($this->request->getQuery('startDate') != null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND StudentApplication.approve = $status";

	  if($status == 1){ //FOR APPROVED TAB OF STUDENT APPLICATION

		$conditions['status'] = "AND StudentApplication.approve <> 0";

	  }elseif($status == 'forRating'){ //RATING TAB OF CAT

		$conditions['status'] = "AND StudentApplication.approve = 1";

	  }

	}

	$conditions['rate'] = '';

	if ($this->request->getQuery('rate') != null) {

	  $rate = $this->request->getQuery('rate');

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}


	$conditions['order'] = '';

	if ($this->request->getQuery('order') != null){

	  $order = $this->request->getQuery('order');

	  $conditions['order'] = $order;

	  $conditionsPrint .= '&order='.$order;
	  
	}
	
	$tmpData = $this->StudentApplications->getAllStudentApplicationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);


	if($this->request->getQuery('status') == 'forRating'){

	  $status = 'FOR RATING';

	}else if($this->request->getQuery('status') == 3){

	  $status = 'FOR INTERVIEW';

	}else if($this->request->getQuery('status') == 4){

	  $status = 'QUALIFIED';

	}else{

	  $status = 'UNQUALIFIED';

	}

	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,$status.' STUDENT APPLICATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(105,5,' APPLICANT NAME',1,0,'C',1);
	$pdf->Cell(65,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(65,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(35,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Cell(30,5,'GENDER',1,0,'C',1);
	$pdf->Cell(35,5,'APPLICATION DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,105,65,65,35,30,35));
	$pdf->SetAligns(array('C','L','L','L','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  strtoupper($data['full_name']),

		  $data['email'],  

		  $data['address'],

		  $data['contact_no'],

		  $data['gender'],

		  fdate($data['application_date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);

	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+188,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function scholarshipApplicationList(){

	$conditions = [];

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}


	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(ScholarshipApplication.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ScholarshipApplication.date) >= '$start' AND DATE(ScholarshipApplication.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = " AND ScholarshipApplication.approve = $status";

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $studentId = $this->Session->read('Auth.User.studentId');

	  $conditions['studentId'] = " AND ScholarshipApplication.student_id = $studentId";

	}

	$conditions['program_id'] = "";

	if ($this->request->getQuery('program_id') != null) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND ScholarshipApplication.program_id = $program_id";

	}

	$conditions['year'] = "";

	if ($this->request->getQuery('year')!=null) {

	  $year = $this->request->getQuery('year'); 

	  if($year==1){
		$y1 = '1';
		$y2 = '2';
	  }else if($year==2){
		$y1 = '4';
		$y2 = '5';
	  }else if($year==3){
		$y1 = '7';
		$y2 = '8';
	  }else if($year==4){
		$y1 = '10';
		$y2 = '11';
	  }else if($year==5){
		$y1 = '13';
		$y2 = '14';
	  }

	  $conditions['year'] = " AND ScholarshipApplication.year_term_id = $year";

	}

	$conditions['scholarship'] = "";

	if ($this->request->getQuery('scholarship') != null) {

	  $scholarship = $this->request->getQuery('scholarship'); 

	  $conditions['scholarship'] = " AND ScholarshipApplication.scholarship_name_id = $scholarship";

	}
	
	$tmpData = $this->Reports->getAllListScholarPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);


	if($this->request->getQuery('status') == 0){

	  $status = 'PENDING';

	}else if($this->request->getQuery('status') == 1){

	  $status = 'APPROVED';

	}else{

	  $status = 'DISAPPROVED';

	}

	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,$status.' STUDENT APPLICATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,' CODE',1,0,'C',1);
	$pdf->Cell(70,5,' APPLICANT NAME',1,0,'C',1);
	$pdf->Cell(30,5,'DATE APPLIED',1,0,'C',1);
	$pdf->Cell(70,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(50,5,'SCHOLARSHIP NAME',1,0,'C',1);
	$pdf->Cell(25,5,'AGE',1,0,'C',1);
	$pdf->Cell(25,5,'SEX',1,0,'C',1);
	$pdf->Cell(35,5,'STATUS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,30,70,30,70,50,25,25,35));
	$pdf->SetAligns(array('C','C','L','C','C','C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  strtoupper($data['student_name']),

		  fdate($data['date'],'m/d/Y'),

		  $data['name'],

		  $data['scholarship_name'],

		  $data['age'],

		  $data['sex'],

		  'CONFIRMED'

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);

	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+188,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function activities(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search') != null){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(CalendarActivity.startDate) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate') != null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(CalendarActivity.startDate) >= '$start' AND DATE(CalendarActivity.endDate) <= '$end'";

	}

	$tmpData = $this->CalendarActivities->getAllCalendarActivityPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'ACTIVITIES',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'CODE',1,0,'C',1);
	$pdf->Cell(75,5,'TITLE',1,0,'C',1);
	$pdf->Cell(70,5,'START DATE',1,0,'C',1);
	$pdf->Cell(70,5,'END DATE',1,0,'C',1);
	$pdf->Cell(70,5,'REMARKS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,50,75,70,70,70));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['title'],

		  fdate($data['startDate'],'m/d/Y'),

		  fdate($data['endDate'],'m/d/Y'),

		  $data['remarks'],


		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();

  }

  public function classSchedule(){
	
	$conditions = array();
  
	$conditions['search'] = '';
  
	if($this->request->getQuery('search')){
  
	  $search = $this->request->getQuery('search');
  
	  $search = strtolower($search);
  
	  $conditions['search'] = $search;
  
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(ClassSchedule.created) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ClassSchedule.created) >= '$start' AND DATE(ClassSchedule.created) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}
  
	$tmpData = $this->ClassSchedules->getAllClassSchedulePrint($conditions);
  
	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'CLASS SCHEDULE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'No.',1,0,'C',1);
	$pdf->Cell(25,5,'CODE',1,0,'C',1);
	$pdf->Cell(70,5,'FACULTY NAME',1,0,'C',1);
	$pdf->Cell(80,5,'COLLEGE',1,0,'C',1);
	$pdf->Cell(80,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(40,5,'YEAR TERM',1,0,'C',1);
	$pdf->Cell(40,5,'SCHOOL YEAR',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,25,70,80,80,40,40));
	$pdf->SetAligns(array('C','C','L','L','L','C','C'));
	$conditions = array();
	if(count($tmpData)>0){
  
	  foreach ($tmpData as $key => $data){
	
		$pdf->RowLegalL(array(
	
		  $key + 1,
	
		  $data['code'],
	
		  strtoupper($data['faculty_name']),
	
		  $data['college'],

		  $data['program'],
  
		  $data['description'],

		  $data['school_year_start'].' - '.$data['school_year_end'],

		));
  
	  }
  
	}else{
  
	  $pdf->Cell(345,5,'No data available.',1,1,'C');
  
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();
  
	$pdf->output();
	exit();

  }

 public function illnessRecommendations(){
	
	$conditions = array();
  
	$conditions['search'] = '';
  
	if($this->request->getQuery('search')){
  
	  $search = $this->request->getQuery('search');
  
	  $search = strtolower($search);
  
	  $conditions['search'] = $search;
  
	}
  
	$tmpData = $this->IllnessRecommendations->getAllIllnessRecommendationPrint($conditions);

	$datas = new Collection($tmpData);
  
	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ILLNESS & RECOMMENDATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'No.',1,0,'C',1);
	$pdf->Cell(70,5,'AILMENT',1,0,'C',1);
	$pdf->Cell(115,5,'DESCRIPTION',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,70,115));
	$pdf->SetAligns(array('C','L','L'));
	$conditions = array();
	if(!$datas->isEmpty()){
  
	  foreach ($datas as $key => $data){
	
		$pdf->RowLegalL(array(
	
		  $key + 1,
	
		  strtoupper($data['ailment']),
	
		  strtoupper($data['description']),

		));
  
	  }
  
	}else{
  
	  $pdf->Cell(195,5,'No data available.',1,1,'C');
  
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+85,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+111,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);
  
	$pdf->output();
	exit();

  }

  public function prescription(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	
	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Prescription.date_added) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Prescription.date) >= '$start' AND DATE(Prescription.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->Prescriptions->getAllPrescriptionPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PRESCRIPTION',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	
	// Centering the table
	$tableWidth = 197.5; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);
	
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(110, 5, 'NAME', 1, 0, 'C', 1);
	$pdf->Cell(70,5,'DATE',1,0,'C',1);
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);
	

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,110,70,65,100));
	$pdf->SetAligns(array('C','C','C'));
	$tableWidth = 197.5; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);

	  // Resetting the left margin to default
	  
	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){


		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['name'],

		  fdate($data['date'],'m/d/Y'),

	
		));

	  }

	  $pdf->SetLeftMargin(0);

	}else{

   // Centering the table
   $tableWidth = 197.5; // Total width of the table
   $leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
   $pdf->SetLeftMargin($leftMargin);
   $pdf->Cell(195,5,'No data available.',1,1,'C');
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+10,$pdf->getY()+2,$pdf->getX()+94,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+118,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);

	$pdf->output();
	exit();

  }

  public function collection_type(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	
	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(CollectionType.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(CollectionType.date) >= '$start' AND DATE(CollectionType.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->CollectionType->query($this->CollectionType->getAllCollectionType($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'COLLECTION TYPE',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	
	// Centering the table
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);
	
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(182, 5, 'NAME', 1, 0, 'C', 1);
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);
	

	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,182,65,65,182));
	$pdf->SetAligns(array('C','C','C','C','C'));
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);

	  // Resetting the left margin to default
	  
	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['CollectionType'];


		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['name'],
	
		));

	  }

	  $pdf->SetLeftMargin(0);

	}else{

   // Centering the table
   $tableWidth = 180; // Total width of the table
   $leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
   $pdf->SetLeftMargin($leftMargin);
   $pdf->Cell(180,5,'No data available.',1,1,'C');
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);
	}

	$pdf->output();

	exit();

  }

  public function learning_resource_material_type(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	
	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(MaterialType.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(MaterialType.date) >= '$start' AND DATE(
		MaterialType.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->MaterialType->query($this->MaterialType->getAllMaterialType($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'MATERIAL TYPE',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	
	// Centering the table
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);
	
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(182, 5, 'NAME', 1, 0, 'C', 1);
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);
	

	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,182,65,65,182));
	$pdf->SetAligns(array('C','C','C','C','C'));
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);

	  // Resetting the left margin to default
	  
	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['MaterialType'];


		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['name'],
	
		));

	  }

	  $pdf->SetLeftMargin(0);

	}else{

   // Centering the table
   $tableWidth = 180; // Total width of the table
   $leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
   $pdf->SetLeftMargin($leftMargin);
   $pdf->Cell(180,5,'No data available.',1,1,'C');
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0)
	;
	}

	$pdf->output();
	
	exit();

  }

  public function consultation(){

	$conditions = [];

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND Consultation.status = $status";

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student') != null) {

	  $per_student = $this->request->getQuery('per_student');

	  $employee_id = $this->Auth->user('studentId');

	  if ($employee_id!=null) {

		$conditions['studentId'] = "AND Consultation.student_id = $employee_id";

	  }

	}

	$tmpData = $this->Consultations->getAllConsultationPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true; 
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'CONSULTATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(80,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'DATE',1,0,'C',1);
	$pdf->Cell(30,5,'AGE',1,0,'C',1);
	$pdf->Cell(30,5,'SEX',1,0,'C',1);
	$pdf->Cell(60,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(20,5,'HEIGHT',1,0,'C',1);
	$pdf->Cell(20,5,'WEIGHT',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,80,55,30,30,60,20,20));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'] != null ? strtoupper($data['student_name']) : strtoupper($data['employee_name']),

		  fdate($data['date'],'m/d/Y'),

		  $data['age'],  

		  $data['sex'],

		  $data['address'],

		  $data['height'],

		  $data['weight'],


		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function consultationForm($id = null){

	$office_reference = $this->Global->OfficeReference('Consultation');

	$data['Consultation'] = $this->Consultations->find()

	  ->contain([

		'Students',

		'ConsultationSubs' => [

		  'conditions' => ['ConsultationSubs.visible' => 1]

		]

	  ])

	  ->where([

		'Consultations.visible' => 1,

		'Consultations.id' => $id

	  ])

	->first();

	$data['ConsultationSub'] = $data['Consultation']['consultation_subs'];

	unset($data['Consultation']['consultation_subs']);

	$data['Consultation']['date'] = !is_null($data['Consultation']['date']) ? $data['Consultation']['date']->format('m/d/Y') : 'N/A';

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,8,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Arial", '', 11.5);
	$pdf->Image($this->base .'/assets/img/zam.png',8,11,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',180,13,18,21);
	$pdf->Ln(3.5);
	
	$pdf->Ln(4.5);
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph ',0,0,'C');
	$pdf->Ln(21);
	
	$pdf->Rect(165.5,$pdf->GetY() -7,31.5,13);
	$pdf->Ln(4);
	$pdf->SetY($pdf->getY()- 10.6);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(154);
	$pdf->Cell(68,4,'ZSCMST - ' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(-154);
	$pdf->Cell(45,5,'HEALTH AND MEDICAL SERVICES',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(-154);
	$pdf->Cell(45,20,'CONSULTATION FORM',0,0,'C');
	$pdf->Line(82,$pdf->getY()+12,125.5,$pdf->getY()+12);
	$pdf->Ln(2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(5);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(30,20,'NAME:',0,0,'L');
	$pdf->Ln(7.5);
	$pdf->Cell(20);
	$pdf->Cell(80,5,$data['Consultation']['student_name'] != null ? $data['Consultation']['student_name'] : $data['Consultation']['employee_name'],0,0,'L');
	$pdf->Line(22,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(-7.5);
	$pdf->Cell(108);
	$pdf->Cell(30,20,'DATE:',0,0,'L');
	$pdf->Ln(7.5);
	$pdf->Cell(140);

	$pdf->Cell(80,5,$data['Consultation']['date'],0,0,'L');
	$pdf->Line(123,$pdf->getY()+4,190,$pdf->getY()+4);

	$pdf->Ln(-2.5);
	$pdf->Cell(5);
	$pdf->Cell(30,20,'AGE:',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(20);
	$pdf->Cell(80,5,$data['Consultation']['age'],0,0,'L');
	$pdf->Line(20,$pdf->getY()+4,94,$pdf->getY()+4);

	$pdf->Ln(-2.5);
	$pdf->Cell(5);
	$pdf->Cell(30,20,'SEX:',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(20);
	$pdf->Cell(80,5,$data['Consultation']['sex'],0,0,'L');
	$pdf->Line(20,$pdf->getY()+4,94,$pdf->getY()+4);

	$pdf->Ln(-7);
	$pdf->Cell(108);
	$pdf->Cell(30,20,'HEIGHT:',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(140);
	$pdf->Cell(80,5,$data['Consultation']['height'],0,0,'L');
	$pdf->Line(130,$pdf->getY()+4,180,$pdf->getY()+4);

	$pdf->Ln(-2.5);
	$pdf->Cell(5);
	$pdf->Cell(30,20,'ADDRESS:',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(30);
	$pdf->Cell(80,5,$data['Consultation']['address'],0,0,'L');
	$pdf->Line(30,$pdf->getY()+4,94,$pdf->getY()+4);

	$pdf->Ln(-7);
	$pdf->Cell(108);
	$pdf->Cell(30,20,'WEIGHT:',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(140);
	$pdf->Cell(80,5,$data['Consultation']['weight'],0,0,'L');
	$pdf->Line(130,$pdf->getY()+4,180,$pdf->getY()+4);

	

	$pdf->Ln(15);
	$pdf->Cell(3);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(33,5,'DATE',1,0,'C',1);
	$pdf->Cell(60,5,'CHIEF COMPLAINTS',1,0,'C',1);
	$pdf->Cell(47,5,'TREATMENTS',1,0,'C',1);
	$pdf->Cell(45,5,'REMARKS',1,0,'C',1);
	$pdf->Ln();
	
	$pdf->SetFont("Arial", '', 8);
	
	$pdf->SetWidths(array(33,60,47,45));
	$pdf->SetAligns(array('L','L','L','L'));
	
	$pdf->Rect(8,$pdf->GetY(),185,163);
	$pdf->Ln(25);
	$pdf->SetFont("Arial", '', 12.5);
	$pdf->SetY($pdf->getY()+157);
	$pdf->Line(67,$pdf->getY()-1.5,143.5,$pdf->getY()-1.5);
	$pdf->Cell(98);
	$pdf->Cell(3.5,5,'PHYSICIAN',0,0,'C');
	$pdf->SetY(93);
	$pdf->Line(41,$pdf->getY()+163,41,$pdf->getY());
	$pdf->Line(101,$pdf->getY()+163,101,$pdf->getY());
	$pdf->Line(148,$pdf->getY()+163,148,$pdf->getY());
	$pdf->Line(193,$pdf->getY()+163,193,$pdf->getY());

	if(!empty($data['ConsultationSub'])){

	  foreach ($data['ConsultationSub'] as $key => $data){

		$pdf->Cell(3);

		$pdf->SetFont("Arial", '', 8);
		
		$pdf->RowNoBorder(array(

		  !is_null($data['date']) ? $data['date']->format('m/d/Y') : 'N/A',

		  $data['chief_complaints'],

		  $data['treatments'],

		  $data['remarks'],

		));

		$pdf->Ln(1);

	  }
	  
	}else{
	  $pdf->Cell(3);
	  $pdf->Cell(185,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();

  }

  public function requestForm() {

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(RequestForm.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(RequestForm.date) >= '$start' AND DATE(RequestForm.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  if($status == 3){

		$conditions['status'] = "AND RequestForm.approve = 2 AND RequestForm.otr = 1";

	  }else{

		$conditions['status'] = "AND RequestForm.approve = $status";

	  }

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $student_id = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND RequestForm.student_id = $student_id";

	}

	$tmpData = $this->RequestForm->getAllRequestFormPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5, 10, 5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base . '/assets/img/zam.png', 75, 10, 25, 25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0, 5, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('telephone'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('website') . ' Email: ' . $this->Global->Settings('email'), 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'REQUEST FORM INFORMATION', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	$pdf->Cell(10, 5, '#', 1, 0, 'C', 1);
	$pdf->Cell(40, 5, 'CODE', 1, 0, 'C', 1);
	$pdf->Cell(110, 5, 'STUDENT NAME', 1, 0, 'C', 1);
	$pdf->Cell(45, 5, 'DATE', 1, 0, 'C', 1);
	$pdf->Cell(135, 5, 'COURSE', 1, 0, 'C', 1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10, 40, 110, 45, 135));
	$pdf->SetAligns(array('C', 'C', 'L', 'C', 'C'));
	$conditions = array();

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'],'m/d/Y'),

		  $data['course'],

		));

	  }

	} else {

	  $pdf->Cell(340, 5, 'No data available.', 1, 1, 'C');
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+188,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function affidavitOfLoss() {

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(AffidavitOfLoss.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(AffidavitOfLoss.date) >= '$start' AND DATE(AffidavitOfLoss.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND AffidavitOfLoss.approve = $status";


	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $student_id = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND AffidavitOfLoss.student_id = $student_id";

	}

	$tmpData = $this->AffidavitOfLosses->getAllAffidavitOfLossPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5, 10, 5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base . '/assets/img/zam.png', 5, 10, 25, 25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0, 5, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('telephone'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('website') . ' Email: ' . $this->Global->Settings('email'), 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'AFFIDAVIT OF LOSS', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	$pdf->Cell(10, 5, 'No.', 1, 0, 'C', 1);
	$pdf->Cell(45, 5, 'CONTROLL NO.', 1, 0, 'C', 1);
	$pdf->Cell(80, 5, 'STUDENT NAME', 1, 0, 'C', 1);
	$pdf->Cell(40, 5, 'REQUESTED FORM', 1, 0, 'C', 1);
	$pdf->Cell(30, 5, 'DATE', 1, 0, 'C', 1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10, 45, 80, 40, 30));
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C'));
	$conditions = array();

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['form'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	} else {

	  $pdf->Cell(205, 5, 'No data available.', 1, 1, 'C');
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+118,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }  

  public function requestFormReceipt($id = null){

	$office_reference = $this->Global->OfficeReference('Request Form');

	$data['RequestForm'] = $this->RequestForm->find()

	  ->contain(['Students', 'CollegePrograms'])

	  ->where([

		  'RequestForms.visible' => 1,

		  'RequestForms.id' => $id

	  ])

	  ->first();

	  // print_r($data['student']);

	  $data['Student'] = $data['RequestForm']['student'];

	  $data['CollegeProgram'] = $data['RequestForm']['college_program'];

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10, 5, 10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 9);
	// $pdf->Image($this->base .'/assets/img/request_form.jpg',0,0,215.9,355.6);
	//? -----------------------------------------------------------------------------------  HEADER START
	$pdf->Image($this->base . '/assets/img/zam.png', 20, 5, 20, 20);
	$pdf->Image($this->base . '/assets/img/iso.png', 180, 5, 15, 20);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0, 5, 'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph', 0, 0, 'C');
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(174, $pdf->GetY() + 7, 28, 13);
	$pdf->Ln(4);
	$pdf->Cell(0, 5, 'http://www.zscmst.edu.ph', 0, 0, 'C');
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5, $pdf->getY() + 5, 174, $pdf->getY() + 5);
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(166, 5, '', 0, 0, 'L');
	$pdf->Cell(68, 5, 'ZSCMST- ' . @$office_reference['OfficeReference']['reference_code'], 0, 0, 'L');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(119, 5, '', 0, 0, 'R');
	$pdf->Cell(68, 5, 'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'], 0, 0, 'R');
	$pdf->Ln(1);
	$pdf->SetFont("Times", '', 13);
	$pdf->Cell(0, 5, 'OFFICE OF THE COLLEGE REGISTRAR', 0, 0, 'C');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(123.5, 5, '', 0, 0, 'R');
	$pdf->Cell(60, 5, 'Revision Status: ', 0, 0, 'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(129, 5, '', 0, 0, 'R');
	$pdf->Cell(59, 5, 'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'], 0, 0, 'R');
	$pdf->Ln(1);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0, 5, 'REQUEST FORM', 0, 0, 'C');

	//? -----------------------------------------------------------------------------------  HEADER END   
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(35, 5, 'NAME / CLIENT :  ', 0, 0, 'L');
	$pdf->Cell(50 , 5, $data['Student']['last_name'], 0, 0, 'L');
	$pdf->Cell(65, 5, $data['Student']['first_name'], 0, 0, 'L');
	$pdf->Cell(65, 5, $data['Student']['middle_name'], 0, 0, 'L');
	$pdf->Line(40, $pdf->getY() + 4, 200, $pdf->getY() + 4);
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(58, 5, '( SURNAME )', 0, 0, 'C');
	$pdf->Cell(65, 5, '( GIVEN NAME )', 0, 0, 'C');
	$pdf->Cell(55, 5, '( MIDDLE NAME )', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(40, 5, 'COURSE / SECTION: ', 0, 0, 'L');
	$pdf->Cell(10, 5, $data['CollegeProgram']['code'], 0, 0, 'L');
	$pdf->Line(45, $pdf->getY() + 5, 80, $pdf->getY() + 5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(35, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'STUDENT NO.: ', 0, 0, 'L');
	$pdf->Cell(30, 5, $data['RequestForm']['student_no'], 0, 0, 'L');
	$pdf->Line(123, $pdf->getY() + 5, 160, $pdf->getY() + 5);
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Date: ', 0, 0, 'L');
	$pdf->Cell(65, 5, $data['RequestForm']['date']->format('m/d/Y'), 0, 0, 'L');
	$pdf->Line(175, $pdf->getY() + 5,200, $pdf->getY() + 5);


	$total =0.00;
	$otr = 120.00;
	$otrTotal = 0.00;
	$cav = 100.00;
	$cert = 50.00;
	$hon = 100.00;
	$auth = 50.00;
	$dip = 200.00;
	$rr = 100.00;
	$lg = 50.00;
	$lgTotal = 0.00;
	$check = "";
	if ($data['RequestForm']['otr']){
	  $otrTotal = $otr * $data['RequestForm']['otrVal'];
	  $total += $otrTotal;
	  $check = "4";
	}
	else $check = "";

	$pdf->Ln(8);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(0, 5, 'PLEASE CHECK NATURE OF REQUEST: ', 0, 0, 'L');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(55, 5, ' ) Transcript of Record (TOR)', 'RTB', 0, 'L');
	$pdf->Cell(29, 5, '= 120.00/page', 1, 0, 'L');
	$pdf->Cell(2, 5, '', 0, 0, 'C');
	$pdf->Rect(103, $pdf->GetY(), 100, 12);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(20, 5, 'PURPOSE: ', 0, 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(50, 5, $data['RequestForm']['purpose'], 0, 0, 'L');

	$pdf->Ln();
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(61, 5, ' Number of Page', 1, 0, 'R');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(29, 5, '= '. $data['RequestForm']['otrVal'], 1, 0, 'L');
	$pdf->Ln();
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	if ($data['RequestForm']['cav']){
	  $total+=$cav;
	  $check = "4";
	}
	  
	else $check = "";
	$y = $pdf->GetY();
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 11, $check,0, 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 11, ' ) ', 'T', 0, 'L');
	$pdf->MultiCell(52, 5.5, 'Certification Authentication             Verification (CAV)', 'RTB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 11, '= 100.00', 1, 0, 'L');  
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2, 5, '', 0, 0, 'C');
	$pdf->Rect(103, $pdf->GetY()+4, 100,19);
	$pdf->Ln();
	$pdf->SetFont("Arial", '',9);
	$pdf->Cell(94, 5, '', 0, 0, 'C');
	$pdf->Cell(35, 5, 'OFFICIAL RECEIPT #: ', 0, 0, 'L');
	$pdf->Line(140, $pdf->getY() + 5, 170, $pdf->getY() + 5);
	$pdf->Cell(32, 5, $data['RequestForm']['or_no'], 0, 0, 'L');
	$pdf->Cell(10, 5, 'DATE: ', 0, 0, 'L');
	$pdf->Cell(65, 5, $data['RequestForm']['date']->format('m/d/Y'), 0, 0, 'L');
	$pdf->Line(182, $pdf->getY() + 5, 200, $pdf->getY() + 5);

	$pdf->Ln(6);
	$y = $pdf->GetY();
	if ($data['RequestForm']['cert']){
	  $total+=$cert;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '',11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Certification', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5 , '= 50.00', 1, 0, 'L');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(94, 5, '', 0, 0, 'C');
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(33, 5, 'PLEASE CLAIM ON', 0, 0, 'L');
	$pdf->Cell(1, 5, 'DATE: ', 0, 0, 'L');
	$pdf->Line(148, $pdf->getY() + 5, 170, $pdf->getY() + 5);
	$pdf->Cell(32, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'TIME: ', 0, 0, 'L');
	$pdf->Cell(65, 5, '', 0, 0, 'L');
	$pdf->Line(182, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Ln(1.5);
	$y = $pdf->GetY();
	if ($data['RequestForm']['hon']){
	  $total+=$hon;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Honorable Dismissal', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5 , '= 100.00', 1, 0, 'L');
	$pdf->Ln(5.5);
	$y = $pdf->GetY();

	
	if ($data['RequestForm']['authUGrad'] || $data['RequestForm']['authGrad']){
	  $total+=$auth;
	  $check = "4";
	}
	else $check = "";
	if ($data['RequestForm']['authUGrad']){
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(3,11, $check, 'T', 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->Cell(61, 11, ' ) Authentication    (Undergrad)', 'T', 1);
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/Set', 'LTR', 0, 'L'); 
	  $pdf->Cell(3, 5, '', 0, 0, 'L');
	  $pdf->Rect(103, $pdf->GetY()+2, 100, 20);
	  $pdf->SetFont("Arial", 'B', 10);
	  $pdf->Cell(20, 10, 'REMARKS: ', 0, 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->MultiCell(78, 10, $data['RequestForm']['remarks'], 0, 1);
	}
	else  if ($data['RequestForm']['authGrad']){
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(3,11, $check, 'T', 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->Cell(61, 11, ' ) Authentication    (Graduate)', 'T', 1);
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/Copy', 'LTR', 0, 'L'); 
	  $pdf->Cell(3, 5, '', 0, 0, 'L');
	  $pdf->Rect(103, $pdf->GetY()+2, 100, 20);
	  $pdf->SetFont("Arial", 'B', 10);
	  $pdf->Cell(20, 10, 'REMARKS: ', 0, 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->MultiCell(78, 10, $data['RequestForm']['remarks'], 0, 1);
	}
	else{
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(3,11, $check, 'T', 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->Cell(61, 11, ' ) Authentication    (Undergrad)', 'T', 1);
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/Set', 'LTR', 0, 'L'); 
	  $pdf->Ln(5);
	  $y = $pdf->GetY();
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(61, 11, '(Graduate) ', 'LBR', 1, 'R');
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/copy', 'LBR', 0, 'L'); 
	  $pdf->Cell(3, 5, '', 0, 0, 'L');
	  $pdf->Rect(103, $pdf->GetY(), 100, 20);
	  $pdf->SetFont("Arial", 'B', 10);
	  $pdf->Cell(20, 5, 'REMARKS: ', 0, 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->MultiCell(78, 10, $data['RequestForm']['remarks'], 0, 1);
	}
	

	
	$pdf->Ln(1);
	$y = $pdf->GetY();
	if ($data['RequestForm']['dip']){
	  $total+=$dip;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Diploma', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= 200.00', 1, 0, 'L');  
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	if ($data['RequestForm']['rr']){
	  $total+=$rr;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Red Ribbon', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= 100.00', 1, 0, 'L');  
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	if ($data['RequestForm']['lg']){
	  $lgTotal = $lg * $data['RequestForm']['lgVal'];
	  $total+=$lgTotal;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) List of Graduates', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= 50.00', 1, 0, 'L');  
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	$pdf->Cell(61, 5.5, 'Photocopy      ', 1, 1, 'R');
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= '.$data['RequestForm']['lgVal'], 1, 0, 'L');  
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(5, 5, '', 0, 0, 'C');
	$pdf->Rect(103, $pdf->GetY()-3, 100,10);
	$pdf->Cell(61, 5.5, 'In Charge     : ______________________________', 0, 0, 'L');
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	$pdf->Line(26, $pdf->getY() + 6, 89, $pdf->getY() + 6);
	if ($data['RequestForm']['other']){
	  $pdf->Cell(90, 7, 'Others:   '.$data['RequestForm']['otherVal'], 1, 1);
	}
	else{
	  $pdf->Cell(90, 7, 'Others:   ', 1, 1);
	}
	define('EURO',chr(128));
	$pdf->SetXY(72, $y);
	$pdf->Ln(7);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	$pdf->Cell(61, 8, 'Total: ', 1, 1, 'R');
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 8,'P ' . sprintf('%01.2f', $total), 1, 0, 'L');  
	$pdf->Ln(13);
	$pdf->SetFont("Times", '', 12);
	$pdf->Rect(11, $pdf->GetY()-5, 90,18);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(90, 18, 'Signature Over Printed Name', 0, 0, 'C');
	$pdf->Line(17, $pdf->getY() + 5, 89, $pdf->getY() + 5);

	$pdf->Ln(10);
	$pdf->SetLineWidth(1);
	$first = 7; $last=10;
	do{
	  $pdf->Line($first, $pdf->getY() + 5, $last, $pdf->getY() + 5);
	  $first+=5;
	  $last+=5;
	}while($last<=210);


	$pdf->Ln(8);
	$pdf->Image($this->base . '/assets/img/zam.png', 20, 175, 20, 20);
	$pdf->Image($this->base . '/assets/img/iso.png', 180, 175, 15, 20);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0, 5, 'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph', 0, 0, 'C');
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(174, $pdf->GetY() + 7, 28, 13);
	$pdf->Ln(4);
	$pdf->Cell(0, 5, 'http://www.zscmst.edu.ph', 0, 0, 'C');
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5, $pdf->getY() + 5, 174, $pdf->getY() + 5);
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(166, 5, '', 0, 0, 'L');
	$pdf->Cell(68, 5, 'ZSCMST-MDU-3.10.1-4', 0, 0, 'L');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(119, 5, '', 0, 0, 'R');
	$pdf->Cell(68, 5, 'Adopted Date: 1-2005', 0, 0, 'R');
	$pdf->Ln(1);
	$pdf->SetFont("Times", '', 13);
	$pdf->Cell(0, 5, 'OFFICE OF THE COLLEGE REGISTRAR', 0, 0, 'C');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(123.5, 5, '', 0, 0, 'R');
	$pdf->Cell(60, 5, 'Revision Status: 3', 0, 0, 'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(129, 5, '', 0, 0, 'R');
	$pdf->Cell(59, 5, 'Revision Date: 04-2021', 0, 0, 'R');
	$pdf->Ln(1);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0, 5, 'REQUEST FORM', 0, 0, 'C');

	//? -----------------------------------------------------------------------------------  HEADER END   
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(35, 5, 'NAME / CLIENT :  ', 0, 0, 'L');
	$pdf->Cell(50 , 5, $data['Student']['last_name'], 0, 0, 'L');
	$pdf->Cell(65, 5, $data['Student']['first_name'], 0, 0, 'L');
	$pdf->Cell(65, 5, $data['Student']['middle_name'], 0, 0, 'L');
	$pdf->Line(40, $pdf->getY() + 4, 200, $pdf->getY() + 4);
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(58, 5, '( SURNAME )', 0, 0, 'C');
	$pdf->Cell(65, 5, '( GIVEN NAME )', 0, 0, 'C');
	$pdf->Cell(55, 5, '( MIDDLE NAME )', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(40, 5, 'COURSE / SECTION: ', 0, 0, 'L');
	$pdf->Cell(10, 5, $data['CollegeProgram']['code'], 0, 0, 'L');
	$pdf->Line(45, $pdf->getY() + 5, 80, $pdf->getY() + 5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(35, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'STUDENT NO.: ', 0, 0, 'L');
	$pdf->Cell(30, 5, $data['RequestForm']['student_no'], 0, 0, 'L');
	$pdf->Line(123, $pdf->getY() + 5, 160, $pdf->getY() + 5);
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Date: ', 0, 0, 'L');
	$pdf->Cell(65, 5, $data['RequestForm']['date']->format('m/d/Y'), 0, 0, 'L');
	$pdf->Line(175, $pdf->getY() + 5,200, $pdf->getY() + 5);


	$total =0.00;
	$otr = 120.00;
	$otrTotal = 0.00;
	$cav = 100.00;
	$cert = 50.00;
	$hon = 100.00;
	$auth = 50.00;
	$dip = 200.00;
	$rr = 100.00;
	$lg = 50.00;
	$lgTotal = 0.00;
	$check = "";
	if ($data['RequestForm']['otr']){
	  $otrTotal = $otr * $data['RequestForm']['otrVal'];
	  $total += $otrTotal;
	  $check = "4";
	}
	else $check = "";

	$pdf->Ln(8);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(0, 5, 'PLEASE CHECK NATURE OF REQUEST: ', 0, 0, 'L');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(55, 5, ' ) Transcript of Record (TOR)', 'RTB', 0, 'L');
	$pdf->Cell(29, 5, '= 120.00/page', 1, 0, 'L');
	$pdf->Cell(2, 5, '', 0, 0, 'C');
	$pdf->Rect(103, $pdf->GetY(), 100, 12);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(20, 5, 'PURPOSE: ', 0, 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(50, 5, $data['RequestForm']['purpose'], 0, 0, 'L');

	$pdf->Ln();
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(61, 5, ' Number of Page', 1, 0, 'R');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(29, 5, '= '. $data['RequestForm']['otrVal'], 1, 0, 'L');
	$pdf->Ln();
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	if ($data['RequestForm']['cav']){
	  $total+=$cav;
	  $check = "4";
	}
	  
	else $check = "";
	$y = $pdf->GetY();
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 11, $check,0, 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 11, ' ) ', 'T', 0, 'L');
	$pdf->MultiCell(52, 5.5, 'Certification Authentication             Verification (CAV)', 'RTB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 11, '= 100.00', 1, 0, 'L');  
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2, 5, '', 0, 0, 'C');
	$pdf->Rect(103, $pdf->GetY()+4, 100,19);
	$pdf->Ln();
	$pdf->SetFont("Arial", '',9);
	$pdf->Cell(94, 5, '', 0, 0, 'C');
	$pdf->Cell(35, 5, 'OFFICIAL RECEIPT #: ', 0, 0, 'L');
	$pdf->Line(140, $pdf->getY() + 5, 170, $pdf->getY() + 5);
	$pdf->Cell(32, 5, $data['RequestForm']['or_no'], 0, 0, 'L');
	$pdf->Cell(10, 5, 'DATE: ', 0, 0, 'L');
	$pdf->Cell(65, 5, $data['RequestForm']['date']->format('m/d/Y'), 0, 0, 'L');
	$pdf->Line(182, $pdf->getY() + 5, 200, $pdf->getY() + 5);

	$pdf->Ln(6);
	$y = $pdf->GetY();
	if ($data['RequestForm']['cert']){
	  $total+=$cert;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '',11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Certification', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5 , '= 50.00', 1, 0, 'L');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(94, 5, '', 0, 0, 'C');
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(33, 5, 'PLEASE CLAIM ON', 0, 0, 'L');
	$pdf->Cell(1, 5, 'DATE: ', 0, 0, 'L');
	$pdf->Line(148, $pdf->getY() + 5, 170, $pdf->getY() + 5);
	$pdf->Cell(32, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'TIME: ', 0, 0, 'L');
	$pdf->Cell(65, 5, '', 0, 0, 'L');
	$pdf->Line(182, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Ln(1.5);
	$y = $pdf->GetY();
	if ($data['RequestForm']['hon']){
	  $total+=$hon;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Honorable Dismissal', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5 , '= 100.00', 1, 0, 'L');
	$pdf->Ln(5.5);
	$y = $pdf->GetY();

	
	if ($data['RequestForm']['authUGrad'] || $data['RequestForm']['authGrad']){
	  $total+=$auth;
	  $check = "4";
	}
	else $check = "";
	if ($data['RequestForm']['authUGrad']){
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(3,11, $check, 'T', 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->Cell(61, 11, ' ) Authentication    (Undergrad)', 'T', 1);
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/Set', 'LTR', 0, 'L'); 
	  $pdf->Cell(3, 5, '', 0, 0, 'L');
	  $pdf->Rect(103, $pdf->GetY()+2, 100, 20);
	  $pdf->SetFont("Arial", 'B', 10);
	  $pdf->Cell(20, 10, 'REMARKS: ', 0, 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->MultiCell(78, 10, $data['RequestForm']['remarks'], 0, 1);
	}
	else  if ($data['RequestForm']['authGrad']){
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(3,11, $check, 'T', 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->Cell(61, 11, ' ) Authentication    (Graduate)', 'T', 1);
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/Copy', 'LTR', 0, 'L'); 
	  $pdf->Cell(3, 5, '', 0, 0, 'L');
	  $pdf->Rect(103, $pdf->GetY()+2, 100, 20);
	  $pdf->SetFont("Arial", 'B', 10);
	  $pdf->Cell(20, 10, 'REMARKS: ', 0, 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->MultiCell(78, 10, $data['RequestForm']['remarks'], 0, 1);
	}
	else{
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(3, 11, ' ( ', 'LT', 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(3,11, $check, 'T', 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->Cell(61, 11, ' ) Authentication    (Undergrad)', 'T', 1);
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/Set', 'LTR', 0, 'L'); 
	  $pdf->Ln(5);
	  $y = $pdf->GetY();
	  $pdf->Cell(1, 5, '', 0, 0, 'L');
	  $pdf->Cell(61, 11, '(Graduate) ', 'LBR', 1, 'R');
	  $pdf->SetXY(72, $y);
	  $pdf->Cell(29, 11, '= 50.00/copy', 'LBR', 0, 'L'); 
	  $pdf->Cell(3, 5, '', 0, 0, 'L');
	  $pdf->Rect(103, $pdf->GetY(), 100, 20);
	  $pdf->SetFont("Arial", 'B', 10);
	  $pdf->Cell(20, 5, 'REMARKS: ', 0, 0, 'L');
	  $pdf->SetFont("Arial", '', 11);
	  $pdf->MultiCell(78, 10, $data['RequestForm']['remarks'], 0, 1);
	}
	

	
	$pdf->Ln(1);
	$y = $pdf->GetY();
	if ($data['RequestForm']['dip']){
	  $total+=$dip;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Diploma', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= 200.00', 1, 0, 'L');  
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	if ($data['RequestForm']['rr']){
	  $total+=$rr;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) Red Ribbon', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= 100.00', 1, 0, 'L');  
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	if ($data['RequestForm']['lg']){
	  $lgTotal = $lg * $data['RequestForm']['lgVal'];
	  $total+=$lgTotal;
	  $check = "4";
	}
	else $check = "";
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(3, 5.5, ' ( ', 'LTB', 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(3, 5.5, $check, 'TB', 0, 'L');
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(61, 5.5, ' ) List of Graduates', 'TB', 1);
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= 50.00', 1, 0, 'L');  
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	$pdf->Cell(61, 5.5, 'Photocopy      ', 1, 1, 'R');
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 5.5, '= '.$data['RequestForm']['lgVal'], 1, 0, 'L');  
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(5, 5, '', 0, 0, 'C');
	$pdf->Rect(103, $pdf->GetY()-3, 100,10);
	$pdf->Cell(61, 5.5, 'In Charge     : ______________________________', 0, 0, 'L');
	$pdf->Ln(5.5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	$pdf->Line(26, $pdf->getY() + 6, 89, $pdf->getY() + 6);
	if ($data['RequestForm']['other']){
	  $pdf->Cell(90, 7, 'Others:   '.$data['RequestForm']['otherVal'], 1, 1);
	}
	else{
	  $pdf->Cell(90, 7, 'Others:   ', 1, 1);
	}
	$pdf->SetXY(72, $y);
	$pdf->Ln(7);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$y = $pdf->GetY();
	$pdf->Cell(61, 8, 'Total: ', 1, 1, 'R');
	$pdf->SetXY(72, $y);
	$pdf->Cell(29, 8,'P ' . sprintf('%01.2f', $total), 1, 0, 'L');  
	$pdf->Ln(13);
	$pdf->SetFont("Times", '', 12);
	$pdf->Rect(11, $pdf->GetY()-5, 90,18);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(90, 18, 'Signature Over Printed Name', 0, 0, 'C');
	$pdf->Line(17, $pdf->getY() + 5, 89, $pdf->getY() + 5);

	
   
	$pdf->output();
	exit();
  }

   public function completionForm($id = null){

	$office_reference = $this->Global->OfficeReference('Completion Form');

	$this->loadModel('Completion');

	$data['Completion'] = $this->Completion->find()

	->contain(['Students']) // Assuming you have an association named 'Students'

	->where([

		'Completions.visible' => 1,

		'Completions.id' => $id,

	])

	->first();

	$data['Student'] = $data['Completion']['students'];

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,9,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->Image($this->base .'/assets/img/zam.png',6.5,11,22,22);
	$pdf->Image($this->base .'/assets/img/iso.png',182,13,18,21);
	$pdf->SetFont("Times", '', 11.5);
	$pdf->Ln(3.5);
	$pdf->Cell(-7);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(-5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", '', 11.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(-6);
	$pdf->Cell(0,6,'OFFICE OF THE COLLEGE REGISTRAR',0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", '', 8);
	$pdf->Cell(-12);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph   email: zscmstguidance@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(12);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(25,$pdf->getY()-5.8,173.5,$pdf->getY()-5.8);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(25,$pdf->getY()-5,173.5,$pdf->getY()-5);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(173.9,$pdf->GetY() -7,29.5,13);
	$pdf->Ln(7);
	$pdf->SetY($pdf->getY()- 10.5);

	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(78);
	$pdf->Cell(45,5,'APPLICATION FOR COMPLETION OF COURSE DEFICIENCY',0,0,'C');
	$pdf->SetLineWidth(0.6);
	$pdf->Line(44,$pdf->getY()+4.5,167.5,$pdf->getY()+4.5);
	$pdf->SetLineWidth(0.2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->SetY($pdf->getY()- 2.5);
	$pdf->Cell(171);
	$pdf->Cell(0,4,'ZSCMST-' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(162);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	// $pdf->SetFont("Arial", 'B', 10.5);
	// $pdf->Cell(-154);
	// $pdf->Cell(45,20,'MEDICAL CERTIFICATE',0,0,'C');
	// $pdf->Line(82,$pdf->getY()+12,125.5,$pdf->getY()+12);
	$pdf->Ln(2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(162);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(162);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(4);
	

	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(65,5,'To the Students:',0,0,'L');
	$pdf->Ln(4.5);

	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(1,5,'a.',0,0,'L');
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(55,5,'This form is to be accomplished in ',0,0,'L');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(5,5,'triplicate ',0,0,'L');
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(11,5,'',0,0,'L');
	$pdf->Cell(55,5,'and distributed as follows: ',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->Cell(32);
	$pdf->Cell(55,5,'Program Chairperson, Registrar and the student. Please strictly follow the order of signature ',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->Cell(32);
	$pdf->Cell(55,5,'as numbered: 1) Applicant  2)  Program Chairperson  3) Examining Faculty',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->Cell(32);
	$pdf->Cell(55,5,'4) Dean of the College',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(1,5,'b.',0,0,'L');
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(1,5,'Course deficiency',0,0,'L');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(28);
	$pdf->Cell(1,5,'not removed within one year after rating',0,0,'L');
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(68);
	$pdf->Cell(1,5,'has been recorded',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->Cell(32);
	$pdf->Cell(1,5,'automatically convert to ',0,0,'L');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(38);
	$pdf->Cell(1,5,'FAILURE',0,0,'L');
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(17);
	$pdf->Cell(1,5,'with a grade of (5.0).',0,0,'L');
	$pdf->Ln(9);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Date:'.'   '.$data['Completion']['date'],0,0,'L');
	$pdf->Line(34,$pdf->getY()+4,60,$pdf->getY()+4);
	$pdf->Ln(9);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Sir/Madam:',0,0,'L');
	$pdf->Ln(8.5);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'I would  like  to apply for  completion  examination/ requirement',0,0,'L');
	$pdf->Cell(50);
	$pdf->Cell(20,5,$data['Completion']['requirement'],0,0,'C');
	$pdf->Cell(13);
	$pdf->Cell(5,5,'for the',0,0,'L');
	$pdf->Line(127,$pdf->getY()+4,173,$pdf->getY()+4);
	$pdf->Ln(4.5);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(52,5,'course by instructor/professor',0,0,'L');
	$pdf->Cell(35,5,$data['Completion']['instructor'],0,0,'C');
	$pdf->Line(74,$pdf->getY()+4,120,$pdf->getY()+4);
	$pdf->Cell(8);
	$pdf->Cell(48,5,'which i took during the '.' '.$data['Completion']['semester'],0,0,'L');
	$pdf->Line(157,$pdf->getY()+4,185,$pdf->getY()+4);
	$pdf->Ln(4.5);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(40,5,'of school year',0,0,'L');
	$pdf->Cell(20,5,$data['Completion']['school_year'],0,0,'C');
	$pdf->Line(47,$pdf->getY()+4,100,$pdf->getY()+4);
	$pdf->Ln(8.5);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Very truly yours,',0,0,'L');
	$pdf->Ln(9);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(21,5,'(1)',0,0,'L');
	$pdf->Cell(30,5,$data['Completion']['student_name'],0,0,'C');
	$pdf->Line(30,$pdf->getY()+4,93,$pdf->getY()+4);
	$pdf->Ln(5);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(21,5,'',0,0,'L');
	$pdf->Cell(30,5,'Signature over printed name',0,0,'C');
	$pdf->Ln(9);
	$pdf->Cell(23);
	$pdf->Cell(30,5,'Action taken/Remarks',0,0,'C');
	$pdf->Cell(29);
	$pdf->Cell(70,5,'Year level',0,0,'C');
	$pdf->Cell(-10);
	$pdf->Cell(1,5,$data['Completion']['year'],0,0,'C');
	$pdf->Line(130,$pdf->getY()+4,182,$pdf->getY()+4);
	$pdf->Ln(4.3);
	$pdf->Line(25,$pdf->getY()+4,85,$pdf->getY()+4);
	$pdf->Cell(101);
	$pdf->Cell(30,5,'O.R. No.',0,0,'C');
	$pdf->Cell(10);
	$pdf->Cell(1,5,$data['Completion']['or'],0,0,'C');
	$pdf->Line(130,$pdf->getY()+4,182,$pdf->getY()+4);
	$pdf->Ln(4.5);
	$pdf->Cell(37);
	$pdf->Cell(20,5,'College Registrar',0,0,'C');
	$pdf->Cell(47);
	$pdf->Cell(30,5,'Date Issued',0,0,'C');
	$pdf->Line(134,$pdf->getY()+4,182,$pdf->getY()+4);
	$pdf->Ln(7);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(25,$pdf->getY(),190,$pdf->getY());
	$pdf->SetLineWidth(0.7);
	$pdf->Line(25,$pdf->getY()+.8,190,$pdf->getY()+.8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(2);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'To:',0,0,'L');
	$pdf->Line(33,$pdf->getY()+4,90,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(45);
	$pdf->Cell(65,5,'Faculty',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'College of',0,0,'L');
	$pdf->Line(44,$pdf->getY()+4,82,$pdf->getY()+4);
	$pdf->Ln(9);
	$pdf->Cell(19.5);
	$pdf->Cell(65,5,'Please give the appropriate requirements/examination to the student concerned and submit his/her',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(19.5);
	$pdf->Cell(65,5,'grade as soon as possible.',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->Cell(109);
	$pdf->Cell(21,5,'(2)',0,0,'L');
	$pdf->Line(120,$pdf->getY()+4,182,$pdf->getY()+4);
	$pdf->Ln(4.5);
	$pdf->Cell(124);
	$pdf->Cell(65,5,'Program Chairperson',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(25,$pdf->getY(),190,$pdf->getY());
	$pdf->SetLineWidth(0.7);
	$pdf->Line(25,$pdf->getY()+.8,190,$pdf->getY()+.8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(2);
	$pdf->Cell(19.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'For the Program Chairperson/Registrar',0,0,'L');
	$pdf->Ln(9);
	$pdf->Cell(19.5);
	$pdf->Cell(64.5,5,'I hereby certify that',0,0,'L');
	$pdf->Line(58,$pdf->getY()+4,118,$pdf->getY()+4);
	$pdf->Cell(30);
	$pdf->Cell(65,5,'has taken/ complied with the completion',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->Cell(19.5);
	$pdf->Cell(64,5,'requirement with me and obtained a grade of',0,0,'L');
	$pdf->Line(95,$pdf->getY()+4,110,$pdf->getY()+4);
	$pdf->Cell(20);
	$pdf->Cell(3,5,',',0,0,'L');
	$pdf->Cell(65,5,'(',0,0,'L');
	$pdf->Cell(5,5,').',0,0,'L');
	$pdf->Line(114,$pdf->getY()+4,178,$pdf->getY()+4);
	$pdf->Ln(9);
	$pdf->Cell(109);
	$pdf->Cell(21,5,'(3)',0,0,'L');
	$pdf->Line(120,$pdf->getY()+4,182,$pdf->getY()+4);
	$pdf->Ln(4.5);
	$pdf->Cell(124);
	$pdf->Cell(65,5,'Signature over printed name',0,0,'L');
	$pdf->Ln(9);
	$pdf->Cell(19.5);
	$pdf->Cell(64.5,5,'Noted:',0,0,'L');
	$pdf->Ln(4.3);
	$pdf->Cell(32);
	$pdf->Cell(21,5,'(4)',0,0,'L');
	$pdf->Line(43,$pdf->getY()+4,105,$pdf->getY()+4);
	$pdf->Ln(4.5);
	$pdf->Cell(58);
	$pdf->Cell(65,5,'College Dean',0,0,'L');
	$pdf->Ln(4.5);
	$pdf->Line(43,$pdf->getY()+4,105,$pdf->getY()+4);
	$pdf->Ln(4.5);
	$pdf->Cell(62);
	$pdf->Cell(65,5,'Date',0,0,'L');
	$pdf->Ln(19);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(19.5);
	$pdf->Cell(64.5,5,'Intriplicate',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(32);
	$pdf->Cell(51,5,'Chairperson',0,0,'L');
	$pdf->Line(56,$pdf->getY()+4,74,$pdf->getY()+4);
	$pdf->Cell(38,5,'Registrar',0,0,'L');
	$pdf->Line(103,$pdf->getY()+4,117,$pdf->getY()+4);
	$pdf->Cell(64.5,5,'Student',0,0,'L');
	$pdf->Line(138,$pdf->getY()+4,154,$pdf->getY()+4);
	// $pdf->SetLineWidth(0.6);
	// $pdf->Line(25,$pdf->getY()+19.3,185,$pdf->getY()+19.3);
	// $pdf->SetLineWidth(0.2);
	// $pdf->Ln(25);
	
	
	$pdf->output();
	exit();

  }

  public function completion(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')!=null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Completion.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if ($this->request->getQuery('startDate')!=null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Completion.date) >= '$start' AND DATE(Completion.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->Completion->getAllCompletionPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true; 
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'COMPLETION',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(80,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'DATE',1,0,'C',1);
	$pdf->Cell(30,5,'REQUIREMENT',1,0,'C',1);
	$pdf->Cell(60,5,'INSTRUCTOR',1,0,'C',1);
	$pdf->Cell(50,5,'YEAR & SEMESTER',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,80,55,30,60,50));
	$pdf->SetAligns(array('C','C','L','C','C','L','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->Cell(10);

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'], 'm/d/Y'),

		  $data['requirement'],  

		  $data['instructor'],

		  $data['description']


		));

	  }

	}else{

	  $pdf->Cell(10);  
	  $pdf->Cell(320,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+10,$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+330,$pdf->getY()+2);
	$pdf->SetDash();    

	$pdf->output();

	exit();

  }

  public function scholasticDocument(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')!=null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->ScholasticDocuments->getAllScholasticDocumentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true; 
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',10,10,20,20);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'SCHOLASTIC DOCUMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CODE',1,0,'C',1);
	$pdf->Cell(60,5,'DOCUMENT NAME',1,0,'C',1);
	$pdf->Cell(40,5,'ACRONYM',1,0,'C',1);
	$pdf->Cell(40,5,'SERIAL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,60,40,40));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->Cell(10);

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['title'],

		  $data['acronym'],

		  $data['serial'],


		));

	  }

	}else{

	  $pdf->Cell(10);  
	  $pdf->Cell(320,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+90,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+117,$pdf->getY()+2,$pdf->getX()+206,$pdf->getY()+2);
	$pdf->SetDash();   

	$pdf->output();

	exit();

  }

  public function studentClearanceForm($id = null){

	$this->LoadModel('StudentClearances');

	$data['StudentClearance'] = $this->StudentClearances->find()

	  ->contain([

		  'Students'=> [

			  'conditions' => ['Students.visible' => 1],

			],


		  'CollegePrograms'=> [

			  'conditions' => ['CollegePrograms.visible' => 1],

			],


		  'YearLevelTerms'=> [

			  'conditions' => ['YearLevelTerms.visible' => 1],

			]

		])


	  ->where([

		'StudentClearances.visible' => 1,

		'StudentClearances.id' => $id

	  ])

	  ->first();

	  $data['Student'] = $data['StudentClearance']['student'];

	  $data['CollegeProgram'] = $data['StudentClearance']['college_program'];

	  $data['YearLevelTerm'] = $data['StudentClearance']['year_level_term'];


	  unset($data['StudentClearance']['student']);

	  unset($data['StudentClearance']['college_program']);

	  unset($data['StudentClearance']['year_level_term']);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	// $pdf->Image($this->base .'/assets/img/medical_certificate_form.png',0,0,210,297);

	$pdf->SetFont("Arial", '', 8);
	// $pdf->Image($this->base .'/assets/img/referral_slip.png',0,0,215.9,355.6);
	$pdf->Image($this->base.'/assets/img/zam.png',6,22,13,13);
	$pdf->Image($this->base.'/assets/img/iso.png',85,22,11,13);
	$pdf->Image($this->base.'/assets/img/zam.png',115,22,13,13);
	$pdf->Image($this->base.'/assets/img/iso.png',194,22,11,13);
	
	$pdf->Image($this->base.'/assets/img/zam.png',6,176,13,13);
	$pdf->Image($this->base.'/assets/img/iso.png',85,176,11,13);
	$pdf->Image($this->base.'/assets/img/zam.png',115,176,13,13);
	$pdf->Image($this->base.'/assets/img/iso.png',194,176,11,13);
	
	$pdf->Rect(3.3,$pdf->GetY() + 2,96.5,135);
	$pdf->Rect(112.5,$pdf->GetY() + 2,96.5,135);


	$pdf->Rect(3.3,$pdf->GetY() + 158,96.5,135);
	$pdf->Rect(112.5,$pdf->GetY() + 158,96.5,135);
	$pdf->Ln(4);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Republic of the Philippines',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 7.2);
	$pdf->Cell(21.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 6.8);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Email Address: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'Email Address: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetLineWidth(0.5);
	$pdf->Line(8,$pdf->getY()+3,95,$pdf->getY()+3);
	$pdf->Line(117,$pdf->getY()+3,204,$pdf->getY()+3);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(4.5);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'STUDENT CLEARANCE',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'STUDENT CLEARANCE',0,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->Cell(10,5,'Name:',0,0,'L');
	$pdf->Cell(45,5,$data['StudentClearance']['student_name'],0,0,'L');
	$pdf->Cell(15,5,'SA No.:',0,0,'L');
	$pdf->Cell(39,5,$data['StudentClearance']['sa_number'],0,0,'L');
	$pdf->Cell(10,5,'Name:',0,0,'L');
	$pdf->Cell(45,5,$data['StudentClearance']['student_name'],0,0,'L');
	$pdf->Cell(15,5,'SA No.:',0,0,'L');
	$pdf->Cell(39,5,$data['StudentClearance']['sa_number'],0,0,'L');
	$pdf->Line(15,$pdf->getY()+4,60,$pdf->getY()+4);
	$pdf->Line(124,$pdf->getY()+4,170,$pdf->getY()+4);
	$pdf->Line(70,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Line(179,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(29,5,'Course/Year/Major:',0,0,'L');
	$pdf->Cell(80,5,$data['CollegeProgram']['code'].'/ '.$data['YearLevelTerm']['description'],0,0,'L');
	$pdf->Cell(29,5,'Course/Year/Major:',0,0,'L');
	$pdf->Cell(80,5,$data['CollegeProgram']['code'].'/ '.$data['YearLevelTerm']['description'],0,0,'L');
	$pdf->Line(33,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Line(142,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(32,5,'School Year & Sem.:',0,0,'L');
	$pdf->Cell(77,5,$data['StudentClearance']['school_year'].'  '.$data['StudentClearance']['semester'],0,0,'L');
	$pdf->Cell(32,5,'School Year & Sem.:',0,0,'L');
	$pdf->Cell(78,5,$data['StudentClearance']['school_year'].'  '.$data['StudentClearance']['semester'],0,0,'L');
	$pdf->Line(35,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Line(144,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(6);

	$y = $pdf->GetY();
	$pdf->Cell(31,5,"Subject",1,0,'C');
	$pdf->Cell(31,5,"Teacher",1,0,'C');
	$pdf->Cell(31,5,"Signature",1,0,'C');
	$pdf->Ln();
	$pdf->SetWidths(array(31,31,31));
	$pdf->SetAligns(array('L','C','L'));
	for ($x = 1; $x <= 10; $x++) {
	  $pdf->Row(array(
		'',
		'',
		'',  
	  ));

	}

	$pdf->SetY($y);
	$pdf->Cell(109);

	$pdf->Cell(31,5,"Subject",1,0,'C');
	$pdf->Cell(31,5,"Teacher",1,0,'C');
	$pdf->Cell(31,5,"Signature",1,0,'C');
	$pdf->Ln();
	$pdf->SetWidths(array(31,31,31));
	$pdf->SetAligns(array('L','C','L'));
	for ($x = 1; $x <= 10; $x++) {
	  $pdf->Cell(109);
	  $pdf->Row(array(
		'',
		'',
		'',  
	  ));

	}

	$cash = $data['StudentClearance']['status_cashier'] ==1? 'CLEARED':'';
	$lib = $data['StudentClearance']['status_librarian'] ==1? 'CLEARED':'';
	$ap = $data['StudentClearance']['status_apartelle'] ==1? 'CLEARED':'';
	$lab = $data['StudentClearance']['status_laboratory'] ==1? 'CLEARED':'';
	$aff = $data['StudentClearance']['status_affairs'] ==1? 'CLEARED':'';
	$head = $data['StudentClearance']['status_head'] ==1? 'CLEARED':'';
	$dean = $data['StudentClearance']['status_dean'] ==1? 'CLEARED':'';
	$pdf->Ln(3);
	$y = $pdf->GetY();
	$pdf->Cell(15,5,'Assesment: ' . $cash,0,0,'L');
	$pdf->Line(22,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Cashier: ' . $cash,0,0,'L');
	$pdf->Line(18,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Librarian: ' . $lib,0,0,'L');
	$pdf->Line(20,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Apartelle Admin: ' . $ap,0,0,'L');
	$pdf->Line(30,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'In-Charge, Laboratory Supplies: ' . $lab,0,0,'L');
	$pdf->Line(50,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Adviser/Head, Students Affairs: ' . $aff,0,0,'L');
	$pdf->Line(50,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Department Head: ' . $head,0,0,'L');
	$pdf->Line(32,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'College Dean: ' . $dean,0,0,'L');
	$pdf->Line(26,$pdf->getY()+4,95,$pdf->getY()+4);

	$pdf->SetY($y);
	$pdf->Cell(109);

	$pdf->Cell(15,5,'Assesment: ' . $cash,0,0,'L');
	$pdf->Line(133,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Cashier: ' . $cash,0,0,'L');
	$pdf->Line(127,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Librarian: ' . $lib,0,0,'L');
	$pdf->Line(130,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Apartelle Admin: ' . $ap,0,0,'L');
	$pdf->Line(137,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'In-Charge, Laboratory Supplies: ' . $lab,0,0,'L');
	$pdf->Line(158,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Adviser/Head, Students Affairs: ' . $aff,0,0,'L');
	$pdf->Line(158,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Department Head: ' . $head,0,0,'L');
	$pdf->Line(140,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'College Dean: ' . $dean,0,0,'L');
	$pdf->Line(135,$pdf->getY()+4,205,$pdf->getY()+4);


	//Bottom Part

	$pdf->Ln(26);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Republic of the Philippines',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 7.2);
	$pdf->Cell(21.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 6.8);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'Email Address: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'Email Address: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetLineWidth(0.5);
	$pdf->Line(8,$pdf->getY()+3,95,$pdf->getY()+3);
	$pdf->Line(117,$pdf->getY()+3,204,$pdf->getY()+3);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(4.5);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(23.5,5,'',0,0,'L');
	$pdf->Cell(50,5,'STUDENT CLEARANCE',0,0,'C');
	$pdf->Cell(59,5,'',0,0,'L');
	$pdf->Cell(50,5,'STUDENT CLEARANCE',0,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->Cell(10,5,'Name:',0,0,'L');
	$pdf->Cell(45,5,$data['StudentClearance']['student_name'],0,0,'L');
	$pdf->Cell(15,5,'SA No.:',0,0,'L');
	$pdf->Cell(39,5,$data['StudentClearance']['sa_number'],0,0,'L');
	$pdf->Cell(10,5,'Name:',0,0,'L');
	$pdf->Cell(45,5,$data['StudentClearance']['student_name'],0,0,'L');
	$pdf->Cell(15,5,'SA No.:',0,0,'L');
	$pdf->Cell(39,5,$data['StudentClearance']['sa_number'],0,0,'L');
	$pdf->Line(15,$pdf->getY()+4,60,$pdf->getY()+4);
	$pdf->Line(124,$pdf->getY()+4,170,$pdf->getY()+4);
	$pdf->Line(70,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Line(179,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(29,5,'Course/Year/Major:',0,0,'L');
	$pdf->Cell(80,5,$data['CollegeProgram']['code'].'/ '.$data['StudentClearance']['year'].'/ '.$data['StudentClearance']['major'],0,0,'L');
	$pdf->Cell(29,5,'Course/Year/Major:',0,0,'L');
	$pdf->Cell(80,5,$data['CollegeProgram']['code'].'/ '.$data['StudentClearance']['year'].'/ '.$data['StudentClearance']['major'],0,0,'L');
	$pdf->Line(33,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Line(142,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(32,5,'School Year & Sem.:',0,0,'L');
	$pdf->Cell(77,5,$data['StudentClearance']['school_year'].'  '.$data['StudentClearance']['semester'],0,0,'L');
	$pdf->Cell(32,5,'School Year & Sem.:',0,0,'L');
	$pdf->Cell(78,5,$data['StudentClearance']['school_year'].'  '.$data['StudentClearance']['semester'],0,0,'L');
	$pdf->Line(35,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Line(144,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(6);


	$y = $pdf->GetY();
	$pdf->Cell(31,5,"Subject",1,0,'C');
	$pdf->Cell(31,5,"Teacher",1,0,'C');
	$pdf->Cell(31,5,"Signature",1,0,'C');
	$pdf->Ln();
	$pdf->SetWidths(array(31,31,31));
	$pdf->SetAligns(array('L','C','L'));
	for ($x = 1; $x <= 10; $x++) {
	  $pdf->Row(array(
		'',
		'',
		'',  
	  ));

	}

	$pdf->SetY($y);
	$pdf->Cell(109);

	$pdf->Cell(31,5,"Subject",1,0,'C');
	$pdf->Cell(31,5,"Teacher",1,0,'C');
	$pdf->Cell(31,5,"Signature",1,0,'C');
	$pdf->Ln();
	$pdf->SetWidths(array(31,31,31));
	$pdf->SetAligns(array('L','C','L'));
	for ($x = 1; $x <= 10; $x++) {
	  $pdf->Cell(109);
	  $pdf->Row(array(
		'',
		'',
		'',  
	  ));

	}

	
	$pdf->Ln(3);
	$y = $pdf->GetY();
	$pdf->Cell(15,5,'Assesment: ' . $cash,0,0,'L');
	$pdf->Line(25,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Cashier: ' . $cash,0,0,'L');
	$pdf->Line(20,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Librarian: ' . $lib,0,0,'L');
	$pdf->Line(21,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Apartelle Admin: ' . $ap,0,0,'L');
	$pdf->Line(30,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'In-Charge, Laboratory Supplies: ' . $lab,0,0,'L');
	$pdf->Line(50,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Adviser/Head, Students Affairs: ' . $aff,0,0,'L');
	$pdf->Line(50,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'Department Head: ' . $head,0,0,'L');
	$pdf->Line(32,$pdf->getY()+4,95,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(15,5,'College Dean: ' . $dean,0,0,'L');
	$pdf->Line(26,$pdf->getY()+4,95,$pdf->getY()+4);

	$pdf->SetY($y);
	$pdf->Cell(109);

	$pdf->Cell(15,5,'Assesment: ' . $cash,0,0,'L');
	$pdf->Line(133,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Cashier: ' . $cash,0,0,'L');
	$pdf->Line(127,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Librarian: ' . $lib,0,0,'L');
	$pdf->Line(130,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Apartelle Admin: ' . $ap,0,0,'L');
	$pdf->Line(137,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'In-Charge, Laboratory Supplies: ' . $lab,0,0,'L');
	$pdf->Line(158,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Adviser/Head, Students Affairs: ' . $aff,0,0,'L');
	$pdf->Line(158,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'Department Head: ' . $head,0,0,'L');
	$pdf->Line(140,$pdf->getY()+4,205,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(109);
	$pdf->Cell(15,5,'College Dean: ' . $dean,0,0,'L');
	$pdf->Line(135,$pdf->getY()+4,205,$pdf->getY()+4);



	$pdf->output();
	exit();

  }

  public function studentClearance(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$this->LoadModel('StudentClearances');
	$tmpData = $this->StudentClearances->getAllStudentClearancePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true; 
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT CLEARANCE',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(18);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(60,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(40,5,'COURSE',1,0,'C',1);
	$pdf->Cell(40,5,'MAJOR',1,0,'C',1);
	$pdf->Cell(30,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Cell(30,5,'SCHOOL YEAR',1,0,'C',1);
	$pdf->Cell(30,5,'SA NO.',1,0,'C',1);
	$pdf->Cell(40,5,'SEMESTER',1,0,'C',1);
	
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,30,60,40,40,30,30,30,40));
	$pdf->SetAligns(array('C','C','L','C','C','C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->Cell(18);

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['name'],  

		  $data['major'],

		  $data['year_level_term'],

		  $data['school_year'],

		  $data['sa_number'],

		  $data['semester'],

		));

	  }

	}else{
	  $pdf->Cell(18);
	  $pdf->Cell(310,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+18,$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+328,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function facultyClearance(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(FacultyClearance.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(FacultyClearance.date) >= '$start' AND DATE(FacultyClearance.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}
	$tmpData = $this->FacultyClearances->getAllFacultyClearancePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'FACULTY CLEARANCE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'NO.',1,0,'C',1);
	$pdf->Cell(60,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(100,5,'FACULTY NAME',1,0,'C',1);
	$pdf->Cell(65,5,'DATE',1,0,'C',1);
	$pdf->Cell(100,5,'REQUEST',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,60,100,65,100));
	$pdf->SetAligns(array('C','C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['faculty_name'],

		  date('m/d/Y', strtotime($data['date'])),

		  $data['request'],

		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function facultyClearanceForm($id = null){

	$office_reference = $this->Global->OfficeReference('Faculty Clearance');

	$data['FacultyClearance'] = $this->FacultyClearances->find()

	->where([

		'visible' => 1,

		'id' => $id

	])

	->first();

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,4,5);
	$pdf->AddPage("P", "A4", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11.5);
	$pdf->Image($this->base.'/assets/img/zam2.png',15.5,8,22,22);
	$pdf->Image($this->base.'/assets/img/iso.png',184,9.2,15,20);
	$pdf->Rect(10.5,$pdf->GetY() + 4,191,138);
	$pdf->Ln(5);
	$pdf->Cell(198.5,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 10.5);
	$pdf->Cell(205,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(205,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 21.5);
	$pdf->Cell(0,5,'C  L   E   A  R   A   N  C  E',0,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(0,5,'(Teaching Personnel)',0,0,'C');

	$pdf->Rect(170,$pdf->GetY() + -3,28.7,10);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,2,'',0,0,'L');
	$pdf->Cell(68,-10,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,5,'',0,0,'L');
	$pdf->Cell(68,-12,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,5,'',0,0,'L');
	$pdf->Cell(65,-11.5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,5,'',0,0,'L');
	$pdf->Cell(65,-12,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');

	$pdf->Ln(-3);
	$pdf->SetFont("TIMES", '', 11);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(35,5,'This is to certify that ',0,0, 'L');

	$day = $data['FacultyClearance']['date']->format('j'); // Get the day without leading zeros

	// Determine the ordinal suffix
	if ($day % 10 == 1 && $day != 11) {
		$ordinal = $day . 'st';
	} elseif ($day % 10 == 2 && $day != 12) {
		$ordinal = $day . 'nd';
	} elseif ($day % 10 == 3 && $day != 13) {
		$ordinal = $day . 'rd';
	} else {
		$ordinal = $day . 'th';
	}

	$pdf->Cell(93,5,$data['FacultyClearance']['faculty_name'],0,0, 'L');
	$pdf->Line(59,$pdf->getY()+4,124,$pdf->getY()+4);
	$pdf->Cell(10,5,'is cleared from his/her accountabilities.',0,0, 'C');

	$pdf->Ln(5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(100,5,'This clearance is issued in connection with his/her request for ',0,0, 'L');
	$pdf->Cell(69,5,$data['FacultyClearance']['request'],0,0, 'L');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(122,$pdf->getY()+4.4,175,$pdf->getY()+4.4);
	$pdf->Cell(-19,5,'',0,0,'L');
	$pdf->Cell(10,5,'on this ',0,0, 'C');

	$pdf->Ln(5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Line(26,$pdf->getY()+4.4,49,$pdf->getY()+4.4);
	$pdf->Cell(28,5,$ordinal,0,0,'C');
	$pdf->Cell(10,5,'day of ',0,0, 'C');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(65,$pdf->getY()+4.4,105,$pdf->getY()+4.4);
	$pdf->Cell(42,5,$data['FacultyClearance']['date']->format('F Y'),0,0,'L');
	$pdf->Cell(10,5,'.',0,0, 'C');

	$pdf->Ln(7);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(55,5,'I COLLEGE CLEARANCE',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'L');
	$pdf->Cell(10,5,'II ACADEMIC SUPPORT CLEARANCE',0,0, 'C');

	$pdf->Ln(4);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(16,$pdf->getY()+4.2,95,$pdf->getY()+4.2);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(115,$pdf->getY()+4.2,193,$pdf->getY()+4.2);

	$pdf->Ln(4);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(65,5,'Program Chair/Department Chair/LHS Principal',0,0, 'C');
	$pdf->Cell(55,5,'',0,0,'L');
	$pdf->Cell(10,5,'College Librarian (Main Library)',0,0, 'C');

	$pdf->Ln(4.5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Line(20,$pdf->getY()+4.2,79,$pdf->getY()+4.2);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(115,$pdf->getY()+4.2,193,$pdf->getY()+4.2);

	$pdf->Ln(4.5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(55,5,'College Registrar',0,0, 'C');
	$pdf->Cell(70,5,'',0,0,'L');
	$pdf->Cell(10,5,'Dean, Student Affairs and Academic Services',0,0, 'C');

	$pdf->Ln(4.3);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(20,$pdf->getY()+4.2,79,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(55,5,'College Dean',0,0, 'C');

	$pdf->Ln(3);
	$pdf->Line(70,$pdf->getY()+4.2,140,$pdf->getY()+4.2);
	$pdf->Ln(4);
	$pdf->Cell(200,5,'Vice President for Academic Affairs',0,0, 'C');
	$pdf->Ln(6);
	$pdf->Cell(200,5,'II ADMINISTRATIVE CLEARANCE',0,0, 'C');

	$pdf->Ln(5);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'Human Resource Management Officer',0,0, 'C');
	$pdf->Ln(4.5);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'College Supply Officer',0,0, 'C');
	$pdf->Ln(4.5);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'College Accountant',0,0, 'C');
	$pdf->Ln(3.6);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'Vice President for Administrative and Finance',0,0, 'C');
	$pdf->Ln(3.6);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'COLLEGE PRESIDENT',0,0, 'C');

	$pdf->Ln(5);

	$pdf->Image($this->base.'/assets/img/zam2.png',15.5,150,20,20);
	$pdf->Image($this->base.'/assets/img/iso.png',184,150,15,20);
	$pdf->Rect(10.5,$pdf->GetY() + 4,191,138);
	$pdf->Ln(5);
	$pdf->Cell(198.5,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 10.5);
	$pdf->Cell(205,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(205,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 21.5);
	$pdf->Cell(0,5,'C  L   E   A  R   A   N  C  E',0,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(0,5,'(Teaching Personnel)',0,0,'C');

	$pdf->Rect(170,$pdf->GetY() + -3,28.7,10);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,2,'',0,0,'L');
	$pdf->Cell(68,-10,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,5,'',0,0,'L');
	$pdf->Cell(68,-12,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,5,'',0,0,'L');
	$pdf->Cell(65,-11.5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5);
	$pdf->Cell(166.5,5,'',0,0,'L');
	$pdf->Cell(65,-12,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');

	$pdf->Ln(-3);
	$pdf->SetFont("TIMES", '', 11);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(35,5,'This is to certify that ',0,0, 'L');

	$day = $data['FacultyClearance']['date']->format('j'); // Get the day without leading zeros

	// Determine the ordinal suffix
	if ($day % 10 == 1 && $day != 11) {
		$ordinal = $day . 'st';
	} elseif ($day % 10 == 2 && $day != 12) {
		$ordinal = $day . 'nd';
	} elseif ($day % 10 == 3 && $day != 13) {
		$ordinal = $day . 'rd';
	} else {
		$ordinal = $day . 'th';
	}

	$pdf->Cell(93,5,$data['FacultyClearance']['faculty_name'],0,0, 'L');
	$pdf->Line(59,$pdf->getY()+4,124,$pdf->getY()+4);
	$pdf->Cell(10,5,'is cleared from his/her accountabilities.',0,0, 'C');

	$pdf->Ln(5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(100,5,'This clearance is issued in connection with his/her request for ',0,0, 'L');
	$pdf->Cell(69,5,$data['FacultyClearance']['request'],0,0, 'L');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(122,$pdf->getY()+4.4,175,$pdf->getY()+4.4);
	$pdf->Cell(-19,5,'',0,0,'L');
	$pdf->Cell(10,5,'on this ',0,0, 'C');

	$pdf->Ln(5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Line(26,$pdf->getY()+4.4,49,$pdf->getY()+4.4);
	$pdf->Cell(28,5,$ordinal,0,0,'C');
	$pdf->Cell(10,5,'day of ',0,0, 'C');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(65,$pdf->getY()+4.4,105,$pdf->getY()+4.4);
	$pdf->Cell(42,5,$data['FacultyClearance']['date']->format('F Y'),0,0,'L');
	$pdf->Cell(10,5,'.',0,0, 'C');

	$pdf->Ln(7);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(55,5,'I COLLEGE CLEARANCE',0,0,'C');
	$pdf->Cell(70,5,'',0,0,'L');
	$pdf->Cell(10,5,'II ACADEMIC SUPPORT CLEARANCE',0,0, 'C');

	$pdf->Ln(4);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(16,$pdf->getY()+4.2,95,$pdf->getY()+4.2);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(115,$pdf->getY()+4.2,193,$pdf->getY()+4.2);

	$pdf->Ln(4);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(65,5,'Program Chair/Department Chair/LHS Principal',0,0, 'C');
	$pdf->Cell(55,5,'',0,0,'L');
	$pdf->Cell(10,5,'College Librarian (Main Library)',0,0, 'C');

	$pdf->Ln(4.5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Line(20,$pdf->getY()+4.2,79,$pdf->getY()+4.2);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(115,$pdf->getY()+4.2,193,$pdf->getY()+4.2);

	$pdf->Ln(4.5);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(55,5,'College Registrar',0,0, 'C');
	$pdf->Cell(70,5,'',0,0,'L');
	$pdf->Cell(10,5,'Dean, Student Affairs and Academic Services',0,0, 'C');

	$pdf->Ln(4.3);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(20,$pdf->getY()+4.2,79,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(19,5,'',0,0,'L');
	$pdf->Cell(55,5,'College Dean',0,0, 'C');

	$pdf->Ln(3);
	$pdf->Line(70,$pdf->getY()+4.2,140,$pdf->getY()+4.2);
	$pdf->Ln(4);
	$pdf->Cell(200,5,'Vice President for Academic Affairs',0,0, 'C');
	$pdf->Ln(6);
	$pdf->Cell(200,5,'II ADMINISTRATIVE CLEARANCE',0,0, 'C');

	$pdf->Ln(5);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'Human Resource Management Officer',0,0, 'C');
	$pdf->Ln(4.5);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'College Supply Officer',0,0, 'C');
	$pdf->Ln(4.5);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'College Accountant',0,0, 'C');
	$pdf->Ln(3.6);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'Vice President for Administrative and Finance',0,0, 'C');
	$pdf->Ln(3.6);
	$pdf->Line(70,$pdf->getY()+4.2,142,$pdf->getY()+4.2);
	$pdf->Ln(4.3);
	$pdf->Cell(200,5,'COLLEGE PRESIDENT',0,0, 'C');




	$pdf->output();
	exit();

  }

  public function counselingIntake(){

   $conditions = [];

	$conditionsPrint = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(CounselingIntake.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(CounselingIntake.date) >= '$start' AND DATE(CounselingIntake.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $studentId = $this->Session->read('Auth.User.studentId');

	  $conditions['studentId'] = "AND CounselingIntake.student_id = $studentId";

	}

	$tmpData = $this->CounselingIntakes->getAllCounselingIntakePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'COUNSELING INTAKE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(100,5,'Student Name',1,0,'C',1);
	$pdf->Cell(65,5,'Yeal Level',1,0,'C',1);
	$pdf->Cell(65,5,'Current Address',1,0,'C',1);
	$pdf->Cell(100,5,'Contact no.',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,100,65,65,100));
	$pdf->SetAligns(array('C','L','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['student_name'],

		  $data['description'],

		  $data['address'],

		  $data['contact_no'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash(); 

	$pdf->output();
	exit();
  
  }

  public function registeredStudents(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentClub.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentClub.date) >= '$start' AND DATE(StudentClub.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id');

	  $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";
	  
	}

	$tmpData = $this->RegisteredStudents->getAllRegisteredStudentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'REGISTERED STUDENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(8,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'STUDENT NUMBER',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(50,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Cell(60,5,'COLLEGE',1,0,'C',1);
	$pdf->Cell(60,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(40,5,'CONTACT NO',1,0,'C',1);
	$pdf->Cell(40,5,'EMAIL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,35,50,50,60,60,40,40));
	$pdf->SetAligns(array('C','C','L','C','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['description'],

		  $data['college'],

		  $data['program'],

		  $data['contact_no'],

		  $data['email']

		));

	  }

	}else{

	  $pdf->Cell(343,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+188,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function studentProfiles(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if ($this->request->getQuery('search')!=null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')!=null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;
	}  

	//advance search

	if ($this->request->getQuery('startdate')!=null) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	if ($this->request->getQuery('college_program_id')!=null) {

	  $college_program_id = $this->request->getQuery('college_program_id');

	  $conditions['college_program'] = " AND StudentApplication.preferred_program_id = $college_program_id";
	  
	}


	$tmpData = $this->StudentProfiles->getAllStudentProfilePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',10,10,20,20);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Student Profiles',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(8,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'STUDENT NUMBER',1,0,'C',1);
	$pdf->Cell(60,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(50,5,'APPLICATION DATE',1,0,'C',1);
	$pdf->Cell(53,5,'EMAIL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,35,60,50,53));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['application_date'],

		  $data['email']

		));

	  }

	}else{

	  $pdf->Cell(206,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+90,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+117,$pdf->getY()+2,$pdf->getX()+206,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function reportRatingForm($id = null){

	$tmpData = $this->Employees->find()

	->contain([

		'Colleges' => [

			'conditions' => ['Colleges.visible' => 1]

		]

	])

	->where([

		'Employees.visible' => 1,

		'Employees.id' => $this->request->getQuery('faculty_id')

	])

	->first();

	$program_id = $this->request->getQuery('program_id');

	$course_id = $this->request->getQuery('course_id');

	$section_id = $this->request->getQuery('section_id');

	$year_term_id = $this->request->getQuery('year_term_id');

	$faculty_id = $this->request->getQuery('faculty_id');

	$section = $this->Sections->get($section_id);

	$program = $this->CollegePrograms->get($program_id);

	$course = $this->Courses->get($course_id);

	$year_term = $this->YearLevelTerms->get($year_term_id);

	$datas = array();

	$school_year = '';

	$block_section = $this->BlockSections->find()
		->where([

			'BlockSections.visible' => 1,

			'BlockSections.section_id' => $section_id,

			'BlockSections.program_id' => $program_id

		])

		->first();

	if(!empty($block_section)){

	  $school_year = $block_section['school_year_start'].' - '.$block_section['school_year_end'];

	}

	$student = "

	  SELECT 

		Student.*,

		StudentEnrolledCourse.id,

		StudentEnrolledCourse.section,

		StudentEnrolledCourse.course,

		StudentEnrolledCourse.midterm_grade,

		StudentEnrolledCourse.finalterm_grade,

		StudentEnrolledCourse.final_grade,

		StudentEnrolledCourse.remarks,

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

		  'id'              => $value['id'],

		  'code'            => $value['course'].' :: '.$value['section'],

		  'student_id'      => $value['id'],

		  'student_no'      => $value['student_no'],

		  'student_name'    => $value['full_name'],

		  'midterm_grade'   => $value['midterm_grade'],

		  'finalterm_grade' => $value['finalterm_grade'],

		  'final_grade'     => $value['final_grade'],

		  'remarks'         => $value['remarks'],

		);

	  }

	}

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10, 6, 10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11);
	// $pdf->Image($this->base .'/assets/img/prac_form.png',0,0,215.9,355.6);
	//? -----------------------------------------------------------------------------------  HEADER START
	$pdf->Image($this->base . '/assets/img/zam.png', 10, 5, 20, 20);
	$pdf->Image($this->base . '/assets/img/iso.png', 187, 5, 15, 20);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(0, 5, 'OFFICE OF THE COLLEGE REGISTRAR', 0, 0, 'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 8);
	$pdf->Cell(0, 5, 'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph email: registrar@zscmst.edu.ph', 0, 0, 'C');
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(174, $pdf->GetY() + 3, 28, 13);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5, $pdf->getY() + 5, 174, $pdf->getY() + 5);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5, $pdf->getY() + 6, 173.5, $pdf->getY() + 6);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(166, 5, '', 0, 0, 'L');
	$pdf->Cell(68, 5, 'ZSCMST-DCR-3.10.1-8', 0, 0, 'L');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(119, 5, '', 0, 0, 'R');
	$pdf->Cell(68, 5, 'Adopted Date: 8-2015', 0, 0, 'R');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(123.5, 5, '', 0, 0, 'R');
	$pdf->Cell(60, 5, 'Revision Status: 2', 0, 0, 'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(129, 5, '', 0, 0, 'R');
	$pdf->Cell(59, 5, 'Revision Date: 04-2021', 0, 0, 'R');
	$pdf->Ln(.5);
	$pdf->SetLineWidth(0.3);
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(0, 5, $tmpData['name'], 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->SetFont("Times", 'B', 15);
	$pdf->Cell(0, 5, 'REPORT OF RATING', 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->SetFont("Times", '', 10);
	$pdf->Line(102, $pdf->getY()+5, 135, $pdf->getY()+5);
	$pdf->Cell(70, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'School Year:', 0, 0, 'L');
	$pdf->Cell(10, 5, $school_year, 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(22, 5, "Course No.:", 0, 0, 'L');
	$pdf->Cell(70, 5, @$program['code'], 0, 0, 'L');

	$pdf->Cell(19, 5, "Semester:", 0, 0, 'L');
	$check = "4";
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(12, 5, "First ", 0, 0, 'L');
	if ($year_term['semester'] == '1st Semester'){
	  $pdf->Cell(1.7, 4, '(    )', 0, 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(4, 4, $check, 0, 0, 'L');
	  $pdf->SetFont("Times", '', 10);
	} 
	else{$pdf->Cell(4, 4, '(    )', 0, 0, 'C');}
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, "Second ", 0, 0, 'L');
	if ($year_term['semester'] == '2nd Semester'){
	  $pdf->Cell(1.7, 4, '(    )', 0, 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(4, 4, $check, 0, 0, 'L');
	  $pdf->SetFont("Times", '', 10);
	} 
	else{$pdf->Cell(4, 4, '(    )', 0, 0, 'C');}
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Cell(18, 5, "Summer ", 0, 0, 'L');
	if ($year_term['semester'] == 'Summer'){
	  $pdf->Cell(1.7, 4, '(    )', 0, 0, 'L');
	  $pdf->SetFont('ZapfDingbats', '', 10);
	  $pdf->Cell(4, 4, $check, 0, 0, 'L');
	  $pdf->SetFont("Times", '', 10);
	} 
	else{$pdf->Cell(4, 4, '(    )', 0, 0, 'C');}
	$pdf->Line(35, $pdf->getY() + 5, 85, $pdf->getY() + 5);
	$pdf->Ln(5);
	$y = $pdf->getY();
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(22, 5, "Course Title:", 0, 0, 'L');
	$pdf->MultiCell(90, 5, @$program['name'], 0, 'L',0);
	$pdf->Line(35, $pdf->getY()-5, 110, $pdf->getY()-5);
	$pdf->Line(35, $pdf->getY(), 110, $pdf->getY());
	$pdf->setXY(114,$y);
	$pdf->Cell(12, 5, "Course:", 0, 0, 'L');
	$pdf->Cell(50, 5, @$course['title'], 0, 0, 'L');
	$pdf->Line(125, $pdf->getY() + 5, 208, $pdf->getY() + 5);
	$pdf->Ln(6);
	$pdf->Cell(104);
	// $pdf->Line(25, $pdf->getY() + 5, 95, $pdf->getY() + 5);
	$pdf->Cell(26, 5, "Year/Section:", 0, 0, 'L');
	$pdf->Cell(55, 5,@$section['name'], 0, 0, 'L');
	$pdf->Line(135, $pdf->getY() + 5, 208, $pdf->getY() + 5);
	// $pdf->Line(134, $pdf->getY() + 5, 180, $pdf->getY() + 5);

	$pdf->Ln(6);
	$pdf->Cell(1, 6, '', 0, 0, 'C');
	$pdf->Cell(80, 10, 'Name in Alphabetical Order', 'LTR', 0, 'C');
	$pdf->Cell(25, 10, 'Mid Term', 'LTR', 0, 'C');
	$pdf->Cell(25, 10, 'Final Term', 'LTR', 0, 'C');
	$pdf->Cell(25, 6, 'Final Grade', 'LTR', 0, 'C');
	$pdf->Cell(40, 14, 'Remarks', 1, 0, 'C');
	$pdf->Ln(4);
	$pdf->Cell(1, 6, '', 0, 0, 'C');
	$pdf->Cell(80, 10, '(Surname, Given Name, MI)', 'LBR', 0, 'C');
	$pdf->Cell(25, 10, 'Grade', 'LBR', 0, 'C');
	$pdf->Cell(25, 10, 'Grade', 'LBR', 0, 'C');
	$pdf->Cell(25, 6, '(50% MTG', 'LR', 0, 'C');
	$pdf->Ln(4);
	$pdf->Cell(131, 6, '', 0, 0, 'C');
	$pdf->Cell(25, 6, '50% FTG)', 'LBR', 0, 'C');
	$pdf->Ln(6);
	$pdf->SetWidths(array(80,25,25,25,40));
	$pdf->SetAligns(array('L','C','C','C','C'));

	$counter = 0;
	
	if(!empty($datas)){

	  foreach ($datas as $key => $data){

		$counter += 1;

		$pdf->Cell(1, 6, '', 0, 0, 'C');

		$pdf->RowLegalP(array(

		  ($key + 1).'.  '.utf8_decode(properCase($data['student_name'])),

		  $data['midterm_grade'] > 0 ? fnumber((float)$data['midterm_grade'],2) : '',

		  $data['finalterm_grade'] > 0 ? fnumber((float)$data['finalterm_grade'],2) : '',

		  $data['final_grade'],

		  $data['remarks'],

		));

	  }

	}

	if($counter < 30){

	  for ($i=$counter; $i < 30; $i++) { 

		$pdf->Cell(1, 6, '', 0, 0, 'L');
		$pdf->Cell(80, 6, ($i + 1).'.', 1, 0, 'L');
		$pdf->Cell(25, 6, '', 1, 0, 'L');
		$pdf->Cell(25, 6, '', 1, 0, 'L');
		$pdf->Cell(25, 6, '', 1, 0, 'L');
		$pdf->Cell(40, 6, '', 1, 1, 'L');

	  } 

	}

	$pdf->Ln(1);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(1, 6, '', 0, 0, 'L');
	$pdf->Cell(100, 6, 'Mid Term Grade:', 0, 0, 'L');
	$pdf->Cell(70, 6, 'Final Term Grade:', 0, 0, 'L');
	$pdf->Ln(10);
	$pdf->Cell(1, 6, '', 0, 0, 'L');
	$pdf->Cell(100, 6, 'Prepared by: ', 0, 0, 'L');
	$pdf->Line(35, $pdf->getY() + 5, 100, $pdf->getY() + 5);
	$pdf->Cell(70, 6, 'Prepared by:', 0, 0, 'L');
	$pdf->Line(135, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Ln(5);
	$pdf->Cell(42, 6, '', 0, 0, 'L');
	$pdf->Cell(100, 6, 'Instructor/  Professor ', 0, 0, 'L');
	$pdf->Cell(70, 6, 'Instructor/  Professor', 0, 0, 'L'); 
	$pdf->Ln(10);
	$pdf->Cell(1, 6, '', 0, 0, 'L');
	$pdf->Cell(100, 6, 'Reviewed by: ', 0, 0, 'L');
	$pdf->Line(35, $pdf->getY() + 5, 100, $pdf->getY() + 5);
	$pdf->Cell(70, 6, 'Reviewed by:', 0, 0, 'L');
	$pdf->Line(135, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Ln(5);
	$pdf->Cell(45, 6, '', 0, 0, 'L');
	$pdf->Cell(100, 6, 'Department Chair', 0, 0, 'L');
	$pdf->Cell(70, 6, 'Department Chair', 0, 0, 'L'); 
	$pdf->Ln(10);
	$pdf->Cell(1, 6, '', 0, 0, 'L');
	$pdf->Line(35, $pdf->getY() + 5, 100, $pdf->getY() + 5);
	$pdf->Line(135, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Ln(5);
	$pdf->Cell(45, 6, '', 0, 0, 'L');
	$pdf->Cell(100, 6, 'Program Adviser', 0, 0, 'L');
	$pdf->Cell(70, 6, 'Program Adviser', 0, 0, 'L'); 
	$pdf->Ln(10);
	$pdf->Cell(1, 6, '', 0, 0, 'L');
	$pdf->Cell(100, 6, 'Attested by:', 0, 0, 'L');
	$pdf->Line(35, $pdf->getY() + 5, 100, $pdf->getY() + 5);
	$pdf->Cell(70, 6, 'Noted by:', 0, 0, 'L');
	$pdf->Line(135, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Ln(5);
	$pdf->Cell(42, 6, '', 0, 0, 'L');
	$pdf->Cell(85, 6, 'College  Dean', 0, 0, 'L');
	$pdf->Cell(70, 6, 'Vice-President for Academic Affairs', 0, 0, 'L'); 
	
	$pdf->output();
	exit();
  }

  public function counselingIntakeForm($id = null){

	$office_reference = $this->Global->OfficeReference('Counseling Intake');

	$data['CounselingIntake'] = $this->CounselingIntakes->find()
	
	  ->contain([

		'CollegePrograms',

		'Students',

		'CounselingIntakeSubs' => [

		  'conditions' => [

			'CounselingIntakeSubs.visible' => 1

		  ]

		]

	  ])

	->where([

	  'CounselingIntakes.visible' => 1,

	  'CounselingIntakes.id' => $id

	])

	->first();

	$data['CounselingIntakeSub'] = $this->CounselingIntakeSubs->find()

	->where([

		'visible' => 1,

		'counseling_intake_id' => $id

	])

	->toArray();

	// debug($data['CounselingIntake']);

	$data['CounselingIntakeSub']['behave'] = explode(',',$data['CounselingIntakeSub'][0]['behavior']);

	if (!empty($data['CounselingIntakeSub']['behave'])){

	  foreach ($data['CounselingIntakeSub']['behave'] as $key => $value) {
		
		$data['CounselingIntakeSub']['behave'][$key] = $data['CounselingIntakeSub']['behave'][$key] == 1 ? true: false;

	  }

	}

	$data['CounselingIntakeSub']['feel'] = explode(',',$data['CounselingIntakeSub'][0]['feelings']);

	if (!empty($data['CounselingIntakeSub']['feel'])){

	  foreach ($data['CounselingIntakeSub']['feel'] as $key => $value) {
		
		$data['CounselingIntakeSub']['feel'][$key] = $data['CounselingIntakeSub']['feel'][$key] == 1 ? true: false;

	  }

	}

		$data['CounselingIntakeSub']['phy'] = explode(',',$data['CounselingIntakeSub'][0]['physical']);
	
	if (!empty($data['CounselingIntakeSub']['phy'])){

	  foreach ($data['CounselingIntakeSub']['phy'] as $key => $value) {
		
		$data['CounselingIntakeSub']['phy'][$key] = $data['CounselingIntakeSub']['phy'][$key] == 1 ? true: false;

	  }

	}

	$year = $this->YearLevelTerms->get($data['CounselingIntake']['Student']['year_term_id']);

	// debug($data['CounselingIntake']);

	$data['CounselingIntake']['student_name'] = ($data['CounselingIntake']['student_name']);
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 10);
	// $pdf->Image($this->base .'/assets/img/counseling_intake.png',0,0,215.9,355.6);
	$pdf->Ln(5);
		//? -----------------------------------------------------------------------------------  HEADER START
	$pdf->Image($this->base .'/assets/img/zam.png',5,15,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',190,15,20,25);
	$pdf->Ln(3.5);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(0, 5, 'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph  email: registrar@zscmst.edu.ph', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5, $pdf->getY() + 1, 187, $pdf->getY() + 1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5, $pdf->getY() + 2, 187, $pdf->getY() + 2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(14.5, $pdf->GetY() + 3.5, 31, 14.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6, 5, '', 0, 0, 'L');
	$pdf->Cell(68, 5, 'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'], 0, 0, 'L');
	$pdf->SetFont("Times", 'B', 14);
	$pdf->Cell(50, 5.5, 'GUIDANCE   AND   COUNSELING   OFFICE', 0, 0, 'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6, 5, '', 0, 0, 'L');
	$pdf->Cell(68, 5, 'Adopted Date:  '. @$office_reference['OfficeReference']['adopted'], 0, 0, 'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6, 5, '', 0, 0, 'L');
	$pdf->Cell(65, 5, 'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'], 0, 0, 'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(6, 5, '', 0, 0, 'L');
	$pdf->Cell(65, 5, 'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'], 0, 0, 'L');
	$pdf->Ln(1);
	$pdf->SetFont("Arial", 'B', 14);
	$pdf->Cell(0, 5, 'COUNSELING INTAKE FORM', 0, 0, 'C');
	//? -----------------------------------------------------------------------------------  Content  
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Line(25,$pdf->getY()+4,190,$pdf->getY()+4);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(15,5,'NAME: ',0,0,'L');
	$pdf->Cell(10,5,$data['CounselingIntake']['Student']['last_name'].", ".$data['CounselingIntake']['Student']['first_name'].", ".$data['CounselingIntake']['Student']['middle_name'],0,0,'L');
	$pdf->Line(36,$pdf->getY()+8,120,$pdf->getY()+8);
	$pdf->Line(140,$pdf->getY()+8,190,$pdf->getY()+8);
	$pdf->Ln(4);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(30,5,'Course and Year: ',0,0,'L');
	$pdf->Cell(80,5,$data['CounselingIntake']['CollegeProgram']['code']." - ".$year['description'],0,0,'L');
	$pdf->Cell(20,5,'Contact No.: ',0,0,'L');
	$pdf->Cell(80,5,$data['CounselingIntake']['contact_no'],0,0,'L');
	$pdf->Ln(4);
	$pdf->Line(30,$pdf->getY()+4,190,$pdf->getY()+4);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(20,5,'ADDRESS: ',0,0,'L');
	$pdf->Cell(80,5,$data['CounselingIntake']['address'],0,0,'L');
	$pdf->Ln(4);
	$pdf->Line(42,$pdf->getY()+5,70,$pdf->getY()+5);
	$pdf->Line(103,$pdf->getY()+5,190,$pdf->getY()+5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(30,5,'DATE OF BIRTH: ',0,0,'L');
	$pdf->Cell(30,5,$data['CounselingIntake']['birth_date']->format('m/d/Y'),0,0,'L');
	$pdf->Cell(30,5,'PLACE OF BIRTH: ',0,0,'L');
	$pdf->Cell(50,5,$data['CounselingIntake']['birth_place'],0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(0, 5, '*********************************************************************************************************************************************************************************', 0, 0, 'c');
	$pdf->Ln(6);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->Cell(0, 5, 'BEHAVIOR: Circle any of the following behaviors that apply to you:', 0, 0, 'C');
	//? -------------------------------------------------------------------------------------------------  BEHAVIOR  
	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][0])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Overeat', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][1])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Suicidal attempts', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][2])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Take drugs', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][3])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Insomnia', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][4])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Compulsions', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][5])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Smoking', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][6])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, ' Odd behavior', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][7])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Withdrawal', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][8])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Lack of Motivation', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][9])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Eating problems', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][10])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Procrastination', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][11])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Sleep disturbance', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][12])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Loss of Control', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][13])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Aggressive behavior', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][14])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, ' Others..', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Ln(7);
	$pdf->Cell(140, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['behave'][14]){
	  $pdf->Line(170, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	  $pdf->Cell(25, 5, 'Please Specify:', 0, 0, 'L');
	  $pdf->Cell(5, 5,$data['CounselingIntakeSub']['otherBehave'], 0, 0, 'L');
	}
	  //? -------------------------------------------------------------------------------------------------  FEELINGS  
	$pdf->Ln(7);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->Cell(0, 5, 'FEELINGS: Circle any of the following behaviors that apply to you:', 0, 0, 'C');
	$pdf->Ln(10);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][0])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Angry', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][1])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Guilty', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][2])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Unhappy ', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][3])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Annoyed', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][4])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, ' Happy', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][5])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Bored', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][6])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Sad', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');


	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][7])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Conflicted', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][8])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Restless', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][9])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Depressed', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][10])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Regretful', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][11])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, ' Lonely', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][13])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Anxious', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][14])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Jealous', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');


	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][15])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Contented', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][16])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Fearful', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][17])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Hopeful', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][18])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Excited', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][19])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Panicky', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][20])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, ' Helpless', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][21])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Envious', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][22])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Energetic', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][23])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Relaxed', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][24])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Tense', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][25])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Hopeless', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][26])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Optimistic', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][27])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Others:', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Ln(7);
	$pdf->Cell(140, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['feel'][27]){
	  $pdf->Line(170, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	  $pdf->Cell(25, 5, 'Please Specify:', 0, 0, 'L');
	  $pdf->Cell(5, 5,$data['CounselingIntakeSub']['otherFeel'], 0, 0, 'L');
	}
	$pdf->Ln(7);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->Cell(0, 5, 'BEHAVIOR: Circle any of the following behaviors that apply to you:', 0, 0, 'C');
	//? -------------------------------------------------------------------------------------------------  PHYSICAL  
	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][0])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Headaches', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][1])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Stomach trouble', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][2])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Skin problems', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][3])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Dizziness', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][4])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Tics', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][5])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Dry mouth', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][6])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Palpitations', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][7])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Fatigue', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][8])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Fatigue', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][9])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Itchy skin', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][10])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Chest pains', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][11])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Tensions', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][12])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Back pain', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][13])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Rapid heartbeat', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][14])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Numbness', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');


	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][15])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Sexual disturbances', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][16])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Unable to relax', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][17])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Fainting spells', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][18])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Bowel disturbances', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][19])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Visual disturbances', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][20])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Hearing problems', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][21])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Others:', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	if ($data['CounselingIntakeSub']['phy'][21]){
	  $pdf->Line(115, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	  $pdf->Cell(25, 5, 'Please Specify:', 0, 0, 'L');
	  $pdf->Cell(5, 5,$data['CounselingIntakeSub']['otherPhysical'], 0, 0, 'L');
	}
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(0, 5, '*********************************************************************************************************************************************************************************', 0, 0, 'c');
	$pdf->Ln(7);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(2, 5, 'PRESENT SITUATION', 0, 0, 'L');

	$yes = $no = "";
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(50, 5, 'Do you have problems at school?', 0, 0, 'L');
	if ($data['CounselingIntake']['school']==1)
	  $yes = 4;
	else if ($data['CounselingIntake']['school']==2) $no = 4;
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $yes, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'Yes', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $no, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'No', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Ln(7);  
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Cell(30, 5, 'If YES, please specify: ', 0, 0, 'L');
	$pdf->Cell(50, 5, $data['CounselingIntake']['schoolYes'], 0, 0, 'L');
	$pdf->Line(45, $pdf->getY() + 5, 200, $pdf->getY() + 5);

	$yes = $no = "";
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(50, 5, 'Do you have problems at Home?', 0, 0, 'L');
	if ($data['CounselingIntake']['home']==1)
	  $yes = 4;
	else if ($data['CounselingIntake']['home']==2) $no = 4;
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $yes, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'Yes', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $no, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'No', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Ln(7);  
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Cell(30, 5, 'If YES, please specify: ', 0, 0, 'L');
	$pdf->Cell(50, 5, $data['CounselingIntake']['homeYes'], 0, 0, 'L');
	$pdf->Line(45, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$yes = $no = "";
	
		
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(50, 5, 'Do you stay in a Boarding House?', 0, 0, 'L');
	if ($data['CounselingIntake']['bhouse']==1)
	  $yes = 4;
	else if ($data['CounselingIntake']['bhouse']==2) $no = 4;
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $yes, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'Yes', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $no, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'No', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(80, 5, 'If YES, Do you have problems in the Boarding House?', 0, 0, 'L');
	if ($data['CounselingIntake']['bhouseProb']==1)
	  $yes = 4;
	else if ($data['CounselingIntake']['bhouseProb']==2) $no = 4;
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $yes, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'Yes', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $no, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'No', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Ln(7);  
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(30, 5, 'If YES, please specify: ', 0, 0, 'L');
	$pdf->Cell(50, 5, $data['CounselingIntake']['bhouseYes'], 0, 0, 'L');
	$pdf->Line(50, $pdf->getY() + 5, 200, $pdf->getY() + 5);

	$yes = $no = "";
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(60, 5, 'Is there something bothering you right now?', 0, 0, 'L');
	if ($data['CounselingIntake']['bother']==1)
	  $yes = 4;
	else if ($data['CounselingIntake']['bother']==2) $no = 4;
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $yes, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'Yes', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $no, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'No', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Ln(7);  
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->Cell(30, 5, 'If YES, please specify: ', 0, 0, 'L');
	$pdf->Cell(50, 5, $data['CounselingIntake']['botherYes'], 0, 0, 'L');
	$pdf->Line(45, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$yes = $no = "";
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(80, 5, 'Do you wish to talk further to your Guidance Counselor?', 0, 0, 'L');
	if ($data['CounselingIntake']['guidance']==1)
	  $yes = 4;
	else if ($data['CounselingIntake']['guidance']==2) $no = 4;
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $yes, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(10, 5, 'Yes', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(5, 5, $no, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'No', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');


	date_default_timezone_set('Asia/Manila');
	$todays_date = date("F d, Y");
	$pdf->Ln(15);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(140, 5, '', 0, 0, 'L');
	$pdf->Line(25, $pdf->getY() + 5, 100, $pdf->getY() + 5);
	$pdf->Cell(65, 5, $todays_date, 0, 0, 'L');
	$pdf->Line(190, $pdf->getY() + 5, 135, $pdf->getY() + 5);
	$pdf->Ln(5);
	$pdf->Cell(35, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Signature of Student', 0, 0, 'L');
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(100, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Date', 0, 0, 'L');
	$pdf->Ln(15);
	$pdf->SetFont("Arial", 'I', 9.5);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Remarks: ', 0, 0, 'L');
	$pdf->Cell(65, 5, '', 0, 0, 'L');
	$pdf->Line(30, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Ln(15);

	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(140, 5, '', 0, 0, 'L');
	$pdf->Cell(65, 5, $todays_date, 0, 0, 'L');
	$pdf->Line(25, $pdf->getY() + 5, 100, $pdf->getY() + 5);

	$pdf->Line(190, $pdf->getY() + 5, 135, $pdf->getY() + 5);
	$pdf->Ln(5);
	$pdf->Cell(25, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Counselors Name over Signature', 0, 0, 'L');
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(108, 5, '', 0, 0, 'L');
	$pdf->Cell(15, 5, 'Date', 0, 0, 'L');


	$pdf->output();
	exit();

  }

  public function apartelleRegistration(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(ApartelleRegistration.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ApartelleRegistration.date) >= '$start' AND DATE(ApartelleRegistration.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	 $conditions['status'] = '';

	if ($this->request->getQuery('status')) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND ApartelleRegistration.approve = $status";
	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $student_id = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND ApartelleRegistration.student_id = $student_id";

	}

	$tmpData = $this->ApartelleRegistrations->getAllApartelleRegistrationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'APARTELLE/DORMITORY REGISTRATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(60,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(35,5,'NICK NAME',1,0,'C',1);
	$pdf->Cell(35,5,'DATE OF BIRTH',1,0,'C',1);
	$pdf->Cell(65,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(35,5,'COURSE',1,0,'C',1);
	$pdf->Cell(35,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Cell(35,5,'STATUS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,60,35,35,65,35,35,35));
	$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C'));

	if(count($tmpData) > 0){

	  $approve = '';

	  foreach ($tmpData as $key => $data){ 

		if($data['approve'] == 0){

		  $approve = 'PENDING';

		}else if($data['approve'] == 2){

		  $approve = 'DISAPPROVED';

		}else if($data['approve'] == 1){

		  $approve = 'APPROVED';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['nick_name'],

		  fdate($data['date_of_birth'],'m/d/Y'),  

		  $data['address'],

		  $data['college_program'],

		  $data['description'],

		  $approve

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function apartelleStudentClearance(){

	$conditions = [];

	$conditionsPrint = '';

	$condition['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND ApartelleStudentClearance.approve = $status";
 
	  $conditionsPrint .= '&status='.$this->request->getQuery('status');

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')!=null) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $studentId = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND ApartelleStudentClearance.student_id = $studentId";

	  $conditionsPrint .= '&per_student='.$per_student;

	}

	$tmpData = $this->ApartelleStudentClearances->getAllApartelleStudentClearancePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'APARTELLE/DORMITORY REGISTRATION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(90,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(105,5,'COLLEGE PROGRAM',1,0,'C',1);
	$pdf->Cell(70,5,'YEAR LEVEL',1,0,'C',1);
	$pdf->Cell(35,5,'STATUS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,90,105,70,35));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if(count($tmpData)>0){

	  $approve = '';

	  foreach ($tmpData as $key => $data){ 

		if($data['approve'] == 0){

		  $approve = 'PENDING';

		}else if($data['approve'] == 2){

		  $approve = 'DISAPPROVED';

		}else if($data['approve'] == 1){

		  $approve = 'APPROVED';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['name'],

		  $data['description'],  

		  $approve

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function listApartelle(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(ApartelleRegistration.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ApartelleRegistration.date) >= '$start' AND DATE(ApartelleRegistration.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	 $conditions['status'] = '';

	if ($this->request->getQuery('status')) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND ApartelleRegistration.approve = $status";
	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $student_id = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND ApartelleRegistration.student_id = $student_id";

	}

	$tmpData = $this->Apartelles->getAllApartellePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'APARTELLE/DORMITORY',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(70,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(70,5,'BUILDING NO.',1,0,'C',1);
	$pdf->Cell(60,5,'ROOM NO.',1,0,'C',1);
	$pdf->Cell(60,5,'PRICE ',1,0,'C',1);
	$pdf->Cell(70,5,'CAPACITY',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,70,70,60,60,70));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){ 

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['building_no'],

		  $data['room_no'],

		  $data['price'],

		  $data['capacity']

		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function apartelleMonthlyPayments(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search') != null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$start = date('Y-m-').'01'; 

	$end = date('Y-m-t');

	$conditions['date'] = " AND DATE(Payment.date) >= '$start' AND DATE(Payment.date) <= '$end'";

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Payment.date) = '$search_date'";

	}  

	if ($this->request->getQuery('startDate') != null) {

	  $start = fdate($this->request->getQuery('startDate'),'Y-m-d'); 

	  $end = fdate($this->request->getQuery('endDate'),'Y-m-d');

	  $conditions['date'] = " AND DATE(Payment.date) >= '$start' AND DATE(Payment.date) <= '$end'";

	}

	$tmpData = $this->Reports->getAllMonthlyPaymentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'APARTELLE/DORMITORY MONTHLY PAYMENT REPORT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(70,5,'REFERENCE NUMBER',1,0,'C',1);
	$pdf->Cell(70,5,'STUDENT NAME ',1,0,'C',1);
	$pdf->Cell(60,5,'STUDENT NO. ',1,0,'C',1);
	$pdf->Cell(60,5,'COLLEGE PROGRAM ',1,0,'C',1);
	$pdf->Cell(35,5,'DATE',1,0,'C',1);
	$pdf->Cell(35,5,'AMOUNT ',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,70,70,60,60,35,35));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){ 

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['or_no'],

		  $data['student_name'],

		  $data['student_no'],

		  $data['program'],

		  fdate($data['date'],'m/d/Y'),

		  $data['amount']

		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function listStudents(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

	}

	$conditions['year_term_id'] = " AND Student.year_term_id IS NULL";

	$conditions['year_term_id_enrollment'] = '';

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

	  $conditions['year_term_id_enrollment'] = " AND StudentEnrollment.year_term_id = $year_term_id";

	}

	$tmpData = $this->Reports->getAllListStudentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF STUDENT REPORT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,8,'#',1,0,'C');
	$pdf->Cell(22,4,'STUDENT','LTR',0,'C');
	$pdf->Cell(45,8,'STUDENT NAME',1,0,'C');
	$pdf->Cell(58,8,'COLLEGE',1,0,'C');
	$pdf->Cell(50,8,'PROGRAM',1,0,'C');
	$pdf->Cell(22,4,'REGISTRATION','LTR',0,'C');
	$pdf->Ln(4);
	$pdf->Cell(8,4,'',0,0,'C');
	$pdf->Cell(22,4,'NUMBER','LBR',0,'C');
	$pdf->Cell(153,4,'',0,0,'C');
	$pdf->Cell(22,4,'DATE','LBR',0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,22,45,58,50,22));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['college'],

		  $data['program'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function studentApplications(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}


	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(ScholarshipApplication.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ScholarshipApplication.date) >= '$start' AND DATE(ScholarshipApplication.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = " AND ScholarshipApplication.approve = $status";

	}

	$conditions['rate'] = '';

	if ($this->request->getQuery('rate')) {

	  $rate = $this->request->getQuery('rate');

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}
	
	$tmpData = $this->ScholarshipApplications->getAllScholarshipApplicationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Scholarship Applications',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(8,5,'#',1,0,'C',1);
	$pdf->Cell(25,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(25,5,'DATE APPLIED',1,0,'C',1);
	$pdf->Cell(37,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(12,5,'AGE',1,0,'C',1);
	$pdf->Cell(17,5,'SEX',1,0,'C',1);
	$pdf->Cell(31,5,'STATUS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,25,50,25,37,12,17,31));
	$pdf->SetAligns(array('C','C','L','C','L','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$status = '';

		if($data['approve'] == 0){

		  $status = 'PENDING';

		}elseif($data['approve'] == 1){

		  $status = 'FOR PROCESSING';

		}elseif($data['approve'] == 2){

		  $status = 'DISAPPROVED';

		}elseif($data['approve'] == 4){

		  $status = 'CONFIRMED';

		}

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'],'m/d/Y'),

		  $data['name'],

		  $data['age'],

		  $data['sex'],

		  $status

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+90,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+115,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function scholarshipApplicationForm($id = null){

	$office_reference = $this->Global->OfficeReference('Scholarship Application');

	$data['ScholarshipApplication'] = $this->ScholarshipApplications->find()

	->contain([

		'Students',

		'CollegePrograms',

		'YearLevelTerms'

	])

	->where([

		'ScholarshipApplications.visible' => 1,

		'ScholarshipApplications.id' => $id

	])

	->first();

	$data['CollegeProgram'] = $data['ScholarshipApplication']['college_program'];

	$data['YearLevelTerm'] = $data['ScholarshipApplication']['year_level_term'];

	$data['YearLevelTerm']['year'] = $data['YearLevelTerm'] != null ? $data['YearLevelTerm']['year'] : '' ;

	unset($data['ScholarshipApplication']['college_program']);

	unset($data['ScholarshipApplication']['year_level_term']);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,6,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Arial", '', 11.5);
   
	$pdf->Image($this->base .'/assets/img/zam.png',12,8,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',182,8,18,21);
	$pdf->Ln(3.5);
	
	$pdf->Ln(4.5);
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 10.5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph ',0,0,'C');

	$pdf->SetLineWidth(0.7);
	$pdf->Line(10,$pdf->getY()+9,205,$pdf->getY()+9);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(6);
	$pdf->SetFont("Times", '', 14);
	$pdf->Cell(80);
	$pdf->Cell(45,20,'ADMISSION AND SCHOLARSHIP OFFICE',0,0,'C');
	$pdf->Ln(8);
	$pdf->Cell(70);
	$pdf->SetFont("Arial", '', 12);
	$pdf->Cell(65,20,'APPLICATION FOR SCHOLARSHIP',0,0,'C');
	$pdf->Ln(21);
	
	$pdf->Rect(165.5,$pdf->GetY() -12,31.5,13);
	$pdf->Ln(4);
	$pdf->SetY($pdf->getY()- 15.6);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(154);
	$pdf->Cell(68,4,'ZSCMST-' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(-154);
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted: '. @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(-154);
	$pdf->Ln(2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(1);

	$check1 = '';
	$check2 = '';

	if($data['ScholarshipApplication']['semester'] == 1){

	  $check1 = 4;


	}elseif($data['ScholarshipApplication']['semester'] == 2){

	  $check2 = 4;

	}

	$pdf->SetFont("calibri", '', 12);
	$pdf->Cell(70);
	$pdf->Cell(6,5,'1st',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check1,0,0,'L');
	$pdf->SetFont("calibri", '', 12);
	$pdf->Cell(8,5,'2nd',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check2,0,0,'L');
	$pdf->SetFont("calibri", '', 12);
	$pdf->Cell(9,5,'SY:',0,0,'L');
	$pdf->Cell(10,5,$data['ScholarshipApplication']['school_year'],0,0,'L');
	$pdf->Line(110,$pdf->getY()+4,125,$pdf->getY()+4);
	
	$pdf->Ln(8);

	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(7);
	$pdf->Cell(30,5,'Date Applied:',0,0,'L');
	$pdf->Cell(30,5,$data['ScholarshipApplication']['date'] != null ? $data['ScholarshipApplication']['date']->format('m/d/Y') : null,0,0,'L');
	$pdf->Line(40,$pdf->getY()+4,70,$pdf->getY()+4);

	$pdf->Ln(12);
	$pdf->Cell(7);
	$pdf->Cell(42,5,'Name of Applicant:',0,0,'L');
	$pdf->Cell(70,5,$data['ScholarshipApplication']['student_name'],0,0,'L');
	$pdf->Line(43,$pdf->getY()+4,125,$pdf->getY()+4);
	$pdf->Cell(25,5,'Civil Status:',0,0,'L');
	$pdf->Cell(20,5,$data['ScholarshipApplication']['civil_status'],0,0,'L');
	$pdf->Line(146,$pdf->getY()+4,170,$pdf->getY()+4);
	$pdf->Cell(10,5,'Sex:',0,0,'L');
	$pdf->Cell(10,5,$data['ScholarshipApplication']['sex'],0,0,'L');
	$pdf->Line(178,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(60);
	$pdf->SetFont("calibri", '', 9);
	$pdf->Cell(42,5,'(Family Name/Given Name/Middle Name)',0,0,'C');
	$pdf->Ln(8);
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(7);
	$pdf->Cell(40,5,'Present Address:',0,0,'L');
	$pdf->Cell(72,5,@$data['ScholarshipApplication']['provincial_address'],0,0,'L');
	$pdf->Line(42,$pdf->getY()+4,125,$pdf->getY()+4);
	$pdf->Cell(25,5,'Contact #',0,0,'L');
	$pdf->Cell(20,5,$data['ScholarshipApplication']['contact_number'],0,0,'L');
	$pdf->Line(144,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(40,5,'Provincial Address:',0,0,'L');
	$pdf->Cell(72,5,@$data['ScholarshipApplication']['provincial_address'],0,0,'L');
	$pdf->Line(45,$pdf->getY()+4,125,$pdf->getY()+4);
	$pdf->Cell(25,5,'Email Add:',0,0,'L');
	$pdf->Cell(20,5,$data['ScholarshipApplication']['email'],0,0,'L');
	$pdf->Line(146,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(60,5,'Senior High School Graduated:',0,0,'L');
	$pdf->Cell(98,5,@$data['ScholarshipApplication']['senior_high_graduated'],0,0,'L');
	$pdf->Line(62,$pdf->getY()+4,170,$pdf->getY()+4);
	$pdf->Cell(20,5,'Gen. Ave.:',0,0,'L');
	$pdf->Cell(10,5,$data['ScholarshipApplication']['gen_ave'],0,0,'L');
	$pdf->Line(190,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(35,5,'School Address:',0,0,'L');
	$pdf->Cell(76,5,@$data['ScholarshipApplication']['senior_high_address'],0,0,'L');
	$pdf->Line(40,$pdf->getY()+4,125,$pdf->getY()+4);
	$pdf->Cell(25,5,'Religion:',0,0,'L');
	$pdf->Cell(20,5,$data['ScholarshipApplication']['religion'],0,0,'L');
	$pdf->Line(142,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(20,5,'Birthdate:',0,0,'L');
	$pdf->Cell(30,5,$data['ScholarshipApplication']['birthdate'] != null ? $data['ScholarshipApplication']['birthdate']->format('m/d/Y') : null,0,0,'L');
	$pdf->Line(31,$pdf->getY()+4,60,$pdf->getY()+4);
	$pdf->Cell(30,5,'Place of Birth:',0,0,'L');
	$pdf->Cell(70,5,$data['ScholarshipApplication']['place_of_birth'],0,0,'L');
	$pdf->Line(90,$pdf->getY()+4,160,$pdf->getY()+4);
	$pdf->Cell(10,5,'Age:',0,0,'L');
	$pdf->Cell(10,5,$data['ScholarshipApplication']['age'],0,0,'C');
	$pdf->Line(172,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);

	$check3 = '';
	$check4 = '';

	if($data['ScholarshipApplication']['isnew'] == 1){

	  $check3 = 4;


	}elseif($data['ScholarshipApplication']['isnew'] == 0){

	  $check4 = 4;

	}

	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(21,5,'New Student',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check3,0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(21,5,'Old Student',0,0,'L');
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check4,0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(40,5,'Indicate Course & Year:',0,0,'L');
	$pdf->Cell(68,5,$data['CollegeProgram']['code'].'    ::    '.$data['YearLevelTerm']['year'],0,0,'L');
	$pdf->Line(105,$pdf->getY()+4,170,$pdf->getY()+4);
	$pdf->Cell(12,5,'GWA:',0,0,'L');
	$pdf->Cell(10,5,$data['ScholarshipApplication']['gwa'],0,0,'C');
	$pdf->Line(187,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(40,5,'Name of Scholarship Applying:',0,0,'L');
	$pdf->Ln(8);
	$pdf->Cell(15);


	$check5 = '';
	$check6 = '';
	$check7 = '';

	if($data['ScholarshipApplication']['scholarship_type'] == 1){

	  $check5 = 4;


	}elseif($data['ScholarshipApplication']['scholarship_type'] == 2){

	  $check6 = 4;

	}elseif($data['ScholarshipApplication']['scholarship_type'] == 3){

	  $check7 = 4;

	}


	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check5,0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(5,5,'Non-Institutional',0,0,'L');
	$pdf->Line(58,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(15);
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check6,0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(5,5,'Disability(PWD)(Recommended/Approved by coordinator)',0,0,'L');
	$pdf->Line(118,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(15);
	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check7,0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(5,5,'Indigenous People Group (Recommended/Approved by coordinator) ',0,0,'L');
	$pdf->Line(138,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(36,5,'Name of Father:',0,0,'L');
	$pdf->Cell(78,5,$data['ScholarshipApplication']['father_name'],0,0,'L');
	$pdf->Line(40,$pdf->getY()+4,125,$pdf->getY()+4);
	$pdf->Cell(20,5,'Occupation:',0,0,'L');
	$pdf->Cell(20,5,$data['ScholarshipApplication']['father_occupation'],0,0,'L');
	$pdf->Line(147,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(60);
	$pdf->SetFont("calibri", '', 9);
	$pdf->Cell(42,5,'(Family Name/Given Name/Middle Name)',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(7);
	$pdf->Cell(40,5,"Mother's Maiden Name:",0,0,'L');
	$pdf->Cell(92,5,$data['ScholarshipApplication']['mother_maiden'],0,0,'L');
	$pdf->Line(52,$pdf->getY()+4,145,$pdf->getY()+4);
	$pdf->Cell(40,5,"Number of Sibling:",0,0,'L');
	$pdf->Cell(78,5,$data['ScholarshipApplication']['number_sibling'],0,0,'L');
	$pdf->Line(178,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(70);
	$pdf->SetFont("calibri", '', 9);
	$pdf->Cell(42,5,'(Family Name/Given Name/Middle Name)',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(7);
	$pdf->Cell(50,5,"Household per Capital Income:",0,0,'L');
	$pdf->Cell(50,5,$data['ScholarshipApplication']['household_income'],0,0,'L');
	$pdf->Line(60,$pdf->getY()+4,110,$pdf->getY()+4);
	$pdf->Cell(40,5,"DSWD Household No.:",0,0,'L');
	$pdf->Cell(92,5,$data['ScholarshipApplication']['household_number'],0,0,'L');
	$pdf->Line(150,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(4);
	$pdf->Cell(150);
	$pdf->SetFont("calibri", '', 9);
	$pdf->Cell(42,5,'(Leave Blank if not applicable)',0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(7);
	$pdf->Cell(45,5,"Do you have any sponsor?",0,0,'L');


	$check8 = '';
	$check9 = '';


	if($data['ScholarshipApplication']['issponsor'] == 1){

	  $check8 = 4;


	}elseif($data['ScholarshipApplication']['issponsor'] == 0){

	  $check9= 4;

	}

	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check8,0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(7,5,'Yes',0,0,'L');

	$pdf->Cell(1,5,'(  )',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(5,5,$check9,0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(5,5,'No',0,0,'L');
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(30);
	$pdf->Cell(35,5,"Name of Scholarship:",0,0,'L');
	$pdf->Cell(50,5,@$data['ScholarshipApplication']['scholarship_name'],0,0,'L');
	$pdf->Line(147,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(65,5,"Name of Scholarship Sponsor/Agency:",0,0,'L');
	$pdf->Cell(70,5,$data['ScholarshipApplication']['sponsor_name'],0,0,'L');
	$pdf->Line(72,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(55,5,"Address of Sponsor/Agency:",0,0,'L');
	$pdf->Cell(70,5,$data['ScholarshipApplication']['sponsor_address'],0,0,'L');
	$pdf->Line(62,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(40,5,"Contact Person:",0,0,'L');
	$pdf->Cell(81,5,$data['ScholarshipApplication']['contact_person'],0,0,'L');
	$pdf->Line(40,$pdf->getY()+4,133,$pdf->getY()+4);
	$pdf->Cell(20,5,"Position:",0,0,'L');
	$pdf->Cell(70,5,$data['ScholarshipApplication']['sponsor_position'],0,0,'L');
	$pdf->Line(150,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(40,5,"Contact Number: Office:",0,0,'L');
	$pdf->Cell(50,5,$data['ScholarshipApplication']['sponsor_contact_office'],0,0,'L');
	$pdf->Line(52,$pdf->getY()+4,100,$pdf->getY()+4);
	$pdf->Cell(20,5,"Mobile #",0,0,'L');
	$pdf->Cell(70,5,$data['ScholarshipApplication']['sponsor_contact_mobile'],0,0,'L');
	$pdf->Line(120,$pdf->getY()+4,200,$pdf->getY()+4);
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Cell(40,5,"Why do you think you deserve to be given a scholarship assistance?",0,0,'L');
	$pdf->Ln(8);
	$pdf->Cell(7);
	$pdf->Line(13,$pdf->getY()+6,200,$pdf->getY()+6);
	$pdf->Line(13,$pdf->getY()+12,200,$pdf->getY()+12);
	$pdf->Line(13,$pdf->getY()+18,200,$pdf->getY()+18);
	$pdf->Line(13,$pdf->getY()+24,200,$pdf->getY()+24);
	$y = $pdf->getY();
	$pdf->MultiCell(190, 6,$data['ScholarshipApplication']['reason'],0,'L',0);

	$pdf->SetY($y+24);
	$pdf->Ln(17);
	$y = $pdf->Gety();
	$pdf->Rect(13,$pdf->GetY(),60,35);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(12,5,"Date Filed: ",0,0,'L');
	$pdf->SetFont("calibri", 'U', 8);
	$pdf->Cell(20,5,"                 ",0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(7,5,"Head, Admission and Scholarship Office",0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(7,5,"Attached Requirements:",0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(7,5,"(Xerox Only)",0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(7,5,"___Copy of Previous grades",0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(7,5,"___Good Moral Character",0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(7,5,"___ Certificate of Registration (COR)",0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont("calibri", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(7,5,"___Barangay Certificate (Indigence)",0,0,'L');
	$pdf->Ln(1);


	$pdf->SetY($y+4);

	$pdf->Cell(150);
	$pdf->SetFont("calibri", '', 11);
	$pdf->Cell(18,5,"(Signature Of Student Applicant)",0,0,'C');
	$pdf->Line(130,$pdf->getY()-1,200,$pdf->getY()-1);
	$pdf->output();
	exit();

  }

  public function certificateRegistrations($id = null){

	$office_reference = $this->Global->OfficeReference('Registered Student');

	$student = $this->Students->find()

	  ->contain([

		'YearLevelTerms',

		'Colleges' => array(

		  'conditions' => ['Colleges.visible' => 1]

		),

		'CollegePrograms' => array(

		  'conditions' => ['CollegePrograms.visible' => 1]

		),

		'StudentEnrolledCourses' => array(

		  'conditions' => [

			'StudentEnrolledCourses.visible' => 1,

		  ]

		),

		'StudentEnrolledUnits' => array(

		  'conditions' => ['StudentEnrolledUnits.visible' => 1]

		),

		'StudentEnrollments' => array(

		  'conditions' => ['StudentEnrollments.visible' => 1]

		),

	  ])

	  ->where([

		'Students.visible' => 1,

		'Students.id' => $id,

	  ])

	->first();

	if($student) {

	  $data['YearLevelTerm'] = $student->year_level_term;

	  $data['CollegeProgram'] = $student->college_program;

	  $data['StudentEnrolledCourse'] = $student->student_enrolled_courses;

	  $data['StudentEnrolledUnit'] = $student->student_enrolled_units;

	  $data['StudentEnrollment'] = $student->student_enrollments;

	  $data['College'] = $student->college;

	  unset($student->year_level_term);

	  unset($student->college_program);

	  unset($student->student_enrolled_courses);

	  unset($student->student_enrolled_units);

	  unset($student->student_enrollments);

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

			  'time' => date('h:i A', strtotime($values->time_start)). ' - ' . date('h:i A', strtotime($values->time_end)),

			  'room' => $values->room,

			  'faculty_name' => $values->faculty_name,

			];

		  }

		}

		$data['StudentEnrolledCourse'][$key]['subs'] = $subs;

	  }

	}

	$student_name = @$data['Student']['last_name'].', '.$data['Student']['first_name'].' '.$data['Student']['middle_name'];

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10, 6, 10);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11);
	$pdf->Image($this->base . '/assets/img/zam.png', 10, 4, 15, 15);
	$pdf->Image($this->base . '/assets/img/iso.png', 150, 4, 13, 16);
	$pdf->Ln();
	$pdf->SetFont("Arial", 'B', 9.5);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'L');
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(164, $pdf->GetY()+1, 43, 9);
	$pdf->Ln(1);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(164, 5, '', 0, 0, 'L');
	$pdf->Cell(78, 5, 'ZSCMST-' . @$office_reference['OfficeReference']['reference_code'], 0, 0, 'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", '', 6);
	$pdf->Cell(129, 5, '', 0, 0, 'R');
	$pdf->Cell(68, 5, 'Adopted Date: '. @$office_reference['OfficeReference']['adopted'], 0, 0, 'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(137, 5, '', 0, 0, 'R');
	$pdf->Cell(60, 5, 'Revision Status: '. @$office_reference['OfficeReference']['revision_status'] .' Revision Date: '. @$office_reference['OfficeReference']['revision_date'], 0, 0, 'R');
	// $pdf->Ln(2.5);
	// $pdf->SetFont("Times", '', 6);
	// $pdf->Cell(130.5, 5, '', 0, 0, 'R');
	// $pdf->Cell(59, 5, '', 0, 0, 'R');
	$pdf->Ln();
	$pdf->SetXY(10, $pdf->getY()-5);
	$pdf->SetFont("Arial", 'B', 20);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(0, 5, 'CERTIFICATE OF REGISTRATION', 0, 0, 'L');
	$pdf->SetFont("Arial", '', 9);
	$pdf->Rect(11, $pdf->getY()+10, 195, $pdf->getY()+9);
	$pdf->Ln(10.5);
	$pdf->Cell(1);
	$pdf->Cell(90, 5, 'Family Name, First Name MI', 0, 0, 'L');
	$pdf->Line($pdf->getX(),$pdf->getY(),$pdf->getX(),$pdf->getY()+11);
	$pdf->Cell(50, 5, 'SEMESTER/SCHOOL YEAR', 0, 0, 'L');
	$pdf->Line($pdf->getX(),$pdf->getY(),$pdf->getX(),$pdf->getY()+11);
	$pdf->Cell(70, 5, 'STUDENT.NO :', 0, 0, 'L');
	$pdf->Ln();
	$pdf->Cell(3);
	$pdf->Cell(90, 5, $student_name , 0, 0, 'L');
	$pdf->Cell(50, 5, $data['YearLevelTerm']['semester'].' - '.$data['Student']['school_year'] , 0, 0, 'L');
	$pdf->Cell(70, 5, $data['Student']['student_no'], 0, 0, 'L');
	$pdf->Line(11,$pdf->getY()+6,206,$pdf->getY()+6);
	$pdf->Ln(6);
	$pdf->Cell(1);
	$pdf->Cell(30, 5, 'COURSE : ', 0, 0, 'L');
	$pdf->Line($pdf->getX(),$pdf->getY(),$pdf->getX(),$pdf->getY()+9);
	$pdf->Cell(30, 5, 'MAJOR : ', 0, 0, 'L');
	$pdf->Line($pdf->getX(),$pdf->getY(),$pdf->getX(),$pdf->getY()+9);
	$pdf->Cell(90, 5, 'COLLEGE : ', 0, 0, 'L');
	$pdf->Line($pdf->getX(),$pdf->getY(),$pdf->getX(),$pdf->getY()+9);
	$pdf->Cell(25, 5, 'YEAR LEVEL : ', 0, 0, 'L');
	$pdf->Line($pdf->getX(),$pdf->getY(),$pdf->getX(),$pdf->getY()+9);
	$pdf->Cell(20, 5, 'STATUS : ', 0, 0, 'L');
	$pdf->Ln();
	$pdf->Cell(3);
	$pdf->Cell(30, 5, $data['CollegeProgram']['code'], 0, 0, 'L');
	$pdf->Cell(30, 5, $data['CollegeProgram']['major'], 0, 0, 'L');
	$pdf->Cell(90, 5, $data['College']['name'], 0, 0, 'L');
	$pdf->Cell(25, 5, $data['YearLevelTerm']['year'], 0, 0, 'L');
	if($data['Student']['active']==1){
	  $active = "Continuing";
	}
	$pdf->Cell(30, 5, $active, 0, 0, 'L');
	$pdf->Ln(4.5);
	

	// '.$active, 'LBR', 1);
		$pdf->getY()-7;
	// print_r($data);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(20, 5, 'Subj Title', 1, 0, 'C');
	$pdf->Cell(65, 5, 'DESCRIPTION', 1, 0, 'C');
	$pdf->Cell(20,5, 'UNITS', 1, 0, 'C');
	$pdf->Cell(30, 5, 'TIME', 1, 0, 'C');
	$pdf->Cell(15, 5, 'DAYS', 1, 0, 'C');
	$pdf->Cell(15, 5, 'SECTION', 1, 0, 'C');
	$pdf->Cell(30, 5, 'FACULTY', 1, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetWidths(array(20,65,10,10,30,15,15,30));
	$pdf->SetAligns(array('C','L','C','C','C','C','C','C'));
	$pdf->SetFont("Arial", '', 7);
	$rows = 0;
	
	if(!empty($data['StudentEnrolledCourse'])){

	  foreach ($data['StudentEnrolledCourse'] as $key => $value) {

		if($value['year_term_id'] == $data['Student']['year_term_id']){

		  $block_section_course = $this->BlockSectionCourses->find()

			->where([

			  'visible' => 1,

			  'id' => $value['block_section_course_id']

			])

		  ->first();

		  $rows += 1;

		  $days = '';

		  $time = '';

		  $room = '';

		  $faculty_name = '';

		  if(!empty($value['subs'])){

			foreach ($value['subs'] as $keys => $values) {
			  if($values['days']=="Monday"){
				$days .= 'M';
			  }
			  else if($values['days']=="Tuesday"){
				$days .= 'T';
			  }
			  
			  else if($values['days']=="Wednesday"){
				$days .= 'W';
			  }
			  
			  else if($values['days']=="Thusrday"){
				$days .= 'TH';
			  }
			  
			  else if($values['days']=="Friday"){
				$days .= 'F';
			  }
			  
			  $time .= $values['time']."\n";

			  $room .= $values['room']."\n";

			  $faculty_name .= $values['faculty_name']."\n";

			}

		  }
		  
		  $pdf->Cell(1, 5, '', 0, 0, 'L');

		  $lab = ($value['laboratory_unit'] > 0 && $value['laboratory_unit'] != null ) ? "lab" : "";

		  $lecture = ($value['lecture_unit'] > 0 && $value['lecture_unit'] != null ) ? "lecture" : "";

		  $pdf->RowLegalP(array(

			$value['course_code'],

			strtoupper($value['course']),

			$lab,

			$lecture,

			$time,

			$days,

			$value['section'],

			$block_section_course['faculty_name'] != null ? $block_section_course['faculty_name'] : 'To be assigned'

		  ));

		}

	  }

	}

	if($rows < 12){

	  for($x = $rows;$x<=12;$x++){
		
		$pdf->Cell(1, 7, '', 0, 0, 'L');
		$pdf->Cell(20, 7, '', 1, 0, 'C');
		// $pdf->Cell(15, 7, '', 1, 0, 'C');
		$pdf->Cell(65, 7, '', 1, 0, 'C');
		$pdf->Cell(10, 7, '', 1, 0, 'C');
		$pdf->Cell(10, 7, '', 1, 0, 'C');
		$pdf->Cell(30, 7, '', 1, 0, 'C');
		$pdf->Cell(15, 7, '', 1, 0, 'C');
		$pdf->Cell(15, 7, '', 1, 0, 'C');
		$pdf->Cell(30, 7, '', 1, 0, 'C');
		$pdf->Ln(7);
		
	  }

	}

	$assessment['Assessment'] = $this->Assessments->find()

	->contain([

	  'AssessmentSubs' => [

		'conditions' => ['AssessmentSubs.visible' => 1]

	  ]

	])

	->where([

	  'Assessments.visible' => 1,

	  'Assessments.student_id' => $id

	])

	->first();



	$assessment['AssessmentSub'] = $assessment['Assessment']->assessment_subs;

	unset($assessment['Assessment']->assessment_subs);
	
	$pdf->Ln(7);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(195, 5, 'ASSESSMENT', 1, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'DESCRIPTION', 1, 0, 'C');
	$pdf->Cell(20, 5, 'UNITS', 1, 0, 'C');
	$pdf->Cell(20, 5, 'AMOUNT', 1, 0, 'C');
	$pdf->Cell(20, 5, 'TOTAL', 1, 0, 'C');
	$pdf->Ln(5);
	if($assessment['AssessmentSub'][0]['admission_fee'] != null){
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'ADMISSION FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['admission_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['admission_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	}
	if($assessment['AssessmentSub'][0]['handbook_fee'] != null){
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'HANDBOOK FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['handbook_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['handbook_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	}
	if($assessment['AssessmentSub'][0]['entrance_fee'] != null){
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'ENTRANCE FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['entrance_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['entrance_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	}
	if($assessment['AssessmentSub'][0]['registration_fee'] != null){
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'REGISTRATIION FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['registration_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['registration_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	}
	if($assessment['AssessmentSub'][0]['school_id_fee'] != null){
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'SCHOOL ID FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['school_id_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['school_id_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	}
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'ATHLETICS FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['athletics_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['athletics_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'CULTURAL FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['cultural_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['cultural_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'DEVT FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['development_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['development_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'GUIDANCE FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['guidance_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['guidance_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'LIBRARY FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['library_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['library_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'MEDICAL/DENTAL FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['medical_dental_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['medical_dental_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'TUITION FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['tuition_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['tuition_fee'], 1, 0, 'L');
	$pdf->Ln(5);

	if($assessment['AssessmentSub'][0]['laboratory_fee'] != null){
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, 'LABORATORY FEE', 1, 0, 'L');
	$pdf->Cell(20, 5, '1.00', 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['laboratory_fee'], 1, 0, 'L');
	$pdf->Cell(20, 5, $assessment['AssessmentSub'][0]['laboratory_fee'], 1, 0, 'L');
	$pdf->Ln(5);
	}

	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, '', 0, 0, 'L');
	$pdf->Cell(35, 5, 'TOTAL CHARGES', 0, 0, 'C');
	$pdf->Cell(25, 5, $assessment['AssessmentSub'][0]['total'], 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(135, 5, '', 0, 0, 'L');
	$pdf->Cell(35, 5, 'SCHOLAR RA10931', 0, 0, 'C');
	$pdf->Cell(25, 5, '2615.00', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(130, 5, '', 0, 0, 'L');
	$pdf->Cell(40, 5, 'TOTAL SCHOLAR & CHARGES', 0, 0, 'C');
	$pdf->Cell(25, 5, '0.00', 0, 0, 'C');

	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Ln(10);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(155, 5, 'Username & Password: '.$data['Student']['student_no'].' '.$data['Student']['last_name'].'       Credit Units: ', 1, 0, 'L');
	$pdf->SetFont("Times", '', 7);
	$pdf->SetXY(10, $pdf->getY()+5);
	$pdf->Rect(11,$pdf->GetY(),105,22);
	$pdf->Rect(116,$pdf->GetY(),50,22);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(110, 5, 'Please log on to your account to verify the subjects enrolled and other information at', 0, 0, 'L');
	$pdf->Image($this->base . '/assets/img/zscmst-qr.png', 50, $pdf->getY()+5, 15, 15);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(1, 5, 'Printed By:'.$data['Student']['student_no'], 0, 0, 'L');
	$pdf->Ln();
	$pdf->Cell(111, 5, '', 0, 0, 'L');
	$pdf->Cell(1, 5, 'Date Printed: '.date("F d, Y"), 0, 0, 'L');
	$pdf->Ln(10);

	$pdf->output();
	exit();
  }

  public function prospectus(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

	}

	$conditions['college_id'] = " AND Student.college_id = null";

	if ($this->request->getQuery('college_id')) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Student.college_id = $college_id";

	}

	$conditions['program_id'] = " AND Student.program_id = null";

	if ($this->request->getQuery('program_id')) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND Student.program_id = $program_id";

	}

	$conditions['year_term_id'] = " AND StudentEnrollment.year_term_id = null";

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND StudentEnrollment.year_term_id = $year_term_id";

	}

	$tmpData = $this->Prospectuses->getAllProspectusPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Prospectus',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(8,5,'#',1,0,'C',1);
	$pdf->Cell(27,5,'STUDENT NUMBER',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(60,5,'COLLEGE',1,0,'C',1);
	$pdf->Cell(60,5,'PROGRAM',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,27,50,60,60));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['college'],

		  $data['program'],

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function tors(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

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

	$tmpData = $this->Tors->getAllTorPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	// $pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'TRANSCRIPT OF RECORDS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(8,5,'#',1,0,'C',1);
	$pdf->Cell(27,5,'STUDENT NUMBER',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(60,5,'COLLEGE',1,0,'C',1);
	$pdf->Cell(60,5,'PROGRAM',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,27,50,60,60));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['college'],

		  $data['program'],

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+90,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+116,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function listCheckouts(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

   if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(CheckOut.date_borrowed) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(CheckOut.date_borrowed) >= '$start' AND DATE(CheckOut.date_borrowed) <= '$end'";

	}

	$tmpData =$this->Reports->getAllCheckOutPrint($conditions);

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF ACCOUNTABILITY',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(70,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(65,5,'MEMBER NAME',1,0,'C',1);
	$pdf->Cell(65,5,'TITLE',1,0,'C',1);
	$pdf->Cell(35,5,'AUTHOR',1,0,'C',1);
	$pdf->Cell(30,5,'BARCODE NO.',1,0,'C',1);
	$pdf->Cell(35,5,'DATE/nBORROWED',1,0,'C',1);
	$pdf->Cell(35,5,'DATE DUE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,70,65,65,35,30,35,35));
	$pdf->SetAligns(array('C','L','L','L','C','C','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$sub = $this->CheckOutSub->find()

		  ->where([

			'visible' => 1,

			'check_out_id' => $data['id'],

		  ])

		->all();

		$title = '';

		$author = '';

		$barcode = '';

		$dateDue = '';

		foreach ($sub as $k => $value) {
			
		  if($k == 0){

			$title .= $value['title'];

			$author .= $value['author'];

			$barcode .= $value['barcode_no'];

			$dateDue .= $value['dueback']->format('m/d/Y');

		  }else{

			$title .= "\n".$value['title'];

			$author .= "\n".$value['author'];

			$barcode .= "\n".$value['barcode_no'];

			$dateDue .= "\n".$value['dueback']->format('m/d/Y');

		  }

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],  

		  $data['member_name'],

		  $title,

		  $author,

		  $barcode,

		  fdate($data['date_borrowed'],'m/d/Y'),

		  $dateDue,

		  
		));

	  }

	} else {

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function listCheckins(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search') != null){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate') != null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

	}

	$conditions['year_term_id'] = " AND StudentEnrollment.year_term_id IS NULL";

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND StudentEnrollment.year_term_id = $year_term_id";

	}

	$tmpData = $this->Reports->getAllCheckinPrint($conditions);

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',70,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',260,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'LIST OF RETURNED ITEMS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(50,5,'MEMBER NAME',1,0,'C',1);
	$pdf->Cell(120,5,'TITLE',1,0,'C',1);
	$pdf->Cell(50,5,'AUTHOR',1,0,'C',1);
	$pdf->Cell(45,5,'BARCODE NO.',1,0,'C',1);
	$pdf->Cell(40,5,'DATE RETURN',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,30,50,120,50,45,40));
	$pdf->SetAligns(array('C','L','L','L','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$title = '';
		$author = '';
		$barcode = '';

		$sub = $this->CheckInSub->find()
		
		  ->where([
			
			'visible' => 1,

			'check_in_id' => $data['id'],

		  ])
		  
		->all();

		if(count($sub) > 0){

		  foreach ($sub as $keys => $values) {
			
			$title .= "\n".$values['title'];

			$author .= "\n".$values['author'];

			$barcode .= "\n".$values['barcode_no'];

		  }

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],  

		  $data['member_name'],

		  $title,

		  $author,

		  $barcode,

		  fdate($data['date_returned'],'m/d/Y')
		  
		));

	  }

	} else {

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();
  
  }

  public function listBibliographies() {

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}
	
	$tmpData = $this->Reports->getAllListInventoryBibliographyPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF BOOK COLLECTION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,'CALL NUMBER',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(70,5,'TITLE',1,0,'C',1);
	$pdf->Cell(35,5,'AUTHOR',1,0,'C',1);
	$pdf->Cell(55,5,'ACQUISITION DATE',1,0,'C',1);
	$pdf->Cell(55,5,'COLLECTION TYPE',1,0,'C',1);
	$pdf->Cell(55,5,'MATERIAL TYPE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,30,35,70,35,55,55,55));
	$pdf->SetAligns(array('C','C','L','L','L','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){


		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['call_number1'] . ', '. $data['call_number2'] . ', '. $data['call_number3'],

		  $data['code'],

		  strtoupper($data['title']),

		  strtoupper($data['author']),

		  fdate($data['date_of_publication'],'m/d/Y'),

		  $data['collection_type'],

		  $data['material_type'],  

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

 public function inventoryBibliography(){

	$conditionsPrint = '';

	$conditions = [];

	if($this->request->getQuery('search') != null){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate') != null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	}
	
	$tmpData = $this->InventoryBibliographies->getAllInventoryBibliographyPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',70,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',260,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'INVENTORY BIBLIOGRAPHY',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(100,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(100,5,'TITLE',1,0,'C',1);
	$pdf->Cell(65,5,'AUTHOR',1,0,'C',1);
	$pdf->Cell(70,5,'QUANTITY',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,100,100,65,70));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  strtoupper($data['title']),

		  $data['author'], 

		  $data['noOfCopy'],  

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }


  public function prospectusForm($id = null){

	$office_reference = $this->Global->OfficeReference('Prospectus');

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


	 if($year_term!=null){

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

				  $courses = $this->Courses->get($datas['course_id']);
				  
				  $course_prerequisites[] = array(

					'course'            => $courses['title'],

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


	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10.5,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(true);
	// $pdf->Image($this->base .'/assets/img/prospectus-1.png',4,0,210,297);
	$pdf->Image($this->base .'/assets/img/zam.png',8,16,24,24);
	$pdf->Image($this->base .'/assets/img/iso.png',184,18,18,21);
	$pdf->SetFont("Times", '', 11.5);
	$pdf->Ln(3.5);
	$pdf->Cell(-3);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(-3);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", '', 11.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(-7);
	$pdf->Cell(0,6,'Tel No:(062) 992-3092/ 991-0647; Telefax: (062) 991-0777',0,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(-9);
	$pdf->Cell(0,5,'http://www.zscmst.edu.ph Email: pres@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(12);

	$pdf->Rect(169,$pdf->GetY() -4,32.5,12.5);
	$pdf->Ln(7);
	$pdf->SetY($pdf->getY()- 10.5);
	$pdf->Cell(78);

	$pdf->Line(10.5,$pdf->getY()+1,169,$pdf->getY()+1);
	$pdf->Line(201.5,$pdf->getY()+1,204,$pdf->getY()+1);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->SetY($pdf->getY()-0.3);
	$pdf->Cell(164);
	$pdf->Cell(0,4,'ZSCMST- '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$y = $pdf->GetY();
	$pdf->Ln(3.2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(156);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: '. @$office_reference['OfficeReference']['adoption'],0,0,'L');
	$pdf->Ln(2.2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(156);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(4);
	$pdf->SetY($y+1.5);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(5);
	$pdf->Cell(12,5,'BOT RES. NO.',0,0,'L');
	$pdf->Line(36.5,$pdf->getY()+4.5,65,$pdf->getY()+4.5);
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", 'B', 16);
	$pdf->Cell(-15);
	$pdf->Cell(0,5,'PROSPECTUS',0,0,'C');
	$pdf->Ln(6);
	$pdf->Line(10.5,$pdf->getY()+1.3,169,$pdf->getY()+1.3);
	$pdf->Line(201.5,$pdf->getY()+1.3,204,$pdf->getY()+1.3);
	$pdf->Line(10.5,$pdf->getY()+1.3,10.5,$pdf->getY()+11.5);
	$pdf->Line(204,$pdf->getY()+1.3,204,$pdf->getY()+11.5);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(0,5,$data['CollegeProgram']['name'],0,0,'C');
	$pdf->Ln(7);
	$pdf->Line(10.5,$pdf->getY()+0.5,204,$pdf->getY()+0.5);
	$pdf->SetFont("Times", '', 8);
	$pdf->Ln(.5);
	$y = $pdf->Gety();
	$pdf->Cell(5.4);
	$pdf->Cell(15,8,"Grades",1,0,'C');
	$y = $pdf->Gety();
	$pdf->MultiCell(15.5,4,"Subject\n Number",1,'C');
	$pdf->SetY($y);
	$pdf->Cell(36);
	$pdf->Cell(92.5,8,"Course Description",1,0,'C');
	$pdf->Cell(17,8,"Lecture (hrs)",1,0,'C');
	$pdf->MultiCell(17,4,"Laboratory\n (hrs)",1,'C');
	$pdf->SetY($y);
	$pdf->Cell(162.5);
	$pdf->Cell(17,8,"Credit Units",1,0,'C');
	$pdf->Cell(19.5,8,"Pre-requisites",1,0,'C');
	$pdf->Ln(4.2);
	
	if(!empty($prospectus)){

	  foreach ($prospectus as $key => $value) {

		$counter = 0;

		$total_laboratory_hours = 0;
		$total_lecture_hours = 0;
		$total_credit_unit = 0;

		$pdf->SetWidths(array(193.5));
		$pdf->SetAligns(array('C'));
		$pdf->SetFont("Times", 'B', 8);


		$pdf->Ln($value['semester'] == '1st Semester' ? 3.8 : 0);
		$pdf->Cell(5.4);
		$pdf->Cell(193.5,3.7,$value['semester'] == '1st Semester' ? $value['year'] : '',1,0,'C');
		$pdf->Ln(3.8);

		$pdf->SetFont("Times", '', 8);
		$pdf->Cell(5.4);
		$pdf->Cell(193.5,3.7,$value['semester'],1,0,'C');
		$pdf->Ln(3.8);

		$pdf->SetWidths(array(15,15.5,92,17,17,17,20));
		$pdf->SetAligns(array('C','C','L','C','C','C','C'));

		if(!empty($value['subs'])){

		  foreach ($value['subs'] as $keys => $values) {

			$counter += 1;

			$total_lecture_hours += ($values['lecture_hours'] > 0 ? $values['lecture_hours'] : 0);

			$total_laboratory_hours += ($values['laboratory_hours'] > 0 ? $values['laboratory_hours'] : 0);

			$total_credit_unit += ($values['credit_unit'] > 0 ? $values['credit_unit'] : 0);

			$pdf->Cell(5.4);

			$course_prerequisites = '';

			if(!empty($values['course_prerequisites'])){

			  foreach ($values['course_prerequisites'] as $index => $datas) {
				
				$course_prerequisites .= $datas['course']."\n";

			  }

			}

			$pdf->RowLegalP(array(

			  $values['final'],

			  $values['course_code'],

			  $values['course'],

			  $values['lecture_hours'],

			  $values['laboratory_hours'],

			  $values['credit_unit'],

			  $course_prerequisites,

			));

		  }

		}

		if($counter < 12){

		  for ($i=$counter; $i < 12; $i++) { 
			
			$pdf->Cell(5.4);
			$pdf->Cell(15,3.7,"",1,0,'C');
			$pdf->Cell(15.5,3.7,"",1,0,'C');
			$pdf->Cell(92,3.7,"",1,0,'R');
			$pdf->Cell(17,3.7,"",1,0,'C');
			$pdf->Cell(17,3.7,"",1,0,'C');
			$pdf->Cell(17,3.7,"",1,0,'C');
			$pdf->Cell(20,3.7,"",1,0,'C');
			$pdf->Ln(3.8);

		  }

		}

		if($value['semester'] == '1st Semester' || $value['semester'] == '2nd Semester'){

		  $pdf->Cell(5.4);
		  $pdf->Cell(15,3.7,"",1,0,'C');
		  $pdf->Cell(15.5,3.7,"",1,0,'C');
		  $pdf->Cell(92,3.7,"Total:",1,0,'R');
		  $pdf->Cell(17,3.7,$total_lecture_hours > 0 ? $total_lecture_hours : '',1,0,'C');
		  $pdf->Cell(17,3.7,$total_laboratory_hours > 0 ? $total_laboratory_hours : '',1,0,'C');
		  $pdf->Cell(17,3.7,$total_credit_unit > 0 ? $total_credit_unit : '',1,0,'C');
		  $pdf->Cell(20,3.7,"",1,0,'C');
		  $pdf->Ln(3.8);
		  $pdf->Cell(5.4);
		  $pdf->Cell(15,3.7,"",1,0,'C');
		  $pdf->Cell(15.5,3.7,"",1,0,'C');
		  $pdf->Cell(92,3.7,"Total Number of Units:",1,0,'R');
		  $pdf->Cell(17,3.7,"",1,0,'C');
		  $pdf->Cell(17,3.7,"",1,0,'C');
		  $pdf->Cell(17,3.7,"",1,0,'C');
		  $pdf->Cell(20,3.7,"",1,0,'C');

		}

	  }

	}

	$pdf->Ln(10);
	$y = $pdf->GetY();
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(5.4);
	$pdf->Cell(15);
	$pdf->Cell(45,3.7,'SUMMARY',1,0,'C');
	$pdf->Cell(13,3.7,"UNITS",1,0,'C');
	$pdf->Ln(3.7);
	$pdf->SetFont("Times", '', 8);

	$summaries = ['General education Courses:','Allied/Elective Courses','Core/Professional Courses:','Other Required Courses:','Summer/Summer Practicum:','On-The-Job Training:','Others(Please Specify)'];
	foreach ($summaries as $summary){

	  $pdf->Cell(5.4);
	  $pdf->Cell(15);
	  $pdf->Cell(45,3.7,$summary,1,0,'L');
	  $pdf->Cell(13,3.7,"",1,0,'C');
	  $pdf->Ln(3.8);

	  
	}

	for ($x = 1; $x <= 4; $x++) {

	  if($x == 4){
		$pdf->Cell(5.4);
		$pdf->Cell(15);
		$pdf->Cell(45,3.7,"TOTAL:",1,0,'R');
		$pdf->Cell(13,3.7,"",1,0,'C');
		$pdf->Ln(3.8);
	  }
	  else{
		$pdf->Cell(5.4);
		$pdf->Cell(15);
		$pdf->Cell(45,3.7,"",1,0,'L');
		$pdf->Cell(13,3.7,"",1,0,'C');
		$pdf->Ln(3.8);
	  }
	}


	$pdf->SetY($y);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(5.4);
	$pdf->Cell(83 );
	$pdf->Cell(10,3.7,'Year',1,0,'C');
	$pdf->Cell(30,3.7,"Semester",1,0,'C');
	$pdf->Cell(17,3.7,"Lecture",1,0,'C');
	$pdf->Cell(17,3.7,"Laboratory",1,0,'C');
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(17,3.7,"No. of Course/s",1,0,'C');
	$pdf->Ln(3.8);
	$pdf->SetFont("Times", '', 8);
	$years = ['1st','2nd','3rd','4th'];
	$y = $pdf->Gety();
	foreach ($years as $year){
	  $pdf->Cell(5.4);
	  $pdf->Cell(83 );
	  $pdf->MultiCell(10,3.7,$year."\n".'Year',1,'C');
	}

	$pdf->setY($y);
	$pdf->SetFont("Times", '', 8);

	for ($x = 1; $x <= 4; $x++) {

	  
		$pdf->Cell(5.4);
		$pdf->Cell(93);
		$pdf->Cell(30,3.7,"First Semester",1,0,'L');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Ln(3.7);
		$pdf->Cell(5.4);
		$pdf->Cell(93);
		$pdf->Cell(30,3.7,"Second Semester",1,0,'L');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Ln(3.7);
	}

	for ($x = 1; $x <= 3; $x++) {

	  if($x==3){
		$pdf->Cell(5.4);
		$pdf->Cell(83 );
		$pdf->Cell(10,3.7,'',1,0,'C');
		$pdf->Cell(30,3.7,"Total:",1,0,'R');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Ln(3.7);
	  }
	  else{
		$pdf->Cell(5.4);
		$pdf->Cell(83 );
		$pdf->Cell(10,3.7,'',1,0,'C');
		$pdf->Cell(30,3.7,"Summer",1,0,'L');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Cell(17,3.7,"",1,0,'C');
		$pdf->Ln(3.7);
	  }
	}


	$pdf->ln(4);
	$pdf->Cell(5.4);
	$pdf->Cell(20,5,'Authority to Operate Program:');
	$pdf->Ln(4);
	$y = $pdf->Gety();
	$pdf->Cell(15);
	$pdf->Cell(10,5,'(BOT and CMO)');
	$pdf->Line(42,$pdf->Gety()+4,65,$pdf->Gety()+4);
	$pdf->Ln(4);
	$pdf->Cell(5.4);
	$pdf->Cell(20,5,'Year of the Program Started:');
	$pdf->Line(44,$pdf->Gety()+4,67,$pdf->Gety()+4);


	$pdf->SetY($y);
	$pdf->Cell(5.4);
	$pdf->Cell(90);
	$pdf->Cell(27,5,'This program requires:',0,0,'L');
	$pdf->Cell(21,5,'Computer Course:',0,0,'L');
	$pdf->Cell(15,5,'( ) Yes ( ) No',0,0,'L');
	$pdf->Cell(13);
	$pdf->Cell(15,5,'No. of Times:',0,0,'L');
	$pdf->Line(193,$pdf->Gety()+4,204,$pdf->Gety()+4);
	$pdf->Ln(4);
	$pdf->Cell(5.4);
	$pdf->Cell(90);
	$pdf->Cell(27);
	$pdf->Cell(21,5,'Swimming:',0,0,'L');
	$pdf->Cell(15,5,'( ) Yes ( ) No',0,0,'L');
	$pdf->Cell(13);
	$pdf->Cell(15,5,'No. of Times:',0,0,'L');
	$pdf->Line(193,$pdf->Gety()+4,204,$pdf->Gety()+4);
	$pdf->Ln(4);
	$pdf->Cell(5.4);
	$pdf->Cell(90);
	$pdf->Cell(27);
	$pdf->Cell(21,5,'Jeep:',0,0,'L');
	$pdf->Cell(15,5,'( ) Yes ( ) No',0,0,'L');
	$pdf->Cell(13);
	$pdf->Cell(15,5,'No. of Times:',0,0,'L');
	$pdf->Line(193,$pdf->Gety()+4,204,$pdf->Gety()+4);
	$pdf->Ln(4);
	$pdf->Cell(5.4);
	$pdf->Cell(90);
	$pdf->Cell(27);
	$pdf->Cell(21,5,'Thesis:',0,0,'L');
	$pdf->Cell(15,5,'( ) Yes ( ) No',0,0,'L');
	$pdf->Cell(13);
	$pdf->Cell(15,5,'No. of Times:',0,0,'L');
	$pdf->Line(193,$pdf->Gety()+4,204,$pdf->Gety()+4);
	$pdf->Ln(8);
	$pdf->Cell(5.4);
	$pdf->Cell(10,5,'Prepared by:');
	$pdf->Line(25,$pdf->Gety()+4,70,$pdf->Gety()+4);
	$pdf->Cell(65);
	$pdf->Cell(10,5,'Noted:');
	$pdf->Line(95,$pdf->Gety()+4,135,$pdf->Gety()+4);
	$pdf->Ln(3);
	$pdf->Cell(35);
	$pdf->Cell(10,5,'Program Adviser',0,0,'C');
	$pdf->Cell(60);
	$pdf->Cell(10,5,'College Dean',0,0,'C');




	$pdf->output();
	exit();

  }

  public function torForm($id = null){

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


	$tor = array();

	$year_term = $this->YearLevelTerms->find()
	->where([
		'YearLevelTerms.visible' => 1,
		'YearLevelTerms.active_prospectus' => 1
	])
	->all();

	if($year_term!=null){

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

				're_exam'          => $value['re_exam'],

				'credit_unit'      => $value['credit_unit'],

				'course_prerequisites' => $course_prerequisites

			  );

			}

		  }

		}

		$tor[] = array(

		  'semester' => $values['semester'],

		  'year'     => $values['year'],

		  'subs'     => $subs,

		);

	  }

	}

	$full_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5, 9, 5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->Image($this->base . '/assets/img/zam.png', 6.5, 22,35, 35);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0, 5, 'ZSCMST-OCR 3.10.I-I5', 0, 0, 'L');
	$pdf->Image($this->base . '/assets/img/iso.png', 182, 13, 18, 21);
	$pdf->SetFont("Times", '', 10);
	$pdf->Ln(5);
	$pdf->Cell(-7);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(-5);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');

	$pdf->Ln(15);
	$pdf->SetFont("Times", '', 14);
	$pdf->Cell(-6);
	$pdf->Cell(0, 6, 'OFFICE OF THE COLLEGE REGISTRAR', 0, 0, 'C');
	$pdf->Ln(7);
	$pdf->SetFont("Times", '', 17);
	$pdf->Cell(45, 8, '', 0, 0, 'C');
	$pdf->Cell(115, 8, 'OFFICIAL TRANSCRIPT OF RECORDS', 1, 0, 'C');

	$pdf->Ln(10);
	$pdf->SetFont("Times", '', 11);
	$pdf->Line(27, $pdf->getY()+5, 110, $pdf->getY()+5);
	$pdf->Line(150, $pdf->getY()+5, 200, $pdf->getY()+5);
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(13, 5, 'Name: ', 0, 0, 'L');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(90, 5, strtoupper($data['Student']['last_name'].', '.$data['Student']['first_name'].' '.$data['Student']['middle_name']), 0, 0, 'L');
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(33, 5, 'Date of Admission: ', 0, 0, 'L');
	// $pdf->Cell(80, 5, fdate($data['StudentApplication']['approved_date'],'m/d/Y'), 0, 0, 'L');
	$pdf->Line(38, $pdf->getY() + 11, 80, $pdf->getY() + 11);
	$pdf->Line(93, $pdf->getY() + 11, 110, $pdf->getY() + 11);
	$pdf->Line(148, $pdf->getY() + 11, 200, $pdf->getY() + 11);
	$pdf->Ln(6);
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(23, 5, 'Date of Birth: ', 0, 0, 'L');
	$pdf->Cell(45, 5, $data['Student']['date_of_birth']->format('m/d/Y'), 0, 0, 'L');
	$pdf->Cell(10, 5, 'Sex:', 0, 0, 'L');
	$pdf->Cell(25, 5, $data['Student']['gender'], 0, 0, 'L');
	$pdf->Cell(30, 5, 'Valid Credential: ', 0, 0, 'L');
	$pdf->Cell(80, 5, '', 0, 0, 'L');
	$pdf->Ln(6);
	$pdf->Line(35, $pdf->getY() + 5, 110, $pdf->getY() + 5);
	$pdf->Line(140, $pdf->getY() + 5, 155, $pdf->getY() + 5);
	$pdf->Line(173, $pdf->getY() + 5, 200, $pdf->getY() + 5);
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(20, 5, 'Birth Place: ', 0, 0, 'L');
	$pdf->Cell(83, 5, @$data['Student']['place_of_birth'], 0, 0, 'L');
	$pdf->Cell(23, 5, 'Civil Status: ', 0, 0, 'L');
	$pdf->Cell(15, 5, @$data['Student']['civil_status'], 0, 0, 'L');
	$pdf->Cell(17, 5, 'Religion:', 0, 0, 'L');
	$pdf->Cell(25, 5, @$data['Student']['religion'], 0, 0, 'L');
	$pdf->Ln(6);
	$pdf->SetFont("Times", '', 11);
	$pdf->Line(40, $pdf->getY()+5, 110, $pdf->getY()+5);
	$pdf->Line(148, $pdf->getY()+5, 200, $pdf->getY()+5);
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(28, 5, 'Home Address: ', 0, 0, 'L');
	$pdf->Cell(75, 5, '', 0, 0, 'L');
	$pdf->Cell(31, 5, 'Parent / Guardian: ', 0, 0, 'L');
	$pdf->Cell(80, 5, '', 0, 0, 'L');
	$pdf->Ln(7);
	$pdf->SetFont("Times", '', 10);
	$pdf->Rect(20, $pdf->GetY(), 175, 21);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(60, 5, 'Preliminar Education: ', 0, 0, 'L');
	$pdf->Cell(60, 5, 'Name of School', 0, 0, 'L');
	$pdf->Cell(31, 5, 'Address', 0, 0, 'L');
	$pdf->Cell(80, 5, 'School Year', 0, 0, 'L');
	$pdf->Ln(4);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(60, 5, 'Intermediate: ', 0, 0, 'L');
	$pdf->Ln(4);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(60, 5, 'Secondary: ', 0, 0, 'L');
	$pdf->Ln(4);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(60, 5, 'Senior High School: ', 0, 0, 'L');    
	$pdf->Ln(4);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(60, 5, 'College: ', 0, 0, 'L');
	$pdf->Ln(6);
	$pdf->SetFont("Times", '', 10);
	$pdf->Line(42, $pdf->getY()+5, 185, $pdf->getY()+5);
	$pdf->Cell(20, 5, '', 0, 0, 'L');
	$pdf->Cell(13, 5, 'DEGREE: ', 0, 0, 'L');
	$pdf->Ln(6);
	$pdf->Line(40, $pdf->getY()+5, 185, $pdf->getY()+5);
	$pdf->Cell(20, 5, '', 0, 0, 'L');
	$pdf->Cell(13, 5, 'MAJOR: ', 0, 0, 'L');
	$pdf->Ln(6);
	$pdf->Line(67, $pdf->getY()+5, 110, $pdf->getY()+5);
	$pdf->Line(156, $pdf->getY()+5, 185, $pdf->getY()+5);
	$pdf->Cell(20, 5, '', 0, 0, 'L');
	$pdf->Cell(43, 5, 'DATE OF GRADUATION: ', 0, 0, 'L');
	$pdf->Cell(51, 5, '', 0, 0, 'L');
	$pdf->Cell(38, 5, 'ACADEMIC AWARDS: ', 0, 0, 'L');
	$pdf->Cell(13, 5, '', 0, 0, 'L');
	$pdf->Ln(8);
	$pdf->Cell(10, 8, '', 0, 0, 'L');
	$pdf->Cell(35,8, 'COURSE NUMBER', 1, 0, 'C');
	$pdf->Cell(100, 8, 'COURSE TITLE', 1, 0, 'C');
	$y = $pdf->getY();
	$pdf->SetFont("Times", '', 8);
	$pdf->MultiCell(15, 4, 'FINAL GRADE', 1, 'C');
	$pdf->SetXY(165, $pdf->getY()-8);
	$pdf->MultiCell(15, 4, 'RE-EXAM
	', 1, 1);
	$pdf->SetXY(180, $pdf->getY()-8);
	$pdf->MultiCell(20, 4, 'UNITS OF CREDIT', 1, 'C');

	if(!empty($tor)){

	  foreach ($tor as $key => $value) {

		$pdf->SetWidths(array(35,100,15,15,20));
		$pdf->SetAligns(array('C','L','C','C','C'));

		$pdf->SetFont("Times", 'BU', 8);
		$pdf->Cell(10, 8, '', 0, 0, 'L');

		$pdf->RowLegalTor(array(

		  '',

		  $value['semester'],

		  '',

		  '',

		  '',

		));
		
		if(!empty($value['subs'])){

		  foreach ($value['subs'] as $keys => $values) {

			$pdf->SetFont("Times", '', 8);
			$pdf->Cell(10, 8, '', 0, 0, 'L');

			$pdf->SetWidths(array(35,100,15,15,20));
			$pdf->SetAligns(array('L','L','C','C','C'));
			  
			$pdf->RowLegalTor(array(

			  $values['course_code'],

			  $values['course'],

			  $values['final'],

			  $values['re_exam'],

			  $values['credit_unit'],

			),$data);

		  }

		}

	  }

	}

	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->Cell(35, 5, '', 'LRB', 0, 'L');
	$pdf->Cell(100, 5, '', 'LRB', 0, 'L');
	$pdf->Cell(15, 5, '', 'LRB', 0, 'L');
	$pdf->Cell(15, 5, '', 'LRB', 0, 'L');
	$pdf->Cell(20, 5, '', 'LRB', 1, 'L');
	$pdf->getY();
	$pdf->Ln(0);
	$pdf->SetFont("Times", 'BU', 11);
	$pdf->Cell(0, 8, 'GRADING SYSTEM', 0, 0, 'C');
	$pdf->Ln(7);
	$pdf->SetFont("Times", 'I', 7);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'UNDERGRADUATE:', 0, 0, 'L');
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(80, 5, '1.00-1.50 - Superior, 1.51-2.00 - Very Good,2.01-2.50 - Good,', 0, 0, 'L');
	$pdf->Cell(20, 5, 'GRADUATE: 1.0 - Excellent, 1.25 -Very Good, 1.5 - Good,', 0, 0, 'L');
	$pdf->Ln(3);
	$pdf->Cell(40, 5, '', 0, 0, 'L');
	$pdf->Cell(95, 5, '2.51-3.00 - Fair, 5.00 - Failure, AW - Authorized Withdrawal means Dropped', 0, 0, 'L');
	$pdf->Cell(20, 5, '1.75 - Fair,2.0 - Passing INC - Incomplete,', 0, 0, 'L');
	$pdf->Ln(3);
	$pdf->Cell(43, 5, '', 0, 0, 'L');
	$pdf->Cell(95, 5, 'a grade of5.00 - Failure', 0, 0, 'L');
	$pdf->Cell(20, 5, '3.0 - Failure', 0, 0, 'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0, 8, 'Any unauthorized errstrre or alteration voids the entries on this form.', 0, 0, 'C');
	$pdf->Ln(7);
	$pdf->SetFont("Times", '', 7);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(23, 5, 'CREDITS: The units of credits is the semester hour. Each unit of credits is at least seventeen (17) hours of actual time inclusive of examinations. The statrdard', 0, 0, 'L');
	$pdf->Ln(3);
	$pdf->Cell(32, 5, '', 0, 0, 'L');
	$pdf->Cell(80, 5, 'number of hours for every one unit of credit is as follows: Lecture = 1 unit, Laborarory = 3 hours: 1 unit, Physical Educalion = hour/week.', 0, 0, 'L');
	$pdf->Ln(7);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'REMARKS:', 0, 0, 'L');
	$pdf->SetFont("Times", 'B', 11);
	$pdf->Cell(23, 5, '', 0, 0, 'L');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 11);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->Line(45, $pdf->getY(), 150, $pdf->getY());
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(25, 5, '(NOT VALID WITHOUT COLLEGE SEAL)', 0, 0, 'L');
	// $pdf->Image($this->base . '/assets/img/zscmst-qr.png', 160, 325,25, 25);
	$pdf->Ln(13);
	$pdf->SetFont("Times", '', 11);
	$pdf->Line(20, $pdf->getY(),60, $pdf->getY());
	$pdf->Cell(25, 5, '', 0, 0, 'L');
	$pdf->SetFont("Times", 'I', 9);
	$pdf->Cell(23, 5, 'Prepared by', 0, 0, 'L');
	$pdf->Line(65, $pdf->getY(),105, $pdf->getY());
	$pdf->Cell(22, 5, '', 0, 0, 'L');
	$pdf->Cell(23, 5, 'Checked by', 0, 0, 'L');
	$pdf->Line(110, $pdf->getY(),150, $pdf->getY());
	$pdf->Cell(18, 5, '', 0, 0, 'L');
	$pdf->Cell(23, 5, 'College Registrar', 0, 0, 'L');
	$pdf->Ln(7);
	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->SetFont("Times", 'I', 9);
	$pdf->Cell(23, 5, 'Student No.: ', 0, 0, 'L');
	$pdf->Line(38, $pdf->getY()+5,60, $pdf->getY()+5);
	$pdf->Cell(30, 5, '', 0, 0, 'L');
	$pdf->SetFont("Times", 'I', 9);
	$pdf->Cell(23, 5, 'Date: ', 0, 0, 'L');
	$pdf->Line(83, $pdf->getY()+5,105, $pdf->getY()+5);
	$pdf->Cell(28, 5, '', 0, 0, 'L');
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(15, 5, 'Page', 0, 0, 'L');
	$pdf->Cell(23, 5, 'of', 0, 0, 'L');
	$pdf->Line(133, $pdf->getY()+5,138, $pdf->getY()+5);
	$pdf->Line(145, $pdf->getY()+5,150, $pdf->getY()+5);

	$pdf->output();
	exit();
	
  }

  public function medicalMonthlyAccomplishment(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$start = date('Y-m-').'01';

	$end = date('Y-m-t');

	$conditions['date'] = "AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = "AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

	}

	$tmpData = $this->Reports->getAllMedicalMonthlyAccomplishmentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',25,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',167,10,20,25);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647 Telefax (062} 991-077 http://www-zscmst.edu.ph',0,0,'C');

	$pdf->Ln(10);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,195,$pdf->getY()+1);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Rect(160,$pdf->GetY(),35,14);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-MDU- 3.4.4-5',0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(73,5,'',0,0,'C');
	$pdf->Cell(50,10,'MEDICAL-DENTAL UNIT',0,0,'C');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: 1-2005',0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: May 2015',0,0,'L');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: 1',0,0,'L');

	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(0,5,'MONHTLY ACCOMPLISHMENT REPORT',0,0,'C');

	$pdf->Ln(15);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(30,5,'For the month of ',0,0,'L');
	$pdf->SetFont("Arial", 'BU', 11);
	$pdf->Cell(50,5,strtoupper(fdate($start,'F Y')),0,0,'L');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(45,10,'AILMENTS',1,0,'C');
	$pdf->Cell(60,5,'NUMBER OF STUDENTS',1,0,'C');
	$pdf->Cell(60,5,'NUMBER OF PERSONNEL',1,0,'C');
	$pdf->Cell(30,10,'REMARKS',1,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(45,5,'',0,0,'C');
	$pdf->Cell(20,5,'TREATED',1,0,'C');
	$pdf->Cell(20,5,'REFERRED',1,0,'C');
	$pdf->Cell(20,5,'TOTAL',1,0,'C');
	$pdf->Cell(20,5,'TREATED',1,0,'C');
	$pdf->Cell(20,5,'REFERRED',1,0,'C');
	$pdf->Cell(20,5,'TOTAL',1,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(45,20,20,20,20,20,20,30));
	$pdf->SetAligns(array('L','C','C','C','C','C','C','C'));

	if(count($tmpData)>0){

	  $grandTotal = 0;

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  ($key + 1).'. '.$data['ailment'],

		  $data['studentTreated'],

		  $data['employeeTreated'],

		  $data['totalTreated'],

		  $data['studentReferred'],

		  $data['employeeReferred'],

		  $data['totalReferred'],

		  $data['remarks'],

		));

		$grandTotal += $data['remarks'] > 0 ? $data['remarks'] : 0;

	  }

	  $pdf->Cell(165,5,'GRAND TOTAL',1,0,'C');
	  $pdf->Cell(30,5,$grandTotal,1,0,'C');

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(130,10,'',0,0,'L');
	$pdf->Cell(45,10,'Submitted by:',0,0,'L');

	$pdf->Ln(15);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(130,10,'',0,0,'L');
	$pdf->Cell(45,10,'JULIE ANNE A. GONZALES, R.N.',0,0,'L');

	$pdf->output();
	exit();
  
  }

  public function cats(){

	$conditions = [];


	if($this->request->getQuery('search') != null){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate') != null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND StudentApplication.approve = $status";

	  if($status == 1){ //FOR APPROVED TAB OF STUDENT APPLICATION

		$conditions['status'] = "AND StudentApplication.approve <> 0";

	  }elseif($status == 'forRating'){ //RATING TAB OF CAT

		$conditions['status'] = "AND StudentApplication.approve = 1";

	  }

	}

	$conditions['rate'] = '';

	if ($this->request->getQuery('rate') != null) {

	  $rate = $this->request->getQuery('rate');

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}


	$conditions['order'] = '';

	if ($this->request->getQuery('order') != null){

	  $order = $this->request->getQuery('order');

	  $conditions['order'] = $order;
	  
	}

	$tmpData = $this->StudentApplications->getAllStudentApplicationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'College Admission Test (For Rating)',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(90,5,'APPLICANT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(70,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(35,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Cell(30,5,'GENDER',1,0,'C',1);
	$pdf->Cell(35,5,'APPLICATION DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,90,55,70,35,30,35));
	$pdf->SetAligns(array('C','L','C','L','C','C','C'));



	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  strtoupper($data['full_name']),

		  $data['email'],

		  $data['address'],

		  $data['contact_no'],

		  $data['gender'],

		  fdate($data['application_date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);

	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+150,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+185,$pdf->getY()+2,$pdf->getX()+330,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function catsAssessed(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['rate'] = '';

	if ($this->request->getQuery('rate')) {

	  $rate = $this->request->getQuery('rate');

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')) {

	  $status = $this->request->getQuery('status');

	  if($status == 'assessed'){
		$conditions['status'] = "AND StudentApplication.approve != 3";
	  }
	  else{
		$conditions['status'] = "AND StudentApplication.approve = $status";
	  }

	}


	$conditions['order'] = '';

	if ($this->request->getQuery('order')){

	  $order = $this->request->getQuery('order');

	  $conditions['order'] = $order;

	  
	}

	$tmpData = $this->StudentApplications->getAllStudentApplicationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'College Admission Test (Assessed)',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(80,5,'APPLICANT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(60,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(35,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Cell(30,5,'GENDER',1,0,'C',1);
	$pdf->Cell(35,5,'APPLICATION DATE',1,0,'C',1);
	$pdf->Cell(20,5,'RATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,80,55,60,35,30,35,20));
	$pdf->SetAligns(array('C','L','C','L','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  strtoupper($data['full_name']),

		  $data['email'],

		  $data['address'],

		  $data['contact_no'],

		  $data['gender'],

		  fdate($data['application_date'],'m/d/Y'),

		  $data['rate'],

		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);

	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+150,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+185,$pdf->getY()+2,$pdf->getX()+330,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

	public function cats_interview(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['rate'] = '';

	if (isset($this->request->query['rate'])) {

	  $rate = $this->request->query['rate'];

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}

	$conditions['status'] = '';

	if (isset($this->request->query['status'])) {

	  $status = $this->request->query['status'];

	  if($status == 'assessed'){
		$conditions['status'] = "AND StudentApplication.approve != 3";
	  }
	  else{
		$conditions['status'] = "AND StudentApplication.approve = $status";
	  }

	}


	$conditions['order'] = '';

	if (isset($this->request->query['order'])){

	  $order = $this->request->query['order'];

	  $conditions['order'] = $order;
	  
	}

	$tmpData = $this->StudentApplication->query($this->StudentApplication->getAllStudentApplication($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'College Admission Test (FOR INTERVIEW)',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(80,5,'APPLICANT NAME',1,0,'C',1);
	$pdf->Cell(55,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(60,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(35,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Cell(30,5,'GENDER',1,0,'C',1);
	$pdf->Cell(35,5,'APPLICATION DATE',1,0,'C',1);
	$pdf->Cell(20,5,'RATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,80,55,60,35,30,35,20));
	$pdf->SetAligns(array('C','L','C','L','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  strtoupper($data[0]['full_name']),

		  $data['StudentApplication']['email'],

		  $data['StudentApplication']['address'],

		  $data['StudentApplication']['contact_no'],

		  $data['StudentApplication']['gender'],

		  fdate($data['StudentApplication']['application_date'],'m/d/Y'),

		  $data['StudentApplication']['rate'],

		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);

	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+150,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+185,$pdf->getY()+2,$pdf->getX()+330,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }


  public function scholarshipName(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')!=null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$tmpData = $this->ScholarshipName->getAllScholarshipNamePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'SCHOLARSHIP NAME',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	
	// Centering the table
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);
	
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(182, 5, 'NAME', 1, 0, 'C', 1);
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);
	

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,182));
	$pdf->SetAligns(array('C','C'));
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);

	  // Resetting the left margin to default
	  
	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){


		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['scholarship_name'],
	
		));

	  }

	  $pdf->SetLeftMargin(0);

	}else{

   // Centering the table
   $tableWidth = 200; // Total width of the table
   $leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
   $pdf->SetLeftMargin($leftMargin);
   $pdf->Cell(197,5,'No data available.',1,1,'C');
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0)
	;
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+8,$pdf->getY()+2,$pdf->getX()+90,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205.5,$pdf->getY()+2);
	$pdf->SetDash();    

	$pdf->output();
	
	exit();

  }

  public function medicalMonthlyConsumption(){

	$conditions = array();
	
	$conditionDate = '';

	$conditions['search'] = '';

	if ($this->request->getQuery('search')!=null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$start = date('Y-m-t');

	$end = date('Y-m-t');

	$conditions['date'] = "AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

	if ($this->request->getQuery('startDate')!=null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = "AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

	  $conditionDate = "AND DATE(ItemIssuance.date) >= '$start' AND DATE(ItemIssuance.date) <= '$end'";


	}

	$tmpData = $this->Reports->getAllMedicalMonthlyConsumptionPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',25,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',167,10,20,25);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647 Telefax (062} 991-077 http://www-zscmst.edu.ph',0,0,'C');

	$pdf->Ln(10);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,195,$pdf->getY()+1);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(4);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Rect(160,$pdf->GetY(),35,14);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-MDU- 3.4.4-6',0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(73,5,'',0,0,'C');
	$pdf->Cell(50,10,'MEDICAL-DENTAL UNIT',0,0,'C');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(68,5,'Adopted Date: 1-2005',0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: May 2015',0,0,'L');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: 1',0,0,'L');

	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(0,5,'CONSUMPTION REPORT',0,0,'C');

	$pdf->Ln(15);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(30,5,'For the month of ',0,0,'L');
	$pdf->SetFont("Arial", 'BU', 11);
	$pdf->Cell(50,5,strtoupper(fdate($start,'F Y')),0,0,'L');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(85,10,'Item',1,0,'C');
	$pdf->Cell(18,5,'Expiry','LTR',0,'C');
	$pdf->Cell(18,5,'Stock','LTR',0,'C');
	$pdf->Cell(18,10,'Total',1,0,'C');
	$pdf->Cell(18,5,'Number','LTR',0,'C');
	$pdf->Cell(18,10,'Balance',1,0,'C');
	$pdf->Cell(20,10,'Remarks',1,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(85,5,'',0,0,'C');
	$pdf->Cell(18,5,'Date','LBR',0,'C');
	$pdf->Cell(18,5,'Available','LBR',0,'C');
	$pdf->Cell(18,5,'',0,0,'C');
	$pdf->Cell(18,5,'Issued','LBR',0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(85,18,18,18,18,18,20));
	$pdf->SetAligns(array('L','C','C','C','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$item_id = $data['id'];

		$result = "

		  SELECT 

			IFNULL(SUM(ItemIssuanceSub.quantity),0) as number_issued

		  FROM

			item_issuance_subs as ItemIssuanceSub LEFT JOIN 

			item_issuances as ItemIssuance on ItemIssuance.id = ItemIssuanceSub.item_issuance_id

		  WHERE 

			ItemIssuance.visible = true $conditionDate AND 

			ItemIssuance.status = 1 AND

			ItemIssuanceSub.item_id = $item_id

		";

		 $connection = $this->ItemIssuances->getConnection();

		  $issuances = $connection->execute($result)->fetchAll('assoc');

		$total_issuances = $issuances[0]['number_issued'];

		if(count($issuances)>0){

		  $total_issuances = 0;

		}

		$inventory = $this->InventoryProperties->find()

			->where([

				'visible' => 1,

				'property_log_id' => $item_id

			])

			->all();

		$total_stock = 0;

		$expiry_date = '';

		$stocks = '';

		if(count($inventory)>0){

		  foreach ($inventory as $keys => $values) {
			
			$expiry_date .= $values['expiry_date']->format('m/d/Y')."\n";

			$stocks .= $values['stocks']."\n";

			$total_stock += $values['stocks'];

		  }

		}

		$pdf->RowLegalP(array(

		  ($key + 1).'. '.$data['property_name'],

		  $expiry_date,

		  $stocks,

		  $total_stock,    

		  $total_stock - $total_issuances,       

		  $total_issuances,

		  ''

		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(130,10,'',0,0,'L');
	$pdf->Cell(45,10,'Submitted by:',0,0,'L');

	$pdf->Ln(15);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(130,10,'',0,0,'L');
	$pdf->Cell(45,10,'JULIE ANNE A. GONZALES, R.N.',0,0,'L');

	$pdf->output();
	exit();
  
  }

  public function medicalDailyTreaments(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$today = date('Y-m-d');

	$conditions['date'] = " AND DATE(ConsultationSub.date) = '$today'"; 

	$condition = " AND DATE(ConsultationSub.date) = '$today'"; 

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(ConsultationSub.date) = '$search_date'"; 

	  $condition = " AND DATE(ConsultationSub.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

	  $condition = " AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

	}

	$tmpData = $this->Reports->getAllMedicalDailyTreatmentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'DAILY TREATMENTS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(60,5,'PATIENT NAME',1,0,'C');
	$pdf->Cell(45,5,'AILMENTS',1,0,'C');
	$pdf->Cell(45,5,'TREATMENTS',1,0,'C');
	$pdf->Cell(45,5,'REMARKS',1,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(10,60,45,45,45));
	$pdf->SetAligns(array('C','L','C','C','L'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$consultation_id = $data['id'];

		$tmp = "

		  SELECT 

			ConsultationSub.*

		  FROM  

			consultation_subs as ConsultationSub

		  WHERE 

			ConsultationSub.visible = true $condition AND 

			ConsultationSub.consultation_id = $consultation_id

		";

		$connection = $this->ConsultationSubs->getConnection();

		$consultation_sub = $connection->execute($tmp)->fetchAll('assoc');

		$ailments = '';

		$treatments = '';

		$remarks = '';

		if(count($consultation_sub)>0){

		  foreach ($consultation_sub as $keys => $value) {

			$ailments .= $value['chief_complaints']."\n";

			$treatments .= $value['treatments']."\n";

			$remarks .= $value['remarks']."\n";

		  }

		}

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_name'] != null ? $data['student_name'] : $data['employee_name'],

		  $ailments,

		  $treatments,

		  $remarks,

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function requestedForms($id = null){

	$data = $this->RequestForm->find('first', array(

	  'contain' => array(

		'Student',

		'Course'

	  ),

	  'conditions' => array(

		'RequestForm.visible' => true,

		'RequestForm.id' => $id,

	  )

	));

	$full_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

	//PRINTING START HERE

	  require("wordwrap.php");
	  $pdf = new ConductPDF();

	  //TOR

	  if($data['RequestForm']['otr']){

		if($data['RequestForm']['otrVal'] > 0){

		  for ($i=1; $i <= $data['RequestForm']['otrVal']; $i++) { 
			
			$tmpTor = $this->Student->find('first', array(

			  'contain' => array(

				'StudentApplication' => array(

				  'conditions' => array(

					'StudentApplication.visible' => true

				  ),

				),
				
				'College' => array(

				  'conditions' => array(

					'College.visible' => true

				  ),

				),
				
				'CollegeProgram' => array(

				  'conditions' => array(

					'CollegeProgram.visible' => true

				  ),

				),
				
				'StudentEnrolledCourse' => array(

				  'conditions' => array(

					'StudentEnrolledCourse.visible' => true

				  )

				),

				'StudentEnrolledUnit' => array(

				  'conditions' => array(

					'StudentEnrolledUnit.visible' => true

				  )

				),

				'StudentEnrollment' => array(

				  'conditions' => array(

					'StudentEnrollment.visible' => true

				  )

				)

			  ),

			  'conditions' => array(

				'Student.visible' => true,

				'Student.id'      => $data['RequestForm']['student_id'],

			  )

			));

			$tor = array();

			$year_term = $this->YearLevelTerm->find('all', array(

			  'conditions' => array(

				'YearLevelTerm.visible' => true,

				'YearLevelTerm.active_prospectus' => true

			  )

			));

			if(!empty($year_term)){

			  foreach ($year_term as $keys => $values) {

				$subs = array();
				
				if(!empty($tmpTor['StudentEnrolledCourse'])){

				  foreach ($tmpTor['StudentEnrolledCourse'] as $key => $value) {
					
					if($values['YearLevelTerm']['id'] == $value['year_term_id']){

					  $subs[] = array(

						'final'            => $value['incomplete'] == 1 ? 'INC' : $value['final_grade'],

						're_exam'          => $value['incomplete'] == 1 ? $value['final_grade'] : '',

						'course_code'      => $value['course_code'],

						'course'           => $value['course'],

						'credit_unit'      => $value['credit_unit'],

					  );

					}

				  }

				}

				$tor[] = array(

				  'semester' => $values['YearLevelTerm']['semester'],

				  'year'     => $values['YearLevelTerm']['year'],

				  'subs'     => $subs,

				);

			  }

			}

			$pdf->SetMargins(5, 9, 5);
			$pdf->AddPage("P", "Legal", 0);
			$pdf->SetAutoPageBreak(false);
			$pdf->Image($this->base . '/assets/img/zam.png', 6.5, 22,35, 35);
			$pdf->SetFont("Times", '', 12);
			$pdf->Cell(0, 5, 'ZSCMST-OCR 3.10.I-I5', 0, 0, 'L');
			// $pdf->Image($this->base . '/assets/img/iso.png', 182, 13, 18, 21);
			$pdf->SetFont("Times", '', 10);
			$pdf->Ln(5);
			$pdf->Cell(-7);
			$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
			$pdf->Ln(5);
			$pdf->SetFont("Times", 'B', 11);
			$pdf->Cell(-5);
			$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
			$pdf->Ln(4.5);
			$pdf->SetFont("Times", '', 10);
			$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');

			$pdf->Ln(15);
			$pdf->SetFont("Times", '', 14);
			$pdf->Cell(-6);
			$pdf->Cell(0, 6, 'OFFICE OF THE COLLEGE REGISTRAR', 0, 0, 'C');
			$pdf->Ln(7);
			$pdf->SetFont("Times", '', 17);
			$pdf->Cell(45, 8, '', 0, 0, 'C');
			$pdf->Cell(115, 8, 'OFFICIAL TRANSCRIPT OF RECORDS', 1, 0, 'C');

			$pdf->Ln(10);
			$pdf->SetFont("Times", '', 11);
			$pdf->Line(27, $pdf->getY()+5, 110, $pdf->getY()+5);
			$pdf->Line(150, $pdf->getY()+5, 200, $pdf->getY()+5);
			$pdf->Cell(10, 5, '', 0, 0, 'L');
			$pdf->Cell(13, 5, 'Name: ', 0, 0, 'L');
			$pdf->SetFont("Times", 'B', 11);
			$pdf->Cell(90, 5, strtoupper($tmpTor['Student']['last_name'].', '.$tmpTor['Student']['first_name'].' '.$tmpTor['Student']['middle_name']), 0, 0, 'L');
			$pdf->SetFont("Times", '', 11);
			$pdf->Cell(33, 5, 'Date of Admission: ', 0, 0, 'L');
			$pdf->Cell(80, 5, fdate($tmpTor['StudentApplication']['approved_date'],'m/d/Y'), 0, 0, 'L');
			$pdf->Line(38, $pdf->getY() + 11, 80, $pdf->getY() + 11);
			$pdf->Line(93, $pdf->getY() + 11, 110, $pdf->getY() + 11);
			$pdf->Line(148, $pdf->getY() + 11, 200, $pdf->getY() + 11);
			$pdf->Ln(6);
			$pdf->Cell(10, 5, '', 0, 0, 'L');
			$pdf->Cell(23, 5, 'Date of Birth: ', 0, 0, 'L');
			$pdf->Cell(45, 5, fdate($tmpTor['Student']['date_of_birth'],'m/d/Y'), 0, 0, 'L');
			$pdf->Cell(10, 5, 'Sex:', 0, 0, 'L');
			$pdf->Cell(25, 5, $tmpTor['Student']['gender'], 0, 0, 'L');
			$pdf->Cell(30, 5, 'Valid Credential: ', 0, 0, 'L');
			$pdf->Cell(80, 5, '', 0, 0, 'L');
			$pdf->Ln(6);
			$pdf->Line(35, $pdf->getY() + 5, 110, $pdf->getY() + 5);
			$pdf->Line(140, $pdf->getY() + 5, 155, $pdf->getY() + 5);
			$pdf->Line(173, $pdf->getY() + 5, 200, $pdf->getY() + 5);
			$pdf->Cell(10, 5, '', 0, 0, 'L');
			$pdf->Cell(20, 5, 'Birth Place: ', 0, 0, 'L');
			$pdf->Cell(83, 5, @$tmpTor['Student']['place_of_birth'], 0, 0, 'L');
			$pdf->Cell(23, 5, 'Civil Status: ', 0, 0, 'L');
			$pdf->Cell(15, 5, @$tmpTor['Student']['civil_status'], 0, 0, 'L');
			$pdf->Cell(17, 5, 'Religion:', 0, 0, 'L');
			$pdf->Cell(25, 5, @$tmpTor['Student']['religion'], 0, 0, 'L');
			$pdf->Ln(6);
			$pdf->SetFont("Times", '', 11);
			$pdf->Line(40, $pdf->getY()+5, 110, $pdf->getY()+5);
			$pdf->Line(148, $pdf->getY()+5, 200, $pdf->getY()+5);
			$pdf->Cell(10, 5, '', 0, 0, 'L');
			$pdf->Cell(28, 5, 'Home Address: ', 0, 0, 'L');
			$pdf->Cell(75, 5, '', 0, 0, 'L');
			$pdf->Cell(31, 5, 'Parent / Guardian: ', 0, 0, 'L');
			$pdf->Cell(80, 5, '', 0, 0, 'L');
			$pdf->Ln(7);
			$pdf->SetFont("Times", '', 10);
			$pdf->Rect(20, $pdf->GetY(), 175, 21);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(60, 5, 'Preliminar Education: ', 0, 0, 'L');
			$pdf->Cell(60, 5, 'Name of School', 0, 0, 'L');
			$pdf->Cell(31, 5, 'Address', 0, 0, 'L');
			$pdf->Cell(80, 5, 'School Year', 0, 0, 'L');
			$pdf->Ln(4);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(60, 5, 'Intermediate: ', 0, 0, 'L');
			$pdf->Ln(4);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(60, 5, 'Secondary: ', 0, 0, 'L');
			$pdf->Ln(4);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(60, 5, 'Senior High School: ', 0, 0, 'L');    
			$pdf->Ln(4);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(60, 5, 'College: ', 0, 0, 'L');
			$pdf->Ln(6);
			$pdf->SetFont("Times", '', 10);
			$pdf->Line(42, $pdf->getY()+5, 185, $pdf->getY()+5);
			$pdf->Cell(20, 5, '', 0, 0, 'L');
			$pdf->Cell(13, 5, 'DEGREE: ', 0, 0, 'L');
			$pdf->Ln(6);
			$pdf->Line(40, $pdf->getY()+5, 185, $pdf->getY()+5);
			$pdf->Cell(20, 5, '', 0, 0, 'L');
			$pdf->Cell(13, 5, 'MAJOR: ', 0, 0, 'L');
			$pdf->Ln(6);
			$pdf->Line(67, $pdf->getY()+5, 110, $pdf->getY()+5);
			$pdf->Line(156, $pdf->getY()+5, 185, $pdf->getY()+5);
			$pdf->Cell(20, 5, '', 0, 0, 'L');
			$pdf->Cell(43, 5, 'DATE OF GRADUATION: ', 0, 0, 'L');
			$pdf->Cell(51, 5, '', 0, 0, 'L');
			$pdf->Cell(38, 5, 'ACADEMIC AWARDS: ', 0, 0, 'L');
			$pdf->Cell(13, 5, '', 0, 0, 'L');
			$pdf->Ln(8);
			$pdf->Cell(10, 8, '', 0, 0, 'L');
			$pdf->Cell(35,8, 'COURSE NUMBER', 1, 0, 'C');
			$pdf->Cell(100, 8, 'COURSE TITLE', 1, 0, 'C');
			$y = $pdf->getY();
			$pdf->SetFont("Times", '', 8);
			$pdf->MultiCell(15, 4, 'FINAL GRADE', 1, 'C');
			$pdf->SetXY(165, $pdf->getY()-8);
			$pdf->MultiCell(15, 4, 'RE-EXAM
			', 1, 1);
			$pdf->SetXY(180, $pdf->getY()-8);
			$pdf->MultiCell(20, 4, 'UNITS OF CREDIT', 1, 'C');

			if(!empty($tor)){

			  foreach ($tor as $key => $value) {

				$pdf->SetWidths(array(35,100,15,15,20));
				$pdf->SetAligns(array('C','L','C','C','C'));

				$pdf->SetFont("Times", 'BU', 8);
				$pdf->Cell(10, 8, '', 0, 0, 'L');

				$pdf->RowLegalTor(array(

				  '',

				  $value['semester'],

				  '',

				  '',

				  '',

				));
				
				if(!empty($value['subs'])){

				  foreach ($value['subs'] as $keys => $values) {

					$pdf->SetFont("Times", '', 8);
					$pdf->Cell(10, 8, '', 0, 0, 'L');

					$pdf->SetWidths(array(35,100,15,15,20));
					$pdf->SetAligns(array('L','L','C','C','C'));
					  
					$pdf->RowLegalTor(array(

					  $values['course_code'],

					  $values['course'],

					  $values['final'],

					  $values['re_exam'],

					  $values['credit_unit'],

					),$data);

				  }

				}

			  }

			}

			$pdf->Cell(10, 5, '', 0, 0, 'L');
			$pdf->Cell(35, 5, '', 'LRB', 0, 'L');
			$pdf->Cell(100, 5, '', 'LRB', 0, 'L');
			$pdf->Cell(15, 5, '', 'LRB', 0, 'L');
			$pdf->Cell(15, 5, '', 'LRB', 0, 'L');
			$pdf->Cell(20, 5, '', 'LRB', 1, 'L');
			$pdf->getY();
			$pdf->Ln(0);
			$pdf->SetFont("Times", 'BU', 11);
			$pdf->Cell(0, 8, 'GRADING SYSTEM', 0, 0, 'C');
			$pdf->Ln(7);
			$pdf->SetFont("Times", 'I', 7);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(25, 5, 'UNDERGRADUATE:', 0, 0, 'L');
			$pdf->SetFont("Times", '', 7);
			$pdf->Cell(80, 5, '1.00-1.50 - Superior, 1.51-2.00 - Very Good,2.01-2.50 - Good,', 0, 0, 'L');
			$pdf->Cell(20, 5, 'GRADUATE: 1.0 - Excellent, 1.25 -Very Good, 1.5 - Good,', 0, 0, 'L');
			$pdf->Ln(3);
			$pdf->Cell(40, 5, '', 0, 0, 'L');
			$pdf->Cell(95, 5, '2.51-3.00 - Fair, 5.00 - Failure, AW - Authorized Withdrawal means Dropped', 0, 0, 'L');
			$pdf->Cell(20, 5, '1.75 - Fair,2.0 - Passing INC - Incomplete,', 0, 0, 'L');
			$pdf->Ln(3);
			$pdf->Cell(43, 5, '', 0, 0, 'L');
			$pdf->Cell(95, 5, 'a grade of5.00 - Failure', 0, 0, 'L');
			$pdf->Cell(20, 5, '3.0 - Failure', 0, 0, 'L');
			$pdf->Ln(3);
			$pdf->SetFont("Times", 'B', 10);
			$pdf->Cell(0, 8, 'Any unauthorized errstrre or alteration voids the entries on this form.', 0, 0, 'C');
			$pdf->Ln(7);
			$pdf->SetFont("Times", '', 7);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(23, 5, 'CREDITS: The units of credits is the semester hour. Each unit of credits is at least seventeen (17) hours of actual time inclusive of examinations. The statrdard', 0, 0, 'L');
			$pdf->Ln(3);
			$pdf->Cell(32, 5, '', 0, 0, 'L');
			$pdf->Cell(80, 5, 'number of hours for every one unit of credit is as follows: Lecture = 1 unit, Laborarory = 3 hours: 1 unit, Physical Educalion = hour/week.', 0, 0, 'L');
			$pdf->Ln(7);
			$pdf->SetFont("Times", '', 11);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Cell(25, 5, 'REMARKS:', 0, 0, 'L');
			$pdf->SetFont("Times", 'B', 11);
			$pdf->Cell(23, 5, '', 0, 0, 'L');
			$pdf->Ln(4);
			$pdf->SetFont("Times", '', 11);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->Line(45, $pdf->getY(), 150, $pdf->getY());
			$pdf->SetFont("Times", '', 10);
			$pdf->Cell(25, 5, '(NOT VALID WITHOUT COLLEGE SEAL)', 0, 0, 'L');
			$pdf->Image($this->base . '/assets/img/zscmst-qr.png', 160, 325,25, 25);
			$pdf->Ln(13);
			$pdf->SetFont("Times", '', 11);
			$pdf->Line(20, $pdf->getY(),60, $pdf->getY());
			$pdf->Cell(25, 5, '', 0, 0, 'L');
			$pdf->SetFont("Times", 'I', 9);
			$pdf->Cell(23, 5, 'Prepared by', 0, 0, 'L');
			$pdf->Line(65, $pdf->getY(),105, $pdf->getY());
			$pdf->Cell(22, 5, '', 0, 0, 'L');
			$pdf->Cell(23, 5, 'Checked by', 0, 0, 'L');
			$pdf->Line(110, $pdf->getY(),150, $pdf->getY());
			$pdf->Cell(18, 5, '', 0, 0, 'L');
			$pdf->Cell(23, 5, 'College Registrar', 0, 0, 'L');
			$pdf->Ln(7);
			$pdf->Cell(15, 5, '', 0, 0, 'L');
			$pdf->SetFont("Times", 'I', 9);
			$pdf->Cell(23, 5, 'Student No.: ', 0, 0, 'L');
			$pdf->Line(38, $pdf->getY()+5,60, $pdf->getY()+5);
			$pdf->Cell(30, 5, '', 0, 0, 'L');
			$pdf->SetFont("Times", 'I', 9);
			$pdf->Cell(23, 5, 'Date: ', 0, 0, 'L');
			$pdf->Line(83, $pdf->getY()+5,105, $pdf->getY()+5);
			$pdf->Cell(28, 5, '', 0, 0, 'L');
			$pdf->SetFont("Times", '', 9);
			$pdf->Cell(15, 5, 'Page', 0, 0, 'L');
			$pdf->Cell(23, 5, 'of', 0, 0, 'L');
			$pdf->Line(133, $pdf->getY()+5,138, $pdf->getY()+5);
			$pdf->Line(145, $pdf->getY()+5,150, $pdf->getY()+5);

		  }

		}

	  }

	  //END TOR


	  $pdf->output();
	  exit();

	//END PRINTING
	
  }

  public function itemIssuances() {

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

	  $conditions['date'] = " AND DATE(ItemIssuance.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ItemIssuance.date) >= '$start' AND DATE(ItemIssuance.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(ItemIssuance.date) >= '$start' AND DATE(ItemIssuance.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND ItemIssuance.status = $status";

	}
	
	$tmpData = $this->ItemIssuances->getAllItemIssuancePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ITEM ISSUANCE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(130,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(130,5,'TYPE',1,0,'C',1);
	$pdf->Cell(75,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,130,130,75));
	$pdf->SetAligns(array('C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  strtoupper($data['type']),

		  fdate($data['date'],'m/d/Y'),  

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function list_sections() {

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	
	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(MaterialType.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(MaterialType.date) >= '$start' AND DATE(
		MaterialType.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->Section->query($this->Section->getAllSection($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'SECTIONS',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	
	// Centering the table
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);
	
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(182, 5, 'NAME', 1, 0, 'C', 1);
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);
	

	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,182,65,65,182));
	$pdf->SetAligns(array('C','C','C','C','C'));
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);

	  // Resetting the left margin to default
	  
	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['Section'];


		$pdf->RowLegalL(array(

		  $key + 1,

		  $tmp['name'],
	
		));

	  }

	  $pdf->SetLeftMargin(0);

	}else{

   // Centering the table
   $tableWidth = 180; // Total width of the table
   $leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
   $pdf->SetLeftMargin($leftMargin);
   $pdf->Cell(180,5,'No data available.',1,1,'C');
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0)
	;
	}

	$pdf->output();
	
	exit();

  }

  public function checkout() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(CheckOut.date_borrowed) = '$search_date'"; 

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(CheckOut.date_borrowed) >= '$start' AND DATE(CheckOut.date_borrowed) <= '$end'";

	}

	$this->loadModel('CheckOuts');

	$tmpData = $this->CheckOuts->query($this->CheckOuts->getAllCheckOutPrint($conditions));

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',5,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',185,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF CHECKOUT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'LIBRARY ID NUMBER',1,0,'C',1);
	$pdf->Cell(65,5,'MEMBER NAME',1,0,'C',1);
	$pdf->Cell(55,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(30,5,'DATE BORROWED',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,65,55,30));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['library_id_number'],  

		  $data['member_name'],

		  $data['email'],

		  $data['date_borrowed']->format('m/d/Y'),

		));

	  }

	} else {

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+83,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+115,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function checkIn() {

	$conditions = [];

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(CheckIn.date_returned) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(CheckIn.date_returned) >= '$start' AND DATE(CheckIn.date_returned) <= '$end'";

	}

	$tmpData = $this->CheckIns->getAllCheckInPrint($conditions);

	$datas = new Collection($tmpData);

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',5,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',185,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF CHECKINS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'LIBRARY ID NUMBER',1,0,'C',1);
	$pdf->Cell(65,5,'MEMBER NAME',1,0,'C',1);
	$pdf->Cell(55,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(30,5,'DATE RETURNED',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,35,65,55,30));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['library_id_number'],  

		  $data['member_name'],

		  $data['email'],

		  fdate($data['date_returned'],'m/d/Y'),

		));

	  }

	} else {

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+83,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+115,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function catRatingResult($id = null){

	$data['StudentApplication'] = $this->StudentApplications->find()

	->contain([

		'YearLevelTerms',

		'Colleges',

		'PreferredPrograms',


		'SecondaryPrograms',

		'StudentApplicationImages' => [

			'conditions' => ['StudentApplicationImages.visible' => 1]

		],

		'StudentEnrolledCourses' => [

			'conditions' => ['StudentEnrolledCourses.visible' => 1]

		],

		'StudentEnrolledUnits' => [

			'conditions' => ['StudentEnrolledUnits.visible' => 1]

		],

		'StudentEnrollments' => [

			'conditions' => ['StudentEnrollments.visible' => 1]

		]

	])

	->where([

		'StudentApplications.visible' => 1,

		'StudentApplications.id' => $id

	])

	->first();

	$data['StudentApplication']['birth_date'] = isset($data['StudentApplication']['birth_date']) ? date('m/d/Y', strtotime($data['StudentApplication']['birth_date'])) : '';

	$data['StudentApplication']['approved_date'] = isset($data['StudentApplication']['approved_date']) ? date('m/d/Y', strtotime($data['StudentApplication']['approved_date'])) : '';

	$data['StudentApplication']['disapproved_date'] = isset($data['StudentApplication']['disapproved_date']) ? date('m/d/Y', strtotime($data['StudentApplication']['disapproved_date'])) : '';

	$data['StudentApplicationImage'] = $data['StudentApplication']['student_application_images'];

	$data['College'] = $data['StudentApplication']['college'];

	$data['CollegeProgram'] = $data['StudentApplication']['preferred_program'];

	$data['CollegeProgramSecondary'] = $data['StudentApplication']['secondary_program'];

	$data['YearLevelTerm'] = $data['StudentApplication']['year_level_term'];

	unset($data['StudentApplication']['student_application_image']);

	unset($data['StudentApplication']['college']);

	unset($data['StudentApplication']['preferred_program']);

	unset($data['StudentApplication']['year_level_term']);

	unset($data['StudentApplication']['secondary_program']);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,6,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11.5);
   
	$pdf->Image($this->base .'/assets/img/zam.png',12,8,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',182,8,18,21);
	$pdf->Ln(3.5);
	
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 10.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 10.5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph ',0,0,'C');
	$pdf->Ln(-1);
	$pdf->SetFont("Times", 'B', 14);
	$pdf->Cell(80);
	$pdf->Cell(45,20,'ADMISSION AND SCHOLARSHIP OFFICE',0,0,'C');
	$pdf->Ln(20);

	$pdf->Rect(165.5,$pdf->GetY() -12,31.5,13);
	$pdf->Ln(4);
	$pdf->SetY($pdf->getY()- 15.6);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(154);
	$pdf->Cell(68,4,'ZSCMST-ASO-3.10.2-1.5',0,0,'L');
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(-154);
	$pdf->Ln(3);
	$pdf->SetFont("Arial", 'B', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: 1-2012',0,0,'L');
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(-154);
	$pdf->Ln(2);
	$pdf->SetFont("Arial", 'B', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: 5-2015',0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", 'B', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: 6',0,0,'L');
	$pdf->Ln(-5);
	$pdf->Cell(70);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(65,20,'COLLEGE ADMISSION TEST (CAT) RESULT OF RATING',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(50,20,'Name of Examinee:',0,0,'L');
	$pdf->Cell(10,20,$data['StudentApplication']['last_name'].', '.$data['StudentApplication']['first_name'].' '.$data['StudentApplication']['middle_name'],0,0,'L');
	$pdf->Line(45.5,$pdf->getY()+12,170,$pdf->getY()+12);
	$pdf->Ln(5);
	$pdf->Cell(0,20,'(Family Name, Given Name, Middle Initial)',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(40,10,'School Graduated From:',0,0,'L');
	$pdf->Cell(10,10,$data['StudentApplication']['last_school'],0,0,'L');
	$pdf->Line(50,$pdf->getY()+8,170,$pdf->getY()+8);

	$pdf->Ln(13);
	$pdf->Cell(10);
	$pdf->SetFont("Times", 'B', 9);
	$pdf->MultiCell(40,5,'
	  RAW SCORE
	  ',1,'C',0);
	$pdf->SetXY(55, $pdf->getY()-15);
	$pdf->MultiCell(150,5,'Preferred Courses to Enroll:
	  (Check the circle of your preferred course)
	  ',1,'C',0);

	$pdf->SetXY(5, $pdf->getY());
	$pdf->Cell(10);
	$pdf->SetFont("Times", '', 20);
	$pdf->Cell(40,30,$data['StudentApplication']['rate'],'LTR',0,'C');

	$pdf->SetFont("Times", '', 9);
	$mt='';
	$me='';
	$martech='';
	$a='';
	$fi='';
	$ft='';
	$mb='';
	$es='';
	$fipht='';
	$dmect='';
	$hm='';
	$ed='';
	$led='';
	$sci='';
	$fil= '';
	$eng= '';
	$math= '';  
	$ict= '';
	$agri= '';
	$home= '';

	if($data['CollegeProgram']['id']==1){
		  $fipht='4';
	}
	if($data['CollegeProgram']['id']==2){
		  $ft='4';
	}
	if($data['CollegeProgram']['id']==3){
		  $mb='4';
	}
	if($data['CollegeProgram']['id']==4){
		  $martech='4';
	}
	if($data['CollegeProgram']['id']==5){
		  $a='4';
	}

	if($data['CollegeProgramSecondary']['id']==1){
		  $fipht='4';
	}
	if($data['CollegeProgramSecondary']['id']==2){
		  $ft='4';
	}
	if($data['CollegeProgramSecondary']['id']==3){
		  $mb='4';
	}
	if($data['CollegeProgramSecondary']['id']==4){
		  $martech='4';
	}
	if($data['CollegeProgramSecondary']['id']==5){
		  $a='4';
	}

	if($data['CollegeProgramSecondary']['major']=='English'){
		  $eng='4';
	}
	if($data['CollegeProgramSecondary']['major']=='Science'){
		  $sci='4';
	}
	if($data['CollegeProgramSecondary']['major']=='Math'){
		  $math='4';
	}
	if($data['CollegeProgramSecondary']['major']=='Filipino'){
		  $fil='4';
	}
	if($data['CollegeProgramSecondary']['major']=='ICT'){
		  $ict='4';
	}
	if($data['CollegeProgramSecondary']['major']=='Agri-Fisheries'){
		  $agri='4';
	}
	if($data['CollegeProgramSecondary']['major']=='Home Economics'){
		  $home='4';
	}
	$pdf->Rect(55, $pdf->GetY(), 150, 55);

	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(1);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$mt,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(50,5,'1. BS Marine Transportation (BSMT)',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$hm,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(55,5,'12. BS Hospitality Management (BSHM)',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$me,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(47,5,'2. BS Marine Engineering (BSME)',0,0,'L');
	$pdf->Cell(18);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$ed,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(50,5,'13. BS Secondary Education (BSED)',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$martech,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(53.5,5,'3. BS Marine Technology (BSMarTech)',0,0,'L');
	$pdf->Cell(10);
		$pdf->SetFont("Times", 'B', 9);
	$pdf->Cell(23,5,'Major: ',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$a,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(34.5,5,'4. BS Aquaculture (BSA)',0,0,'L');
	$pdf->Cell(41);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$sci,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(12,5,'Science',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$fi,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(30.5,5,'5. BS Fisheries (BSFi)',0,0,'L');
	$pdf->Cell(44);
	$pdf->Cell(3,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$fil,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(12,5,'Filipino',0,0,'L');

	$pdf->Ln(5);   
	$pdf->Cell(10); 
	$pdf->MultiCell(40,5,"PERCENTAGE\nEQUIVALENT",1,'C',0);
	$pdf->SetXY(55, $pdf->getY()-15);
	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$ft,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(42.5,5,'6. BS Food Technology (BSFT)',0,0,'L');
	$pdf->Cell(33);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$eng,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(11.5,5,'English',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$mb,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(41.5,5,'7. BS Marine Biology (BSMB)',0,0,'L');
	$pdf->Cell(34);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$math,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(9,5,'Math',0,0,'L');

	$pdf->Ln(5);   
	$pdf->Cell(10); 
	 $pdf->MultiCell(40,5,'

	
	',1,'C',0);
	$pdf->SetXY(55, $pdf->getY()-25);
	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$es,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(50,5,'8. BS Environmental Science (BSES)',0,0,'L');
	$pdf->Cell(17);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$led,0,0,'L');
		$pdf->SetFont("Times", '', 7);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(65,5,'14. Bachelor in Technology and Livelihood Education (BTLEd)',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$fipht,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(62,5,'9. BS Fi Post-Harvest Technology (BSFi-PHT)',0,0,'L');
	$pdf->Cell(14);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$ict,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(7,5,'ICT',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$dmect,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(67,5,'10. Diploma in Marine Electronics Communication ',0,0,'L');
	$pdf->Cell(9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$agri,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(20,5,'Agri-Fisheries',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(63);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(30,5,'Technology (DMECT)',0,0,'L');
	$pdf->Cell(41);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$agri,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(25,5,'Home Economics ',0,0,'L');

	$pdf->Ln(20);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont("Arial", 'BU', 11);
	$pdf->Cell(140);
	$pdf->Cell(58,5,'REGAN C. SITOY',0,'C',0);
	$pdf->Ln(-1);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(130);
	$pdf->Cell(58,5,'Head, Admission, & Scholarship Office',0,'C',0);
	$pdf->Ln(5);
	$first = 0; $last=3;
	do{
	  $pdf->Line($first, $pdf->getY() + 3, $last, $pdf->getY() + 3);
	  $first+=5;
	  $last+=5;
	}while($last<=250);

	$pdf->Ln(5);
	$pdf->Image($this->base .'/assets/img/zam.png',12,175,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',182,175,18,21);
	$pdf->Ln(4);


	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 10.5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 10.5);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 10.5);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph ',0,0,'C');
	$pdf->Ln(-1);
	$pdf->SetFont("Times", 'B', 14);
	$pdf->Cell(80);
	$pdf->Cell(45,20,'ADMISSION AND SCHOLARSHIP OFFICE',0,0,'C');
	$pdf->Ln(20);

	$pdf->Rect(165.5,$pdf->GetY() -12,31.5,13);
	$pdf->Ln(4);
	$pdf->SetY($pdf->getY()- 15.6);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(154);
	$pdf->Cell(68,4,'ZSCMST-ASO-3.10.2-1.5',0,0,'L');
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(-154);
	$pdf->Ln(3);
	$pdf->SetFont("Arial", 'B', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: 1-2012',0,0,'L');
	$pdf->SetFont("Arial", 'B', 10.5);
	$pdf->Cell(-154);
	$pdf->Ln(2);
	$pdf->SetFont("Arial", 'B', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: 5-2015',0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", 'B', 5.5);
	$pdf->Cell(154);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: 6',0,0,'L');
	$pdf->Ln(-5);
	$pdf->Cell(70);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(65,20,'COLLEGE ADMISSION TEST (CAT) RESULT OF RATING',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(50,20,'Name of Examinee:',0,0,'L');
	$pdf->Cell(10,20,$data['StudentApplication']['last_name'].', '.$data['StudentApplication']['first_name'].' '.$data['StudentApplication']['middle_name'],0,0,'L');
	$pdf->Line(45.5,$pdf->getY()+12,170,$pdf->getY()+12);
	$pdf->Ln(5);
	$pdf->Cell(0,20,'(Family Name, Given Name, Middle Initial)',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(40,10,'School Graduated From:',0,0,'L');
	$pdf->Cell(10,10,$data['StudentApplication']['last_school'],0,0,'L');
	$pdf->Line(50,$pdf->getY()+8,170,$pdf->getY()+8);

	$pdf->Ln(13);
	$pdf->Cell(10);
	$pdf->SetFont("Times", 'B', 9);
	$pdf->MultiCell(40,5,'
	  RAW SCORE
	  ',1,'C',0);
	$pdf->SetXY(55, $pdf->getY()-15);
	$pdf->MultiCell(150,5,'Preferred Courses to Enroll:
	  (Check the circle of your preferred course)
	  ',1,'C',0);

	$pdf->SetXY(5, $pdf->getY());
	$pdf->Cell(10);
	$pdf->SetFont("Times", '', 20);
	$pdf->Cell(40,30,$data['StudentApplication']['rate'],'LRT',0,'C');

	$pdf->SetFont("Times", '', 9);

	$pdf->Rect(55, $pdf->GetY(), 150, 55);

	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(1);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$mt,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(50,5,'1. BS Marine Transportation (BSMT)',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$hm,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(55,5,'12. BS Hospitality Management (BSHM)',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$me,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(47,5,'2. BS Marine Engineering (BSME)',0,0,'L');
	$pdf->Cell(18);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$ed,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(50,5,'13. BS Secondary Education (BSED)',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$martech,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(53.5,5,'3. BS Marine Technology (BSMarTech)',0,0,'L');
	$pdf->Cell(10);
		$pdf->SetFont("Times", 'B', 9);
	$pdf->Cell(23,5,'Major: ',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$a,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(34.5,5,'4. BS Aquaculture (BSA)',0,0,'L');
	$pdf->Cell(41);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$sci,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(12,5,'Science',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$fi,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(30.5,5,'5. BS Fisheries (BSFi)',0,0,'L');
	$pdf->Cell(44);
	$pdf->Cell(3,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$fil,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(12,5,'Filipino',0,0,'L');

	$pdf->Ln(5);   
	$pdf->Cell(10); 
	$pdf->MultiCell(40,5,"PERCENTAGE\nEQUIVALENT",1,'C',0);
	$pdf->SetXY(55, $pdf->getY()-15);
	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$ft,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(42.5,5,'6. BS Food Technology (BSFT)',0,0,'L');
	$pdf->Cell(33);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$eng,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(11.5,5,'English',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$mb,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(41.5,5,'7. BS Marine Biology (BSMB)',0,0,'L');
	$pdf->Cell(34);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$math,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(9,5,'Math',0,0,'L');

	$pdf->Ln(5);   
	$pdf->Cell(10); 
	 $pdf->MultiCell(40,5,'

	
	',1,'C',0);
	$pdf->SetXY(55, $pdf->getY()-25);
	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$es,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(50,5,'8. BS Environmental Science (BSES)',0,0,'L');
	$pdf->Cell(17);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$led,0,0,'L');
		$pdf->SetFont("Times", '', 7);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(65,5,'14. Bachelor in Technology and Livelihood Education (BTLEd)',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$fipht,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(62,5,'9. BS Fi Post-Harvest Technology (BSFi-PHT)',0,0,'L');
	$pdf->Cell(14);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$ict,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(7,5,'ICT',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$dmect,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(67,5,'10. Diploma in Marine Electronics Communication ',0,0,'L');
	$pdf->Cell(9);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$agri,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(20,5,'Agri-Fisheries',0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(63);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(30,5,'Technology (DMECT)',0,0,'L');
	$pdf->Cell(41);
	$pdf->Cell(2,5,'(',0,0,'L');
		$pdf->SetFont('ZapfDingbats','', 9);
	$pdf->Cell(3,5,$agri,0,0,'L');
		$pdf->SetFont("Times", '', 9);
	$pdf->Cell(2,5,')',0,0,'L');
	$pdf->Cell(25,5,'Home Economics ',0,0,'L');

	$pdf->Ln(20);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont("Arial", 'BU', 11);
	$pdf->Cell(140);
	$pdf->Cell(58,5,'REGAN C. SITOY',0,'C',0);
	$pdf->Ln(-1);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(130);
	$pdf->Cell(58,5,'Head, Admission, & Scholarship Office',0,'C',0);

	$pdf->output();
	exit();

  }

  public function catApplicationForm($id = null){

	$office_reference = $this->Global->OfficeReference('Cat');

	$data['StudentApplication'] = $this->StudentApplications->find()

	->contain([

		'YearLevelTerms',

		'Colleges',

		'CollegePrograms',

		'SecondaryPrograms',

		'StudentApplicationImages' => [

			'conditions' => [

				'StudentApplicationImages.visible' => 1

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

		'StudentApplications.visible' => 1,

		'StudentApplications.id' => $id

	])

	->first();

	$data['StudentApplicationImage'] = $data['StudentApplication']['student_application_images'];

	$data['College'] = $data['StudentApplication']['college'];

	$data['CollegeProgram'] = $data['StudentApplication']['college_program'];

	$data['CollegeProgramSecondary'] = $data['StudentApplication']['secondary_program'];

	$data['YearLevelTerm'] = $data['StudentApplication']['year_level_term'];

	unset($data['StudentApplication']['student_application_image']);

	unset($data['StudentApplication']['college']);

	unset($data['StudentApplication']['preferred_program']);

	unset($data['StudentApplication']['year_level_term']);

	unset($data['StudentApplication']['secondary_program']);

	unset($data['StudentApplication']['college_program']);


	

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,1,5);
	$pdf->AddPage("P", "A4", 0);
	$pdf->SetAutoPageBreak(false);

	
	$pdf->Image($this->base .'/assets/img/zam.png',12,4,22,22);
	$pdf->Image($this->base .'/assets/img/iso.png',183,6,15,18);
	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 8.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", 'B', 10);
	$pdf->Cell(0,5,'S T U D E N T  A D M I S S I O N   O F F I C E',0,0,'C');
	$pdf->Ln(7.5);
	$y = $pdf->GetY();
	$pdf->Cell(5.9);
	$pdf->SetFont("Arial", '', 10);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetFillColor(0,0,0);
	$pdf->Cell(137.5,5,'APPLICATION PROCEDURES',0,0,'C',1);
	$pdf->Ln(5);
	$pdf->Rect(11,$pdf->GetY(),137.5,39);
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(8);
	$pdf->Cell(80.5,5,'1. Submit the following together with the accomplished CAT Application form:',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(15);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(3,5,'a.',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(30,5,'Clear Photocopy of PSA Birth Certificate',0,0,'L');
	$pdf->Ln(3.5);
	$pdf->Cell(15);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(3,5,'b.',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(30,5,'Clear Photocopy of Form 138 or SHS School Card or Transcript of Records (TOR) for transferees.',0,0,'L');
	$pdf->Ln(3.5);
	$pdf->Cell(15);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(3,5,'c.',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(30,5,'Certificate of Good Moral Character',0,0,'L');
	$pdf->Ln(3.5);
	$pdf->Cell(15);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(3,5,'d.',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(30,5,'Two (2) pieces 2" x 2" recent identical pictures with blue or white background only. (selfie not accepted)',0,0,'L');
	$pdf->Ln(7);
	$pdf->Cell(8);
	$pdf->MultiCell(150,3.7,"2. Graduates of Alternative Learning System (ALS) should secure and present original copy of Certificate of \n     ALS Accreditation and Equivalency Test.'",0,'L',0);

	$pdf->SetY($y);
	$pdf->Rect(151,$pdf->GetY(),23,10);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(155);
	$pdf->Cell(5,5,'TESTING',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(155);
	$pdf->Cell(5,5,'CENTER',0,0,'C');
	$pdf->Ln(3);
	$pdf->Cell(155);
	$pdf->Cell(5,5,'COPY',0,0,'C');
	$pdf->SetY($y);
	$pdf->Rect(174.5,$pdf->GetY(),24.3,10);
	$pdf->SetFont("Arial", '', 5);
	$pdf->Cell(170);
	$pdf->Cell(5,3.5,'ZSCMST- '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->Cell(170);
	$pdf->Cell(5,3.5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->Ln(2.2);
	$pdf->Cell(170);
	$pdf->Cell(5,3.5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(2);
	$pdf->Cell(170);
	$pdf->Cell(5,3.5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(4);
	$pdf->Rect(151,$pdf->GetY(),47.6,44.4);
	$pdf->Ln(18);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150);
	$pdf->MultiCell(40,3,"Attach 2'' x2'' photo\nwith your signature over\nprinted name at the back.",0,'C',0);
	$pdf->Ln(7.5);
	$pdf->Cell(5.9);
	$pdf->SetFont("Arial", '', 10);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(137.5,5,'COLLEGE ADMISSION TEST APPLICATION FORM',0,0,'C',1);
	$pdf->Ln(4);
	$pdf->Line(148,$pdf->GetY()+1,151,$pdf->GetY()+1);
	$pdf->Line(11,$pdf->GetY(),11,149);
	$pdf->Line(198.5,$pdf->GetY()+6,198.5,149);
	$pdf->Ln(2);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(8);
	$pdf->Cell(26,5,'PERSONAL DATA',0,0,'L');
	$pdf->SetFont("Arial", '', 6);
	$pdf->Cell(25,5,'* Please use ballpen and write in block letters only',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5,181,6);
	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10);
	$pdf->Cell(47,5,$data['StudentApplication']['last_name'],0,0,'L');
	$pdf->Cell(45,5,$data['StudentApplication']['first_name'],0,0,'L');
	$pdf->Cell(51,5,$data['StudentApplication']['middle_name'],0,0,'L');
	$pdf->Cell(20,5,$data['StudentApplication']['auxilliary_name'],0,0,'L');
	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(9);
	$pdf->Cell(47,5,'Last Name',0,0,'L');
	$pdf->Cell(45,5,'First Name',0,0,'L');
	$pdf->Cell(51,5,'Middle Name',0,0,'L');
	$pdf->Cell(20,5,'Auxilliary Name',0,0,'L');
	$pdf->SetFont("Arial", '', 6);
	$pdf->Cell(20,5,'(e.g. jr lll, etc.)',0,0,'L');

	$pdf->Rect(14,$pdf->GetY()+4.8,52,6);
	$pdf->Rect(67.5,$pdf->GetY()+4.8,52,6);
	$pdf->Rect(121,$pdf->GetY()+4.8,42.5,6);
	$pdf->Rect(165,$pdf->GetY()+4.8,30,6);
	$pdf->Ln(5.4);
	$pdf->Cell(9);
	$pdf->SetFont("Arial", '', 8);
	$bday = $data['StudentApplication']['birth_date']? $data['StudentApplication']['birth_date']->format('m/d/Y') : '';
	$pdf->Cell(53,5,$bday,0,0,'L');
	$pdf->Cell(54,5,$data['StudentApplication']['birth_place'],0,0,'L');
	$pdf->Cell(45,5,$data['StudentApplication']['nationality'],0,0,'L');

	$gender1 = '';
	$gender2 = '';

	if($data['StudentApplication']['gender'] == 'Male'){
	  $gender1 = 4;
	}else if($data['StudentApplication']['gender'] == 'Female'){
	  $gender2 = 4;
	}
	$pdf->SetFont("zapfdingbats", '', 8);

	$pdf->Cell(14,5,$gender1,0,0,'L');
	$pdf->Cell(1,5,$gender2,0,0,'L');
	$pdf->Rect(167,$pdf->GetY()+1.1,2.5,2.5);
	$pdf->Rect(181,$pdf->GetY()+1.1,2.5,2.5);
	$pdf->Ln(0.1);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(165);
	$pdf->Cell(13,5,'Male',0,0,'L');
	$pdf->Cell(20,5,'Female',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(8);
	$pdf->Cell(53,5,'Date of Birth (m/d/y)',0,0,'L');
	$pdf->Cell(54,5,'Place of Birth',0,0,'L');
	$pdf->Cell(54,5,'Nationality',0,0,'L');
	$pdf->Cell(53,5,'Gender',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(9);
	$pdf->Cell(54,5,$data['StudentApplication']['ethnic_group'],0,0,'L');
	$pdf->Cell(51,5,$data['StudentApplication']['religion'],0,0,'L');
	$pdf->Cell(48,5,$data['StudentApplication']['contact_no'],0,0,'L');


	$civil1 = '';
	$civil2 = '';

	if($data['StudentApplication']['civil_status'] == 'Single'){
	  $civil1 = 4;
	}else if($data['StudentApplication']['civil_status'] == 'Maried'){
	  $civil2 = 4;
	}
	$pdf->SetFont("zapfdingbats", '', 8);

	$pdf->Cell(13,5,$civil1,0,0,'L');
	$pdf->Cell(1,5,$civil2,0,0,'L');

	$pdf->SetFont("Arial", '', 7);

	$pdf->Rect(14,$pdf->GetY()-.7,52,6);
	$pdf->Rect(67.5,$pdf->GetY()-.7,49,6);
	$pdf->Rect(118,$pdf->GetY()-.7,47,6);
	$pdf->Rect(166.5,$pdf->GetY()-.7,28.5,6);

	$pdf->Ln(-1.5);
	$pdf->Rect(168,$pdf->GetY()+2.5,2.5,2.5);
	$pdf->Rect(181,$pdf->GetY()+2.5,2.5,2.5);
	$pdf->Ln(1.5);
	$pdf->Cell(165);
	$pdf->Cell(13,5,'Single',0,0,'L');
	$pdf->Cell(20,5,'Maried',0,0,'L');
	$pdf->Ln(5.5);
	$pdf->Cell(8);
	$pdf->Cell(17,5,'Ethnic Group',0,0,'L');
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(36.5,5,'(e.g. Chavacano, Tausug, Bisaya etc.)',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(10,5,'Religion',0,0,'L');
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(41,5,'(e.g. Catholic, Protestant, Islam etc.)',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(20,5,'Contact Number',0,0,'L');
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(28.5,5,'(Landline or Mobile)',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(17,5,'Civil Status',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5.3,114.5,6);
	$pdf->Rect(130,$pdf->GetY()+5.3,65,6);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(9);
	$pdf->Cell(116,5,$data['StudentApplication']['address'],0,0,'L');
	$pdf->Cell(48,5,$data['StudentApplication']['email'],0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(8);
	$pdf->Cell(116,5,'Complete Home Address',0,0,'L');
	$pdf->Cell(30,5,'E- mail Address',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5,70,6);
	$pdf->Rect(85,$pdf->GetY()+5,40,6);
	$pdf->Rect(126,$pdf->GetY()+5,68.5,6);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(9);
	$pdf->Cell(72,5,$data['StudentApplication']['guardian_name'],0,0,'L');
	$pdf->Cell(40,5,$data['StudentApplication']['guardian_relationship'],0,0,'L');
	$pdf->Cell(50,5,$data['StudentApplication']['guardian_contact'],0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(8);
	$pdf->Cell(72,5,'Name of Parents or Guardian',0,0,'L');
	$pdf->Cell(40,5,'Relationship',0,0,'L');
	$pdf->Cell(50,5,'Contact No. of Parants/Guardian',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5.5,70,6);
	$pdf->Rect(85,$pdf->GetY()+5.5,109.5,6);


	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(9);
	$pdf->Cell(72,5,$data['StudentApplication']['guardian_occupation'],0,0,'L');
	$pdf->Cell(72,5,$data['StudentApplication']['guardian_address'],0,0,'L');
	$pdf->Ln(5);

	$pdf->Cell(8);
	$pdf->Cell(72,5,'Occupation of Parents or Guardian',0,0,'L');
	$pdf->Cell(72,5,'Complete Home Address of Parents or Guardian',0,0,'L');
	$pdf->Ln(5);
	$pdf->Line(11,$pdf->GetY()+1,198.5,$pdf->GetY()+1);
	$pdf->Ln(2);
	$pdf->Rect(11,$pdf->GetY(),187.5,40);
	$pdf->Ln(0.7);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(8);
	$pdf->Cell(26,5,'SCHOOL DATA',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5,151.5,6);
	$pdf->Rect(167,$pdf->GetY()+5,28.5,6);
	$pdf->Ln(2);
	$pdf->Rect(168,$pdf->GetY()+4.5,2.5,2.5);
	$pdf->Rect(179,$pdf->GetY()+4.5,2.5,2.5);
	$pdf->Ln(3.4);
	$pdf->Cell(165);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(11,5,'New',0,0,'L');
	$pdf->Cell(20,5,'Transferee',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(-187);
	$pdf->Cell(153,5,$data['StudentApplication']['last_school'],0,0,'L');

	$type1 = '';
	$type2 = '';

	if($data['StudentApplication']['student_type'] == 'New'){
	  $type1 = 4;
	}else if($data['StudentApplication']['student_type'] == 'Transferee'){
	  $type2 = 4;
	}
	$pdf->SetFont("zapfdingbats", '', 8);

	$pdf->Cell(11,5,$type1,0,0,'L');
	$pdf->Cell(1,5,$type2,0,0,'L');

	$pdf->SetFont("Arial", '', 7);

	$pdf->Ln(5.7);
	$pdf->Cell(8);
	$pdf->Cell(154,5,'Name of last school attended (Do not abbreviate)',0,0,'L');
	$pdf->Cell(20,5,'Type of Student',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5,151.5,6);
	$pdf->Rect(167,$pdf->GetY()+5,28.5,6);
	$pdf->Ln(2);
	$pdf->Rect(167.5,$pdf->GetY()+4.5,2.5,2.5);
	$pdf->Rect(176.5,$pdf->GetY()+4.5,2.5,2.5);
	$pdf->Rect(185.5,$pdf->GetY()+4.5,2.5,2.5);
	$pdf->Ln(3.4);
	$pdf->Cell(164.8);
	$pdf->Cell(9,5,'ALS',0,0,'L');
	$pdf->Cell(9.5,5,'BEC',0,0,'L');
	$pdf->Cell(9,5,'K-12',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(-183);
	$pdf->Cell(152.3,5,$data['StudentApplication']['last_school_address'],0,0,'L');

	$curr1 = '';
	$curr2 = '';
	$curr3 = '';

	if($data['StudentApplication']['curriculumn'] == 'ALS'){
	  $curr1 = 4;
	}else if($data['StudentApplication']['curriculumn'] == 'BEC'){
	  $curr2 = 4;
	}else if($data['StudentApplication']['curriculumn'] == 'K-12'){
	  $curr3 = 4;
	}

	$pdf->SetFont("zapfdingbats", '', 8);

	$pdf->Cell(9,5,$curr1,0,0,'L');
	$pdf->Cell(9,5,$curr2,0,0,'L');
	$pdf->Cell(1,5,$curr3,0,0,'L');

	$pdf->Ln(5.7);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(8);
	$pdf->Cell(154,5,'Complete School Address',0,0,'L');
	$pdf->Cell(20,5,'High School Curriculum',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5.3,126,6);
	$pdf->Rect(141,$pdf->GetY()+5.3,24,6);
	$pdf->Rect(166.8,$pdf->GetY()+5.3,28,6);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(9);
	$pdf->Cell(128.3,5,$data['StudentApplication']['frat'],0,0,'L');
	$pdf->Cell(25.3,5,$data['StudentApplication']['year_graduated'],0,0,'L');
	$pdf->Cell(40.3,5,$data['StudentApplication']['school_type'],0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(8);
	$pdf->Cell(127,5,'Membership school clubs, organizations or fraternities (Please indicate your position)',0,0,'L');
	$pdf->Cell(26,5,'Year Graduated',0,0,'L');
	$pdf->Cell(30,5,'School Type',0,0,'L');
	$pdf->Ln(2);
	$pdf->Cell(163);
	$pdf->SetFont("Arial", '', 5);
	$pdf->Cell(26,4.4,'(e.g. Private, public, SUC etc.)',0,0,'L');
	$pdf->Ln(5.4);
	$pdf->Rect(11,$pdf->GetY(),187.5,25);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(8);
	$pdf->Cell(35,5.3,'PROGRAM REFERENCES',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(26,5.3,'(e.g. BS Marine Transportation, BSEd, BS Fishiries etc.)  *Check brochure for complete list of courses',0,0,'L');
	$pdf->Rect(14,$pdf->GetY()+5.3,181,6);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(9);
	$pdf->Cell(40.3,5,$data['CollegeProgram']['name'],0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(9);
	$pdf->Cell(161,4,'I here by certify that information indicated herein is true and correct. I am fully aware',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(40.3,5,$data['StudentApplication']['application_date']->format('m/d/Y'),0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Ln(4);
	$pdf->Cell(9);
	$pdf->Cell(35,4,'that any fraudent information would be ground for revocation of my application.',0,0,'L');
	$pdf->Rect(138.5,$pdf->GetY()-4.5,32,6);
	$pdf->Rect(173.5,$pdf->GetY()-4.5,22,6);
	$pdf->Ln(2);
	$pdf->Cell(133);
	$pdf->Cell(34,4,'Signature of Applicant',0,0,'L');
	$pdf->Cell(40,4,'Date',0,0,'L');
	$pdf->Ln(6);

	$pdf->Rect(11,$pdf->GetY(),187.5,16);
	$pdf->Ln(1);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(8);
	$pdf->Cell(25,5,'TEST SCHEDULE',0,0,'L');
	$pdf->SetFont("Arial", '', 6);
	$pdf->Cell(26,4.5,'*To be filled out by the Registration Officer',0,0,'L');
	$pdf->Rect(14.8,$pdf->GetY()+4.7,53.5,6);
	$pdf->Rect(69.7,$pdf->GetY()+4.7,53.5,6);
	$pdf->Rect(124.7,$pdf->GetY()+4.7,20,6);
	$pdf->Rect(145.7,$pdf->GetY()+4.7,50,6);
	$pdf->Ln(6);
	$pdf->Cell(11);
	$date = $data['StudentApplication']['date']? $data['StudentApplication']['date']->format('m/d/Y') : '';
	$pdf->Cell(10,4,$date,0,0,'L');
	$pdf->Cell(47);
	$pdf->Cell(10,4,$data['StudentApplication']['place']. ' - ' .$data['StudentApplication']['room'],0,0,'L');
	$pdf->Cell(43);
	$pdf->Cell(10,4,$data['StudentApplication']['time'],0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(8);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(16,4,'TEST DATE',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(40,4,'(m/d/yyyy)',0,0,'L');
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(55,4,'VENUE & ROOM NUMBER',0,0,'L');
	$pdf->Cell(20,3.2,'TIME',0,0,'L');
	$pdf->Cell(35,3.2,'APPLICATION FORM NUMBER',0,0,'L');

	$pdf->SetFont("zapfdingbats", '', 9);
	$pdf->Ln(4);
	$pdf->Cell(5);
	$pdf->Cell(5,4,'$');
	$pdf->SetDash(2.5,1.5); 
	$pdf->Line(15,$pdf->getY()+2,199,$pdf->getY()+2);
	$pdf->SetDash(); 
	$pdf->Ln(3.7);

	$pdf->Cell(6);
	$pdf->SetFont("Arial", '', 10);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(188,4.5,'STUDENT PERMIT',0,0,'C',1);
	$pdf->SetTextColor(0,0,0);

	$pdf->Ln(6);
	$y = $pdf->Gety();
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(8);
	$pdf->Cell(35,5,$data['StudentApplication']['last_name'],0,0,'L');
	$pdf->Cell(32,5,$data['StudentApplication']['first_name'],0,0,'L');
	$pdf->Cell(40,5,$data['StudentApplication']['middle_name'],0,0,'L');
	$pdf->Cell(20,5,$data['StudentApplication']['auxilliary_name'],0,0,'L');
	$pdf->Rect(11,$pdf->GetY()+-1.7,138,6);
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(5);
	$pdf->Cell(35,5,'Last Name',0,0,'L');
	$pdf->Cell(32,5,'First Name',0,0,'L');
	$pdf->Cell(35,5,'Middle Name',0,0,'L');
	$pdf->Cell(20,5,'Auxilliary Name',0,0,'L');
	$pdf->SetFont("Arial", '', 6);
	$pdf->Cell(20,5,'(e.g. jr lll, etc.)',0,0,'L');
	$pdf->SetY($y);
	$pdf->Rect(151,$pdf->GetY()+4.7,47.6,44.4);
	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(150);
	$pdf->MultiCell(40,3,"Attach 2'' x2'' photo\nwith your signature over\nprinted name at the back.",0,'C',0);
	$pdf->Ln(-13);
	$pdf->Cell(4);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(35,5,'TEST SCHEDULE',0,0,'L');
	$pdf->Rect(11,$pdf->GetY()+4.7,138,14);
	$pdf->Ln(2);
	$pdf->Rect(14,$pdf->GetY()+5.5,33,6);
	$pdf->Rect(48.8,$pdf->GetY()+5.5,44.5,6);
	$pdf->Rect(95,$pdf->GetY()+5.5,14,6);
	$pdf->Rect(110,$pdf->GetY()+5.5,37,6);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Ln(6);
	$pdf->Cell(11);
	$pdf->Cell(10,4,$date,0,0,'C');
	$pdf->Cell(25);
	$pdf->Cell(10,4,$data['StudentApplication']['place']. ' - ' .$data['StudentApplication']['room'],0,0,'C');
	$pdf->Cell(35);
	$pdf->Cell(10,4,$data['StudentApplication']['time'],0,0,'C');
	$pdf->Ln(6);
	$pdf->Cell(7.5);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(16,4,'TEST DATE',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(19,4,'(m/d/y)',0,0,'L');
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(47,4,'VENUE & ROOM NUMBER',0,0,'L');
	$pdf->Cell(14.5,4,'TIME',0,0,'L');
	$pdf->Cell(19,4,'APPLICATION FORM NO.',0,0,'L');
	$pdf->Ln(1);
	$pdf->SetDash(1,1); 
	$pdf->Rect(11,$pdf->GetY()+4.7,77,13);
	$pdf->SetDash();
	$pdf->Ln(4.7);
	$pdf->SetFont("Arial", 'B', 6);
	$pdf->Cell(7);
	$y = $pdf->GetY();
	$pdf->Cell(16,4,'IMPORTANT REMINDERS',0,0,'L');
	$pdf->SetFont("Arial", '', 6);
	$pdf->Ln(4);
	$pdf->Cell(7);
	$pdf->Cell(16,4,'1. Bring student permit on test date and present this to the proctor.',0,0,'L');
	$pdf->Ln(2.5);
	$pdf->Cell(7);
	$pdf->Cell(16,4,'2. Bring at least two MONGOL #2 pencils',0,0,'L');
	$pdf->Ln(2.2);
	$pdf->Cell(7);
	$pdf->Cell(16,4,'3. Present this permit when claiming results',0,0,'L');
	$pdf->Ln(4);
	$pdf->Cell(5);
	$pdf->Cell(16,4,'*This form may be photocopied or reproduced.',0,0,'L');

	$pdf->SetY($y+0.2);
	$pdf->SetFont("Arial", '', 7.5);
	$pdf->Cell(86);
	$pdf->Cell(16,4,'Verified by:',0,0,'L');
	$pdf->Rect(92.7,$pdf->GetY()+4.2,56.5,6);
	$pdf->Ln(11);
	$pdf->Cell(87);
	$pdf->Cell(16,4,"Registration Officer's Name & Signature",0,0,'L');

	$pdf->output();
	exit();

  }

  public function addDrop(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(AddingDroppingSubject.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(AddingDroppingSubject.date) >= '$start' AND DATE(AddingDroppingSubject.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND AddingDroppingSubject.approve = $status";

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $employee_id = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND AddingDroppingSubject.student_id = $employee_id";

	}

	$tmpData = $this->AddingDroppingSubjects->getAllAddingDroppingSubjectPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ADDING AND/OR DROPPING OF SUBJECT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(170,5,'COURSE',1,0,'C',1);
	$pdf->Cell(30,5,'DATE',1,0,'C',1);
	$pdf->Cell(30,5,'STATUS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,50,170,30,30));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$status = '';

		if($data['approve'] == 0){

		  $status = 'PENDING';

		}elseif($data['approve'] == 1){

		  $status = 'APPROVED';

		}elseif($data['approve'] == 2){

		  $status = 'DISAPPROVED';

		}


		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['program'],

		  fdate($data['date'],'m/d/Y'),

		   $status,

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+188,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function addingDroppingSubjectForm($id = null){

	$office_reference = $this->Global->OfficeReference('Adding/Dropping Subject');

	$data['AddingDroppingSubject'] = $this->AddingDroppingSubjects->find()

		->contain([

			'Students',

			'AddingDroppingSubjectSubs'

		])

		->where([

			'AddingDroppingSubjects.visible' => 1,

			'AddingDroppingSubjects.id'      => $id,

		])

		->first();

		// debug($data['AddingDroppingSubject']);    

	$data['AddingDroppingSubjectSub'] = $data['AddingDroppingSubject']['adding_dropping_subject_subs'];   

	$tmpData = $data['AddingDroppingSubjectSub'];

	$data['Student'] = $data['AddingDroppingSubject']['student'];

	unset($data['AddingDroppingSubject']['adding_dropping_subject_subs']);

	unset($data['AddingDroppingSubject']['student']);    

	

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,9,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	// $pdf->Image($this->base .'/assets/img/adding_dropping.png',0,0,215.9,355.6);
	$pdf->Image($this->base .'/assets/img/zam.png',8.5,14,22,21);
	$pdf->Image($this->base .'/assets/img/iso.png',192,14,16,22);
	$pdf->SetFont("Times", '', 12);
	$pdf->Ln(3.5);
	$pdf->Cell(-2);
	$pdf->Cell(0,11,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(2);
	$pdf->Cell(0,13,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(-1);
	$pdf->Cell(0,15,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(-4);
	$pdf->Cell(0,17,'OFFICE OF THE COLLEGE REGISTRAR',0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(-2);
	$pdf->Cell(0,19,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph   email: registrar@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(20);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(25,$pdf->getY()-5.8,173.5,$pdf->getY()-5.8);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(25,$pdf->getY()-5,173.5,$pdf->getY()-5);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(175,$pdf->GetY() -7.5,30,14);
	$pdf->Ln(7);
	$pdf->SetY($pdf->getY()- 10.5);

	$pdf->SetFont("Times", 'B', 16);
	$pdf->Cell(79.5);
	$pdf->Cell(45,24,'Adding  and  Dropping of  Subjects',0,0,'C');
	$pdf->SetLineWidth(0.6);
	$pdf->SetLineWidth(0.2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->SetY($pdf->getY()- 2.5);
	$pdf->Cell(171);
	$pdf->Cell(0,4,'ZSCMST- '. @$office_reference['OfficeReference']['reference_code'] ,0,0,'L');
	
	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(162);
	$pdf->Cell(9,5,'',0,0,'L');
	$pdf->Cell(68,4,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->Ln(2);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(162);
	$pdf->Cell(9,5,'',0,0,'L');
	$pdf->Cell(65,6,'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Arial", '', 5.5);
	$pdf->Cell(162);
	$pdf->Cell(9,5,'',0,0,'L');
	$pdf->Cell(65,7,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(23);

	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(-9,5,'',0,0,'L');
	$pdf->Cell(72,4.7,'Name : ',0,0,'C');
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-30,5,'',0,0,'L');
	$pdf->Cell(15,4,$data['AddingDroppingSubject']['student_name'],0,0,'L');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(39,$pdf->getY()+4.4,126,$pdf->getY()+4.4);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(50,5,'',0,0,'L');
	$pdf->Cell(72,4.7,'Student No. ',0,0,'C');
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-26,5,'',0,0,'L');
	$pdf->Cell(15,4.7,$data['AddingDroppingSubject']['student_no'],0,0,'L');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(153,$pdf->getY()+4.4,190,$pdf->getY()+4.4);
	$pdf->Ln(10.2);

	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(-8.5,5,'',0,0,'L');
	$pdf->Cell(70,8,'Course: ',0,0,'C');
	$pdf->SetFont("TIMES", '', 10);
	$pdf->Cell(-25, 5, '', 0, 0, 'L');
	$program = $data['AddingDroppingSubject']['program'];
	$programParts = explode(' ', $program);
	$currentLine = '';
	$remainingLine = '';

	foreach ($programParts as $key => $part) {
		if (strlen($currentLine . $part) < 75) {
			$currentLine .= $part . ' ';
		} else {
			$remainingLine = $part . ' ';
			break;
		}
	}

	$pdf->Cell(15, 4.7, $currentLine, 0, 0, 'L');
	$pdf->Ln();

	if (!empty($remainingLine)) {
		$pdf->Cell(33, 5, '', 0, 0, 'L');
		$pdf->Cell(15, 4.7, $remainingLine, 0, 0, 'L');
	}

	$pdf->Cell(3, 5, '', 0, 0, 'L');
	$pdf->Line(39.5, $pdf->getY() + 4.4, 190, $pdf->getY() + 4.4);


	$pdf->Ln(125);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(-6,5,'',0,0,'L');
	$pdf->Cell(72,4.7,'Reason/s: ',0,0,'C');
	$pdf->Ln(9);

	// $pdf->Line(29,$pdf->getY()+4,192,$pdf->getY()+4);
	// $pdf->Line(29,$pdf->getY()+13,192,$pdf->getY()+13);
	// $pdf->Cell(24,1,'',0,0,'C');
	// $pdf->MultiCell(173,3,$data['AddingDroppingSubject']['reason'],0, 'L');

	// if($pdf->GetY() == 114.5){
	//   $pdf->Ln(15);
	// }elseif($pdf->GetY() == 120){
	//   $pdf->Ln(9);
	// }elseif($pdf->GetY() >= 125.5){
	//   $pdf->Ln(4);
	// }

	$pdf->Line(29, $pdf->getY()+5.5, 200, $pdf->getY()+5.5);
	$pdf->Line(29, $pdf->getY()+13, 200, $pdf->getY()+13);
	$pdf->Cell(24, -2, '', 0, 0, 'C');
	$pdf->MultiCell(173, 7, $data['AddingDroppingSubject']['reason'], 0, 'L');

	if ($pdf->GetY() >= 100 && $pdf->GetY() < 110) {
		$pdf->Ln(9);
	} elseif ($pdf->GetY() >= 120 && $pdf->GetY() < 125.5) {
		$pdf->Ln(6.5);
	}


	$pdf->Ln(14);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(-2,5,'',0,0,'L');
	$pdf->Cell(72,4.7,'Fee Charged: ',0,0,'C');
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(51,$pdf->getY()+4.4,93,$pdf->getY()+4.4);
	$pdf->Ln(8.9);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(-2,5,'',0,0,'L');
	$pdf->Cell(72,4.7,'O.R. Number: ',0,0,'C');
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(54,$pdf->getY()+4.4,93,$pdf->getY()+4.4);
	$pdf->Ln(8.5);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(-9.5,5,'',0,0,'L');
	$pdf->Cell(72,4.7,'Date: ',0,0,'C');
	$pdf->SetFont("TIMES", '', 12);
	 $pdf->Cell(-30,4.5,'',0,0,'L');
	$pdf->Cell(15,4,date('m/d/Y', strtotime($data['AddingDroppingSubject']['date'])),0,0,'L');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(36,$pdf->getY()+4.2,93,$pdf->getY()+4.2);

	$pdf->Ln(17);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(101,5,'',0,0,'L');
	$pdf->Cell(72,4.7,'Recommending Approval: ',0,0,'C');

	$pdf->Ln(17);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Line(117.8,$pdf->getY()+4.7,180.5,$pdf->getY()+4.7);
	$pdf->Cell(103,5,'',0,0,'L');
	$pdf->Cell(72,18,'Program Adviser ',0,0,'C');

	$pdf->Ln(12);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(20,4.7,'',0,0,'L');
	$pdf->Cell(173,5,'Noted: ',0);

	$pdf->Ln(17);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Line(25.8,$pdf->getY()+5,91,$pdf->getY()+5);
	$pdf->Ln(5.6);
	$pdf->SetFont("TIMES", '', 13);
	$pdf->Cell(16,4.7,'',0,0,'L');
	$pdf->Cell(68,7,'College Registrar',0,0,'C');

	$pdf->Ln(-229);
	$pdf->SetFont("TIMES", 'B', 12);
	$pdf->Cell(-1, 8, '', 0, 0, 'C');
	$pdf->Cell(104, 5.4, 'Subjects to be ADDED and/or DROPPED', 1, 0, 'C', 0, '', 0, false, 'C', 'C');
	$pdf->Cell(104, 5.4, 'INSTRUCTORS/ PROFESSORS', 1, 0, 'C', 0, '', 0, false, 'C', 'C');

	$pdf->Ln();
	$pdf->SetWidths(array(104, 104));
	$pdf->SetAligns(array('C', 'C'));
	$pdf->SetFont("Times", '', 6);
	$rows = 0;

	if ($tmpData != null) {
	foreach ($tmpData as $key => $data) {
		$tmp = $data['AddingDroppingSubjectSub'];
		$pdf->Cell(3);
		$y = $pdf->GetY();

		$pdf->SetFont("Arial", '', 8);
		$courseTitle = $data['course_title'];
		$status = $data['status'];
		
		$courseTitle = $data['course_title'];
		$status = $data['status'];
		$courseTitleParts = explode(' ', $courseTitle);
		$courseTitleLines = [];

		$currentLine = '';
		foreach ($courseTitleParts as $part) {
			if (strlen($currentLine . $part) <= 65) {
				$currentLine .= $part . ' ';
			} else {
				$courseTitleLines[] = $currentLine;
				$currentLine = $part . ' ';
			}
		}
		$courseTitleLines[] = $currentLine;

		if (strlen($courseTitle) < 20 || strlen($courseTitle) <= 65) {
			$pdf->Cell(-3.9, 10, '', 0, 0, 'C');
			$pdf->MultiCell(104, 10, implode("\n", $courseTitleLines) . " - " . $status, 1, 'C');
		} else {
			$pdf->Cell(-3.9, 10, '', 0, 0, 'C');
			$pdf->MultiCell(104, 5, implode("\n", $courseTitleLines) . " - " . $status, 1, 'C');
		}

		$pdf->SetY($y);

		$pdf->SetFont("Arial", '', 8);
		$pdf->Cell(102.9, 10, '', 0, 0, 'C');
		$pdf->CellFitSpace(104, 10, $data['faculty_name'], 1, 0, 'C');
		$pdf->Ln(10);

		$rows++;
		}

		if ($rows < 9) {
			for ($x = $rows; $x <= 9; $x++) {
				$pdf->Cell(3);
				$pdf->Cell(-3.9, 10, '', 0, 0, 'C');

				if (!empty($content1)) {
					$pdf->Cell(103.9, 10, $content1, 1, 0, 'C');
				} else {
					$pdf->Cell(103.9, 10, '', 1, 0, 'C');
				}

				if (!empty($content2)) {
					$pdf->Cell(103.9, 10, $content2, 1, 0, 'C');
				} else {
					$pdf->Cell(103.9, 10, '', 1, 0, 'C');
				}

				$pdf->Ln(10);
			}
		}
		} else {
			$pdf->Cell(3);
			$pdf->Cell(-3.9, 10, '', 0, 0, 'C');
			$pdf->Cell(208, 10, 'No data available.', 1, 1, 'C');

			for ($x = 1; $x <= 9; $x++) {
				$pdf->Cell(3);
				$pdf->Cell(-3.9, 10, '', 0, 0, 'C');
				$pdf->Cell(104, 10, '', 1, 0, 'C');
				$pdf->Cell(104, 10, '', 1, 0, 'C');
				$pdf->Ln(10);
			}
		}

	$pdf->Ln(-95);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'1. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'2. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'3. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'4. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'5. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'6. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'7. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'8. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-34,5,'',0,0,'L');
	$pdf->Cell(72,5,'9. ',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("TIMES", '', 12);
	$pdf->Cell(-33.5,5,'',0,0,'L');
	$pdf->Cell(72,5,'10. ',0,0,'C');


	$pdf->output();
	exit();

  }

  public function medicalPropertyEquipments(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(PropertyLog.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

	}

	$tmpData = $this->Reports->getAllMedicalPropertyEquipmentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PROPERTY & EQUIPMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 9);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(115,5,'NAME',1,0,'C');
	$pdf->Cell(40,5,'TYPE',1,0,'C');
	$pdf->Cell(40,5,'DATE',1,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,115,40,40));
	$pdf->SetAligns(array('C','L','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['property_name'],

		  $data['type'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function consultationReport(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

	}

	$tmpData = $this->Reports->getAllConsultationEmployeePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'CONSULTATION REPORT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 9);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(115,5,'NAME',1,0,'C');
	$pdf->Cell(80,5,'DATE',1,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,115,80));
	$pdf->SetAligns(array('C','L','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['employee_name'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function consultationEmployeeReport(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

	}

	$tmpData = $this->Reports->getAllConsultationEmployeePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'CONSULTATION REPORT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 9);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(90,5,'NAME',1,0,'C');
	$pdf->Cell(30,5,'DATE',1,0,'C');
	$pdf->Cell(45,5,'REMARKS',1,0,'C');
	$pdf->Cell(30,5,'STATUS',1,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,90,30,45,30));
	$pdf->SetAligns(array('C','L','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		if($data['status'] == 0){

		  $status = 'PENDING';

		}else if($data['status'] == 3){

		  $status = 'APPROVED';

		}else if($data['status'] == 4){

		  $status = 'DISAPPROVED';

		}else if($data['status'] == 1){

		  $status = 'TREATED';

		}else if($data['status'] == 2){

		  $status = 'REFERRED';

		}

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['employee_name'],

		  fdate($data['date'],'m/d/Y'),

		  $data['nurse_remarks'],

		  $status,

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function employeeFrequencyReport(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

	}

	$tmpData = $this->Reports->getAllEmployeeFrequencyPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'EMPLOYEE CONSULATION FREQUENCY REPORT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 9);
	$pdf->Cell(10,5,'#',1,0,'C');
	$pdf->Cell(115,5,'NAME',1,0,'C');
	$pdf->Cell(80,5,'NO. OF TIMES',1,0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,115,80));
	$pdf->SetAligns(array('C','L','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['employee_name'],

		  $data['frequency'],

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function subjectMasterlists(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['college_program_id'] = " AND CollegeProgramCourse.college_program_id IS NULL";

	if ($this->request->getQuery('college_program_id')) {

	  $college_program_id = $this->request->getQuery('college_program_id'); 

	  $conditions['college_program_id'] = " AND CollegeProgramCourse.college_program_id = $college_program_id";

	}

	$tmpData = $this->Reports->getAllSubjectMasterListPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'SUBJECT MASTERLISTS',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	
	// Centering the table
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);
	
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(182, 5, 'SUBJECT', 1, 0, 'C', 1);
	// Resetting the left margin to default
	$pdf->SetLeftMargin(0);
	

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,182,65,65,182));
	$pdf->SetAligns(array('C','C','C','C','C'));
	$tableWidth = 200; // Total width of the table
	$leftMargin = ($pdf->GetPageWidth() - $tableWidth) / 2; // Calculating the left margin
	$pdf->SetLeftMargin($leftMargin);

	  // Resetting the left margin to default
	  
	 if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['course'], 

		));

	  }

	}else{
  
	  $tableWidth = 200;
	  $pdf->Cell(197,5,'No data available.',1,1,'C');
	;}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+117,$pdf->getY()+2,$pdf->getX()+197,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	
	exit();

  }

  public function enrollmentList(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

	}

	$conditions['year_term_id'] = " AND Student.year_term_id IS NULL";

	$conditions['year_term_id_enrollment'] = '';

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

	  $conditions['year_term_id_enrollment'] = " AND StudentEnrollment.year_term_id = $year_term_id";

	}

	$this->loadModel('Reports');

	$tmpData =$this->Reports->getAllEnrollmentListPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ENROLLMENT LIST REPORT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,8,'#',1,0,'C');
	$pdf->Cell(22,4,'STUDENT','LTR',0,'C');
	$pdf->Cell(45,8,'STUDENT NAME',1,0,'C');
	$pdf->Cell(58,8,'COLLEGE',1,0,'C');
	$pdf->Cell(50,8,'PROGRAM',1,0,'C');
	$pdf->Cell(22,4,'REGISTRATION','LTR',0,'C');
	$pdf->Ln(4);
	$pdf->Cell(8,4,'',0,0,'C');
	$pdf->Cell(22,4,'NUMBER','LBR',0,'C');
	$pdf->Cell(153,4,'',0,0,'C');
	$pdf->Cell(22,4,'DATE','LBR',0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,22,45,58,50,22));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['college'],

		  $data['program'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function customer_satisfaction_form($id = null) {

	$office_reference = $this->Global->OfficeReference('Customer Satisfaction');

   $data = $this->CustomerSatisfaction->find('first', array(

	  'conditions' => array(

		'CustomerSatisfaction.visible' => true,

		'CustomerSatisfaction.id' => $id,

	  )

	));

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(3,4,3);
	$pdf->AddPage("P", "A4", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11.5);
	// $pdf->Image($this->base .'/assets/img/promissory_note.png',0,0,210,297);
	$pdf->Image($this->base .'/assets/img/zam.png',12,4,22,22);
	$pdf->Image($this->base .'/assets/img/iso.png',190,5,15,20);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 8);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph   email: zscmstguidance@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,205,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,205,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(12,$pdf->GetY() + 3.5,31,13);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,4,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(45,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", 'B', 12.5);
	$pdf->Cell(45,20,'CUSTOMER SATISFACTION FORM',0,0,'C');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(7);

	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->MultiCell(190,4,'    This Client Satisfaction Measurement (CSM) tracks the customer experience of government offices. Your feedback on your receently concluded transaction will help this office provide a better service. Personal information shared will be kept confidential and you always have the option to not answer this form. ',0,1);
	$pdf->ln(1);

	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'Client Type : ',0,0,'L');
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(90,5,$data['CustomerSatisfaction']['client_type'],0,0,'L');
	$pdf->Line(33,$pdf->getY()+4,100,$pdf->getY()+4);
	$pdf->ln(5);

	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'Date : ',0,0,'L');
	$pdf->Cell(90,5,fdate($data['CustomerSatisfaction']['date'],'m/d/Y'),0,0,'L');
	$pdf->Cell(-45,5,'',0,0,'L');
	$pdf->Cell(5,5,'Sex : ',0,0,'C');
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(80,5,$data['CustomerSatisfaction']['sex'],0,0,'L');
	$pdf->Cell(-45,5,'',0,0,'L');
	$pdf->Cell(5,5,'Age : ',0,0,'C');
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(80,5,$data['CustomerSatisfaction']['age'],0,0,'L');
	$pdf->Line(123,$pdf->getY()+4,150,$pdf->getY()+4);
	$pdf->Line(24,$pdf->getY()+4,60,$pdf->getY()+4);
	$pdf->Line(78,$pdf->getY()+4,100,$pdf->getY()+4);
	$pdf->Ln(7);

	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'Region of Residence : ',0,0,'L');
	$pdf->Cell(25,5,'',0,0,'L');
	$pdf->Cell(75,5,$data['CustomerSatisfaction']['region_of_residence'],0,0,'L');
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(-10,5,'Service Availed : ',0,0,'C');
	$pdf->Cell(18,5,'',0,0,'L');
	$pdf->Cell(80,5,$data['CustomerSatisfaction']['service_availed'],0,0,'L');
	$pdf->Line(47,$pdf->getY()+4,100,$pdf->getY()+4);
	$pdf->Line(138,$pdf->getY()+4,180,$pdf->getY()+4);
	$pdf->ln(6);

	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->MultiCell(170,4,'INSTRUCTIONS: Check mark your answer to the Citizen\'s Charter (CC) questions. The Citizen\'s Charter is an Official document that reflects the services of a government agency/office including its requirements, fees, and its processing times among others.',0, 'L');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Ln(1);

	$a1 = '';
	$b1 = '';
	$c1 = '';
	$d1 = '';
	$e1 = '';
	$f1 = '';
	$g1 = '';
	$h1 = '';
	$i1 = '';
	$j1 = '';
	$k1 = '';
	$l1 = '';

	$a2 = '';
	$b2 = '';
	$c2 = '';
	$d2 = '';
	$e2 = '';
	$f2 = '';
	$g2 = '';
	$h2 = '';
	$i2 = '';
	$j2 = '';
	$k2 = '';
	$l2 = '';

	$a3 = '';
	$b3 = '';
	$c3 = '';
	$d3 = '';
	$e3 = '';
	$f3 = '';
	$g3 = '';
	$h3 = '';
	$i3 = '';
	$j3 = '';
	$k3 = '';
	$l3 = '';

	$a4 = '';
	$b4 = '';
	$c4 = '';
	$d4 = '';
	$e4 = '';
	$f4 = '';
	$g4 = '';
	$h4 = '';
	$i4 = '';
	$j4 = '';
	$k4 = '';
	$l4 = '';

	$a5 = '';
	$b5 = '';
	$c5 = '';
	$d5 = '';
	$e5 = '';
	$f5 = '';
	$g5 = '';
	$h5 = '';
	$i5 = '';
	$j5 = '';
	$k5 = '';
	$l5 = '';

	$a6 = '';
	$b6 = '';
	$c6 = '';
	$d6 = '';
	$e6 = '';
	$f6 = '';
	$g6 = '';
	$h6 = '';
	$i6 = '';

	// A

	  if($data['CustomerSatisfaction']['a'] == 1) {

		  $a1 = 4;

		} elseif($data['CustomerSatisfaction']['a'] == 2){

		  $a2 = 4;

		} elseif($data['CustomerSatisfaction']['a'] == 3){

		  $a3 = 4;

		} elseif($data['CustomerSatisfaction']['a'] == 4){

		  $a4 = 4;

		} elseif($data['CustomerSatisfaction']['a'] == 5){

		  $a5 = 4;

		} elseif($data['CustomerSatisfaction']['a'] == 6){

		  $a6 = 4;

		}

	// B

	  if($data['CustomerSatisfaction']['b'] == 1) {

		  $b1 = 4;

		} elseif($data['CustomerSatisfaction']['b'] == 2){

		  $b2 = 4;

		} elseif($data['CustomerSatisfaction']['b'] == 3){

		  $b3 = 4;

		} elseif($data['CustomerSatisfaction']['b'] == 4){

		  $b4 = 4;

		} elseif($data['CustomerSatisfaction']['b'] == 5){

		  $b5 = 4;

		} elseif($data['CustomerSatisfaction']['b'] == 6){

		  $b6 = 4;

		} 

	// C

	  if($data['CustomerSatisfaction']['c'] == 1) {

		  $c1 = 4;

		} elseif($data['CustomerSatisfaction']['c'] == 2){

		  $c2 = 4;

		} elseif($data['CustomerSatisfaction']['c'] == 3){

		  $c3 = 4;

		} elseif($data['CustomerSatisfaction']['c'] == 4){

		  $c4 = 4;

		} elseif($data['CustomerSatisfaction']['c'] == 5){

		  $c5 = 4;

		} elseif($data['CustomerSatisfaction']['c'] == 6){

		  $c6 = 4;

		} 

	// D

	  if($data['CustomerSatisfaction']['d'] == 1) {

		  $d1 = 4;

		} elseif($data['CustomerSatisfaction']['d'] == 2){

		  $d2 = 4;

		} elseif($data['CustomerSatisfaction']['d'] == 3){

		  $d3 = 4;

		} elseif($data['CustomerSatisfaction']['d'] == 4){

		  $d4 = 4;

		} elseif($data['CustomerSatisfaction']['d'] == 5){

		  $d5 = 4;

		} elseif($data['CustomerSatisfaction']['d'] == 6){

		  $d6 = 4;

		} 

	// E 

	  if($data['CustomerSatisfaction']['e'] == 1) {

		  $e1 = 4;

		} elseif($data['CustomerSatisfaction']['e'] == 2){

		  $e2 = 4;

		} elseif($data['CustomerSatisfaction']['e'] == 3){

		  $e3 = 4;

		} elseif($data['CustomerSatisfaction']['e'] == 4){

		  $e4 = 4;

		} elseif($data['CustomerSatisfaction']['e'] == 5){

		  $e5 = 4;

		} elseif($data['CustomerSatisfaction']['e'] == 6){

		  $e6 = 4;

		} 

	// F

	  if($data['CustomerSatisfaction']['f'] == 1) {

		  $f1 = 4;

		} elseif($data['CustomerSatisfaction']['f'] == 2){

		  $f2 = 4;

		} elseif($data['CustomerSatisfaction']['f'] == 3){

		  $f3 = 4;

		} elseif($data['CustomerSatisfaction']['f'] == 4){

		  $f4 = 4;

		} elseif($data['CustomerSatisfaction']['f'] == 5){

		  $f5 = 4;

		} elseif($data['CustomerSatisfaction']['f'] == 6){

		  $f6 = 4;

		} 

	// G 

	  if($data['CustomerSatisfaction']['g'] == 1) {

		  $g1 = 4;

		} elseif($data['CustomerSatisfaction']['g'] == 2){

		  $g2 = 4;

		} elseif($data['CustomerSatisfaction']['g'] == 3){

		  $g3 = 4;

		} elseif($data['CustomerSatisfaction']['g'] == 4){

		  $g4 = 4;

		} elseif($data['CustomerSatisfaction']['g'] == 5){

		  $g5 = 4;

		} elseif($data['CustomerSatisfaction']['g'] == 6){

		  $g6 = 4;

		} 

	// H

	  if($data['CustomerSatisfaction']['h'] == 1) {

		  $h1 = 4;

		} elseif($data['CustomerSatisfaction']['h'] == 2){

		  $h2 = 4;

		} elseif($data['CustomerSatisfaction']['h'] == 3){

		  $h3 = 4;

		} elseif($data['CustomerSatisfaction']['h'] == 4){

		  $h4 = 4;

		} elseif($data['CustomerSatisfaction']['h'] == 5){

		  $h5 = 4;

		} elseif($data['CustomerSatisfaction']['h'] == 6){

		  $h6 = 4;

		} 

	// I 

	  if($data['CustomerSatisfaction']['i'] == 1) {

		  $i1 = 4;

		} elseif($data['CustomerSatisfaction']['i'] == 2){

		  $i2 = 4;

		} elseif($data['CustomerSatisfaction']['i'] == 3){

		  $i3 = 4;

		} elseif($data['CustomerSatisfaction']['i'] == 4){

		  $i4 = 4;

		} elseif($data['CustomerSatisfaction']['i'] == 5){

		  $i5 = 4;

		} elseif($data['CustomerSatisfaction']['i'] == 6){

		  $i6 = 4;

		}

	// J

	  if($data['CustomerSatisfaction']['j'] == 1) {

		  $j1 = 4;

		} elseif($data['CustomerSatisfaction']['j'] == 2){

		  $j2 = 4;

		} elseif($data['CustomerSatisfaction']['j'] == 3){

		  $j3 = 4;

		} elseif($data['CustomerSatisfaction']['j'] == 4){

		  $j4 = 4;

		} 

	// K 

	  if($data['CustomerSatisfaction']['k'] == 1) {

		  $k1 = 4;

		} elseif($data['CustomerSatisfaction']['k'] == 2){

		  $k2 = 4;

		} elseif($data['CustomerSatisfaction']['k'] == 3){

		  $k3 = 4;

		} elseif($data['CustomerSatisfaction']['k'] == 4){

		  $k4 = 4;

		} elseif($data['CustomerSatisfaction']['k'] == 5){

		  $k5 = 4;

		} 

	// L

	  if($data['CustomerSatisfaction']['l'] == 1) {

		  $l1 = 4;

		} elseif($data['CustomerSatisfaction']['l'] == 2){

		  $l2 = 4;

		} elseif($data['CustomerSatisfaction']['l'] == 3){

		  $l3 = 4;

		} elseif($data['CustomerSatisfaction']['l'] == 4){

		  $l4 = 4;

		} 

	//----------------------------------------- CC1

	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'CC1 : ',0,0,'L');
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(80,5,'Which of the following best describes your awareness of a CC? ',0,0,'C');
	$pdf->ln(7);


	$pdf->Cell(30, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $j1, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '1. I know what a CC is and I saw the offices CC. ', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->ln(7);

	$pdf->Cell(30, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $j2, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '2. I know what a CC is but I did NOT see this offices CC.  ', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->ln(7);

	$pdf->Cell(30, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $j3, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '3. I learned of the CC only when I saw this offices CC.  ', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->ln(7);

	$pdf->Cell(30, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $j4, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '4. I do not know what a CC is and I did not see one in this office. (Answer : N/A on CC2 and CC3) ', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->ln(8);

	//- -----------------------------------------------CC2

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'CC2 : ',0,0,'L');
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(120,5,'If aware of CC (answered 1-3 in CC1), would you say that the CC of this office was...? ',0,0,'C');
	$pdf->ln(7);

	$pdf->Cell(15, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $k1, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '1. Easy to see.  ', 0, 0, 'L');
	
	$pdf->Cell(-1, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $k2, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '2. Somewhat easy to see.  ', 0, 0, 'L');
	$pdf->Cell(10, 5, '', 0, 0, 'L');

	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $k3, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '3. Difficult to see.   ', 0, 0, 'L');
	$pdf->Cell(-1, 5, '', 0, 0, 'L');

	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $k4, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '4. Not visible at all.  ', 0, 0, 'L');
	$pdf->Cell(1, 5, '', 0, 0, 'L');

	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $k5, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, ' 5. N/A ', 0, 0, 'L');
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->ln(8);

	// ---------------------------------------------------------------------- CC3

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'CC3 : ',0,0,'L');
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(125,5,'If aware of CC (answered 1-3 in CC1), how much did the CC help you in your transaction? ',0,0,'C');
	$pdf->ln(7);

	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(7, 6, $l1, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '1. Helped very much.  ', 0, 0, 'L');
	$pdf->Cell(10, 5, '', 0, 0, 'L');

	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $l2, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '2. Somewhat helped.  ', 0, 0, 'L');
	$pdf->Cell(10, 5, '', 0, 0, 'L');
	
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $l3, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '3. Did not help.  ', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
 
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $l4, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, '4. N/A  ', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->ln(8);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->MultiCell(185,4,'INSTRUCTIONS: Check mark your answer to the Citizen\'s Charter (CC) questions. The Citizen\'s Charter is an Official document that reflects the services of a government agency/office including its requirements, fees, and its processing times among others.',0, 'L');
	$pdf->Cell(10,0,'',0,0,'C');
	$pdf->Ln(2);

	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(90.5,20,'',1,0,'L');
	$pdf->Image($this->base .'/assets/img/sad.png',102.5,162,11.5,11.5);
	$pdf->Cell(20,20,'',1,0,'C');
	$pdf->Cell(-20,35,'Strongly Disagree',0,0,'C');

	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->Image($this->base .'/assets/img/sad.png',120.5,162,11.5,11.5);
	$pdf->Cell(15,20,'',1,0,'C');
	$pdf->Cell(-15,35,'Disagree',0,0,'C');

	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Image($this->base .'/assets/img/poker_face.png',136.5,162,11.5,11.5);
	$pdf->Cell(17,20,'',1,0,'C');
	$pdf->Cell(-16,32,'Neither Agree ',0,0,'C');
	$pdf->Ln(2.5);
	$pdf->Cell(280,32,'nor Disagree',0,0,'C');
	$pdf->Ln(-2.5);

	$pdf->Cell(147.5,5,'',0,0,'L');
	$pdf->Image($this->base .'/assets/img/smiley.png',154,162,11.5,11.5);
	$pdf->Cell(17,20,'',1,0,'C');
	$pdf->Cell(-16,35,' Agree ',0,0,'C');
	$pdf->Ln(0);

	$pdf->Cell(164.5,5,'',0,0,'L');
	$pdf->Image($this->base .'/assets/img/smiley.png',170.5,162,11.5,11.5);
	$pdf->Cell(17,20,'',1,0,'C');
	$pdf->Cell(-16,35,'Strongly Agree ',0,0,'C');
	$pdf->Ln(0);

	$pdf->Cell(181.5,5,'',0,0,'L');
	$pdf->Image($this->base .'/assets/img/n_a.png',187,162,11,11);
	$pdf->Cell(17,20,'',1,0,'C');
	$pdf->Cell(-16,32,'N/A ',0,0,'C'); 

	$pdf->Ln(20);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD0.  I am satisfied with the service that I availed. ',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,5,$a1,1,0,'C');
	$pdf->Cell(15,5,$a2,1,0,'C');
	$pdf->Cell(17,5,$a3,1,0,'C');
	$pdf->Cell(17,5,$a4,1,0,'C');
	$pdf->Cell(17,5,$a5,1,0,'C');
	$pdf->Cell(17,5,$a6,1,0,'C');

	$pdf->Ln(5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD1.  I spent a reasonable amount of time for my transaction. ',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,5,$b1,1,0,'C');
	$pdf->Cell(15,5,$b2,1,0,'C');
	$pdf->Cell(17,5,$b3,1,0,'C');
	$pdf->Cell(17,5,$b4,1,0,'C');
	$pdf->Cell(17,5,$b5,1,0,'C');
	$pdf->Cell(17,5,$b6,1,0,'C');

	$pdf->Ln(5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD2. The office followed the transactions requirements and steps based on the information provided.  ',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,10,$c1,1,0,'C');
	$pdf->Cell(15,10,$c2,1,0,'C');
	$pdf->Cell(17,10,$c3,1,0,'C');
	$pdf->Cell(17,10,$c4,1,0,'C');
	$pdf->Cell(17,10,$c5,1,0,'C');
	$pdf->Cell(17,10,$c6,1,0,'C');

	$pdf->Ln(10);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD3. The steps (including payment) I needed to do for my transaction were easy and simple.  ',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,10,$d1,1,0,'C');
	$pdf->Cell(15,10,$d2,1,0,'C');
	$pdf->Cell(17,10,$d3,1,0,'C');
	$pdf->Cell(17,10,$d4,1,0,'C');
	$pdf->Cell(17,10,$d5,1,0,'C');
	$pdf->Cell(17,10,$d6,1,0,'C');

	$pdf->Ln(10);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD4. I easily found information about my transaction from the office or its website.  ',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,10,$e1,1,0,'C');
	$pdf->Cell(15,10,$e2,1,0,'C');
	$pdf->Cell(17,10,$e3,1,0,'C');
	$pdf->Cell(17,10,$e4,1,0,'C');
	$pdf->Cell(17,10,$e5,1,0,'C');
	$pdf->Cell(17,10,$e6,1,0,'C');

	$pdf->Ln(10);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD5. I paid a reasonable amount of feesfor my transaction.   ',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,5,$f1,1,0,'C');
	$pdf->Cell(15,5,$f2,1,0,'C');
	$pdf->Cell(17,5,$f3,1,0,'C');
	$pdf->Cell(17,5,$f4,1,0,'C');
	$pdf->Cell(17,5,$f5,1,0,'C');
	$pdf->Cell(17,5,$f6,1,0,'C');

	$pdf->Ln(5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD6. I feel the office was fair to everyone, or "walang palakasan", during my transaction.',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,10,$g1,1,0,'C');
	$pdf->Cell(15,10,$g2,1,0,'C');
	$pdf->Cell(17,10,$g3,1,0,'C');
	$pdf->Cell(17,10,$g4,1,0,'C');
	$pdf->Cell(17,10,$g5,1,0,'C');
	$pdf->Cell(17,10,$g6,1,0,'C');

	$pdf->Ln(10);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD7. I was treated courteously by teh staff, and (if asked for help) the staff was helpful.',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,10,$h1,1,0,'C');
	$pdf->Cell(15,10,$h2,1,0,'C');
	$pdf->Cell(17,10,$h3,1,0,'C');
	$pdf->Cell(17,10,$h4,1,0,'C');
	$pdf->Cell(17,10,$h5,1,0,'C');
	$pdf->Cell(17,10,$h6,1,0,'C');

	$pdf->Ln(10);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$y = $pdf->GetY();
	$pdf->MultiCell(90.5,5,'SQD8. I got what I needed from the government office, or (if denied) denial of request was sufficiently explained to me.  ',1,1);
	$pdf->SetXY(98.5, $y);
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(20,10,$i1,1,0,'C');
	$pdf->Cell(15,10,$i2,1,0,'C');
	$pdf->Cell(17,10,$i3,1,0,'C');
	$pdf->Cell(17,10,$i4,1,0,'C');
	$pdf->Cell(17,10,$i5,1,0,'C');
	$pdf->Cell(17,10,$i6,1,0,'C');
	$pdf->ln(12);

	$pdf->Cell(3.5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	$x = $pdf->GetX();
	$pdf->Cell(90.5,5,'Suggestion on how can we further improve our service (Optional) :',0,0);
	$pdf->SetXY(10,262);
	$pdf->MultiCell(90,4,'        '.$data['CustomerSatisfaction']['suggestion'],0,1);
	$pdf->Line(8,$pdf->getY()-4,200,$pdf->getY()-4);
	$pdf->Line(8,$pdf->getY()+1,200,$pdf->getY()+1);
	$pdf->ln(5);

	$pdf->Cell(3.5,5,'',0,0,'L');
	$pdf->SetFont("Arial", '', 8);
	// $y = $pdf->GetY();
	$pdf->Cell(90.5,5,'Email/Facebook :',0,0);
	$pdf->Cell(-65,5,'',0,0,'L');
	$pdf->Cell(10,5,$data['CustomerSatisfaction']['email'],0,0,'L');
	$pdf->Line(31,$pdf->getY()+4,75,$pdf->getY()+4);

	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(190,5,'THANK YOU',0,0,'C');

	$pdf->output();
	exit();

  }

  public function customer_satisfaction() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['rate'] = '';

	if (isset($this->request->query['rate'])) {

	  $rate = $this->request->query['rate'];

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}

	$tmpData = $this->CustomerSatisfaction->query($this->CustomerSatisfaction->getAllCustomerSatisfaction($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'CUSTOMER SATISFACTION MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(35,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(80,5,'CLIENT TYPE',1,0,'C',1);
	$pdf->Cell(60,5,'REGION OF RESIDENCE',1,0,'C',1);
	$pdf->Cell(45,5,'SERVICE AVAILED',1,0,'C',1);
	$pdf->Cell(65,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(35,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,35,80,60,45,65,35));
	$pdf->SetAligns(array('C','L','C','L','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['CustomerSatisfaction']['code'],

		  $data['CustomerSatisfaction']['client_type'],

		  $data['CustomerSatisfaction']['region_of_residence'],

		  $data['CustomerSatisfaction']['service_availed'],

		  $data['CustomerSatisfaction']['email'],

		  fdate($data['CustomerSatisfaction']['date'],'m/d/Y'),


		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();

  }

  public function participantEvaluationActivityForm($id = null) {

	$office_reference = $this->Global->OfficeReference('Participant Evaluation Activity');

	$data['ParticipantEvaluationActivity'] = $this->ParticipantEvaluationActivities->find()

	  ->contain([

		'CollegePrograms'

		])

	  ->where([

		'ParticipantEvaluationActivities.visible' => 1,

		'ParticipantEvaluationActivities.id' => $id

	  ])

	  ->first();

	  $data = [

		'ParticipantEvaluationActivity' => $data['ParticipantEvaluationActivity'],

		'CollegeProgram'  => $data['ParticipantEvaluationActivity']->CollegeProgram,

	  ];

	  unset($data['ParticipantEvaluationActivity']->CollegeProgram);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(55,10,55);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 6.5);
	// $pdf->Image($this->base .'/assets/img/gco_evaluation.png',0,0,215.9,355.6);
	$pdf->Image($this->base.'/assets/img/zam.png',59.5,10.5,15,15);
	$pdf->Image($this->base.'/assets/img/iso.png',149.5,10.5,10,14);
  
	$pdf->Ln(3);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(60,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 6);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(60,5,'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Times", '', 6.5);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(60,5,'Fort Pilar, Zamboanga City 7000',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(60,5,'GUIDANCE AND COUNSELING OFFICE',0,0,'C');

 
	$pdf->Ln(5.5);
	$pdf->Rect(60,$pdf->GetY(),25,14.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(27,6,'ZSCMST - '. @$office_reference['OfficeReference']['reference_code'],0,'L');
	$pdf->Ln(-3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(21,5,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Ln(2.5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Status: ' . @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Cell(76.5,5,'',0,0,'L');
	$pdf->Ln(2.5);
	$pdf->Cell(5,5,'',0,0,'L');
	$pdf->Cell(25,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(-5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(0,12,'PARTICIPANT EVALUATION ',0,0,'C');
	$pdf->Cell(16.5,5,'',0,0,'L');

	
	
	$pdf->Ln(3.5);
	$pdf->Cell(0,12,'OF ACTIVITY',0,0,'C');


	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'Activity : ',0,0,'L');
	$pdf->Cell(90,5,$data['ParticipantEvaluationActivity']['activity'],0,0,'L');
	$pdf->Line(78,$pdf->getY()+4,138,$pdf->getY()+4);


	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'Date : ',0,0,'L');
	$pdf->Cell(90,5,date('m/d/Y',strtotime($data['ParticipantEvaluationActivity']['date'])),0,0,'L');
	$pdf->Line(78,$pdf->getY()+4,138,$pdf->getY()+4);


	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(12.5,5,'Venue : ',0,0,'L');
	$pdf->Cell(90,5,$data['ParticipantEvaluationActivity']['venue'],0,0,'L');
	$pdf->Line(78,$pdf->getY()+4,138,$pdf->getY()+4);


	$pdf->Ln(4);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(6.5,5,'',0,0,'C');
	$pdf->Cell(80,5,'Instruction: Please indicate your response to the items below with ',0,0,'L');

	$pdf->Ln(3);
	$pdf->SetFont("Arial", '', 7);
	$pdf->Cell(6.5,5,'',0,0,'C');
	$pdf->Cell(80,5,'a check mark under the corresponding column.',0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'B', 7);
	$pdf->Cell(6.5,5,'',0,0,'C');
	$pdf->Cell(80,5,'Rate the activity on a 5 to 1 scale, where:',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 6.5);
	$pdf->Cell(6.5,5,'',0,0,'C');
	$pdf->Cell(55.5,5,'1 - Strongly Disagree',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->Cell(59.5,5,'2 - Disagree',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 6.5);
	$pdf->Cell(6.5,5,'',0,0,'C');
	$pdf->Cell(65.5,5,'3 - Neither Agree nor Disagree',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->Cell(56.5,5,'4 - Agree',0,0,'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 6.5);
	$pdf->Cell(6.5,5,'',0,0,'C');
	$pdf->Cell(52.5,5,'5 - Strongly Agree',0,0,'C');

	$a1 = '';
	$b1 = '';
	$c1 = '';
	$d1 = '';
	$e1 = '';
	$f1 = '';
	$g1 = '';
	$h1 = '';
	$i1 = '';
	$j1 = '';
	$k1 = '';
	$l1 = '';
	$m1 = '';
	$n1 = '';
	$o1 = '';
	$p1 = '';
	$q1 = '';
	$r1 = '';
	$s1 = '';
	$t1 = '';

	$a2 = '';
	$b2 = '';
	$c2 = '';
	$d2 = '';
	$e2 = '';
	$f2 = '';
	$g2 = '';
	$h2 = '';
	$i2 = '';
	$j2 = '';
	$k2 = '';
	$l2 = '';
	$m2 = '';
	$n2 = '';
	$o2 = '';
	$p2 = '';
	$q2 = '';
	$r2 = '';
	$s2 = '';
	$t2 = '';

	$a3 = '';
	$b3 = '';
	$c3 = '';
	$d3 = '';
	$e3 = '';
	$f3 = '';
	$g3 = '';
	$h3 = '';
	$i3 = '';
	$j3 = '';
	$k3 = '';
	$l3 = '';
	$m3 = '';
	$n3 = '';
	$o3 = '';
	$p3 = '';
	$q3 = '';
	$r3 = '';
	$s3 = '';
	$t3 = '';

	$a4 = '';
	$b4 = '';
	$c4 = '';
	$d4 = '';
	$e4 = '';
	$f4 = '';
	$g4 = '';
	$h4 = '';
	$i4 = '';
	$j4 = '';
	$k4 = '';
	$l4 = '';
	$m4 = '';
	$n4 = '';
	$o4 = '';
	$p4 = '';
	$q4 = '';
	$r4 = '';
	$s4 = '';
	$t4 = '';

	$a5 = '';
	$b5 = '';
	$c5 = '';
	$d5 = '';
	$e5 = '';
	$f5 = '';
	$g5 = '';
	$h5 = '';
	$i5 = '';
	$j5 = '';
	$k5 = '';
	$l5 = '';
	$m5 = '';
	$n5 = '';
	$o5 = '';
	$p5 = '';
	$q5 = '';
	$r5 = '';
	$s5 = '';
	$t5 = '';

	// A

	  if($data['ParticipantEvaluationActivity']['a'] == 1) {

		$a1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['a'] == 2){

		$a2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['a'] == 3){

		$a3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['a'] == 4){

		$a4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['a'] == 5){

		$a5 = 4;

	  }

	// B

	  if($data['ParticipantEvaluationActivity']['b'] == 1) {

		$b1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['b'] == 2){

		$b2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['b'] == 3){

		$b3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['b'] == 4){

		$b4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['b'] == 5){

		$b5 = 4;

	  }

	// C

	  if($data['ParticipantEvaluationActivity']['c'] == 1) {

		$c1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['c'] == 2){

		$c2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['c'] == 3){

		$c3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['c'] == 4){

		$c4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['c'] == 5){

		$c5 = 4;

	  }

	// D

	  if($data['ParticipantEvaluationActivity']['d'] == 1) {

		$d1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['d'] == 2){

		$d2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['d'] == 3){

		$d3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['d'] == 4){

		$d4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['d'] == 5){

		$d5 = 4;

	  }

	// E 

	  if($data['ParticipantEvaluationActivity']['e'] == 1) {

		$e1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['e'] == 2){

		$e2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['e'] == 3){

		$e3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['e'] == 4){

		$e4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['e'] == 5){

		$e5 = 4;

	  }

	// F

	  if($data['ParticipantEvaluationActivity']['f'] == 1) {

		$f1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['f'] == 2){

		$f2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['f'] == 3){

		$f3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['f'] == 4){

		$f4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['f'] == 5){

		$f5 = 4;

	  }

	// G

	  if($data['ParticipantEvaluationActivity']['g'] == 1) {

		$g1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['g'] == 2){

		$g2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['g'] == 3){

		$g3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['g'] == 4){

		$g4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['g'] == 5){

		$g5 = 4;

	  }

	// H

	  if($data['ParticipantEvaluationActivity']['h'] == 1) {

		$h1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['h'] == 2){

		$h2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['h'] == 3){

		$h3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['h'] == 4){

		$h4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['h'] == 5){

		$h5 = 4;

	  }

	// I

	  if($data['ParticipantEvaluationActivity']['i'] == 1) {

		$i1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['i'] == 2){

		$i2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['i'] == 3){

		$i3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['i'] == 4){

		$i4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['i'] == 5){

		$i5 = 4;

	  }

	// J 

	  if($data['ParticipantEvaluationActivity']['j'] == 1) {

		$j1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['j'] == 2){

		$j2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['j'] == 3){

		$j3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['j'] == 4){

		$j4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['j'] == 5){

		$j5 = 4;

	  }

	// K

	  if($data['ParticipantEvaluationActivity']['k'] == 1) {

		$k1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['k'] == 2){

		$k2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['k'] == 3){

		$k3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['k'] == 4){

		$k4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['k'] == 5){

		$k5 = 4;

	  }

	// L

	  if($data['ParticipantEvaluationActivity']['l'] == 1) {

		$l1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['l'] == 2){

		$l2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['l'] == 3){

		$l3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['l'] == 4){

		$l4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['l'] == 5){

		$l5 = 4;

	  }

	// M

	  if($data['ParticipantEvaluationActivity']['m'] == 1) {

		$m1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['m'] == 2){

		$m2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['m'] == 3){

		$m3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['m'] == 4){

		$m4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['m'] == 5){

		$m5 = 4;

	  }

	// N

	  if($data['ParticipantEvaluationActivity']['n'] == 1) {

		$n1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['n'] == 2){

		$n2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['n'] == 3){

		$n3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['n'] == 4){

		$n4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['n'] == 5){

		$n5 = 4;

	  }

	// O

	  if($data['ParticipantEvaluationActivity']['o'] == 1) {

		$o1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['o'] == 2){

		$o2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['o'] == 3){

		$o3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['o'] == 4){

		$o4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['o'] == 5){

		$o5 = 4;

	  }

	// P

	  if($data['ParticipantEvaluationActivity']['p'] == 1) {

		$p1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['p'] == 2){

		$p2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['p'] == 3){

		$p3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['p'] == 4){

		$p4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['p'] == 5){

		$p5 = 4;

	  }

	// Q

	  if($data['ParticipantEvaluationActivity']['q'] == 1) {

		$q1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['q'] == 2){

		$q2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['q'] == 3){

		$q3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['q'] == 4){

		$q4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['q'] == 5){

		$q5 = 4;

	  }

	// R

	  if($data['ParticipantEvaluationActivity']['r'] == 1) {

		$r1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['r'] == 2){

		$r2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['r'] == 3){

		$r3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['r'] == 4){

		$r4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['r'] == 5){

		$r5 = 4;

	  }

	// S

	  if($data['ParticipantEvaluationActivity']['s'] == 1) {

		$s1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['s'] == 2){

		$s2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['s'] == 3){

		$s3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['s'] == 4){

		$s4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['s'] == 5){

		$s5 = 4;

	  }

	// T

	  if($data['ParticipantEvaluationActivity']['t'] == 1) {

		$t1 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['t'] == 2){

		$t2 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['t'] == 3){

		$t3 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['t'] == 4){

		$t4 = 4;

	  } elseif($data['ParticipantEvaluationActivity']['t'] == 5){

		$t5 = 4;

	  }

	//EVALUATION TABLE

	  $pdf->Ln(4);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", 'B', 9);
	  $pdf->Cell(66.5,5,'ACTIVITY CONTENT',1,0,'L');
	  $pdf->Cell(5,5,'5',1,0,'C');
	  $pdf->Cell(5,5,'4',1,0,'C');
	  $pdf->Cell(5,5,'3',1,0,'C');
	  $pdf->Cell(5,5,'2',1,0,'C');
	  $pdf->Cell(5,5,'1',1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,4.5,'1. I was well informed about the objectives of this activity.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,9,$a5,1,0,'C');
	  $pdf->Cell(5,9,$a4,1,0,'C');
	  $pdf->Cell(5,9,$a3,1,0,'C');
	  $pdf->Cell(5,9,$a2,1,0,'C');
	  $pdf->Cell(5,9,$a1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');


	  $pdf->Ln(9);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,4.5,'2. This activity lived up to my expectations',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,4.5,$b5,1,0,'C');
	  $pdf->Cell(5,4.5,$b4,1,0,'C');
	  $pdf->Cell(5,4.5,$b3,1,0,'C');
	  $pdf->Cell(5,4.5,$b2,1,0,'C');
	  $pdf->Cell(5,4.5,$b1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(4.5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'3. The content is relevant to my life.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$c5,1,0,'C');
	  $pdf->Cell(5,5,$c4,1,0,'C');
	  $pdf->Cell(5,5,$c3,1,0,'C');
	  $pdf->Cell(5,5,$c2,1,0,'C');
	  $pdf->Cell(5,5,$c1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'4. The materials provided are relevant to my life.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$d5,1,0,'C');
	  $pdf->Cell(5,10,$d4,1,0,'C');
	  $pdf->Cell(5,10,$d3,1,0,'C');
	  $pdf->Cell(5,10,$d2,1,0,'C');
	  $pdf->Cell(5,10,$d1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", 'B', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'ACTIVITY DESIGN',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(10,5,'',0,0,'L');
	  
	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'1. The activities conducted have stimulated my learning.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$e5,1,0,'C');
	  $pdf->Cell(5,10,$e4,1,0,'C');
	  $pdf->Cell(5,10,$e3,1,0,'C');
	  $pdf->Cell(5,10,$e2,1,0,'C');
	  $pdf->Cell(5,10,$e1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'2. The activities conducted gave me sufficient practice and feedback.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$f5,1,0,'C');
	  $pdf->Cell(5,10,$f4,1,0,'C');
	  $pdf->Cell(5,10,$f3,1,0,'C');
	  $pdf->Cell(5,10,$f2,1,0,'C');
	  $pdf->Cell(5,10,$f1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'3. The activities are of practical use to my life as a student.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$g5,1,0,'C');
	  $pdf->Cell(5,10,$g4,1,0,'C');
	  $pdf->Cell(5,10,$g3,1,0,'C');
	  $pdf->Cell(5,10,$g2,1,0,'C');
	  $pdf->Cell(5,10,$g1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'4. The difficulty level of this activity is appropriate.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$h5,1,0,'C');
	  $pdf->Cell(5,10,$h4,1,0,'C');
	  $pdf->Cell(5,10,$h3,1,0,'C');
	  $pdf->Cell(5,10,$h2,1,0,'C');
	  $pdf->Cell(5,10,$h1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'5. The pace of this workshop was appropriate.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$i5,1,0,'C');
	  $pdf->Cell(5,10,$i4,1,0,'C');
	  $pdf->Cell(5,10,$i3,1,0,'C');
	  $pdf->Cell(5,10,$i2,1,0,'C');
	  $pdf->Cell(5,10,$i1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", 'B', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'ACTIVITY SPEAKER',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(5,5,'',1,0,'C',true);
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'1. The speaker showed that he/she was well prepared.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$j5,1,0,'C');
	  $pdf->Cell(5,10,$j4,1,0,'C');
	  $pdf->Cell(5,10,$j3,1,0,'C');
	  $pdf->Cell(5,10,$j2,1,0,'C');
	  $pdf->Cell(5,10,$j1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'2. The speaker showed a mastery of the topic.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$k5,1,0,'C');
	  $pdf->Cell(5,10,$k4,1,0,'C');
	  $pdf->Cell(5,10,$k3,1,0,'C');
	  $pdf->Cell(5,10,$k2,1,0,'C');
	  $pdf->Cell(5,10,$k1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'3. The speaker was able to establish rapport with the participants.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$l5,1,0,'C');
	  $pdf->Cell(5,10,$l4,1,0,'C');
	  $pdf->Cell(5,10,$l3,1,0,'C');
	  $pdf->Cell(5,10,$l2,1,0,'C');
	  $pdf->Cell(5,10,$l1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'4. The speaker presented the topic in a clear and understandable manner.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$m5,1,0,'C');
	  $pdf->Cell(5,10,$m4,1,0,'C');
	  $pdf->Cell(5,10,$m3,1,0,'C');
	  $pdf->Cell(5,10,$m2,1,0,'C');
	  $pdf->Cell(5,10,$m1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'5. The speaker made the topic interesting.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$n5,1,0,'C');
	  $pdf->Cell(5,5,$n4,1,0,'C');
	  $pdf->Cell(5,5,$n3,1,0,'C');
	  $pdf->Cell(5,5,$n2,1,0,'C');
	  $pdf->Cell(5,5,$n1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'6. The speaker answered questions adequately.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$o5,1,0,'C');
	  $pdf->Cell(5,10,$o4,1,0,'C');
	  $pdf->Cell(5,10,$o3,1,0,'C');
	  $pdf->Cell(5,10,$o2,1,0,'C');
	  $pdf->Cell(5,10,$o1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", 'B', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'THE FACILITIES',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,'',1,0,'C', true);
	  $pdf->Cell(5,5,'',1,0,'C', true);
	  $pdf->Cell(5,5,'',1,0,'C', true);
	  $pdf->Cell(5,5,'',1,0,'C', true);
	  $pdf->Cell(5,5,'',1,0,'C', true);
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'1. The venue was conductive to the facilitation of the activities given.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,10,$p5,1,0,'C');
	  $pdf->Cell(5,10,$p4,1,0,'C');
	  $pdf->Cell(5,10,$p3,1,0,'C');
	  $pdf->Cell(5,10,$p2,1,0,'C');
	  $pdf->Cell(5,10,$p1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(10);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'2. The sound system was adequate.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$q5,1,0,'C');
	  $pdf->Cell(5,5,$q4,1,0,'C');
	  $pdf->Cell(5,5,$q3,1,0,'C');
	  $pdf->Cell(5,5,$q2,1,0,'C');
	  $pdf->Cell(5,5,$q1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'3. The video system was adequate.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$r5,1,0,'C');
	  $pdf->Cell(5,5,$r4,1,0,'C');
	  $pdf->Cell(5,5,$r3,1,0,'C');
	  $pdf->Cell(5,5,$r2,1,0,'C');
	  $pdf->Cell(5,5,$r1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'4. The lighting was adequate.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$s5,1,0,'C');
	  $pdf->Cell(5,5,$s4,1,0,'C');
	  $pdf->Cell(5,5,$s3,1,0,'C');
	  $pdf->Cell(5,5,$s2,1,0,'C');
	  $pdf->Cell(5,5,$s1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Cell(6,5,'',0,0,'L');
	  $pdf->SetFont("Arial", '', 9);
	  $y = $pdf->GetY();
	  $pdf->MultiCell(66.5,5,'5. The ventilation was adequate.',1,1);
	  $pdf->SetXY(127.5, $y);
	  $pdf->SetFont('ZapfDingbats','', 10);
	  $pdf->Cell(5,5,$t5,1,0,'C');
	  $pdf->Cell(5,5,$t4,1,0,'C');
	  $pdf->Cell(5,5,$t3,1,0,'C');
	  $pdf->Cell(5,5,$t2,1,0,'C');
	  $pdf->Cell(5,5,$t1,1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'L');

	  $pdf->Ln(5);
	  $pdf->Line(67.5,$pdf->getY()+12.5,145,$pdf->getY()+12.5);
	  $pdf->Line(67.5,$pdf->getY()+16.5,145,$pdf->getY()+16.5);
	  $pdf->Line(67.5,$pdf->getY()+20.5,145,$pdf->getY()+20.5);
  
	  $pdf->SetFont("Arial", '', 8);
	  $pdf->Cell(6.5,5,'',0,0,'L');
	  $pdf->Cell(1,5,'Please answer the following questions:',0,0,'L');
	  $y = $pdf->GetY();
	  $pdf->Ln(5);
	  $pdf->SetFont("Arial", '', 8);
	  $pdf->Cell(6.5,5,'',0,0,'L');
	  $pdf->Cell(15,5,'1. What were some of the things you learned in this activity?',0,0,'L');
	  $pdf->ln(4);
	  $pdf->SetFont("Arial", '', 6);
	  $pdf->Cell(10,5,'',0,0);
	  $pdf->MultiCell(85,4,'     '.$data['ParticipantEvaluationActivity']['question_1'],0,1);

	  $pdf->ln(10);
	  $pdf->Line(67.5,$pdf->getY()+14,145,$pdf->getY()+14);
	  $pdf->Line(67.5,$pdf->getY()+17.5,145,$pdf->getY()+17.5);
	  $pdf->Line(67.5,$pdf->getY()+21.5,145,$pdf->getY()+21.5);
	  $pdf->SetFont("Arial", '', 8);
	  $pdf->Cell(7,1,'',0,0,'L');
	  $pdf->MultiCell(90,5,'2. What recommendations can you make for the improvement of this activity?',0,1);
	  $pdf->Cell(22,-5,' ',0,0,'L');
	  $pdf->SetFont("Arial", '', 6);
	  $pdf->Cell(-12,40,'',0,0,'L');
	  $y = $pdf->GetY();
	  $pdf->MultiCell(85,4,'      '.$data['ParticipantEvaluationActivity']['question_2'],0,1);

	  $pdf->Ln(15);
	  $pdf->Line(90.5,$pdf->getY()+5,125,$pdf->getY()+5);
	  $pdf->Ln(7);
	  $pdf->Cell(42,5,'',0,0,'L');
	  $pdf->Cell(3.5,3,'Participant Signature',0,0,'L');


	  $pdf->Ln(10);
	  $pdf->Line(90.5,$pdf->getY()+5,125,$pdf->getY()+5);
	  $pdf->Cell(10,5,'',0,0,'L');
	  $pdf->MultiCell(85,5,''.$data['ParticipantEvaluationActivity']['year'],0,'C');
	  $pdf->Ln(4);
	  $pdf->Cell(45,5,'',0,0,'L');
	  $pdf->Cell(3.5,-1,'Course and Year',0,0,'L');
	  

	$pdf->output();
	exit();

  }

  public function participantEvaluationActivity() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['rate'] = '';

	if ($this->request->getQuery('rate')) {

	  $rate = $this->request->getQuery('rate');

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}

	$tmpData = $this->ParticipantEvaluationActivities->getAllParticipantEvaluationActivityPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',85,10,25,25);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PARTICIPANT EVALUATION ACTIVITY',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(5,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'ACTIVITY',1,0,'C',1);
	$pdf->Cell(50,5,'VENUE',1,0,'C',1);
	$pdf->Cell(150,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(40,5,'DATE',1,0,'C',1);
	$pdf->Cell(40,5,'YEAR',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(5,50,50,150,40,40));
	$pdf->SetAligns(array('C','L','C','L','C','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['activity'],

		  $data['venue'],

		  $data['program_name'],

		  fdate($data['date'],'m/d/Y'),

		  $data['year'],

		  


		));

	  }

	}else{

	  $pdf->Cell(335,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+150,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+185,$pdf->getY()+2,$pdf->getX()+335,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function studentExit() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['rate'] = '';

	if (isset($this->request->query['rate'])) {

	  $rate = $this->request->query['rate'];

	  if($rate == 0){

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NULL";

	  }else{

		$conditions['rate'] = "AND StudentApplication.rate_by_id IS NOT NULL";

	  }

	}

	$tmpData = $this->StudentExits->getAllStudentExitPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT EXIT MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(80,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(90,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(70,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(45,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Cell(35,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,80,90,70,45,35));
	$pdf->SetAligns(array('C','L','C','L','C','C'));

	if(count($tmpData) > 0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['student_name'],

		  $data['name'],

		  $data['email'],

		  $data['contact_no'],

		  date('m/d/Y',strtotime($data['date'])),


		));

	  }

	}else{

	  $pdf->Cell(335,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+152,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+185,$pdf->getY()+2,$pdf->getX()+335,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function studentExitForm($id = null) {

	$office_reference = $this->Global->OfficeReference('Student Exit Management');

	$data['StudentExit'] = $this->StudentExits->find()

	  ->contain([

		'CollegePrograms'

		])

	  ->where([

		'StudentExits.visible' => 1,

		'StudentExits.id' => $id

	  ])

	  ->first();

	  $data = [

		'StudentExit' => $data['StudentExit'],

		'CollegeProgram'  => $data['StudentExit']->CollegeProgram,

	  ];

	  unset($data['StudentExit']->CollegeProgram);

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(3,4,3);
	$pdf->AddPage("P", "A4", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 11.5);
	// $pdf->Image($this->base .'/assets/img/promissory_note.png',0,0,210,297);
	$pdf->Image($this->base.'/assets/img/zam.png',12,4,22,22);
	$pdf->Image($this->base.'/assets/img/iso.png',190,5,15,20);
	$pdf->Ln(3.5);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(4.5);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,6,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 8);
	$pdf->Cell(0,5,'Tel No: (062) 991-0647; Telefax: (062) 991-0777 |  http://www.zscmst.edu.ph   email: zscmstguidance@zscmst.edu.ph',0,0,'C');
	$pdf->Ln(5);
	$pdf->SetLineWidth(0.4);
	$pdf->Line(12.5,$pdf->getY()+1,205,$pdf->getY()+1);
	$pdf->SetLineWidth(0.7);
	$pdf->Line(12.5,$pdf->getY()+2,205,$pdf->getY()+2);
	$pdf->SetLineWidth(0.2);
	$pdf->Rect(12,$pdf->GetY() + 3.5,31,13);
	$pdf->Ln(4);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,4,'ZSCMST - ' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(45,5,'GUIDANCE   AND   COUNSELING   OFFICE',0,0,'C');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(68,3,'Adopted Date: ' . @$office_reference['OfficeReference']['adopted'],0,0,'L');
	$pdf->SetFont("Times", 'B', 12.5);
	$pdf->Cell(45,20,'STUDENT EXIT QUESTIONNAIRE',0,0,'C');
	$pdf->Ln(2);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(8.5,5,'',0,0,'L');
	$pdf->Cell(65,5,'Revision Date: ' . @$office_reference['OfficeReference']['revision_date'],0,0,'L');
	$pdf->Ln(10);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'Name : ',0,0,'L');
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(90,5,$data['StudentExit']['student_name'],0,0,'L');
	$pdf->Line(33,$pdf->getY()+4,100,$pdf->getY()+4);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(-5,5,'',0,0,'L');
	$pdf->Cell(5.5,5,'Date : ',0,0,'L');
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(90,5,date('m/d/Y',strtotime($data['StudentExit']['date'])),0,0,'L');
	$pdf->Line(33,$pdf->getY()+4,100,$pdf->getY()+4);
	$pdf->Line(130,$pdf->getY()+4,170,$pdf->getY()+4);
	$pdf->ln(7);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'Course : ',0,0,'L');
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(90,5,$data['CollegeProgram']['name'],0,0,'L');
	$pdf->Line(33,$pdf->getY()+4,150,$pdf->getY()+4);
	$pdf->Ln(10);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'Answer the following questions briefly: ',0,0,'L');
	$pdf->Ln(5);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'What were the best parts of your learning experience in ZSCMST? Why?  ',0,0,'L');
	$pdf->ln(5);
	$pdf->SetXY(10,73);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(8,5,'',0,0,'L');
	$pdf->MultiCell(160,5,$data['StudentExit']['question_1'],0,1);
	$pdf->Line(14,$pdf->getY()-5,180,$pdf->getY()-5);
	$pdf->Line(14,$pdf->getY()+1,180,$pdf->getY()+1);
	$pdf->Ln(5);
	
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'What were the worst parts of your learning experience in ZSCMST? Why?   ',0,0,'L');
	$pdf->ln(5);
	$pdf->SetXY(10,93);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(8,5,'',0,0,'L');
	$pdf->MultiCell(160,5,$data['StudentExit']['question_2'],0,1);
	$pdf->Line(14,$pdf->getY()-5,180,$pdf->getY()-5);
	$pdf->Line(14,$pdf->getY()+1,180,$pdf->getY()+1);
	$pdf->Ln(5);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'Of all the subjects you took, which were your favorite and why?  ',0,0,'L');
	$pdf->ln(5);
	$pdf->SetXY(10,113);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(8,5,'',0,0,'L');
	$pdf->MultiCell(160,5,$data['StudentExit']['question_3'],0,1);
	$pdf->Line(14,$pdf->getY()-5,180,$pdf->getY()-5);
	$pdf->Line(14,$pdf->getY()+1,180,$pdf->getY()+1);
	$pdf->Ln(5);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'Of all the subjects you took, which were your least favorite and why?   ',0,0,'L');
	$pdf->ln(5);
	$pdf->SetXY(10,133);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(8,5,'',0,0,'L');
	$pdf->MultiCell(160,5,$data['StudentExit']['question_4'],0,1);
	$pdf->Line(14,$pdf->getY()-5,180,$pdf->getY()-5);
	$pdf->Line(14,$pdf->getY()+1,180,$pdf->getY()+1);
	$pdf->ln(5);

	$a1 = '';
	$b1 = '';

	$a2 = '';
	$b2 = '';

	$a3 = '';
	$b3 = '';

	$a4 = '';

	// A 

	  if($data['StudentExit']['a'] == 1) {

		  $a1 = 4;

		} elseif($data['StudentExit']['a'] == 2){

		  $a2 = 4;

		} elseif($data['StudentExit']['a'] == 3){

		  $a3 = 4;

		} elseif($data['StudentExit']['a'] == 4){

		  $a4 = 4;

		}

	// B

	  if($data['StudentExit']['b'] == 3) {

		  $b3 = 4;

		} elseif($data['StudentExit']['b'] == 2){

		  $b2 = 4;

		} elseif($data['StudentExit']['b'] == 1){

		  $b1 = 4;

		}

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(80,5,'How do you feel about the guidance and learning you received from ZSCMST? ',0,0,'C');
	$pdf->ln(7);

	$pdf->Cell(20, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $a1, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Very Good ', 0, 0, 'L');

	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $a2, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Good ', 0, 0, 'L');

	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $a3, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Fair ', 0, 0, 'L');

	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $a4, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Poor', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');
	$pdf->ln(10);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'What changes would you suggest that would improve the teaching in ZSCMST? ',0,0,'L');
	$pdf->ln(5);
	$pdf->SetXY(5,170);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->MultiCell(160,5,$data['StudentExit']['question_5'],0,1);
	$pdf->Line(14,$pdf->getY()-5,180,$pdf->getY()-5);
	$pdf->Line(14,$pdf->getY()+1,180,$pdf->getY()+1);
	$pdf->ln(5);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(11.5,5,'What particular area of the school that needs improvement? ',0,0,'L');
	$pdf->ln(5);
	$pdf->SetXY(5,190);
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->MultiCell(160,5,$data['StudentExit']['question_6'],0,1);
	$pdf->Line(14,$pdf->getY()-5,180,$pdf->getY()-5);
	$pdf->Line(14,$pdf->getY()+1,180,$pdf->getY()+1);
	$pdf->ln(10);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(-7,5,'',0,0,'L');
	$pdf->Cell(80,5,'What is your immediate plan?  ',0,0,'C');
	$pdf->ln(7);

	$pdf->Cell(20, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $b3, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Employment ', 0, 0, 'L');

	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $b2, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Continue education ', 0, 0, 'L');

	$pdf->Cell(10, 5, '', 0, 0, 'L');
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(7, 6, $b1, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(1, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Others : ', 0, 0, 'L');
	if ($b1 == true){
	  $pdf->Line(152, $pdf->getY() + 5, 180, $pdf->getY() + 5);
	  $pdf->Cell(-12,5,'',0,0,'L');
	  $pdf->Cell(25, 5, 'Please Specify : ', 0, 0, 'L');
	  $pdf->Cell(5, 5,$data['StudentExit']['otherImmediate'], 0, 1, 'L');
	}
	$pdf->ln(20);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(-7,5,'',0,0,'L');
	$pdf->Cell(80,5,'For future contact informations :  ',0,0,'C');
	$pdf->ln(8);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(-7,5,'',0,0,'L');
	$pdf->Cell(55,5,'Contact No. :  ',0,0,'C');
	$pdf->Cell(-15,5,'',0,0,'L');
	$pdf->Cell(5, 5,$data['StudentExit']['contact_no'], 0, 0, 'L');
	$pdf->Line(35, $pdf->getY() + 5, 70, $pdf->getY() + 5);
	$pdf->ln(7);

	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(-4.5,5,'',0,0,'L');
	$pdf->Cell(55,5,'Email/Facebook:  ',0,0,'C');
	$pdf->Cell(-15,5,'',0,0,'L');
	$pdf->Cell(5, 5,$data['StudentExit']['email'], 0, 0, 'L');
	$pdf->Line(37, $pdf->getY() + 5, 70, $pdf->getY() + 5);
	$pdf->Ln(20);

	$pdf->Line(70, $pdf->getY() + 5, 130, $pdf->getY() + 5);
	$pdf->ln(5);
	$pdf->Cell(70,5,'',0,0,'L');
	$pdf->Cell(55,5,'Signature  ',0,0,'C');

	$pdf->output();
	exit();

  }

   public function programAdviser() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search') != null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['year_term_id'] = 0; 

	if($this->request->getQuery('year_term_id') != null) {

	  $year_term_id = $this->request->getQuery('year_term_id');

	  $conditions['year_term_id'] = $year_term_id; 

	}

	$conditions['status'] = '';

	if($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  if($status == 0){

		$title = 'FOR ENLISTMENT';

		$conditions['status'] = "AND (StudentEnrollment.enrollmentCount = 0 OR StudentEnrollment.enrollmentCount IS NULL)";

	  }else{

		$title = 'ENLISTED';

		$conditions['status'] = "AND StudentEnrollment.enrollmentCount > 0";

	  }

	}

	$tmpData = $this->ProgramAdvisers->getAllProgramAdviserPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT '.$title,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(25,5,'STUDENT NO.',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(90,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(20,5,'RATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(10,25,50,90,20));
	$pdf->SetAligns(array('C','C','L','L','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){ 

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['student_no'],

		  strtoupper($data['full_name']),

		  strtoupper($data['name']),

		  $data['rate'],

		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+85,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+111,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);

	$pdf->output();
	exit();

  }

	 public function ptc() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search') != null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$tmpData = $this->Ptcs->getAllPtcPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PTC',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(90,5,'CODE',1,0,'C',1);
	$pdf->Cell(90,5,'SECTION',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(15,90,90));
	$pdf->SetAligns(array('C','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){ 

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['section'],


		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+85,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+111,$pdf->getY()+2,$pdf->getX()+195,$pdf->getY()+2);

	$pdf->output();
	exit();

  }

  public function approval_enrolled_course() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(ApprovalEnrolledCourse.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(ApprovalEnrolledCourse.application_date) >= '$start' AND DATE(ApprovalEnrolledCourse.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if (isset($this->request->query['status'])) {

	  $status = $this->request->query['status'];

	  $conditions['status'] = "AND ApprovalEnrolledCourse.approve = $status";

	}

	$tmpData = $this->ApprovalEnrolledCourse->query($this->ApprovalEnrolledCourse->getAllApprovalEnrolledCourse($conditions));

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 12);
	$pdf->Cell(0,5,'APPROVAL OF ENROLLED COURSE MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(70,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(110,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(40,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(40,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Cell(25,5,'STATUS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(15,30,70,110,40,40,25,20));
	$pdf->SetAligns(array('C','C','L','C','L','C','C','C'));

	if(!empty($tmpData)){

	  $approve = '';

	  foreach ($tmpData as $key => $data){ 

		$tmp = $data['ApprovalEnrolledCourse'];

		if($tmp['approve'] == 0){

		  $approve = 'PENDING';

		}else if($tmp['approve'] == 1){

		  $approve = 'APPROVED';

		}else if($tmp['approve'] == 2){

		  $approve = 'DISAPPROVED';

		}

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['ApprovalEnrolledCourse']['code'],

		  $data['ApprovalEnrolledCourse']['student_name'],

		  $data['ApprovalEnrolledCourse']['program'],

		  $data['ApprovalEnrolledCourse']['email'],

		  $data['ApprovalEnrolledCourse']['contact_no'],

		  $approve

		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->output();
	exit();

  }

  public function payment() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Payment.application_date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Payment.application_date) >= '$start' AND DATE(Payment.application_date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND Payment.approve = $status";

	}

	$tmpData = $this->Payments->getAllPaymentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PAYMENT MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(70,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(130,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(45,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(40,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,30,70,130,45,40));
	$pdf->SetAligns(array('C','C','L','C','L','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){ 

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['program'],

		  $data['email'],

		  $data['contact_no'],

		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+150,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+185,$pdf->getY()+2,$pdf->getX()+330,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function assessment() {

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Assessment.created) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Assessment.created) >= '$start' AND DATE(Assessment.created) <= '$end'";

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND Assessment.approve = $status";

	}
 
	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student') != null) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $studentId = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND Assessment.student_id = $studentId";

	}

	$tmpData = $this->Assessments->getAllAssessmentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'PAYMENT MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'#',1,0,'C',1);
	$pdf->Cell(30,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(30,5,'STUDENT NO',1,0,'C',1);
	$pdf->Cell(70,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(45,5,'EMAIL',1,0,'C',1);
	$pdf->Cell(40,5,'CONTACT NO.',1,0,'C',1);
	$pdf->Cell(105,5,'PROGRAM',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,30,30,70,45,40,105));
	$pdf->SetAligns(array('C','C','C','L','C','C','L'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){ 

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_no'],

		  $data['student_name'],

		  $data['email'],

		  $data['contact_no'],

		  $data['program']
		));

	  }

	}else{

	  $pdf->Cell(335,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+153,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+183,$pdf->getY()+2,$pdf->getX()+335,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }


  public function studentRanking(){

	$conditions = array();

	 $conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}


	$conditions['program_id'] = '';

	if ($this->request->getQuery('program_id')) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND Student.program_id = $program_id";
	}

	$conditions['year_term_id'] = "";


	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

	}

	$conditions['year'] = "";


	if ($this->request->getQuery('year')) {

	  $year = $this->request->getQuery('year'); 

	  if($year==1){
		$y1 = '1';
		$y2 = '2';
	  }else if($year==2){
		$y1 = '4';
		$y2 = '5';
	  }else if($year==3){
		$y1 = '7';
		$y2 = '8';
	  }else if($year==4){
		$y1 = '10';
		$y2 = '11';
	  }else if($year==5){
		$y1 = '13';
		$y2 = '14';
	  }

	  $conditions['year'] = " AND (StudentEnrolledCourse.year_term_id = $y1 OR StudentEnrolledCourse.year_term_id = $y2) ";

	}


	$tmpData = $this->Reports->getAllStudentRankingPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT RANKINGS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(40,5,'STUDENT NUMBER',1,0,'C');
	$pdf->Cell(80,5,'STUDENT NAME',1,0,'C');
	$pdf->Cell(57,5,'PROGRAM',1,0,'C');
	$pdf->Cell(20,5,'AVERAGE',1,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,40,80,57,20));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['program'],

		  $data['ave'],

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function promotedStudent(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}


	$conditions['program_id'] = '';

	if ($this->request->getQuery('program_id')) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND Student.program_id = $program_id";

	}

	$conditions['year'] = "";

	if ($this->request->getQuery('year')) {

	  $year = $this->request->getQuery('year'); 

	  if($year==1){
		$y1 = '1';
		$y2 = '2';
	  }else if($year==2){
		$y1 = '4';
		$y2 = '5';
	  }else if($year==3){
		$y1 = '7';
		$y2 = '8';
	  }else if($year==4){
		$y1 = '10';
		$y2 = '11';
	  }else if($year==5){
		$y1 = '13';
		$y2 = '14';
	  }

	  $conditions['year'] = " AND StudentEnrolledCourse.year_term_id = $year";

	}

	$tmpData = $this->Reports->getAllPromotedStudentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF PROMOTED STUDENTS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(50,5,'STUDENT NUMBER',1,0,'C');
	$pdf->Cell(90,5,'STUDENT NAME',1,0,'C');
	$pdf->Cell(57,5,'PROGRAM',1,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,50,90,57));
	$pdf->SetAligns(array('C','C','L','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['program'],


		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

   public function interviewRequest(){

	$conditions = [];

	$conditionsPrint = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	 $conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(InterviewRequest.date) = '$search_date'"; 

	  $conditionsPrint .= '&date='.$search_date;

	}
	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(InterviewRequest.date) >= '$start' AND DATE(InterviewRequest.date) <= '$end'";

	  $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status')!=null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND InterviewRequest.approve = $status";
 
	  $conditionsPrint .= '&status='.$this->request->getQuery('status');

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student')) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $studentId = $this->Session->read('Auth.User.studentId');

	  $conditions['studentId'] = "AND InterviewRequest.student_id = $studentId";

	  $conditionsPrint .= '&per_student='.$per_student;

	}

	$tmpData = $this->InterviewRequests->getAllInterviewRequestPrint($conditions);

	$full_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5, 10, 5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base . '/assets/img/zam.png', 75, 10, 25, 25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0, 5, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('telephone'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('website') . ' Email: ' . $this->Global->Settings('email'), 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'INTERVIEW REQUESTS', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	$pdf->Cell(10);
	$pdf->Cell(10, 5, '#', 1, 0, 'C', 1);
	$pdf->Cell(20, 5, 'CODE', 1, 0, 'C', 1);
	$pdf->Cell(50, 5, 'STUDENT NAME', 1, 0, 'C', 1);
	$pdf->Cell(130, 5, 'COURSE', 1, 0, 'C', 1);
	$pdf->Cell(45, 5, 'YEAR LEVEL', 1, 0, 'C', 1);
	$pdf->Cell(30, 5, 'DATE', 1, 0, 'C', 1);
	$pdf->Cell(40, 5, 'STATUS', 1, 0, 'C', 1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10, 20, 50, 130, 45, 30,40));
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C','C'));
	$conditions = array();

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {


		if ($data['approve'] == 0) {

			$approve = 'PENDING';

		} else if ($data['approve'] == 1) {

			$approve = 'APPROVED';

		} else if ($data['approve'] == 2) {

			$approve = 'DISAPPROVED';

		}

		$pdf->Cell(10);
		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['name'],

		  $data['description'],

		  fdate($data['date'], 'm/d/Y'),

		  $approve

		));

	  }

	} else {

	  $pdf->Cell(10);

	  $pdf->Cell(325, 5, 'No data available.', 1, 1, 'C');
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+10,$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+335,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function reportStudentBehavior(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentBehavior.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentBehavior.date) >= '$start' AND DATE(StudentBehavior.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}
	 $conditions['program_id'] = '';

	if ($this->request->getQuery('program_id')!=null) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND StudentBehavior.course_id = $program_id";

	}

	$conditions['year'] = "";


	if ($this->request->getQuery('year')!=null) {

	  $year = $this->request->getQuery('year'); 

	  $conditions['year'] = " AND StudentBehavior.year_term_id = '$year' ";

	}

	// debug($conditions);

	$this->loadModel('Reports');

	$tmpData = $this->Reports->getAllStudentBehaviorPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT BEHAVIOR',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(30,5,'STUDENT NUMBER',1,0,'C');
	$pdf->Cell(60,5,'STUDENT NAME',1,0,'C');
	$pdf->Cell(57,5,'PROGRAM',1,0,'C');
	$pdf->Cell(50,5,'BEHAVIOR',1,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,30,60,57,50));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['student_name'],

		  $data['program'],

		  $data['behavior'],


		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function transcriptOfRecords(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search') != null){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date') != null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate') != null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

	}

	$conditions['college_id'] = " AND Student.college_id = 0";

	if ($this->request->getQuery('college_id') != null) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Student.college_id = $college_id";

	}

	$conditions['program_id'] = '';

	if ($this->request->getQuery('program_id') != null) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND Student.program_id = $program_id";

	}

	$conditions['year_term_id'] = '';

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND StudentEnrollment.year_term_id = $year_term_id";

	}

	$tmpData = $this->Reports->getAllTranscriptofRecordPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT BEHAVIOR',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(60,5,'STUDENT NAME',1,0,'C');
	$pdf->Cell(30,5,'STUDENT NUMBER',1,0,'C');
	$pdf->Cell(57,5,'COLLEGE',1,0,'C');
	$pdf->Cell(50,5,'PROGRAM',1,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,30,60,57,50));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['full_name'],

		  $data['student_no'],

		  $data['college'],

		  $data['program'],


		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function academicList(){

	
	$conditionsPrint = '';

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')!=null){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')!=null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(AwardeeManagement.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startDate')!=null) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(AwardeeManagement.date) >= '$start' AND DATE(AwardeeManagement.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$conditions['college_id'] = '';

	if ($this->request->getQuery('college_id')!=null) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND AwardeeManagement.college_id = $college_id";
	}

	$conditions['program_id'] = '';

	if ($this->request->getQuery('program_id')!=null) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND AwardeeManagement.program_id = $program_id";

	}

	$conditions['semester'] = '';

	if ($this->request->getQuery('semester')!=null) {

	  $semester = $this->request->getQuery('semester'); 

	  $conditions['semester'] = " AND AwardeeManagement.semester = $semester";

	}

	$conditions['year'] = '';

	if ($this->request->getQuery('year')!=null) {

	  $year = $this->request->getQuery('year'); 

	  $conditions['year'] = " AND AwardeeManagement.year = $year";

	}

	$conditions['section_id'] = " AND AwardeeManagement.section_id IS NULL";

	if ($this->request->getQuery('section_id')!=null) {

	  $section_id = $this->request->getQuery('section_id'); 

	  $conditions['section_id'] = " AND AwardeeManagement.section_id = $section_id";

	}

	$tmpData = $this->Reports->getAllAcademicListPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ACADEMIC LIST',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(30,5,'STUDENT NUMBER',1,0,'C');
	$pdf->Cell(60,5,'STUDENT NAME',1,0,'C');
	$pdf->Cell(57,5,'AWARD',1,0,'C');
	$pdf->Cell(50,5,'REGISTRATION DATE ',1,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,30,60,57,50));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_name'],

		  $data['student_no'],

		  $data['award_id'],

		  fdate($data['date'],'m/d/Y')

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function studentBehavior(){

	$conditions = [];

	$conditionsPrint = '';

	if ($this->request->getQuery('search')!=null) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')!=null) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentBehavior.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')!=null) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentBehavior.date) >= '$start' AND DATE(StudentBehavior.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	
	$conditions['program_id'] = " AND StudentBehavior.course_id = 0";

	if ($this->request->getQuery('program_id')!=null) {

	  $program_id = $this->request->getQuery('program_id');

	  $conditions['program_id'] = " AND StudentBehavior.course_id = $program_id";

	}

	$conditions['year'] = "";

	if ($this->request->getQuery('year')!=null) {

	  $year = $this->request->getQuery('year');

	  $conditions['year'] = " AND StudentBehavior.year_term_id = '$year' ";

	}

	// debug($conditions);

	// $this->loadModel('StudentBehaviors');

	$tmpData = $this->StudentBehaviors->getAllStudentBehaviorPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT BEHAVIOR',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(30,5,'STUDENT NUMBER',1,0,'C');
	$pdf->Cell(60,5,'STUDENT NAME',1,0,'C');
	$pdf->Cell(57,5,'PROGRAM',1,0,'C');
	$pdf->Cell(50,5,'BEHAVIOR',1,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,30,60,57,50));
	$pdf->SetAligns(array('C','C','L','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['student_name'],

		  $data['program'],

		  $data['behavior'],


		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+90,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+117,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function studentClub(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentClub.date) = '$search_date'";

	  $dates['date'] = $search_date;
	}

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate');

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentClub.date) >= '$start' AND DATE(StudentClub.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;
	}

	$conditions['status'] = '';

	if ($this->request->getQuery('status') != null) {

	  $status = $this->request->getQuery('status');

	  $conditions['status'] = "AND StudentClub.approve = $status";

	}

	$conditions['studentId'] = '';

	if ($this->request->getQuery('per_student') != null) {

	  $per_student = $this->request->getQuery('per_student');
	  
	  $student_id = $this->Auth->user('studentId');

	  $conditions['studentId'] = "AND StudentClub.student_id = $student_id";

	}

	$tmpData = $this->StudentClubs->getAllStudentClubPrint($conditions);

	$full_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5, 10, 5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base . '/assets/img/zam.png', 75, 10, 25, 25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0, 5, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('telephone'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('website') . ' Email: ' . $this->Global->Settings('email'), 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'STUDENT CLUB APPLICATIONS', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	$pdf->Cell(10);
	$pdf->Cell(10, 5, 'No.', 1, 0, 'C', 1);
	$pdf->Cell(35, 5, 'CODE', 1, 0, 'C', 1);
	$pdf->Cell(80, 5, 'STUDENT NAME', 1, 0, 'C', 1);
	$pdf->Cell(45, 5, 'DATE', 1, 0, 'C', 1);
	$pdf->Cell(45, 5, 'POSITION', 1, 0, 'C', 1);
	$pdf->Cell(70, 5, 'CLUB', 1, 0, 'C', 1);
	$pdf->Cell(40, 5, 'STATUS', 1, 0, 'C', 1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10, 35, 80, 45, 45, 70,40));
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C','C'));
	$conditions = array();

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {


		if($data['approve'] == 0){

		  $approve = 'PENDING';

		}else if($data['approve'] == 1){

		  $approve = 'APPROVED';

		}
		$pdf->Cell(10);
		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  fdate($data['date'], 'm/d/Y'),

		  $data['position'],

		  $data['title'],

		  $approve

		));

	  }

	} else {

	  $pdf->Cell(10);

	  $pdf->Cell(325, 5, 'No data available.', 1, 1, 'C');
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+10,$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+335,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function club(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	}


	$tmpData = $this->Clubs->getAllClubPrint($conditions);

	$full_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5, 10, 5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base . '/assets/img/zam.png', 5, 10, 25, 25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0, 5, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('telephone'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->Cell(0, 5, $this->Global->Settings('website') . ' Email: ' . $this->Global->Settings('email'), 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, 'STUDENT CLUB APPLICATIONS', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217, 237, 247);
	$pdf->Cell(35);
	$pdf->Cell(10, 5, 'No.', 1, 0, 'C', 1);
	$pdf->Cell(30, 5, 'CODE', 1, 0, 'C', 1);
	$pdf->Cell(80, 5, 'CLUB NAME', 1, 0, 'C', 1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,30,80));
	$pdf->SetAligns(array('C', 'C', 'C'));
	$conditions = array();

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {
	   
		$pdf->Cell(35);
		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['title'],


		));

	  }

	} else {

	  $pdf->Cell(35);

	  $pdf->Cell(120, 5, 'No data available.', 1, 1, 'C');
	}
	
	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX()+35,$pdf->getY()+2,$pdf->getX()+85,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function listAcademicAwardees(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['college_id'] = " AND Student.college_id IS NULL";

	if ($this->request->getQuery('college_id')) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Student.college_id = $college_id";

	}

	 $conditions['program_id'] = '';

	if ($this->request->getQuery('program_id')) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND Student.program_id = $program_id";


	}

	$conditions['award'] = "";

	if ($this->request->getQuery('award')) {

	  $award = $this->request->getQuery('award');
	  
	  if ($award == 1) {

		$conditions['award'] = "AND StudentEnrolledCourse.final_grade BETWEEN 1.00 AND 1.30";

	  } else if ($award == 2) {

		$conditions['award'] = "AND StudentEnrolledCourse.final_grade BETWEEN 1.40 AND 1.50";

	  }
	  
	}
  

	$conditions['year_term_id'] = "";


	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";


	}

	$conditions['year'] = "";


	if ($this->request->getQuery('year')) {

	  $year = $this->request->getQuery('year'); 

	  if($year==1){
		$y1 = '1';
		$y2 = '2';
	  }else if($year==2){
		$y1 = '4';
		$y2 = '5';
	  }else if($year==3){
		$y1 = '7';
		$y2 = '8';
	  }else if($year==4){
		$y1 = '10';
		$y2 = '11';
	  }else if($year==5){
		$y1 = '13';
		$y2 = '14';
	  }

	  $conditions['year'] = " AND (StudentEnrolledCourse.year_term_id = $y1 OR StudentEnrolledCourse.year_term_id = $y2) ";

	}
	
	$tmpData = $this->Reports->getAllListAcademicAwardeePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	 $pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST ACADEMIC AWARDEE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(100,5,'COLLEGE',1,0,'C',1);
	$pdf->Cell(60,5,'COURSE',1,0,'C',1);
	$pdf->Cell(60,5,'AVERAGE',1,0,'C',1);
	$pdf->Cell(65,5,'AWARD',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,100,60,60,65));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {

		$award = '';

		if ($data['award'] == 1) {

		  $award = "President's Lister";

		  } elseif ($data['award'] == 2) {

		  $award = "Dean's Lister";
		  
		  }
	
		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['full_name'],

		  $data['college'],

		  $data['program'],

		  $data['ave'],

		  $award,

		));

	  }

	}

	else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function faculty_score(){


	  $tmpData = $this->FacultyEvaluation->find('all', array(
		'contain' => array(
		
		  'Course' => array(

			'conditions' => array(

			  'Course.visible' => true

			),

		  ),
		),
		'conditions' => array(
		  'FacultyEvaluation.visible' => true,
		),
		// 'group' => 'FacultyEvaluation.course_id',
		'order' => array(

		  'FacultyEvaluation.course_id' => 'ASC'

		)

	  ));


	
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,5,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 10);
	// $pdf->Image($this->base .'/assets/img/counseling_intake.png',0,0,215.9,355.6);
		//? -----------------------------------------------------------------------------------  HEADER START
	$pdf->Image($this->base .'/assets/img/zam.png',5,3,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',190,3,20,25);
	$pdf->Ln(3.5);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0, 5, 'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph  email: registrar@zscmst.edu.ph', 0, 0, 'C');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(0, 6, 'RESULTS OF STUDENTS\' EVALUATIONS ON TEACHERS\' PERFORMANCE', 0, 0, 'C');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9);

	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,18,'No.',1,0,'C',1);
	$pdf->Cell(70,18,'Name',1,0,'C',1);
	  $y = $pdf->GetY();
	$pdf->MultiCell(20,4.5,"A. Commitment

	  ",1,'C',1);
	$pdf->SetXY(105, $y);
	$y = $pdf->GetY();
	$pdf->MultiCell(20,4.5,"B. Knowledge of Subject
	  ",1,'C',1);
	$pdf->SetXY(125, $y);
		$y = $pdf->GetY();
	$pdf->MultiCell(20,4.5,"C. Teaching for Independent Learning",1,'C',1);
	$pdf->SetXY(145, $y);
			$y = $pdf->GetY();
	$pdf->MultiCell(21,4.5,"D. Management of Learning",1,'C',1);
	$pdf->SetXY(166, $y);
				$y = $pdf->GetY();
	$pdf->Cell(15,18,'WMS',1,0,'C',1);
	$pdf->SetXY(181, $y);
			$y = $pdf->GetY();
	$pdf->MultiCell(30,4.5,"ADJECTIVAL DESCRIPTION",1,'C',1);
	$pdf->SetXY(166, $y);
	$y = $pdf->GetY();
	$pdf->Ln(18);
	$pdf->SetFont("Arial", '', 8);
	$pdf->SetWidths(array(10,70,20,20,20,21,15,30));
	$pdf->SetAligns(array('C','L','C','C','C','C','C','C'));
	$a_ave=0.0;
	$b_ave=0.0;
	$c_ave=0.0;
	$d_ave=0.0;
	$wms = 0.0;
	$desc = "";
	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$tmp = $data['FacultyEvaluation'];
		$a_ave = ($tmp['a1']+$tmp['a2']+$tmp['a3']+$tmp['a4']+$tmp['a5'])/5;
		$b_ave = ($tmp['b1']+$tmp['b2']+$tmp['b3']+$tmp['b4']+$tmp['b5'])/5;
		$c_ave = ($tmp['c1']+$tmp['c2']+$tmp['c3']+$tmp['c4']+$tmp['c5'])/5;
		$d_ave = ($tmp['d1']+$tmp['d2']+$tmp['d3']+$tmp['d4']+$tmp['d5'])/5;
		$wms = ($a_ave+$d_ave+$c_ave+$d_ave)/4;

		if($wms >= 4.50 ){
		  $desc = "OUTSTANDING";
		}else if($wms >=3.5 && $wms < 4.5 ){
		  $desc = "VERY SATISFACTORY";
		}
		else if($wms >=2.5 && $wms < 3.5 ){
		  $desc = "SATISFACTORY";
		}
		else if($wms >=1.5 && $wms < 2.5 ){
		  $desc = "Fair";
		}
		else if($wms <1.5 ){
		  $desc = "POOR";
		}

		$pdf->RowLegalP(array(

		  $key + 1,

		  $tmp['employee_name'],

		  $a_ave,
		  $b_ave,
		  $c_ave,
		  $d_ave,
		  $wms,
		  $desc,

		));

	  }

	}else{

	  $pdf->Cell(195,5,'No data available.',1,1,'C');

	}

	// print_r($tmp);
	$pdf->output();
	exit();

  }

  public function faculty_comment_form($id = null){


	  $tmpData = $this->FacultyEvaluation->find('all', array(
		'contain' => array(
		
		  'Course' => array(

			'conditions' => array(

			  'Course.visible' => true

			),

		  ),
		),
		'conditions' => array(
		  'FacultyEvaluation.visible' => true,
		  'FacultyEvaluation.employee_id' => $id,
		),
		'order' => array(

		  'FacultyEvaluation.course_id' => 'ASC'

		)

	));
	  $course = $this->FacultyEvaluation->find('all', array(
		'contain' => array(
		
		  'Course' => array(

			'conditions' => array(

			  'Course.visible' => true

			),

		  ),
		),
		'conditions' => array(
		  'FacultyEvaluation.visible' => true,
		  'FacultyEvaluation.employee_id' => $id,
		),
		'group' => 'FacultyEvaluation.course_id',
		'order' => array(
		  'FacultyEvaluation.course_id' => 'ASC'
		)

	));

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,5,5);
	$pdf->AddPage("P", "Legal", 0);
	$pdf->SetAutoPageBreak(false);
	$pdf->SetFont("Times", '', 10);
	// $pdf->Image($this->base .'/assets/img/counseling_intake.png',0,0,215.9,355.6);
		//? -----------------------------------------------------------------------------------  HEADER START
	$pdf->Image($this->base .'/assets/img/zam.png',5,3,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',190,3,20,25);
	$pdf->Ln(3.5);
	$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
	$pdf->Ln(3.5);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0, 5, 'Tel No: (062) 991-0647; Telefax: (062) 991-0777 http://www.zscmst.edu.ph  email: registrar@zscmst.edu.ph', 0, 0, 'C');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->Cell(0, 6, 'RESULTS OF STUDENTS\' EVALUATIONS ON TEACHERS\' PERFORMANCE', 0, 0, 'C');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9);
	$pdf->Cell(0, 6, 'Faculty Name: '.$tmpData[0]['FacultyEvaluation']['employee_name'], 0, 0, 'L');
	$pdf->Ln(5);
	if(!empty($tmpData)){

	  foreach ($course as $key=>$data){
		$tmp = $data['FacultyEvaluation'];

		$pdf->Ln(5);
		$pdf->SetFont("Arial", 'I', 9);
		$pdf->SetFillColor(217,237,247);
		$pdf->Cell(205,5,$data['Course']['code']." : ".$data['Course']['title'],1,0,'C',1);
		$pdf->SetFont("Arial", '', 8);
		$pdf->SetFillColor(221,248,222);
		$pdf->Ln(5);

		$pdf->Cell(20,5,'Evaluator ID',1,0,'C',1);
		$pdf->Cell(185,5,'Comment',1,0,'C',1);
		$pdf->Ln(5);
		
		$pdf->SetWidths(array(20,185));
		$pdf->SetAligns(array('C','L'));
		foreach($tmpData as $k => $d){
		  $t = $d['FacultyEvaluation'];
		  if($tmp['course_id']==$t['course_id']){
			$pdf->RowLegalP(array(
			  $tmp['rate_by'],

			  $tmp['comments'],
			  
			));
		  }
		}

	  }

	}

	$pdf->output();
	exit();

  }

  public function blockSections(){
	
	$conditions = array();
  
	$conditions['search'] = '';
  
	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['college_id'] = '';

	if ($this->request->getQuery('college_id')) {

	  $college_id = $this->request->getQuery('college_id');

	  $conditions['college_id'] = "AND BlockSection.college_id = $college_id";

	}

	$conditions['program_id'] = '';

	if ($this->request->getQuery('program_id')) {

	  $program_id = $this->request->getQuery('program_id');

	  $conditions['program_id'] = "AND BlockSection.program_id = $program_id"; 

	}

	$conditions['year_term_id'] = '';

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id');

	  $conditions['year_term_id'] = "AND BlockSection.year_term_id = $year_term_id";

	}
  
	$tmpData = $this->BlockSections->getAllBlockSectionPrint($conditions);
  
	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,10);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'BLOCK SECTIONS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'No.',1,0,'C',1);
	$pdf->Cell(25,5,'CODE',1,0,'C',1);
	$pdf->Cell(100,5,'COLLEGE',1,0,'C',1);
	$pdf->Cell(100,5,'PROGRAM',1,0,'C',1);
	$pdf->Cell(55,5,'YEAR TERM',1,0,'C',1);
	$pdf->Cell(40,5,'SCHOOL YEAR',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,25,100,100,55,40));
	$pdf->SetAligns(array('C','C','L','L','C','C'));
	$conditions = array();
	if(!empty($tmpData)){
  
	  foreach ($tmpData as $key => $data){
	
		$pdf->RowLegalL(array(
	
		  $key + 1,
	
		  $data['code'],
	
		  $data['college'],

		  $data['program'],
  
		  $data['description'],

		  $data['school_year_start'].' - '.$data['school_year_end'],

		));
  
	  }
  
	}else{
  
	  $pdf->Cell(330,5,'No data available.',1,1,'C');
  
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+182,$pdf->getY()+2,$pdf->getX()+330,$pdf->getY()+2);
	$pdf->SetDash();
  
	$pdf->output();
	exit();

  }

  public function gwa(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['section_id'] = '';

	if ($this->request->getQuery('section_id')) {

	  $section_id = $this->request->getQuery('section_id'); 

	  $conditions['section_id'] = " AND StudentEnrolledCourse.section_id = $section_id";


	}


	$conditions['college_id'] = " AND Student.college_id IS NULL";

	if ($this->request->getQuery('college_id')) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Student.college_id = $college_id";

	}

	 $conditions['program_id'] = '';

	if ($this->request->getQuery('program_id')) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND Student.program_id = $program_id";


	}

	
	$tmpData = $this->Reports->getAllGwaPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	   require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF GENERAL WEIGHTED AVERAGE (GWA)',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(150,5,'COLLEGE',1,0,'C',1);
	$pdf->Cell(68,5,'COURSE',1,0,'C',1);
	$pdf->Cell(68,5,'GWA',1,0,'C',1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,150,68,68,));
	$pdf->SetAligns(array('C','C','C','C','C'));

	if (count($tmpData)>0) {
	  foreach ($tmpData as $key => $data) {

	
		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['full_name'],

		  $data['college'],

		  $data['program'],

		  $data['ave'],
	 
		));
	  }
	}
	else{

	  $pdf->Cell(346,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function academicFailuresList(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['college_id'] = '';

	if ($this->request->getQuery('college_id')) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Student.college_id = $college_id";

	}

	$conditions['college_program_id'] = "AND Student.program_id IS NULL";

	if ($this->request->getQuery('college_program_id')) {

	  $college_program_id = $this->request->getQuery('college_program_id'); 

	  $conditions['college_program_id'] = " AND Student.program_id = $college_program_id";


	}

	$conditions['program_course_id'] = '';

	if ($this->request->getQuery('program_course_id')) {

	  $program_course_id = $this->request->getQuery('program_course_id'); 

	  $conditions['program_course_id'] = " AND StudentEnrolledCourse.course_id = $program_course_id";


	  $adata = $this->Course->find()
		->where([
			'Course.visible' => true,
			'Course.id' => $program_course_id
		])
		->first();


	}

	$conditions['term'] = '';

	$term = '';

	if ($this->request->getQuery('term')) {

	  $term = $this->request->getQuery('term'); 

	  if($term === 'midterm'){
		$conditions['term'] = " AND StudentEnrolledCourse.midterm_submitted = 1 AND StudentEnrolledCourse.midterm_grade > 3 ";
	  }
	  else if($term === 'finalterm'){
		$conditions['term'] = " AND StudentEnrolledCourse.finalterm_submitted = 1 AND StudentEnrolledCourse.finalterm_grade > 3 ";
	  }
	  else if($term === 'final'){
		$conditions['term'] = " AND StudentEnrolledCourse.final_grade > 3 ";
	  }

	}

	$this->loadModel('Reports');

	$tmpData = $this->Reports->getAllFailedStudentPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',60,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ACADEMIC FAILURES LIST',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($term),0,0,'C');
	$pdf->Ln(5);
	if($conditions['program_course_id'] !== '')
	$pdf->Cell(0,5,$adata['Course']['code'].' : '.$adata['Course']['title'],0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Times", 'B', 10);
	$pdf->SetFillColor(217, 237, 247);
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(70, 5, 'STUDENT NO', 1, 0, 'C', 1);
	$pdf->Cell(120, 5, 'STUDENT NAME', 1, 0, 'C', 1);
	$pdf->Cell(70, 5, 'YEAR TERM', 1, 0, 'C', 1);
	$pdf->Cell(65, 5, 'REMARKS', 1, 0, 'C', 1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 10);
	$pdf->SetWidths(array(15,70,120,70,65));
	$pdf->SetAligns(array('C','C','C','C','C'));
	  
	 if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['year'].'-'.$data['semester'],

		  "FAILED",

		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+156,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();    

	$pdf->output();
	
	exit();

  }

	public function studentClubList() {

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['club_id'] = 'AND StudentClub.club_id IS NULL';

	if ($this->request->getQuery('club_id')) {

	  $club_id = $this->request->getQuery('club_id'); 

	  $conditions['club_id'] = " AND StudentClub.club_id = $club_id";

	}

	

	$tmpData = $this->Reports->getAllStudentClubListPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',60,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'STUDENT CLUB LIST',0,0,'C');
	$pdf->Ln(10);

	$pdf->SetFont("Times", 'B', 10);
	$pdf->SetFillColor(217, 237, 247);
	$pdf->Cell(15, 5, '#', 1,0, 'C', 1);
	$pdf->Cell(70, 5, 'STUDENT NO', 1, 0, 'C', 1);
	$pdf->Cell(120, 5, 'STUDENT NAME', 1, 0, 'C', 1);
	$pdf->Cell(50, 5, 'COLLEGE', 1, 0, 'C', 1);
	$pdf->Cell(30, 5, 'CLUB', 1, 0, 'C', 1);
	$pdf->Cell(30, 5, 'YEAR LEVEL', 1, 0, 'C', 1);
	$pdf->Cell(30, 5, 'POSITION', 1, 0, 'C', 1);

	$pdf->Ln();
	$pdf->SetFont("Times", '', 10);
	$pdf->SetWidths(array(15,70,120,50,30,30,30));
	$pdf->SetAligns(array('C','C','C','C','C','C','C'));
	  
	 if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['name'],

		  $data['title'],

		  $data['year'],

		  $data['position'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');
	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+156,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	
	exit();

  }

  public function facultyMasterlists(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['college_id'] = " AND Employee.college_id IS NULL";

	if ($this->request->getQuery('college_id')) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Employee.college_id = $college_id";

	}
	
	$tmpData = $this->Reports->getAllFacultyMasterlistPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',70,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'FACULTY MASTERLISTS',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'FACULTY NO.',1,0,'C',1);
	$pdf->Cell(100,5,'FACULTY NAME',1,0,'C',1);
	$pdf->Cell(60,5,'GENDER',1,0,'C',1);
	$pdf->Cell(60,5,'ACADEMIC RANK',1,0,'C',1);
	$pdf->Cell(65,5,'COLLEGE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,100,60,60,65));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['code'],

		  $data['full_name'],

		  $data['gender'],

		  $data['rank'],

		  $data['college'],

		));

	  }

	}else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function awardeeManagement(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(AwardeeManagement.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}  

	//advance search

	if ($this->request->getQuery('startdate')) {

	  $start = $this->request->getQuery('startdate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(AwardeeManagement.date) >= '$start' AND DATE(AwardeeManagement.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}


	$this->loadModel('AwardeeManagements');

	$tmpData = $this->AwardeeManagements->getAllAwardeeManagementPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',6,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'LIST OF BEST ACADEMIC STUDENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 7);
	$pdf->Cell(8,8,'#',1,0,'C');
	$pdf->Cell(22,4,'STUDENT','LTR',0,'C');
	$pdf->Cell(45,8,'STUDENT NAME',1,0,'C');
	$pdf->Cell(58,8,'COURSE',1,0,'C');
	$pdf->Cell(50,8,'YEAR LEVEL',1,0,'C');
	$pdf->Cell(22,8,'DATE','LTR',0,'C');
	$pdf->Ln(4);
	$pdf->Cell(8,4,'',0,0,'C');
	$pdf->Cell(22,4,'NUMBER','LBR',0,'C');
	$pdf->Cell(153,4,'',0,0,'C');
	$pdf->Cell(22,4,'','LBR',0,'C');
	$pdf->Ln();
	$pdf->SetFont("Times", '', 7);
	$pdf->SetWidths(array(8,22,45,58,50,22));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['student_name'],

		  $data['course_id'],

		  $data['year'],

		  fdate($data['date'],'m/d/Y'),

		));

	  }

	}else{

	  $pdf->Cell(205,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();
  
  }

  public function enrollmentProfile(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['year_term_id'] = "AND Student.year_term_id IS NULL";

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";


	}

	$conditions['college_id'] = " ";

	if ($this->request->getQuery('college_id')) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Student.college_id = $college_id";


	}
	$conditions['section_id'] = " ";

	if ($this->request->getQuery('section_id')) {

	  $section_id = $this->request->getQuery('section_id'); 

	  $conditions['section_id'] = " AND StudentEnrolledCourse.section_id = $section_id";


	}

	$this->loadModel('Reports');
	
	$tmpData = $this->Reports->getAllEnrollmentProfilePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ENROLLMENT PROFILE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NO.',1,0,'C',1);
	$pdf->Cell(100,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(60,5,'COURSE',1,0,'C',1);
	$pdf->Cell(60,5,'SECTION',1,0,'C',1);
	$pdf->Cell(65,5,'EMAIL',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,100,60,60,65));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {
	
		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['full_name'],

		  $data['course'],

		  $data['section'],

		  $data['email'],

		));

	  }

	}

	else{

	  $pdf->Cell(345,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+345,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function gcoEvaluationList(){

	$conditions = array();

	$conditions['search'] = '';

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(GcoEvaluation.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(GcoEvaluation.date) >= '$start' AND DATE(GcoEvaluation.date) <= '$end'";

	}

	$conditions['year_term_id'] = "";


	if ($this->request->getQuery('year_term_id')!=null) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND Student.year_term_id = '$year_term_id' ";

	}

	$conditions['college_id'] = "AND Student.college_id IS NULL";


	if ($this->request->getQuery('college_id')!=null) {

	  $college_id = $this->request->getQuery('college_id'); 

	  $conditions['college_id'] = " AND Student.college_id = '$college_id' ";

	}

	$conditions['program_id'] = "AND Student.program_id IS NULL";


	if ($this->request->getQuery('program_id')!=null) {

	  $program_id = $this->request->getQuery('program_id'); 

	  $conditions['program_id'] = " AND Student.program_id = '$program_id' ";

	}

	$conditions['employee_id'] = "";


	if ($this->request->getQuery('employee_id')!=null) {

	  $employee_id = $this->request->getQuery('employee_id'); 

	  $conditions['employee_id'] = " AND CounselingAppointment.employee_id = '$employee_id' ";

	}
	
	$tmpData = $this->Reports->getAllGcoEvaluationPrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'ENROLLMENT PROFILE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NO.',1,0,'C',1);
	$pdf->Cell(100,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(120,5,'COMMENTS',1,0,'C',1);
	$pdf->Cell(60,5,'DATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,50,100,120,60));
	$pdf->SetAligns(array('C','C','C','C','C'));

	if (count($tmpData)>0) {

	  foreach ($tmpData as $key => $data) {
	
		$pdf->RowLegalP(array(

		  $key + 1,

		  $data['student_no'],

		  $data['student_name'],

		  $data['comments'],

		  $data['date'],

		));

	  }

	}

	else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+160,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+187,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();

	exit();

  }

  public function medicalStudentProfile(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->MedicalStudentProfiles->getAllMedicalStudentProfilePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'MEDICAL STUDENT PROFILE MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(30,5,'CODE',1,0,'C',1);
	$pdf->Cell(50,5,'STUDENT NAME',1,0,'C',1);
	$pdf->Cell(140,5,'COLLEGE PROGRAM',1,0,'C',1);
	$pdf->Cell(30,5,'YEAR',1,0,'C',1);
	$pdf->Cell(75,5,'ADDRESS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,30,50,140,30,75));
	$pdf->SetAligns(array('C','C','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['student_name'],

		  $data['name'],

		  $data['description'],

		  $data['address']

		));

	  }

	}else{

	  $pdf->Cell(340,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+340,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function medicalStudentProfileForm($id = null) {

	// $office_reference = $this->Global->OfficeReference('Medical Student Profile');

	 $data['MedicalStudentProfile'] = $this->MedicalStudentProfiles->find()

	  ->contain([

		'MedicalStudentProfileImages' => [

		  'conditions' => [

			'MedicalStudentProfileImages.visible' => 1

		  ],

		],

		'CollegePrograms',

		'YearLevelTerms'

	  ])

	  ->where([

		  'MedicalStudentProfiles.visible' => 1,

		  'MedicalStudentProfiles.id' => $id,

	  ])

	  ->first();

	  $data['MedicalStudentProfileImage'] = $data['MedicalStudentProfile']['medical_student_profile_images'];

	  $data['CollegeProgram'] = $data['MedicalStudentProfile']['college_program'];

	  $data['YearLevelTerm'] = $data['MedicalStudentProfile']['year_level_term'];

	  unset($data['MedicalStudentProfile']['medical_student_profile_images']);

	  unset($data['MedicalStudentProfile']['year_level_term']);

	  unset($data['MedicalStudentProfile']['college_program']);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,5);
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/iso.png',175,10,20,25);
	$pdf->Image($this->base .'/assets/img/zam.png',18,10,25,25);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');

	$pdf->SetLineWidth(0.6);
	$pdf->Line(18,$pdf->getY()+8,200,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(10);
	$pdf->Rect(175,40,32,15.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(167,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(114,5,'',0,0,'R');
	$pdf->Cell(68,5,'Adopted Date: '. @$office_reference['OfficeReference']['adopted'],0,0,'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(123,5,'',0,0,'R');
	$pdf->Cell(59,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'R');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(126,5,'',0,0,'R');
	$pdf->Cell(60,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'R');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'MEDICAL EXAMINATION FORM',0,0,'C');

	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'NAME: ',0,0,'L');
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['student_name'],0,0,'L');
	$pdf->Line(25,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'PROGRAM: ',0,0,'L');
	$pdf->Cell(8);
	$pdf->Cell(85,5,$data['CollegeProgram']['code'],0,0,'L');
	$pdf->Line(127,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'ADDRESS: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->SetFont("Arial", '', 8.5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['address'],0,0,'L');
	$pdf->Line(31,$pdf->getY()+5,100,$pdf->getY()+5);
	
	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(10);
	$pdf->Cell(15,5,'YEAR: ',0,0,'L');
	// $pdf->Cell(5);
	$pdf->Cell(85,5,$data['YearLevelTerm']['description'],0,0,'L');
	$pdf->Line(127,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'AGE: ',0,0,'L');
	// $pdf->Cell(5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['age'],0,0,'L');
	$pdf->Line(21,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-3);
	$pdf->Cell(15,5,'CIVIL STATUS: ',0,0,'L');
	$pdf->Cell(13);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['civil_status'],0,0,'L');
	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'HEIGHT: ',0,0,'L');
	$pdf->Cell(6);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['height'],0,0,'L');
	$pdf->Line(27,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'WEIGHT: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['weight'],0,0,'L');
	$pdf->Line(127,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(2);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(3);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'RESPIRATORY SYSTEM: ',0,0,'L');
	$pdf->Cell(30);
	$pdf->Cell(100,5,$data['MedicalStudentProfile']['respiratory_system'],0,0,'L');
	$pdf->Line(53,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(5);
	$pdf->Line(10,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$x = $pdf->getX();
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(15,5,'EYES: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['eyes'],0,0,'L');
	$pdf->Line(127,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->setXY($y,109);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(1.5);
	$pdf->Cell(15,5,'COLOR PRECEPTION: ',0,0,'L');
	$pdf->Cell(25);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['color_preception'],0,0,'L');
	$pdf->Line(143,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'FLOUROGRAPHY: ',0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['flourography'],0,0,'L');
	$pdf->Line(42,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(8);
	$pdf->Cell(15,5,'VISION: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['vision'],0,0,'L');
	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'LUNGS: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['lungs'],0,0,'L');
	$pdf->Line(26,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2);
	$pdf->Cell(15,5,'FAR RIGHT: ',0,0,'L');
	$pdf->Cell(10);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['far_right'],0,0,'L');
	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'HEART: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['heart'],0,0,'L');
	$pdf->Line(26,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(12);
	$pdf->Cell(15,5,'LEFT: ',0,0,'L');
	$pdf->Cell(1);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['far_left'],0,0,'L');
	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(15);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'BLOOD PRESSURE : ',0,0,'L');

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'SYSTOLIC: ',0,0,'L');
	$pdf->Cell(10);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['systolic'],0,0,'L');
	$pdf->Line(31,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(13.5);
	$pdf->Cell(15,5,'EARS: ',0,0,'L');
	$pdf->Cell(-1);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['ears'],0,0,'L');
	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DIASTOLIC: ',0,0,'L');
	$pdf->Cell(10);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['diastolic'],0,0,'L');
	$pdf->Line(32,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(7.5);
	$pdf->Cell(15,5,'HEARING: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['hearing'],0,0,'L');
	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'SITTING: ',0,0,'L');
	$pdf->Cell(10);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['sitting'],0,0,'L');
	$pdf->Line(28,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(9);
	$pdf->Cell(15,5,'THROAT: ',0,0,'L');
	$pdf->Cell(3.5);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['throat'],0,0,'L');
	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'AGILITY TESTS: ',0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['agility_test'],0,0,'L');
	$pdf->Line(42,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-2);
	$pdf->Cell(15,5,'IMMUNIZATION: ',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['immunization'],0,0,'L');
	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(120,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(120,$pdf->getY()+5,200,$pdf->getY()+5); 

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DIGESTIVE SYSTEM: ',0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['digestive_system'],0,0,'L');
	$pdf->Line(47,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-2);
	$pdf->Cell(15,5,'REMARKS: ',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['remarks'],0,0,'L');
	$pdf->Line(122,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5); 

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'GENITO-UNIRARY SYSTEM: ',0,0,'L');
	$pdf->Cell(40);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['digestive_system'],0,0,'L');
	$pdf->Line(58,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-2);
	$pdf->Cell(15,5,'RECOMMENDATIONS: ',0,0,'L');
	$pdf->Cell(25);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['remarks'],0,0,'L');
	$pdf->Line(140,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5); 

	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'URINALYSIS: ',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['urinalysis'],0,0,'L');
	$pdf->Line(34,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'SKIN: ',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['skin'],0,0,'L');
	$pdf->Line(22,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'LOCOMOTION SYSTEM: ',0,0,'L');
	$pdf->Cell(35);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['locomotion_system'],0,0,'L');
	$pdf->Line(52,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'NERVOUS SYSTEM: ',0,0,'L');
	$pdf->Cell(25);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['nervous_system'],0,0,'L');
	$pdf->Line(46,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(5);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(3);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DATE: ',0,0,'L');
	$pdf->Cell(4);
	$pdf->Cell(85,5,date('m/d/Y'),0,0,'L');
	$pdf->Line(23,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(13.5);
	$pdf->Cell(15,5,'APPLICANT : ',0,0,'L');
	$pdf->Ln(6);
	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);


	// $pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'PLACE: ',0,0,'L');
	$pdf->Cell(10);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['nervous_system'],0,0,'L');
	$pdf->Line(25,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(145);
	$pdf->Cell(15,5,'Signature ',0,0,'L');

	$pdf->Ln(20);
	$pdf->Line(70,$pdf->getY()+5,140,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(75);
	$pdf->Cell(15,5,'Name of Medical Examiner ',0,0,'L');

	$pdf->output();
	exit();

  }

  public function medicalEmployeeProfileForm($id = null) {

	$office_reference = $this->Global->OfficeReference('Medical Employee Profile');

	$medicalEmployeeProfilesTable = TableRegistry::getTableLocator()->get('MedicalEmployeeProfiles');

	$query = $medicalEmployeeProfilesTable->find()

	  ->contain(['Colleges'])

	  ->where([

		'MedicalEmployeeProfiles.visible' => 1,

		'MedicalEmployeeProfiles.id' => $id,

	  ])

	->first();

	$data = $query->toArray();

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,5);
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/iso.png',175,10,20,25);
	$pdf->Image($this->base .'/assets/img/zam.png',18,10,25,25);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');

	$pdf->SetLineWidth(0.6);
	$pdf->Line(18,$pdf->getY()+8,200,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(10);
	$pdf->Rect(175,40,32,15.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(167,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-' . @$office_reference['OfficeReference']['reference_code'],0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(114,5,'',0,0,'R');
	$pdf->Cell(68,5,'Adopted Date: '. @$office_reference['OfficeReference']['adopted'],0,0,'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(123,5,'',0,0,'R');
	$pdf->Cell(59,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'R');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(126,5,'',0,0,'R');
	$pdf->Cell(60,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'R');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'MEDICAL EXAMINATION FORM',0,0,'C');

	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'NAME: ',0,0,'L');
	$pdf->Cell(65, 5, $data['employee_name'] != null ? $data['employee_name'] : '', 0, 0, 'L');
	$pdf->Line(25,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'COLLEGE: ',0,0,'L');
	$pdf->Cell(8);

	$collegeInfo = $data['code'] . ' - ' . $data['college']['name'];
	$pdf->SetFont("Arial", '', 6);
	$pdf->Cell(85, 5, $collegeInfo, 0, 0, 'L');

	$pdf->Line(127,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'ADDRESS: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->SetFont("Arial", '', 8.5);

	$address = $data['address'];
	$pdf->Cell(85, 5, $address, 0, 0, 'L');

	$pdf->Line(31,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-3);
	$pdf->Cell(15,5,'CIVIL STATUS: ',0,0,'L');
	$pdf->Cell(13);

	$civilStatus = $data['civil_status'];
	$pdf->Cell(85, 5, $civilStatus, 0, 0, 'L');

	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'AGE: ',0,0,'L');
	// $pdf->Cell(5);

	$age = $data['age'];
	$pdf->Cell(85, 5, $age, 0, 0, 'L');

	$pdf->Line(21,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'WEIGHT: ',0,0,'L');
	$pdf->Cell(5);

	$weight = $data['weight'];
	$pdf->Cell(85, 5, $weight, 0, 0, 'L');

	$pdf->Line(127,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'HEIGHT: ',0,0,'L');
	$pdf->Cell(6);

	$height = $data['height'];
	$pdf->Cell(85, 5, $height, 0, 0, 'L');

	$pdf->Line(27,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(2);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(3);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'RESPIRATORY SYSTEM: ',0,0,'L');
	$pdf->Cell(30);

	$respiratorySystem = $data['respiratory_system'];
	$pdf->Cell(100, 5, $respiratorySystem, 0, 0, 'L');

	$pdf->Line(53,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(5);
	$pdf->Line(10,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$x = $pdf->getX();
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(15,5,'EYES: ',0,0,'L');
	$pdf->Cell(5);

	$eyes = $data['eyes'];
	$pdf->Cell(85, 5, $eyes, 0, 0, 'L');

	$pdf->Line(127,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->setXY($y,109);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(1.5);
	$pdf->Cell(15,5,'COLOR PRECEPTION: ',0,0,'L');
	$pdf->Cell(25);

	$colorPerception = $data['color_perception'];
	$pdf->Cell(85, 5, $colorPerception, 0, 0, 'L');

	$pdf->Line(143,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'FLOUROGRAPHY: ',0,0,'L');
	$pdf->Cell(20);

	$flourography = $data['flourography'];
	$pdf->Cell(85, 5, $flourography, 0, 0, 'L');

	$pdf->Line(42,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(8);
	$pdf->Cell(15,5,'VISION: ',0,0,'L');
	$pdf->Cell(5);

	$vision = $data['vision'];
	$pdf->Cell(85, 5, $vision, 0, 0, 'L');

	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'LUNGS: ',0,0,'L');
	$pdf->Cell(5);

	$lungs = $data['lungs'];
	$pdf->Cell(85, 5, $lungs, 0, 0, 'L');

	$pdf->Line(26,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2);
	$pdf->Cell(15,5,'FAR RIGHT: ',0,0,'L');
	$pdf->Cell(10);

	$farRight = $data['far_right'];
	$pdf->Cell(85, 5, $farRight, 0, 0, 'L');

	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'HEART: ',0,0,'L');
	$pdf->Cell(5);

	$heart = $data['heart'];
	$pdf->Cell(85, 5, $heart, 0, 0, 'L');

	$pdf->Line(26,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(12);
	$pdf->Cell(15,5,'LEFT: ',0,0,'L');
	$pdf->Cell(1);

	$farLeft = $data['far_left'];
	$pdf->Cell(85, 5, $farLeft, 0, 0, 'L');

	$pdf->Line(129,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(15);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'BLOOD PRESSURE : ',0,0,'L');

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'SYSTOLIC: ',0,0,'L');
	$pdf->Cell(10);

	$systolic = $data['systolic'];
	$pdf->Cell(85, 5, $systolic, 0, 0, 'L');

	$pdf->Line(31,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(13.5);
	$pdf->Cell(15,5,'EARS: ',0,0,'L');
	$pdf->Cell(-1);

	$ears = $data['ears'];
	$pdf->Cell(85, 5, $ears, 0, 0, 'L');

	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DIASTOLIC: ',0,0,'L');
	$pdf->Cell(10);

	$diastolic = $data['diastolic'];
	$pdf->Cell(85, 5, $diastolic, 0, 0, 'L');

	$pdf->Line(32,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(7.5);
	$pdf->Cell(15,5,'HEARING: ',0,0,'L');
	$pdf->Cell(5);

	$hearing = $data['hearing'];
	$pdf->Cell(85, 5, $hearing, 0, 0, 'L');

	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'SITTING: ',0,0,'L');
	$pdf->Cell(10);

	$sitting = $data['sitting'];
	$pdf->Cell(85, 5, $sitting, 0, 0, 'L');

	$pdf->Line(28,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(9);
	$pdf->Cell(15,5,'THROAT: ',0,0,'L');
	$pdf->Cell(3.5);

	$throat = $data['throat'];
	$pdf->Cell(85, 5, $throat, 0, 0, 'L');

	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'AGILITY TESTS: ',0,0,'L');
	$pdf->Cell(20);

	$agility_test = $data['agility_test'];
	$pdf->Cell(85, 5, $agility_test, 0, 0, 'L');

	$pdf->Line(42,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-2);
	$pdf->Cell(15,5,'IMMUNIZATION: ',0,0,'L');
	$pdf->Cell(15);

	$immunization = $data['immunization'];
	$pdf->Cell(85, 5, $immunization, 0, 0, 'L');

	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(120,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(120,$pdf->getY()+5,200,$pdf->getY()+5); 

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DIGESTIVE SYSTEM: ',0,0,'L');
	$pdf->Cell(20);

	$digestive_system = $data['digestive_system'];
	$pdf->Cell(85, 5, $digestive_system, 0, 0, 'L');

	$pdf->Line(47,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-2);
	$pdf->Cell(15,5,'REMARKS: ',0,0,'L');
	$pdf->Cell(15);

	$remarks = $data['remarks'];
	$pdf->Cell(85, 5, $remarks, 0, 0, 'L');

	$pdf->Line(122,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5); 

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'GENITO-UNIRARY SYSTEM: ',0,0,'L');
	$pdf->Cell(40);

	$digestiveSystem = $data['digestive_system'];
	$pdf->Cell(85, 5, $digestiveSystem, 0, 0, 'L');

	$pdf->Line(58,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(15,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(-2);
	$pdf->Cell(15,5,'RECOMMENDATIONS: ',0,0,'L');
	$pdf->Cell(25);

	$recommendation = $data['recommendation'];
	$pdf->Cell(85, 5, $recommendation, 0, 0, 'L');

	$pdf->Line(140,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->Line(110,$pdf->getY()+5,200,$pdf->getY()+5); 

	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'URINALYSIS: ',0,0,'L');
	$pdf->Cell(15);

	$urinalysis = $data['urinalysis'];
	$pdf->Cell(85, 5, $urinalysis, 0, 0, 'L');

	$pdf->Line(34,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'SKIN: ',0,0,'L');
	$pdf->Cell(15);

	$skin = $data['skin'];
	$pdf->Cell(85, 5, $skin, 0, 0, 'L');

	$pdf->Line(22,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'LOCOMOTION SYSTEM: ',0,0,'L');
	$pdf->Cell(35);

	$locomotion_system = $data['locomotion_system'];
	$pdf->Cell(85, 5, $locomotion_system, 0, 0, 'L');

	$pdf->Line(52,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'NERVOUS SYSTEM: ',0,0,'L');
	$pdf->Cell(25);

	$nervous_system = $data['nervous_system'];
	$pdf->Cell(85, 5, $nervous_system, 0, 0, 'L');

	$pdf->Line(46,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(5);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(3);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,205,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(20);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DATE: ',0,0,'L');
	$pdf->Cell(4);
	$pdf->Cell(85,5,date('m/d/Y'),0,0,'L');
	$pdf->Line(23,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(13.5);
	$pdf->Cell(15,5,'APPLICANT : ',0,0,'L');
	$pdf->Ln(6);
	$pdf->Line(130,$pdf->getY()+5,200,$pdf->getY()+5);


	// $pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$y = $pdf->getY();
	$pdf->Cell(15,5,'PLACE: ',0,0,'L');
	$pdf->Cell(10);

	$address = $data['address'];
	$pdf->Cell(85, 5, $address, 0, 0, 'L');
	
	$pdf->Line(25,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(145);
	$pdf->Cell(15,5,'Signature ',0,0,'L');

	$pdf->Ln(20);
	$pdf->Line(70,$pdf->getY()+5,140,$pdf->getY()+5);
	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(75);
	$pdf->Cell(15,5,'Name of Medical Examiner ',0,0,'L');

	$pdf->output();
	exit();

  }

  public function medicalEmployeeProfile(){

	$conditions = array();

	$conditions['search'] = '';

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$tmpData = $this->MedicalEmployeeProfiles->getAllMedicalEmployeeProfilePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("L", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',75,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'MEDICAL STUDENT PROFILE MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(30,5,'CODE',1,0,'C',1);
	$pdf->Cell(70,5,'EMPLOYEE NAME',1,0,'C',1);
	$pdf->Cell(60,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(33,5,'AGE',1,0,'C',1);
	$pdf->Cell(33,5,'HEIGHT',1,0,'C',1);
	$pdf->Cell(30,5,'WEIGHT',1,0,'C',1);
	$pdf->Cell(70,5,'REMARKS',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,30,70,60,33,33,30,70));
	$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));

	if(!empty($tmpData)){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  $data['employee_name'],

		  $data['address'],

		  $data['age'],

		  $data['height'],

		  $data['weight'],

		  $data['remarks']

		));

	  }

	}else{

	  $pdf->Cell(341,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+155,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+190,$pdf->getY()+2,$pdf->getX()+341,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function nurseProfile(){

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$tmpData = $this->NurseProfiles->getAllNurseProfilePrint($conditions);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 9);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 9);
	$pdf->Cell(0,5,'NURSE PROFILE MANAGEMENT',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(15,5,'No.',1,0,'C',1);
	$pdf->Cell(70,5,'NURSE NAME',1,0,'C',1);
	$pdf->Cell(50,5,'ADDRESS',1,0,'C',1);
	$pdf->Cell(35,5,'AGE',1,0,'C',1);
	$pdf->Cell(35,5,'BIRTHDATE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(15,70,50,35,35));
	$pdf->SetAligns(array('C','C','C','C','C'));

	if(count($tmpData)>0){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['name'],

		  $data['address'],

		  $data['age'],

		  fdate($data['birthdate'],'m/d/Y')

		));

	  }

	}else{

	  $pdf->Cell(330,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+85,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+117,$pdf->getY()+2,$pdf->getX()+205,$pdf->getY()+2);

	$pdf->output();
	exit();

  }

  public function medicalHistoryForm($id = null) {

	$office_reference = $this->Global->OfficeReference('Medical Student Profile');

	 $data['MedicalStudentProfile'] = $this->MedicalStudentProfiles->find()

	->contain([

	  'MedicalStudentProfileImages' => [

		'conditions' => [

		  'MedicalStudentProfileImages.visible' => 1

		],

	  ],

	  'CollegePrograms',

	  'YearLevelTerms'

	])

	->where([

		'MedicalStudentProfiles.visible' => 1,

		'MedicalStudentProfiles.id' => $id,

	])

	->first();

	// debug($data['MedicalStudentProfile'])

	$data['MedicalStudentProfileImage'] = $data['MedicalStudentProfile']['medical_student_profile_images'];

	$data['CollegeProgram'] = $data['MedicalStudentProfile']['college_program'];

	$data['YearLevelTerm'] = $data['MedicalStudentProfile']['year_level_term'];

	unset($data['MedicalStudentProfile']['medical_student_profile_images']);

	unset($data['MedicalStudentProfile']['year_level_term']);

	unset($data['MedicalStudentProfile']['college_program']);

	$data['MedicalStudentProfile']['have'] = $data['MedicalStudentProfile']['treatment']!= null ? explode(',',$data['MedicalStudentProfile']['treatment']) : explode(',','0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0');

	if (!empty($data['MedicalStudentProfile']['have'])){

	  foreach ($data['MedicalStudentProfile']['have'] as $key => $value) {
		
		$data['MedicalStudentProfile']['have'][$key] = $data['MedicalStudentProfile']['have'][$key] == 1 ? true: false;

	  }

	}

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,5);
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/iso.png',175,10,20,25);
	$pdf->Image($this->base .'/assets/img/zam.png',18,10,25,25);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');

	$pdf->Ln(10);
	$pdf->Rect(176,40,32,15.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(167,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-' . @$office_reference['OfficeReference']['medical_student_history_reference'],0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(114,5,'',0,0,'R');
	$pdf->Cell(68,5,'Adopted Date: '. @$office_reference['OfficeReference']['adopted'],0,0,'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(123,5,'',0,0,'R');
	$pdf->Cell(59,5,'Revision Date: '. @$office_reference['OfficeReference']['revision_date'],0,0,'R');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(126,5,'',0,0,'R');
	$pdf->Cell(60,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'R');
	$pdf->Ln(-2);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'EXAMINATION FORM',0,0,'C');

	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'NAME: ',0,0,'L');
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['student_name'],0,0,'L');
	$pdf->Line(25,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'DATE: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,date('F d, Y'),0,0,'L');
	$pdf->Line(118,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'ADDRESS: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['address'],0,0,'L');
	$pdf->Line(31,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'AGE: ',0,0,'L');
	$pdf->Cell(-2);
	$pdf->Cell(85,5,$data['MedicalStudentProfile']['age'],0,0,'L');
	$pdf->Line(118,$pdf->getY()+5,130,$pdf->getY()+5);

	$pdf->setXY(130,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'COURSE & YEAR: ',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(85,5,$data['CollegeProgram']['code'] . ' - ' . $data['YearLevelTerm']['description'],0,0,'L');
	$pdf->Line(162,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(15);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'MEDICAL HISTORY',0,0,'C');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'Please "X" each box if the answer YES, leave blank if NO. ',0,0,'L');

	$pdf->Ln(8);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'Have you had : ',0,0,'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][0])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'A recent physical exam', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][9])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Sinusitis', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][1])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Any heart problem', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][10])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Diabetes', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][2])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'High Blood pressure', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][11])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Epilepsy', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][3])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Low Blood pressure', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][12])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Malignancies', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][4])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Circulatory problems', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][13])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Rheumatic Fever', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][5])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Nervous problems', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][14])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Thyroid', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][6])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Radiation Treatments', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][15])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Tuberculosis', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][7])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Excessive Bleeding', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][16])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Hepatitis', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][8])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Anemia', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalStudentProfile']['have'][17])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Venereal Disease', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'On previous visits : ',0,0,'L');

	$pdf->Ln(8);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'Have you had any outward reaction during or after procedure',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(5);
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['reaction_procedure'],0,0,'L');
	$pdf->Line(10,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'Were X-ray given? ',0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['x_ray'],0,0,'L');
	$pdf->Line(38.5,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'Were there any special problem? ',0,0,'L');
	$pdf->Cell(42);
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['special_problem'],0,0,'L');
	$pdf->Line(61,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'ALLERGY TO : ',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'Penicillin: ',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'Local Aesthetics (Novacain, Procaine, etc.): ',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'Were there any special problem? ',0,0,'L');
	$pdf->Cell(42);
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['allergy'],0,0,'L');
	$pdf->Line(66,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->MultiCell(200,5,
	  'Please describe any current medical treatment, including drugs, impending operationsm pregnancies, or other information regarding your present health health that the doctor should be aware of it  ',0,1);
	$pdf->Cell(10);
	$pdf->Cell(65,5,$data['MedicalStudentProfile']['current_medical_treatment'],0,0,'L');
	$pdf->Line(10,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(5);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,200,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(2);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,200,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(15);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'CLINICAL EXAMINATION',0,0,'C');

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'CHIEF COMPLAINTS : ',0,0,'L');
	$pdf->Line(46,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'HISTORY OF CHIEF COMPLAINTS : ',0,0,'L');
	$pdf->Line(68,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'CLINICAL FINDINGS : ',0,0,'L');
	$pdf->Line(45,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'X-RAY : ',0,0,'L');
	$pdf->Line(24,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DIAGNOSIS : ',0,0,'L');
	$pdf->Line(32,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'TREATMENT : ',0,0,'L');
	$pdf->Line(34,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(50);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(35,5,'',0,0,'L');
	$pdf->Cell(10,5,'ORAL HEALTH CONDITION',0,0,'C');
	$pdf->Cell(101,5,'',0,0,'L');
	$pdf->Cell(10,5,'DENTAL HEALTH CONDITION',0,0,'C');
	$pdf->Ln(10);

	$dentalImages = [];

	if (!empty($data['MedicalStudentProfileImage'])) {
		foreach ($data['MedicalStudentProfileImage'] as $image) {
			if (!is_null($image['images'])) {
				$dentalImages[] = [
					'imageSrc' => '/uploads/medical-student-profile/' . $id . '/' . $image['images'],
					'name' => $image['images'],
					'id' => $image['id'] ?? null,
				];
			}
		}
	}

	function isImageFile($file)
	  {
		  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
		  $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		  return in_array($fileExtension, $allowedExtensions) && getimagesize('../webroot' . $file['imageSrc']);
	  }

	  $xPosition = 125;
	  $yPosition = 20;
	  $imageCount = 0;
	  $imageLimit = 2; // Set the limit to 2 images

	  if (!empty($dentalImages)) {
		  foreach ($dentalImages as $img) {
			  if (isImageFile($img)) {
				  $imageCount++;
				  $pdf->Image($this->base . $img['imageSrc'], $xPosition, $yPosition, 70, 35);
				  $yPosition += 37;
				  if ($imageCount == $imageLimit) {
					  break; // Stop adding images after reaching the limit
				  }
				  if ($imageCount % 2 === 0) {
					  // $xPosition = 115;
					  $yPosition += 37;
				  }
			  }
		  }
	  }

	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(41,8,' DATE:',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CARIES',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' GINGIVITIS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' P. POCKETS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' DEBRIS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CALCULUS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' NEOPLASM',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CLEFT LIP',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' OTHERS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->SetFont("Arial", 'B', 8.5);
	$pdf->Ln(70);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(9,5,utf8_decode('Ø'),0,0,'L');
	$pdf->Cell(10,5,'CAVITY',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(10,5,'O',0,0,'L');
	$pdf->Cell(10,5,'FILLING',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(19,5,'/',0,0,'L');
	$pdf->Cell(10,5,'INDICATED FOR EXO',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(13,5,'X',0,0,'L');
	$pdf->Cell(10,5,'EXTRACTED',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(11,5,'S',0,0,'L');
	$pdf->Cell(10,5,'SEALANT',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(15,5,'T.F.',0,0,'L');
	$pdf->Cell(10,5,'TEMP. FILLING',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(13,5,'UN',0,0,'L');
	$pdf->Cell(10,5,'UNRUPTED',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(13,5,'3',0,0,'L');
	$pdf->SetFont("Arial", 'B', 8.5);
	$pdf->Cell(10,5,'CARIES FREE',0,0,'C');
  
	$pdf->output();
	exit();

  }

  public function medicalHistoryFormEmployee($id = null) {

	$office_reference = $this->Global->OfficeReference('Medical Employee Profile');

	$data['MedicalEmployeeProfile'] = $this->MedicalEmployeeProfiles->find('all')
	->where([
		'visible' => 1,
		'id' => $id,
	])
	->first();

	$data['MedicalEmployeeProfile']['have'] = explode(',',$data['MedicalEmployeeProfile']['treatment']);

	if (!empty($data['MedicalEmployeeProfile']['have'])){

	  foreach ($data['MedicalEmployeeProfile']['have'] as $key => $value) {
		
		$data['MedicalEmployeeProfile']['have'][$key] = $data['MedicalEmployeeProfile']['have'][$key] == 1 ? true: false;

	  }

	}

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(10,10,5);
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/iso.png',175,10,20,25);
	$pdf->Image($this->base .'/assets/img/zam.png',18,10,25,25);
	$pdf->SetFont("Times", 'B', 10);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');

	$pdf->Ln(10);
	$pdf->Rect(177,40,32,15.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(167,5,'',0,0,'L');
	$pdf->Cell(68,5,'ZSCMST-' . @$office_reference['OfficeReference']['medical_employee_history_reference'],0,0,'L');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(114,5,'',0,0,'R');
	$pdf->Cell(68,5,'Adopted Date: '. @$office_reference['OfficeReference']['adopted'],0,0,'R');
	$pdf->Ln(2.5);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(123,5,'',0,0,'R');
	$pdf->Cell(59,5,'Revision Date: '. @$office_reference['OfficeReference']['reference_code'],0,0,'R');
	$pdf->Ln(3);
	$pdf->SetFont("Times", '', 5.5);
	$pdf->Cell(126,5,'',0,0,'R');
	$pdf->Cell(60,5,'Revision Status: '. @$office_reference['OfficeReference']['revision_status'],0,0,'R');
	$pdf->Ln(-2);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'EXAMINATION FORM',0,0,'C');

	$pdf->Ln(11);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'NAME: ',0,0,'L');
	$pdf->Cell(65,5,$data['MedicalEmployeeProfile']['employee_name'],0,0,'L');
	$pdf->Line(25,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'DATE: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(85,5,date('F d, Y'),0,0,'L');
	$pdf->Line(118,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'ADDRESS: ',0,0,'L');
	$pdf->Cell(5);
	$pdf->Cell(65,5,$data['MedicalEmployeeProfile']['address'],0,0,'L');
	$pdf->Line(31,$pdf->getY()+5,100,$pdf->getY()+5);

	$pdf->setXY(105,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'AGE: ',0,0,'L');
	$pdf->Cell(-2);
	$pdf->Cell(85,5,$data['MedicalEmployeeProfile']['age'],0,0,'L');
	$pdf->Line(118,$pdf->getY()+5,130,$pdf->getY()+5);

	$pdf->setXY(130,$y);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(15,5,'COURSE & YEAR: ',0,0,'L');
	$pdf->Cell(15);
	$pdf->Cell(85,5,'',0,0,'L');
	$pdf->Line(162,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(15);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'MEDICAL HISTORY',0,0,'C');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'Please "X" each box if the answer YES, leave blank if NO. ',0,0,'L');

	$pdf->Ln(8);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'Have you had : ',0,0,'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][0])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'A recent physical exam', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][9])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Sinusitis', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][1])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Any heart problem', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][10])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Diabetes', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][2])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'High Blood pressure', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][11])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Epilepsy', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][3])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Low Blood pressure', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][12])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Malignancies', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][4])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Circulatory problems', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][13])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Rheumatic Fever', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][5])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Nervous problems', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][14])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Thyroid', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][6])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Radiation Treatments', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][15])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Tuberculosis', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][7])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Excessive Bleeding', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][16])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Hepatitis', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(8);
	$check = "";
	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][8])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Anemia', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Cell(35);
	if ($data['MedicalEmployeeProfile']['have'][17])
	  $check = "4";
	else $check = "";
	$pdf->SetFont('ZapfDingbats', '', 10);
	$pdf->Cell(6, 6, $check, 1, 0, 'C');
	$pdf->SetFont("Arial", '', 8);
	$pdf->Cell(2, 5, '', 0, 0, 'L');
	$pdf->Cell(25, 5, 'Venereal Disease', 0, 0, 'L');
	$pdf->Cell(5, 5, '', 0, 0, 'L');

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'On previous visits : ',0,0,'L');

	$pdf->Ln(8);
	$pdf->SetFont("Arial", '', 10);
	$pdf->Cell(0,5,'Have you had any outward reaction during or after procedure',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(5);
	$pdf->Cell(65,5,$data['MedicalEmployeeProfile']['reaction_procedure'],0,0,'L');
	$pdf->Line(10,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'Were X-ray given? ',0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(65,5,$data['MedicalEmployeeProfile']['x_ray'],0,0,'L');
	$pdf->Line(38.5,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'Were there any special problem? ',0,0,'L');
	$pdf->Cell(42);
	$pdf->Cell(65,5,$data['MedicalEmployeeProfile']['special_problem'],0,0,'L');
	$pdf->Line(61,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'ALLERGY TO : ',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'Penicillin: ',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'Local Aesthetics (Novacain, Procaine, etc.): ',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont("Arial", '', 9.5);
	$pdf->Cell(6);
	$pdf->Cell(15,5,'Were there any special problem? ',0,0,'L');
	$pdf->Cell(42);
	$pdf->Cell(65,5,$data['MedicalEmployeeProfile']['allergy'],0,0,'L');
	$pdf->Line(66,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->MultiCell(200,5,
	  'Please describe any current medical treatment, including drugs, impending operationsm pregnancies, or other information regarding your present health health that the doctor should be aware of it  ',0,1);
	$pdf->Cell(10);
	$pdf->Cell(65,5,$data['MedicalEmployeeProfile']['current_medical_treatment'],0,0,'L');
	$pdf->Line(10,$pdf->getY()+5,200,$pdf->getY()+5);

	$pdf->Ln(5);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,200,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);
	$pdf->Ln(2);
	$pdf->SetLineWidth(0.6);
	$pdf->Line(10,$pdf->getY()+8,200,$pdf->getY()+8);
	$pdf->SetLineWidth(0.2);

	$pdf->Ln(15);
	$pdf->SetFont("Arial", 'BU', 10);
	$pdf->Cell(0,5,'CLINICAL EXAMINATION',0,0,'C');

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'CHIEF COMPLAINTS : ',0,0,'L');
	$pdf->Line(46,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'HISTORY OF CHIEF COMPLAINTS : ',0,0,'L');
	$pdf->Line(68,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'CLINICAL FINDINGS : ',0,0,'L');
	$pdf->Line(45,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'X-RAY : ',0,0,'L');
	$pdf->Line(24,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'DIAGNOSIS : ',0,0,'L');
	$pdf->Line(32,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(6);
	$pdf->SetFont("Arial", '', 9.5);
	$y = $pdf->getY();
	$pdf->Cell(15,5,'TREATMENT : ',0,0,'L');
	$pdf->Line(34,$pdf->getY()+5,170,$pdf->getY()+5);

	$pdf->Ln(50);
	$pdf->SetFont("Arial", 'B', 11);
	$pdf->Cell(35,5,'',0,0,'L');
	$pdf->Cell(10,5,'ORAL HEALTH CONDITION',0,0,'C');
	$pdf->Cell(101,5,'',0,0,'L');
	$pdf->Cell(10,5,'DENTAL HEALTH CONDITION',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Arial", '', 11);
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(41,8,' DATE:',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CARIES',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' GINGIVITIS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' P. POCKETS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' DEBRIS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CALCULUS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' NEOPLASM',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' CLEFT LIP',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(2.5,5,'',0,0,'L');
	$pdf->Cell(41,8,' OTHERS',1,0,'L',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->Cell(9,8,'',1,0,'C',1);
	$pdf->SetFont("Arial", 'B', 8.5);
	$pdf->Ln(70);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(9,5,utf8_decode('Ø'),0,0,'L');
	$pdf->Cell(10,5,'CAVITY',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(10,5,'O',0,0,'L');
	$pdf->Cell(10,5,'FILLING',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(19,5,'/',0,0,'L');
	$pdf->Cell(10,5,'INDICATED FOR EXO',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(13,5,'X',0,0,'L');
	$pdf->Cell(10,5,'EXTRACTED',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(11,5,'S',0,0,'L');
	$pdf->Cell(10,5,'SEALANT',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(15,5,'T.F.',0,0,'L');
	$pdf->Cell(10,5,'TEMP. FILLING',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->Cell(13,5,'UN',0,0,'L');
	$pdf->Cell(10,5,'UNRUPTED',0,0,'C');
	$pdf->Ln(4);
	$pdf->Cell(135,5,'',0,0,'L');
	$pdf->SetFont('ZapfDingbats','', 10);
	$pdf->Cell(13,5,'3',0,0,'L');
	$pdf->SetFont("Arial", 'B', 8.5);
	$pdf->Cell(10,5,'CARIES FREE',0,0,'C');
  
	$pdf->output();
	exit();

  }

  public function exportRegisteredStudents(){

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

	}  

	//advance search

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

	}

	$conditions['year_term_id'] = " AND Student.year_term_id IS NULL";

	if ($this->request->getQuery('year_term_id')) {

	  $year_term_id = $this->request->getQuery('year_term_id'); 

	  $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

	}

	$tmpData = $this->RegisteredStudents->getAllRegisteredStudentPrint($conditions);

	$datas = array();

	if(!empty($tmpData)){

	  foreach ($tmpData as $data) {

		$datas[] = array(

		  'id'          => $data['student_id'],

		  'full_name'   => $data['full_name'],

		  'student_no'  => $data['student_no'],

		  'college'     => $data['college'],

		  'program'     => $data['program'],

		  'email'       => $data['email'],

		  'contact_no'  => $data['contact_no'],

		  'year'        => $data['description']

		);

	  }

	}

	$this->set(compact('datas'));

  }

  public function barcode() {

	$conditions = [];

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	}
	
	$tmpData = $this->Bibliographies->getAllBibliographyPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base .'/assets/img/zam2.png',5,10,25,25);
	$pdf->Image($this->base .'/assets/img/iso.png',185,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'BIBLIOGRAPHY BARCODE',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(80,5,'CONTROL NO.',1,0,'C',1);
	$pdf->Cell(113,5,'TITLE',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,80,113));
	$pdf->SetAligns(array('C','C','L'));

	if(!$datas->isEmpty()){

	  foreach ($tmpData as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['code'],

		  strtoupper($data['title']),

		));

	  }

	}else{

	  $pdf->Cell(203,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+203,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function callNumber() {

	$conditions = [];

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	}
	
	$tmpData = $this->Bibliographies->getAllBibliographyPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam.png',5,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'BIBLIOGRAPHY CALL NUMBER',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(113,5,'TITLE',1,0,'C',1);
	$pdf->Cell(80,5,'CALL NUMBER ',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,113,80));
	$pdf->SetAligns(array('C','C','L','C','C','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  strtoupper($data['title']),

		  $data['call_number1'] . ', ' . $data['call_number2'] . ', ' . $data['call_number3']

		));

	  }

	}else{

	  $pdf->Cell(203,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+203,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function catalog() {

	$conditions = [];

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	}
	
	$tmpData = $this->Bibliographies->getAllBibliographyPrint($conditions);

	$datas = new Collection($tmpData);

	$full_name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

	require("wordwrap.php");
	$pdf = new ConductPDF();
	$pdf->SetMargins(5,10,5);
	$pdf->SetFooter(true);
	$pdf->footerSystem = true;
	$pdf->AliasNbPages();
	$pdf->AddPage("P", "legal", 0);
	$pdf->Image($this->base.'/assets/img/zam2.png',5,10,25,25);
	$pdf->Image($this->base.'/assets/img/iso.png',185,10,25,25);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'Republic of the Philippines',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,strtoupper($this->Global->Settings('lgu_name')),0,0,'C');
	$pdf->Ln(5);
	$pdf->SetFont("Times", '', 10);
	$pdf->Cell(0,5,$this->Global->Settings('address'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('telephone'),0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,5,$this->Global->Settings('website').' Email: '.$this->Global->Settings('email'),0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0,5,'BIBLIOGRAPHY CATALOG',0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->SetFillColor(217,237,247);
	$pdf->Cell(10,5,'#',1,0,'C',1);
	$pdf->Cell(113,5,'TITLE',1,0,'C',1);
	$pdf->Cell(80,5,'CATALOG',1,0,'C',1);
	$pdf->Ln();
	$pdf->SetFont("Times", '', 8);
	$pdf->SetWidths(array(10,113,80));
	$pdf->SetAligns(array('C','L','C'));

	if(!$datas->isEmpty()){

	  foreach ($datas as $key => $data){

		$pdf->RowLegalL(array(

		  $key + 1,

		  $data['title'],

		  strtoupper($data['collection_type']),

		));

	  }

	}else{

	  $pdf->Cell(203,5,'No data available.',1,1,'C');

	}

	$pdf->Ln(5);
	$pdf->SetDash(2.5,1.5);
	$pdf->SetFont("Times", 'B', 8);
	$pdf->Cell(0,5,'* Nothing to follow *',0,0,'C');
	$pdf->Ln(0.1);
	$pdf->Line($pdf->getX(),$pdf->getY()+2,$pdf->getX()+88,$pdf->getY()+2);
	$pdf->Line($pdf->getX()+120,$pdf->getY()+2,$pdf->getX()+203,$pdf->getY()+2);
	$pdf->SetDash();

	$pdf->output();
	exit();

  }

  public function export_member() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(Member.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}

	if (isset($this->request->query['college'])) {

	  $college_id = $this->request->query['college'];

	  $conditions['advSearch'] = "AND Member.college_id = $college_id";

	}

	if (isset($this->request->query['program'])) {

	  $program_id = $this->request->query['program'];

	  $conditions['advSearch'] = "AND Member.program_id = $program_id";

	}

	if (isset($this->request->query['faculty_status'])) {

	  $faculty_status = $this->request->query['faculty_status'];

	  $conditions['faculty_status'] = "AND Member.faculty_status = '$faculty_status'";

	}

	$conditions['member_type'] = '';

	if (isset($this->request->query['member_type'])) {

	  $member_type = $this->request->query['member_type'];

	  $conditions['member_type'] = "AND Member.member_type = '$member_type'";

	}

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(Member.date) >= '$start' AND DATE(Member.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->Member->query($this->Member->getAllMember($conditions));

	$datas = array();

	if(!empty($tmpData)){

	  foreach ($tmpData as $data) {

		$datas[] = array(

		  'library_id_number' => $data['Member']['library_id_number'],

		  'member_name' => $data['Member']['member_name'],

		  'member_type' => $data['Member']['member_type'],

		  'program' => $data['CollegeProgram']['name'],

		  'year_level' => $data['Member']['year_level'],

		  'date' => fdate($data['Member']['date'],'m/d/Y'),

		);

	  }

	}

	$this->set(compact('datas'));

  }

  public function exportMemberFaculty() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if($this->request->getQuery('search')){

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->getQuery('date');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) = '$search_date'"; 

	}

	if ($this->request->getQuery('college')) {

	  $college_id = $this->request->getQuery('college');

	  $conditions['advSearch'] = "AND LearningResourceMember.college_id = $college_id";

	}

	if ($this->request->getQuery('program')) {

	  $program_id = $this->request->getQuery('program');

	  $conditions['advSearch'] = "AND LearningResourceMember.program_id = $program_id";

	}

	$conditions['classification'] = '';

	if ($this->request->getQuery('classification')) {

	  $classification = $this->request->getQuery('classification');

	  $conditions['classification'] = "AND LearningResourceMember.classification = '$classification'";

	}

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(LearningResourceMember.date) >= '$start' AND DATE(LearningResourceMember.date) <= '$end'";

	}

	$dataTable = $this->LearningResourceMembers;

	$tmpData = $dataTable->getAllLearningResourceMemberPrint($conditions);

	$datas = array();

	if(!empty($tmpData)){

	  foreach ($tmpData as $data) {

		$datas[] = array(

		  'library_id_number' => $data['library_id_number'],

		  'employee_name' => $data['employee_name'],

		  'faculty_status' => $data['faculty_status'],

		  'office' => $data['office'],

		  'date' => fdate($data['date'],'m/d/Y'),

		);

	  }

	}

	$this->set(compact('datas'));

  }

  public function export_member_admin() {

	$conditions = array();

	$conditions['search'] = '';

	// search conditions

	if(isset($this->request->query['search'])){

	  $search = $this->request->query['search'];

	  $search = strtolower($search);

	  $conditions['search'] = $search;

	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(Member.date) = '$search_date'"; 

	  $dates['date'] = $search_date;

	}

	$conditions['member_type'] = '';

	if (isset($this->request->query['member_type'])) {

	  $member_type = $this->request->query['member_type'];

	  $conditions['member_type'] = "AND Member.member_type = '$member_type'";

	}

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(Member.date) >= '$start' AND DATE(Member.date) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}

	$tmpData = $this->Member->query($this->Member->getAllMember($conditions));

	$datas = array();

	if(!empty($tmpData)){

	  foreach ($tmpData as $data) {

		$datas[] = array(

		  'library_id_number' => $data['Member']['library_id_number'],

		  'member_name' => $data['Member']['member_name'],

		  'member_type' => $data['Member']['member_type'],

		  'program' => $data['CollegeProgram']['name'],

		  'date' => fdate($data['Member']['date'],'m/d/Y'),

		);

	  }

	}

	$this->set(compact('datas'));

  }

  public function exportBibliography() {

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if ($this->request->getQuery('date')) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if ($this->request->getQuery('startDate')) {

	  $start = $this->request->getQuery('startDate'); 

	  $end = $this->request->getQuery('endDate');

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}
	
	$tmpData = $this->Bibliographies->getAllBibliographyPrint($conditions);

	$datas = array();

	if(!empty($tmpData)){

	  foreach ($tmpData as $data) {

		$datas[] = array(

		  'code' => $data['code'],

		  'title' => strtoupper($data['title']),

		  'author' => $data['author'],

		  'material_type' => $data['material_type'], 

		  'collection_type' => $data['collection_type'],

		  'date_of_publication' => fdate($data['date_of_publication'],'m/d/Y'),

		);

	  }

	}

	$this->set(compact('datas'));

  }

  public function export_inventory_bibliography() {

	$conditions = array();

	$conditions['search'] = '';

	if ($this->request->getQuery('search')) {

	  $search = $this->request->getQuery('search');

	  $search = strtolower($search);

	  $conditions['search'] = $search;
	
	}

	$conditions['date'] = '';

	if (isset($this->request->query['date'])) {

	  $search_date = $this->request->query['date'];

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

	  $dates['date'] = $search_date;

	} 

	if (isset($this->request->query['startDate'])) {

	  $start = $this->request->query['startDate']; 

	  $end = $this->request->query['endDate'];

	  $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

	  $dates['startDate'] = $start;

	  $dates['endDate']   = $end;

	}
	
	$tmpData = $this->Bibliography->query($this->Bibliography->getAllBibliography($conditions));

	$datas = array();

	if(!empty($tmpData)){

	  foreach ($tmpData as $data) {

		$datas[] = array(

		  'code' => $data['Bibliography']['code'],

		  'title' => strtoupper($data['Bibliography']['title']),

		  'author' => $data['Bibliography']['author'],

		);

	  }

	}

	$this->set(compact('datas'));

  }

  public function onlinePayment($id = null){

	$data = $this->RequestForm->get($id);

	$student = $this->Students->get($data['student_id']);

	// $student = Set::extract('Student',$this->Student->findById($data['RequestForm']['student_id']));

	$data['Student'] = $student;

	$this->set(compact('data'));

  }

}