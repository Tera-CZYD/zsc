<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class EmployeesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Colleges', [

     'foreignKey' => 'college_id',

     'propertyName' => 'College',

    ]);

    $this->belongsTo('Specializations', [

     'foreignKey' => 'specialization_id'

    ]);

    $this->belongsTo('AcademicRanks', [

     'foreignKey' => 'academic_rank_id'

    ]);

  }

  public function getAllEmployeePrint($conditions){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $specialization_id = @$conditions['specialization_id'];

    $sql = "

       SELECT

        Employee.*,

        Specialization.name as specialization,

        CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name,

        CONCAT(College.code,' - ',College.name) as college,

        AcademicRank.rank as academic_rank

      FROM

        employees as Employee LEFT JOIN

        colleges as College ON Employee.college_id =  College.id LEFT JOIN 

        specializations as Specialization ON Employee.specialization_id = Specialization.id LEFT JOIN 

        academic_ranks AcademicRank ON Employee.academic_rank_id = AcademicRank.id

      WHERE

        Employee.visible = true $college_id $specialization_id AND

        Employee.active = true AND

        College.visible = true AND

        (

          Employee.code     LIKE  '%$search%' OR

          Employee.family_name     LIKE  '%$search%' OR

          Employee.given_name     LIKE  '%$search%' OR

          Employee.middle_name     LIKE  '%$search%' OR

          College.code     LIKE  '%$search%' OR

          College.name     LIKE  '%$search%'

        )

      GROUP BY

        Employee.id

      ORDER BY 

        full_name ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllEmployee($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $specialization_id = @$conditions['specialization_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Employee.*,

        Specialization.name as specialization,

        CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name,

        CONCAT(College.code,' - ',College.name) as college,

        AcademicRank.rank as academic_rank

      FROM

        employees as Employee LEFT JOIN

        colleges as College ON Employee.college_id =  College.id LEFT JOIN 

        specializations as Specialization ON Employee.specialization_id = Specialization.id LEFT JOIN 

        academic_ranks AcademicRank ON Employee.academic_rank_id = AcademicRank.id

      WHERE

        Employee.visible = true $college_id $specialization_id AND

        Employee.active = true AND

        College.visible = true AND

        (

          Employee.code     LIKE  '%$search%' OR

          Employee.family_name     LIKE  '%$search%' OR

          Employee.given_name     LIKE  '%$search%' OR

          Employee.middle_name     LIKE  '%$search%' OR

          College.code     LIKE  '%$search%' OR

          College.name     LIKE  '%$search%'

        )

      GROUP BY

        Employee.id

      ORDER BY 

        full_name ASC

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

    $result = $this->getAllEmployee($conditions, $limit, $page)->fetchAll('assoc');

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

    $term_id = @$conditions['term_id'];

    $college_id = @$conditions['college_id'];

    $department_id = @$conditions['department_id'];

    $program_id = @$conditions['program_id'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        employees as Employee LEFT JOIN

        colleges as College ON Employee.college_id =  College.id

      WHERE

        Employee.visible = true $college_id AND

        Employee.active = true AND

        College.visible = true AND

        (

          Employee.code     LIKE  '%$search%' OR

          Employee.family_name     LIKE  '%$search%' OR

          Employee.given_name     LIKE  '%$search%' OR

          Employee.middle_name     LIKE  '%$search%' OR

          College.code     LIKE  '%$search%' OR

          College.name     LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
