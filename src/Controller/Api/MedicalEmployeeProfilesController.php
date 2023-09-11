<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class MedicalEmployeeProfilesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->MedicalEmployeeProfile = TableRegistry::getTableLocator()->get('MedicalEmployeeProfiles');

    $this->EmployeeFile = TableRegistry::getTableLocator()->get('EmployeeFiles');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

    $this->autoRender = false;

  }

  public $uses = array(

    'MedicalEmployeeProfile',

    'EmployeeFile',

    'College'

  );

  public function index() {

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    $header = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $conditions['search'] = strtolower($search);

      $conditionsPrint .= '&search='.$search;

      $header .= ' SEARCH : '.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(MedicalEmployeeProfile.date_of_publication) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

      $header .= ' DATE : '.fdate($search_date,'F d, Y');

    } 

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(MedicalEmployeeProfile.date_of_publication) >= '$start' AND DATE(MedicalEmployeeProfile.date_of_publication) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

      $header .= ' RANGE : '.fdate($start,'F d, Y').' - '.fdate($end,'F d, Y');

    }

    $limit = 25;

    $tmpData = $this->MedicalEmployeeProfile->paginate($this->MedicalEmployeeProfile->getAllMedicalEmployeeProfile($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $MedicalEmployeeProfile = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($MedicalEmployeeProfile as $data) {

      $datas[] = array(
          
         'id'              => $data['id'],

         'code'            => $data['code'],

         'employee_name'   => $data['employee_name'],

         'address'         => $data['address'],

         'age'             => $data['age'],

         'height'          => $data['height'],

         'weight'          => $data['weight'],

         'remarks'         => $data['remarks'],

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

  public function view($id = null) {

    $data['MedicalEmployeeProfile'] = $this->MedicalEmployeeProfiles

    ->find()

    ->contain([

      'Colleges',

      'EmployeeFiles' => [

        'conditions' => ['EmployeeFiles.visible' => 1]

      ]

    ])

    ->where([

      'MedicalEmployeeProfiles.visible' => 1,

      'MedicalEmployeeProfiles.id' => $id

    ])
    
    ->first();

    $data['MedicalEmployeeProfile']['have'] = explode(',',$data['MedicalEmployeeProfile']['treatment']);
    
    if (!empty($data['MedicalEmployeeProfile']['have'])){

      foreach ($data['MedicalEmployeeProfile']['have'] as $key => $value) {
        
        $data['MedicalEmployeeProfile']['have'][$key] = $data['MedicalEmployeeProfile']['have'][$key] == 1 ? true: false;

      }

    }

    $data['EmployeeFile'] = $data['MedicalEmployeeProfile']['employee_files'];

    unset($data['MedicalEmployeeProfile']['employee_files']);

    $applicationImage = array();

    if(!empty($data['EmployeeFile'])){

      foreach($data['EmployeeFile'] as $key => $image){

        if (!is_null($image['files'])) {

          $applicationImage[] = array(

            'imageSrc' => $this->base . '/uploads/medical-employee-profile/' . $id . '/' . @$image['files'],

            'name' => @$image['files'],

            'id' => @$image['id'],

          );

        }

      }
    }


    $response = array(

      'ok'   => true,

      'data' => $data,

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

  public function add(){

    $this->autoRender = false;

    if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

    $requestData = $this->request->getData('data');

    $main = json_decode($requestData, true);

    $uploadedFiles = $this->request->getUploadedFiles();

    $medicalEmployeeProfileEntity = $this->MedicalEmployeeProfiles->newEntity($main['MedicalEmployeeProfile']);

    $save = $this->MedicalEmployeeProfiles->save($medicalEmployeeProfileEntity);

    if ($this->MedicalEmployeeProfiles->save($medicalEmployeeProfileEntity)) {

      if (!empty($main) && isset($main['have'])) {

        $treatment = $main['have'];

        $medicalEmployeeProfileEntity->set('treatment', $treatment);

        $this->MedicalEmployeeProfiles->save($medicalEmployeeProfileEntity);

      }

    }

    if ($save) {

      $id = $save->id;

        foreach ($uploadedFiles as $fieldName => $images) {

          $path = "uploads/medical-employee-profile/$id";

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

            if (isset($main['EmployeeFile'])) {

              foreach ($main['EmployeeFile'][count($main['EmployeeFile']) - 1]['files'] as $key => $valueImages) {

                $valueImages['files'] = $names[$key];

                $valueImages['employee_profile_id'] = $id;

                $datasImages[] = $valueImages;

              }

              $entities = $this->EmployeeFile->newEntities($datasImages);

              $this->EmployeeFile->saveMany($entities);

            }

          }

          $response = [

            'ok' => true,

            'msg' => 'Medical Employee Profile has been successfully saved.',

            'data' => $requestData,

          ];

        $userLogEntity = $this->UserLogs->newEntity([

        'action' => 'Add',

        'description' => 'Medical Employee Profile Management',

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);

      $this->UserLogs->save($userLogEntity);

      }else{

        $response = [

        'ok' => false,

        'data' => $requestData,

        'msg' => 'Medical Employee Profile cannot be saved at this time.',

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

  public function edit($id){

    $data = $this->MedicalEmployeeProfiles->get($id);

    $requestData = $this->getRequest()->getData('MedicalEmployeeProfile');

    $this->MedicalEmployeeProfiles->patchEntity($data, $requestData);

    if ($this->MedicalEmployeeProfiles->save($data)) {

        $response = [

            'ok' => true,

            'msg' => 'Medical Employee Profile has been successfully updated.',

            'data' => $requestData,

        ];

        $userLogEntity = $this->UserLogs->newEntity([

            'action' => 'Edit',

            'description' => 'Medical Employee Profile Management',

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s'),

        ]);


        $this->UserLogs->save($userLogEntity);

    } else {

        $response = [

            'ok' => false,

            'msg' => 'Medical Employee Profile cannot be updated at this time.',

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

  public function delete($id){

    $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->MedicalEmployeeProfiles->get($id);

    $data->visible = 0;

    if ($this->MedicalEmployeeProfiles->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Medical Employee Profile has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Medical Employee Profile Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Medical Employee Profile cannot be deleted at this time.'

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

  public function api_deleteImage($id = null) {

    $data = $this->EmployeeFile->findById($id);

    if ($this->EmployeeFile->hide($id)) {

      $path = "uploads/medical-employee-profile/" . @$data['EmployeeFile']['employee_profile_id'];

      $orgfile = $path . '/' . @$data['EmployeeFile']['files'];

      if(file_exists($orgfile)){

        unlink(@$orgfile);

      }

      $response = array(

        'ok'   => true,

        'data' => $id,

        'msg' => 'File has been deleted.'

      );

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

  }

}