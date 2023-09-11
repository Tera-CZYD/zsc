<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class CollegesTable extends Table{




  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Campus', [
        'foreignKey' => 'campus_id',
    ]);

    $this->hasMany('CollegeSub', [
        'foreignKey' => 'college_id',
        'className' => 'CollegeSubs',
    ]);

  }

  public function getAllCollegePrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        College.*

      FROM

        colleges as College

      WHERE

        College.visible = true AND

        (
 
          College.code LIKE '%$search%' OR

          College.name LIKE '%$search%' OR 

          College.acronym LIKE '%$search%'

        )

      ORDER BY 

        College.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCollege($conditions, $limit, $page){

    $search = @$conditions['search'];

    // $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        College.*

      FROM

        colleges as College

      WHERE

        College.visible = true AND 

        (

          College.code         LIKE  '%$search%' OR

          College.acronym         LIKE  '%$search%' OR

          College.year_established         LIKE  '%$search%' OR

          College.name         LIKE  '%$search%'

        )

      GROUP BY

        College.id

      ORDER BY 

        College.code ASC

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

    $result = $this->getAllCollege($conditions, $limit, $page)->fetchAll('assoc');

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

    // $college_id = @$conditions['college_id'];

    $sql = "

      SELECT

        count(*) as count

       FROM

        colleges as College 

      WHERE

        College.visible = true AND 

        (

          College.code         LIKE  '%$search%' OR

          College.acronym         LIKE  '%$search%' OR

          College.year_established         LIKE  '%$search%' OR

          College.name         LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
