<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class CheckInsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('CheckInSubs', [

      'foreignKey' => 'check_in_id', 

    ]);

  }

  public function getAllCheckInPrint($conditions){

    $search = strtolower(@$conditions['search']);

    $date = @$conditions['date'];

    $borrower_id = @$conditions['borrower_id'];

    $sql = "

      SELECT 

        CheckIn.*

      FROM 

        check_ins as CheckIn 

      WHERE 

        CheckIn.visible = true $date AND

        (

          CheckIn.library_id_number LIKE '%$search%' OR 

          CheckIn.member_name LIKE '%$search%' OR 

          CheckIn.email LIKE '%$search%'      

        )

      ORDER BY 

        CheckIn.id DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCheckIn($conditions, $limit, $page){

    $search = strtolower(@$conditions['search']);

    $date = @$conditions['date'];

    $borrower_id = @$conditions['borrower_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

        CheckIn.*

      FROM 

        check_ins as CheckIn 

      WHERE 

        CheckIn.visible = true $date AND

        (

          CheckIn.library_id_number LIKE '%$search%' OR 

          CheckIn.member_name LIKE '%$search%' OR 

          CheckIn.email LIKE '%$search%'      

        )

      ORDER BY 

        CheckIn.id DESC

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

    $result = $this->getAllCheckIn($conditions, $limit, $page)->fetchAll('assoc');

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

    $search = strtolower(@$conditions['search']);

    $date = @$conditions['date'];

    $borrower_id = @$conditions['borrower_id'];

    $sql = "

      SELECT 

        count(*) as count

      FROM 

        check_ins as CheckIn 

      WHERE 

        CheckIn.visible = true $date AND

        (

          CheckIn.library_id_number LIKE '%$search%' OR 

          CheckIn.member_name LIKE '%$search%' OR 

          CheckIn.email LIKE '%$search%'      

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
