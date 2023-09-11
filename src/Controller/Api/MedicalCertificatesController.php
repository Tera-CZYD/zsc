<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class MedicalCertificatesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->MedicalCertificates = TableRegistry::getTableLocator()->get('MedicalCertificates');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

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

      $conditions['date'] = " AND DATE(MedicalCertificate.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }
    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(MedicalCertificate.date) >= '$start' AND DATE(MedicalCertificate.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }


    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND MedicalCertificate.status = $status";
 
      // $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Session->read('Auth.User.studentId');

      $conditions['studentId'] = "AND MedicalCertificate.student_id = $studentId";

      // $conditionsPrint .= '&per_student='.$per_student;

    }

    $dataTable = TableRegistry::getTableLocator()->get('MedicalCertificates');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllMedicalCertificate($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $medicalCertificates = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($medicalCertificates as $medicalCertificate) {

      $datas[] = array(
      
        'id'            => $medicalCertificate['id'],

        'code'          => $medicalCertificate['code'],

        'patient_name'  => $medicalCertificate['student_name'] != null ? $medicalCertificate['student_name'] : $medicalCertificate['employee_name'],

        'date'          => fdate($medicalCertificate['date'],'m/d/Y'),

        'description'   => $medicalCertificate['description'],

        'course'        => $medicalCertificate['code'],

        'year'          => $medicalCertificate['description'],

        'description'   => $medicalCertificate['description'],

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

    $requestData = $this->request->getData('MedicalCertificate');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->MedicalCertificates->newEmptyEntity();
   
    $data = $this->MedicalCertificates->patchEntity($data, $requestData); 

    if ($this->MedicalCertificates->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Medical Certificate Request has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Medical Certificate Request',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Medical Certificate Request cannot saved this time.',

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

    $building = $this->MedicalCertificates->get($id); 

    $requestData = $this->getRequest()->getData('MedicalCertificate');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->MedicalCertificates->patchEntity($building, $requestData); 

    if ($this->MedicalCertificates->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Medical Certificate Request has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Medical Certificate Request',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Medical Certificate Request cannot updated this time.',

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

    $data = $this->MedicalCertificates->get($id);

    $data->visible = 0;

    if ($this->MedicalCertificates->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Medical Certificate has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Medical Certificate',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Medical Certificate cannot be deleted at this time.'

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
