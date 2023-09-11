<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class StudentProfilesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->StudentProfiles = TableRegistry::getTableLocator()->get('StudentProfiles');

    $this->CollegeProgramSubs = TableRegistry::getTableLocator()->get('CollegeProgramSubs');

  }

  
  public function index(){

    // default page 1

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1; 
    
    // default conditions

    $conditionsPrint = '';

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

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')!=null) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    if ($this->request->getQuery('college_program_id')!=null) {

      $college_program_id = $this->request->getQuery('college_program_id');

      $conditions['college_program'] = " AND StudentApplication.preferred_program_id = $college_program_id";

      $conditionsPrint .= '&college_program_id=' . $college_program_id;
      
    }


    $limit = 25;

    $tmpData = $this->StudentProfiles->paginate($this->StudentProfiles->getAllStudentProfile($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $registered_students = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($registered_students as $data) {

      $datas[] = array(

        'id'          => $data['id'],

        'full_name'   => $data['full_name'],

        'student_no'  => $data['student_no'],

        'application_date'     => fdate($data['application_date'],'m/d/Y'),

        'email'  => $data['email'],

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

    $data['StudentApplication'] = $this->StudentApplications->find()

      ->contain([

        'PreferredPrograms',

        'StudentApplicationImages' => [

          'conditions' => [

            'StudentApplicationImages.visible' => 1

          ]

        ],

      ])

      ->where([

        'StudentApplications.visible' => 1,

        'StudentApplications.id' => $id

      ])

    ->first();

    $data['StudentApplication']['application_date'] = isset($data['StudentApplication']['application_date']) ? date('m/d/Y', strtotime($data['StudentApplication']['application_date'])) : '';

    $data['StudentApplicationImage'] = $data['StudentApplication']['student_application_images'];

    $data['CollegeProgram'] = $data['StudentApplication']['preferred_program'];

    unset($data['StudentApplication']['student_application_image']);

    unset($data['StudentApplication']['preferred_program']);

    $applicationImage = array();

    if(!empty($data['StudentApplicationImage'])){

      foreach($data['StudentApplicationImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $applicationImage[] = array(

            'imageSrc' => $this->base . 'uploads/student-application/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }

    } 

    $requirements = $this->CollegeProgramSubs->find()

      ->where([

        'visible' => 1,

        'college_program_id' => $data['CollegeProgram']['id']

      ])

    ->all();

    $response = array(

      'ok'   => true,

      'data' => $data,

      'requirements' => $requirements,

      'applicationImage' =>$applicationImage

    );
      
    $this->set(array(

      'response'   => $response,

      '_serialize' => 'response'

   ));

        $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }
   
}