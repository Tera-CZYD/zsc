<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class RegisteredStudentsTable extends Table {

  public function initialize(array $config): void{
    $this->setTable('registered_students');
    $this->setDisplayField('id');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');
    
    $this->belongsTo('YearLevelTerms', ['foreignKey' => 'year_term_id']);

  }

  public function getAllRegisteredStudentPrint($conditions){

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

  public function getAllRegisteredStudent($conditions=array()){

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

    $result = $this->getAllRegisteredStudent($conditions, $limit, $page)->fetchAll('assoc');

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

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');
    // var_dump($query);

    return $query['count'];

  }

}

