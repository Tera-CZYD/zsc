<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class PtcsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('PtcSubs', [

      'foreignKey' => 'ptc_id', 

    ]);

  }

    public function getAllPtcPrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        Ptc.*

      FROM

        ptcs as Ptc  

      WHERE

        Ptc.visible = true AND

        (

          Ptc.code LIKE '%$search%'

        )
 
      ORDER BY 

        Ptc.id DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllPtc($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Ptc.*

      FROM

        ptcs as Ptc  

      WHERE

        Ptc.visible = true AND

        (

          Ptc.code LIKE '%$search%'

        )
 
      ORDER BY 

        Ptc.id DESC

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

    $result = $this->getAllPtc($conditions, $limit, $page)->fetchAll('assoc');

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

        count(*) as count

      FROM

        ptcs as Ptc  

      WHERE

        Ptc.visible = true AND

        (

          Ptc.code LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
