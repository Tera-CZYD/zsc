<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AcademicTermsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('YearLevelTerms', [

          'foreignKey' => 'year_term_id',

      ]);

  }

  public function getAllAcademicTerm($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        AcademicTerm.*,

        YearLevelTerm.description

      FROM

        academic_terms as AcademicTerm LEFT JOIN

        year_level_terms as YearLevelTerm ON AcademicTerm.year_term_id = YearLevelTerm.id

      WHERE

        AcademicTerm.visible = true AND 

        (


          AcademicTerm.school_year_start     LIKE  '%$search%'

        )

      GROUP BY

        AcademicTerm.id

      ORDER BY 

        AcademicTerm.school_year_start ASC

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

    $result = $this->getAllAcademicTerm($conditions, $limit, $page)->fetchAll('assoc');

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

        academic_terms as AcademicTerm LEFT JOIN

        year_level_terms as YearLevelTerm ON AcademicTerm.year_term_id = YearLevelTerm.id

      WHERE

        AcademicTerm.visible = true AND 

        (

          AcademicTerm.school_year_start         LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
