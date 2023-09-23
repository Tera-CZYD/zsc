<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class PtcsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Ptcs = TableRegistry::getTableLocator()->get('Ptcs');

    $this->PtcSubs = TableRegistry::getTableLocator()->get('PtcSubs');

    $this->Courses = TableRegistry::getTableLocator()->get('Courses');

    $this->BlockSections = TableRegistry::getTableLocator()->get('BlockSections');

    $this->BlockSectionCourses = TableRegistry::getTableLocator()->get('BlockSectionCourses');

    $this->BlockSectionSchedules = TableRegistry::getTableLocator()->get('BlockSectionSchedules');

    $this->PtcSubs = TableRegistry::getTableLocator()->get('PtcSubs');

    $this->StudentEnrolledCourses = TableRegistry::getTableLocator()->get('StudentEnrolledCourses');

    $this->StudentEnrolledSchedules = TableRegistry::getTableLocator()->get('StudentEnrolledSchedules');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $conditions = [];

    $conditionsPrint = '';

    if($this->request->getQuery('search')){

      $search = $this->request->getQuery('search');

      $search = strtolower($search);

      $conditions['search'] = $search;

      $conditionsPrint .= '&search='.$search;

    }

    $limit = 25;

    $tmpData = $this->Ptcs->paginate($this->Ptcs->getAllPtc($conditions, $limit, $page), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $ptcs = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($ptcs as $ptc) {

      $datas[] = array(

        'id'       => $ptc['id'],

        'code'     => $ptc['code'],

        'section'  => $ptc['section'],

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

  public function add($id = null) {

    $this->autoRender = false;

    $main = $this->request->getData('Ptc');

    $sub = $this->request->getData('PtcSub');

    $data = $this->Ptcs->newEmptyEntity();
   
    $data = $this->Ptcs->patchEntity($data, $main); 

    if($this->Ptcs->save($data)) {

      $id = $data->id;

      $block_section = $this->BlockSections->find()

        ->where([

          'visible' => 1,

          'id' => $main['block_section_id'],

        ])

      ->first();

      if(!empty($sub)){

        foreach ($sub as $key => $value) {

          $sub[$key]['ptc_id'] = $id;

          //ENROLL SUBJECTS TO STUDENTS

            $student_enrolled_course = array();

            $student_enrolled_schedule = array();

            $block_section_course = $this->BlockSectionCourses->find()

              ->where([

                'visible' => 1,

                'block_section_id' => $main['block_section_id'],

                'ptc' => 1

              ])

            ->all();

            if(!empty($block_section_course)){

              foreach ($block_section_course as $keys => $values) {

                $course = $this->Courses->find()

                  ->where([

                    'visible' => 1,

                    'id' => $values['course_id']

                  ])

                ->first();
                
                $student_enrolled_course[] = array(

                  'student_id' => $value['student_id'],

                  'course_id' => $values['course_id'],

                  'course_code' => $course['code'],

                  'course' => $values['course'],

                  'year_term_id' => $block_section['year_term_id'],

                  'section_id' => $block_section['section_id'],

                  'section' => $block_section['section'],

                  'credit_unit' => $block_section['credit_unit'],

                  'laboratory_unit' => $block_section['laboratory_unit'],

                  'laboratory_hours' => $block_section['laboratory_hours'],

                  'lecture_unit' => $block_section['lecture_unit'],

                  'lecture_hours' => $block_section['lecture_hours'],

                );

                $block_section_course = $this->BlockSectionSchedules->find()

                  ->where([

                    'visible' => 1,

                    'block_section_id' => $main['block_section_id'],

                    'block_section_course_id' => $values['id']

                  ])

                ->all();

                if(!empty($block_section_course)){

                  foreach ($block_section_course as $index => $datas) {
                    
                    $student_enrolled_schedule[] = array(

                      'student_id' => $value['student_id'],

                      'course_id' => $values['course_id'],

                      'course' => $values['course'],

                      'block_section_schedule_id' => $datas['id'],

                      'year_term_id' => $block_section['year_term_id'],

                      'day' => $datas['day'],

                      'time_start' => $datas['time_start'],

                      'time_end' => $datas['time_end'],

                      'section_id' => $block_section['section_id'],

                      'section' => $block_section['section'],

                    );

                  }

                }

                //SAVE SCHEDULES

                  $tmpEntity = $this->StudentEnrolledSchedules->newEntities($student_enrolled_schedule);

                  $this->StudentEnrolledSchedules->saveMany($tmpEntity);

                //END 

              }

            }

            //SAVE COURSES

              $tmpEntity = $this->StudentEnrolledCourses->newEntities($student_enrolled_course);

              $this->StudentEnrolledCourses->saveMany($tmpEntity);

            //END   

          //END 

        }

        $subEntity = $this->PtcSubs->newEntities($sub);

        $this->PtcSubs->saveMany($subEntity);

      }

      $response = array(

        'ok'  =>true,

        'msg' =>'PTC has been successfully saved.',

        'data'=>$main

      );

      $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
          
      $userLogEntity = $userLogTable->newEntity([

        'action' => 'PTC',

        'userId' => $this->Auth->user('id'),

        'description' => 'Program Adviser',

        'code' => $main['code'],

        'created' => date('Y-m-d H:i:s'),

        'modified' => date('Y-m-d H:i:s')

      ]);
      
      $userLogTable->save($userLogEntity); 
      
    } else {

      $response = array(

        'ok'  =>true,

        'data'=>$main,

        'msg' =>'PTC cannot saved this time.',

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

    $data['Ptc'] = $this->Ptcs->find()

      ->contain([

        'PtcSubs' => [

          'conditions' => ['PtcSubs.visible' => 1]

        ]

      ])

      ->where([

        'Ptcs.visible' => 1,

        'Ptcs.id' => $id

      ])

    ->first();

    $data['PtcSub'] = $data['Ptc']['ptc_subs'];

    unset($data['Ptc']['ptc_subs']);

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

}
