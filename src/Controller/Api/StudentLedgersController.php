<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class StudentLedgersController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Student = TableRegistry::getTableLocator()->get('Students');

    $this->StudentLedgers = TableRegistry::getTableLocator()->get('StudentLedgers');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    $header = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $conditions['search'] = strtolower($search);

      $conditionsPrint .= '&search='.$search;

      $header .= ' SEARCH : '.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Student.created) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

      $header .= ' DATE : '.fdate($search_date,'F d, Y');

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Student.created) >= '$start' AND DATE(Student.created) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

      $header .= ' RANGE : '.fdate($start,'F d, Y').' - '.fdate($end,'F d, Y');

    }

    $conditions['college_id'] = '';

    if ($this->request->getQuery('college_id')) {

      $college_id = $this->request->getQuery('college_id');

      $conditions['college_id'] = "AND Student.college_id = $college_id";

      $conditionsPrint .= '&college_id='.$college_id;

      $collegeData = $this->College->findById($college_id);

      $header .= ' COLLEGE : '.$collegeData['College']['name'];

    }

    $conditions['degree_id'] = '';

    if ($this->request->getQuery('degree_id')) {

      $degree_id = $this->request->getQuery('degree_id');

      $conditions['degree_id'] = "AND Student.degree_id = $degree_id";

      $conditionsPrint .= '&degree_id='.$degree_id;

      $degreeData = $this->Degree->findById($degree_id);

      $header .= ' DEGREE : '.$degreeData['Degree']['name'];

    }

    $limit = 25;

    $tmpData = $this->Student->paginate($this->Student->getAllStudent($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $StudentBehavior = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($StudentBehavior as $data) {

      $datas[] = array(
          
         'id'           => $data['id'],

         'student_no'   => $data['student_no'],

         'first_name'   => $data['first_name'],

         'middle_name'  => $data['middle_name'],

         'last_name'    => $data['last_name'],

         'college'      => $data['c_name'],

         'program_name' => $data['program_name'],

         'year_level'   => $data['year_level'],

         'student_name' => $data['full_name'],

         'regular'      => $data['regular_yes'] ? 'True' : 'False',

         'active'       => $data['active'] ? 'True' : 'False'

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

  public function view($id = null){

    $data['Student'] = $this->Student->find()

      ->contain([

        'StudentLedgers' => array(

          'conditions' => array(

            'StudentLedgers.visible' => 1

          )

        ),

        'CollegePrograms',

        'Colleges'

      ])
        
      ->where([

        'Students.id' => $id

      ])

    ->first();

    $data['Student']['full_name'] = $data['Student']['last_name'].', '.$data['Student']['first_name'].' '.$data['Student']['middle_name'];

    $data['StudentLedger'] = $data['Student']['student_ledgers'];

    if(!empty($data['StudentLedger'])){

      foreach ($data['StudentLedger'] as $key => $value) {
        
        $data['StudentLedger'][$key]['transaction_date'] = $value['transaction_date'] != null ? $value['transaction_date']->format('m/d/Y') : null;

      }

    }

    unset($data['Student']['student_ledgers']);

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

}
