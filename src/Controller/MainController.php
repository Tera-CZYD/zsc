<?php

namespace App\Controller;

date_default_timezone_set("Asia/Manila");

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\View\ViewBuilder;
use Cake\View\Helper\UrlHelper;

class MainController extends AppController {
  
  public $layout = null;

  public $uses = array(

    'User',

    'UserLog',

    'Setting',

    'Member'

  );

  public function initialize(): void {

    parent::initialize();

    $this->loadComponent('Global');

    // $this->loadComponent('Auth', [

    //   'authenticate' => [

    //     'Form' => [

    //       'fields' => [

    //         'username' => 'username', // Replace with your username field

    //         'password' => 'password' // Replace with your password field

    //       ]

    //     ]

    //   ],

    //   'loginAction' => [

    //     'controller' => 'Pages',

    //     'action' => 'login'

    //   ],

    //   'logoutRedirect' => [

    //     'controller' => 'Pages',

    //     'action' => 'login'

    //   ]

    // ]);

  }

  public function beforeFilter(\Cake\Event\EventInterface $event) {

    parent::beforeFilter($event);

    $this->Auth->allow(array(

      'login',

      'logout',

      'application',

      'change_program',

      'admissionPortal',

      'application',

      'incomingFreshmenLogin',

      'continuingStudentLogin',

      'changeProgram'

    ));

  }
    
  public function index() {

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function changeProgram() {

    $this->viewBuilder()->setLayout('change-program');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function application() {

    $this->viewBuilder()->setLayout(null);

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function incomingFreshmenLogin() {

    $this->viewBuilder()->setLayout('freshmen-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }


  public function continuingStudentLogin() {

    $this->viewBuilder()->setLayout('freshmen-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function admissionPortal() {

    $this->viewBuilder()->setLayout(null);

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));



  }

  public function change_program() {

    $base = $this->serverUrl();

    $api  = $this->serverUrl() . 'api/';

    $tmp  = $this->serverUrl() . 'template/';

    $this->set(compact(

      'base',

      'api',

      'tmp'

    ));

  }

  public function login() {

    // auto-update active year

    $settingsTable = TableRegistry::getTableLocator()->get('Settings');

    $settingEntity = $settingsTable->newEntity(['id' => 13, 'value' => date('Y')]);

    $settingsTable->save($settingEntity);

    if ($this->request->is('post')) {

      $user = $this->Auth->identify(); 
     
      if ($user) {

        $this->Global->monthlyApartelleBalance();

          $this->Auth->setUser($user);

          $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
        
          $userLogEntity = $userLogTable->newEntity([

              'userId' => $this->Auth->user('id'),

              'action' => 'Log In',

              'description' => 'logged in - ' . $this->Auth->user('name'),

              'code' => ' ',

              'created' => date('Y-m-d H:i:s'),

              'modified' => date('Y-m-d H:i:s')

          ]);
          
          $userLogTable->save($userLogEntity);

          $this->viewBuilder()->setLayout('default');

          $redirect = $this->request->getQuery('redirect', [

            'controller' => 'Main',

            'action' => 'index',

          ]);

          return $this->redirect($redirect);

      } else {

        $this->Flash->error(__('Invalid username or password.'));

      }

    }

  }
  

  public function logout(){

    // $this->Authorization->skipAuthorization();

    // $result = $this->Authentication->getResult();

    // // regardless of POST or GET, redirect if user is logged in
    // if ($result && $result->isValid()) {

      $this->Auth->logout();

      return $this->redirect(['controller' => 'Main', 'action' => 'login']);

    // }
    
  }

}