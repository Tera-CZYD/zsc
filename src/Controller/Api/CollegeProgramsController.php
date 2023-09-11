<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
 

class CollegeProgramsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->CollegePrograms = TableRegistry::getTableLocator()->get('CollegePrograms');

    $this->CollegeProgramCourse = TableRegistry::getTableLocator()->get('CollegeProgramCourses');

    $this->CollegeProgramPrerequisite = TableRegistry::getTableLocator()->get('CollegeProgramPrerequisites');

    $this->CollegeProgramCorequisite = TableRegistry::getTableLocator()->get('CollegeProgramCorequisites');

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

    $dataTable = TableRegistry::getTableLocator()->get('CollegePrograms');

    $limit = 25;

    $tmpData = $dataTable->paginate($dataTable->getAllCollegeProgram($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $college_programs = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($college_programs as $college_program) {

      $datas[] = array(

        'id'           => $college_program['id'],

        'name'         => $college_program['name'],

        'code'         => $college_program['code'],

        'acronym'         => $college_program['acronym'],

        'major'         => $college_program['major'],

        'program_name'         => $college_program['program_name'],

        'capacity'         => $college_program['capacity'],

        'program_term_id'         => $college_program['program_term_id'],

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

    $CollegeProgramSubs = $this->CollegeProgramSubs = TableRegistry::getTableLocator()->get('CollegeProgramSubs');

    $requestData = $this->request->getData('CollegeProgram');

    $subs = $this->request->getData('CollegeProgramSub');

    $data = $this->CollegePrograms->newEmptyEntity();
   
    $data = $this->CollegePrograms->patchEntity($data, $requestData); 

    if ($this->CollegePrograms->save($data)) {

       $id = $data->id;


      if (!empty($subs)) {
          foreach ($subs as $sub) {

          $subEntities = $CollegeProgramSubs->newEntity([

              'college_program_id' => $id,

              'requirement' => $sub['requirement'],

          ]);

          $this->CollegeProgramSubs->save($subEntities);
      }

      $response = array(

        'ok'  =>true,

        'msg' =>'College Program has been successfully saved.',

        'data'=>$requestData

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Add',

          'description' => 'College Program Management',

          'code' => $requestData['code'],

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

    }else {

      $response = array(

        'ok'  =>true,

        'data'=>$requestData,

        'msg' =>'College Program cannot saved this time.',

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

  public function view($id = null){


      $query = $this->CollegePrograms->find()

        ->contain([

            'ProgramTerms' => function ($q) {

                return $q

                ->where(['ProgramTerms.visible' => 1]);

            },

            'CollegeProgramSubs' => function ($q) {

                return $q

                ->where(['CollegeProgramSubs.visible' => 1]);

            }

        ])

        ->where([

            'CollegePrograms.visible' => 1,

            'CollegePrograms.id'      => $id,

        ])

        ->first();

    $data = [

        'CollegeProgram' => $query,

        'ProgramTerm' => !empty($query->program_terms) ? $query->program_terms[0] : null,

        'CollegeProgramSub' => $query->CollegeProgramSubs

    ];

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


  public function edit($id = null)
  {
      $this->autoRender = false;

      $CollegeProgramSubs = $this->CollegeProgramSubs = TableRegistry::getTableLocator()->get('CollegeProgramSubs');

      $requestData = $this->request->getData('CollegeProgram');

      $subs = $this->request->getData('CollegeProgramSub');

      $id = $requestData['id'];

      $data = $this->CollegePrograms->get($id);

      $data = $this->CollegePrograms->patchEntity($data, $requestData);

      if ($this->CollegePrograms->save($data)) {

          $this->CollegePrograms->CollegeProgramSubs->deleteAll(['college_program_id' => $id]);

          if (!empty($subs)) {
              foreach ($subs as $sub) {
                  $subEntities = $CollegeProgramSubs->newEntity([
                      'college_program_id' => $id,
                      'requirement' => $sub['requirement'],
                  ]);

                  $this->CollegeProgramSubs->save($subEntities);
              }
          }

          $response = [
              'ok' => true,
              'msg' => 'College Program has been successfully updated.',
              'data' => $requestData,
          ];

          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
          $userLogEntity = $userLogTable->newEntity([

              'action' => 'Add',

              'description' => 'College Program Management',

              'code' => $requestData['code'],

              'created' => date('Y-m-d H:i:s'),

              'modified' => date('Y-m-d H:i:s')

          ]);
          
          $userLogTable->save($userLogEntity);

      } else {

          $response = [

              'ok' => false,

              'data' => $requestData,

              'msg' => 'College Program could not be updated this time.',

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

  public function delete($id){

    $this->autoRender = false;

    $this->request->allowMethod(['delete']);

    $data = $this->CollegePrograms->get($id);

    $data->visible = 0;

    if ($this->CollegePrograms->save($data)) {

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
      $userLogEntity = $userLogTable->newEntity([

          'action' => 'Delete',

          'description' => 'College Program Management',

          'code' => $data->code,

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity);

      $response = [

        'ok' => true,

        'msg' => 'College Program has been successfully deleted'

      ];

    } else {

      $response = [

        'ok' => false,

        'msg' => 'College Program cannot be deleted at this time.'

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

  public function course($id = null)
  {
      $this->autoRender = false;

      // Get request data for CollegeProgramCourse
      $main = $this->request->getData('CollegeProgramCourse');

      $main['college_program_id'] = $this->request->getQuery('id');

      $prerequisite = $this->request->getData('CollegeProgramPrerequisite');

      $corequisite = $this->request->getData('CollegeProgramCorequisite');

      $courseEntity = $this->CollegeProgramCourse->newEntity($main);

      $patchEntity = $this->CollegeProgramCourse->patchEntity($courseEntity, $main); 

      if ($this->CollegeProgramCourse->save($patchEntity)) {

          $id = $courseEntity->id;

          if (!empty($prerequisite)) {

              $prerequisiteEntities = [];

              foreach ($prerequisite as $key => $value) {

                  $value['college_program_id'] = $main['college_program_id'];

                  $value['college_program_course_id'] = $id;

                  $prerequisiteEntities[] = $this->CollegeProgramPrerequisite->newEntity($value);

              }

              $this->CollegeProgramPrerequisite->saveMany($prerequisiteEntities);
          }

          if (!empty($corequisite)) {

              $corequisiteEntities = [];

              foreach ($corequisite as $key => $value) {

                  $value['college_program_id'] = $main['college_program_id'];

                  $value['college_program_course_id'] = $id;

                  $corequisiteEntities[] = $this->CollegeProgramCorequisite->newEntity($value);

              }

              $this->CollegeProgramCorequisite->saveMany($corequisiteEntities);

          }

          $response = [

              'ok' => true,

              'msg' => 'College Program Course has been successfully saved.',

              'data' => $patchEntity

          ];

          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
          $userLogEntity = $userLogTable->newEntity([

            'action' => 'Add',

            'description' => 'College Program View Course Management',

            'code' => $patchEntity->course,

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s')

        ]);
        
        $userLogTable->save($userLogEntity);

      } else {

          $response = [

              'ok' => false,

              'data' => [],

              'msg' => 'College Program Course cannot be saved this time.'

          ];

      }

      $this->set([

          'response' => $response,

          '_serialize' => 'response'

      ]);

      $this->response = $this->response->withType('application/json');

      $this->response = $this->response->withStringBody(json_encode($response));


      return $this->response;
  }

    public function course_view(){

      $this->autoRender = false;

      $id = $this->request->getParam('id');

      $query = $this->CollegeProgramCourse->find()

        ->contain([

            'CollegeProgramPrerequisites' => [

                'Courses' => function ($q) {

                    return $q->where(['Courses.visible' => 1]);

                },

            ],

            'CollegeProgramCorequisites' => [

                'Courses' => function ($q) {

                    return $q->where(['Courses.visible' => 1]);

                },

            ],

            'CollegePrograms' => function ($q) {

                return $q->where(['CollegePrograms.visible' => 1]);

            },

            'Courses' => function ($q) {

                return $q->where(['Courses.visible' => 1]);

            },

            'YearLevelTerms' => function ($q) {

                return $q->where(['YearLevelTerms.visible' => 1]);

            },

        ])
        ->where([

            'CollegeProgramCourses.visible' => 1,

            'CollegeProgramCourses.id' => $id,

        ])

        ->first();

     $data = [

        'CollegeProgramCourse' => $query,

        'CollegeProgram' => $query->CollegeProgram,

        'Course' => $query->course_data,

        'YearLevelTerm' => $query->YearLevelTerm,

        'CollegeProgramCorequisite' => $query->CollegeProgramCorequisite,

        'CollegeProgramPrerequisite' => $query->CollegeProgramPrerequisite,

    ];

    $query = $query->toArray();

    $data['CollegeProgramCourse']['curriculum_view'] = $data['CollegeProgram']['code'].' - '.$data['CollegeProgram']['name'];

    $response = [

        'ok' => true,

        'data' => $data,

    ];

    $this->set([

        'response' => $response,

        '_serialize' => 'response'

    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function course_update()
  {

       $this->autoRender = false;

      // Get request data for CollegeProgramCourse
      $main = $this->request->getData('CollegeProgramCourse');

      $existingEntity = $this->CollegeProgramCourse->get($main['id']);

      $courses = TableRegistry::getTableLocator()->get('Courses');

      $course_title = $courses->find()->select(['code','title']) ->where(['id' => $main['course_id']])->first();

      $course = $course_title->code. ' - ' . $course_title->title;

      $main['course'] = $course;

      $prerequisite = $this->request->getData('CollegeProgramPrerequisite');

      $corequisite = $this->request->getData('CollegeProgramCorequisite');

      $patchEntity = $this->CollegeProgramCourse->patchEntity($existingEntity, $main); 

      if ($this->CollegeProgramCourse->save($patchEntity)) {

          $id = $patchEntity;

          if (!empty($prerequisite)) {

              $prerequisiteEntities = [];

              foreach ($prerequisite as $key => $value) {

                  $value['college_program_id'] = $main['college_program_id'];

                  $value['college_program_course_id'] = $id;

                  $prerequisiteEntities[] = $this->CollegeProgramPrerequisite->newEntity($value);

              }

              $this->CollegeProgramPrerequisite->saveMany($prerequisiteEntities);

          }

          if (!empty($corequisite)) {

              $corequisiteEntities = [];

              foreach ($corequisite as $key => $value) {

                  $value['college_program_id'] = $main['college_program_id'];

                  $value['college_program_course_id'] = $id;

                  $corequisiteEntities[] = $this->CollegeProgramCorequisite->newEntity($value);

              }

              $this->CollegeProgramCorequisite->saveMany($corequisiteEntities);

          }

          $response = [

              'ok' => true,

              'msg' => 'College Program Course has been successfully saved.',

              'data' => $patchEntity

          ];

          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
          $userLogEntity = $userLogTable->newEntity([

            'action' => 'Add',

            'description' => 'College Program View Course Management',

            'code' => $patchEntity->course,

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s')

        ]);
        
        $userLogTable->save($userLogEntity);

      } else {

          $response = [

              'ok' => false,

              'data' => [],

              'msg' => 'College Program Course cannot be saved this time.'

          ];

      }

      $this->set([

          'response' => $response,

          '_serialize' => 'response'

      ]);

      $this->response = $this->response->withType('application/json');

      $this->response = $this->response->withStringBody(json_encode($response));

      return $this->response;

  }

    public function course_delete($id = null) {

      // $this->request->allowMethod(['delete']);

      $this->autoRender = false;

      $main = $this->request->getData('data');

      $main['visible'] = 0;

      $existingEntity = $this->CollegeProgramCourse->get($main['id']);

      $patchEntity = $this->CollegeProgramCourse->patchEntity($existingEntity, $main); 

      if ($this->CollegeProgramCourse->save($patchEntity)) {

        $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
          
        $userLogEntity = $userLogTable->newEntity([

            'action' => 'Delete',

            'description' => 'College Program View Course Management',

            'code' => $patchEntity->course,

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s')

        ]);
        
        $userLogTable->save($userLogEntity);

      // Assuming you have a 'hide' method in your CollegeProgramCourse model
      // if ($this->CollegeProgramCourse->hide($main['id'])) {

          // Update related data to be hidden
          $collegeProgramPrerequisiteTable = TableRegistry::getTableLocator()->get('CollegeProgramPrerequisites');

          $collegeProgramPrerequisiteTable->updateAll(

              ['visible' => 0],

              ['college_program_course_id' => $main['id']]

          );

          $collegeProgramCorequisiteTable = TableRegistry::getTableLocator()->get('CollegeProgramCorequisites');

          $collegeProgramCorequisiteTable->updateAll(

              ['visible' => 0],

              ['college_program_course_id' => $main['id']]

          );

          // Response for a successful deletion
          $response = [

              'ok'   => true,

              'data' => $patchEntity,

              'msg'  => 'College Program Course has been successfully deleted.'

          ];

          // Logging the deletion
          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');

          $userLogEntity = $userLogTable->newEntity([

              'action'      => 'Delete',

              'description' => 'College Program View Course Management',

              'code'        => @$main['code'],

              'created'     => date('Y-m-d H:i:s'),

              'modified'    => date('Y-m-d H:i:s')

          ]);

          $userLogTable->save($userLogEntity);

      } else {

          // Response for an unsuccessful deletion
          $response = [

              'ok'   => false,

              'data' => $main,

              'msg'  => 'College Program Course cannot be deleted at this time.'

          ];

      }

      // Serialize the response and set it for the view
      $this->set([

          'response'   => $response,

          '_serialize' => 'response'

      ]);

      $this->response = $this->response->withType('application/json');
      
      $this->response = $this->response->withStringBody(json_encode($response));

      return $this->response;

  }

}
