<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class ParticipantEvaluationActivitiesTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'course_id',

      'propertyName' => 'CollegeProgram'

    ]);

  }

  public function getAllParticipantEvaluationActivityPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT 

      ParticipantEvaluationActivity.*,

      CollegeProgram.name as program_name

    FROM 

      participant_evaluation_activities as ParticipantEvaluationActivity LEFT JOIN 

      college_programs as CollegeProgram ON ParticipantEvaluationActivity.course_id = CollegeProgram.id

    WHERE 

      ParticipantEvaluationActivity.visible = true AND 

      (

        ParticipantEvaluationActivity.activity        LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.date            LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.venue           LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.course_id       LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.year            LIKE      '%$search%'     

      )

      ORDER BY 

        ParticipantEvaluationActivity.id ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllParticipantEvaluationActivity($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

      ParticipantEvaluationActivity.*,

      CollegeProgram.name as program_name

    FROM 

      participant_evaluation_activities as ParticipantEvaluationActivity LEFT JOIN 

      college_programs as CollegeProgram ON ParticipantEvaluationActivity.course_id = CollegeProgram.id

    WHERE 

      ParticipantEvaluationActivity.visible = true AND 

      (

        ParticipantEvaluationActivity.activity        LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.date            LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.venue           LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.course_id       LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.year            LIKE      '%$search%'     

      )

      GROUP BY

        ParticipantEvaluationActivity.id

      ORDER BY 

        ParticipantEvaluationActivity.id ASC

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

    $result = $this->getAllParticipantEvaluationActivity($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT

        count(*) as count

      FROM 

      participant_evaluation_activities as ParticipantEvaluationActivity LEFT JOIN 

      college_programs as CollegeProgram ON ParticipantEvaluationActivity.course_id = CollegeProgram.id

    WHERE 

      ParticipantEvaluationActivity.visible = true AND 

      (

        ParticipantEvaluationActivity.activity        LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.date            LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.venue           LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.course_id       LIKE      '%$search%'     OR

        ParticipantEvaluationActivity.year            LIKE      '%$search%'     

      )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
