<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class ScholarshipNamesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllScholarshipNamePrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        ScholarshipName.*

      FROM

        scholarship_names as ScholarshipName

      WHERE

        ScholarshipName.visible = true AND 

        (


          ScholarshipName.scholarship_name         LIKE  '%$search%'

        )

      GROUP BY

        ScholarshipName.id

      ORDER BY 

        ScholarshipName.scholarship_name ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllScholarshipName($conditions, $limit, $page){

    $search = @$conditions['search'];

    // $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        ScholarshipName.*

      FROM

        scholarship_names as ScholarshipName

      WHERE

        ScholarshipName.visible = true AND 

        (


          ScholarshipName.scholarship_name         LIKE  '%$search%'

        )

      GROUP BY

        ScholarshipName.id

      ORDER BY 

        ScholarshipName.scholarship_name ASC

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

    $result = $this->getAllScholarshipName($conditions, $limit, $page)->fetchAll('assoc');

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

    // $college_id = @$conditions['college_id'];

    $sql = "

      SELECT

        count(*) as count

       FROM

        scholarship_names as ScholarshipName 

      WHERE

        ScholarshipName.visible = true AND 

        (

          ScholarshipName.scholarship_name         LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
