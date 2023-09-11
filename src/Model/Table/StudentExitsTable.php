<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class StudentExitsTable extends Table
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

  }

  public function getAllStudentExitPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT 

      StudentExit.*,

      CollegeProgram.name

    FROM 

      student_exits as StudentExit LEFT JOIN 

      college_programs as CollegeProgram On StudentExit.course_id = CollegeProgram.id

    WHERE 

      StudentExit.visible = true AND 

      (

        StudentExit.student_name         LIKE      '%$search%'     OR

        StudentExit.email               LIKE      '%$search%'     OR

        StudentExit.contact_no           LIKE      '%$search%'    

      )

      ORDER BY 

        StudentExit.id DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllStudentExit($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

      StudentExit.*,

      CollegeProgram.name

      FROM 

        student_exits as StudentExit LEFT JOIN 

        college_programs as CollegeProgram On StudentExit.course_id = CollegeProgram.id

      WHERE 

        StudentExit.visible = true AND 

        (

          StudentExit.student_name         LIKE      '%$search%'     OR

          StudentExit.email               LIKE      '%$search%'     OR

          StudentExit.contact_no           LIKE      '%$search%'    

        )

      GROUP BY

        StudentExit.id

      ORDER BY 

        StudentExit.id DESC

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

    $result = $this->getAllStudentExit($conditions, $limit, $page)->fetchAll('assoc');

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

        student_exits as StudentExit LEFT JOIN 

        college_programs as CollegeProgram On StudentExit.course_id = CollegeProgram.id

      WHERE 

        StudentExit.visible = true AND 

        (

          StudentExit.student_name         LIKE      '%$search%'     OR

          StudentExit.email               LIKE      '%$search%'     OR

          StudentExit.contact_no           LIKE      '%$search%'    

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
