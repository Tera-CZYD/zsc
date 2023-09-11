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
class PromissoryNotesTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id',

      'propertyName' => 'CollegeProgram'

    ]);

    $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id',

      'propertyName' => 'YearLevelTerm'

    ]);

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id',

      'propertyName' => 'Student'

    ]);


  }

  public function getAllPromissoryNotePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        PromissoryNote.*,

        CollegeProgram.name,

        YearLevelTerm.description

      FROM

        promissory_notes as PromissoryNote LEFT JOIN

        college_programs as CollegeProgram ON PromissoryNote.program_id = CollegeProgram.id LEFT JOIN

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = PromissoryNote.year_term_id

      WHERE

        PromissoryNote.visible = true $date AND

        (
 
          PromissoryNote.code LIKE  '%$search%' OR

          PromissoryNote.student_no LIKE  '%$search%' OR

          PromissoryNote.student_name LIKE  '%$search%' OR

          PromissoryNote.description LIKE  '%$search%'

        )

      ORDER BY 

        PromissoryNote.code ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllPromissoryNote($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        PromissoryNote.*,

        CollegeProgram.name,

        YearLevelTerm.description

      FROM

        promissory_notes as PromissoryNote LEFT JOIN

        college_programs as CollegeProgram ON PromissoryNote.program_id = CollegeProgram.id LEFT JOIN

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = PromissoryNote.year_term_id

      WHERE

        PromissoryNote.visible = true $date AND

        (
 
          PromissoryNote.code LIKE  '%$search%' OR

          PromissoryNote.student_no LIKE  '%$search%' OR

          PromissoryNote.student_name LIKE  '%$search%' OR

          PromissoryNote.description LIKE  '%$search%'

        )

      GROUP BY

        PromissoryNote.id

      ORDER BY 

        PromissoryNote.code ASC

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

    $result = $this->getAllPromissoryNote($conditions, $limit, $page)->fetchAll('assoc');

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

        promissory_notes as PromissoryNote LEFT JOIN

        college_programs as CollegeProgram ON PromissoryNote.program_id = CollegeProgram.id LEFT JOIN

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = PromissoryNote.year_term_id

      WHERE

        PromissoryNote.visible = true $date AND

        (
 
          PromissoryNote.code LIKE  '%$search%' OR

          PromissoryNote.student_no LIKE  '%$search%' OR

          PromissoryNote.student_name LIKE  '%$search%' OR

          PromissoryNote.description LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
