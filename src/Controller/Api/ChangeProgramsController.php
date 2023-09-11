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


class ChangeProgramsController extends AppController {

  public function beforeFilter(\Cake\Event\EventInterface $event) {

    parent::beforeFilter($event);

    $this->Auth->allow('add');

  }
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->StudentApplications = TableRegistry::getTableLocator()->get('StudentApplications');

    $this->CollegePrograms = TableRegistry::getTableLocator()->get('CollegePrograms');

  }

  public function index(){}

  public function add(){

    $main = $this->request->getData('StudentApplication');

    $data['id'] = $main['id'];

    $data['approve'] = 1;

    $data['preferred_program_id'] = $main['preferred_program_id'];

    $pref = $this->CollegePrograms->find()

        ->where([

            'visible' => 1,

            'id' => $data['preferred_program_id']

        ])

        ->first();

     $app = $this->StudentApplications->find()

        ->where([

            'visible' => 1,

            'id' => $data['id']

        ])

        ->first();

      $studentApplication = $this->StudentApplications->newEntity($data);

      $studentApplication = $this->StudentApplications->patchEntity($studentApplication, $data);

      
      if($this->StudentApplications->save($studentApplication)){

        if(isset($app['email'])){

        $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

        $email = $app['email'];

        $student_no = $app['student_no'];

        $preferred = $pref['name'];

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
              $mail->Subject = 'Change Program Successful';

              $_SESSION['name'] = $name; 

              $_SESSION['date'] = date('Y-m-d'); 

              $_SESSION['student_no'] = $student_no; 

              $_SESSION['pref_prog'] = $preferred; 

              ob_start();

              include('Email/change-program.ctp');

              $bodyContent = ob_get_contents();

              ob_end_clean();

              $mail->Body = $bodyContent;
                  

              $mail->send();

            }

        }

      }
    }


    $response = array(

      'ok'   => true,

      'data' => $app,       

      'msg'  => 'Email notification has been sent.'

    );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'send Email',

          'userId' => $this->Auth->user('id'),

          'description' => 'CAT',

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

  public function view($id = null){

    $data['Account'] = $this->Accounts->find()

      ->where([

        'visible' => 1,

        'id' => $id

      ])

      ->first();

    $data['Account']['active_view'] = $data['Account']['active'] ? 'True' : 'False';

    $data['Account']['floors'] = intval($data['Account']['floors']);

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

    $building = $this->Accounts->get($id); 

    $requestData = $this->getRequest()->getData('Account');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $this->Accounts->patchEntity($building, $requestData); 

    if ($this->Accounts->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Chart of Accounts has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Chart of Accounts',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Chart of Accounts cannot updated this time.',

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

    $data = $this->Accounts->get($id);

    $data->visible = 0;

    if ($this->Accounts->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Chart of Accounts has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Chart of Accounts',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Chart of Accounts cannot be deleted at this time.'

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
