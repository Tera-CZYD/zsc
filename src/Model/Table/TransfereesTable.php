<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class TransfereesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('TransfereeImages', [

      'foreignKey' => 'transferee_id', 

    ]);

  }

  public function getAllTransfereePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        Transferee.*,

        IFNULL(CONCAT(Transferee.last_name,', ',Transferee.first_name,' ',IFNULL(Transferee.middle_name,' ')),' ') AS full_name

      FROM

        transferees as Transferee 

      WHERE

        Transferee.visible = true $date $studentId AND

        (
 
          Transferee.first_name           LIKE  '%$search%' OR

          Transferee.middle_name          LIKE  '%$search%' OR

          Transferee.last_name            LIKE  '%$search%' OR

          Transferee.year_level           LIKE  '%$search%' OR

          Transferee.email                LIKE  '%$search%' OR

          Transferee.date                 LIKE  '%$search%'

        )

      ORDER BY 

        full_name ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllTransferee($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Transferee.*,

        IFNULL(CONCAT(Transferee.last_name,', ',Transferee.first_name,' ',IFNULL(Transferee.middle_name,' ')),' ') AS full_name

      FROM

        transferees as Transferee 

      WHERE

        Transferee.visible = true $date $studentId AND

        (
 
          Transferee.first_name           LIKE  '%$search%' OR

          Transferee.middle_name          LIKE  '%$search%' OR

          Transferee.last_name            LIKE  '%$search%' OR

          Transferee.year_level           LIKE  '%$search%' OR

          Transferee.email                LIKE  '%$search%' OR

          Transferee.date                 LIKE  '%$search%'

        )

      ORDER BY 

        full_name ASC

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

    $result = $this->getAllTransferee($conditions, $limit, $page)->fetchAll('assoc');

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

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        count(*) as count

       FROM

        transferees as Transferee 

      WHERE

        Transferee.visible = true $date $studentId AND

        (
 
          Transferee.first_name           LIKE  '%$search%' OR

          Transferee.middle_name          LIKE  '%$search%' OR

          Transferee.last_name            LIKE  '%$search%' OR

          Transferee.year_level           LIKE  '%$search%' OR

          Transferee.email                LIKE  '%$search%' OR

          Transferee.date                 LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
