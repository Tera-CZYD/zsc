<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AdmissionStatusesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllAdmissionStatus($conditions, $limit, $page){

    $search = @$conditions['search'];

    // $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        AdmissionStatus.*

      FROM

        admission_statuses as AdmissionStatus

      WHERE

        AdmissionStatus.visible = true AND 

        (


          AdmissionStatus.status         LIKE  '%$search%'

        )

      GROUP BY

        AdmissionStatus.id

      ORDER BY 

        AdmissionStatus.status ASC

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

    $result = $this->getAllAdmissionStatus($conditions, $limit, $page)->fetchAll('assoc');

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

        admission_statuses as AdmissionStatus 

      WHERE

        AdmissionStatus.visible = true AND 

        (

          AdmissionStatus.status         LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
