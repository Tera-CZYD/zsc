<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;

class ApplicationController extends AppController {

  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->loadComponent('Global');

    $this->StudentApplications = TableRegistry::getTableLocator()->get('StudentApplications');

    $this->StudentApplicationImages = TableRegistry::getTableLocator()->get('StudentApplicationImages');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

  }

  public function beforeFilter(\Cake\Event\EventInterface $event) {

    parent::beforeFilter($event);

    $this->Auth->allow(array(

      'add',

    ));

  }

  public function index(){}

  public function add() { 

    $this->autoRender = false;

    if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

      $requestData = $this->request->getData('data');

      $main = json_decode($requestData, true);

      $main['StudentApplication']['application_date'] = date('Y-m-d');

      $main['StudentApplication']['year_term_id'] = 1;

      $main['StudentApplication']['birth_date'] = isset($main['StudentApplication']['birth_date']) ? fdate($main['StudentApplication']['birth_date'],'Y-m-d') : null;

      $uploadedFiles = $this->request->getUploadedFiles();

      // debug($uploadedFiles['attachment']);

      $save = $this->StudentApplications->validSave($main['StudentApplication']);

      if ($save['ok']) {

        $id = $save['data']['id'];

        foreach ($uploadedFiles as $fieldName => $images) {

          $path = "uploads/student-application/$id";

          if (!file_exists($path)) {

            mkdir($path, 0777, true);

          }

          foreach ($images as $ctr => $image) {

            $filename = $image->getClientFilename();

            $image->moveTo($path . '/' . $filename);

            $names[$ctr] = $filename;

          }

        }

        $newPRImage = @$_FILES['attachment']['name'];

        $datasImages = [];

        if (!empty($newPRImage)) {

          if (isset($main['StudentApplicationImage'])) {

            foreach ($main['StudentApplicationImage'][count($main['StudentApplicationImage']) - 1]['images'] as $key => $valueImages) {

              $valueImages['images'] = $names[$key];

              $valueImages['application_id'] = $id;

              $datasImages[] = $valueImages;

            }

            $entities = $this->StudentApplicationImages->newEntities($datasImages);

            $this->StudentApplicationImages->saveMany($entities);

          }

        }

        $response = $save;

        $userLogEntity = $this->UserLogs->newEntity([

          'action' => 'Add',

          'description' => 'Student Applciation Management',

          'created' => date('Y-m-d H:i:s'),

          'modified' => date('Y-m-d H:i:s')

        ]);

        $this->UserLogs->save($userLogEntity);

      }else{

        $response = $save;

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

}