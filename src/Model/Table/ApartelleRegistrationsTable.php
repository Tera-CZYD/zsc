<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class ApartelleRegistrationsTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

      $this->belongsTo('CollegePrograms', [

        'foreignKey' => 'program_id', 

      ]);

      $this->belongsTo('YearLevelTerms', [

        'foreignKey' => 'year_term_id', 

      ]);

      $this->belongsTo('Apartelles', [

        'foreignKey' => 'apartelle_id', 

      ]);

      $this->belongsTo('Students', [

        'foreignKey' => 'student_id', 

      ]);

    }

    public function getAllApartelleRegistration($conditions, $limit, $page){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

        ApartelleRegistration.*,

          CollegeProgram.code as program_code,

          CollegeProgram.name,

          YearLevelTerm.description

        FROM

          apartelle_registrations as ApartelleRegistration LEFT JOIN

          college_programs as CollegeProgram ON ApartelleRegistration.program_id = CollegeProgram.id LEFT JOIN

          year_level_terms as YearLevelTerm ON ApartelleRegistration.year_term_id = YearLevelTerm.id

        WHERE

          ApartelleRegistration.visible = true $date $status $studentId AND

          (

            ApartelleRegistration.code LIKE  '%$search%' OR
   
            ApartelleRegistration.nick_name LIKE  '%$search%' OR

            ApartelleRegistration.student_name LIKE '%$search%' OR

            ApartelleRegistration.date_of_birth LIKE  '%$search%'


          )

        ORDER BY 

          ApartelleRegistration.code ASC
          
      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllApartelleRegistrationPrint($conditions){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

        ApartelleRegistration.*,

          CollegeProgram.code as college_program,

          CollegeProgram.name,

          YearLevelTerm.description

        FROM

          apartelle_registrations as ApartelleRegistration LEFT JOIN

          college_programs as CollegeProgram ON ApartelleRegistration.program_id = CollegeProgram.id LEFT JOIN

          year_level_terms as YearLevelTerm ON ApartelleRegistration.year_term_id = YearLevelTerm.id

        WHERE

          ApartelleRegistration.visible = true $date $status $studentId AND

          (

            ApartelleRegistration.code LIKE  '%$search%' OR
   
            ApartelleRegistration.nick_name LIKE  '%$search%' OR

            ApartelleRegistration.student_name LIKE '%$search%' OR

            ApartelleRegistration.date_of_birth LIKE  '%$search%'


          )

        ORDER BY 

          ApartelleRegistration.code ASC
          
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

      $result = $this->getAllApartelleRegistration($conditions, $limit, $page)->fetchAll('assoc');

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

          apartelle_registrations as ApartelleRegistration 

        WHERE

          ApartelleRegistration.visible = true $date $status $studentId AND

          (

            ApartelleRegistration.code LIKE  '%$search%' OR
   
            ApartelleRegistration.nick_name LIKE  '%$search%' OR

            ApartelleRegistration.student_name LIKE '%$search%' OR

            ApartelleRegistration.date_of_birth LIKE  '%$search%'


          )

        ORDER BY 

          ApartelleRegistration.code ASC
          
      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }