<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class ItemIssuancesTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

    }

    public function getAllItemIssuance($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $sql = "

        SELECT

        ItemIssuance.*

        FROM

          item_issuances as ItemIssuance 

        WHERE

          ItemIssuance.visible = true $date $status AND

          (

            ItemIssuance.code LIKE  '%$search%' OR

            ItemIssuance.dental LIKE  '%$search%' OR

            ItemIssuance.consultation LIKE  '%$search%'

          )

        ORDER BY 

          ItemIssuance.code DESC
          
      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllItemIssuancePrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $sql = "

        SELECT

        ItemIssuance.*

        FROM

          item_issuances as ItemIssuance 

        WHERE

          ItemIssuance.visible = true $date $status AND

          (

            ItemIssuance.code LIKE  '%$search%' OR

            ItemIssuance.dental LIKE  '%$search%' OR

            ItemIssuance.consultation LIKE  '%$search%'

          )

        ORDER BY 

          ItemIssuance.code DESC
          
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

      $result = $this->getAllItemIssuance($conditions, $limit, $page)->fetchAll('assoc');

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

      $sql = "

        SELECT

        count(*) as total

        FROM

          item_issuances as ItemIssuance 

        WHERE

          ItemIssuance.visible = true $date $status AND

          (

            ItemIssuance.code LIKE  '%$search%' OR

            ItemIssuance.dental LIKE  '%$search%' OR

            ItemIssuance.consultation LIKE  '%$search%'

          )

      ";
    
      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }