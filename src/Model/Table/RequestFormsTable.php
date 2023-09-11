<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class RequestFormsTable extends Table{

  public function initialize(array $config): void{ 

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);
    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id', 

    ]);
   }

  public function getAllRequestFormPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "SELECT

        RequestForm.*,

        CollegeProgram.name as course

      FROM

        request_forms as RequestForm LEFT JOIN

        students as Student ON RequestForm.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON RequestForm.program_id = CollegeProgram.id

      WHERE

        RequestForm.visible = true $date $status $studentId AND

        (
 
          RequestForm.code LIKE  '%$search%' OR

          RequestForm.student_no LIKE  '%$search%' OR

          RequestForm.student_name LIKE  '%$search%' OR

          RequestForm.purpose LIKE  '%$search%'

        )

    ";


    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllRequestForm($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    // var_dump($status);

    $offset = ($page - 1) * $limit;

    $sql = "SELECT

        RequestForm.*,

        CollegeProgram.name as course

      FROM

        request_forms as RequestForm LEFT JOIN

        students as Student ON RequestForm.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON RequestForm.program_id = CollegeProgram.id

      WHERE

        RequestForm.visible = true $date $status $studentId AND

        (
 
          RequestForm.code LIKE  '%$search%' OR

          RequestForm.student_no LIKE  '%$search%' OR

          RequestForm.student_name LIKE  '%$search%' OR

          RequestForm.purpose LIKE  '%$search%'

        )

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

    $result = $this->getAllRequestForm($conditions, $limit, $page)->fetchAll('assoc');

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

    $date = @$conditions['date'];

        $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "SELECT

        count(*) as count

      FROM

        request_forms as RequestForm LEFT JOIN

        students as Student ON RequestForm.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON RequestForm.program_id = CollegeProgram.id

      WHERE

        RequestForm.visible = true $date $status $studentId AND

        (
 
          RequestForm.code LIKE  '%$search%' OR

          RequestForm.student_no LIKE  '%$search%' OR

          RequestForm.student_name LIKE  '%$search%' OR

          RequestForm.purpose LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
