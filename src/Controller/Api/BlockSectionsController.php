<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class BlockSectionsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->BlockSections = TableRegistry::getTableLocator()->get('BlockSections');

    $this->BlockSectionCourses = TableRegistry::getTableLocator()->get('BlockSectionCourses');

    $this->BlockSectionSchedules = TableRegistry::getTableLocator()->get('BlockSectionSchedules');

    $this->Employees = TableRegistry::getTableLocator()->get('Employees');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    if ($this->request->getQuery('search')) {

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

    }

    $dataTable = TableRegistry::getTableLocator()->get('BlockSections');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllBlockSection($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $blockSections = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($blockSections as $blockSection) {

      $blockSectionCourseTable = TableRegistry::getTableLocator()->get('BlockSectionCourses');

      $courses = $blockSectionCourseTable->find()
        
        ->where([
          
          'visible' => 1,

          'block_section_id' => $blockSection['id'],

        ])

        ->toArray();

      $datas[] = array(

        'id'            => $blockSection['id'],

        'code'          => $blockSection['code'],  

        'college'       => $blockSection['college'], 

        'program'       => $blockSection['program'],      

        'year_term'     => $blockSection['description'], 

        'section'       => $blockSection['section'],    

        'school_year'   => $blockSection['school_year_start'].' - '.$blockSection['school_year_end'],

        'course'       => $courses

      );

    }

    $response = [

      'ok' => true,

      'data' => $datas,

      'paginator' => $paginator,

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function add(){

    $this->autoRender = false;

    $requestData = $this->request->getData('BlockSection');

    $course = $this->request->getData('BlockSectionCourse');

    // $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $data = $this->BlockSections->newEmptyEntity();
   
    $data = $this->BlockSections->patchEntity($data, $requestData);     

    if ($this->BlockSections->save($data)) {

      $id = $data->id;

      if (!empty($course)) {

        foreach ($course as $key => $value) {

            $course[$key]['block_section_id'] = $id;

        }

        $blockSectionCourseTable = TableRegistry::getTableLocator()->get('BlockSectionCourses');

        $blockSectionCourseEntities = $blockSectionCourseTable->newEntities($course);

        $blockSectionCourseTable->saveMany($blockSectionCourseEntities);

      }

      $response = array(

        'ok'  =>true,

        'msg' =>'Block Sections has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'Block Sections',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Block Sections cannot saved this time.',

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

    $data['BlockSection'] = $this->BlockSections->find()

      ->where([

        'BlockSections.visible' => 1,

        'BlockSections.id' => $id

      ])

      ->contain([

        'YearLevelTerms',

        'BlockSectionCourses'

      ])

      ->first();

    $data['YearLevelTerm'] = $data['BlockSection']['year_level_term'];

    unset($data['BlockSection']['year_level_term']);

    $data['BlockSectionCourse'] = $data['BlockSection']['block_section_courses'];

    unset($data['BlockSection']['block_section_courses']);

    $data['BlockSection']['active_view'] = $data['BlockSection']['active'] ? 'True' : 'False';

    // $data['BlockSection']['date'] = $data['BlockSection']['date']->format('m/d/Y');

    $data['BlockSection']['floors'] = intval($data['BlockSection']['floors']);

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

    $building = $this->BlockSections->get($id); 

    $requestData = $this->getRequest()->getData('BlockSection');

    $requestData['date'] = isset($requestData['date']) ? date('Y/m/d', strtotime($requestData['date'])) : null;

    $requestData['date'] = isset($requestData['date']) ? fdate($requestData['date'],'Y-m-d') : NULL;

    $this->BlockSections->patchEntity($building, $requestData); 

    if ($this->BlockSections->save($building)) {

      $response = array(

        'ok'  =>true,

        'msg' =>'Block Sections has been successfully updated.',

        'data'=>$requestData

      );
        
      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Edit',

          'description' => 'Block Sections',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'Block Sections cannot updated this time.',

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

    $data = $this->BlockSections->get($id);

    $data->visible = 0;

    if ($this->BlockSections->save($data)) {

      $response = [

        'ok' => true,

        'msg' => 'Block Section has been successfully deleted'

      ];

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'Block Section',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Block Section cannot be deleted at this time.'

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

  public function scheduleView($id = null) {

    $this->autoRender = false;

    $data['BlockSectionCourse'] = $this->BlockSectionCourses->find()

    ->contain([

      'BlockSectionSchedules' => [

        'conditions' => [

          'BlockSectionSchedules.visible' => 1

        ]

      ]

    ])

    ->where([

      'BlockSectionCourses.id' => $id,

      'BlockSectionCourses.visible' => 1

    ])

    ->first();

    $data['BlockSectionSchedule'] = $data['BlockSectionCourse']['block_section_schedules'];

    unset($data['BlockSectionCourse']['block_section_schedules']);

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

  public function scheduleAdd($id = null) {

    if($this->request->is('post')){

        $data = $this->getRequest()->getData();

        if (!empty($data)) { 

            $main = $this->BlockSectionCourses->get($data['block_section_course_id']);

            $blockSectionSchedule = $this->BlockSectionSchedules->newEmptyEntity();

            $blockSectionSchedule = $this->BlockSectionSchedules->patchEntity($blockSectionSchedule, [

                'block_section_id' => $main->block_section_id,

                'block_section_course_id' => $data['block_section_course_id'],

                'day' => $data['day'],

                'time_start' => $data['time_start'],

                'time_end' => $data['time_end'],

                'year_start' => $data['year_start'],

                'year_end' => $data['year_end'],

                'room_id' => $data['room_id'],

                'room' => $data['room'],

                'section_id' => $data['section_id'],

                'section' => $data['section'],

            ]);

            if ($this->BlockSectionSchedules->save($blockSectionSchedule)) {

              $response = [

                'ok' => true,

                'data' => $data,

                'msg' => 'Schedule has been successfully saved.',

              ];

            } else {

              $response = [

                'ok' => false,

                'data' => $data,

                'msg' => 'Failed to save schedule.',

              ];

            }

        } else {

            $response = [

              'ok' => false,

              'msg' => 'No data provided.',

            ];
        }

        $this->set([

          'response' => $response,

          '_serialize' => 'response',

        ]);

    }else{

        $data = $this->getRequest()->getData();

        $blockSectionSchedule = $this->BlockSectionSchedules->get($data['id']); 

        $this->BlockSectionSchedules->patchEntity($blockSectionSchedule, $data); 

        if ($this->BlockSectionSchedules->save($blockSectionSchedule)) {

          $response = array(

            'ok'  =>true,

            'msg' =>'Block Sections has been successfully updated.',

            'data'=>$data

          );
            
        }else {

          $response = array(

            'ok'  =>true,

            'data'=>$data,

            'msg' =>'Block Sections cannot updated this time.',

          );

        }

        $this->set(array(

          'response'=>$response,

          '_serialize'=>'response'

        ));

    }



    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function schedule_delete($id = null) {

    $schedule = $this->BlockSectionSchedules->get($id);

    // Try to delete the schedule

    if ($this->BlockSectionSchedules->delete($schedule)) {

      $response = [

        'ok' => true,

        'msg' => 'Schedule has been successfully deleted.',

        'data' => $schedule,

      ];

        // Assuming you have UserLog model loaded

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
      
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'Delete',

        'description' => 'Block Section Schedule',

        'code' => $schedule->day,

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

    ]);
      
      $userLogTable->save($userLogEntity);

    } else {

      $response = [

        'ok' => false,

        'msg' => 'Schedule cannot be deleted this time.',

        'data' => $id,

      ];

    }

    $this->set([

      'response' => $response,

      '_serialize' => 'response',

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function addFaculty($id = null) {

    $data = $this->getRequest()->getData();

    $blockSectionCourse = $this->BlockSectionCourses->get($id);

    if (!empty($data)) {

        $blockSectionCourse = $this->BlockSectionCourses->patchEntity($blockSectionCourse,$data);

        if ($this->BlockSectionCourses->save($blockSectionCourse)) {

          $response = [

            'ok' => true,

            'data' => $data,

            'msg' => 'Faculty in Block Section has been successfully saved.',

          ];

        } else {

          $response = [

            'ok' => false,

            'data' => $data,

            'msg' => 'Failed to save Faculty in Block Section.',

          ];

        }

    } else {

        $response = [

          'ok' => false,

          'msg' => 'No data provided.',

        ];
    }

    $this->set([

      'response' => $response,

      '_serialize' => 'response',

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

}
