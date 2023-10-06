<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class PromissoryNotesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->PromissoryNotes = TableRegistry::getTableLocator()->get('PromissoryNotes');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if ($this->request->getQuery('search') != null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date') != null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(PromissoryNote.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(PromissoryNote.date) >= '$start' AND DATE(PromissoryNote.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student') != null) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Session->read('Auth.User.studentId');

      $conditions['studentId'] = "AND PromissoryNote.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->PromissoryNotes->paginate($this->PromissoryNotes->getAllPromissoryNote($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $promissory_notes = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($promissory_notes as $data) {

      $datas[] = array(

  
          'id'            => $data['id'],
  
          'code'          => $data['code'],

          'student_name'  => $data['student_name'],

          'date'          => fdate($data['date'],'m/d/Y'),

          'program'       => $data['name'],

          'year_level'    => $data['description'],


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

    $requestData = $this->request->getData('PromissoryNote');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $data = $this->PromissoryNotes->newEmptyEntity();
   
    $data = $this->PromissoryNotes->patchEntity($data, $requestData); 

    if ($this->PromissoryNotes->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Promissory Note has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Promissory Note Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Promissory Note cannot saved this time.',

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

    $data = $this->PromissoryNotes->find()
      ->contain([
          'CollegePrograms'=> [
              'conditions' => ['CollegePrograms.visible' => 1],
            ],

          'YearLevelTerms'=> [
              'conditions' => ['YearLevelTerms.visible' => 1],
          ]
        ])

      ->where([

        'PromissoryNotes.visible' => 1,

        'PromissoryNotes.id' => $id

      ])

      ->first();

      $PromissoryNote = $data->toArray();

      unset($PromissoryNote['CollegeProgram']);

      unset($PromissoryNote['YearLevelTerm']);

      $data = [

        'PromissoryNote' => $PromissoryNote,

        'CollegeProgram' => $data['CollegeProgram'],

        'YearLevelTerm' => $data['YearLevelTerm'],

      ];

      $data['PromissoryNote']['date'] = isset($data['PromissoryNote']['date']) ? date('m/d/Y', strtotime($data['PromissoryNote']['date'])) : null;
      

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

   $data = $this->PromissoryNotes->get($id); 

    $requestData = $this->getRequest()->getData('PromissoryNote');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->PromissoryNotes->patchEntity($data, $requestData); 

    if ($this->PromissoryNotes->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Promissory Note has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Promissory Note',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Promissory Note cannot updated this time.',

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

    $data = $this->PromissoryNotes->get($id);

    $data->visible = 0;

    if ($this->PromissoryNotes->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Promissory Note has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Promissory Note cannot be deleted at this time.'

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
