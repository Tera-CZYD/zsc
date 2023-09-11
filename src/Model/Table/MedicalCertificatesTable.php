<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class MedicalCertificatesTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

      $this->belongsTo('YearLevelTerms', [

        'foreignKey' => 'year_term_id', 

      ]);

      $this->belongsTo('CollegePrograms', [

        'foreignKey' => 'program_id', 

      ]);

      $this->belongsTo('Students', [

        'foreignKey' => 'student_id', 

      ]);

      $this->belongsTo('Employees', [

        'foreignKey' => 'employee_id', 

      ]);



    }

    public function getAllMedicalCertificate($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

        MedicalCertificate.*,

        CollegeProgram.code,

        YearLevelTerm.description

        FROM

          medical_certificates as MedicalCertificate LEFT JOIN

          year_level_terms as YearLevelTerm ON MedicalCertificate.year_term_id = YearLevelTerm.id LEFT JOIN

          college_programs as CollegeProgram ON MedicalCertificate.program_id = CollegeProgram.id LEFT JOIN

          students as Student ON MedicalCertificate.student_id = Student.id

        WHERE

        MedicalCertificate.visible = true $date $status  $studentId AND

          (
   
              MedicalCertificate.code LIKE  '%$search%' OR

              MedicalCertificate.student_no LIKE  '%$search%' OR

              MedicalCertificate.student_name LIKE  '%$search%' OR

              MedicalCertificate.description LIKE  '%$search%'

          )

        ORDER BY 

        MedicalCertificate.code DESC
          
      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllMedicalCertificatePrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

          MedicalCertificate.*,

          CollegeProgram.code,

          YearLevelTerm.description

        FROM

          medical_certificates as MedicalCertificate LEFT JOIN

          year_level_terms as YearLevelTerm ON MedicalCertificate.year_term_id = YearLevelTerm.id LEFT JOIN

          college_programs as CollegeProgram ON MedicalCertificate.program_id = CollegeProgram.id 


        WHERE

        MedicalCertificate.visible = true $date $status  $studentId AND

          (
   
              MedicalCertificate.code LIKE  '%$search%' OR

              MedicalCertificate.student_no LIKE  '%$search%' OR

              MedicalCertificate.student_name LIKE  '%$search%' OR

              MedicalCertificate.description LIKE  '%$search%'

          )

        ORDER BY 

        MedicalCertificate.code DESC
          
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

      $result = $this->getAllMedicalCertificate($conditions, $limit, $page)->fetchAll('assoc');

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

          count(*) as total

        FROM

          medical_certificates as MedicalCertificate LEFT JOIN

          year_level_terms as YearLevelTerm ON MedicalCertificate.year_term_id = YearLevelTerm.id LEFT JOIN

          college_programs as CollegeProgram ON MedicalCertificate.program_id = CollegeProgram.id LEFT JOIN

          students as Student ON MedicalCertificate.student_id = Student.id

        WHERE

        MedicalCertificate.visible = true $date $status $studentId AND

          (
   
              MedicalCertificate.code LIKE  '%$search%' OR

              MedicalCertificate.student_no LIKE  '%$search%' OR

              MedicalCertificate.student_name LIKE  '%$search%' OR

              MedicalCertificate.description LIKE  '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }