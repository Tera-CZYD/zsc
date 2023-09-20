<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class BibliographiesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Bibliographies = TableRegistry::getTableLocator()->get('Bibliographies');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditionsPrint = '';

    $conditions = [];

    if($this->request->getQuery('search') != null){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date') != null) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(Bibliography.date_of_publication) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('startDate') != null) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(Bibliography.date_of_publication) >= '$start' AND DATE(Bibliography.date_of_publication) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $conditions['material_type'] = '';

    if ($this->request->getQuery('material_type') != null) {

      $material_type = $this->request->getQuery('material_type');

      $conditions['date'] = " AND Bibliography.material_type_id = '$material_type'"; 

      $conditionsPrint .= '&material_type='.$material_type;

    }


    $limit = 25;

    $tmpData = $this->Bibliographies->paginate($this->Bibliographies->getAllBibliography($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $bibliographies = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($bibliographies as $bibliography) {

      $datas[] = array(

         'id'                    => $bibliography['id'],

         'code'                  => $bibliography['code'],

         'title'                 => $bibliography['title'],

         'call_number1'          => $bibliography['call_number1'],

         'call_number2'          => $bibliography['call_number2'],

         'call_number3'          => $bibliography['call_number3'],

         'author'                => $bibliography['author'],

         'material_type'         => $bibliography['material_type'],

         'collection_type'       => $bibliography['collection_type'],

         'copyright'             => $bibliography['copyright'],

         'date_of_publication'   => fdate($bibliography['date_of_publication'],'m/d/Y'),

         'no_of_copy'            => $bibliography['noOfCopy'],

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

    $requestData = $this->request->getData('Bibliography');

    $requestData['date_of_publication'] = isset($requestData['date_of_publication']) ? fdate($requestData['date_of_publication'],'Y-m-d') : NULL;

    $data = $this->Bibliographies->newEmptyEntity();
   
    $data = $this->Bibliographies->patchEntity($data, $requestData); 

    if ($this->Bibliographies->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Bibliography has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Bibliography Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Bibliography cannot saved this time.',

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

  public function view($id = null){

    $data['Bibliography'] = $this->Bibliographies->find()

      ->contain([

        'CollectionTypes' => [

          'conditions' => ['CollectionTypes.visible' => 1]

        ],

        'MaterialTypes' => [

          'conditions' => ['MaterialTypes.visible' => 1]

        ]

      ])

      ->where([

        'Bibliographies.visible' => 1,

        'Bibliographies.id' => $id

      ])

    ->first();

    $response = [

      'ok' => true,

      'data' => $data

    ];

    $this->set([

      'response' => $response,

      '_serialize' => 'response'

    ]);

    $data['Bibliography']['date_of_publication'] = !is_null($data['Bibliography']['date_of_publication']) ? $data['Bibliography']['date_of_publication']->format('m/d/Y') : '';

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function edit($id){

    $material = $this->Bibliographies->get($id); 

    $requestData = $this->getRequest()->getData('Bibliography');

    $requestData['date_of_publication'] = isset($requestData['date_of_publication']) ? fdate($requestData['date_of_publication'],'Y-m-d') : NULL;

    $this->Bibliographies->patchEntity($material, $requestData); 

    if ($this->Bibliographies->save($material)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Bibliography has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Bibliography Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Bibliography cannot updated this time.',

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

    $data = $this->Bibliographies->get($id);

    $data->visible = 0;

    if ($this->Bibliographies->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Bibliography has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Bibliography Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Bibliography cannot be deleted at this time.'

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
