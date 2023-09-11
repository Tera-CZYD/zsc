<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class OfficeReferencesTable extends Table{

  public function initialize(array $config): void{}

  public function getAllOfficeReference($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        OfficeReference.*


      FROM

        office_references as OfficeReference  

      WHERE

        OfficeReference.visible = true AND

        (

          OfficeReference.module LIKE '%$search%' OR

          OfficeReference.sub_module LIKE '%$search%' OR

          OfficeReference.reference_code LIKE '%$search%' 

        )
 
      ORDER BY 

        OfficeReference.id ASC
        
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

    $result = $this->getAllOfficeReference($conditions, $limit, $page)->fetchAll('assoc');

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

  public function paginateCount($conditions = null){ 

    $search = @$conditions['search'];

    $sql = "

      SELECT

        count(*) as total

      FROM

        office_references as OfficeReference  

      WHERE

        OfficeReference.visible = true AND

        (

          OfficeReference.module LIKE '%$search%' OR

          OfficeReference.sub_module LIKE '%$search%' OR

          OfficeReference.reference_code LIKE '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['total'];

  }

}
