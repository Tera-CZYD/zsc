<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class BuildingsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllBuilding($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Building.*

      FROM

        buildings as Building

      WHERE

        Building.visible = true $college_id AND 

        (

          Building.code         LIKE  '%$search%' OR

          Building.name         LIKE  '%$search%' OR

          Building.location         LIKE  '%$search%' OR

          Building.short_name   LIKE  '%$search%' OR

          Building.description  LIKE  '%$search%'  

        )

      GROUP BY

        Building.id

      ORDER BY 

        Building.code ASC

      LIMIT

        $limit OFFSET $offset

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

    $result = $this->getAllBuilding($conditions, $limit, $page)->fetchAll('assoc');

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

    $college_id = @$conditions['college_id'];

    $sql = "

      SELECT

        count(*) as count

       FROM

        buildings as Building 

      WHERE

        Building.visible = true $college_id AND 

        (

          Building.code         LIKE  '%$search%' OR

          Building.name         LIKE  '%$search%' OR

          Building.location         LIKE  '%$search%' OR

          Building.short_name   LIKE  '%$search%' OR

          Building.description  LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
