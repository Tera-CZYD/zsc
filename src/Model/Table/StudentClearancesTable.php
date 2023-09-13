<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class StudentClearancesTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id'

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'course_id'

    ]);


    $this->belongsTo('Employees', [

      'foreignKey' => 'employee_id'

    ]);

    $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id'

    ]);

    $this->hasMany('StudentClearanceSubs', [

      'foreignKey' => 'clearance_id'

    ]);

  }

  public function getAllStudentClearancePrint($conditions){

    $search = @$conditions['search'];

    // $date = @$conditions['date'];

    $college_program = @$conditions['college_program'];

    $sql = "

      SELECT

        StudentClearance.*,

        CollegeProgram.name,

        YearLevelTerm.description as year_level_term

      FROM

        student_clearances as StudentClearance LEFT JOIN

        college_programs as CollegeProgram ON StudentClearance.course_id = CollegeProgram.id LEFT JOIN

        student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = StudentClearance.student_id LEFT JOIN 

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = StudentClearance.year_term_id
      WHERE

      StudentClearance.visible = true $college_program AND

        (
 
          StudentClearance.code LIKE  '%$search%' OR

          StudentClearance.student_no LIKE  '%$search%' OR

          StudentClearance.student_name LIKE  '%$search%' OR


          StudentClearance.major LIKE  '%$search%'

        )

      ORDER BY 

      StudentClearance.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllStudentClearance($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $faculty = @$conditions['faculty'];

    $course = @$conditions['course'];

    $status = @$conditions['status'];

    $college_program = @$conditions['college_program'];

    $step = @$conditions['step'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        StudentClearance.*,

        CollegeProgram.name,

        YearLevelTerm.description as year_level_term,

        StudentEnrolledCourse.course as course,

        StudentEnrolledCourse.clearance_remarks as faculty_remark

      FROM

        student_clearances as StudentClearance LEFT JOIN

        college_programs as CollegeProgram ON StudentClearance.course_id = CollegeProgram.id  LEFT JOIN 

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = StudentClearance.year_term_id LEFT JOIN

        student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = StudentClearance.student_id

      WHERE

        StudentClearance.visible = true $faculty $course $status $college_program $step AND 

        (
 
          StudentClearance.code LIKE  '%$search%' OR

          StudentClearance.student_no LIKE  '%$search%' OR

          StudentClearance.student_name LIKE  '%$search%' OR

          StudentClearance.major LIKE  '%$search%'

        )

      GROUP BY 

        StudentClearance.id

      ORDER BY 

        StudentClearance.code DESC

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

    $result = $this->getAllStudentClearance($conditions, $limit, $page)->fetchAll('assoc');

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

    // $date = @$conditions['date'];

    $sql = "

      SELECT

        count(*) as count

       FROM

        student_clearances as StudentClearance 

      WHERE

        StudentClearance.visible = true AND 

        (
 
          StudentClearance.code LIKE  '%$search%' OR

          StudentClearance.student_no LIKE  '%$search%' OR

          StudentClearance.student_name LIKE  '%$search%' OR

          StudentClearance.major LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
