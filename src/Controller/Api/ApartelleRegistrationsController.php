<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'PHPMailer/Exception.php';

include 'PHPMailer/PHPMailer.php';

include 'PHPMailer/SMTP.php';

class ApartelleRegistrationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->ApartelleRegistrations = TableRegistry::getTableLocator()->get('ApartelleRegistrations');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    $condition['search'] = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND ApartelleRegistration.approve = $status";
 
      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

      $per_student = $this->request->getQuery('per_student');
      
      $studentId = $this->Auth->user('studentId');

      $conditions['studentId'] = "AND ApartelleRegistration.student_id = $studentId";

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $dataTable = TableRegistry::getTableLocator()->get('ApartelleRegistrations');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllApartelleRegistration($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $apartelleRegistrations = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($apartelleRegistrations as $apartelleRegistration) {

      $datas[] = array(

        'id'                       => $apartelleRegistration['id'],

        'code'                     => $apartelleRegistration['code'],

        'student_name'             => $apartelleRegistration['student_name'],

        'nick_name'                => $apartelleRegistration['nick_name'],

        'date_of_birth'            => fdate($apartelleRegistration['date_of_birth'],'m/d/Y'),

        'address'                  => $apartelleRegistration['address'],

        'course'                   => $apartelleRegistration['program_code'],

        'year_level'               => $apartelleRegistration['description'],

        'status'                   => $apartelleRegistration['approve'],
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

    $requestData = $this->request->getData('ApartelleRegistration');

    $requestData['date_of_birth'] = isset($requestData['date_of_birth']) ? fdate($requestData['date_of_birth'],'Y-m-d') : NULL;

    $data = $this->ApartelleRegistrations->newEmptyEntity();
   
    $data = $this->ApartelleRegistrations->patchEntity($data, $requestData); 

    if ($this->ApartelleRegistrations->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Apartelle Registrations has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Apartelle Registrations',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Apartelle Registrations cannot saved this time.',

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

    $data['ApartelleRegistration'] = $this->ApartelleRegistrations->find()

      ->contain([

          'Apartelles',

          'CollegePrograms',

          'YearLevelTerms'

      ])

      ->where([

          'ApartelleRegistrations.visible' => 1,

          'ApartelleRegistrations.id' => $id

      ])

      ->first();

    $data['ApartelleRegistration']['date_of_birth'] = isset($data['ApartelleRegistration']['date_of_birth']) ? $data['ApartelleRegistration']['date_of_birth']->format('m/d/Y') : 'N/A';

    $data['CollegeProgram'] = $data['ApartelleRegistration']['college_program'];

    $data['Apartelle'] = $data['ApartelleRegistration']['apartelle'];

    $data['YearLevelTerm'] = $data['ApartelleRegistration']['year_level_term'];

    unset($data['ApartelleRegistration']['course']);

    unset($data['ApartelleRegistration']['apartelle']);

    unset($data['ApartelleRegistration']['year_level_term']);

    $data['ApartelleRegistration']['active_view'] = $data['ApartelleRegistration']['active'] ? 'True' : 'False';

    // $data['ApartelleRegistration']['date_of_birth'] = $data['ApartelleRegistration']['date_of_birth']->format('m/d/Y');

    $data['ApartelleRegistration']['floors'] = intval($data['ApartelleRegistration']['floors']);

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

    $building = $this->ApartelleRegistrations->get($id); 

    $requestData = $this->getRequest()->getData('ApartelleRegistration');

    $requestData['date_of_birth'] = isset($requestData['date_of_birth']) ? date('Y/m/d', strtotime($requestData['date_of_birth'])) : null;

    $requestData['date_of_birth'] = isset($requestData['date_of_birth']) ? fdate($requestData['date_of_birth'],'Y-m-d') : NULL;

    $this->ApartelleRegistrations->patchEntity($building, $requestData); 

    if ($this->ApartelleRegistrations->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Apartelle Registrations has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Apartelle Registrations',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Apartelle Registrations cannot updated this time.',

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

    $data = $this->ApartelleRegistrations->get($id);

    $data->visible = 0;

    if ($this->ApartelleRegistrations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Apartelle Registrations has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Apartelle Registrations',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Apartelle Registrations cannot be deleted at this time.'

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

    $data = $this->ApartelleRegistrations->get($id);

    $data->apartelle_id = @$this->request->getData('room');

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->ApartelleRegistrations->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Apartelle Registrations has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'approve',

          'description' => 'Apartelle Registrations',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Apartelle Registrations cannot be deleted at this time.'

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

    $data = $this->ApartelleRegistrations->get($id);

    $data->approve = 2;

    $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->ApartelleRegistrations->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Apartelle Registrations has been successfully disapproved.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Apartelle Registrations',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Apartelle Registrations cannot be disapproved this time.'

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

  public function email(){

    $this->autoRender = false;

    $request = $this->request->getData();

    $app = $this->ApartelleRegistrations->find()

    ->contain([

          'Students',

      ])
    ->where([
        'ApartelleRegistrations.visible' => 1,
        'ApartelleRegistrations.id' => $request['reference_id']
    ])
    ->first();

    //EMAIL VERIFICATION

    $name = $app['student']['first_name'].' '.substr($app['student']['middle_name'],0,1).'. '.$app['student']['last_name'];

        $app_no = $app['student']['application_no'];

        $email = $app['student']['email'];

        // var_dump($email);

      if(isset($email)){

        //EMAIL VERIFICATION
        if(isset($email)){

          if($email != ''){

            // fix value
        
            $mail = new PHPMailer(true);

            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address
            $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name
            $mail->addAddress($email, $name); // Recipient's email and name

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Apartelle Registration Interview Schedule';
            $_SESSION['name'] = @$name; 

            $_SESSION['code'] = @$app['code'];

            $_SESSION['student_no'] = @$app['student']['student_no'];

            $_SESSION['date'] = fdate(@$request['date'],'F d, Y'); 

            $_SESSION['time'] = @$request['time']; 

            $_SESSION['place'] = @$request['place']; 

            $_SESSION['room'] = @$request['room'];

            $_SESSION['id'] = @$request['reference_id'];

                 ob_start();

            include('Email/apartelle-registration.ctp');

            $bodyContent = ob_get_contents();

            ob_end_clean();

            $mail->Body = $bodyContent;
                

            $mail->send();

          }

        }

      }

    //EMAIL VERIFICATION

    $response = array(

      'ok'   => true,

      'data' => $app,       

      'msg'  => 'Email notification has been sent.'

    );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Send Interview Schedule',

          'userId' => $this->Auth->user('id'),

          'description' => 'Apartelle REgistration',

          'code' => '',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

}
