<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class PropertyLogsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('InventoryProperties', [

      'foreignKey' => 'property_log_id', 

    ]);

  }

  public function getAllPropertyLogPrint($conditions){

    $search = @$conditions['search'];

    $type = @$conditions['type'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        PropertyLog.*


      FROM

        property_logs as PropertyLog  

      WHERE

        PropertyLog.visible = true $date $type AND

        (

          PropertyLog.property_name LIKE  '%$search%' 

        )
 
      ORDER BY 

        PropertyLog.property_name ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllPropertyLog($conditions, $limit, $page){

    $search = @$conditions['search'];

    $type = @$conditions['type'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        PropertyLog.*


      FROM

        property_logs as PropertyLog  

      WHERE

        PropertyLog.visible = true $date $type AND

        (

          PropertyLog.property_name LIKE  '%$search%' 

        )
 
      ORDER BY 

        PropertyLog.property_name ASC

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

    $result = $this->getAllPropertyLog($conditions, $limit, $page)->fetchAll('assoc');

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

    $type = @$conditions['type'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        property_logs as PropertyLog

      WHERE

        PropertyLog.visible = true $date $type AND

        (

          PropertyLog.property_name LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
