<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class StudentProfilesTable extends Table {

  public function initialize(array $config): void{
    $this->addBehavior('Timestamp');
    
    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'preffered_program_id'

    ]);

    $this->hasMany('CollegeProgramSubs', [

      'foreignKey' => 'college_program_id'

    ]);

     $this->hasMany('StudentApplicationImages', [

      'foreignKey' => 'application_id'

    ]);

  }

  public function getAllStudentProfilePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $college_program = @$conditions['college_program'];

    $sql = "

      
      SELECT

        StudentApplication.*,

        CollegeProgram.name,

        IFNULL(CONCAT(StudentApplication.last_name,', ',StudentApplication.first_name,' ',IFNULL(StudentApplication.middle_name,' ')),' ') AS full_name

      FROM

        student_applications as StudentApplication LEFT JOIN 

        college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id LEFT JOIN 

        student_application_images as StudentApplicationImage ON StudentApplication.id = StudentApplicationImage.application_id

      WHERE

        StudentApplication.visible = true $date $college_program AND

        CollegeProgram.visible = true AND

        (
 
          StudentApplication.first_name LIKE  '%$search%' OR

          StudentApplication.middle_name LIKE  '%$search%' OR

          StudentApplication.last_name LIKE  '%$search%' OR

          StudentApplication.email LIKE  '%$search%' OR

          StudentApplication.contact_no LIKE  '%$search%' OR

          StudentApplication.address LIKE  '%$search%'

        )

      GROUP BY 

        StudentApplication.id

      ORDER BY 

        full_name DESC

        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllStudentProfile($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $college_program = @$conditions['college_program'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        StudentApplication.*,

        CollegeProgram.name,

        IFNULL(CONCAT(StudentApplication.last_name,', ',StudentApplication.first_name,' ',IFNULL(StudentApplication.middle_name,' ')),' ') AS full_name

      FROM

        student_applications as StudentApplication LEFT JOIN 

        college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id LEFT JOIN 

        student_application_images as StudentApplicationImage ON StudentApplication.id = StudentApplicationImage.application_id

      WHERE

        StudentApplication.visible = true $date $college_program AND

        CollegeProgram.visible = true AND

        (
 
          StudentApplication.first_name LIKE  '%$search%' OR

          StudentApplication.middle_name LIKE  '%$search%' OR

          StudentApplication.last_name LIKE  '%$search%' OR

          StudentApplication.email LIKE  '%$search%' OR

          StudentApplication.contact_no LIKE  '%$search%' OR

          StudentApplication.address LIKE  '%$search%'

        )

      GROUP BY 

        StudentApplication.id

      ORDER BY 

        full_name DESC


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

    $result = $this->getAllStudentProfile($conditions, $limit, $page)->fetchAll('assoc');

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

    $college_program = @$conditions['college_program'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        student_applications as StudentApplication LEFT JOIN 

        college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id LEFT JOIN 

        student_application_images as StudentApplicationImage ON StudentApplication.id = StudentApplicationImage.application_id

      WHERE

        StudentApplication.visible = true $date $college_program AND

        CollegeProgram.visible = true AND

        (
 
          StudentApplication.first_name LIKE  '%$search%' OR

          StudentApplication.middle_name LIKE  '%$search%' OR

          StudentApplication.last_name LIKE  '%$search%' OR

          StudentApplication.email LIKE  '%$search%' OR

          StudentApplication.contact_no LIKE  '%$search%' OR

          StudentApplication.address LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}

