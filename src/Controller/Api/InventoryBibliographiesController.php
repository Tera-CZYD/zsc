<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class InventoryBibliographiesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->InventoryBibliographies = TableRegistry::getTableLocator()->get('InventoryBibliographies');

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

      $conditions['material_type'] = " AND Bibliography.material_type_id = '$material_type'"; 

      $conditionsPrint .= '&material_type='.$material_type;

    }

    $conditions['collection_type'] = '';

    if ($this->request->getQuery('collection_type') != null) {

      $collection_type = $this->request->getQuery('collection_type');

      $conditions['collection_type'] = " AND Bibliography.collection_type_id = '$collection_type'"; 

      $conditionsPrint .= '&collection_type='.$collection_type;

    }


    $limit = 25;

    $tmpData = $this->InventoryBibliographies->paginate($this->InventoryBibliographies->getAllInventoryBibliography($conditions, $limit, $page), [

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

        'id' => $bibliography['id'],

        'code'  => $bibliography['code'],

        'title' => $bibliography['title'],

        'author' => $bibliography['author'],

        'terms' => $bibliography['terms_of_availability'],

        'quantity' => $bibliography['noOfCopy'],

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

    $data['Bibliography'] = $this->Bibliographies->find()

      ->contain([

        'CollectionTypes' => [

          'conditions' => ['CollectionTypes.visible' => 1]

        ],

        'MaterialTypes' => [

          'conditions' => ['MaterialTypes.visible' => 1]

        ],

        'InventoryBibliographies' => [

          'conditions' => ['InventoryBibliographies.visible' => 1]

        ]

      ])

      ->where([

        'Bibliographies.visible' => 1,

        'Bibliographies.id' => $id

      ])

    ->first();

    $data['InventoryBibliography'] = $data['Bibliography']['inventory_bibliographies'];

    $data['Bibliography']['date_of_publication'] = !is_null($data['Bibliography']['date_of_publication']) ? $data['Bibliography']['date_of_publication']->format('m/d/Y') : 'N/A';

    if($data['Bibliography']['call_number2'] == null || $data['Bibliography']['call_number2'] == ''){

      $data['Bibliography']['call_number2'] = null;

    }

    if($data['Bibliography']['call_number3'] == null || $data['Bibliography']['call_number3'] == ''){

      $data['Bibliography']['call_number3'] = null;

    }

    if(!empty($data['InventoryBibliography'])){

      foreach ($data['InventoryBibliography'] as $key => $value) {
        
        $data['InventoryBibliography'][$key]['status_dt'] = !is_null($value['status_dt']) ? $value['status_dt']->format('m/d/Y') : 'N/A';

      }

    }   

    $response = [

      'ok' => true,

      'data' => $data

    ];

    $this->set([

      'response' => $response,

      '_serialize' => 'response'

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function api_manual($id = null){

    $this->autoRender = false;

    $data = $this->request->getData();

    if(!empty($data)){

      $tmpEntity = $this->InventoryBibliographies->newEntity([

        'id'               => @$data['id'],

        'bibliography_id'  => $data['bibliography_id'],

        'barcode_no'       => $data['barcode_no'],

        'description'      => $data['description'],

        'status'           => 'Available'

      ]);
      
      $this->InventoryBibliographies->save($tmpEntity);

    }

    $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
    $userLogEntity = $userLogTable->newEntity([

      'action' => 'Add',

      'description' => 'Add Copy',

      'code' => $data['barcode_no'],

      'created' => date('Y-m-d H:i:s'),

      'modified' => date('Y-m-d H:i:s')

    ]);
    
    $userLogTable->save($userLogEntity);

    $response = array(

      'ok'   => true,

      'msg'  => 'Inventory Bibliography has been successfully saved.',

      'data' => $data,

    );

    $this->set(array(

      'response'=>$response, 

      '_serialize'=>'response'

    ));

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function api_manual_delete($id = null){

    $this->autoRender = false;

    $data = $this->request->getData();

    if(!empty($data)){

      $tmpEntity = $this->InventoryBibliographies->newEntity([

        'id'       => @$data['id'],

        'visible'  => 0

      ]);
      
      $this->InventoryBibliographies->save($tmpEntity);

      $response = [

        'ok' => true,

        'msg' => 'Inventory Bibliography has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Delete',

        'description' => 'Inventory Bibliography',

        'code' => $data['barcode_no'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Inventory Bibliography cannot be deleted at this time.'

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
