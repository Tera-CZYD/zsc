<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class ApartellesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('ApartelleImages', [
        'foreignKey' => 'apartelle_id',
    ]);

  }

  public function getAllApartelle($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $date = @$conditions['date'];

    $sql = "

      SELECT

        Apartelle.*

      FROM

        apartelles as Apartelle 

      WHERE

        Apartelle.visible = true $date AND

        (
 
          Apartelle.code LIKE  '%$search%' OR

          Apartelle.building_no LIKE  '%$search%' OR

          Apartelle.room_no LIKE  '%$search%' OR

          Apartelle.description LIKE  '%$search%' OR

          Apartelle.capacity LIKE  '%$search%' 

        )

      ORDER BY 

        Apartelle.code DESC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllApartellePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        Apartelle.*

      FROM

        apartelles as Apartelle 

      WHERE

        Apartelle.visible = true $date AND

        (
 
          Apartelle.code LIKE  '%$search%' OR

          Apartelle.building_no LIKE  '%$search%' OR

          Apartelle.room_no LIKE  '%$search%' OR

          Apartelle.description LIKE  '%$search%' OR

          Apartelle.capacity LIKE  '%$search%' 

        )

      ORDER BY 

        Apartelle.code DESC
        
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

    $result = $this->getAllApartelle($conditions, $limit, $page)->fetchAll('assoc');

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

    $date = @$conditions['date'];

    $sql = "

      SELECT

        count(*) as total

      FROM

        apartelles as Apartelle 

      WHERE

        Apartelle.visible = true $date AND

        (
 
          Apartelle.code LIKE  '%$search%' OR

          Apartelle.building_no LIKE  '%$search%' OR

          Apartelle.room_no LIKE  '%$search%' OR

          Apartelle.description LIKE  '%$search%' OR

          Apartelle.capacity LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['total'];

  }

}
