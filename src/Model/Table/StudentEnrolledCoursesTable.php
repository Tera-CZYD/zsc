<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class StudentEnrolledCoursesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Courses', [

      'foreignKey' => 'course_id', 

<<<<<<< HEAD
=======
      'propertyName' => 'course_association'

>>>>>>> 66b81273bcdeb45ccb2566ff250a7db7b8394497
    ]);

    $this->belongsTo('Sections', [

      'foreignKey' => 'section_id', 

<<<<<<< HEAD
=======
      'propertyName' => 'section_association'

>>>>>>> 66b81273bcdeb45ccb2566ff250a7db7b8394497
    ]);

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);

  }

  public function getAllStudentEnrolledCoursePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $year_term_id = @$conditions['year_term_id'];

    $sql = "

      SELECT

        StudentEnrollment.*,

        IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name,

        College.name as college,

        CollegeProgram.name as program,

        Student.email,

        Student.contact_no,

        YearLevelTerm.description

      FROM

        students as Student LEFT JOIN

        student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

        colleges as College ON College.id = Student.college_id LEFT JOIN 

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN 

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = Student.year_term_id

      WHERE

        Student.visible = true $date $year_term_id AND

        StudentEnrollment.visible = true AND 

        YearLevelTerm.visible = true AND

        (
 
          Student.first_name LIKE  '%$search%' OR

          Student.middle_name LIKE  '%$search%' OR

          Student.last_name LIKE  '%$search%' OR

          Student.email LIKE  '%$search%' OR

          StudentEnrollment.student_no LIKE '%$search%' OR 

          CollegeProgram.name LIKE '%$search%' OR 

          College.name LIKE '%$search%'

        )

      GROUP BY 

        Student.id

      ORDER BY 

        full_name ASC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllStudentEnrolledCourse($conditions=array()){

    $search = @$conditions['search'];

    $faculty = $conditions['employeeId'];

    $sql = "

      SELECT

        StudentEnrolledCourse.*

      FROM

        student_enrolled_courses as StudentEnrolledCourse

      WHERE

       StudentEnrolledCourse.visible = true $faculty AND

        (

          StudentEnrolledCourse.course LIKE '%$search%'

        )

      GROUP BY 

        StudentEnrolledCourse.course_id  

      ORDER BY 

        StudentEnrolledCourse.course ASC
        
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

    $result = $this->getAllStudentEnrolledCourse($conditions, $limit, $page)->fetchAll('assoc');

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

    $year_term_id = @$conditions['year_term_id'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        student_enrolled_courses as StudentEnrolledCourse

      WHERE

       StudentEnrolledCourse.visible = true AND

        (

          StudentEnrolledCourse.course LIKE '%$search%'
          
        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');
    // var_dump($query);

    return $query['count'];

  }

}
