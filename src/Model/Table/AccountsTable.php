<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AccountsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllAccounts($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Account.*


      FROM

        accounts as Account  

      WHERE

        Account.visible = true AND

        (

          Account.name LIKE '%$search%' OR

          Account.code LIKE '%$search%' OR

          Account.acronym LIKE '%$search%' OR

          Account.amount LIKE '%$search%' OR

          Account.unit LIKE '%$search%' 

        )
 
      ORDER BY 

        Account.code ASC
        
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

    $result = $this->getAllAccounts($conditions, $limit, $page)->fetchAll('assoc');

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

        accounts as Account  

      WHERE

        Account.visible = true AND

        (

          Account.name LIKE '%$search%' OR

          Account.code LIKE '%$search%' OR

          Account.acronym LIKE '%$search%' OR

          Account.amount LIKE '%$search%' OR

          Account.unit LIKE '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
