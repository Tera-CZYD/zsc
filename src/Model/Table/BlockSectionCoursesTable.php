<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class BlockSectionCoursesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('BlockSectionSchedules', [

        'foreignKey' => 'block_section_course_id', 

      ]);

  }

  public function getAllBlockSectionCourse($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        BlockSectionCourse.*


      FROM

        block_section_courses as BlockSectionCourse LEFT JOIN

        block_section_schedules as BlockSectionSchedule ON BlockSectionSchedule.id = BlockSectionCourse.course_id

      WHERE

        BlockSectionCourse.visible = true 
 
      ORDER BY 

        BlockSectionCourse.code ASC
        
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

    $result = $this->getAllBlockSectionCourse($conditions, $limit, $page)->fetchAll('assoc');

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

        block_section_courses as BlockSectionCourse  

      WHERE

        BlockSectionCourse.visible = true 

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
