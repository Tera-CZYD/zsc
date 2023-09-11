<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class DentalsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);

    $this->hasMany('DentalImages', [

      'foreignKey' => 'dental_id',

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'course_id',

    ]);


  }

  public function getAllDentalPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        Dental.*,

        CollegeProgram.code as program_code,

        Course.code as course_code

      FROM

        dentals as Dental LEFT JOIN

        courses as Course ON Dental.course_id = Course.id LEFT JOIN

        students as Student ON Dental.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON Dental.course_id = CollegeProgram.id

      WHERE
        Dental.visible = true $date $status  $studentId AND

    (

      Dental.code LIKE  '%$search%' OR

      Dental.student_no LIKE  '%$search%' OR

      Dental.student_name LIKE  '%$search%' OR

      Dental.year LIKE  '%$search%' 


    )


      ORDER BY 

        Dental.code DESC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllDental($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "

     
      SELECT

        Dental.*,

        CollegeProgram.name as college_name,

        Course.code as course_code

      FROM

        dentals as Dental LEFT JOIN

        courses as Course ON Dental.course_id = Course.id LEFT JOIN

        students as Student ON Dental.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON Dental.course_id = CollegeProgram.id

      WHERE
        Dental.visible = true $date $status  $studentId AND

    (

      Dental.code LIKE  '%$search%' OR

      Dental.student_no LIKE  '%$search%' OR

      Dental.student_name LIKE  '%$search%' OR

      Dental.year LIKE  '%$search%' 


    )


      ORDER BY 

        Dental.code DESC

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

    $result = $this->getAllDental($conditions, $limit, $page)->fetchAll('assoc');

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

        dentals as Dental LEFT JOIN

        students as Student ON Dental.student_id = Student.id

      WHERE

      Dental.visible = true $date $status $studentId AND

        (
 
          Dental.code LIKE  '%$search%' OR

          Dental.student_no LIKE  '%$search%' OR

          Dental.student_name LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
