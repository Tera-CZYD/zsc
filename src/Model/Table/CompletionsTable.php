<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class CompletionsTable extends Table{

  public function initialize(array $config): void{ 

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);
   }

  public function getAllCompletionPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "SELECT

        Completion.*


      FROM

        completions as Completion LEFT JOIN

        students as Student ON Completion.student_id = Student.id

      WHERE

      Completion.visible = 1 $date AND

        (
 
            Completion.code LIKE  '%$search%' OR

            Completion.student_no LIKE  '%$search%' OR

            Completion.student_name LIKE  '%$search%' OR

            Completion.year LIKE  '%$search%'

            -- Consultation.description LIKE  '%$search%'

        )

      ORDER BY 

      Completion.code DESC
        
    ";


    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllCompletion($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "SELECT

        Completion.*


      FROM

        completions as Completion LEFT JOIN

        students as Student ON Completion.student_id = Student.id

      WHERE

      Completion.visible = true $date AND

        (
 
            Completion.code LIKE  '%$search%' OR

            Completion.student_no LIKE  '%$search%' OR

            Completion.student_name LIKE  '%$search%' OR

            Completion.year LIKE  '%$search%'

            -- Consultation.description LIKE  '%$search%'

        )

      ORDER BY 

      Completion.code DESC
        
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

    $result = $this->getAllCompletion($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "SELECT

        count(*) as count

      FROM

        completions as Completion LEFT JOIN

        students as Student ON Completion.student_id = Student.id

      WHERE

      Completion.visible = true $date AND

        (
 
          Completion.code LIKE  '%$search%' OR

          Completion.student_no LIKE  '%$search%' OR

          Completion.student_name LIKE  '%$search%' OR

          Completion.year LIKE  '%$search%'

          -- MedicalCertificate.description LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
