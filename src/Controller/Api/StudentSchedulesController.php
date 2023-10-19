<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class StudentSchedulesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->StudentEnrolledSchedules = TableRegistry::getTableLocator()->get('StudentEnrolledSchedules');

    $this->Students = TableRegistry::getTableLocator()->get('Students');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditionsPrint = '';

    $conditions = [];

    if ($this->request->getQuery('search')!=null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['student_id'] = '';

    if ($this->Auth->user('studentId')!=null) {

      $student_id = $this->Auth->user('studentId');

      $student = $this->Students->get($student_id);

      if ($student_id!='') {

        $year_term_id = $student['year_term_id'];

        $conditions['student_id'] = "AND StudentEnrolledSchedule.student_id = $student_id AND StudentEnrolledSchedule.year_term_id = $year_term_id";

      }

      $conditionsPrint .= '&per_student='.$student_id;

    }

    $limit = 25;

    $tmpData = $this->StudentEnrolledSchedules->paginate($this->StudentEnrolledSchedules->getAllStudentEnrolledSchedule($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $tmp = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $daysOfWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');

    

    $datas = [];

    foreach ($daysOfWeek as $key => $value) {

      $colors = array("#FAEDCB","#C9E4DE","#C6DEF1","#DBCDF0","#F2C6DE","#F7D9C4");

      $perDay = [];
      shuffle($colors);

      foreach ($tmp as $data) {

        if($value==$data['day']){

            $start = date("H:i", strtotime($data['time_start']));

            $end = date("H:i", strtotime($data['time_end']));

            $randomIndex = array_rand($colors);

            // Use the random index to access the randomly selected color
            $randomColor = $colors[$randomIndex];

            $perDay[] = array(

            'id'            => $data['id'],

            'code'     => $data['code'],

            'faculty_name'   => $data['faculty_name'],

            'day'   => $data['day'],

            'course'        => $data['course'],

            'room'        => $data['room'],

            'time_start'        => $start,

            'time_end'        => $end,

            'color' => $randomColor

          );

            $indexToRemove = array_search($randomColor, $colors);

            if ($indexToRemove !== false) {
                // Unset the element with the found index
                unset($colors[$indexToRemove]);
            }
        }

      }

      $datas[] = $perDay;
      
    }

    $response = [

      'ok' => true,

      'data' => $datas,

      'days' => $daysOfWeek,

      'paginator' => $paginator,

      'conditionsPrint' => $conditionsPrint,

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function add(){

    $this->autoRender = false;

    $requestData = $this->request->getData('Section');

    $data = $this->Sections->newEmptyEntity();
   
    $data = $this->Sections->patchEntity($data, $requestData); 

    if ($this->Sections->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Section has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Section Management',

          // 'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Section cannot saved this time.',

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

    $data['Section'] = $this->Sections->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

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

    $section = $this->Sections->get($id); 

    $requestData = $this->getRequest()->getData('Section');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->Sections->patchEntity($section, $requestData); 

    if ($this->Sections->save($section)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Section has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Section Management',

          // 'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Section cannot updated this time.',

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

    $data = $this->Sections->get($id);

    $data->visible = 0;

    if ($this->Sections->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Section Management',

          // 'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'Section has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Section cannot be deleted at this time.'

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

}
