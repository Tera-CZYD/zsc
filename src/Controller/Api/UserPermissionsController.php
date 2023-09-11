<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
class UserPermissionsController extends AppController
{
  public function initialize():void
  {
    parent::initialize();

    $this->loadComponent('RequestHandler');

    $this->autoRender = false;

    $this->viewBuilder()->setLayout(null);

    $this->UserPermissions = TableRegistry::getTableLocator()->get('UserPermissions');
  }

  public function beforeFilter(\Cake\Event\EventInterface $event)
  {
    parent::beforeFilter($event);
    $this->Auth->deny(['index']);
    $this->autoRender = false;
  }

  public function add()
  {
    $this->request->allowMethod(['post', 'ajax']);
    $this->autoRender = false;

    $requestData = $this->request->getData('UserPermission');
    // var_dump($requestData);
    $userPermissionEntities = $this->UserPermissions->newEntities($this->request->getData('UserPermission'));


    if ($this->UserPermissions->saveMany($userPermissionEntities)) {
        $response = [
            'ok' => true,
            'msg' => 'Permission has been added',
        ];
    } else {
        $response = [
            'ok' => false,
            'data' => $data['UserPermission'],
            'msg' => 'Permission cannot be added at this time.',
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

  public function delete($id = null)
  {
    $entity = $this->UserPermissions->get($id);

    // Attempt to delete the entity
    if ($this->UserPermissions->delete($entity)) {
        $response = [
            'ok' => true,
            'data' => $id,
            'msg' => 'Permission has been removed.',
        ];
    } else {
        $response = [
            'ok' => false,
            'data' => $id,
            'msg' => 'Permission cannot be removed at this time.',
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

  public function deleteSelected()
  {
    foreach ($this->request->getData('permissiondelete') as $share) {
      
      $entity = $this->UserPermissions->get($share['permission_id']);
      
      $this->UserPermissions->delete($entity);
      
    }

    $response = [
      
      'ok' => true,
      
      'data' => $this->request->getData('permissiondelete'),
      
      'msg' => 'Permission has been removed.',
      
    ];

    $this->set([
      
      'response' => $response,
      
      '_serialize' => 'response',
      
    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;
  }
}