<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class BlockSectionsTable extends Table{

    public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

      $this->belongsTo('YearLevelTerms', [

        'foreignKey' => 'year_term_id', 

      ]);

      $this->hasMany('BlockSectionCourses', [

        'foreignKey' => 'block_section_id', 

      ]);

    }

    public function getAllBlockSection($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $sql = "

        SELECT * FROM (

        SELECT

          BlockSection.*,

          YearLevelTerm.description

        FROM

          block_sections as BlockSection LEFT JOIN 

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = BlockSection.year_term_id

        WHERE

          BlockSection.visible = true $date $year_term_id $college_id $program_id AND

          (

            BlockSection.code LIKE  '%$search%' OR

            BlockSection.program LIKE  '%$search%' OR

            BlockSection.college LIKE  '%$search%' 

          )

        ORDER BY 

          BlockSection.code ASC
          
      ) as BlockSection ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllBlockSectionPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $sql = "

        SELECT * FROM (

        SELECT

          BlockSection.*,

          YearLevelTerm.description

        FROM

          block_sections as BlockSection LEFT JOIN 

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = BlockSection.year_term_id

        WHERE

          BlockSection.visible = true $date $year_term_id $college_id $program_id AND

          (

            BlockSection.code LIKE  '%$search%' OR

            BlockSection.program LIKE  '%$search%' OR

            BlockSection.college LIKE  '%$search%' 

          )

        ORDER BY 

          BlockSection.code ASC
          
      ) as BlockSection ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function paginate($query, array $options = []){

      $extra = isset($options['extra']) ? $options['extra'] : [];

      $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

      $page = $options['page'];

      $limit = $options['limit'];

      $result = $this->getAllBlockSection($conditions, $limit, $page)->fetchAll('assoc');

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

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $sql = "

        SELECT count(*) as total FROM (

        SELECT

          BlockSection.*,

          YearLevelTerm.description

        FROM

          block_sections as BlockSection LEFT JOIN 

          year_level_terms as YearLevelTerm ON YearLevelTerm.id = BlockSection.year_term_id

        WHERE

          BlockSection.visible = true $date $year_term_id $college_id $program_id AND

          (

            BlockSection.code LIKE  '%$search%' OR

            BlockSection.program LIKE  '%$search%' OR

            BlockSection.college LIKE  '%$search%' 

          )
          
      ) as BlockSection ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }