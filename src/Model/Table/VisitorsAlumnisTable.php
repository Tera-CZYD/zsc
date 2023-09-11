<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class VisitorsAlumnisTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllVisitorsAlumni($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        VisitorsAlumni.*


      FROM

        visitors_alumnis as VisitorsAlumni  

      WHERE

        VisitorsAlumni.visible = true AND

        (

          VisitorsAlumni.name LIKE '%$search%' OR

          VisitorsAlumni.name_of_school LIKE '%$search%' 

        )
 
      ORDER BY 

        VisitorsAlumni.name ASC

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

    $result = $this->getAllVisitorsAlumni($conditions, $limit, $page)->fetchAll('assoc');

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

        visitors_alumnis as VisitorsAlumni  

      WHERE

        VisitorsAlumni.visible = true AND

        (

          VisitorsAlumni.name LIKE '%$search%' OR

          VisitorsAlumni.name_of_school LIKE '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
