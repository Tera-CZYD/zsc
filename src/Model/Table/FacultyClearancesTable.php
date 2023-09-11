<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class FacultyClearancesTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Employees', [

      'foreignKey' => 'employee_id'

    ]);

  }

  public function getAllFacultyClearancePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        FacultyClearance.*

      FROM

        faculty_clearances as FacultyClearance

      WHERE

        FacultyClearance.visible = true $date AND 

        (

        FacultyClearance.code         LIKE  '%$search%' OR

        FacultyClearance.faculty_name         LIKE  '%$search%' OR

        FacultyClearance.request         LIKE  '%$search%'

        )

      ORDER BY 

        FacultyClearance.code ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllFacultyClearance($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        FacultyClearance.*

      FROM

        faculty_clearances as FacultyClearance

      WHERE

        FacultyClearance.visible = true $date AND 

        (

        FacultyClearance.code         LIKE  '%$search%' OR

        FacultyClearance.faculty_name         LIKE  '%$search%' OR

        FacultyClearance.request LIKE  '%$search%'

        )

      GROUP BY

        FacultyClearance.id

      ORDER BY 

        FacultyClearance.code ASC

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

    $result = $this->getAllFacultyClearance($conditions, $limit, $page)->fetchAll('assoc');

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

        faculty_clearances as FacultyClearance 

      WHERE

        FacultyClearance.visible = true $date AND 

        (

            FacultyClearance.code         LIKE  '%$search%' OR

            FacultyClearance.faculty_name         LIKE  '%$search%' OR

            FacultyClearance.request         LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
