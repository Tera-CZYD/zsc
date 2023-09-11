<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class ClubsTable extends Table{

  public function initialize(array $config): void{

    $this->setTable('clubs');
    $this->setDisplayField('code');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');

  }

  public function getAllClubPrint($conditions){

    $search = @$conditions['search'];

    $sql = "

    	SELECT

          Club.*

      FROM

        clubs as Club 

      WHERE

      Club.visible = true AND

        (
 
          Club.code LIKE  '%$search%' OR

          Club.title LIKE  '%$search%'

        )

      ORDER BY 

      	Club.code DESC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllClub($conditions, $limit, $page){

    $search = @$conditions['search'];

    $sql = "

    	SELECT

          Club.*

      FROM

        clubs as Club 

      WHERE

      Club.visible = true AND

        (
 
          Club.code LIKE  '%$search%' OR

          Club.title LIKE  '%$search%'

        )

      ORDER BY 

      	Club.code DESC
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

    $result = $this->getAllClub($conditions, $limit, $page)->fetchAll('assoc');

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

        clubs as Club 

      WHERE

      Club.visible = true $date AND

        (
 
          Club.code LIKE  '%$search%' OR

          Club.title LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
