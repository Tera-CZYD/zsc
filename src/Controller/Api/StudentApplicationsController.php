<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use App\Model\Entity\StudentApplication;
use App\Model\Entity\Student;

use Cake\View\ViewBuilder;
use Cake\View\Helper\UrlHelper;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'PHPMailer/Exception.php';

include 'PHPMailer/PHPMailer.php';

include 'PHPMailer/SMTP.php';

require 'SMS/vendor/autoload.php';
use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

class StudentApplicationsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->loadComponent('Global');

    $this->StudentApplications = TableRegistry::getTableLocator()->get('StudentApplications');

    $this->Users = TableRegistry::getTableLocator()->get('Users');

    $this->StudentApplicationImages = TableRegistry::getTableLocator()->get('StudentApplicationImages');

    $this->CollegeProgram = TableRegistry::getTableLocator()->get('CollegePrograms');

    $this->CollegeProgramSubs = TableRegistry::getTableLocator()->get('CollegeProgramSubs');

    $this->Student = TableRegistry::getTableLocator()->get('Students');

    $this->Room = TableRegistry::getTableLocator()->get('Rooms');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

    $this->viewBuilder = new ViewBuilder();

    $this->view = $this->viewBuilder->build();

    $this->urlHelper = new UrlHelper($this->view);

    $this->base = $this->urlHelper->build('/', ['fullBase' => true]);

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date') != null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(StudentApplication.application_date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(StudentApplication.application_date) >= '$start' AND DATE(StudentApplication.application_date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['status'] = '';

    if ($this->request->getQuery('status') != null) {

      $status = $this->request->getQuery('status');

      $conditions['status'] = "AND StudentApplication.approve = $status";

      $conditionsPrint .= '&status='.$this->request->getQuery('status');

      if($status == 1){ //FOR APPROVED TAB OF STUDENT APPLICATION

        $conditions['status'] = "AND StudentApplication.approve <> 0";

      }elseif($status == 'forRating'){ //RATING TAB OF CAT

        $conditions['status'] = "AND StudentApplication.approve = 1";

      }

    }

    $conditions['order'] = '';

    if ($this->request->getQuery('order') != null){

      $order = $this->request->getQuery('order');

      $conditions['order'] = $order;

      $conditionsPrint .= '&order='.$order;
      
    }

    $entries = 25;

    if ($this->request->getQuery('entries') != null){

      $entries = $this->request->getQuery('entries');
      
    }

    $limit = $entries;

    $tmpData = $this->StudentApplications->paginate($this->StudentApplications->getAllStudentApplication($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $main = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($main as $data) {

      $datas[] = array(

        'id'                => $data['id'],

        'full_name'         => $data['full_name'],

        'email'             => $data['email'],

        'address'           => $data['address'],

        'contact_no'        => $data['contact_no'],

        'gender'            => $data['gender'],

        'application_date'  => fdate($data['application_date'],'m/d/Y'),

        'rate'              => $data['rate'],

        'status'            => $data['status'],

        'request_purpose'   => $data['request_purpose'],

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

        'YearLevelTerms',

        'Colleges',

        'PreferredPrograms',

        'SecondaryPrograms',

        'StudentApplicationImages' => [

          'conditions' => [

            'StudentApplicationImages.visible' => 1

          ]

        ],

        'StudentEnrolledCourses' => [

            'conditions' => [

              'StudentEnrolledCourses.visible' => 1

            ]

        ],

        'StudentEnrolledUnits' => [

          'conditions' => [

            'StudentEnrolledUnits.visible' => 1

          ]

        ],

        'StudentEnrollments' => [

          'conditions' => [

            'StudentEnrollments.visible' => 1

          ]

        ]

      ])

      ->where([

        'StudentApplications.visible' => 1,

        'StudentApplications.id' => $id

      ])

    ->first();

    // var_dump($data['StudentApplication']['college_program']);

    $data['StudentApplication']['birth_date'] = isset($data['StudentApplication']['birth_date']) ? date('m/d/Y', strtotime($data['StudentApplication']['birth_date'])) : '';

    $data['StudentApplication']['approved_date'] = isset($data['StudentApplication']['approved_date']) ? date('m/d/Y', strtotime($data['StudentApplication']['approved_date'])) : '';

    $data['StudentApplication']['disapproved_date'] = isset($data['StudentApplication']['disapproved_date']) ? date('m/d/Y', strtotime($data['StudentApplication']['disapproved_date'])) : '';

    $data['StudentApplicationImage'] = $data['StudentApplication']['student_application_images'];

    $data['College'] = $data['StudentApplication']['college'];

    $data['CollegeProgram'] = $data['StudentApplication']['preferred_program'];

    $data['CollegeProgramSecondary'] = $data['StudentApplication']['secondary_program'];

    $data['YearLevelTerm'] = $data['StudentApplication']['year_level_term'];

    unset($data['StudentApplication']['student_application_image']);

    unset($data['StudentApplication']['college']);

    unset($data['StudentApplication']['preferred_program']);

    unset($data['StudentApplication']['year_level_term']);

    unset($data['StudentApplication']['secondary_program']);

    $applicationImage = array();

    if(!empty($data['StudentApplicationImage'])){

      foreach($data['StudentApplicationImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $applicationImage[] = array(

            'imageSrc' => $this->base . '/uploads/student-application/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }

    }

    $requirements = $this->CollegeProgramSubs->find()

      ->where([

        'visible' => 1,

        'college_program_id' => $data['StudentApplication']['preferred_program_id']

      ])

    ->all();

    $response = array(

      'ok'   => true,

      'data' => $data,

      'requirement' => $requirements,

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

  public function add() { 

    if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

      $requestData = $this->request->getData('data');

      $main = json_decode($requestData, true);

      $main['StudentApplication']['application_date'] = date('Y-m-d');

      $main['StudentApplication']['year_term_id'] = 1;

      $main['StudentApplication']['birth_date'] = isset($main['StudentApplication']['birth_date']) ? fdate($main['StudentApplication']['birth_date'],'Y-m-d') : null;

      $uploadedFiles = $this->request->getUploadedFiles();

      // debug($uploadedFiles['attachment']);

      $save = $this->StudentApplications->validSave($main['StudentApplication']);

      if ($save['ok']) {

        $id = $save['data']['id'];

        // $id = $this->StudentApplications->getLastInsertId();

        foreach ($uploadedFiles as $fieldName => $images) {

          $path = "uploads/student-application/$id";

          if (!file_exists($path)) {

            mkdir($path, 0777, true);

          }

          foreach ($images as $ctr => $image) {

            $filename = $image->getClientFilename();

            $image->moveTo($path . '/' . $filename);

            $names[$ctr] = $filename;

          }

        }


        $newPRImage = @$_FILES['attachment']['name'];

        $datasImages = [];

        if (!empty($newPRImage)) {

          if (isset($main['StudentApplicationImage'])) {

            foreach ($main['StudentApplicationImage'][count($main['StudentApplicationImage']) - 1]['images'] as $key => $valueImages) {

              $valueImages['images'] = $names[$key];

              $valueImages['application_id'] = $id;

              $datasImages[] = $valueImages;

            }

            $entities = $this->StudentApplicationImages->newEntities($datasImages);

            $this->StudentApplicationImages->saveMany($entities);

          }

        }

        $response = $save;

        $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Student Applciation Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);

      }else{

        $response = $save;

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

  public function edit($id = null) {

    $student_application = $this->StudentApplications->get($id);

    $requestData = $this->getRequest()->getData('StudentApplication');

    $requestData['birth_date'] = isset($requestData['birth_date']) ? date('Y-m-d', strtotime($requestData['birth_date'])) : null;

    $this->StudentApplications->patchEntity($student_application, $requestData);

    if ($this->StudentApplications->save($student_application)) {

      $response = [

        'ok' => true,

        'msg' => 'Student Application has been successfully updated.',

        'data' => $requestData,

      ];

      $userLogEntity = $this->UserLogs->newEntity([

        'action' => 'Edit',

        'description' => 'Student Application Management',

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s'),

      ]);

      $this->UserLogs->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Student Application cannot be updated at this time.',

        'data' => $requestData,

      ];

    }

    $this->set([

      'response' => $response,

      '_serialize' => 'response',

    ]);

    $this->response = $this->response->withType('application/json');

    $this->response = $this->response->withStringBody(json_encode($response));

    return $this->response;

  }

  public function delete($id = null) {

    $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->StudentApplications->get($id);

    $data->visible = 0;

    if ($this->StudentApplications->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Students Application has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'userId' => $this->Auth->user('id'),

          'description' => 'Students Application Management',

          'code' => $data->student_no,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Students Application cannot be deleted at this time.'

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

  public function deleteImage($id = null){

    $data = $this->StudentApplicationImages->get($id);

    $path = "uploads/student-application/" . $data->application_id;

    $orgFile = $path . '/' . $data->images;

    $data->visible = 0;

    if ($this->StudentApplicationImages->save($data)) {

        if (file_exists($orgFile)) {

            unlink($orgFile);

        }

        $response = [

            'ok' => true,

            'data' => $id,

            'msg' => 'File has been deleted.'

        ];

    } else {

        $response = [

            'ok' => false,

            'data' => $id

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

    $app = $this->StudentApplications->get($id);

    $app->approve = 1;

    $app->approved_by_id = $this->currentUser->id;

    $app->status = 'APPROVED';

    $email = $app->email;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        if ($this->StudentApplications->save($app)) {

        //EMAIL VERIFICATION

          $name = @$app['first_name'].' '.@$app['middle_name'].' '.@$app['last_name'];

          $email = @$app['email'];

          if(isset($app['email'])){

            $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

            $app_no = $app['application_no'];

            $email = $app['email'];

            if($email != ''){

              // fix value
        
              $mail = new PHPMailer(true);

              $mail->isSMTP(); // Send using SMTP

              $mail->Host = 'smtp.gmail.com';

              $mail->SMTPAuth = true;

              $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

              $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

              $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

              $mail->Port = 587; // TCP port to connect to

              // Bypass SSL certificate verification
              $mail->SMTPOptions = [

                'ssl' => [

                  'verify_peer' => false,

                  'verify_peer_name' => false,

                  'allow_self_signed' => true,

                ],

              ];

              //Recipients

              $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

              $mail->addAddress($email, $name); // Recipient's email and name

              // Content
              $mail->isHTML(true); // Set email format to HTML

              $mail->Subject = 'Application Status';

              $_SESSION['name'] = @$name; 

              $_SESSION['application_no'] = @$app['application_no'];

              $_SESSION['id'] = $id; 

              ob_start();

              include('Email/admission-application-approved.ctp');

              $bodyContent = ob_get_contents();

              ob_end_clean();

              $mail->Body = $bodyContent;
                  
              $mail->send();

            }

          }

        //EMAIL VERIFICATION

        //SMS NOTIFICATION

          // if($app['contact_no'] != null){

          //   $contact_no = $app['contact_no'];

          //   $BASE_URL = "https://l3zndj.api.infobip.com";

          //   $API_KEY = "c1ad2a470047d8d917fbb56151e22f85-5b4c9dc0-01cc-4a5f-b46f-d29ddad4997d";

          //   $SENDER = "InfoSMS";

          //   //SAMPLE CONTACT NUMBER FORMAT
          //   //639178673561

          //   $RECIPIENT = $contact_no;

          //   $MESSAGE_TEXT = "Hi, Greetings from Zamboanga State College of Marine Sciences and Technology. \n\nThis is to notify you that your application passed the requirements. Please wait for further instructions regarding your exmaination.";

          //   $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

          //   $sendSmsApi = new SmsApi(config: $configuration);

          //   $destination = new SmsDestination(

          //     to: $RECIPIENT

          //   );

          //   $message = new SmsTextualMessage(destinations: [$destination], from: $SENDER, text: $MESSAGE_TEXT);

          //   $request = new SmsAdvancedTextualRequest(messages: [$message]);

          //   try {

          //     $smsResponse = $sendSmsApi->sendSmsMessage($request);

          //     // echo $smsResponse->getBulkId() . PHP_EOL;

          //     // foreach ($smsResponse->getMessages() ?? [] as $message) {

          //     //   echo sprintf('Message ID: %s, status: %s', $message->getMessageId(), $message->getStatus()?->getName()) . PHP_EOL;

          //     // }

          //   } catch (Throwable $apiException) {

          //     // echo("HTTP Code: " . $apiException->getCode() . "\n");

          //   }

          // }

        //END 

        $response = array(

          'ok'   => true,

          'data' => $app,       

          'msg'  => 'Examinee has been successfully rated.'

        );
            $userLogEntity = $this->UserLogs->newEntity([

            'action' => 'CAT',

            'description' => 'Qualify'.@$app['StudentApplication']['first_name'].' '.@$app['StudentApplication']['last_name'],

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s')

          ]);

          $this->UserLogs->save($userLogEntity);

      } else {

        $response = array(

          'ok'   => false,

          'data' => $app,

          'msg'  =>'Examinee cannot be rated this time.'

        );

      }

    } else {

        $response = array(

        'ok'   => false,

        'data' => $app,

        'msg'  =>'Invalid Email can not Approved student.'

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

  public function disapprove($id = null){
    
    $this->autoRender = false;

    $app = $this->StudentApplications->get($id);

    $app->approve = 2;

    $app->disapproved_by_id = $this->currentUser->id;

    $app->disapproved_reason = $this->getRequest()->getData('explanation');

    $app->status = 'DISAPPROVED';

    $email = $app->email;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

      if ($this->StudentApplications->save($app)) {

        //EMAIL VERIFICATION

          $name = @$app['first_name'].' '.@$app['middle_name'].' '.@$app['last_name'];

          $email = @$app['email'];

          if(isset($app['email'])){

            $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

            $app_no = $app['application_no'];

            $email = $app['email'];

            if($email != ''){

              // fix value
          
              $mail = new PHPMailer(true);

              $mail->isSMTP(); // Send using SMTP

              $mail->Host = 'smtp.gmail.com';

              $mail->SMTPAuth = true;

              $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

              $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

              $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

              $mail->Port = 587; // TCP port to connect to

              // Bypass SSL certificate verification
              $mail->SMTPOptions = [

                'ssl' => [

                  'verify_peer' => false,

                  'verify_peer_name' => false,

                  'allow_self_signed' => true,

                ],

              ];

              //Recipients

              $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

              $mail->addAddress($email, $name); // Recipient's email and name

              // Content

              $mail->isHTML(true); // Set email format to HTML

              $mail->Subject = 'Application Status';

              $_SESSION['name'] = @$name; 

              $_SESSION['application_no'] = @$app['application_no'];

              $_SESSION['disapproved_reason'] = @$app['disapproved_reason'];

              $_SESSION['id'] = $id; 

              ob_start();

              include('Email/admission-application-disapproved.ctp');

              $bodyContent = ob_get_contents();

              ob_end_clean();

              $mail->Body = $bodyContent;
                  
              $mail->send();

            }

          }

        //EMAIL VERIFICATION

        //SMS NOTIFICATION

          // if($app['contact_no'] != null){

          //   $contact_no = $app['contact_no'];

          //   $BASE_URL = "https://l3zndj.api.infobip.com";

          //   $API_KEY = "c1ad2a470047d8d917fbb56151e22f85-5b4c9dc0-01cc-4a5f-b46f-d29ddad4997d";

          //   $SENDER = "InfoSMS";

          //   //SAMPLE CONTACT NUMBER FORMAT
          //   //639178673561

          //   $RECIPIENT = $contact_no;

          //   $MESSAGE_TEXT = "Hi, Greetings from Zamboanga State College of Marine Sciences and Technology. \n\nThis is to notify you that your application did not passed the requirements";

          //   $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

          //   $sendSmsApi = new SmsApi(config: $configuration);

          //   $destination = new SmsDestination(

          //     to: $RECIPIENT

          //   );

          //   $message = new SmsTextualMessage(destinations: [$destination], from: $SENDER, text: $MESSAGE_TEXT);

          //   $request = new SmsAdvancedTextualRequest(messages: [$message]);

          //   try {

          //     $smsResponse = $sendSmsApi->sendSmsMessage($request);

          //     // echo $smsResponse->getBulkId() . PHP_EOL;

          //     // foreach ($smsResponse->getMessages() ?? [] as $message) {

          //     //   echo sprintf('Message ID: %s, status: %s', $message->getMessageId(), $message->getStatus()?->getName()) . PHP_EOL;

          //     // }

          //   } catch (Throwable $apiException) {

          //     // echo("HTTP Code: " . $apiException->getCode() . "\n");

          //   }

          // }

        //END

        $response = array(

          'ok'   => true,

          'data' => $app,       

          'msg'  => 'Examinee has been successfully rated.'

        );
            $userLogEntity = $this->UserLogs->newEntity([

            'action' => 'CAT',

            'description' => 'Unqualify'.@$app['StudentApplication']['first_name'].' '.@$app['StudentApplication']['last_name'],

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s')

          ]);

          $this->UserLogs->save($userLogEntity);

      } else {

        $response = array(

          'ok'   => false,

          'data' => $app,

          'msg'  =>'Examinee cannot be rated this time.'

        );

      }

    }else {

      $response = array(

        'ok'   => false,

        'data' => $app,

        'msg'  =>'Ivalid Email can not be disapproved this time.'

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

  public function bulkEmail(){

    $this->autoRender = false;

    $request = $this->request->getData();

    if(!empty($request)){

      foreach ($request as $key => $value) {

        $app = $this->StudentApplications->get($value['student_id']); 

        //EMAIL VERIFICATION

          if(isset($app['email'])){

            $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

            $email = $app['email'];

            if(isset($email)){

              if($email != ''){

                $mail = new PHPMailer(true);

                $mail->isSMTP(); // Send using SMTP

                $mail->Host = 'smtp.gmail.com';
                
                $mail->SMTPAuth = true;
               
                $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address
               
                $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password
               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
               
                $mail->Port = 587; // TCP port to connect to

                // Bypass SSL certificate verification
                $mail->SMTPOptions = [

                  'ssl' => [

                    'verify_peer' => false,

                    'verify_peer_name' => false,

                    'allow_self_signed' => true,

                  ],

                ];

                //Recipients
                $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

                $mail->addAddress($email, $name); // Recipient's email and name

                // Content
                $mail->isHTML(true); // Set email format to HTML

                $mail->Subject = 'CAT details';

                $_SESSION['name'] = $name; 

                $_SESSION['date'] = fdate($value['date'],'F d, Y'); 

                $_SESSION['time'] = $value['time']; 

                $_SESSION['place'] = $value['place']; 

                $_SESSION['id'] = $value['student_id'];

                ob_start();

                include('Email/cat-email.ctp');

                $bodyContent = ob_get_contents();

                ob_end_clean();

                $mail->Body = $bodyContent;

                $mail->send();

              }

            }

          }

        //EMAIL VERIFICATION

        //SAVING 

          $value['date'] = isset($value['date']) ? fdate($value['date'],'Y-m-d') : null;
            
          $entity = $this->StudentApplications->newEntity([

            'id' => $value['student_id'],

            'date' => $value['date'],

            'time' => $value['time'],

            'place' => $value['place'],

          ]);
          
          $this->StudentApplications->save($entity);

        //SAVING

      }

    }

    $response = array(

      'ok'   => true,   

      'msg'  => 'Email notification has been sent.'

    );

    $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
      
    $userLogEntity = $userLogTable->newEntity([

        'action' => 'Bulk Email Notification',

        'userId' => $this->Auth->user('id'),

        'description' => 'CAT',

        'code' => '',

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

    ]);
    
    $userLogTable->save($userLogEntity);

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

    $app = $this->StudentApplications->find()

      ->where([

        'StudentApplications.visible' => 1,

        'StudentApplications.id' => $request['reference_id']
      ])

    ->first();

    //EMAIL VERIFICATION

      if(isset($app['email'])){

        $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

        $app_no = $app['application_no'];

        $email = $app['email'];

        //EMAIL VERIFICATION

        if(isset($email)){

          if($email != ''){

            // fix value
        
            $mail = new PHPMailer(true);

            $mail->isSMTP(); // Send using SMTP

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

            $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

            $mail->Port = 587; // TCP port to connect to

            // Bypass SSL certificate verification
            $mail->SMTPOptions = [

              'ssl' => [

                'verify_peer' => false,

                'verify_peer_name' => false,

                'allow_self_signed' => true,

              ],

            ];

            //Recipients
            $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

            $mail->addAddress($email, $name); // Recipient's email and name

            // Content
            $mail->isHTML(true); // Set email format to HTML

            $mail->Subject = 'CAT Schedule';

            $_SESSION['name'] = $name; 

            $_SESSION['date'] = fdate($request['date'],'F d, Y'); 

            $_SESSION['time'] = $request['time']; 

            $_SESSION['place'] = $request['place']; 

            $_SESSION['id'] = $request['reference_id'];

            ob_start();

            include('Email/cat-email.ctp');

            $bodyContent = ob_get_contents();

            ob_end_clean();

            $mail->Body = $bodyContent;
                

            $mail->send();

          }

        }

      }

    //EMAIL VERIFICATION

    //SAVING 

    if(!empty($request)) {

      $request['date'] = isset($request['date']) ? fdate($request['date'],'Y-m-d') : null;

       $query = new StudentApplication([

        'id' => $request['reference_id'],

        'date' => $request['date'],

        'time' => $request['time'],

        'place' => $request['place'],

      ]);

      $this->StudentApplications->save($query);

    }

    //SAVING

    //SMS NOTIFICATION

      $link = $this->base.'change-program/'.$app['id'];

      if($app['contact_no'] != null){

        $contact_no = $app['contact_no'];

        $BASE_URL = "https://l3zndj.api.infobip.com";

        $API_KEY = "c1ad2a470047d8d917fbb56151e22f85-5b4c9dc0-01cc-4a5f-b46f-d29ddad4997d";

        $SENDER = "InfoSMS";

        //SAMPLE CONTACT NUMBER FORMAT
        //639178673561

        $RECIPIENT = $contact_no;

        $MESSAGE_TEXT = "Hi, Greetings from Zamboanga State College of Marine Sciences and Technology. \n\nThis is to notify you about the details of your College Examination Test. \n\nDate : ". fdate($request['date'],'F d, Y')."\n\nTime : ".$request['time']."\n\nPlace : ".$request['place'];


        $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

        $sendSmsApi = new SmsApi(config: $configuration);

        $destination = new SmsDestination(

          to: $RECIPIENT

        );

        $message = new SmsTextualMessage(destinations: [$destination], from: $SENDER, text: $MESSAGE_TEXT);

        $request = new SmsAdvancedTextualRequest(messages: [$message]);

        try {

          $smsResponse = $sendSmsApi->sendSmsMessage($request);

          // echo $smsResponse->getBulkId() . PHP_EOL;

          // foreach ($smsResponse->getMessages() ?? [] as $message) {

          //   echo sprintf('Message ID: %s, status: %s', $message->getMessageId(), $message->getStatus()?->getName()) . PHP_EOL;

          // }

        } catch (Throwable $apiException) {

          // echo("HTTP Code: " . $apiException->getCode() . "\n");

        }

      }

    //END 

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

  public function rate($id = null){

    $this->autoRender = false;

    $app = $this->StudentApplications->get($id);

    $data['id'] = $id;

    $app->approve = 3;

    $app->rated_date = date('Y-m-d');

    $app->rate_by_id = $this->Auth->user('id');

    $app->rate = @$this->request->getData('rate');

    $app->status = 'FOR INTERVIEW REQUEST';

    if($this->StudentApplications->save($app)){

      //LIST OF PROGRAMS BASED ON RATE

        $program = $this->CollegeProgram->get($app['preferred_program_id']);

        if(!empty($program)){ 

          if($program['passing_rate'] > $app['rate']){ // EMAIL FOR FAILED

            $program_list = $this->CollegeProgram->find()

              ->where([

                'visible' => 1,

                'passing_rate <=' => $app['rate']

              ])

            ->all();

            $list = array();

            if(!empty($program_list)){

              foreach ($program_list as $keys => $values) {
                
                $list[$keys]['name'] = $values['name'];

              }

            }

            //EMAIL VERFIFICATION

              if(isset($app['email'])){

                $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

                $app_no = $app['application_no'];

                $email = $app['email'];

                if(isset($email)){

                  if($email != ''){
              
                    $mail = new PHPMailer(true);

                    //Server settings

                    $mail->isSMTP(); // Send using SMTP

                    $mail->Host = 'smtp.gmail.com';

                    $mail->SMTPAuth = true;

                    $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

                    $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

                    $mail->Port = 587; // TCP port to connect to

                    // Bypass SSL certificate verification
                    $mail->SMTPOptions = [

                      'ssl' => [

                        'verify_peer' => false,

                        'verify_peer_name' => false,

                        'allow_self_signed' => true,

                      ],

                    ];

                    //Recipients
                    $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

                    $mail->addAddress($email, $name); // Recipient's email and name

                    // Content
                    $mail->isHTML(true); // Set email format to HTML

                    $mail->Subject = 'CAT Details';

                    $_SESSION['application_no'] = $app_no; 

                    $_SESSION['name'] = $name; 

                    $_SESSION['rate'] = @$this->request->getData('rate');

                    $_SESSION['preferred_program'] = $program['name']; 

                    $_SESSION['program_list'] = $list; 

                    $_SESSION['base'] = $this->base; 

                    $_SESSION['id'] = $app['id'];

                    ob_start();

                    include('Email/cat-result-email-failed.ctp');

                    $bodyContent = ob_get_contents();

                    ob_end_clean();

                    $mail->Body = $bodyContent;
                        
                    $mail->send();

                  }

                }

              }

            //EMAIL VERFIFICATION

            //SMS NOTIFICATION

              // $link = $this->base.'change-program/'.$app['id'];

              // if($app['contact_no'] != null){

              //   $contact_no = $app['contact_no'];

              //   $BASE_URL = "https://l3zndj.api.infobip.com";

              //   $API_KEY = "c1ad2a470047d8d917fbb56151e22f85-5b4c9dc0-01cc-4a5f-b46f-d29ddad4997d";

              //   $SENDER = "InfoSMS";

              //   //SAMPLE CONTACT NUMBER FORMAT
              //   //639178673561

              //   $RECIPIENT = $contact_no;

              //   $MESSAGE_TEXT = "Hi, Greetings from Zamboanga State College of Marine Sciences and Technology. \n\nThis is to notify you that you scored ".@$this->request->getData('rate')." and did not meet the required rating (".$program['passing_rate'].") for ".$program['name']."\n\nClick here to change your program : ".$link;



              //   $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

              //   $sendSmsApi = new SmsApi(config: $configuration);

              //   $destination = new SmsDestination(

              //     to: $RECIPIENT

              //   );

              //   $message = new SmsTextualMessage(destinations: [$destination], from: $SENDER, text: $MESSAGE_TEXT);

              //   $request = new SmsAdvancedTextualRequest(messages: [$message]);

              //   try {

              //     $smsResponse = $sendSmsApi->sendSmsMessage($request);

              //     // echo $smsResponse->getBulkId() . PHP_EOL;

              //     // foreach ($smsResponse->getMessages() ?? [] as $message) {

              //     //   echo sprintf('Message ID: %s, status: %s', $message->getMessageId(), $message->getStatus()?->getName()) . PHP_EOL;

              //     // }

              //   } catch (Throwable $apiException) {

              //     // echo("HTTP Code: " . $apiException->getCode() . "\n");

              //   }

              // }

            //END 

          }else{ // EMAIL FOR PASSED

            $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

            $app_no = $app['application_no'];

            $email = $app['email'];

            //EMAIL VERFIFICATION

              if(isset($email)){

                if($email != ''){

                  // fix value
              
                  $mail = new PHPMailer(true);

                  //Server settings

                  $mail->isSMTP(); // Send using SMTP

                  $mail->Host = 'smtp.gmail.com';

                  $mail->SMTPAuth = true;
                  $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

                  $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

                  $mail->Port = 587; // TCP port to connect to

                  // Bypass SSL certificate verification
                  $mail->SMTPOptions = [

                    'ssl' => [

                      'verify_peer' => false,

                      'verify_peer_name' => false,

                      'allow_self_signed' => true,

                    ],

                  ];

                  //Recipients
                  $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

                  $mail->addAddress($email, $name); // Recipient's email and name

                  // Content
                  $mail->isHTML(true); // Set email format to HTML

                  $mail->Subject = 'Admission Result';

                  $_SESSION['application_no'] = $app_no; 

                  $_SESSION['name'] = $name; 

                  $_SESSION['rate'] = @$this->request->getData('rate');

                  $_SESSION['preferred_program'] = $program['name']; 

                  $_SESSION['id'] = $app['id']; 

                  ob_start();

                  include('Email/cat-result-email-passed.ctp');

                  $bodyContent = ob_get_contents();

                  ob_end_clean();

                  $mail->Body = $bodyContent;
                      
                  $mail->send();

                }

              }

            //EMAIL VERFIFICATION

          }

        }

      //END 

      //TRANSFERRING DATA TO STUDENT TABLE

        $query = new Student([

          'student_applicant_id' => $id,

          'student_no' => $app['student_no'],

          'first_name' => $app['first_name'],

          'middle_name' => $app['middle_name'],

          'last_name' => $app['last_name'],

          'college_id' => $app['college_id'],

          'program_id' => $app['preferred_program_id'],

          'gender' => $app['gender'],

          'year_term_id' => $app['year_term_id'],

          'email' => $app['email'],

          'present_address' => $app['address'],

        ]);

        $this->Student->save($query);

        $student_id = $query->id;

        $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

        $app_no = $app['application_no'];

        $email = $app['email'];

        if(isset($email)){

          if($email != ''){

            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            // Generate a random string of 10 characters
            $password = substr(str_shuffle($chars), 0, 10);

            $user = $this->Users->newEmptyEntity();

            $user = $this->Users->patchEntity($user, [

              'studentId' => $student_id,

              'student_name' => @$app['last_name'] . ', ' . @$app['first_name'] . ' ' . @$app['middle_name'],

              'username' => @$app['student_no'],

              'password' => $password,

              'first_name' => @$app['first_name'],

              'middle_name' => @$app['middle_name'],

              'last_name' => @$app['last_name'],

              'roleId' => 13,

              'developer' => 0,

              'active' => 1,

              'verified' => 1,

            ]);

            $this->Users->save($user);
      
            $mail = new PHPMailer(true);

            //Server settings
            
            $mail->isSMTP(); // Send using SMTP

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

            $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

            $mail->Port = 587; // TCP port to connect to

            // Bypass SSL certificate verification
            $mail->SMTPOptions = [

              'ssl' => [

                'verify_peer' => false,

                'verify_peer_name' => false,

                'allow_self_signed' => true,

              ],

            ];

            //Recipients
            $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

            $mail->addAddress($email, $name); // Recipient's email and name

            // Content
            $mail->isHTML(true); // Set email format to HTML

            $mail->Subject = 'Admission Application Status';

            $_SESSION['name'] = @$name; 

            $_SESSION['application_no'] = @$app['application_no'];

            $_SESSION['username'] = @$app['student_no']; 

            $_SESSION['password'] = $password; 

            $_SESSION['id'] = $id; 

            ob_start();

            include('Email/admission-application-for-medical.ctp');

            $bodyContent = ob_get_contents();

            ob_end_clean();

            $mail->Body = $bodyContent;
                

            $mail->send();

          }

        }

      //END 

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Examinee has been successfully rated.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'rate',

        'userId' => $this->Auth->user('id'),

        'description' => 'CAT',

        'code' => '',

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);

      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Examinee cannot be rated this time.'

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

  public function requestInterview($id = null){

    $this->autoRender = false;

    $request = $this->request->getData();

    $app = $this->StudentApplications->get($id);

    $app->request_purpose = $request['purpose'];

    $app->status = 'REQUESTED';

    if ($this->StudentApplications->save($app)) {

      $response = array(

        'ok'   => true,

        'data' => $app,       

        'msg'  => 'You have successfully requested for an medical interview.'

      );

    } else {

      $response = array(

        'ok'   => false,

        'data' => $app,

        'msg'  => 'You cannot request for an medical interview this time.'

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

  public function sendSchedule($id = null){

    $this->autoRender = false;

    $request = $this->request->getData(); 

    // $room = $this->Room->get($request['room']);

    $app = $this->StudentApplications->get($id);

    //EMAIL VERIFICATION

      $name = @$app['first_name'].' '.@$app['middle_name'].' '.@$app['last_name'];

      $email = @$app['email'];

      if(isset($app['email'])){

        $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

        $app_no = $app['application_no'];

        $email = $app['email'];

        if($email != ''){

          // fix value
      
          $mail = new PHPMailer(true);

          //Server settings

          $mail->isSMTP(); // Send using SMTP

          $mail->Host = 'smtp.gmail.com';

          $mail->SMTPAuth = true;

          $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

          $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

          $mail->Port = 587; // TCP port to connect to

          // Bypass SSL certificate verification
          $mail->SMTPOptions = [

            'ssl' => [

              'verify_peer' => false,

              'verify_peer_name' => false,

              'allow_self_signed' => true,

            ],

          ];

          //Recipients
          $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

          $mail->addAddress($email, $name); // Recipient's email and name

          // Content
          $mail->isHTML(true); // Set email format to HTML

          $mail->Subject = 'INTERVIEW SCHEDULE';

          $_SESSION['name'] = $name; 

          $_SESSION['date'] = fdate($request['date'],'F d, Y'); 

          $_SESSION['time'] = $request['time']; 

          $_SESSION['place'] = $request['place']; 

          // $_SESSION['room'] = $request['room'];

          ob_start();

          include('Email/admission-application-interview-schedule.ctp');

          $bodyContent = ob_get_contents();

          ob_end_clean();

          $mail->Body = $bodyContent;
              
          $mail->send();

        }

      }

    //EMAIL VERIFICATION

    $response = array(

      'ok'   => true,

      'data' => $request,       

      'msg'  => 'Examinee has been successfully rated.'

    );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'send Schedule',

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

  public function qualify($id = null){

    $this->autoRender = false;

    $app = $this->StudentApplications->get($id);

    $app->approve = 4;

    $app->status = 'QUALIFIED';

    $app->qualified_by_id = $this->currentUser->id;

    if ($this->StudentApplications->save($app)) {

      //EMAIL VERIFICATION

        $name = @$app['first_name'].' '.@$app['middle_name'].' '.@$app['last_name'];

        $email = @$app['email'];

        if(isset($app['email'])){

          $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

          $app_no = $app['application_no'];

          $email = $app['email'];

          if($email != ''){

            // fix value
        
            $mail = new PHPMailer(true);

            //Server settings

            $mail->isSMTP(); // Send using SMTP

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

            $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

            $mail->Port = 587; // TCP port to connect to

            // Bypass SSL certificate verification
            $mail->SMTPOptions = [

              'ssl' => [

                'verify_peer' => false,

                'verify_peer_name' => false,

                'allow_self_signed' => true,

              ],

            ];

            //Recipients
            $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

            $mail->addAddress($email, $name); // Recipient's email and name

            // Content
            $mail->isHTML(true); // Set email format to HTML

            $mail->Subject = 'Application Status';

            $_SESSION['name'] = @$name; 

            $_SESSION['application_no'] = @$app['application_no'];

            $_SESSION['id'] = $id; 

            ob_start();

            include('Email/admission-application-qualified.ctp');

            $bodyContent = ob_get_contents();

            ob_end_clean();

            $mail->Body = $bodyContent;

            $mail->send();

          }

        }

      //EMAIL VERIFICATION

      //SMS NOTIFICATION

        // if($app['contact_no'] != null){

        //   $contact_no = $app['contact_no'];

        //   $BASE_URL = "https://l3zndj.api.infobip.com";

        //   $API_KEY = "c1ad2a470047d8d917fbb56151e22f85-5b4c9dc0-01cc-4a5f-b46f-d29ddad4997d";

        //   $SENDER = "InfoSMS";

        //   //SAMPLE CONTACT NUMBER FORMAT
        //   //639178673561

        //   $RECIPIENT = $contact_no;

        //   $MESSAGE_TEXT = "Hi, Greetings from Zamboanga State College of Marine Sciences and Technology. \n\nThis is to notify you that you passed the medical examination.";

        //   $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

        //   $sendSmsApi = new SmsApi(config: $configuration);

        //   $destination = new SmsDestination(

        //     to: $RECIPIENT

        //   );

        //   $message = new SmsTextualMessage(destinations: [$destination], from: $SENDER, text: $MESSAGE_TEXT);

        //   $request = new SmsAdvancedTextualRequest(messages: [$message]);

        //   try {

        //     $smsResponse = $sendSmsApi->sendSmsMessage($request);

        //     // echo $smsResponse->getBulkId() . PHP_EOL;

        //     // foreach ($smsResponse->getMessages() ?? [] as $message) {

        //     //   echo sprintf('Message ID: %s, status: %s', $message->getMessageId(), $message->getStatus()?->getName()) . PHP_EOL;

        //     // }

        //   } catch (Throwable $apiException) {

        //     // echo("HTTP Code: " . $apiException->getCode() . "\n");

        //   }

        // }

      //END 

      $response = array(

        'ok'   => true,

        'data' => $app,       

        'msg'  => 'Examinee has been successfully rated.'

      );

      $userLogEntity = $this->UserLogs->newEntity([

        'action' => 'CAT',

        'description' => 'Qualify'.@$app['StudentApplication']['first_name'].' '.@$app['StudentApplication']['last_name'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);

      $this->UserLogs->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Examinee cannot be rated this time.'

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

  public function unqualify($id = null){
    
    $this->autoRender = false;

    $app = $this->StudentApplications->get($id);

    $app->approve = 5;

    $app->unqualified_by_id = $this->currentUser->id;

    $app->unqualified_reason = $this->getRequest()->getData('explanation');

    $app->unqualified_date = date('Y-m-d');

    $app->status = 'UNQUALIFIED';

    if ($this->StudentApplications->save($app)) {

      //EMAIL VERIFICATION

        $name = @$app['first_name'].' '.@$app['middle_name'].' '.@$app['last_name'];

        $email = @$app['email'];

        if(isset($app['email'])){

          $name = $app['first_name'].' '.substr($app['middle_name'],0,1).'. '.$app['last_name'];

          $app_no = $app['application_no'];

          $email = $app['email'];
         
          if($email != ''){

            // fix value
        
            $mail = new PHPMailer(true);

            //Server settings

            $mail->isSMTP(); // Send using SMTP

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'mycreativepandaii@gmail.com'; // Your Gmail email address

            $mail->Password = 'tkoahowwnzuzqczy'; // Your Gmail password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption

            $mail->Port = 587; // TCP port to connect to

            // Bypass SSL certificate verification
            $mail->SMTPOptions = [

              'ssl' => [

                'verify_peer' => false,

                'verify_peer_name' => false,

                'allow_self_signed' => true,

              ],

            ];

            //Recipients
            $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

            $mail->addAddress($email, $name); // Recipient's email and name

            // Content
            $mail->isHTML(true); // Set email format to HTML

            $mail->Subject = 'Application Status';

            $_SESSION['name'] = @$name; 

            $_SESSION['application_no'] = @$app['application_no'];

            $_SESSION['disapproved_reason'] = @$app['disapproved_reason'];

            $_SESSION['id'] = $id; 

            ob_start();

            include('Email/admission-application-unqualified.ctp');

            $bodyContent = ob_get_contents();

            ob_end_clean();

            $mail->Body = $bodyContent;
                
            $mail->send();

          }

        }

      //EMAIL VERIFICATION

      //SMS NOTIFICATION

        // if($app['contact_no'] != null){

        //   $contact_no = $app['contact_no'];

        //   $BASE_URL = "https://l3zndj.api.infobip.com";

        //   $API_KEY = "c1ad2a470047d8d917fbb56151e22f85-5b4c9dc0-01cc-4a5f-b46f-d29ddad4997d";

        //   $SENDER = "InfoSMS";

        //   //SAMPLE CONTACT NUMBER FORMAT
        //   //639178673561

        //   $RECIPIENT = $contact_no;

        //   $MESSAGE_TEXT = "Hi, Greetings from Zamboanga State College of Marine Sciences and Technology. \n\nThis is to notify you that you did not passed the medical examination.";

        //   $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

        //   $sendSmsApi = new SmsApi(config: $configuration);

        //   $destination = new SmsDestination(

        //     to: $RECIPIENT

        //   );

        //   $message = new SmsTextualMessage(destinations: [$destination], from: $SENDER, text: $MESSAGE_TEXT);

        //   $request = new SmsAdvancedTextualRequest(messages: [$message]);

        //   try {

        //     $smsResponse = $sendSmsApi->sendSmsMessage($request);

        //     // echo $smsResponse->getBulkId() . PHP_EOL;

        //     // foreach ($smsResponse->getMessages() ?? [] as $message) {

        //     //   echo sprintf('Message ID: %s, status: %s', $message->getMessageId(), $message->getStatus()?->getName()) . PHP_EOL;

        //     // }

        //   } catch (Throwable $apiException) {

        //     // echo("HTTP Code: " . $apiException->getCode() . "\n");

        //   }

        // }

      //END 

      $response = array(

        'ok'   => true,

        'data' => $app,       

        'msg'  => 'Examinee has been successfully rated.'

      );
          $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'CAT',

          'description' => 'Unqualify'.@$app['StudentApplication']['first_name'].' '.@$app['StudentApplication']['last_name'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Examinee cannot be rated this time.'

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

  public function checkForm($id = null) {

    $this->autoRender = false;

    $data = $this->StudentApplications->get($id);

    $requestData = $this->request->getData('StudentApplication');

    $psa = (isset($requestData['psa']) && $requestData['psa'] == true) ? 1 : 0 ;

    $data->psa =  $psa;

    $form_137 = (isset($requestData['form_137']) && $requestData['form_137'] == true) ? 1 : 0 ;

    $data->form_137 =  $form_137;

    if ($this->StudentApplications->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Students Application has been successfully modified'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'userId' => $this->Auth->user('id'),

          'description' => 'Students Application Management',

          'code' => $data->student_no,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Students Application cannot be modified at this time.'

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
