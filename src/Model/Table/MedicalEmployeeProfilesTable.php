<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class MedicalEmployeeProfilesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Colleges', [

      'foreignKey' => 'college_id', 

    ]);

    $this->hasMany('EmployeeFiles', [

      'foreignKey' => 'employee_profile_id', 

    ]);

  }

  public function getAllMedicalEmployeeProfile($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

      MedicalEmployeeProfile.*

    FROM 

      medical_employee_profiles as MedicalEmployeeProfile 

    WHERE 

      MedicalEmployeeProfile.visible = true AND 

      (

        MedicalEmployeeProfile.employee_name        LIKE      '%$search%'     OR

        MedicalEmployeeProfile.address            LIKE      '%$search%'     OR

        MedicalEmployeeProfile.code       LIKE    '%$search%'

      )

    ORDER BY 

      MedicalEmployeeProfile.id ASC

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

    $result = $this->getAllMedicalEmployeeProfile($conditions, $limit, $page)->fetchAll('assoc');

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

  public function getAllMedicalEmployeeProfilePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT 

      MedicalEmployeeProfile.*

    FROM 

      medical_employee_profiles as MedicalEmployeeProfile 

    WHERE 

      MedicalEmployeeProfile.visible = true AND 

      (

        MedicalEmployeeProfile.employee_name        LIKE      '%$search%'     OR

        MedicalEmployeeProfile.address            LIKE      '%$search%'     OR

        MedicalEmployeeProfile.code       LIKE    '%$search%'

      )

    ORDER BY 

      MedicalEmployeeProfile.id ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function paginateCount($conditions = null){ 

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $date = @$conditions['date'];

    $sql = "

      SELECT 

      count(*) as total 

    FROM

      medical_employee_profiles as MedicalEmployeeProfile 

    WHERE 

      MedicalEmployeeProfile.visible = true AND 

      (

        MedicalEmployeeProfile.employee_name        LIKE      '%$search%'     OR

        MedicalEmployeeProfile.address            LIKE      '%$search%'     OR

        MedicalEmployeeProfile.code       LIKE    '%$search%'  

      )

    "; 

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['total'];

  }

}
