<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AdminsTable extends Table{

  public function initialize(array $config): void{}

  public function getAllAdmin($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Admin.*,

        CONCAT(IFNULL(Admin.last_name,''),', ',IFNULL(Admin.first_name,''),' ',IFNULL(Admin.middle_name,'')) as full_name

      FROM

        admins as Admin  

      WHERE

        Admin.visible = true AND

        (

          Admin.employee_no LIKE '%$search%' OR

          Admin.first_name LIKE '%$search%' OR

          Admin.middle_name LIKE '%$search%' OR

          Admin.last_name LIKE '%$search%' OR

          Admin.department LIKE '%$search%'

        )
 
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

    $result = $this->getAllAdmin($conditions, $limit, $page)->fetchAll('assoc');

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

        admins as Admin  

      WHERE

        Admin.visible = true AND

        (

          Admin.employee_no LIKE '%$search%' OR

          Admin.first_name LIKE '%$search%' OR

          Admin.middle_name LIKE '%$search%' OR

          Admin.last_name LIKE '%$search%' OR

          Admin.department LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
