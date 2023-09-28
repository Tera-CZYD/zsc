<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class AffidavitOfLossesTable extends Table{

  public function initialize(array $config): void {

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id', 

    ]);


  }

  public function getAllAffidavitOfLossPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        AffidavitOfLoss.*

      FROM

        affidavit_of_losses as AffidavitOfLoss LEFT JOIN

        students as Student ON AffidavitOfLoss.student_id = Student.id

      WHERE

        AffidavitOfLoss.visible = true $date $status $studentId AND

        (

          AffidavitOfLoss.code LIKE '%$search%' OR

          AffidavitOfLoss.student_name LIKE '%$search%' OR 

          AffidavitOfLoss.description LIKE '%$search%'

        )

      ORDER BY

        AffidavitOfLoss.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAffidavitOfLoss($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        AffidavitOfLoss.*

      FROM

        affidavit_of_losses as AffidavitOfLoss LEFT JOIN

        students as Student ON AffidavitOfLoss.student_id = Student.id

      WHERE

        AffidavitOfLoss.visible = true $date $status $studentId AND

        (

          AffidavitOfLoss.code LIKE '%$search%' OR

          AffidavitOfLoss.student_name LIKE '%$search%' OR 

          AffidavitOfLoss.description LIKE '%$search%'

        )

      ORDER BY

        AffidavitOfLoss.code DESC


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

    $result = $this->getAllAffidavitOfLoss($conditions, $limit, $page)->fetchAll('assoc');

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

        affidavit_of_losses as AffidavitOfLoss LEFT JOIN

        students as Student ON AffidavitOfLoss.student_id = Student.id

      WHERE

        AffidavitOfLoss.visible = true $date $status $studentId AND

        (

          AffidavitOfLoss.code LIKE '%$search%' OR

          AffidavitOfLoss.student_name LIKE '%$search%' OR 

          AffidavitOfLoss.description LIKE '%$search%'

        )


    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}