<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class CalendarActivitiesTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllCalendarActivityPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        CalendarActivity.*

      FROM

        calendar_activities as CalendarActivity 

      WHERE

        CalendarActivity.visible = true $date AND

        (

          CalendarActivity.code LIKE '%$search%' OR

          CalendarActivity.title LIKE '%$search%' OR

          CalendarActivity.remarks LIKE '%$search%'

        )

      ORDER BY 

        CalendarActivity.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCalendarActivity($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        CalendarActivity.*

      FROM

        calendar_activities as CalendarActivity 

      WHERE

        CalendarActivity.visible = true $date AND

        (

          CalendarActivity.code LIKE '%$search%' OR

          CalendarActivity.title LIKE '%$search%' OR

          CalendarActivity.remarks LIKE '%$search%'

        )

      GROUP BY

        CalendarActivity.id

      ORDER BY 

        CalendarActivity.code DESC

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

    $result = $this->getAllCalendarActivity($conditions, $limit, $page)->fetchAll('assoc');

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

        calendar_activities as CalendarActivity 

      WHERE

        CalendarActivity.visible = true $date AND

        (

          CalendarActivity.code LIKE '%$search%' OR

          CalendarActivity.title LIKE '%$search%' OR

          CalendarActivity.remarks LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
