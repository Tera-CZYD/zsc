<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class StudentsTable extends Table{

  public function initialize(array $config): void{

    $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id'

    ]);

    $this->belongsTo('Curriculums', [

      'foreignKey' => 'curriculum_id'

    ]);

    // $this->hasOne('StudentProfiles', [

    //   'foreignKey' => 'student_id'

    // ]);

    $this->belongsTo('Colleges', [

      'foreignKey' => 'college_id'

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id'

    ]);

    $this->hasMany('StudentEnrolledCourses', [

      'foreignKey' => 'student_id'

    ]);

    $this->hasMany('StudentEnrolledUnits', [

      'foreignKey' => 'student_id'

    ]);

    $this->hasMany('StudentEnrolledSchedules', [

      'foreignKey' => 'student_id'

    ]);

    $this->hasMany('StudentEnrollments', [

      'foreignKey' => 'student_id'

    ]);

    $this->hasMany('StudentLedgers', [

      'foreignKey' => 'student_id'

    ]);
  }

  public function getAllStudent($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $college_id = @$conditions['college_id'];

    $degree_id = @$conditions['degree_id'];

    if(@$conditions['view_by_student']){

      $order = "ORDER BY Student.last_name ASC,Student.first_name ASC,Student.middle_name ASC";

    }else{

      $order = "ORDER BY Student.student_no ASC";

    }

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Student.*,

        CONCAT(Student.last_name, ', ', IFNULL(Student.first_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name,

        College.name as c_name,

        CollegeProgram.name as program_name

      FROM

        students as Student LEFT JOIN

        (

          SELECT

            College.id,

            College.name

          FROM

            colleges as College

          WHERE 

            College.visible = true

        ) as College ON College.id = Student.college_id LEFT JOIN

        (

          SELECT

            CollegeProgram.id,

            CollegeProgram.name

          FROM

            college_programs as CollegeProgram

          WHERE 

            CollegeProgram.visible = true

        ) as CollegeProgram ON CollegeProgram.id = Student.program_id 

      WHERE

        Student.visible = true $date $college_id  AND

        (

          Student.student_no   LIKE  '%$search%' OR

          Student.first_name   LIKE  '%$search%' OR

          Student.middle_name  LIKE  '%$search%' OR

          Student.last_name    LIKE  '%$search%' OR

          College.name         LIKE  '%$search%' OR

          CollegeProgram.name  LIKE  '%$search%' 

        )

      GROUP BY

        Student.id

      $order

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

    $result = $this->getAllStudent($conditions, $limit, $page)->fetchAll('assoc');

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

    $degree_id = @$conditions['degree_id'];

    if(@$conditions['view_by_student']){

      $order = "ORDER BY Student.last_name ASC,Student.first_name ASC,Student.middle_name ASC";

    }else{

      $order = "ORDER BY Student.student_no ASC";

    }

    $sql = "

      SELECT

        COUNT(*) as count

      FROM

        students as Student LEFT JOIN

        (

          SELECT

            College.id,

            College.name

          FROM

            colleges as College

          WHERE 

            College.visible = true

        ) as College ON College.id = Student.college_id LEFT JOIN

        (

          SELECT

            CollegeProgram.id,

            CollegeProgram.name

          FROM

            college_programs as CollegeProgram

          WHERE 

            CollegeProgram.visible = true

        ) as CollegeProgram ON CollegeProgram.id = Student.program_id 

      WHERE

        Student.visible = true $date $college_id  AND

        (

          Student.student_no   LIKE  '%$search%' OR

          Student.first_name   LIKE  '%$search%' OR

          Student.middle_name  LIKE  '%$search%' OR

          Student.last_name    LIKE  '%$search%' OR

          College.name         LIKE  '%$search%' OR

          CollegeProgram.name  LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
