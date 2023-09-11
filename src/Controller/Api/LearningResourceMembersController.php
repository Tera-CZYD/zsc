<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class LearningResourceMembersController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->LearningResourceMembers = TableRegistry::getTableLocator()->get('LearningResourceMembers');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditionsPrint = '';

    $conditions = [];

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $search_date = $this->request->getQuery('date');

      $conditions['date'] = " AND DATE(LearningResourceMember.date) = '$search_date'"; 

      $conditionsPrint .= '&date='.$search_date;

    }

    if ($this->request->getQuery('college')) {

      $college_id = $this->request->getQuery('college');

      $conditions['advSearch'] = "AND LearningResourceMember.college_id = $college_id";

      $conditionsPrint .= '&college='.$college_id;

    }

    if ($this->request->getQuery('program')) {

      $program_id = $this->request->getQuery('program');

      $conditions['advSearch'] = "AND LearningResourceMember.program_id = $program_id";

      $conditionsPrint .= '&program='.$program_id;

    }

    $conditions['classification'] = '';

    if ($this->request->getQuery('classification')) {

      $classification = $this->request->getQuery('classification');

      $conditions['classification'] = "AND LearningResourceMember.classification = '$classification'";

      $conditionsPrint .= '&classification='.$classification;

    }

    if ($this->request->getQuery('startDate')) {

      $start = $this->request->getQuery('startDate'); 

      $end = $this->request->getQuery('endDate');

      $conditions['date'] = " AND DATE(LearningResourceMember.date) >= '$start' AND DATE(LearningResourceMember.date) <= '$end'";

      $conditionsPrint .= '&startDate='.$start.'&endDate='.$end;

    }

    $dataTable = $this->LearningResourceMembers;

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllLearningResourceMember($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $members = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($members as $member) {

      $member_name = '';

      if($member['student_name'] != null){

        $member_name = $member['student_name'];

      }elseif($member['employee_name'] != null){

        $member_name = $member['employee_name'];

      }elseif($member['admin_name'] != null){

        $member_name = $member['admin_name'];

      }

      $datas[] = array(

        'id'                 => $member['id'],

        'library_id_number'  => $member['library_id_number'],

        'member_name'        => $member_name,

        'program'            => $member['college_program'],

        'year_level'         => $member['year_level'],

        'faculty_status'     => $member['faculty_status'],

        'office'             => $member['office'],

        'date'               => fdate($member['date'],'m/d/Y'),

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

    $requestData = $this->request->getData('LearningResourceMember');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->LearningResourceMembers->newEmptyEntity();
   
    $data = $this->LearningResourceMembers->patchEntity($data, $requestData); 

    if ($this->LearningResourceMembers->save($data)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Member has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Learning Resource Member Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Member cannot saved this time.',

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

    $data['LearningResourceMember'] = $this->LearningResourceMembers->find()

      ->contain([

        'YearLevelTerms' => [

          'conditions' => ['YearLevelTerms.visible' => 1]

        ],

        'CollegePrograms' => [

          'conditions' => ['CollegePrograms.visible' => 1]

        ],

        'Colleges' => [

          'conditions' => ['Colleges.visible' => 1]

        ],

      ])

      ->where([

        'LearningResourceMembers.visible' => 1,

        'LearningResourceMembers.id' => $id

      ])

    ->first();

    $data['LearningResourceMember']['date'] = $data['LearningResourceMember']['date']->format('m/d/Y');

    if($data['LearningResourceMember']['classification'] == 'STUDENT'){

      $data['LearningResourceMember']['member_name'] = $data['LearningResourceMember']['student_name'];

    }elseif($data['LearningResourceMember']['classification'] == 'FACULTY'){

      $data['LearningResourceMember']['member_name'] = $data['LearningResourceMember']['employee_name'];

    }elseif($data['LearningResourceMember']['classification'] == 'ADMIN'){

      $data['LearningResourceMember']['member_name'] = $data['LearningResourceMember']['admin_name'];

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

  public function edit($id){

    $member = $this->LearningResourceMembers->get($id); 

    $requestData = $this->getRequest()->getData('LearningResourceMember');

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->LearningResourceMembers->patchEntity($member, $requestData); 

    if ($this->LearningResourceMembers->save($member)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Member has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Learning Resource Member Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Member cannot updated this time.',

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

    $data = $this->LearningResourceMembers->get($id);

    $data->visible = 0;

    if ($this->LearningResourceMembers->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Member has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Learning Resource Member Management',

          'code' => '',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Member cannot be deleted at this time.'

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
