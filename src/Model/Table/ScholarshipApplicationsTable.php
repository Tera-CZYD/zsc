<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class ScholarshipApplicationsTable extends Table{

    public function initialize(array $config): void {

      $this->addBehavior('Timestamp');

      $this->belongsTo('CollegePrograms', [

        'foreignKey' => 'program_id', 

      ]);

      $this->belongsTo('Students', [

        'foreignKey' => 'student_id', 

      ]);

      $this->belongsTo('Provinces', [

        'foreignKey' => 'province_id', 

      ]);

      $this->belongsTo('Municipalities', [

        'foreignKey' => 'town_id', 

      ]);

      $this->belongsTo('Barangays', [

        'foreignKey' => 'barangay_id', 

      ]);

      $this->belongsTo('Schools', [

        'foreignKey' => 'school_name_id', 

      ]);

      $this->belongsTo('ScholarshipNames', [

        'foreignKey' => 'scholarship_name_id', 

      ]);

      $this->belongsTo('YearLevelTerms', [

        'foreignKey' => 'year_term_id', 

      ]);

    }

  public function getAllScholarshipApplicationPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "SELECT 

        ScholarshipApplication.*,

        CollegeProgram.name,

        ScholarshipName.scholarship_name

      FROM

        scholarship_applications as ScholarshipApplication LEFT JOIN

        scholarship_names as ScholarshipName ON ScholarshipName.id = ScholarshipApplication.scholarship_name_id LEFT JOIN

        students as Student ON ScholarshipApplication.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

      WHERE

        ScholarshipApplication.visible = true $date $status $studentId AND

        (
 
          ScholarshipApplication.code LIKE  '%$search%' OR

          ScholarshipApplication.student_no LIKE  '%$search%' OR

          ScholarshipApplication.student_name LIKE  '%$search%' OR

          ScholarshipApplication.year_term_id LIKE  '%$search%' OR

          ScholarshipApplication.reason LIKE  '%$search%' OR 

          CollegeProgram.name LIKE  '%$search%'

        )

      ORDER BY 

      ScholarshipApplication.student_name ASC
      ";


    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllScholarshipApplication($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "SELECT 

        ScholarshipApplication.*,

        CollegeProgram.name,

        ScholarshipName.scholarship_name

      FROM

        scholarship_applications as ScholarshipApplication LEFT JOIN

        scholarship_names as ScholarshipName ON ScholarshipName.id = ScholarshipApplication.scholarship_name_id LEFT JOIN

        students as Student ON ScholarshipApplication.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

      WHERE

        ScholarshipApplication.visible = true $date $status $studentId AND

        (
 
          ScholarshipApplication.code LIKE  '%$search%' OR

          ScholarshipApplication.student_no LIKE  '%$search%' OR

          ScholarshipApplication.student_name LIKE  '%$search%' OR

          ScholarshipApplication.year_term_id LIKE  '%$search%' OR

          ScholarshipApplication.reason LIKE  '%$search%' OR 

          CollegeProgram.name LIKE  '%$search%'

        )

      ORDER BY 

      ScholarshipApplication.student_name ASC
        
            
    LIMIT

      $limit OFFSET $offset ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function paginate($query, array $options = []){

    $extra = isset($options['extra']) ? $options['extra'] : [];

    $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

    $page = $options['page'];

    $limit = $options['limit'];

    $result = $this->getAllScholarshipApplication($conditions, $limit, $page)->fetchAll('assoc');

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

        scholarship_applications as ScholarshipApplication LEFT JOIN

        students as Student ON ScholarshipApplication.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

      WHERE

        ScholarshipApplication.visible = true $date $status $studentId AND

        (
 
          ScholarshipApplication.code LIKE  '%$search%' OR

          ScholarshipApplication.student_no LIKE  '%$search%' OR

          ScholarshipApplication.student_name LIKE  '%$search%' OR

          ScholarshipApplication.year_term_id LIKE  '%$search%' OR

          ScholarshipApplication.reason LIKE  '%$search%' OR 

          CollegeProgram.name LIKE  '%$search%'

        )

    ";


    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

  }