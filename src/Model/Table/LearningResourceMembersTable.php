<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class LearningResourceMembersTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id', 

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id', 

    ]);

    $this->belongsTo('Colleges', [

      'foreignKey' => 'college_id', 

    ]);

  }

  public function getAllLearningResourceMemberPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $classification = @$conditions['classification'];

    $sql = "

      SELECT

        LearningResourceMember.*,

        CollegeProgram.name as college_program

      FROM

        learning_resource_members as LearningResourceMember LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = LearningResourceMember.program_id

      WHERE

        LearningResourceMember.visible = true $date $classification AND

        (
 
          LearningResourceMember.code LIKE  '%$search%' OR

          LearningResourceMember.student_name LIKE  '%$search%' OR 

          LearningResourceMember.employee_name LIKE '%$search%'

        )

      ORDER BY 

        LearningResourceMember.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllLearningResourceMember($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $classification = @$conditions['classification'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        LearningResourceMember.*,

        CollegeProgram.name as college_program

      FROM

        learning_resource_members as LearningResourceMember LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = LearningResourceMember.program_id

      WHERE

        LearningResourceMember.visible = true $date $classification AND

        (
 
          LearningResourceMember.code LIKE  '%$search%' OR

          LearningResourceMember.student_name LIKE  '%$search%' OR 

          LearningResourceMember.employee_name LIKE '%$search%'

        )

      ORDER BY 

        LearningResourceMember.code DESC

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

    $result = $this->getAllLearningResourceMember($conditions, $limit, $page)->fetchAll('assoc');

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

    $classification = @$conditions['classification'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        learning_resource_members as LearningResourceMember 

      WHERE

        LearningResourceMember.visible = true $date $classification AND

        (
 
          LearningResourceMember.code LIKE  '%$search%' OR

          LearningResourceMember.student_name LIKE  '%$search%' OR 

          LearningResourceMember.employee_name LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
