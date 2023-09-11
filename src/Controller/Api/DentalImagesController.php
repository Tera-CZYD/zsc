<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class DentalImagesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->Dentals = TableRegistry::getTableLocator()->get('Dentals');

    $this->DentalImages = TableRegistry::getTableLocator()->get('DentalImages');

     $this->UserLogs = TableRegistry::getTableLocator()->get('UserLogs');

     $this->autoRender = false;

  }



  public function add(){

    $this->autoRender = false;

    if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

        $requestData = $this->request->getData('data');

        $requestData = json_decode($requestData, true);

        $id = @$requestData[0]['dental_id'];

      $uploadedFiles = $this->request->getUploadedFiles();

      if (!empty($uploadedFiles)) {

        foreach ($uploadedFiles as $fieldName => $images) {

            foreach ($images as $ctr => $image) {

              $path = "uploads/dental/$id";

              if (!file_exists($path)) {

                mkdir($path, 0777, true);

              }

              $filename = $image->getClientFilename(); // Corrected line

              $image->moveTo($path . '/' . $filename);
            }

        }
      }


        if (!empty($requestData)) {

            foreach ($requestData as $key => $value) {

                $requestData[$key]['images'] = $value['images'];

            }

        }

        $entities = $this->DentalImages->newEntities($requestData);

        if ($this->DentalImages->saveMany($entities)) {

            $response = [

                'ok' => true,

                'msg' => 'Image(s) successfully saved.',

                'data' => $requestData,

            ];

            $userLogEntity = $this->UserLogs->newEntity([

            'action' => 'Add',

            'description' => 'Dental Management',

            'created' => date('Y-m-d H:i:s'),

            'modified' => date('Y-m-d H:i:s')

          ]);

          $this->UserLogs->save($userLogEntity);

        } else {

            $response = [

                'ok' => false,

                'msg' => 'Image(s) cannot be saved at this time.',

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
  }

   

}
