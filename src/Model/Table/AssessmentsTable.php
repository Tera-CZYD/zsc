<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AssessmentsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('AssessmentSubs', [

      'foreignKey' => 'assessment_id', 

    ]);

    // $this->belongsTo('Students', [

    //   'foreignKey' => 'student_id', 

    // ]);

  }

  public function getAllAssessmentPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $sql = "

      SELECT 

        Assessment.*

      FROM 

        assessments as Assessment 

      WHERE 

        Assessment.visible = true $date $status AND

      (

        Assessment.code LIKE '%$search%' OR

        Assessment.student_name LIKE '%$search%' OR

        Assessment.student_no LIKE '%$search%' OR

        Assessment.email LIKE '%$search%' OR

        Assessment.contact_no LIKE '%$search%' 

      )

      ORDER BY 

      Assessment.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAssessment($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

        Assessment.*

      FROM 

        assessments as Assessment 

      WHERE 

        Assessment.visible = true $date $status AND

      (

        Assessment.code LIKE '%$search%' OR

        Assessment.student_name LIKE '%$search%' OR

        Assessment.student_no LIKE '%$search%' OR

        Assessment.email LIKE '%$search%' OR

        Assessment.contact_no LIKE '%$search%' 

      )

      ORDER BY 

        Assessment.code DESC

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

    $result = $this->getAllAssessment($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT 

        count(*) as count

      FROM 

        assessments as Assessment 

      WHERE

        Assessment.visible = true $date $status AND

      (

        Assessment.code LIKE '%$search%' OR

        Assessment.student_name LIKE '%$search%' OR

        Assessment.student_no LIKE '%$search%' OR

        Assessment.email LIKE '%$search%' OR

        Assessment.contact_no LIKE '%$search%' 

      )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
