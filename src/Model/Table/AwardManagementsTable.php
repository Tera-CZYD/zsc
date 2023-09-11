<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AwardManagementsTable extends Table{

  public function initialize(array $config): void{}

  public function getAllAwardManagement($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "SELECT

        AwardManagement.*


      FROM

        award_managements as AwardManagement  

      WHERE

        AwardManagement.visible = true AND

        (

          AwardManagement.name LIKE '%$search%'

        )
 
      ORDER BY 

        AwardManagement.name ASC
        
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

    $result = $this->getAllAwardManagement($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "SELECT

        count(*) as count

       FROM

        award_managements as AwardManagement

      WHERE

        AwardManagement.visible = true AND

        (

          AwardManagement.name LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
