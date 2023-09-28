<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class GradesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Employees = TableRegistry::getTableLocator()->get('Employees');

    $this->StudentEnrolledCourses = TableRegistry::getTableLocator()->get('StudentEnrolledCourses');

    $this->YearLevelTerms = TableRegistry::getTableLocator()->get('YearLevelTerms');

    $this->Students = TableRegistry::getTableLocator()->get('Students');

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

      $conditions['date'] = " AND DATE(Completion.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Completion.date) >= '$start' AND DATE(Completion.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $limit = 25;

    $tmpData = $this->Completions->paginate($this->Completions->getAllCompletion($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $Completions = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // var_dump($Completions);
    foreach ($Completions as $data) {

      $datas[] = array(

         'id'             => $data['id'],

         'code'           => $data['code'],

         'student_name'   => $data['student_name'],

         'requirement'    => $data['requirement'],

         'instructor'     => $data['instructor'],

         'semester'       => $data['semester'],

         'or_no'             => $data['or_no'],

         'school_year'    => $data['school_year'],

         'year'           => $data['year'],

         'date'           => fdate($data['date'],'m/d/Y'),

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

    $data['Employee'] = $this->Employees->find()

      ->contain([

        'Colleges' => [

          'conditions' => [

            'Colleges.visible' => 1

          ]

        ]

      ])

      ->where([

        'Employees.visible' => 1,

        'Employees.id' => $id

      ])

    ->first();

    $data['College'] = $data['Employee']['College'];

    unset($data['Employee']['College']);

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

  public function gradeUpdate($id = null){

    $data = $this->request->getData();

    // var_dump($data);

    if(!empty($data)){

      foreach ($data as $key => $value) {

        // var_dump($value);

        if($value['midterm_submitted'] == 1 && ($value['finalterm_grade'] == '' || $value['finalterm_grade'] == null)){

          $value['final_grade'] = 'INC';

          $value['remarks'] = 'INCOMPLETE';

          $value['incomplete'] = 1;

        }

        $entity = $this->StudentEnrolledCourses->newEntity($value);
        
        $this->StudentEnrolledCourses->save($entity);

      }

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Update',

          'userId' => $this->Auth->user('id'),

          'description' => 'Grades',

          'code' => $data[0]['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Grade has been successfully saved.'

      );

    }else{

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Grade cannot be saved this time.'

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

  public function submitMidterm($id = null){

    $data = $this->request->getData();

    // var_dump($data);

    if(!empty($data)){

      foreach ($data as $key => $value) {

        // var_dump($value);

        $value['midterm_submitted'] = 1;

        $entity = $this->StudentEnrolledCourses->newEntity($value);
        
        $this->StudentEnrolledCourses->save($entity);

      }

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Grade',

          'userId' => $this->Auth->user('id'),

          'description' => 'Submit Mid Term Grade',

          'code' => $data[0]['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Grade has been successfully submitted.'

      );

    }else{

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Grade cannot be submitted this time.'

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

  public function submitFinalterm($id = null){

    $data = $this->request->getData();

    if(!empty($data)){

      foreach ($data as $key => $value) {

        if($value['midterm_submitted'] == 1 && ($value['finalterm_grade'] == '' || $value['finalterm_grade'] == null)){

          $value['final_grade'] = 'INC';

          $value['remarks'] = 'INCOMPLETE';

          $value['incomplete'] = 1;

        }

        $value['finalterm_submitted'] = 1;

        $value['finalterm_submitted_date'] = date('Y-m-d');

        $entity = $this->StudentEnrolledCourses->newEntity($value);
        
        $this->StudentEnrolledCourses->save($entity);

        $student['id'] = $value['student_id'];

        $student['status'] = $value['remarks'];

        $entity = $this->Students->newEntity($student);
        
        $this->Students->save($entity);

      }

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Grade',

          'userId' => $this->Auth->user('id'),

          'description' => 'Submit Final Term Grade',

          'code' => $data[0]['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Grade has been successfully submitted.'

      );

    }else{

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Grade cannot be submitted this time.'

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
