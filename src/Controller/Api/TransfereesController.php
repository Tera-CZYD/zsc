<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\View\ViewBuilder;
use Cake\View\Helper\UrlHelper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'PHPMailer/Exception.php';

include 'PHPMailer/PHPMailer.php';

include 'PHPMailer/SMTP.php';

class TransfereesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Transferees = TableRegistry::getTableLocator()->get('Transferees');

    $this->TransfereeImages = TableRegistry::getTableLocator()->get('TransfereeImages');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

    $this->viewBuilder = new ViewBuilder();

    $this->view = $this->viewBuilder->build();

    $this->urlHelper = new UrlHelper($this->view);

    $this->base = $this->urlHelper->build('/', ['fullBase' => true]);

    $this->Students = TableRegistry::getTableLocator()->get('Students');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if ($this->request->getQuery('search') != null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date') != null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Transferee.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Transferee.date) >= '$start' AND DATE(Transferee.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student') != null) {

      $per_student = $this->request->getQuery('per_student');

      $employee_id = $this->Auth->user('studentId');

      if ($employee_id!='') {

        $conditions['studentId'] = "AND Transferee.student_id = $employee_id AND Transferee.type = 'Transfer Out'";

      }

      $conditionsPrint .= '&per_student='.$per_student;

    }

    $limit = 25;

    $tmpData = $this->Transferees->paginate($this->Transferees->getAllTransferee($conditions, $limit, $page), [

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

        'student_no'        => $data['student_no'],

        'full_name'         => $data['full_name'],

        'year_level'        => $data['year_level'],

        'email'             => $data['email'],

        'date'              => fdate($data['date'],'m/d/Y'),

        'approve'           => $data['approve'],

        'year'              =>  $data['year'],

        'program'           =>  $data['program'],

        'college'           =>  $data['college']

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

    if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

      $requestData = $this->request->getData('data');

      $main = json_decode($requestData, true);

      $main['Transferee']['date'] = isset($main['Transferee']['date']) ? fdate($main['Transferee']['date'],'Y-m-d') : null;

      $uploadedFiles = $this->request->getUploadedFiles();

      $main['Transferee']['student_name'] = (isset($main['Transferee']['student_name'])  || $main['Transferee']['student_name'] != null ) ? $main['Transferee']['student_name'] : $main['Transferee']['last_name'].', '.$main['Transferee']['first_name'].' '.$main['Transferee']['middle_name'];

      $student_no = $main['Transferee']['student_no'];

      $students = $this->Transferees->find()

      ->where([

        'student_no' => $student_no,

        'visible' => 1

      ])

      ->all();

      if(count($students) == 0 ){

        $data = $this->Transferees->newEmptyEntity();
     
        $data = $this->Transferees->patchEntity($data, $main['Transferee']); 

        if($this->Transferees->save($data)) {

          $id = $data->id;

          foreach ($uploadedFiles as $fieldName => $images) {

            $path = "uploads/transferee/$id";

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

            if (isset($main['TransfereeImage'])) {

              foreach ($main['TransfereeImage'][count($main['TransfereeImage']) - 1]['images'] as $key => $valueImages) {

                $valueImages['images'] = $names[$key];

                $valueImages['transferee_id'] = $id;

                $datasImages[] = $valueImages;

              }

              $entities = $this->TransfereeImages->newEntities($datasImages); 

              $this->TransfereeImages->saveMany($entities);

            }

          }

          $response = array(

            'ok'  =>true,

            'msg' =>'School Transfer Request has been successfully saved.',

            'data'=>$main['Transferee']

          );

          $userLogEntity = $this->UserLogs->newEntity([

            'action' => 'Add',

            'userId' => $this->Auth->user('id'),

            'code' => $main['Transferee']['student_no'],

            'description' => 'School Transfer Request Management',

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s')

          ]);

          $this->UserLogs->save($userLogEntity);

        }else{

          $response = array(

            'ok'  =>true,

            'data'=>$main['Transferee'],

            'msg' =>'School Transfer Request cannot saved this time.',

          );

        }

      }else{

        if($main['Transferee']['type'] == 'Transfer In'){

          $response = array(

            'ok'  =>false,

            'data'=>$main['Transferee'],

            'msg' =>'There is Existing Transferee Record.',

          );

        }else{

          $response = array(

            'ok'  =>false,

            'data'=>$main['Transferee'],

            'msg' =>'There is pending Transfer Out for this student.',

          );

        }

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

  public function view($id = null){

    $data['Transferee'] = $this->Transferees->find()

      ->contain([

        'TransfereeImages' => [

          'conditions' => ['TransfereeImages.visible' => 1]

        ],

        'YearLevelTerms' => [

          'conditions' => ['YearLevelTerms.visible' => 1]

        ],

        'CollegePrograms' => [

          'conditions' => ['CollegePrograms.visible' => 1]

        ],

        'Colleges' => [

          'conditions' => ['Colleges.visible' => 1]

        ]

      ])

      ->where([

        'Transferees.visible' => 1,

        'Transferees.id' => $id

      ])

    ->first();

    $data['Transferee']['date'] = !is_null($data['Transferee']['date']) ? $data['Transferee']['date']->format('m/d/Y') : null;

    $data['TransfereeImage'] = $data['Transferee']->transferee_images;

    $data['College'] = $data['Transferee']->college;

    $data['CollegeProgram'] = $data['Transferee']->college_program;

    $data['YearLevelTerm'] = $data['Transferee']->year_level_term;

    unset($data['Transferee']->transferee_images);

    unset($data['Transferee']->college);

    unset($data['Transferee']->college_programs);

    unset($data['Transferee']->year_level_term);

    $transfereeImage = array();

    if(!empty($data['TransfereeImage'])){

      foreach($data['TransfereeImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $transfereeImage[] = array(

            'imageSrc' => $this->base . '/uploads/transferee/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }
    }

    $response = [

      'ok' => true,

      'data' => $data,

      'transfereeImage' => $transfereeImage

    ];

    $this->set([

      'response' => $response,

      '_serialize' => 'response'

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function edit($id = null){

    $data = $this->Transferees->get($id); 

    $requestData = $this->getRequest()->getData('Transferee');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $this->Transferees->patchEntity($data, $requestData); 

    if ($this->Transferees->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'School Transfer Request has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'userId' => $this->Auth->user('id'),

          'description' => 'School Transfer Request Management',

          'code' => $requestData['student_no'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'School Transfer Request cannot updated this time.',

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

    $data = $this->Transferees->get($id);

    $data->visible = 0;

    if ($this->Transferees->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'School Transfer Request has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'userId' => $this->Auth->user('id'),

          'description' => 'School Transfer Request Management',

          'code' => $data->student_no,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'School Transfer Request cannot be deleted at this time.'

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

  public function delete_image(){

    $id = $this->request->getParam('id');

    $data = $this->TransfereeImages->get($id);

    $path = "uploads/transferee/" . $data->transferee_id;

    $orgFile = $path . '/' . $data->images;

    $data->visible = 0;

    if ($this->TransfereeImages->save($data)) {

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

    $data = $this->Transferees->get($id);

    $data->approve = 1;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->Transferees->save($data)) {

      $transferee_id = $data->id;

      if($data->type == 'Transfer In'){

      $student_data = array();

      $student_data['transferee_id'] = $transferee_id;

      $student_data['student_no'] = $data->student_no;

      $student_data['first_name'] = $data->first_name;

      $student_data['middle_name'] = $data->middle_name;

      $student_data['last_name'] = $data->last_name;

      $student_data['email'] = $data->email;

      $student_data['gender'] = $data->gender;

      $student_data['incoming_freshmen'] = 0;

      $student_data['contact_no'] = $data->contact_no;

      $student_data['present_address'] = $data->address;

      $student_data['college_id'] = $data->college_id;

      $student_data['program_id'] = $data->program_id;

      $student_data['year_term_id'] = $data->year_term_id;

      $student = $this->Students->newEmptyEntity();

      $student = $this->Students->patchEntity($student,$student_data);

        if($this->Students->save($student)){

          $student_id = $student->id;

          $data->student_id = $student_id;

          $transferee = $this->Transferees->save($data);


          if($data->email != ''){

            $name = $data->last_name . ', ' . $data->first_name . ' ' . $data->middle_name;

            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            $password = substr(str_shuffle($chars), 0, 10);

            $user_data = array();

            $user_data['studentId'] = $student_id;
            
            $user_data['student_name'] = $name;
            
            $user_data['username'] = $data->student_no;

            $user_data['password'] = $password;
            
            $user_data['first_name'] = $data->first_name;

            $user_data['middle_name'] = $data->middle_name;

            $user_data['last_name'] = $data->last_name;

            $user_data['roleId'] = 13;

            $user_data['developer'] = 0;

            $user_data['active'] = 1;

            $user_data['verified'] = 1;


            $user = $this->Users->newEmptyEntity();

            $user = $this->Users->patchEntity($user,$user_data);

            $this->Users->save($user);

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

            $mail->setFrom('mycreativepandaii@gmail.com', 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLOGY'); // Sender's email and name

            $mail->addAddress($data->email, $name); // Recipient's email and name

            // Content
            $mail->isHTML(true); // Set email format to HTML

            $mail->Subject = 'Transferee Student';

            $_SESSION['name'] = @$name; 

            $_SESSION['username'] = $data->student_no; 

            $_SESSION['password'] = $password; 

            $_SESSION['id'] = $student_id; 

            ob_start();

            include('Email/transferee.ctp');

            $bodyContent = ob_get_contents();

            ob_end_clean();

            $mail->Body = $bodyContent;
                

            $mail->send();

          }




        }

      }else{ 

        $student_id = $data->student_id;

        $student = $this->Students->get($student_id);

        $student = $this->Students->patchEntity($student,[

          'transfer' => 'TRANSFERED OUT'

        ]);

        $this->Students->save($student);

      }



      $response = [

        'ok' => true,

        'data' => $id,

        'msg' => 'Transferee has been approved.'

      ];

    } else {

      $response = [

        'ok' => false,

        'data' => $id,

        'msg' => 'Transferee cannot be approved this time.'

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
