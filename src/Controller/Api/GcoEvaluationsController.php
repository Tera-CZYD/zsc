<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class GcoEvaluationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->GcoEvaluations = TableRegistry::getTableLocator()->get('GcoEvaluations');

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

      $conditions['date'] = " AND DATE(GcoEvaluation.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(GcoEvaluation.date) >= '$start' AND DATE(GcoEvaluation.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');

      $employee_id = $this->Auth->user('studentId');

      if ($employee_id!='') {

        $conditions['studentId'] = "AND GcoEvaluation.student_id = $employee_id";

      }

      $conditionsPrint .= '&per_student='.$per_student;

    }


    $limit = 25;

    $tmpData = $this->GcoEvaluations->paginate($this->GcoEvaluations->getAllGcoEvaluation($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $gco_evaluations = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    // var_dump($RequestForms);
    foreach ($gco_evaluations as $data) {

      $datas[] = array(

  
          'id'            => $data['id'],
  
          'code'          => $data['code'],

          'student_name'  => $data['student_name'],

          'date'          => $data['date'],

          'attendanceCode' => $data['attendanceCode']

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

    $AttendanceCounselings = $this->AttendanceCounselings = TableRegistry::getTableLocator()->get('AttendanceCounselings');

    $main = $this->request->getData('GcoEvaluation');

    $sub = $this->request->getData('AttendanceCounseling');

    $main['date'] = isset($main['date']) ? date('Y-m-d', strtotime($main['date'])) : NULL;

    $data = $this->GcoEvaluations->newEmptyEntity();
   
    $data = $this->GcoEvaluations->patchEntity($data, $main);

    if ($this->GcoEvaluations->save($data)) {

       $id = $data->id;


      if (!empty($sub)) {

        $subEntities = $AttendanceCounselings->newEntity([

              'id'         => $main['attendance_counseling_id'],

              'gco_evaluation_id' => $id,

          ]);

          $this->AttendanceCounselings->save($subEntities);
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Gco Evaluation Intake has been successfully saved.',

        'data'=>$main

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Gco Evaluation Management',

          'code' => $main['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$main,

        'msg' =>'Gco Evaluation cannot saved this time.',

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

    $data['GcoEvaluation'] = $this->GcoEvaluations->find()

      ->contain([

        'Students',

        'AttendanceCounselings'

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

      ];

      unset($data['GcoEvaluation']->student);

      unset($data['GcoEvaluation']->attendance_counseling);


      $data['GcoEvaluation']['date'] = isset($data['GcoEvaluation']['date']) ? date('m/d/Y', strtotime($data['GcoEvaluation']['date'])) : null;

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

    $this->autoRender = false;

      $AttendanceCounselings = $this->AttendanceCounselings = TableRegistry::getTableLocator()->get('AttendanceCounselings');

      $main = $this->request->getData('GcoEvaluation');

      $main['date'] = isset($main['date']) ? date('Y-m-d', strtotime($main['date'])) : NULL;

      $sub = $this->request->getData('GcoEvaluation');

      $id = $main['id'];

      $data = $this->GcoEvaluations->get($id);

      $data = $this->GcoEvaluations->patchEntity($data, $main);

      if ($this->GcoEvaluations->save($data)) {

          $this->GcoEvaluations->AttendanceCounselings->deleteAll(['gco_evaluation_id' => $id]);

          if (!empty($sub)) {

            $subEntities = $AttendanceCounselings->newEntity([

                'id'         => $main['attendance_counseling_id'],

                'gco_evaluation_id' => $id,

            ]);

            $this->AttendanceCounselings->save($subEntities);

          }

          $response = [
              'ok' => true,
              'msg' => 'Gco Evaluation has been successfully updated.',
              'data' => $main,
          ];

          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
          $userLogEntity = $userLogTable->newEntity([

              'action' => 'Add',

              'description' => 'Gco Evaluation Management',

              'code' => $main['student_name'],

              'created' => date('Y-m-d H:i:s'),

              'modified' => date('Y-m-d H:i:s')

          ]);
          
          $userLogTable->save($userLogEntity);

      } else {

          $response = [

              'ok' => false,

              'data' => $main,

              'msg' => 'Gco Evaluation could not be updated this time.',

          ];

      }

      $this->set([

          'response' => $response,

          '_serialize' => 'response',

      ]);

      $this->response->withType('application/json');

      $this->response->getBody()->write(json_encode($response));

      return $this->response;

  }

  public function delete($id){

    $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->GcoEvaluations->get($id);

    $data->visible = 0;

    if ($this->GcoEvaluations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Gco Evaluation has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Gco Evaluation cannot be deleted at this time.'

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
