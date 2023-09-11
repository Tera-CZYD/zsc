<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Controller;
use Cake\View\JsonView;


class MedicalStudentProfileImagesController extends AppController {
   
  public function initialize(): void{

    parent::initialize();
    
    $this->loadComponent('RequestHandler');

    $this->MedicalStudentProfileImages = TableRegistry::getTableLocator()->get('MedicalStudentProfileImages');

  }



  public function index() {

      if ($this->request->is(['post', 'ajax']) && $this->request->is('json')) {

          $requestData = $this->request->getData('data');

          $requestData = json_decode($requestData, true);

          $id = @$requestData[0]['student_profile_id'];

          $uploadedFiles = $this->request->getUploadedFiles();

          if (!empty($uploadedFiles)) {

              foreach ($uploadedFiles as $fieldName => $images) {

                  foreach ($images as $ctr => $image) {

                      $path = "uploads/medical-student-profile/$id";


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

          $entities = $this->MedicalStudentProfileImages->newEntities($requestData);

          if ($this->MedicalStudentProfileImages->saveMany($entities)) {

              $response = [

                  'ok' => true,

                  'msg' => 'Image(s) successfully saved.',

                  'data' => $requestData,

              ];

          } else {

              $response = [

                  'ok' => false,

                  'msg' => 'Image(s) cannot be saved at this time.',

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
  }

}
