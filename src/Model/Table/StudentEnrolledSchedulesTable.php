<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class StudentEnrolledSchedulesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('BlockSectionSchedules', [

      'foreignKey' => 'block_section_schedule_id', 

    ]);

  }

  public function getAllStudentEnrolledSchedule($conditions=array()){

    $search = @$conditions['search'];

    $student = $conditions['student_id'];

    $sql = "

      SELECT

        StudentEnrolledSchedule.*,

        Course.code

      FROM

        student_enrolled_schedules as StudentEnrolledSchedule LEFT JOIN 

        courses as Course ON StudentEnrolledSchedule.course_id = Course.id

      WHERE

       StudentEnrolledSchedule.visible = true $student
        
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

    $result = $this->getAllStudentEnrolledSchedule($conditions, $limit, $page)->fetchAll('assoc');

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

    $student = $conditions['student_id'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        student_enrolled_schedules as StudentEnrolledSchedule LEFT JOIN 

        courses as Course ON StudentEnrolledSchedule.course_id = Course.id

      WHERE

       StudentEnrolledSchedule.visible = true $student

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');
    // var_dump($query);

    return $query['count'];

  }


}
