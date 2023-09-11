<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class ProspectusesTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

      $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id', 

    ]);

    }

    public function getAllProspectus($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $sql = "

        SELECT

          Student.id,

          StudentEnrollment.*,

          IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name,

          College.name as college,

          CollegeProgram.name as program 

        FROM

          students as Student LEFT JOIN

          student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          Student.visible = true $date $college_id $program_id $year_term_id AND

          StudentEnrollment.visible = true AND 

          (
   
            Student.first_name LIKE  '%$search%' OR

            Student.middle_name LIKE  '%$search%' OR

            Student.last_name LIKE  '%$search%' OR

            Student.email LIKE  '%$search%' OR

            StudentEnrollment.student_no LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%' OR 

            College.name LIKE '%$search%'

          )

        ORDER BY 

          full_name ASC
          
      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllProspectusPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $sql = "

        SELECT

          Student.id as student_id,

          StudentEnrollment.*,

          IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name,

          College.name as college,

          CollegeProgram.name as program 

        FROM

          students as Student LEFT JOIN

          student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          Student.visible = true $date $college_id $program_id $year_term_id AND

          StudentEnrollment.visible = true AND 

          (
   
            Student.first_name LIKE  '%$search%' OR

            Student.middle_name LIKE  '%$search%' OR

            Student.last_name LIKE  '%$search%' OR

            Student.email LIKE  '%$search%' OR

            StudentEnrollment.student_no LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%' OR 

            College.name LIKE '%$search%'

          )

        ORDER BY 

          full_name ASC
          
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

      $result = $this->getAllProspectus($conditions, $limit, $page)->fetchAll('assoc');

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

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $sql = "

        SELECT

        count(*) as total

        FROM

          students as Student LEFT JOIN

          student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          Student.visible = true $date $college_id $program_id $year_term_id AND

          StudentEnrollment.visible = true AND 

          (
   
            Student.first_name LIKE  '%$search%' OR

            Student.middle_name LIKE  '%$search%' OR

            Student.last_name LIKE  '%$search%' OR

            Student.email LIKE  '%$search%' OR

            StudentEnrollment.student_no LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%' OR 

            College.name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }