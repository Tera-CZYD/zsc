<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class MedicalStudentProfilesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('MedicalStudentProfileImages', [

      'foreignKey' => 'student_profile_id', 

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'course_id', 

    ]);

    $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id', 

    ]);

  }

  public function getAllMedicalStudentProfile($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

    SELECT 

      MedicalStudentProfile.*,

      CollegeProgram.name,

      YearLevelTerm.description,

      YearLevelTerm.year

    FROM 

      medical_student_profiles as MedicalStudentProfile LEFT JOIN 

      college_programs as CollegeProgram ON MedicalStudentProfile.course_id = CollegeProgram.id LEFT JOIN 

      year_level_terms as YearLevelTerm ON MedicalStudentProfile.year_term_id = YearLevelTerm.id

    WHERE 

      MedicalStudentProfile.visible = true AND 

      (

        MedicalStudentProfile.student_name        LIKE      '%$search%'     OR

        MedicalStudentProfile.address            LIKE      '%$search%'     OR

        MedicalStudentProfile.year_term_id           LIKE      '%$search%'     OR

        MedicalStudentProfile.course_id       LIKE      '%$search%'     

      )

    ORDER BY 

      MedicalStudentProfile.id ASC

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

    $result = $this->getAllMedicalStudentProfile($conditions, $limit, $page)->fetchAll('assoc');

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

  public function validSave($data){

    $result = [];
    // debug($data['id']);

    $data['student_name']  = ucwords(@$data['student_name']);

    $existingConditions = [];

    $existingConditions['student_name'] = @$data['student_name'];

    $existingConditions['visible'] = 1;

    

    if (isset($data['id'])) {

      $existingConditions['id !='] = $data['id'];

    }


    $existing = $this->find()

    ->where($existingConditions)

    ->first();

    if ($existing) {

      $result = [

        'data' => $data,

        'ok' => false,

        'msg' => 'Medical Student Profile already exists.'

      ];

    } else {



      $entity = $this->newEntity($data);

      // debug($entity);

      if ($this->save($entity)) {

        $data['id'] = $entity->id;

        $result = [

          'data' => $data,

          'ok' => true,

          'msg' => 'Medical Student Profile Has been successfuly saved.'

        ];

      }

    }

    return $result;

  }

  public function getAllMedicalStudentProfilePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

    SELECT 

      MedicalStudentProfile.*,

      CollegeProgram.name,

      YearLevelTerm.description,

      YearLevelTerm.year

    FROM 

      medical_student_profiles as MedicalStudentProfile LEFT JOIN 

      college_programs as CollegeProgram ON MedicalStudentProfile.course_id = CollegeProgram.id LEFT JOIN 

      year_level_terms as YearLevelTerm ON MedicalStudentProfile.year_term_id = YearLevelTerm.id

    WHERE 

      MedicalStudentProfile.visible = true AND 

      (

        MedicalStudentProfile.student_name        LIKE      '%$search%'     OR

        MedicalStudentProfile.address            LIKE      '%$search%'     OR

        MedicalStudentProfile.year_term_id           LIKE      '%$search%'     OR

        MedicalStudentProfile.course_id       LIKE      '%$search%'     

      )

    ORDER BY 

      MedicalStudentProfile.id ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function paginateCount($conditions = null){ 

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $date = @$conditions['date'];

    $sql = "

     SELECT 

      count(*) as total 

    FROM

      medical_student_profiles as MedicalStudentProfile LEFT JOIN 

      college_programs as CollegeProgram ON MedicalStudentProfile.course_id = CollegeProgram.id LEFT JOIN 

      year_level_terms as YearLevelTerm ON MedicalStudentProfile.year_term_id = YearLevelTerm.id

    WHERE 

      MedicalStudentProfile.visible = true AND 

      (

        MedicalStudentProfile.student_name        LIKE      '%$search%'     OR

        MedicalStudentProfile.address            LIKE      '%$search%'     OR

        MedicalStudentProfile.year_term_id           LIKE      '%$search%'     OR

        MedicalStudentProfile.course_id       LIKE      '%$search%'       

      )

    "; 

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['total'];

  }

}
