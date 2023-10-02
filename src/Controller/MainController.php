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
    
  }

  public function beforeFilter(\Cake\Event\EventInterface $event) {

    parent::beforeFilter($event);

    $action = $this->getRequest()->getParam('action');

    if (!method_exists($this, $action)) {

      return $this->redirect(['controller' => 'Error', 'action' => 'missingAction']); 

    }

    $this->Auth->allow(array(

      'login',

      'logout',

      'application',

      'change_program',

      'admissionPortal',

      'application',

      'incomingFreshmenLogin',

      'continuingStudentLogin',

      'changeProgram',

      'facultyLogin',

      'guidanceCounselingLogin',

      'healthMedicalServicesLogin',

      'learningResourceCenterLogin',

      'deanLogin',

      'vicePresidentLogin',

      'cashierLogin',

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

  public function facultyLogin() {

    $this->viewBuilder()->setLayout('faculty-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function guidanceCounselingLogin() {

    $this->viewBuilder()->setLayout('guidance-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function healthMedicalServicesLogin() {

    $this->viewBuilder()->setLayout('health-medical-services-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function learningResourceCenterLogin() {

    $this->viewBuilder()->setLayout('learning-resource-center-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function deanLogin() {

    $this->viewBuilder()->setLayout('dean-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function cashierLogin() {

    $this->viewBuilder()->setLayout('cashier-layout');

    $viewBuilder = new ViewBuilder();

    $view = $viewBuilder->build();

    $urlHelper = new UrlHelper($view);

    $base = $urlHelper->build('/', ['fullBase' => true]);

    $api = $base . 'api/';

    $tmp = $base . 'template/';

    $this->set(compact('base', 'api', 'tmp'));

  }

  public function vicePresidentLogin() {

    $this->viewBuilder()->setLayout('vice-president-layout');

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

          'description' => 'logged in - ' . $this->Auth->user('first_name').' '.$this->Auth->user('last_name'),

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