<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class AddingDroppingSubjectsTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id',

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id',

    ]);

    $this->hasMany('AddingDroppingSubjectSubs', [

      'foreignKey' => 'adding_dropping_subject_id'

    ]);

  }

  public function getAllAddingDroppingSubjectPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        AddingDroppingSubject.*,

        Student.id as student_id,

        CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name

      FROM

        adding_dropping_subjects as AddingDroppingSubject LEFT JOIN

        students as Student ON AddingDroppingSubject.student_id = Student.id


      WHERE

        AddingDroppingSubject.visible = true $date  AND

        AddingDroppingSubject.visible = true $date $status $studentId AND

        (

          AddingDroppingSubject.student_no    LIKE  '%$search%' OR

          AddingDroppingSubject.student_name  LIKE  '%$search%' OR
         
          AddingDroppingSubject.date          LIKE  '%$search%' OR
       
          AddingDroppingSubject.student_id    LIKE  '%$search%' 


        )

      ORDER BY 

        AddingDroppingSubject.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAddingDroppingSubject($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        AddingDroppingSubject.*,

        Student.id as student_id,

        CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name

      FROM

        adding_dropping_subjects as AddingDroppingSubject LEFT JOIN

        students as Student ON AddingDroppingSubject.student_id = Student.id


      WHERE

        AddingDroppingSubject.visible = true $date  AND

        AddingDroppingSubject.visible = true $date $status $studentId AND

        (

          AddingDroppingSubject.student_no    LIKE  '%$search%' OR

          AddingDroppingSubject.student_name  LIKE  '%$search%' OR
         
          AddingDroppingSubject.date          LIKE  '%$search%' OR
       
          AddingDroppingSubject.student_id    LIKE  '%$search%' 


        )

      GROUP BY

        AddingDroppingSubject.id

      ORDER BY 

        AddingDroppingSubject.code DESC

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

    $result = $this->getAllAddingDroppingSubject($conditions, $limit, $page)->fetchAll('assoc');

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

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        adding_dropping_subjects as AddingDroppingSubject LEFT JOIN

        students as Student ON AddingDroppingSubject.student_id = Student.id


      WHERE

        AddingDroppingSubject.visible = true $date  AND

        AddingDroppingSubject.visible = true $date $status $studentId AND

        (

          AddingDroppingSubject.student_no    LIKE  '%$search%' OR

          AddingDroppingSubject.student_name  LIKE  '%$search%' OR
         
          AddingDroppingSubject.date          LIKE  '%$search%' OR
       
          AddingDroppingSubject.student_id    LIKE  '%$search%' 


        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
