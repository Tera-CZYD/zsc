<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class AppointmentSlipsTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id',

      'propertyName' => 'Student'

    ]);


  }

  public function getAllAppointmentSlipPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        AppointmentSlip.*

      FROM

        appointment_slips as AppointmentSlip 

      WHERE

        AppointmentSlip.visible = true $date AND

        (

          AppointmentSlip.code LIKE '%$search%' OR

          AppointmentSlip.student_name LIKE '%$search%' OR

          AppointmentSlip.student_no LIKE '%$search%' OR 

          AppointmentSlip.purpose LIKE '%$search%'

        )

      ORDER BY 

        AppointmentSlip.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAppointmentSlip($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        AppointmentSlip.*

      FROM

        appointment_slips as AppointmentSlip 

      WHERE

        AppointmentSlip.visible = true $date AND

        (

          AppointmentSlip.code LIKE '%$search%' OR

          AppointmentSlip.student_name LIKE '%$search%' OR

          AppointmentSlip.student_no LIKE '%$search%' OR 

          AppointmentSlip.purpose LIKE '%$search%'

        )

      GROUP BY

        AppointmentSlip.id

      ORDER BY 

        AppointmentSlip.code DESC

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

    $result = $this->getAllAppointmentSlip($conditions, $limit, $page)->fetchAll('assoc');

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

        appointment_slips as AppointmentSlip 

      WHERE

        AppointmentSlip.visible = true $date AND

        (

          AppointmentSlip.code LIKE '%$search%' OR

          AppointmentSlip.student_name LIKE '%$search%' OR

          AppointmentSlip.student_no LIKE '%$search%' OR 

          AppointmentSlip.purpose LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
