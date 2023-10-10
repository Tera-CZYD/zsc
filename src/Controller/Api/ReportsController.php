<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
 

class ReportsController extends AppController {



	public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Reports = TableRegistry::getTableLocator()->get('Reports');

    $this->ItemIssuance = TableRegistry::getTableLocator()->get('ItemIssuances');

    $this->InventoryProperty = TableRegistry::getTableLocator()->get('InventoryProperties');

    $this->CheckOutSub = TableRegistry::getTableLocator()->get('CheckOutSubs');

    $this->CheckInSub = TableRegistry::getTableLocator()->get('CheckInSubs');

  }

  public function studentClubList(){

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['club_id'] = 'AND StudentClub.club_id IS NULL';

    $club_id = $this->request->getQuery('club_id');

    if ($club_id !== null) {

      $conditions['club_id'] = " AND StudentClub.club_id = $club_id";

      $conditionsPrint .= '&club_id=' . $club_id;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllStudentClubList($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'student-club-list'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $student_club_lists = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($student_club_lists as $data) {

      $datas[] = array(

        'student_no'   => $data['student_no'],

        'student_name'   => $data['full_name'],

        'college'   => $data['name'],

        'year'   => $data['year'],

        'program'   => $data['program_name'],

        'position'   => $data['position'],

        'club'   => $data['title'],

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

  public function promotedStudent() {

    //with pagination

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    // search conditions

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['program_id'] = 0;

    if ($this->request->getQuery('program_id') != null) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND Student.program_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

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

      $conditions['year'] = " AND StudentEnrolledCourse.year_term_id = $year";

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllPromotedStudent($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'promoted-student'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $main = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = array();

    if(!empty($main)){

      foreach ($main as $data) {

        $datas[] = array(

          'id'          => $data['id'],

          'student_name'   => $data['full_name'],

          'student_no'  => $data['student_no'],

          'program'     => $data['program'],

          'ave'     => $data['ave'],

        );

      }

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

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

  }

  public function studentRanking() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions = [];
    $conditionsPrint = '';

    if ($this->request->getQuery('program_id')) {
      $program_id = $this->request->getQuery('program_id');
      $conditions['program_id'] = " AND Student.program_id = $program_id";
      $conditionsPrint .= '&program_id=' . $program_id;
    }

    if ($this->request->getQuery('year_term_id')) {
      $year_term_id = $this->request->getQuery('year_term_id');
      $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";
      $conditionsPrint .= '&year_term_id=' . $year_term_id;
    }

    if ($this->request->getQuery('year')) {
      $year = $this->request->getQuery('year');
      if ($year == 1) {
          $y1 = '1';
          $y2 = '2';
      } elseif ($year == 2) {
          $y1 = '4';
          $y2 = '5';
      } elseif ($year == 3) {
          $y1 = '7';
          $y2 = '8';
      } elseif ($year == 4) {
          $y1 = '10';
          $y2 = '11';
      } elseif ($year == 5) {
          $y1 = '13';
          $y2 = '14'; 
      }

      $conditions['year'] = " AND (StudentEnrolledCourse.year_term_id = $y1 OR StudentEnrolledCourse.year_term_id = $y2) ";
      $conditionsPrint .= '&year=' . $y1 . '&year=' . $y2;
    }


    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllStudentRanking($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'student-ranking'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $student_rankings = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($student_rankings as $data) {

      $datas[] = array(

        'id'          => $data['id'],

        'student_name'   => $data['full_name'],

        'student_no'  => $data['student_no'],

        'college'     => $data['college'],

        'program'     => $data['program'],

        'ave'     => $data['ave'],

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

  public function listAcademicAwardees() {

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['college_id'] = 'AND Student.college_id IS NULL';

    $college_id = $this->request->getQuery('college_id');

    if ($college_id !== null) {

      $conditions['college_id'] = " AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id=' . $college_id;

    }

    if ($this->request->getQuery('program_id')) {

      $program_id = $this->request->getQuery('program_id');

      $conditions['program_id'] = " AND Student.program_id = $program_id";

      $conditionsPrint .= '&program_id=' . $program_id;

    }

    if ($this->request->getQuery('year_term_id')) {

      $year_term_id = $this->request->getQuery('year_term_id');

      $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

      $conditionsPrint .= '&year_term_id=' . $year_term_id;

    }

    if ($this->request->getQuery('year')) {

      $year = $this->request->getQuery('year');

      if ($year == 1) {
          $y1 = '1';
          $y2 = '2';
      } elseif ($year == 2) {
          $y1 = '4';
          $y2 = '5';
      } elseif ($year == 3) {
          $y1 = '7';
          $y2 = '8';
      } elseif ($year == 4) {
          $y1 = '10';
          $y2 = '11';
      } elseif ($year == 5) {
          $y1 = '13';
          $y2 = '14'; 
      }

      $conditions['year'] = " AND (StudentEnrolledCourse.year_term_id = $y1 OR StudentEnrolledCourse.year_term_id = $y2) ";

      $conditionsPrint .= '&year=' . $y1 . '&year=' . $y2;

    }

    $conditions['award'] = "";

    if ($this->request->getQuery('award')) {

      $award = $this->request->getQuery('award');
      
      if ($award == 1) {

        $conditions['award'] = "AND StudentEnrolledCourse.final_grade BETWEEN 1.00 AND 1.30";

      } else if ($award == 2) {

        $conditions['award'] = "AND StudentEnrolledCourse.final_grade BETWEEN 1.40 AND 1.50";

      }
      
      $conditionsPrint .= '&award='.$award;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllListAcademicAwardee($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'list-academic-awardees'

      ],

      'page' => $page,

      'limit' => $limit

    ]);
    
    $list_academic_awardees = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($list_academic_awardees as $data) {

      $datas[] = array(

        'id' => $data['id'],

        'student_name' => $data['full_name'],

        'college' => $data['college'],

        'program' => $data['program'],

        'ave' => $data['ave'],

        'award' => $data['award'],

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


  public function facultyMasterlists() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['college_id'] = "AND Employee.college_id IS NULL";

    if ($this->request->getQuery('college_id')) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND Employee.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllFacultyMasterlist($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'faculty-masterlist'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $faculty_masterlists = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($faculty_masterlists as $data) {

      $datas[] = array(

          'id'            => $data['id'],
          
          'code'  		  => $data['code'],

          'faculty_name'  => $data['full_name'],

          'gender'        => $data['gender'],

          'academic_rank' => $data['rank'],

          'college'       => $data['college'],

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

  public function academicList(){

    // default page 1

    $page = $this->request->getQuery('page', 1);
    
    // default conditions

    $conditionsPrint = '';

    $conditions = array();

    $conditions['search'] = '';

    // search conditions

    if($this->request->getQuery('search')!=null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')!=null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(AwardeeManagement.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')!=null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(AwardeeManagement.date) >= '$start' AND DATE(AwardeeManagement.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['college_id'] = '';

    if ($this->request->getQuery('college_id')!=null) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND AwardeeManagement.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['program_id'] = '';

    if ($this->request->getQuery('program_id')!=null) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND AwardeeManagement.program_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

    }

    $conditions['semester'] = '';

    if ($this->request->getQuery('semester')!=null) {

      $semester = $this->request->getQuery('semester'); 

      $conditions['semester'] = " AND AwardeeManagement.semester = $semester";

      $conditionsPrint .= '&semester='.$semester;

    }

    $conditions['year'] = '';

    if ($this->request->getQuery('year')!=null) {

      $year = $this->request->getQuery('year'); 

      $conditions['year'] = " AND AwardeeManagement.year = $year";

      $conditionsPrint .= '&year='.$year;

    }

    $conditions['section_id'] = " AND AwardeeManagement.section_id IS NULL";

    if ($this->request->getQuery('section_id')!=null) {

      $section_id = $this->request->getQuery('section_id'); 

      $conditions['section_id'] = " AND AwardeeManagement.section_id = $section_id";

      $conditionsPrint .= '&section_id='.$section_id;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllAcademicList($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'academic-list'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $acads_list = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];



    foreach ($acads_list as $data) {

      $datas[] = array(

        'id'          => $data['id'],

        'student_name'   => $data['student_name'],

        'student_no'  => $data['student_no'],

        'year'     => $data['year'],

        'award_id'     => $data['award_id'],

        'date'        => fdate($data['date'],'m/d/Y'),

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

  public function medicalMonthlyAccomplishment() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $start = date('Y-m-').'01';

    $end = date('Y-m-t');

    $conditions['date'] = "AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = "AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllMedicalMonthlyAccomplishment($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'medical-monthly-accomplishment'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $monthly_accomplishments = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($monthly_accomplishments as $data) {

      $datas[] = array(

          'ailment'           => $data['ailment'],

          'studentTreated'    => $data['studentTreated'],

          'employeeTreated'   => $data['employeeTreated'],

          'totalTreated'      => $data['totalTreated'],

          'studentReferred'   => $data['studentReferred'],

          'employeeReferred'  => $data['employeeReferred'],

          'totalReferred'     => $data['totalReferred'],

          'remarks'           => $data['remarks'],

       );

    }

    $response = array(

      'ok' => true,

      'conditionsPrint' => $conditionsPrint,

      'data' => $datas,

      'month' => 'For the month of '.fdate($start,'F Y'),

      'paginator' => $paginator

    );

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }  

  public function medicalPropertyEquipment() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(PropertyLog.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllMedicalPropertyEquipment($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'medical-property-equipment'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $property_equipments = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($property_equipments as $data) {

      $datas[] = array(

          'id'           => $data['id'],

          'property_name' => $data['property_name'],

          'type'         => $data['type'],

          'date'         => fdate($data['date'],'m/d/Y'),

       );

    }

    $response = array(

      'ok' => true,

      'conditionsPrint' => $conditionsPrint,

      'data' => $datas,

      'paginator' => $paginator

    );

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function medicalMonthlyConsumption() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')!=null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $start = date('Y-m-t');

    $end = date('Y-m-t');

    $conditions['date'] = "AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

    if ($this->request->getQuery('startDate')!=null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = "AND DATE(PropertyLog.date) >= '$start' AND DATE(PropertyLog.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllMedicalMonthlyConsumption($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'medical-monthly-consumption'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $monthly_consumptions = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    if(count($monthly_consumptions) > 0){

      foreach ($monthly_consumptions as $data) {

        $item_id = $data['id'];

        $issuancesQuery = $this->ItemIssuance->find();

      	$issuancesQuery->select([

    	    'number_issued' => $issuancesQuery->func()->coalesce([

  	        $issuancesQuery->func()->sum('ItemIssuanceSubs.quantity'),

  	        0
    	    ])

      	])

        ->leftJoinWith('ItemIssuanceSubs')	

        ->where([

            'ItemIssuances.visible' => 1,

            'ItemIssuances.status' => 1,

            'ItemIssuanceSubs.item_id' => $item_id

          ])

          ->enableAutoFields(true);

          $issuancesResult = $issuancesQuery->firstOrFail();

          $total_issuances = $issuancesResult->number_issued ?? 0;

          $inventory = $this->InventoryProperty->find()

          ->where([

              'InventoryProperties.visible' => 1,

              'InventoryProperties.property_log_id' => $item_id

          ])

          ->all();

      		$total_stock = 0;

      		foreach ($inventory as $entity) {

      		    $entity->expiry_date = $entity->expiry_date->format('m/d/Y');

      		    $total_stock += $entity->stocks;

      		}

          $datas[] = array(

            'property_name'        => $data['property_name'],

            'inventory'            => $inventory,

            'total_stock'          => $total_stock,    

            'balance'              => $total_stock - $total_issuances,       

            'number_issued'        => $total_issuances,

          );

        }

      }

      $response = array(

        'ok' => true,

        'conditionsPrint' => $conditionsPrint,

        'data' => $datas,

        'paginator' => $paginator

      );

      $this->response->withType('application/json');

      $this->response->getBody()->write(json_encode($response));

      return $this->response;

  }  

  public function medicalDailyTreatments() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $today = date('Y-m-d');

    $conditions['date'] = " AND DATE(ConsultationSub.date) = '$today'"; 

    $condition = " AND DATE(ConsultationSub.date) = '$today'"; 

    if ($this->request->getQuery('date')!=null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(ConsultationSub.date) = '$search_date' "; 

      $condition = " AND DATE(ConsultationSub.date) = '$search_date' "; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')!=null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

      $condition = " AND DATE(ConsultationSub.date) >= '$start' AND DATE(ConsultationSub.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllFacultyMasterlist($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'medical-daily-treatment'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $faculty_masterlists = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($faculty_masterlists as $data) {

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

      $subs = array();

      if(!empty($consultation_sub)){

        foreach ($consultation_sub as $key => $value) {
          
          $subs[] = array(

            'ailments'   => $value['chief_complaints'],

            'treatments' => $value['treatments'],

            'remarks'    => $value['remarks'],

          );

        }

      }

      $datas[] = array(

        'id'            => $data['id'],

        'patient_name'  => $data['student_name'] != null ? $data['student_name'] : $data['employee_name'],

        'subs'          => $subs

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


  public function enrollmentProfile() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['program_id'] = "";

    if ($this->request->getQuery('program_id')) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND Student.program_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

    }

    $conditions['year_term_id'] = "AND Student.year_term_id IS NULL";

    if ($this->request->getQuery('year_term_id')) {

      $year_term_id = $this->request->getQuery('year_term_id'); 

      $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

      $conditionsPrint .= '&year_term_id='.$year_term_id;

    }

    $conditions['college_id'] = " ";

    if ($this->request->getQuery('college_id')) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['section_id'] = " ";

    if ($this->request->getQuery('section_id')) {

      $section_id = $this->request->getQuery('section_id'); 

      $conditions['section_id'] = " AND StudentEnrolledCourse.section_id = $section_id";

      $conditionsPrint .= '&section_id='.$section_id;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllEnrollmentProfile($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'enrollment-profile'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $enrollment_profiles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($enrollment_profiles as $data) {


        $fullName = $data['last_name'] . ' ' . $data['first_name'] . ' ' . $data['middle_name']; // Concatenated full name

        $datas[] = array(

         'id'           =>        $data['id'],

         'student_no'   =>        $data['student_no'],

         'course'       =>        $data['course'],

         'name'         =>        $data ['name'],

         'section'      =>        $data ['section'],

         'email'        =>        $data ['email'],

         'fullname'     =>        $fullName,

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

  public function enrollmentList() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

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

   
    $conditions['year_term_id'] = "AND Student.year_term_id IS NULL";

    if ($this->request->getQuery('year_term_id')) {

      $year_term_id = $this->request->getQuery('year_term_id'); 

      $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

      $conditionsPrint .= '&year_term_id='.$year_term_id;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllEnrollmentList($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'enrollment-list'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $enrollment_profiles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($enrollment_profiles as $data) {

        $datas[] = array(

          'id'          => $data['id'],

          'student_name'   => $data['full_name'],

          'student_no'  => $data['student_no'],

          'college'     => $data['college'],

          'program'     => $data['program'],

          'date'        => fdate($data['date'],'m/d/Y'),

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

  public function academicFailuresList() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['college_id'] = '';

    if ($this->request->getQuery('collee_id')) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['college_program_id'] = "AND Student.program_id IS NULL";

    if ($this->request->getQuery('collee_program_id')) {

      $college_program_id = $this->request->getQuery('college_program_id'); 

      $conditions['college_program_id'] = " AND Student.program_id = $college_program_id";

      $conditionsPrint .= '&college_program_id='.$college_program_id;

    }

    $conditions['program_course_id'] = '';

    if ($this->request->getQuery('progrm_course_id')) {

      $program_course_id = $this->request->getQuery('program_course_id'); 

      $conditions['program_course_id'] = " AND StudentEnrolledCourse.course_id = $program_course_id";

      $conditionsPrint .= '&program_course_id='.$program_course_id;

    }

    $conditions['term'] = '';

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
      
      $conditionsPrint .= '&term='.$term;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllFailedStudent($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'academic-failures-list'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $enrollment_profiles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($enrollment_profiles as $data) {

        $datas[] = array(

          'student_no'   => $data['student_no'],

          'student_name'   => $data['full_name'],

          'remarks'   => 'FAILED',

          'year' => $data['year'],

          'semester' => $data['semester'],

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

  public function transcriptOfRecords() {

    //with pagination

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    // search conditions

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date') != null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentEnrollment.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['college_id'] = " AND Student.college_id = 0";

    if ($this->request->getQuery('college_id') != null) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['program_id'] = '';

    if ($this->request->getQuery('program_id') != null) {

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

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllTranscriptOfRecord($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'transcript-of-records'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $main = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = array();

    if(!empty($main)){

      foreach ($main as $data) {

        $datas[] = array(

          'id'          => $data['id'],

          'full_name'   => $data['full_name'],

          'student_no'  => $data['student_no'],

          'college'     => $data['college'],

          'program'     => $data['program'],

        );

      }

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

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

  }

  public function studentBehavior() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentBehavior.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentBehavior.date) >= '$start' AND DATE(StudentBehavior.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }
    $conditions['program_id'] = '';

    if ($this->request->getQuery('program_id')) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND StudentBehavior.course_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

    }

    $conditions['year'] = "";


    if ($this->request->getQuery('year_term_id')) {

      $year = $this->request->getQuery('year_term_id'); 

      $conditions['year'] = " AND StudentBehavior.year_term_id = '$year' ";

      $conditionsPrint .= '&year='.$year;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllStudentBehavior($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'student-behavior'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $enrollment_profiles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($enrollment_profiles as $data) {

        $datas[] = array(

            'id'          => $data['id'],

            'student_name'   => $data['student_name'],

            'student_no'  => $data['student_no'],

            'program'     => $data['program'],

            'behavior'     => $data['behavior'],

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


  //admission
  public function listApplicants(){   

   $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date') != null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status') != null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND StudentApplication.approve = $status";

      $conditionsPrint .= '&status='.$this->request->getQuery('status');

      if($status == 1){ //FOR APPROVED TAB OF STUDENT APPLICATION

        $conditions['status'] = "AND StudentApplication.approve <> 0";

      }elseif($status == 'forRating'){ //RATING TAB OF CAT

        $conditions['status'] = "AND StudentApplication.approve = 1";

      }

    }

    $conditions['order'] = '';

    if ($this->request->getQuery('order') != null){

      $order = $this->request->getQuery('order');

      $conditions['order'] = $order;

      $conditionsPrint .= '&order='.$order;
      
    }

    $entries = 25;

    if ($this->request->getQuery('entries') != null){

      $entries = $this->request->getQuery('entries');
      
    }
    // var_dump($conditions);

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllListApplicant($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'list-applicant'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $main = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($main as $data) {

      $datas[] = array(

        'id'                => $data['id'],

        'full_name'         => $data['full_name'],

        'email'             => $data['email'],

        'address'           => $data['address'],

        'contact_no'        => $data['contact_no'],

        'gender'            => $data['gender'],

        'application_date'  => fdate($data['application_date'],'m/d/Y'),

        'rate'              => $data['rate'],

        'status'            => $data['status'],

        'request_purpose'   => $data['request_purpose'],

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

  public function listStudents() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

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

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentEnrollment.date) >= '$start' AND DATE(StudentEnrollment.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['year_term_id'] = " AND Student.year_term_id IS NULL";

    $conditions['year_term_id_enrollment'] = '';

    if ($this->request->getQuery('year_term_id')) {

      $year_term_id = $this->request->getQuery('year_term_id'); 

      $conditions['year_term_id'] = " AND Student.year_term_id = $year_term_id";

      $conditions['year_term_id_enrollment'] = " AND StudentEnrollment.year_term_id = $year_term_id";

      $conditionsPrint .= '&year_term_id='.$year_term_id;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllListStudent($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'list-student'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    
    $student_lists = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($student_lists as $data) {

      $datas[] = array(

          'id'          => $data['id'],

          'student_name'   => $data['full_name'],

          'student_no'  => $data['student_no'],

          'college'     => $data['college'],

          'program'     => $data['program'],

          'date'        => fdate($data['date'],'m/d/Y'),

       );

    }



    $response = array(

      'ok' => true,

      'conditionsPrint' => $conditionsPrint,

      'data' => $datas,

      'paginator' => $paginator

    );

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function listScholars() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

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
      
      $studentId = $this->Session->read('Auth.User.studentId');

      $conditions['studentId'] = " AND ScholarshipApplication.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $conditions['program_id'] = "";

    if ($this->request->getQuery('program_id') != null) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND ScholarshipApplication.program_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

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

      $conditionsPrint .= '&year='.$year;

    }

    $conditions['scholarship'] = "";

    if ($this->request->getQuery('scholarship') != null) {

      $scholarship = $this->request->getQuery('scholarship'); 

      $conditions['scholarship'] = " AND ScholarshipApplication.scholarship_name_id = $scholarship";

      $conditionsPrint .= '&scholarship='.$scholarship;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllListScholar($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'list-scholar'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $list_applicant = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($list_applicant as $data) {

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

  public function listCheckouts() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(CheckOut.date_borrowed) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(CheckOut.date_borrowed) >= '$start' AND DATE(CheckOut.date_borrowed) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllCheckout($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'check-out'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $checkout = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($checkout as $data) {

        $sub = $this->CheckOutSub->find()
        
          ->where([
            
            'visible' => 1,

            'check_out_id' => $data['id'],

          ])
        ->all();

        $datas[] = array(

        'id'                 => $data['id'],

        'library_id_number'  => $data['library_id_number'],

        'code'               => $data['code'],

        'member_name'        => $data['member_name'],

        'email'              => $data['email'],

        'date_borrowed'      => fdate($data['date_borrowed'],'m/d/Y'),

        'subs'                => $sub

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

  public function listCheckins() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

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

      $conditions['date'] = " AND DATE(CheckIn.date_borrowed) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(CheckIn.date_borrowed) >= '$start' AND DATE(CheckIn.date_borrowed) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllCheckin($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'check-in'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $checkin = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($checkin as $data) {

        $sub = $this->CheckInSub->find()
        
          ->where([
            
            'visible' => 1,

            'check_in_id' => $data['id'],

          ])
          
        ->all();

        $datas[] = array(

        'id'                 => $data['id'],

        'library_id_number'  => $data['library_id_number'],

        'code'               => $data['code'],

        'member_name'        => $data['member_name'],

        'email'              => $data['email'],

        'date_returned'      => fdate($data['date_returned'],'m/d/Y'),

        'subs'                => $sub

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

  public function apartelleMonhtlyPayments() {

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search') != null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $start = date('Y-m-').'01'; 

    $end = date('Y-m-t');

    $conditions['date'] = " AND DATE(Payment.date) >= '$start' AND DATE(Payment.date) <= '$end'";

    if ($this->request->getQuery('date') != null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Payment.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    if ($this->request->getQuery('startDate') != null) {

      $start = fdate($this->request->getQuery('startDate'),'Y-m-d'); 

      $end = fdate($this->request->getQuery('endDate'),'Y-m-d');

      $conditions['date'] = " AND DATE(Payment.date) >= '$start' AND DATE(Payment.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllMonthlyPayment($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'monthly-payment'

      ],

      'page' => $page,

      'limit' => $limit

    ]);
    
    $list_academic_awardees = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($list_academic_awardees as $data) {

      $datas[] = array(

        'id'             => $data['id'],

        'or_no'          => $data['or_no'],

        'student_name'   => $data['student_name'],

        'student_no'     => $data['student_no'],

        'program'        => $data['program'],

        'date'           => fdate($data['date'],'m/d/Y'),

        'amount'         => $data['amount'],

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



  //MEDICAL

  public function consultationReport() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end; 

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllConsultationEmployee($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'consultation-employee'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $consultation = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($consultation as $data) {

        
        $datas[] = array(

        'id'                 => $data['id'],

        'name'  =>  $data['employee_name'],

        'date' => fdate($data['date'],'m/d/Y')

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

  public function consultationEmployeeReport() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end; 

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllConsultationEmployee($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'consultation-employee'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $consultation_employee = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($consultation_employee as $data) {

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

        $datas[] = array(

        'id'                 => $data['id'],

        'name'  =>  $data['employee_name'],

        'remarks'  =>  $data['nurse_remarks'],

        'status'  =>  $status,

        'date' => fdate($data['date'], 'm/d/Y')

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

  public function employeeFrequencyReport() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Consultation.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Consultation.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end; 

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllEmployeeFrequency($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'employee-frequency'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $employee_frequency = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($employee_frequency as $data) {


        $datas[] = array(

        'id'                 => $data['id'],

        'name'  =>  $data['employee_name'],

        'frequency'  =>  $data['frequency'],

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


  //GUIDANCE

  public function listRequestedForm() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(RequestForm.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(RequestForm.date) >= '$start' AND DATE(Consultation.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end; 

    }

    $conditions['year_term_id'] = "";


    // if ($this->request->getQuery('year_term_id')) {

    //   $year_term_id = $this->request->getQuery('year_term_id'); 

    //   $conditions['year_term_id'] = " AND Student.year_term_id = '$year_term_id' ";

    //   $conditionsPrint .= '&year_term_id='.$year_term_id;

    // }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllRequestedForm($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'requested-form'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $requested_forms = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];


    foreach ($requested_forms as $data) {

        $data['otr'] = ($data['otr'] != null && $data['otr'] == 1) ? "Transcript of Records" : "";

        $data['cav'] = ($data['cav'] != null && $data['cav'] == 1) ? "Certification Authentication Verification" : "";

        $data['cert'] = ($data['cert'] != null && $data['cert'] == 1) ? "Certification" : "";

        $data['hon'] = ($data['hon'] != null && $data['hon'] == 1) ? "Honorable Dismissal" : "";

        $data['authGrad'] = ($data['authGrad'] != null && $data['authGrad'] == 1) ? "Authorization Gradudate" : "";

        $data['authUGrad'] = ($data['authUGrad'] != null && $data['authUGrad'] == 1) ? "Authorization Under Gradudate" : "";

        $data['dip'] = ($data['otr'] != null && $data['dip'] == 1) ? "Diploma" : "";

        $data['rr'] = ($data['rr'] != null && $data['rr'] == 1) ? "Red Ribbon" : "";

        $data['other'] = ($data['other'] != null && $data['rr'] == 1) ? $data['otherVal'] : "";


        $datas[] = array(

        'id'   => $data['id'],

        'student_name' => $data['student_name'],

        'student_no' => $data['student_no'],

        'otr' => $data['otr'],

        'cert' => $data['cert'],

        'cav' => $data['cav'],

        'hon' => $data['hon'],

        'authGrad' => $data['authGrad'],

        'authUGrad' => $data['authUGrad'],

        'dip' => $data['dip'],

        'rr' => $data['rr'],

        'other' => $data['other'],


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

  public function gcoEvaluationList() {

    //with pagination

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(GcoEvaluation.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(GcoEvaluation.date) >= '$start' AND DATE(GcoEvaluation.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end; 

    }

    $conditions['year_term_id'] = "";


    if ($this->request->getQuery('year_term_id')) {

      $year_term_id = $this->request->getQuery('year_term_id'); 

      $conditions['year_term_id'] = " AND Student.year_term_id = '$year_term_id' ";

      $conditionsPrint .= '&year_term_id='.$year_term_id;

    }

    $conditions['college_id'] = "AND Student.college_id IS NULL";


    if ($this->request->getQuery('college_id')) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND Student.college_id = '$college_id' ";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['program_id'] = "AND Student.program_id IS NULL";


    if ($this->request->getQuery('program_id')) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND Student.program_id = '$program_id' ";

      $conditionsPrint .= '&program_id='.$program_id;

    }

    $conditions['employee_id'] = "";


    if ($this->request->getQuery('employee_id')) {

      $employee_id = $this->request->getQuery('employee_id'); 

      $conditions['employee_id'] = " AND CounselingAppointment.employee_id = '$employee_id' ";

      $conditionsPrint .= '&employee_id='.$employee_id;

    }
    
    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllGcoEvaluation($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'gco-evaluation'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $gco_evaluation = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    // debug($gco_evaluation);

    foreach ($gco_evaluation as $data) {

        $datas[] = array(

        'id'   => $data['id'],

        'student_no'   => $data['student_no'],

        'student_name'   => $data['student_name'],

        'comments'   => $data['comments'],

        'date'   => $data['date'],

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

  public function gwa() {

    //with pagination

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    // search conditions

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['college_id'] = "AND Student.college_id = 0";

    if ($this->request->getQuery('college_id') != null) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['program_id'] = " AND Student.program_id = 0";

    if ($this->request->getQuery('program_id') != null) {

      $program_id = $this->request->getQuery('program_id'); 

      $conditions['program_id'] = " AND Student.program_id = $program_id";

      $conditionsPrint .= '&program_id='.$program_id;

    }

    $conditions['section_id'] = " AND StudentEnrolledCourse.section_id = 0";

    if ($this->request->getQuery('section_id') != null) {

      $section_id = $this->request->getQuery('section_id'); 

      $conditions['section_id'] = " AND StudentEnrolledCourse.section_id = $section_id";

      $conditionsPrint .= '&section_id='.$section_id;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllGwa($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'gwa'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $main = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = array();

    if(!empty($main)){

      foreach ($main as $data) {

        $datas[] = array(

          'id' => $data['id'],

          'student_name' => $data['full_name'],

          'college' => $data['college'],

          'program' => $data['program'],

          'ave' => $data['ave'],



        );

      }

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

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

  }

  public function listInventoryBibliographies() {

    //with pagination 

    $page = $this->request->getQuery('page', 1);

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllListInventoryBibliography($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'inventory-bibliographies'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $inventory_bibiliographies = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    // debug($inventory_bibiliographies);

    foreach ($inventory_bibiliographies as $data) {

      $datas[] = array(

          'id'        => $data['id'],

          'code'      => $data['code'],

          'call_number1'      => $data['call_number1'],

          'call_number2'      => $data['call_number2'],

          'call_number3'      => $data['call_number3'],

          'dueback'   => fdate($data['dueback'],'m/d/Y'),

          'title'      => $data['title'],

          'author'      => $data['author'],

          'material_type'      => $data['material_type'],

          'collection_type'      => $data['collection_type'],

          'date_of_publication'      => $data['date_of_publication'],

       );

    }


    $response = array(

      'ok' => true,

      'conditionsPrint' => $conditionsPrint,

      'data' => $datas,

      'paginator' => $paginator

    );

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }


  public function subjectMasterlists() {

    //with pagination

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;

    $conditions = array();
    
    $conditionsPrint = '';

    $conditions['search'] = '';

    // search conditions

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['college_id'] = '';

    if ($this->request->getQuery('college_id') != null) {

      $college_id = $this->request->getQuery('college_id'); 

      $conditions['college_id'] = " AND College.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

    }

    $conditions['college_program_id'] = "AND CollegeProgramCourse.college_program_id IS NULL";

    if ($this->request->getQuery('college_program_id') != null) {

      $college_program_id = $this->request->getQuery('college_program_id'); 

      $conditions['college_program_id'] = " AND CollegeProgramCourse.college_program_id = $college_program_id";

      $conditionsPrint .= '&college_program_id='.$college_program_id;

    }

    $limit = 25;

    $tmpData = $this->Reports->paginate($this->Reports->getAllSubjectMasterList($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions,

        'type'   => 'subject-masterlist'

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $subject_masterlists = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = array();

    if(!empty($subject_masterlists)){

      foreach ($subject_masterlists as $data) {

        $datas[] = array(

          'course'   => $data['course'],

        );

      }

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

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

  }






}