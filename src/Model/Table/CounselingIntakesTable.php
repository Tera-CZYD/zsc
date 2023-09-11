<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class CounselingIntakesTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id',

      'propertyName' => 'Student'

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'course_id',

      'propertyName' => 'CollegeProgram'

    ]);

    $this->hasOne('CounselingIntakeSubs', [

      'foreignKey' => 'counseling_intake_id',

      'propertyName' => 'CounselingIntakeSub'

    ]);


  }

  public function getAllCounselingIntakePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        CounselingIntake.*,

        Student.id as student_id,

        Student.date_of_birth,

        CollegeProgram.code,

        CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name

      FROM

        counseling_intakes as CounselingIntake LEFT JOIN

        students as Student ON CounselingIntake.student_id = Student.id LEFT JOIN 

        college_programs as CollegeProgram ON CounselingIntake.course_id = CollegeProgram.id


      WHERE

        CounselingIntake.visible = true  AND

        Student.visible = true  AND

        CollegeProgram.visible = true AND 

        (
 

          CounselingIntake.student_name             LIKE  '%$search%' OR

          CounselingIntake.year_level_term          LIKE  '%$search%' OR

          CounselingIntake.address                  LIKE  '%$search%' OR

          CounselingIntake.contact_no               LIKE  '%$search%' 


        )

      ORDER BY 

        CounselingIntake.student_name ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCounselingIntake($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        CounselingIntake.*,

        Student.id as student_id,

        Student.date_of_birth,

        CollegeProgram.code,

        CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name

      FROM

        counseling_intakes as CounselingIntake LEFT JOIN

        students as Student ON CounselingIntake.student_id = Student.id LEFT JOIN 

        college_programs as CollegeProgram ON CounselingIntake.course_id = CollegeProgram.id


      WHERE

        CounselingIntake.visible = true  AND

        Student.visible = true  AND

        CollegeProgram.visible = true AND 

        (
 

          CounselingIntake.student_name             LIKE  '%$search%' OR

          CounselingIntake.year_level_term          LIKE  '%$search%' OR

          CounselingIntake.address                  LIKE  '%$search%' OR

          CounselingIntake.contact_no               LIKE  '%$search%' 


        )

      GROUP BY

        CounselingIntake.id

      ORDER BY 

        CounselingIntake.student_name ASC

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

    $result = $this->getAllCounselingIntake($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT

        count(*) as count

      
      FROM

        counseling_intakes as CounselingIntake LEFT JOIN

        students as Student ON CounselingIntake.student_id = Student.id LEFT JOIN 

        college_programs as CollegeProgram ON CounselingIntake.course_id = CollegeProgram.id


      WHERE

        CounselingIntake.visible = true  AND

        Student.visible = true  AND

        CollegeProgram.visible = true AND 

        (
 

          CounselingIntake.student_name             LIKE  '%$search%' OR

          CounselingIntake.year_level_term          LIKE  '%$search%' OR

          CounselingIntake.address                  LIKE  '%$search%' OR

          CounselingIntake.contact_no               LIKE  '%$search%' 


        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
