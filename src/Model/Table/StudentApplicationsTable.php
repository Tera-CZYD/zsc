<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class StudentApplicationsTable extends Table{

  public function initialize(array $config): void {

    $this->addBehavior('Timestamp');

     $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id'

    ]);

    $this->belongsTo('Colleges', [

      'foreignKey' => 'college_id'

    ]);


    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'preferred_program_id'

    ]);

    $this->belongsTo('PreferredPrograms', [

        'className' => 'CollegePrograms',

        'foreignKey' => 'preferred_program_id'

    ]);

    $this->belongsTo('SecondaryPrograms', [
      
        'className' => 'CollegePrograms',
        
        'foreignKey' => 'secondary_program_id'
        
    ]);

    $this->hasMany('StudentApplicationImages', [

      'foreignKey' => 'application_id'

    ]);

    $this->hasMany('StudentEnrolledCourses', [

      'foreignKey' => 'student_id'

    ]);

    $this->hasMany('StudentEnrolledUnits', [

      'foreignKey' => 'student_id'

    ]);

    $this->hasMany('StudentEnrollments', [

      'foreignKey' => 'student_id'

    ]);

  }


  public function validSave($data){

    $result = [];

    $data['first_name'] = ucwords(@$data['first_name']);

    $data['last_name']  = ucwords(@$data['last_name']);

    $existingConditions = [];

    $existingConditions['first_name'] = @$data['first_name'];

    $existingConditions['last_name'] = @$data['last_name'];

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

        'msg' => '<span style="color:#f5f5f5; font-size: 13px">Please input valid email address.</span>'

      ];

    } else {

      $entity = $this->newEntity($data);

      // debug($entity);

      if ($this->save($entity)) {

        $data['id'] = $entity->id;

        $result = [

          'data' => $data,

          'ok' => true,

          'msg' => 'Student Application Has been successfuly saved.'

        ];

      }

    }

    return $result;

  }

  public function getAllStudentApplicationPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $rate = @$conditions['rate'];

    $order = '';

    if(@$conditions['order'] == 'studentRateAsc'){

      $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) ASC";

    }elseif(@$conditions['order'] == 'studentRateDesc'){

      $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) DESC";

    }else{

      $order = "ORDER BY full_name ASC";

    }

    $sql = "

      SELECT

        StudentApplication.*,

        CollegeProgram.name,

        IFNULL(CONCAT(StudentApplication.last_name,', ',StudentApplication.first_name,' ',IFNULL(StudentApplication.middle_name,' ')),' ') AS full_name

      FROM

        student_applications as StudentApplication LEFT JOIN 

        college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id

      WHERE

        StudentApplication.visible = true $date $status $rate AND

        CollegeProgram.visible = true AND

        (
 
          StudentApplication.first_name LIKE  '%$search%' OR

          StudentApplication.middle_name LIKE  '%$search%' OR

          StudentApplication.last_name LIKE  '%$search%' OR

          StudentApplication.email LIKE  '%$search%' OR

          StudentApplication.contact_no LIKE  '%$search%' OR

          StudentApplication.address LIKE  '%$search%'

        )

      $order

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllStudentApplication($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $rate = @$conditions['rate'];

    $order = '';

    if(@$conditions['order'] == 'studentRateAsc'){

      $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) ASC";

    }elseif(@$conditions['order'] == 'studentRateDesc'){

      $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) DESC";

    }elseif(@$conditions['order'] == 'applicantNameDesc'){

      $order = "ORDER BY full_name DESC";

    }elseif(@$conditions['order'] == 'applicantNameAsc'){

      $order = "ORDER BY full_name ASC";

    }elseif(@$conditions['order'] == 'applicationDateDesc'){

      $order = "ORDER BY StudentApplication.application_date DESC";

    }elseif(@$conditions['order'] == 'applicationDateAsc'){

      $order = "ORDER BY StudentApplication.application_date ASC";

    }else{

      $order = "ORDER BY full_name ASC";

    }

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        StudentApplication.*,

        CollegeProgram.name,

        IFNULL(CONCAT(StudentApplication.last_name,', ',StudentApplication.first_name,' ',IFNULL(StudentApplication.middle_name,' ')),' ') AS full_name

      FROM

        student_applications as StudentApplication LEFT JOIN 

        college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id

      WHERE

        StudentApplication.visible = true $date $status $rate AND

        CollegeProgram.visible = true AND

        (
 
          StudentApplication.first_name LIKE  '%$search%' OR

          StudentApplication.middle_name LIKE  '%$search%' OR

          StudentApplication.last_name LIKE  '%$search%' OR

          StudentApplication.email LIKE  '%$search%' OR

          StudentApplication.contact_no LIKE  '%$search%' OR

          StudentApplication.address LIKE  '%$search%'

        )

      $order

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

    $result = $this->getAllStudentApplication($conditions, $limit, $page)->fetchAll('assoc');

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

    $rate = @$conditions['rate'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        student_applications as StudentApplication LEFT JOIN 

        college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id

      WHERE

        StudentApplication.visible = true $date $status $rate AND

        CollegeProgram.visible = true AND

        (
 
          StudentApplication.first_name LIKE  '%$search%' OR

          StudentApplication.middle_name LIKE  '%$search%' OR

          StudentApplication.last_name LIKE  '%$search%' OR

          StudentApplication.email LIKE  '%$search%' OR

          StudentApplication.contact_no LIKE  '%$search%' OR

          StudentApplication.address LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}