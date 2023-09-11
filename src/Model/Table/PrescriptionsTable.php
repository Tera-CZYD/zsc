<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class PrescriptionsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllPrescription($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Prescription.*


      FROM

        prescriptions as Prescription  

      WHERE

       Prescription.visible = true $date AND

        (

            Prescription.name LIKE '%$search%' 

            -- Prescription.date LIKE '%$search%'

        )
 
      ORDER BY 

      Prescription.name ASC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function paginate($query, array $options = []){

    $extra = isset($options['extra']) ? $options['extra'] : [];

    $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

    $page = $options['page'];

    $limit = $options['limit'];

    $result = $this->getAllPrescription($conditions, $limit, $page)->fetchAll('assoc');

    $paginator = [

      'page' => $page,

      'limit' => $limit,

      'count' => $this->paginateCount($conditions),

      'perPage' => $limit,

      'pageCount' => ceil($this->paginateCount($conditions) / $limit),

    ];

    return [

      'data' => $result,

      'pagination' => $paginator,

    ];

  }

  public function getAllPrescriptionPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        Prescription.*


      FROM

        prescriptions as Prescription  

      WHERE

       Prescription.visible = true $date AND

        (

            Prescription.name LIKE '%$search%' 

            -- Prescription.date LIKE '%$search%'

        )
 
      ORDER BY 

      Prescription.name ASC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function paginateCount($conditions = null){ 

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        count(*) as total

       FROM

        prescriptions as Prescription

      WHERE

        Prescription.visible = true $date AND

        (

         Prescription.name LIKE  '%$search%' 

          -- Prescription.date LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['total'];

  }

}
