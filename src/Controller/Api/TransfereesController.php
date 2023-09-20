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

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Transferee.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Transferee.date) >= '$start' AND DATE(Transferee.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

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

        'date'              => fdate($data['date'],'m/d/Y')

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

        ]

      ])

      ->where([

        'Transferees.visible' => 1,

        'Transferees.id' => $id

      ])

    ->first();

    $data['Transferee']['date'] = !is_null($data['Transferee']['date']) ? $data['Transferee']['date']->format('m/d/Y') : null;

    $data['TransfereeImage'] = $data['Transferee']['transferee_images'];

    unset($data['Transferee']['transferee_images']);

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

}
