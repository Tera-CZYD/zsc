<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;


/**
 * CollegeProgramCourses Model
 *
 * @property \App\Model\Table\CollegeProgramCorequisitesTable&\Cake\ORM\Association\HasMany $CollegeProgramCourses
 *
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProgramTermsTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('CollegeProgramSubs', [

      'foreignKey' => 'college_program_id',

      'propertyName' => 'CollegeProgramSubs'

    ]);

    $this->belongsTo('ProgramTerms', [

      'foreignKey' => 'program_term_id',

      'propertyName' => 'ProgramTerms'

    ]);


  }

  public function getAllCollegeProgramPrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        CollegeProgram.*

      FROM

        college_programs as CollegeProgram

      WHERE

        CollegeProgram.visible = true AND 

        (

        CollegeProgram.code         LIKE  '%$search%' OR

        CollegeProgram.name         LIKE  '%$search%' OR

        CollegeProgram.program_name LIKE  '%$search%' OR

        CollegeProgram.major         LIKE  '%$search%'

        )

      ORDER BY 

        CollegeProgram.code ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCollegeProgram($conditions, $limit, $page){

    $search = @$conditions['search'];

    // $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        CollegeProgram.*

      FROM

        college_programs as CollegeProgram

      WHERE

        CollegeProgram.visible = true AND 

        (

        CollegeProgram.code         LIKE  '%$search%' OR

        CollegeProgram.name         LIKE  '%$search%' OR

        CollegeProgram.program_name LIKE  '%$search%' OR

        CollegeProgram.major         LIKE  '%$search%'

        )

      GROUP BY

        CollegeProgram.id

      ORDER BY 

        CollegeProgram.code ASC

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

    $result = $this->getAllCollegeProgram($conditions, $limit, $page)->fetchAll('assoc');

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

        college_programs as CollegeProgram 

      WHERE

        CollegeProgram.visible = true AND 

        (

            CollegeProgram.code         LIKE  '%$search%' OR

            CollegeProgram.name         LIKE  '%$search%' OR

            CollegeProgram.program_name         LIKE  '%$search%' OR

            CollegeProgram.major         LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
