<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class InterviewRequestsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('YearLevelTerms', ['foreignKey' => 'year_term_id',]);

    $this->belongsTo('CollegePrograms', ['foreignKey' => 'program_id',]);

    $this->belongsTo('Students', ['foreignKey' => 'student_id',]);

  }

  public function getAllInterviewRequestPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        InterviewRequest.*,

        CollegeProgram.name,

        YearLevelTerm.description

      FROM

        interview_requests as InterviewRequest LEFT JOIN

        college_programs as CollegeProgram ON InterviewRequest.program_id = CollegeProgram.id LEFT JOIN

        year_level_terms as YearLevelTerm ON InterviewRequest.year_term_id = YearLevelTerm.id

      WHERE

        InterviewRequest.visible = true $date $status $studentId  AND 

        (

          InterviewRequest.code         LIKE  '%$search%'  

        )

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllInterviewRequest($conditions=array()){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        InterviewRequest.*,

        CollegeProgram.name,

        YearLevelTerm.description

      FROM

        interview_requests as InterviewRequest LEFT JOIN

        college_programs as CollegeProgram ON InterviewRequest.program_id = CollegeProgram.id LEFT JOIN

        year_level_terms as YearLevelTerm ON InterviewRequest.year_term_id = YearLevelTerm.id

      WHERE

        InterviewRequest.visible = true $date $status $studentId  AND 

        (

          InterviewRequest.code         LIKE  '%$search%'  

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

    $result = $this->getAllInterviewRequest($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT

        count(*) as count

      FROM

        interview_requests as InterviewRequest LEFT JOIN

        college_programs as CollegeProgram ON InterviewRequest.program_id = CollegeProgram.id LEFT JOIN

        year_level_terms as YearLevelTerm ON InterviewRequest.year_term_id = YearLevelTerm.id

      WHERE

        InterviewRequest.visible = true $date $status $studentId  AND 

        (

          InterviewRequest.code         LIKE  '%$search%'  

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
