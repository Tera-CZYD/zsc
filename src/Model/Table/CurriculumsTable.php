<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class CurriculumsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Campus', [

        'foreignKey' => 'campus_id',

    ]);

    $this->hasMany('CurriculumSubs', [

        'foreignKey' => 'curriculum_id',

    ]);

  }

  public function getAllCurriculumPrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        Curriculum.*

      FROM

        curriculums as Curriculum

      WHERE

        Curriculum.visible = true AND

        (
 
          Curriculum.code LIKE '%$search%' OR

          Curriculum.description LIKE '%$search%'

        )

      ORDER BY 

        Curriculum.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCurriculum($conditions, $limit, $page){

    $search = @$conditions['search'];

    // $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Curriculum.*

      FROM

        curriculums as Curriculum

      WHERE

        Curriculum.visible = true AND 

        (

          Curriculum.code         LIKE  '%$search%' OR

          Curriculum.description         LIKE  '%$search%' 

        )

      GROUP BY

        Curriculum.id

      ORDER BY 

        Curriculum.code ASC

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

    $result = $this->getAllCurriculum($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT

        count(*) as count

       FROM

        curriculums as Curriculum 

      WHERE

        Curriculum.visible = true AND 

        (

          Curriculum.code         LIKE  '%$search%' OR

          Curriculum.description         LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
