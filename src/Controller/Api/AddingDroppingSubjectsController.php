<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
 

class AddingDroppingSubjectsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('Paginator');

    $this->loadComponent('RequestHandler');

    $this->AddingDroppingSubjects = TableRegistry::getTableLocator()->get('AddingDroppingSubjects');

    $this->AddingDroppingSubjectSubs = TableRegistry::getTableLocator()->get('AddingDroppingSubjectSubs');

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

      $conditions['date'] = " AND DATE(AddingDroppingSubject.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    if ($this->request->getQuery('program')) {

      $program_id = $this->request->getQuery('program');

      $conditions['advSearch'] = "AND AddingDroppingSubject.course_program_id = $program_id"; 

      $conditionsPrint .= '&program='.$program_id;

    }

    //advance search

    if ($this->request->getQuery('startDate') != null ) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(AddingDroppingSubject.date) >= '$start' AND DATE(AddingDroppingSubject.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

     $conditions['status'] = '';

    if ($this->request->getQuery('status') != null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND AddingDroppingSubject.approve = $status";

      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student') != null ) {
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND AddingDroppingSubject.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$studentId;

    }

    $limit = 25;

    $tmpData = $this->AddingDroppingSubjects->paginate($this->AddingDroppingSubjects->getAllAddingDroppingSubject($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $adding_dropping_subjects = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($adding_dropping_subjects as $data) {

      $datas[] = array(

          'id'            => $data['id'],
          
          'student_name'  => $data['student_name'],

          'date'          => fdate($data['date'],'m/d/Y'),

          'code'          => $data['code'],

          // 'course_program_id'  => $data['AddingDroppingSubject']['name'],

          'program'       => $data['program'],

          'status'        => $data['approve'],

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

    $requestData = $this->request->getData('AddingDroppingSubject');

    $subs = $this->request->getData('AddingDroppingSubjectSub');

    $requestData['date'] = isset($requestData['date']) ? date('Y-m-d', strtotime($requestData['date'])) : null;

    $data = $this->AddingDroppingSubjects->newEmptyEntity();
   
    $data = $this->AddingDroppingSubjects->patchEntity($data, $requestData); 

    if ($this->AddingDroppingSubjects->save($data)) {

       $id = $data->id;



      if (count($subs) > 0) {
          foreach ($subs as $sub) {

          $subEntities = $this->AddingDroppingSubjectSubs->newEntity([

              'adding_dropping_subject_id' => $id,

              'course_title' => $sub['course_title'],

              'faculty_id' => $sub['faculty_id'],

              'faculty_name' => $sub['faculty_name'],

              'status' => $sub['status'],

          ]);

          $this->AddingDroppingSubjectSubs->save($subEntities);
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Adding Dropping Subject has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Adding Dropping Subject Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Adding Dropping Subject cannot saved this time.',

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

  public function view($id = null){

      $data['AddingDroppingSubject'] = $this->AddingDroppingSubjects->find()

        ->contain([

            'Students',

            'AddingDroppingSubjectSubs' => [

              'conditions' => ['AddingDroppingSubjectSubs.visible' => 1] 

            ]

        ])

        ->where([

            'AddingDroppingSubjects.visible' => 1,

            'AddingDroppingSubjects.id'      => $id,

        ])

        ->first();

    $data = [

        'AddingDroppingSubject' => $data['AddingDroppingSubject'],

        'AddingDroppingSubjectSub' => $data['AddingDroppingSubject']->adding_dropping_subject_subs, 

        'Student' => $data['AddingDroppingSubject']->student

    ];

    unset($data['AddingDroppingSubject']->adding_dropping_subject_subs);

    unset($data['AddingDroppingSubject']->student);

    $data['AddingDroppingSubject']['date'] = isset($data['AddingDroppingSubject']['date']) ? date('m/d/Y', strtotime($data['AddingDroppingSubject']['date'])) : null;

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


  public function edit($id = null)
  {
      $this->autoRender = false;

      $main = $this->request->getData('AddingDroppingSubject');

      $subs = $this->request->getData('AddingDroppingSubjectSub');

      $id = $main['id'];

      $data = $this->AddingDroppingSubjects->get($id);

      $main['date'] = isset($main['date']) ? date('Y-m-d', strtotime($main['date'])) : null;

      $data = $this->AddingDroppingSubjects->patchEntity($data, $main);

      if ($this->AddingDroppingSubjects->save($data)) {

          $this->AddingDroppingSubjects->AddingDroppingSubjectSubs->deleteAll(['adding_dropping_subject_id' => $id]);

          if (count($subs) > 0) {

          foreach ($subs as $sub) {

              $subEntities = $this->AddingDroppingSubjectSubs->newEntity([

                  'adding_dropping_subject_id' => $id,

                  'course_title' => $sub['course_title'],

                  'faculty_id' => $sub['faculty_id'],

                  'faculty_name' => $sub['faculty_name'],

                  'status' => $sub['status'],

                  'visible' => $sub['visible'],

              ]);

              $this->AddingDroppingSubjectSubs->save($subEntities);
          }
        }

          $response = [
              'ok' => true,
              'msg' => 'Adding Dropping Subject has been successfully updated.',
              'data' => $main,
          ];

          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
          $userLogEntity = $userLogTable->newEntity([

              'action' => 'Edit',

              'description' => 'Adding Dropping Subject Management',

              'code' => $main['code'],

              'created' => date('Y-m-d H:i:s'),

              'modified' => date('Y-m-d H:i:s')

          ]);
          
          $userLogTable->save($userLogEntity);

      } else {

          $response = [

              'ok' => false,

              'data' => $main,

              'msg' => 'Adding Dropping Subject could not be updated this time.',

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

    $data = $this->AddingDroppingSubjects->get($id);

    $data->visible = 0;

    if ($this->AddingDroppingSubjects->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Adding Dropping Subject Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'Adding Dropping Subject has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Adding Dropping Subject cannot be deleted at this time.'

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

    public function approve($id = null){

    $this->autoRender = false;

    $data = $this->AddingDroppingSubjects->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->AddingDroppingSubjects->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Adding Dropping Subject has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Adding Dropping Subject',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Adding Dropping Subject cannot be deleted at this time.'

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
  public function disapprove($id = null){

    $this->autoRender = false;

    $data = $this->AddingDroppingSubjects->get($id);

    $data->approve = 2;

    $data->disapprove_by_id = $this->currentUser->id;
    // $requestData = $this->getRequest()->getData('explanation');
    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->AddingDroppingSubjects->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Adding Dropping Subject has been successfully disapproved.'

      );
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Adding Dropping Subject',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Adding Dropping Subject cannot be disapproved this time.'

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
