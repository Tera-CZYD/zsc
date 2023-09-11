<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class ApartellesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->Apartelles = TableRegistry::getTableLocator()->get('Apartelles');

    $this->ApartelleRegistrations = TableRegistry::getTableLocator()->get('ApartelleRegistrations');

    $this->ApartelleImages = TableRegistry::getTableLocator()->get('ApartelleImages');

     $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

     $this->autoRender = false;

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

      $conditions['date'] = " AND DATE(Apartelles.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startdate')) {

      $start = $this->request->getQuery('startdate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Apartelles.date) >= '$start' AND DATE(Apartelles.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $dataTable = TableRegistry::getTableLocator()->get('Apartelles');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllApartelle($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $apartelles = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($apartelles as $apartelle) {
      $id = $apartelle['id'];

      $query = $this->ApartelleRegistrations->find()

            ->where([

                'visible' => 1,

                'apartelle_id' => $id

            ])

            ->count();

      $counter = 0;

      if(is_numeric($apartelle['capacity'])){

        $counter = $apartelle['capacity'] - $query;

      }else{

        $counter = 0;
      }

      $datas[] = array(

        'id'           => $apartelle['id'],

        'code'         => $apartelle['code'],

        'building_no'         => $apartelle['building_no'],

        'room_no'     => $apartelle['room_no'],

        'price'   => $apartelle['price'],

        'capacity'   => $apartelle['capacity'],

        'available' => $counter

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

    $apartelleEntity = $this->Apartelles->newEntity($main['Apartelle']);

    $save = $this->Apartelles->save($apartelleEntity);

    if ($save) {

        $id = $save->id;

        // var_dump($id);

            // $id = $this->Apartelles->getLastInsertId();

            foreach ($uploadedFiles as $fieldName => $images) {

                $path = "uploads/apartelle/$id";

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

                if (isset($main['ApartelleImage'])) {

                  // var_dump($main);

                    foreach ($main['ApartelleImage'][count($main['ApartelleImage']) - 1]['images'] as $key => $valueImages) {

                        $valueImages['images'] = $names[$key];

                        $valueImages['apartelle_id'] = $id;

                        $datasImages[] = $valueImages;

                    }

                    $entities = $this->ApartelleImages->newEntities($datasImages);

                     $this->ApartelleImages->saveMany($entities);

                }
            }

            $response = [
                'ok' => true,
                'msg' => 'Apartelle/Dormitory has been successfully saved.',
                'data' => $requestData,
            ];

          $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Student Applciation Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);

    }else{

                $response = [
              'ok' => false,
              'data' => $requestData,
              'msg' => 'Apartelle/Dormitory cannot be saved at this time.',
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

    $data['Apartelle'] = $this->Apartelles
      ->find()
      ->contain([
          'ApartelleImages' => [
              'conditions' => ['ApartelleImages.visible' => 1]
          ]
      ])
      ->where([
          'Apartelles.visible' => 1,
          'Apartelles.id' => $id
      ])
      ->first();

    $data['Apartelle']['active_view'] = $data['Apartelle']['active'] ? 'True' : 'False';

    $data['Apartelle']['floors'] = intval($data['Apartelle']['floors']);

    $data['ApartelleImage'] = $data['Apartelle']['apartelle_images'];

    unset($data['Apartelle']['apartelle_images']);

    $apartelleImage = array();
    

    if(!empty($data['ApartelleImage'])){

      foreach($data['ApartelleImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $apartelleImage[] = array(

            'imageSrc' => $this->base . 'uploads/apartelle/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }
    }

    $response = [

      'ok' => true,

      'data' => $data,

      'apartelleImage' => $apartelleImage

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

    $apartelle = $this->Apartelles->get($id);

    $requestData = $this->getRequest()->getData('Apartelle');

    $this->Apartelles->patchEntity($apartelle, $requestData);

    if ($this->Apartelles->save($apartelle)) {

        $response = [

            'ok' => true,

            'msg' => 'Apartelle has been successfully updated.',

            'data' => $requestData,

        ];

        $userLogEntity = $this->UserLogs->newEntity([

            'action' => 'Edit',

            'description' => 'Apartelle Management',

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s'),

        ]);


        $this->UserLogs->save($userLogEntity);

    } else {

        $response = [

            'ok' => false,

            'msg' => 'Apartelle cannot be updated at this time.',

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

    $data = $this->Apartelles->get($id);

    $data->visible = 0;

    if ($this->Apartelles->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Apartelles has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Apartelle Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Apartelles cannot be deleted at this time.'

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

    $data = $this->ApartelleImages->get($id);

    $data->visible = 0;

    if ($this->ApartelleImages->save($data)) {

      $path = "uploads/apartelle/" . @$data['apartelle_id'];

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

          'description' => 'Apartelle Management',

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
