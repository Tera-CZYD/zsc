<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class DentalsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Dentals = TableRegistry::getTableLocator()->get('Dentals');

    $this->DentalImages = TableRegistry::getTableLocator()->get('DentalImages');

     $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

     $this->autoRender = false;

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    $conditions['search'] = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Dental.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Dental.date) >= '$start' AND DATE(Dental.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }


    $conditions['status'] = '';

    if ($this->request->getQuery('status')!=null) {

      $status = $this->request->getQuery('status');

      // var_dump($status);

      $conditions['status'] = "AND Dental.status = $status";

      $conditionsPrint .= '&status='.$this->request->getQuery('status');

    }

    

    $conditions['studentId'] = '';

    if ($this->request->getQuery('per_student')) {

        $per_student = $this->request->getQuery('per_student');

        $employee_id = $this->Auth->user('studentId');

        if (!empty($employee_id)) {

            $conditions['studentId'] = "AND Dental.student_id = $employee_id";

        }

        $conditionsPrint .= '&per_student='.$per_student;

    }

    $dataTable = TableRegistry::getTableLocator()->get('Dentals');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllDental($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $dentals = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($dentals as $data) {

      $datas[] = array(
          'id'            => $data['id'],

          'code'          => $data['code'],

          'patient_name'  => $data['student_name'] != null ? $data['student_name'] : $data['employee_name'],

          'student_name'  => $data['student_name'],

          'age'           => $data['age'],

          'date'          => fdate($data['date'],'m/d/Y'),

          'course'        => $data['college_name'],

          'year'          => $data['year'],

          'medical_history'   => $data['medical_history'],

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

    $main['Dental']['date'] = !is_null($main['Dental']['date']) ? fdate($main['Dental']['date'],'Y-m-d') : null;

    // var_dump($main['Dental']['date']);

    $apartelleEntity = $this->Dentals->newEntity($main['Dental']);

    $save = $this->Dentals->save($apartelleEntity);

    if ($save) {

        $id = $save->id;

            foreach ($uploadedFiles as $fieldName => $images) {

                $path = "uploads/dental/$id";

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

            // var_dump($newPRImage);

            $datasImages = [];


            if (!empty($newPRImage)) {

                if (isset($main['DentalImage'])) {

                  // var_dump($main);

                    foreach ($main['DentalImage'][count($main['DentalImage']) - 1]['images'] as $key => $valueImages) {

                        $valueImages['images'] = $names[$key];

                        $valueImages['dental_id'] = $id;

                        $datasImages[] = $valueImages;

                    }

                    $entities = $this->DentalImages->newEntities($datasImages);

                     $this->DentalImages->saveMany($entities);

                }
            }

            $response = [
                'ok' => true,
                'msg' => 'Dental has been successfully saved.',
                'data' => $requestData,
            ];

          $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Dental Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);

    }else{

                $response = [
              'ok' => false,
              'data' => $requestData,
              'msg' => 'Dental cannot be saved at this time.',
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

    $data['Dental'] = $this->Dentals
      ->find()
      ->contain([
          'DentalImages' => [
              'conditions' => ['DentalImages.visible' => 1]
          ],

          'CollegePrograms' => [
              'conditions' => ['CollegePrograms.visible' => 1]
          ]
      ])
      ->where([
          'Dentals.visible' => 1,
          'Dentals.id' => $id
      ])
      ->first();

      // var_dump($id);


    $data['DentalImage'] = $data['Dental']['dental_images'];

    unset($data['Dental']['dental_images']);

    $data['CollegeProgram'] = $data['Dental']['college_program'];

    unset($data['Dental']['college_program']);

    $DentalImage = array();

    // var_dump($data['Dental']['date']);

    $data['Dental']['date'] = !is_null($data['Dental']['date']) ? $data['Dental']['date']->format('m/d/Y') : 'N/A';
    

    if(!empty($data['DentalImage'])){

      foreach($data['DentalImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $DentalImage[] = array(

            'imageSrc' => $this->base . 'uploads/dental/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }
    }

    $response = [

      'ok' => true,

      'data' => $data,

      'DentalImage' => $DentalImage

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

    $dental = $this->Dentals->get($id);

    $requestData = $this->getRequest()->getData('Dental');

    $requestData['date'] = !is_null($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $this->Dentals->patchEntity($dental, $requestData);

    if ($this->Dentals->save($dental)) {

        $response = [

            'ok' => true,

            'msg' => 'Dental has been successfully updated.',

            'data' => $requestData,

        ];

        $userLogEntity = $this->UserLogs->newEntity([

            'action' => 'Edit',

            'description' => 'Dental Management',

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s'),

        ]);


        $this->UserLogs->save($userLogEntity);

    } else {

        $response = [

            'ok' => false,

            'msg' => 'Dental cannot be updated at this time.',

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

    $data = $this->Dentals->get($id);

    $data->visible = 0;

    if ($this->Dentals->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Dentals has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Dental Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Dentals cannot be deleted at this time.'

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

    $data = $this->DentalImages->get($id);

    $data->visible = 0;

    if ($this->DentalImages->save($data)) {

      $path = "uploads/dental/" . @$data['apartelle_id'];

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

          'description' => 'Dental Management',

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

  public function approve($id = null){

    $this->autoRender = false;

    $data = $this->Dentals->get($id);

    $data->status = 3;

    $data->approve_by_id = $this->currentUser->id;

    if ($this->Dentals->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Dental has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Dental cannot be deleted at this time.'

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

  public function treated($id = null){

    $this->autoRender = false;

    $data = $this->Dentals->get($id);
    
    $data->status = 1;

    $data->treated_by_id = $this->currentUser->id;

    if($this->Dentals->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Dental has been successfully treated.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Treated',

          'description' => 'Dentals',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Dental cannot be treated this time.'

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

    $data = $this->Dentals->get($id);

     $data->status = 4;

    $data->disapprove_by_id = $this->currentUser->id;

    $data->disapproved_reason = $this->getRequest()->getData('explanation');

    if($this->Dentals->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Dental has been successfully disapproved.'

      );
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Disapproved',

          'description' => 'Dentals',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Dental cannot be disapproved this time.'

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

  public function referred($id = null){

    $this->autoRender = false;

    $data = $this->Dentals->get($id);

    $data->status = 2;

    // $data->referred_by_id = $this->currentUser->id;

    if($this->Dentals->save($data)){

      $response = array(

        'ok'   => true,

        'data' => $data,       

        'msg'  => 'Dental has been successfully reffered.'

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Reffered',

          'description' => 'Dentals',

          'code' => $data['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = array(

        'ok'   => false,

        'data' => $data,

        'msg'  =>'Dental cannot be reffered this time.'

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
