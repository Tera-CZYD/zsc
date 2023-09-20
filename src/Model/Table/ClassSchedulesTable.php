<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class ClassSchedulesTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

      $this->belongsTo('YearLevelTerms', [

        'foreignKey' => 'year_term_id', 

      ]);

      $this->hasMany('ClassScheduleDays', [

        'foreignKey' => 'class_schedule_id', 

      ]);

      $this->hasMany('ClassScheduleTmps', [

        'foreignKey' => 'class_schedule_id', 

      ]);

      $this->hasMany('ClassScheduleSubs', [

        'foreignKey' => 'class_schedule_id', 

      ]);

      $this->belongsTo('Colleges', [

        'foreignKey' => 'college_id', 

        'propertyName' => 'college'

      ]);

    }

    public function getAllClassSchedule($conditions, $limit, $page){

      $search = @$conditions['search'];

      $year = @$conditions['year'];

      $semester = @$conditions['semester'];

      $sql = "SELECT * FROM (

        SELECT

          ClassSchedule.*,

          YearLevelTerm.description,

          College.name

        FROM

          class_schedules as ClassSchedule LEFT JOIN 

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = ClassSchedule.year_term_id LEFT JOIN

          colleges as College On College.id = ClassSchedule.college_id

        WHERE

          ClassSchedule.visible = true $year $semester AND



          (

            ClassSchedule.code LIKE  '%$search%' OR

            ClassSchedule.faculty_name LIKE  '%$search%' OR

            ClassSchedule.program LIKE  '%$search%'

          )

        GROUP BY

          ClassSchedule.id

        ORDER BY 

          ClassSchedule.code ASC
          
      ) as ClassSchedule ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllClassSchedulePrint($conditions){

      $search = @$conditions['search'];

      $year = @$conditions['year'];

      $semester = @$conditions['semester'];

      $sql = "SELECT * FROM (

        SELECT

          ClassSchedule.*,

          YearLevelTerm.description,

          College.name

        FROM

          class_schedules as ClassSchedule LEFT JOIN 

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = ClassSchedule.year_term_id LEFT JOIN

          colleges as College On College.id = ClassSchedule.college_id

        WHERE

          ClassSchedule.visible = true $year $semester AND



          (

            ClassSchedule.code LIKE  '%$search%' OR

            ClassSchedule.faculty_name LIKE  '%$search%' OR

            ClassSchedule.program LIKE  '%$search%'

          )

        GROUP BY

          ClassSchedule.id

        ORDER BY 

          ClassSchedule.code ASC
          
      ) as ClassSchedule ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function paginate($query, array $options = []){

      $extra = isset($options['extra']) ? $options['extra'] : [];

      $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

      $page = $options['page'];

      $limit = $options['limit'];

      $result = $this->getAllClassSchedule($conditions, $limit, $page)->fetchAll('assoc');

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

      $year = @$conditions['year'];

      $semester = @$conditions['semester'];

      $sql = "

        SELECT count(*) as total FROM (

        SELECT

          ClassSchedule.*,

          YearLevelTerm.description

        FROM

          class_schedules as ClassSchedule LEFT JOIN 

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = ClassSchedule.year_term_id LEFT JOIN

          colleges as College On College.id = ClassSchedule.college_id

        WHERE

          ClassSchedule.visible = true $year $semester AND



          (

            ClassSchedule.code LIKE  '%$search%' OR

            ClassSchedule.faculty_name LIKE  '%$search%' OR

            ClassSchedule.program LIKE  '%$search%'

          )

        GROUP BY

          ClassSchedule.id

        ORDER BY 

          ClassSchedule.code ASC
          
      ) as ClassSchedule ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }