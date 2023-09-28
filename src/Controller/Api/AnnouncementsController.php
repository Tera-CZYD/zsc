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

class AnnouncementsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Announcements = TableRegistry::getTableLocator()->get('Announcements');

    $this->AnnouncementImages = TableRegistry::getTableLocator()->get('AnnouncementImages');

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

    $tmpData = $this->Announcements->paginate($this->Announcements->getAllAnnouncement($conditions, $limit, $page), [

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

      $images = $this->AnnouncementImages->find()

        ->where([

          'announcement_id' => $id,

          'visible' => 1

        ])

        ->all();

      foreach ($images as $key => $image) {
        
        $imgTmp[] = array(

          'imageSrc' => $this->base . '/uploads/announcement/' . $id . '/' . @$image['images'],

          'name' => @$image['images'],

          'id' => @$image['id'],

        );

      }

      // var_dump($role);

      $datas[] = array(

        'id'                => $data['id'],

        'title'        => $data['title'],

        'img'         => $imgTmp,

        'date'          => fdate($data['date'],'m/d/Y'),

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

      $main['Announcement']['date'] = isset($main['Announcement']['date']) ? fdate($main['Announcement']['date'],'Y-m-d') : null;

      $main['Announcement']['receiver'] = '1'.','.@$main['Announcement']['receiver'][1].','.@$main['Announcement']['receiver'][2].','.@$main['Announcement']['receiver'][3].','.@$main['Announcement']['receiver'][4].','.@$main['Announcement']['receiver'][5].','.@$main['Announcement']['receiver'][6].','.@$main['Announcement']['receiver'][7].','.@$main['Announcement']['receiver'][8].','.@$main['Announcement']['receiver'][9].','.@$main['Announcement']['receiver'][10];


      $uploadedFiles = $this->request->getUploadedFiles();

      $data = $this->Announcements->newEmptyEntity();
   
      $data = $this->Announcements->patchEntity($data, $main['Announcement']); 

      if($this->Announcements->save($data)) {

        $id = $data->id;

        foreach ($uploadedFiles as $fieldName => $images) {

          $path = "uploads/announcement/$id";

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

          if (isset($main['announcementImage'])) {

            foreach ($main['announcementImage'][count($main['announcementImage']) - 1]['images'] as $key => $valueImages) {

              $valueImages['images'] = $names[$key];

              $valueImages['announcement_id'] = $id;

              $datasImages[] = $valueImages;

            }

            $entities = $this->AnnouncementImages->newEntities($datasImages);

            $this->AnnouncementImages->saveMany($entities);

          }

        }

        $response = array(

          'ok'  =>true,

          'msg' =>'Announcement has been successfully saved.',

          'data'=>$main['Announcement']

        );

        $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'userId' => $this->Auth->user('id'),

          'description' => 'Announcement',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);

      }else{

        $response = array(

          'ok'  =>false,

          'data'=>$main['Announcement'],

          'msg' =>'Announcement cannot saved this time.',

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

    $data['Announcement'] = $this->Announcements->find()

      ->contain([

        'AnnouncementImages' => [

          'conditions' => ['AnnouncementImages.visible' => 1]

        ]

      ])

      ->where([

        'Announcements.visible' => 1,

        'Announcements.id' => $id

      ])

    ->first();

    $data['Announcement']['date'] = !is_null($data['Announcement']['date']) ? $data['Announcement']['date']->format('m/d/Y') : null;

    $data['AnnouncementImage'] = $data['Announcement']['announcement_images'];

    unset($data['Announcement']['announcement_images']);

    $announcementImage = array();

    if(!empty($data['AnnouncementImage'])){

      foreach($data['AnnouncementImage'] as $key => $image){

        if (!is_null($image['images'])) {

          $announcementImage[] = array(

            'imageSrc' => $this->base . '/uploads/announcement/' . $id . '/' . @$image['images'],

            'name' => @$image['images'],

            'id' => @$image['id'],

          );

        }

      }
    }

    $data['Announcement']['receiver'] = explode(',',$data['Announcement']['receiver']);

    $counter = count($data['Announcement']['receiver']);

    // var_dump($counter);

    if (!empty($data['Announcement']['receiver'])){

      foreach ($data['Announcement']['receiver'] as $key => $value) {
        
        $data['Announcement']['receiver'][$key] = $data['Announcement']['receiver'][$key] == 1 ? true: false;

      }

    }

    $response = [

      'ok' => true,

      'data' => $data,

      'announcementImage' => $announcementImage

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

    $data = $this->Announcements->get($id); 

    $requestData = $this->getRequest()->getData('Announcement');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : null;

    $requestData['receiver'] = '1'.','.@$requestData['receiver'][1].','.@$requestData['receiver'][2].','.@$requestData['receiver'][3].','.@$requestData['receiver'][4].','.@$requestData['receiver'][5].','.@$requestData['receiver'][6].','.@$requestData['receiver'][7].','.@$requestData['receiver'][8].','.@$requestData['receiver'][9].','.@$requestData['receiver'][10];

    $this->Announcements->patchEntity($data, $requestData); 

    if ($this->Announcements->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Announcement has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'userId' => $this->Auth->user('id'),

          'description' => 'Announcement',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Announcement cannot updated this time.',

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

    $data = $this->Announcements->get($id);

    $data->visible = 0;

    if ($this->Announcements->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Announcement has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'userId' => $this->Auth->user('id'),

          'description' => 'Announcement',

          'code' => $data->student_no,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Announcement cannot be deleted at this time.'

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

    $data = $this->AnnouncementImages->get($id);

    $path = "uploads/announcement/" . $data->announcement_id;

    $orgFile = $path . '/' . $data->images;

    $data->visible = 0;

    if ($this->AnnouncementImages->save($data)) {

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
