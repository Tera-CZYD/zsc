<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class AttendanceCounselingsTable extends Table{

    public function initialize(array $config): void {

    $this->addBehavior('Timestamp');

    $this->belongsTo('CounselingAppointments', [

      'foreignKey' => 'counseling_appointment_id', 

    ]);
     

    }

  public function getAllAttendanceCounselingPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    // var_dump($status);

    $sql = "SELECT

        AttendanceCounseling.*,

        CounselingAppointment.student_name,

        CounselingType.name

      FROM

        attendance_counselings as AttendanceCounseling LEFT JOIN

        counseling_appointments as CounselingAppointment ON AttendanceCounseling.counseling_appointment_id = CounselingAppointment.id LEFT JOIN

        counseling_types as CounselingType ON CounselingAppointment.counseling_type_id = CounselingType.id

      WHERE

        AttendanceCounseling.visible = true $date AND

        CounselingAppointment.visible = true AND

        CounselingType.visible = true AND 

        (

          AttendanceCounseling.code LIKE '%$search%' OR

          AttendanceCounseling.location LIKE '%$search%' OR

          AttendanceCounseling.recommendation LIKE '%$search%' OR 

          CounselingAppointment.student_name LIKE '%$search%'

        )

      ORDER BY

        AttendanceCounseling.code DESC

    ";


    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAttendanceCounseling($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    // var_dump($status);

    $offset = ($page - 1) * $limit;

    $sql = "SELECT

        AttendanceCounseling.*,

        CounselingAppointment.student_name,

        CounselingType.name

      FROM

        attendance_counselings as AttendanceCounseling LEFT JOIN

        counseling_appointments as CounselingAppointment ON AttendanceCounseling.counseling_appointment_id = CounselingAppointment.id LEFT JOIN

        counseling_types as CounselingType ON CounselingAppointment.counseling_type_id = CounselingType.id

      WHERE

        AttendanceCounseling.visible = true $date AND

        CounselingAppointment.visible = true AND

        CounselingType.visible = true AND 

        (

          AttendanceCounseling.code LIKE '%$search%' OR

          AttendanceCounseling.location LIKE '%$search%' OR

          AttendanceCounseling.recommendation LIKE '%$search%' OR 

          CounselingAppointment.student_name LIKE '%$search%'

        )

      ORDER BY

        AttendanceCounseling.code DESC

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

    $result = $this->getAllAttendanceCounseling($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "SELECT

        count(*) as count

      FROM

        attendance_counselings as AttendanceCounseling LEFT JOIN

        counseling_appointments as CounselingAppointment ON AttendanceCounseling.counseling_appointment_id = CounselingAppointment.id LEFT JOIN

        counseling_types as CounselingType ON CounselingAppointment.counseling_type_id = CounselingType.id

      WHERE

        AttendanceCounseling.visible = true $date AND

        CounselingAppointment.visible = true AND

        CounselingType.visible = true AND 

        (

          AttendanceCounseling.code LIKE '%$search%' OR

          AttendanceCounseling.location LIKE '%$search%' OR

          AttendanceCounseling.recommendation LIKE '%$search%' OR 

          CounselingAppointment.student_name LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

  }