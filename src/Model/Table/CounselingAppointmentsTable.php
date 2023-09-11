<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class CounselingAppointmentsTable extends Table{

  public function initialize(array $config): void {

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);

    $this->belongsTo('CounselingTypes', [

      'foreignKey' => 'counseling_type_id', 

    ]);

  }

  public function getAllCounselingAppointmentPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    // var_dump($status);

    $sql = "

      SELECT

        CounselingAppointment.*,

        CounselingType.name

      FROM

        counseling_appointments as CounselingAppointment LEFT JOIN

        counseling_types as CounselingType ON CounselingAppointment.counseling_type_id = CounselingType.id

      WHERE

        CounselingAppointment.visible = true $date $status $studentId AND

        CounselingType.visible = true AND

        (

          CounselingAppointment.code LIKE '%$search%' OR

          CounselingAppointment.counselor_name LIKE '%$search%' OR

          CounselingAppointment.student_name LIKE '%$search%' OR 

          CounselingAppointment.description LIKE '%$search%'

        )

      ORDER BY

        CounselingAppointment.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCounselingAppointment($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    // var_dump($status);

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        CounselingAppointment.*,

        CounselingType.name

      FROM

        counseling_appointments as CounselingAppointment LEFT JOIN

        counseling_types as CounselingType ON CounselingAppointment.counseling_type_id = CounselingType.id

      WHERE

        CounselingAppointment.visible = true $date $status $studentId AND

        CounselingType.visible = true AND

        (

          CounselingAppointment.code LIKE '%$search%' OR

          CounselingAppointment.counselor_name LIKE '%$search%' OR

          CounselingAppointment.student_name LIKE '%$search%' OR 

          CounselingAppointment.description LIKE '%$search%'

        )

      ORDER BY

        CounselingAppointment.code DESC


      LIMIT

        $limit OFFSET $offset ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function paginate($query, array $options = []){

    $extra = isset($options['extra']) ? $options['extra'] : [];

    $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

    $page = $options['page'];

    $limit = $options['limit'];

    $result = $this->getAllCounselingAppointment($conditions, $limit, $page)->fetchAll('assoc');

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

        counseling_appointments as CounselingAppointment LEFT JOIN

        counseling_types as CounselingType ON CounselingAppointment.counseling_type_id = CounselingType.id

      WHERE

        CounselingAppointment.visible = true $date $status $studentId AND

        CounselingType.visible = true AND

        (

          CounselingAppointment.code LIKE '%$search%' OR

          CounselingAppointment.counselor_name LIKE '%$search%' OR

          CounselingAppointment.student_name LIKE '%$search%' OR 

          CounselingAppointment.description LIKE '%$search%'

        )


    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}