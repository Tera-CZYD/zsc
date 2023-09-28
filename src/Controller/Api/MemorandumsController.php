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

class MemorandumsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Memorandums = TableRegistry::getTableLocator()->get('Memorandums');

    $this->MemorandumImages = TableRegistry::getTableLocator()->get('MemorandumImages');

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

    if ($this->request->getQuery('search') != null) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }


    $limit = 25;

    $tmpData = $this->Memorandums->paginate($this->Memorandums->getAllMemorandum($conditions, $limit, $page), [

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

      $id = $data['id'];

      $imgTmp = array();

      $images = $this->MemorandumImages->find()

        ->where([

          'memorandum_id' => $id,

          'visible' => 1

        ])

        ->all();

      foreach ($images as $key => $image) {
        
        $imgTmp[] = array(

          'imageSrc' => $this->base . '/uploads/memorandum/' . $id . '/' . @$image['images'],

          'name' => @$image['images'],

          'id' => @$image['id'],

        );

      }

      $data['receiver'] = explode(',',$data['receiver']);

        if (!empty($data['receiver'])){

        foreach ($data['receiver'] as $key => $value) {
          
          $data['receiver'][$key] = $data['receiver'][$key] == 1 ? true: false;

        }

      }

      // var_dump($data['receiver']);

      $datas[] = array(

        'id'                => $data['id'],

        'title'        => $data['title'],

        'img'         => $imgTmp

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

      // var_dump($main);

      $main['Memorandum']['date'] = isset($main['Memorandum']['date']) ? fdate($main['Memorandum']['date'],'Y-m-d') : null;

      $main['Memorandum']['receiver'] = '1'.','.@$main['Memorandum']['receiver'][1].','.@$main['Memorandum']['receiver'][2].','.@$main['Memorandum']['receiver'][3].','.@$main['Memorandum']['receiver'][4].','.@$main['Memorandum']['receiver'][5].','.@$main['Memorandum']['receiver'][6].','.@$main['Memorandum']['receiver'][7].','.@$main['Memorandum']['receiver'][8].','.@$main['Memorandum']['receiver'][9].','.@$main['Memorandum']['receiver'][10];


      $uploadedFiles = $this->request->getUploadedFiles();

      $data = $this->Memorandums->newEmptyEntity();
   
      $data = $this->Memorandums->patchEntity($data, $main['Memorandum']); 

      if($this->Memorandums->save($data)) {

        $id = $data->id;

        foreach ($uploadedFiles as $fieldName => $images) {

          $path = "uploads/memorandum/$id";

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
        // var_dump($newPRImage);

        if (!empty($newPRImage)) {

          if (isset($main['memorandumImage'])) {

            foreach ($main['memorandumImage'][count($main['memorandumImage']) - 1]['images'] as $key => $valueImages) {

              $valueImages['images'] = $names[$key];

              $valueImages['memorandum_id'] = $id;

              $datasImages[] = $valueImages;

            }

            $entities = $this->MemorandumImages->newEntities($datasImages);

            $this->MemorandumImages->saveMany($entities);

          }

        }

        $response = array(

          'ok'  =>true,

          'msg' =>'Memorandum has been successfully saved.',

          'data'=>$main['Memorandum']

        );

        $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'userId' => $this->Auth->user('id'),

          'description' => 'Memorandum',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);

      }else{

        $response = array(

          'ok'  =>false,

          'data'=>$main['Memorandum'],

          'msg' =>'Memorandum cannot saved this time.',

        );

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

    $data['Memorandum'] = $this->Memorandums->find()

      ->contain([

        'MemorandumImages' => [

          'conditions' => ['MemorandumImages.visible' => 1]

        ]

      ])

      ->where([

        'Memorandums.visible' => 1,

        'Memorandums.id' => $id

      ])

    ->first();

    $data['Memorandum']['date'] = !is_null($data['Memorandum']['date']) ? $data['Memorandum']['date']->format('m/d/Y') : null;

    $data['MemorandumImage'] = $data['Memorandum']['memorandum_images'];

    unset($data['Memorandum']['memorandum_images']);

    $memorandumImage = array();

    if(!empty($data['MemorandumImage'])){

      foreach($data['MemorandumImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $memorandumImage[] = array(

            'imageSrc' => $this->base . '/uploads/memorandum/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }
    }

    $response = [

      'ok' => true,

      'data' => $data,

      'memorandumImage' => $memorandumImage

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

    $data = $this->Memorandums->get($id); 

    $requestData = $this->getRequest()->getData('Memorandum');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $this->Memorandums->patchEntity($data, $requestData); 

    if ($this->Memorandums->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Memorandum has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'userId' => $this->Auth->user('id'),

          'description' => 'Memorandum',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Memorandum cannot updated this time.',

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

    $data = $this->Memorandums->get($id);

    $data->visible = 0;

    if ($this->Memorandums->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Memorandum has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'userId' => $this->Auth->user('id'),

          'description' => 'Memorandum',

          'code' => $data->student_no,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Memorandum cannot be deleted at this time.'

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

  public function deleteImage($id=null){

    // $id = $this->request->getParam('id');

    $data = $this->MemorandumImages->get($id);

    $path = "uploads/memorandum/" . $data->memorandum_id;

    $orgFile = $path . '/' . $data->images;

    $data->visible = 0;

    if ($this->MemorandumImages->save($data)) {

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

}
