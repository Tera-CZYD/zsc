<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class SettingsTable extends Table{

    public function initialize(array $config): void{}

  public function getAllSettings($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Settings.*


      FROM

        settings as Settings  

      WHERE

        Settings.visible = true AND

        (

          Settings.id LIKE '%$search%' OR

          Settings.code LIKE '%$search%' OR

          Settings.value LIKE '%$search%' OR

          Settings.name LIKE '%$search%'

        )
 
      ORDER BY 

        Settings.id ASC
        
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

    $result = $this->getAllSettings($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT

        count(*) as total

      FROM

        settings as Settings  

      WHERE

        Settings.visible = true AND

        (

          Settings.id LIKE '%$search%' OR

          Settings.code LIKE '%$search%' OR

          Settings.value LIKE '%$search%' OR

          Settings.name LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['total'];

  }

  }