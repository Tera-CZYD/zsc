<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class UserLogsTable extends Table{

    public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllUserLogs($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        UserLog.*,

        User.*,

        CONCAT(User.last_name, ', ', User.first_name,'', IFNULL(CONCAT(' ',User.middle_name), '')) as full_name

      FROM

        user_logs as UserLog LEFT JOIN

        users as User ON User.id = UserLog.userId

      WHERE

        User.visible = true $date AND

        UserLog.visible = true AND

        (

          User.last_name          LIKE  '%$search%' OR 

          User.first_name         LIKE  '%$search%' OR 

          UserLog.action      LIKE  '%$search%' OR 

          UserLog.description LIKE  '%$search%' OR 

          UserLog.code        LIKE  '%$search%' OR 

          UserLog.created     LIKE  '%$search%'

        )

      ORDER BY 

        UserLog.created DESC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllUserLogPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        Apartelle.*

      FROM

        apartelles as Apartelle 

      WHERE

        Apartelle.visible = true $date AND

        (
 
          Apartelle.code LIKE  '%$search%' OR

          Apartelle.building_no LIKE  '%$search%' OR

          Apartelle.room_no LIKE  '%$search%' OR

          Apartelle.description LIKE  '%$search%' OR

          Apartelle.capacity LIKE  '%$search%' 

        )

      ORDER BY 

        Apartelle.code DESC
        
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

    $result = $this->getAllUserLogs($conditions, $limit, $page)->fetchAll('assoc');

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

    $college_id = @$conditions['college_id'];

    $date =@$conditions['date'];

    $sql = "

      SELECT

        count(*) as total

      FROM

        user_logs as UserLog LEFT JOIN

        users as User ON User.id = UserLog.userId

      WHERE

        User.visible = true $date AND

        UserLog.visible = true AND

        (

          User.last_name          LIKE  '%$search%' OR 

          User.first_name         LIKE  '%$search%' OR 

          UserLog.action      LIKE  '%$search%' OR 

          UserLog.description LIKE  '%$search%' OR 

          UserLog.code        LIKE  '%$search%' OR 

          UserLog.created     LIKE  '%$search%'

        )

    ";


    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['total'];

  }

  }