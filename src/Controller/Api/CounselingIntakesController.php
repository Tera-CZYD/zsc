<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class CounselingIntakesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->CounselingIntakes = TableRegistry::getTableLocator()->get('CounselingIntakes');

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

      $conditions['date'] = " AND DATE(CounselingIntake.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(CounselingIntake.date) >= '$start' AND DATE(CounselingIntake.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Session->read('Auth.User.studentId');

      $conditions['studentId'] = "AND CounselingIntake.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->CounselingIntakes->paginate($this->CounselingIntakes->getAllCounselingIntake($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $counseling_intakes = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($counseling_intakes as $data) {

      $datas[] = array(

  
          'id'                 => $data['id'],
  
          'full_name'          => $data['full_name'],

          'address'            => $data['address'],

          'year_level_term'    => $data['year_level_term'],

          'contact_no'         => $data['contact_no'],


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

    $CounselingIntakeSubs = $this->CounselingIntakeSubs = TableRegistry::getTableLocator()->get('CounselingIntakeSubs');

    $main = $this->request->getData('CounselingIntake');

    $sub = $this->request->getData('CounselingIntakeSub');

    $main['date'] = isset($main['date']) ? date('Y-m-d', strtotime($main['date'])) : NULL;

    $main['birth_date'] = isset($main['birth_date']) ? date('Y-m-d', strtotime($main['birth_date'])) : NULL;

    $data = $this->CounselingIntakes->newEmptyEntity();
   
    $data = $this->CounselingIntakes->patchEntity($data, $main);

    if ($this->CounselingIntakes->save($data)) {

       $id = $data->id;


      if (!empty($sub)) {

        $sub['behavior'] = @$sub['behave'][0].','.@$sub['behave'][1].','.@$sub['behave'][2].','.@$sub['behave'][3].','.@$sub['behave'][4].','.@$sub['behave'][5].','.@$sub['behave'][6].','.@$sub['behave'][7].','.@$sub['behave'][8].','.@$sub['behave'][9].','.@$sub['behave'][10].','.@$sub['behave'][11].','.@$sub['behave'][12].','.@$sub['behave'][13].','.@$sub['behave'][14];

        $sub['feelings'] = @$sub['feel'][0].','.@$sub['feel'][1].','.@$sub['feel'][2].','.@$sub['feel'][3].','.@$sub['feel'][4].','.@$sub['feel'][5].','.@$sub['feel'][6].','.@$sub['feel'][7].','.@$sub['feel'][8].','.@$sub['feel'][9].','.@$sub['feel'][10].','.@$sub['feel'][11].','.@$sub['feel'][12].','.@$sub['feel'][13].','.@$sub['feel'][14].','.@$sub['feel'][15].','.@$sub['feel'][16].','.@$sub['feel'][17].','.@$sub['feel'][18].','.@$sub['feel'][19].','.@$sub['feel'][20].','.@$sub['feel'][21].','.@$sub['feel'][22].','.@$sub['feel'][23].','.@$sub['feel'][24].','.@$sub['feel'][25].','.@$sub['feel'][26].','.@$sub['feel'][27];

        $sub['physical'] = @$sub['phy'][0].','.@$sub['phy'][1].','.@$sub['phy'][2].','.@$sub['phy'][3].','.@$sub['phy'][4].','.@$sub['phy'][5].','.@$sub['phy'][6].','.@$sub['phy'][7].','.@$sub['phy'][8].','.@$sub['phy'][9].','.@$sub['phy'][10].','.@$sub['phy'][11].','.@$sub['phy'][12].','.@$sub['phy'][13].','.@$sub['phy'][14].','.@$sub['phy'][15].','.@$sub['phy'][16].','.@$sub['phy'][17].','.@$sub['phy'][18].','.@$sub['phy'][19].','.@$sub['phy'][20].','.@$sub['phy'][21];

        $subEntities = $CounselingIntakeSubs->newEntity([

              'counseling_intake_id' => $id,

              'behavior' => $sub['behavior'],

              'feelings' => $sub['feelings'],

              'physical' => $sub['physical']

          ]);

          $this->CounselingIntakeSubs->save($subEntities);
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Counseling Intake has been successfully saved.',

        'data'=>$main

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Counseling Intake Management',

          'code' => $main['student_name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$main,

        'msg' =>'Counseling Intake cannot saved this time.',

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

    $data = $this->CounselingIntakes->find()
      ->contain([
          'CollegePrograms',

          'CounselingIntakeSubs' => [

            'conditions' => ['CounselingIntakeSubs.visible' => 1]

          ]

        ])

      ->where([

        'CounselingIntakes.visible' => 1,

        'CounselingIntakes.id' => $id

      ])

      ->first();

      $CounselingIntake = $data->toArray();

      unset($CounselingIntake['CollegeProgram']);

      unset($CounselingIntake['CounselingIntakeSub']);

      $data = [

        'CounselingIntake' => $CounselingIntake,

        'CollegeProgram' => $data['CollegeProgram'],

        'CounselingIntakeSub' => $data['CounselingIntakeSub'],

      ];

      $data['CounselingIntake']['date'] = isset($data['CounselingIntake']['date']) ? date('m/d/Y', strtotime($data['CounselingIntake']['date'])) : null;

      $data['CounselingIntake']['birth_date'] = isset($data['CounselingIntake']['birth_date']) ? date('m/d/Y', strtotime($data['CounselingIntake']['birth_date'])) : null;

      $data['CounselingIntakeSub']['behave'] = explode(',',$data['CounselingIntakeSub']['behavior']);

      if (!empty($data['CounselingIntakeSub']['behave'])){

      foreach ($data['CounselingIntakeSub']['behave'] as $key => $value) {
        
        $data['CounselingIntakeSub']['behave'][$key] = $data['CounselingIntakeSub']['behave'][$key] == 1 ? true: false;

      }

    }

    $data['CounselingIntakeSub']['feel'] = explode(',',$data['CounselingIntakeSub']['feelings']);

    if (!empty($data['CounselingIntakeSub']['feel'])){

      foreach ($data['CounselingIntakeSub']['feel'] as $key => $value) {
        
        $data['CounselingIntakeSub']['feel'][$key] = $data['CounselingIntakeSub']['feel'][$key] == 1 ? true: false;

      }

    }

    $data['CounselingIntakeSub']['phy'] = explode(',',$data['CounselingIntakeSub']['physical']);
    
    if (!empty($data['CounselingIntakeSub']['phy'])){

      foreach ($data['CounselingIntakeSub']['phy'] as $key => $value) {
        
        $data['CounselingIntakeSub']['phy'][$key] = $data['CounselingIntakeSub']['phy'][$key] == 1 ? true: false;

      }

    }

    $data['CounselingIntake']['student_name'] = ($data['CounselingIntake']['student_name']);
      

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

      $CounselingIntakeSubs = $this->CounselingIntakeSubs = TableRegistry::getTableLocator()->get('CounselingIntakeSubs');

      $main = $this->request->getData('CounselingIntake');

      $main['date'] = isset($main['date']) ? date('Y-m-d', strtotime($main['date'])) : NULL;

      $main['birth_date'] = isset($main['birth_date']) ? date('Y-m-d', strtotime($main['birth_date'])) : NULL;

      $sub = $this->request->getData('CounselingIntakeSub');

      $id = $main['id'];

      $data = $this->CounselingIntakes->get($id);

      $data = $this->CounselingIntakes->patchEntity($data, $main);

      if ($this->CounselingIntakes->save($data)) {

          $this->CounselingIntakes->CounselingIntakeSubs->deleteAll(['counseling_intake_id' => $id]);

          if (!empty($sub)) {

            $sub['behavior'] = @$sub['behave'][0].','.@$sub['behave'][1].','.@$sub['behave'][2].','.@$sub['behave'][3].','.@$sub['behave'][4].','.@$sub['behave'][5].','.@$sub['behave'][6].','.@$sub['behave'][7].','.@$sub['behave'][8].','.@$sub['behave'][9].','.@$sub['behave'][10].','.@$sub['behave'][11].','.@$sub['behave'][12].','.@$sub['behave'][13].','.@$sub['behave'][14];

            $sub['feelings'] = @$sub['feel'][0].','.@$sub['feel'][1].','.@$sub['feel'][2].','.@$sub['feel'][3].','.@$sub['feel'][4].','.@$sub['feel'][5].','.@$sub['feel'][6].','.@$sub['feel'][7].','.@$sub['feel'][8].','.@$sub['feel'][9].','.@$sub['feel'][10].','.@$sub['feel'][11].','.@$sub['feel'][12].','.@$sub['feel'][13].','.@$sub['feel'][14].','.@$sub['feel'][15].','.@$sub['feel'][16].','.@$sub['feel'][17].','.@$sub['feel'][18].','.@$sub['feel'][19].','.@$sub['feel'][20].','.@$sub['feel'][21].','.@$sub['feel'][22].','.@$sub['feel'][23].','.@$sub['feel'][24].','.@$sub['feel'][25].','.@$sub['feel'][26].','.@$sub['feel'][27];

            $sub['physical'] = @$sub['phy'][0].','.@$sub['phy'][1].','.@$sub['phy'][2].','.@$sub['phy'][3].','.@$sub['phy'][4].','.@$sub['phy'][5].','.@$sub['phy'][6].','.@$sub['phy'][7].','.@$sub['phy'][8].','.@$sub['phy'][9].','.@$sub['phy'][10].','.@$sub['phy'][11].','.@$sub['phy'][12].','.@$sub['phy'][13].','.@$sub['phy'][14].','.@$sub['phy'][15].','.@$sub['phy'][16].','.@$sub['phy'][17].','.@$sub['phy'][18].','.@$sub['phy'][19].','.@$sub['phy'][20].','.@$sub['phy'][21];

            $subEntities = $CounselingIntakeSubs->newEntity([

              'counseling_intake_id' => $id,

              'behavior' => $sub['behavior'],

              'feelings' => $sub['feelings'],

              'physical' => $sub['physical']

          ]);

            $this->CounselingIntakeSubs->save($subEntities);

          }

          $response = [
              'ok' => true,
              'msg' => 'Counseling Intake has been successfully updated.',
              'data' => $main,
          ];

          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
          $userLogEntity = $userLogTable->newEntity([

              'action' => 'Add',

              'description' => 'Counseling Intake Management',

              'code' => $main['student_name'],

              'created' => date('Y-m-d H:i:s'),

              'modified' => date('Y-m-d H:i:s')

          ]);
          
          $userLogTable->save($userLogEntity);

      } else {

          $response = [

              'ok' => false,

              'data' => $main,

              'msg' => 'Counseling Intake could not be updated this time.',

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

    $data = $this->CounselingIntakes->get($id);

    $data->visible = 0;

    if ($this->CounselingIntakes->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Counseling Intake has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Counseling Intake cannot be deleted at this time.'

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
