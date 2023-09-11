<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class PurposesTable extends Table{

  public function initialize(array $config): void{

    $this->setTable('purposes');
    $this->setDisplayField('code');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');

  }

  public function getAllPurposePrint($conditions){

    $search = @$conditions['search'];

    $sql = "

    	SELECT

        Purpose.*

      FROM

        purposes as Purpose 

      WHERE

      Purpose.visible = true AND

        (
 
          Purpose.code LIKE  '%$search%' OR

          Purpose.purpose LIKE  '%$search%'

        )

      ORDER BY 

      	Purpose.code DESC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllPurpose($conditions, $limit, $page){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        Purpose.*

      FROM

        purposes as Purpose 

      WHERE

      Purpose.visible = true AND

        (
 
          Purpose.code LIKE  '%$search%' OR

          Purpose.purpose LIKE  '%$search%'

        )

      ORDER BY 

        Purpose.code DESC
        
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

    $result = $this->getAllPurpose($conditions, $limit, $page)->fetchAll('assoc');

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

    $date = @$conditions['date'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        purposes as Purpose 

      WHERE

      Purpose.visible = true $date AND

        (
 
          Purpose.code LIKE  '%$search%' OR

          Purpose.purpose LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
