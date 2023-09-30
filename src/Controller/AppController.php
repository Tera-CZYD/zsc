<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\View\ViewBuilder;
use Cake\View\Helper\UrlHelper;

//for cakephp query
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');

        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [

          'authenticate' => [

            'Form' => [

              'fields' => [

                'username' => 'username', // Replace with your username field

                'password' => 'password' // Replace with your password field

              ],

              'finder' => 'auth',

            ]

          ],

          'loginAction' => [

            'controller' => 'Main',

            'action' => 'login'

          ],

          'logoutRedirect' => [

            'controller' => 'Main',

            'action' => 'login'

          ]

        ]);

        
        $this->Users = TableRegistry::getTableLocator()->get('Users');

         $this->Students = TableRegistry::getTableLocator()->get('Students');

         $this->StudentEnrollments = TableRegistry::getTableLocator()->get('StudentEnrollments');

        $this->StudentEnrolledCourses = TableRegistry::getTableLocator()->get('StudentEnrolledCourses');

        $this->StudentApplications = TableRegistry::getTableLocator()->get('StudentApplications');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event) {

      parent::beforeFilter($event);

      //Uncomment to show error, if not redirect to error landing page

      // if($this->name == 'CakeError'){

      //   $this->layout = 'error';

      // }

      // $this->viewBuilder()->setHelpers(['Access']);

      $this->viewBuilder()->setLayout('login');

      $viewBuilder = new ViewBuilder();

      $view = $viewBuilder->build();

      $urlHelper = new UrlHelper($view);

      $base = $urlHelper->build('/', ['fullBase' => true]);

      $currentUser = array();


      $for_medical_interview = 0;

      $for_schedule = 0;

      $show_self_enrollment = 0;

      $enrolment_count = 0;

      $grades = array();

      $user = $this->Auth->user();

      if(!empty($user)){

        $this->viewBuilder()->setLayout('default');

        $currentUser = $this->Users->find()

            ->contain([

                'UserPermissions' => [

                    'conditions' => ['UserPermissions.visible' => 1],

                    'Permissions'

                ],

                'Employees' => [

                    'conditions' => ['Employees.visible' => 1],

                    'AcademicRanks'

                ],

                'Roles',

                'Students' => [

                    'conditions' => ['Students.visible' => 1]

                ]

            ])

            ->where(['Users.id' => $user['id']])

            ->firstOrFail();

            

        if(!empty($currentUser)){

          // var_dump($currentUser->toArray()['user_permissions']);

          if(!empty($currentUser['user_permissions'])){

            foreach ($currentUser['user_permissions'] as $k => $permission) {

              // var_dump($permission);

              $currentUser['user_permissions'][$k] = $permission['permission']['module'] .  '/' . $permission['permission']['action'];

            }

          }

        }

        if($currentUser['role']['code'] == 'Student'){

          $id='';

          $term =0;

          $id = $user['id'];

          $term = $currentUser['student']['year_term_id'];

          $student_id = $currentUser['studentId'];

          $tmp = "

            SELECT

              StudentEnrolledCourse.*

            FROM

              student_enrolled_courses as StudentEnrolledCourse

            WHERE

              StudentEnrolledCourse.visible = true AND

              StudentEnrolledCourse.year_term_id = $term AND

              StudentEnrolledCourse.student_id = $student_id

          ";

          $connection = $this->StudentEnrolledCourses->getConnection();

          $grades = $connection->execute($tmp)->fetchAll('assoc');


          $tmp = "

            SELECT 

              StudentApplication.*

            FROM  

              students as Student LEFT JOIN 

              student_applications as StudentApplication ON StudentApplication.id = Student.student_applicant_id 

            WHERE 

              Student.id = $student_id

          ";

          $connection = $this->StudentApplications->getConnection();

          $student_details = $connection->execute($tmp)->fetchAll('assoc');

          $for_medical_interview = $student_details[0]['approve'] == 1 ? 1 : 0;

          $for_schedule = $student_details[0]['status'] == 'REQUESTED' ? 1 : 0;

          //FOR CHECKING IF STUDENT IS REGULAR OR IRREGULAR

            $student_data = $this->Students->get($student_id);

            if($student_data['status'] == 'IRREGULAR' || $student_data['status'] == 'INCOMPLETE' || $student_data['status'] == 'FAILED'){

              $show_self_enrollment = 1;

            }


          //CHECKING IF STUDENT IS ALREADY ENROLLED

            $student_data = $this->Students->get($user['studentId']);

            $year_term_id = $student_data['year_term_id'];

            $enrolment_count = $this->StudentEnrollments->find()

              ->where([

                'visible' => 1,

                'student_id' => $user['studentId'],

                'year_term_id' => $year_term_id

              ])

            ->count();

        }

      }

      
      $this->currentUser = $currentUser;

      $this->base = $base;

      // print_r($currentUser);

      $this->set(compact('base','currentUser','grades','for_medical_interview','for_schedule','show_self_enrollment','enrolment_count'));



    }

}
