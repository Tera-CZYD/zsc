<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class NurseProfilesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }


   public function getAllNurseProfilePrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT 

      NurseProfile.*

    FROM 

      nurse_profiles as NurseProfile 

    WHERE 

      NurseProfile.visible = true AND 

      (

        NurseProfile.name               LIKE      '%$search%'     OR

        NurseProfile.address            LIKE      '%$search%'     OR

        NurseProfile.age                LIKE      '%$search%'     OR

        NurseProfile.birthdate          LIKE      '%$search%' 

      )

    ORDER BY 

      NurseProfile.id ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllNurseProfile($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

      NurseProfile.*

    FROM 

      nurse_profiles as NurseProfile 

    WHERE 

      NurseProfile.visible = true AND 

      (

        NurseProfile.name               LIKE      '%$search%'     OR

        NurseProfile.address            LIKE      '%$search%'     OR

        NurseProfile.age                LIKE      '%$search%'     OR

        NurseProfile.birthdate          LIKE      '%$search%' 

      )

    ORDER BY 

      NurseProfile.id ASC

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

    $result = $this->getAllNurseProfile($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT

        count(*) as count

       FROM

        nurse_profiles as NurseProfile 

    WHERE 

      NurseProfile.visible = true AND 

      (

        NurseProfile.name               LIKE      '%$search%'     OR

        NurseProfile.address            LIKE      '%$search%'     OR

        NurseProfile.age                LIKE      '%$search%'     OR

        NurseProfile.birthdate          LIKE      '%$search%' 

      )

    ORDER BY 

      NurseProfile.id ASC

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
