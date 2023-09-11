<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class ApartelleStudentClearancesTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

      $this->belongsTo('CollegePrograms', [

        'foreignKey' => 'program_id', 

      ]);

      $this->belongsTo('YearLevelTerms', [

        'foreignKey' => 'year_term_id', 

      ]);

      $this->belongsTo('CollegePrograms', [

        'foreignKey' => 'program_id', 

      ]);

    }

    public function getAllApartelleStudentClearance($conditions, $limit, $page){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

        ApartelleStudentClearance.*,

          CollegeProgram.code as collegeProgramCode,

          CollegeProgram.name,

          YearLevelTerm.description

        FROM

          apartelle_student_clearances as ApartelleStudentClearance LEFT JOIN

          college_programs as CollegeProgram ON ApartelleStudentClearance.program_id = CollegeProgram.id LEFT JOIN

          year_level_terms as YearLevelTerm ON ApartelleStudentClearance.year_term_id = YearLevelTerm.id

        WHERE

          ApartelleStudentClearance.visible = true $date $status $studentId AND

          (

            ApartelleStudentClearance.code LIKE  '%$search%' OR

            ApartelleStudentClearance.student_name LIKE '%$search%'


          )

        ORDER BY 

          ApartelleStudentClearance.code ASC
          
      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllApartelleStudentClearancePrint($conditions){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

        ApartelleStudentClearance.*,

          CollegeProgram.code as collegeProgramCode,

          CollegeProgram.name,

          YearLevelTerm.description

        FROM

          apartelle_student_clearances as ApartelleStudentClearance LEFT JOIN

          college_programs as CollegeProgram ON ApartelleStudentClearance.program_id = CollegeProgram.id LEFT JOIN

          year_level_terms as YearLevelTerm ON ApartelleStudentClearance.year_term_id = YearLevelTerm.id

        WHERE

          ApartelleStudentClearance.visible = true $date $status $studentId AND

          (

            ApartelleStudentClearance.code LIKE  '%$search%' OR

            ApartelleStudentClearance.student_name LIKE '%$search%'

          )

        ORDER BY 

          ApartelleStudentClearance.code ASC
          
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

      $result = $this->getAllApartelleStudentClearance($conditions, $limit, $page)->fetchAll('assoc');

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

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

          count(*) as total

        FROM

          apartelle_student_clearances as ApartelleStudentClearance 

        WHERE

          ApartelleStudentClearance.visible = true $date $status $studentId AND

          (

            ApartelleStudentClearance.code LIKE  '%$search%' OR

            ApartelleStudentClearance.student_name LIKE '%$search%'


          )

        ORDER BY 

          ApartelleStudentClearance.code ASC
          
      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }