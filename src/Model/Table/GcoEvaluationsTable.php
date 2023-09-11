<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class GcoEvaluationsTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id',

    ]);

    $this->belongsTo('AttendanceCounselings', [

      'foreignKey' => 'attendance_counseling_id',

    ]);

    // $this->belongsTo('CounselingAppointments', [

    //   'foreignKey' => 'attendance_counseling_id',

    // ]);

  }

  public function getAllGcoEvaluationPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        GcoEvaluation.*,

        AttendanceCounseling.code as attendanceCode

      FROM

        gco_evaluations as GcoEvaluation LEFT JOIN

        attendance_counselings as AttendanceCounseling ON AttendanceCounseling.id = GcoEvaluation.attendance_counseling_id

      WHERE

        GcoEvaluation.visible = true $date $studentId AND

        AttendanceCounseling.visible = true AND

        (

          GcoEvaluation.code LIKE '%$search%' OR

          GcoEvaluation.student_no LIKE '%$search%' OR

          GcoEvaluation.student_name LIKE '%$search%' OR 

          AttendanceCounseling.code LIKE '%$search%'

        )

      ORDER BY 

        GcoEvaluation.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllGcoEvaluation($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        GcoEvaluation.*,

        AttendanceCounseling.code as attendanceCode

      FROM

        gco_evaluations as GcoEvaluation LEFT JOIN

        attendance_counselings as AttendanceCounseling ON AttendanceCounseling.id = GcoEvaluation.attendance_counseling_id

      WHERE

        GcoEvaluation.visible = true $date $studentId AND

        AttendanceCounseling.visible = true AND

        (

          GcoEvaluation.code LIKE '%$search%' OR

          GcoEvaluation.student_no LIKE '%$search%' OR

          GcoEvaluation.student_name LIKE '%$search%' OR 

          AttendanceCounseling.code LIKE '%$search%'

        )

      GROUP BY

        GcoEvaluation.id

      ORDER BY 

        GcoEvaluation.code DESC

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

    $result = $this->getAllGcoEvaluation($conditions, $limit, $page)->fetchAll('assoc');

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

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        gco_evaluations as GcoEvaluation LEFT JOIN

        attendance_counselings as AttendanceCounseling ON AttendanceCounseling.id = GcoEvaluation.attendance_counseling_id

      WHERE

        GcoEvaluation.visible = true $date $studentId AND

        AttendanceCounseling.visible = true AND

        (

          GcoEvaluation.code LIKE '%$search%' OR

          GcoEvaluation.student_no LIKE '%$search%' OR

          GcoEvaluation.student_name LIKE '%$search%' OR 

          AttendanceCounseling.code LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
