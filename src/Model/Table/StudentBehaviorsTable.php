<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class StudentBehaviorsTable extends Table{

    public function initialize(array $config): void {

    $this->addBehavior('Timestamp');

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'course_id', 

    ]);

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);
     

    }

  public function getAllStudentBehaviorPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $year = @$conditions['year'];

    $program_id = @$conditions['program_id'];

    $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

    $sql = "SELECT

          StudentBehavior.*,

          CollegeProgram.name as program

        FROM

          student_behaviors as StudentBehavior LEFT JOIN

          college_programs as CollegeProgram ON StudentBehavior.course_id = CollegeProgram.id 

 
        WHERE

          StudentBehavior.visible = true $date $program_id $year AND

          (

            StudentBehavior.student_name LIKE '%$search%' OR 


            CollegeProgram.name LIKE '%$search%'

          )

      ";


    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllStudentBehavior($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $year = @$conditions['year'];

    $program_id = @$conditions['program_id'];

    $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

   

    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM (

        SELECT

          StudentBehavior.*,

          CollegeProgram.name as program

        FROM

          student_behaviors as StudentBehavior LEFT JOIN

          college_programs as CollegeProgram ON StudentBehavior.course_id = CollegeProgram.id 

 
        WHERE

          StudentBehavior.visible = true $date $program_id $year AND

          (

            StudentBehavior.student_name LIKE '%$search%' OR 


            CollegeProgram.name LIKE '%$search%'

          )

      ) as StudentBehavior ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function paginate($query, array $options = []){

    $extra = isset($options['extra']) ? $options['extra'] : [];

    $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

    $page = $options['page'];

    $limit = $options['limit'];

    $result = $this->getAllStudentBehavior($conditions, $limit, $page)->fetchAll('assoc');

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

    $year = @$conditions['year'];

    $program_id = @$conditions['program_id'];

    $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

    $sql = "SELECT count(*) as count FROM (

        
        SELECT

          StudentBehavior.*,

          CollegeProgram.name as program

        FROM

          student_behaviors as StudentBehavior LEFT JOIN

          college_programs as CollegeProgram ON StudentBehavior.course_id = CollegeProgram.id 

 
        WHERE

          StudentBehavior.visible = true $date $program_id $year AND

          (

            StudentBehavior.student_name LIKE '%$search%' OR 


            CollegeProgram.name LIKE '%$search%'

          )


      ) as StudentBehavior ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

  }