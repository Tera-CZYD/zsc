<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AwardeeManagementsTable extends Table{

  public function initialize(array $config): void{
      parent::initialize($config);

      $this->setTable('awardee_managements');
      $this->setDisplayField('id');
      $this->setPrimaryKey('id');

      $this->addBehavior('Timestamp');

      $this->belongsTo('Students', [
          'foreignKey' => 'student_id',
      ]);
      $this->belongsTo('Sections', [
          'foreignKey' => 'section_id'
      ]);
      $this->belongsTo('Courses', [
          'foreignKey' => 'course_id',
      ]);
      $this->belongsTo('Colleges', [
          'foreignKey' => 'college_id'
      ]);
      $this->belongsTo('CollegePrograms', [
          'foreignKey' => 'program_id'
      ]);
      $this->belongsTo('AwardManagements', [
          'foreignKey' => 'award_id'
      ]);

    $this->addBehavior('Timestamp');

  }

   public function getAllAwardeeManagementPrint($conditions){

     $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "SELECT

        AwardeeManagement.*,

        Course.code,
        
        Section.name

      FROM

        awardee_managements as AwardeeManagement LEFT JOIN

        courses as Course ON AwardeeManagement.course_id = Course.id  LEFT JOIN

        sections as Section ON AwardeeManagement.section_id = Section.id  LEFT JOIN

        award_managements as AwardManagement ON AwardeeManagement.award_id = AwardManagement.id 

      WHERE

        AwardeeManagement.visible = true $date AND

        (
 
          AwardeeManagement.code LIKE  '%$search%' OR

          AwardeeManagement.student_no LIKE  '%$search%' OR

          AwardeeManagement.student_name LIKE  '%$search%' 
          

        )

      ORDER BY 

        AwardeeManagement.code DESC
        
    ";


    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAwardeeManagement($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "SELECT

        AwardeeManagement.*,

        Course.code,
        
        Section.name

      FROM

        awardee_managements as AwardeeManagement LEFT JOIN

        courses as Course ON AwardeeManagement.course_id = Course.id  LEFT JOIN

        sections as Section ON AwardeeManagement.section_id = Section.id  LEFT JOIN

        award_managements as AwardManagement ON AwardeeManagement.award_id = AwardManagement.id 

      WHERE

        AwardeeManagement.visible = true $date AND

        (
 
          AwardeeManagement.code LIKE  '%$search%' OR

          AwardeeManagement.student_no LIKE  '%$search%' OR

          AwardeeManagement.student_name LIKE  '%$search%' 
          

        )

      ORDER BY 

        AwardeeManagement.code DESC
        
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

    $result = $this->getAllAwardeeManagement($conditions, $limit, $page)->fetchAll('assoc');

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

          awardee_managements as AwardeeManagement LEFT JOIN

        courses as Course ON AwardeeManagement.course_id = Course.id  LEFT JOIN

        sections as Section ON AwardeeManagement.section_id = Section.id  LEFT JOIN

        award_managements as AwardManagement ON AwardeeManagement.award_id = AwardManagement.id 

      WHERE

        AwardeeManagement.visible = true $date AND


        (
 
          AwardeeManagement.code LIKE  '%$search%' OR

          AwardeeManagement.student_no LIKE  '%$search%' OR

          AwardeeManagement.student_name LIKE  '%$search%' 
          

        )

      ORDER BY 

        AwardeeManagement.code DESC

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
