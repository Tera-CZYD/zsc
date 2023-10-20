<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class YearLevelTermsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllYearLevelTerm($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        YearLevelTerm.*

      FROM

        year_level_terms as YearLevelTerm

      WHERE

        YearLevelTerm.visible = true AND 

        (


          YearLevelTerm.description         LIKE  '%$search%' OR

          YearLevelTerm.year         LIKE  '%$search%' OR

          YearLevelTerm.semester         LIKE  '%$search%'

        )

      GROUP BY

        YearLevelTerm.id

      ORDER BY 

        YearLevelTerm.description ASC

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

    $result = $this->getAllYearLevelTerm($conditions, $limit, $page)->fetchAll('assoc');

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

        year_level_terms as YearLevelTerm 

      WHERE

        YearLevelTerm.visible = true AND 

        (

          YearLevelTerm.description         LIKE  '%$search%' OR

          YearLevelTerm.year         LIKE  '%$search%' OR

          YearLevelTerm.semester         LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
