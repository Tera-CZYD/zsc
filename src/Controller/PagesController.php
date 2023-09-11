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

  /**
   * Static content controller
   *
   * This controller will render views from templates/Pages/
   *
   * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
   */
  class PagesController extends AppController{

    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */

    public function display(string ...$path): ?Response{

      if(!$path) {

        return $this->redirect('/');

      }

      if (in_array('..', $path, true) || in_array('.', $path, true)) {

        throw new ForbiddenException();

      }

      $page = $subpage = null;

      if(!empty($path[0])) {

        $page = $path[0];

      }
      if(!empty($path[1])) {

        $subpage = $path[1];

      }

      $this->set(compact('page', 'subpage'));

      try {

        return $this->render(implode('/', $path));

      } catch (MissingTemplateException $exception) {

        if (Configure::read('debug')) {

          throw $exception;
        }

        throw new NotFoundException();
      }

    }

    // public function initialize(): void {

    //   parent::initialize();

    //   $this->loadComponent('Auth', [

    //     'authenticate' => [

    //       'Form' => [

    //         'fields' => [

    //           'username' => 'username', // Replace with your username field

    //           'password' => 'password' // Replace with your password field

    //         ]

    //       ]

    //     ],

    //     'loginAction' => [

    //       'controller' => 'Pages',

    //       'action' => 'login'

    //     ],

    //     'logoutRedirect' => [

    //       'controller' => 'Pages',

    //       'action' => 'login'

    //     ]

    //   ]);

    // }

    // public function beforeFilter(\Cake\Event\EventInterface $event) {

    //   parent::beforeFilter($event);

    //   $this->Auth->allow(array(

    //     'login',

    //     'logout',

    //     'application',

    //     'change_program'

    //   ));

    // }

    // public function index() {

    //   $viewBuilder = new ViewBuilder();

    //   $view = $viewBuilder->build();

    //   $urlHelper = new UrlHelper($view);

    //   $base = $urlHelper->build('/', ['fullBase' => true]);

    //   $api = $base . 'api/';

    //   $tmp = $base . 'template/';

    //   $this->set(compact('base', 'api', 'tmp'));

    // }

    // public function change_program() {

    //   $base = $this->serverUrl();

    //   $api  = $this->serverUrl() . 'api/';

    //   $tmp  = $this->serverUrl() . 'template/';

    //   $this->set(compact(

    //     'base',

    //     'api',

    //     'tmp'

    //   ));

    // }

    // public function login() {

    //   // auto-update active year

    //   $settingsTable = TableRegistry::getTableLocator()->get('Settings');

    //   $settingEntity = $settingsTable->newEntity(['id' => 13, 'value' => date('Y')]);

    //   $settingsTable->save($settingEntity);

    //   if ($this->request->is('post')) {

    //     $user = $this->Auth->identify(); 
       
    //     if ($user) {

    //         $this->Auth->setUser($user);

    //         $userLogTable = TableRegistry::getTableLocator()->get('UserLogs');
          
    //         $userLogEntity = $userLogTable->newEntity([

    //             'userId' => $this->Auth->user('id'),

    //             'action' => 'Log In',

    //             'description' => 'logged in - ' . $this->Auth->user('name'),

    //             'code' => ' ',

    //             'created' => date('Y-m-d H:i:s'),

    //             'modified' => date('Y-m-d H:i:s')

    //         ]);
            
    //         $userLogTable->save($userLogEntity);

    //         $this->viewBuilder()->setLayout('default');

    //         $redirect = $this->request->getQuery('redirect', [

    //           'controller' => 'Pages',

    //           'action' => 'index',

    //         ]);

    //         return $this->redirect($redirect);

    //     } else {

    //       $this->Flash->error(__('Invalid username or password.'));

    //     }

    //   } else {

    //     if ($this->Auth->isLoggedIn()) {

    //       return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
            
    //     }

    //   }

    // }

    // public function logout() {
        
    //   $this->UserLog->save(array(

    //     'userId'    =>  session('id'),

    //     'action'    =>  'Log Out',

    //     'description'=> 'logged out - '. session('name'),

    //     'code'       => ' ',
        
    //   )); 

    //   $this->Session->destroy();

    //   $this->Session->delete('Auth');

    //   return $this->redirect($this->Auth->logout());

    // }

  }
