<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;

class MedicalStudentProfilesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->MedicalStudentProfiles = TableRegistry::getTableLocator()->get('MedicalStudentProfiles');

    $this->MedicalStudentProfileImages = TableRegistry::getTableLocator()->get('MedicalStudentProfileImages');

    $this->CollegePrograms = TableRegistry::getTableLocator()->get('CollegePrograms');

    $this->YearLevelTerms = TableRegistry::getTableLocator()->get('YearLevelTerms');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

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

      $conditions['date'] = " AND DATE(MedicalStudentProfile.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(MedicalStudentProfile.date) >= '$start' AND DATE(MedicalStudentProfile.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $limit = 25;

    $tmpData = $this->MedicalStudentProfiles->paginate($this->MedicalStudentProfiles->getAllMedicalStudentProfile($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $medicalStudentProfiles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($medicalStudentProfiles as $data) {

      $datas[] = array(

        'code'            => $data['code'],

        'id'              => $data['id'],

        'student_name'    => $data['student_name'],

        'course'          => $data['name'],

        'address'         => $data['address'],

        'year'            => $data['description'],
     
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

    $uploadedFiles = $this->request->getUploadedFiles();

    $medicalStudentProfileEntity = $this->MedicalStudentProfiles->newEntity($main['MedicalStudentProfile']);

    $save = $this->MedicalStudentProfiles->save($medicalStudentProfileEntity);

    if ($this->MedicalStudentProfiles->save($medicalStudentProfileEntity)) {

      if (!empty($main) && isset($main['have'])) {

        $treatment = $main['have'];

        $medicalStudentProfileEntity->set('treatment', $treatment);

        $this->MedicalStudentProfiles->save($medicalStudentProfileEntity);

      }

    }

    if ($save) {

      $id = $save->id;

        foreach ($uploadedFiles as $fieldName => $images) {

          $path = "uploads/medical-student-profile/$id";

          if (!file_exists($path)) {mkdir($path, 0777, true);

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

            if (isset($main['MedicalStudentProfileImage'])) {

              foreach ($main['MedicalStudentProfileImage'][count($main['MedicalStudentProfileImage']) - 1]['images'] as $key => $valueImages) {

                $valueImages['files'] = $names[$key];

                $valueImages['student_profile_id'] = $id;

                $datasImages[] = $valueImages;

              }

              $entities = $this->MedicalStudentProfileImages->newEntities($datasImages);

              $this->MedicalStudentProfileImages->saveMany($entities);

            }

          }

          $response = [

            'ok' => true,

            'msg' => 'Medical Student Profile has been successfully saved.',

            'data' => $requestData,

          ];

        $userLogEntity = $this->UserLogs->newEntity([

        'action' => 'Add',

        'description' => 'Medical Student Profile Management',

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);

      $this->UserLogs->save($userLogEntity);

      }else{

        $response = [

        'ok' => false,

        'data' => $requestData,

        'msg' => 'Medical Student Profile cannot be saved at this time.',

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

  public function view($id = null){

    $data['MedicalStudentProfile'] = $this->MedicalStudentProfiles->find()

    ->contain([

      'MedicalStudentProfileImages' => [

        'conditions' => [

          'MedicalStudentProfileImages.visible' => 1

        ],

      ],

      'CollegePrograms',

      'YearLevelTerms'

    ])

    ->where([

        'MedicalStudentProfiles.visible' => 1,

        'MedicalStudentProfiles.id' => $id,

    ])

    ->first();

    $data['MedicalStudentProfileImage'] = $data['MedicalStudentProfile']['medical_student_profile_images'];

    $data['CollegeProgram'] = $data['MedicalStudentProfile']['college_program'];

    $data['YearTermLevel'] = $data['MedicalStudentProfile']['year_level_term'];

    unset($data['MedicalStudentProfile']['medical_student_profile_images']);

    unset($data['MedicalStudentProfile']['year_level_term']);

    unset($data['MedicalStudentProfile']['college_program']);

    // Assuming you have already retrieved the data in $data

    if (!empty($data['MedicalStudentProfile']['treatment'])) {

        $treatmentValues = explode(',', $data['MedicalStudentProfile']['treatment']);

        // Transform the values to boolean
        $treatmentValues = array_map(function ($value) {

            return $value == 1 ? true : false;

        }, $treatmentValues);

        // Assign the transformed values back to the 'have' field

        $data['MedicalStudentProfile']['have'] = $treatmentValues;

    }

    $medicalStudentProfileImages = array();

    if(!empty($data['MedicalStudentProfileImage'])){

      foreach($data['MedicalStudentProfileImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $medicalStudentProfileImages[] = array(

            'imageSrc' => $this->base . '/uploads/medical-student-profile/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }

    }

    $response = array(

      'ok'   => true,

      'data' => $data,

      'medicalStudentProfileImage' => $medicalStudentProfileImages

    );

    $this->set([

      'response' => $response,

      '_serialize' => 'response'

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function edit($id){

    $medicalStudentProfiles = $this->MedicalStudentProfiles->get($id); 

    $requestData = $this->getRequest()->getData('MedicalStudentProfile');

    $requestData['application'] = isset($requestData['application']) ? date('Y/m/d', strtotime($requestData['application'])) : null;

    $this->MedicalStudentProfiles->patchEntity($medicalStudentProfiles, $requestData); 

    if ($this->MedicalStudentProfiles->save($medicalStudentProfiles)) {

      if (!empty($requestData)) {

        $requestData['treatment'] = @$requestData['have'][0].','.@$requestData['have'][1].','.@$requestData['have'][2].','.@$requestData['have'][3].','.@$requestData['have'][4].','.@$requestData['have'][5].','.@$requestData['have'][6].','.@$requestData['have'][7].','.@$requestData['have'][8].','.@$requestData['have'][9].','.@$requestData['have'][10].','.@$requestData['have'][11].','.@$requestData['have'][12].','.@$requestData['have'][13].','.@$requestData['have'][14].','.@$requestData['have'][15].','.@$requestData['have'][16].','.@$requestData['have'][17].','.@$requestData['have'][18];

        $saveEntity = $this->MedicalStudentProfiles->patchEntity($medicalStudentProfiles, $requestData); 

        $this->MedicalStudentProfiles->save($saveEntity);

      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Medical Student Profiles has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Medical Student Profiles',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Medical Student Profiles cannot updated this time.',

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

    $data = $this->MedicalStudentProfiles->get($id);

    $data->visible = 0;

    if ($this->MedicalStudentProfiles->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Medical Student Profiles has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Medical Student Profiles cannot be deleted at this time.'

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

  public function deleteImage($id = null) {

    $data = $this->MedicalStudentProfileImages->get($id);

    $data->visible = 0;

    if ($this->MedicalStudentProfileImages->save($data)) {

      $path = "uploads/medical-student-profile/" . @$data['student_profile_id'];

      $orgfile = $path . '/' . @$data['images'];

      if(file_exists($orgfile)){

        unlink(@$orgfile);

      }

      $response = array(

        'ok'   => true,

        'data' => $id,

        'msg' => 'File has been deleted.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete Image',

          'description' => 'Medical Student Profiles',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $id,

      );

    }

    $this->set(array(

      'response'   => $response,

      '_serialize' => 'response'

    ));

        $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

}
