<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class StudentAttendancesTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

    }

    public function getAllStudentAttendance($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

          StudentAttendance.*

        FROM

          student_attendances as StudentAttendance LEFT JOIN

          class_schedule_days as ClassScheduleDay ON StudentAttendance.student_id = ClassScheduleDay.id 

        WHERE

        StudentAttendance.visible = true $date $status $studentId AND
        

          -- (

          --   Consultation.code LIKE  '%$search%' OR

          --   Consultation.student_no LIKE  '%$search%' OR

          --   Consultation.student_name LIKE  '%$search%' 

          -- )

        ORDER BY 

        StudentAttendance.id DESC
          
      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllStudentAttendancePrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

          StudentAttendance.*

        FROM

          student_attendances as StudentAttendance LEFT JOIN

          class_schedule_days as ClassScheduleDay ON StudentAttendance.student_id = ClassScheduleDay.id 

        WHERE

        StudentAttendance.visible = true $date $status $studentId AND
        

          -- (

          --   Consultation.code LIKE  '%$search%' OR

          --   Consultation.student_no LIKE  '%$search%' OR

          --   Consultation.student_name LIKE  '%$search%' 

          -- )

        ORDER BY 

        StudentAttendance.id DESC
          
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

      $result = $this->getAllGoodMoral($conditions, $limit, $page)->fetchAll('assoc');

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

          count(*) as total

        FROM

          student_attendances as StudentAttendance LEFT JOIN

          class_schedule_days as Student ON StudentAttendance.student_id = StudentAttendance.id

        WHERE

        StudentAttendance.visible = true $date $status $studentId AND

          -- (
   
          --   Consultation.code LIKE  '%$search%' OR

          --   Consultation.student_no LIKE  '%$search%' OR

          --   Consultation.student_name LIKE  '%$search%'

          -- )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }