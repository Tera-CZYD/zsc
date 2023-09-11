<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class GoodMoralsTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

    }

    public function getAllGoodMoral($conditions, $limit, $page){

      $search = @$conditions['search'];

      $college_id = @$conditions['college_id'];

      $offset = ($page - 1) * $limit;

      $date = @$conditions['date'];

      $sql = "

        SELECT

          GoodMoral.*

        FROM

          good_morals as GoodMoral 

        WHERE

          GoodMoral.visible = true $date AND

          (
   
            GoodMoral.code LIKE  '%$search%' OR

            GoodMoral.student_no LIKE  '%$search%' OR

            GoodMoral.student_name LIKE  '%$search%' 

          )

        ORDER BY 

          GoodMoral.code DESC
          
      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllGoodMoralPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

          GoodMoral.*

        FROM

          good_morals as GoodMoral 

        WHERE

          GoodMoral.visible = true $date AND

          (
   
            GoodMoral.code LIKE  '%$search%' OR

            GoodMoral.student_no LIKE  '%$search%' OR

            GoodMoral.student_name LIKE  '%$search%' 

          )

        ORDER BY 

          GoodMoral.code DESC
          
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

      $college_id = @$conditions['college_id'];

      $date = @$conditions['date'];

      $sql = "

        SELECT

          count(*) as total

        FROM

          good_morals as GoodMoral 

        WHERE

          GoodMoral.visible = true $date AND

          (
   
            GoodMoral.code LIKE  '%$search%' OR

            GoodMoral.student_no LIKE  '%$search%' OR

            GoodMoral.student_name LIKE  '%$search%' 

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }