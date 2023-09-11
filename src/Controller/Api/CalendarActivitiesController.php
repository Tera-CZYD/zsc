<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\I18n\Time;



class CalendarActivitiesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->CalendarActivities = TableRegistry::getTableLocator()->get('CalendarActivities');

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

      $conditions['date'] = " AND DATE(CalendarActivity.date) = '$search_date'"; 

      $dates['date'] = $search_date;

      $conditionsPrint .= '&date='.$search_date;

    }  

    //advance search

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(CalendarActivity.date) >= '$start' AND DATE(CalendarActivity.date) <= '$end'";

      $dates['startDate'] = $start;

      $dates['endDate']   = $end;

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }


    $limit = 25;

    $tmpData = $this->CalendarActivities->paginate($this->CalendarActivities->getAllCalendarActivity($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $calendar_activities = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];
    foreach ($calendar_activities as $data) {

      $datas[] = array(

  
          'id'         => $data['id'],
  
          'code'       => $data['code'],

          'title'      => $data['title'],

          'startDate'  => $data['startDate'],

          'endDate'    => $data['endDate'],

          'remarks'    => $data['remarks'],

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

    $requestData = $this->request->getData('CalendarActivity');

    // $requestData['date'] = isset($requestData['date']) ? date('Y-m-d', strtotime($requestData['date'])) : null;

    $requestData['startDate'] = isset($requestData['startDate']) ? date('Y-m-d', strtotime($requestData['startDate'])) : null;

    $requestData['endDate'] = isset($requestData['endDate']) ? date('Y-m-d', strtotime($requestData['endDate'])) : null;

    $data = $this->CalendarActivities->newEmptyEntity();
   
    $data = $this->CalendarActivities->patchEntity($data, $requestData); 

    if ($this->CalendarActivities->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Calendar Activity has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Calendar Activity Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Calendar Activity cannot saved this time.',

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

    $data['CalendarActivity'] = $this->CalendarActivities->find()

      ->where([

        'CalendarActivities.visible' => 1,

        'CalendarActivities.id' => $id

      ])

      ->first();

      // $data['Affidavit']['date'] = isset($data['Affidavit']['date']) ? date('m/d/Y', strtotime($data['Affidavit']['date'])) : null;

      $data['CalendarActivity']['startDate'] = isset($data['CalendarActivity']['startDate']) ? date('m/d/Y',strtotime($data['CalendarActivity']['startDate'])) : 'N/A';

    $data['CalendarActivity']['endDate'] = isset($data['CalendarActivity']['endDate']) ? date('m/d/Y',strtotime($data['CalendarActivity']['endDate'])) : 'N/A';

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


  public function edit($id){

    $data = $this->CalendarActivities->get($id); 

    $requestData = $this->getRequest()->getData('CalendarActivity');

    // $requestData['date'] = isset($requestData['date']) ? date('Y-m-d', strtotime($requestData['date'])) : NULL;

    $requestData['startDate'] = isset($requestData['startDate']) ? date('Y-m-d', strtotime($requestData['startDate'])) : null;

    $requestData['endDate'] = isset($requestData['endDate']) ? date('Y-m-d', strtotime($requestData['endDate'])) : null;

    $this->CalendarActivities->patchEntity($data, $requestData); 

    if ($this->CalendarActivities->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Calendar Activity has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Calendar Activity',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Calendar Activity cannot updated this time.',

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

    $data = $this->CalendarActivities->get($id);

    $data->visible = 0;

    if ($this->CalendarActivities->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Calendar Activity has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Calendar Activity cannot be deleted at this time.'

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
