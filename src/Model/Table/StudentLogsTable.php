<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class StudentLogsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }


  public function getAllStudentLogPrint($conditions){

    $search = @$conditions['search'];


    $sql = "

      SELECT

        StudentLog.*


      FROM

        student_logs as StudentLog  

      WHERE

        StudentLog.visible = true AND

        (

          StudentLog.student_name         LIKE  '%$search%' OR

          StudentLog.date                 LIKE  '%$search%' OR

          StudentLog.time                 LIKE  '%$search%' OR

          StudentLog.concern              LIKE  '%$search%' 

        )
 
      ORDER BY 

        StudentLog.student_name ASC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }
  public function getAllStudentLog($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        StudentLog.*


      FROM

        student_logs as StudentLog  

      WHERE

        StudentLog.visible = true AND

        (

          StudentLog.student_name         LIKE  '%$search%' OR

          StudentLog.date                 LIKE  '%$search%' OR

          StudentLog.time                 LIKE  '%$search%' OR

          StudentLog.concern              LIKE  '%$search%' 

        )
 
      ORDER BY 

        StudentLog.student_name ASC
        
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

    $result = $this->getAllStudentLog($conditions, $limit, $page)->fetchAll('assoc');

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

        student_logs as StudentLog

      WHERE

        StudentLog.visible = true AND

        (

          StudentLog.student_name         LIKE  '%$search%' OR

          StudentLog.date                 LIKE  '%$search%' OR

          StudentLog.time                 LIKE  '%$search%' OR

          StudentLog.concern              LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
