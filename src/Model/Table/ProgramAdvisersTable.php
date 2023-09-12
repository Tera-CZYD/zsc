<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ProgramAdvisersTable extends Table{

  public function initialize(array $config): void {

   	$this->addBehavior('Timestamp');

    $this->belongsTo('Sections', [

      'foreignKey' => 'section_id', 

    ]);

  }

  public function getAllProgramAdviserPrint($conditions){

    $search = strtolower(@$conditions['search']);

    $status = @$conditions['status'];

    $date = @$conditions['date'];

    $year_term_id = @$conditions['year_term_id'];

    $sql = "

      SELECT 

        Student.*,

        CollegeProgram.id,

        CollegeProgram.name,

        CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ', IFNULL(Student.middle_name,'')) as full_name,

        StudentApplication.rate

      FROM 

        students as Student LEFT JOIN 

        student_applications as StudentApplication ON StudentApplication.id = Student.student_applicant_id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

        (

          SELECT 

            StudentEnrollment.student_id,

            COUNT(*) as enrollmentCount

          FROM 

            student_enrollments as StudentEnrollment

          WHERE 

            StudentEnrollment.visible = true AND 

            StudentEnrollment.year_term_id = $year_term_id

          GROUP BY 

            StudentEnrollment.student_id

        ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id

      WHERE 

        Student.visible = true $status $date AND 

        Student.year_term_id = $year_term_id AND 

        StudentApplication.status = 'QUALIFIED' AND 

      (

        Student.student_no LIKE '%$search%' OR

        Student.first_name LIKE '%$search%' OR

        Student.middle_name LIKE '%$search%' OR

        Student.last_name LIKE '%$search%' 

      )

      ORDER BY 

        full_name ASC,

        CollegeProgram.name ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllProgramAdviser($conditions, $limit, $page){

    $search = strtolower(@$conditions['search']);

    $status = @$conditions['status'];

    $date = @$conditions['date'];

    $year_term_id = @$conditions['year_term_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

        Student.*,

        Student.id as student_id,

        CollegeProgram.id,

        CollegeProgram.name,

        CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ', IFNULL(Student.middle_name,'')) as full_name,

        StudentApplication.rate

      FROM 

        students as Student LEFT JOIN 

        student_applications as StudentApplication ON StudentApplication.id = Student.student_applicant_id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

        (

          SELECT 

            StudentEnrollment.student_id,

            COUNT(*) as enrollmentCount

          FROM 

            student_enrollments as StudentEnrollment

          WHERE 

            StudentEnrollment.visible = true AND 

            StudentEnrollment.year_term_id = $year_term_id

          GROUP BY 

            StudentEnrollment.student_id

        ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id

      WHERE 

        Student.visible = true $status $date AND 

        Student.year_term_id = $year_term_id AND 

        StudentApplication.status = 'QUALIFIED' AND 

      (

        Student.student_no LIKE '%$search%' OR

        Student.first_name LIKE '%$search%' OR

        Student.middle_name LIKE '%$search%' OR

        Student.last_name LIKE '%$search%' 

      )

      ORDER BY 

        full_name ASC,

        CollegeProgram.name ASC

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

    $result = $this->getAllProgramAdviser($conditions, $limit, $page)->fetchAll('assoc');

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

    $status = @$conditions['status'];

    $year_term_id = @$conditions['year_term_id'];

    $sql = "

      SELECT

        count(*) as count

      FROM 

        students as Student LEFT JOIN 

        student_applications as StudentApplication ON StudentApplication.id = Student.student_applicant_id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

        (

          SELECT 

            StudentEnrollment.student_id,

            COUNT(*) as enrollmentCount

          FROM 

            student_enrollments as StudentEnrollment

          WHERE 

            StudentEnrollment.visible = true AND 

            StudentEnrollment.year_term_id = $year_term_id

          GROUP BY 

            StudentEnrollment.student_id

        ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id

      WHERE 

        Student.visible = true $status AND 

        Student.year_term_id = $year_term_id AND 

        StudentApplication.status = 'QUALIFIED' AND 

      (

        Student.student_no LIKE '%$search%' OR

        Student.first_name LIKE '%$search%' OR

        Student.middle_name LIKE '%$search%' OR

        Student.last_name LIKE '%$search%' 

      )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

  }