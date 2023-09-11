<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class IllnessRecommendationsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('IllnessRecommendationSubs', [

      'foreignKey' => 'illness_recommendation_id', 

    ]);

  }

  public function getAllIllnessRecommendationPrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        IllnessRecommendation.*

      FROM

        illness_recommendations as IllnessRecommendation 

      WHERE

        IllnessRecommendation.visible = true AND

        (

          IllnessRecommendation.ailment LIKE  '%$search%' OR

          IllnessRecommendation.description LIKE  '%$search%'

        )

      GROUP BY

        IllnessRecommendation.id

      ORDER BY 

        IllnessRecommendation.id ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllIllnessRecommendation($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        IllnessRecommendation.*

      FROM

        illness_recommendations as IllnessRecommendation 

      WHERE

        IllnessRecommendation.visible = true AND

        (

          IllnessRecommendation.ailment LIKE  '%$search%' OR

          IllnessRecommendation.description LIKE  '%$search%'

        )

      GROUP BY

        IllnessRecommendation.id

      ORDER BY 

        IllnessRecommendation.id ASC

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

    $result = $this->getAllIllnessRecommendation($conditions, $limit, $page)->fetchAll('assoc');

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

        illness_recommendations as IllnessRecommendation

      WHERE

        IllnessRecommendation.visible = true AND

        (

          IllnessRecommendation.ailment LIKE  '%$search%' OR

          IllnessRecommendation.description LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
