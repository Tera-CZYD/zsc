<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\Collection\Collection;

class BackupsController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Backups = TableRegistry::getTableLocator()->get('Backups');

    $this->BackupFiles = TableRegistry::getTableLocator()->get('BackupFiles');

    $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

  }

  public function index(){   

    $page = $this->request->getQuery('page', 1);

    $trigerred = 0;

    $conditions = [];

    $conditions['date'] = '';

    if ($this->request->getQuery('date')) {

      $date = $this->request->getQuery('date');

      $conditions['date'] = " WHERE DATE(Backup.created) = '$date' ";

      $trigerred = 1;

    } 

    $limit = 25;

    $tmpData = $this->BackupFiles->paginate($this->BackupFiles->getAllFile($conditions,$page,$limit), [

      'extra' => [

        'conditions' => $conditions

      ],

      'page' => $page,

      'limit' => $limit

    ]);

    $files = $tmpData['data'];

    $paginator = $tmpData['pagination'];

    $datas = [];

    foreach ($files as $data) {

      $datas[] = array(

          'src'       => $this->base . 'uploads/sql_dump/'.$data['filename'],

         'id'             => $data['id'],

         'filename'    => $data['filename'],

         'full_name'  => $data['username'],    

      );

    }

    $response = [

      'ok' => true,

      'datas' => $datas,

      'paginator' => $paginator,

      'baseUrl' => $this->base,

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

 public function export() {

    $d = $this->Backups->exportDatabase();

    if ($d['database']) {
        // Save backup information to the database
        $backupFileEntity = $this->BackupFiles->newEntity([
            'filename' => $d['fname'],
            'user_id' =>  $this->Auth->user('id')
        ]);

        $saveResult = $this->BackupFiles->save($backupFileEntity);

        // Set appropriate headers for file download
        $data = $this->response->withType('application/download')
            ->withHeader('Content-Disposition', 'attachment; filename=' . $d['fname'])
            ->withHeader('Content-Length', filesize($d['file']));

        // Output file content directly to the response
        // $fp = fopen($d['file'], "r");
        // fpassthru($fp);
        // fclose($fp);

        // Create and save user log entity
        $userLogEntity = $this->UserLogs->newEntity([
            'action' => 'Backup',
            'description' => 'Download - ' . $d['fname'],
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ]);

        $this->UserLogs->save($userLogEntity);

      }

      $response = [

      'ok' => true,

      'data' => $data

    ];

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }

  public function delete($id = null) {

   $data = $this->BackupFiles->get($id);

    if ($this->BackupFiles->delete($data)) {
        unlink('uploads/sql_dump/'.$data->filename); // Assuming 'filename' is a field in your entity

        $userLogEntity = $this->UserLogs->newEntity([
            'action' => 'Backup',
            'description' => 'Delete',
            'code' => '',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ]);

        $this->UserLogs->save($userLogEntity);

        $response = [
            'ok'   => true,
            'msg'  => 'Backup has been deleted'
        ];
    } else {
        $response = [
            'ok'  => false,
            'msg' => 'Backup cannot be deleted this time.'
        ];
    }

    $this->set([
        'response'   => $response,
        '_serialize' => 'response',
    ]);

    $this->response->withType('application/json');

    $this->response->getBody()->write(json_encode($response));

    return $this->response;

  }


}
