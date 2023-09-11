<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class AffidavitsTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id',

      'propertyName' => 'Student'

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id',

      'propertyName' => 'CollegeProgram'

    ]);

  }

  public function getAllAffidavitPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        Affidavit.*,

        CollegeProgram.name

      FROM

        affidavits as Affidavit LEFT JOIN

        college_programs as CollegeProgram ON Affidavit.program_id = CollegeProgram.id 

      WHERE

        Affidavit.visible = true $date AND

        (
 
          Affidavit.code LIKE  '%$search%' OR

          Affidavit.student_no LIKE  '%$search%' OR

          Affidavit.student_name LIKE  '%$search%' OR

          Affidavit.or_no LIKE  '%$search%'

        )

      ORDER BY 

        Affidavit.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAffidavit($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Affidavit.*,

        CollegeProgram.name

      FROM

        affidavits as Affidavit LEFT JOIN

        college_programs as CollegeProgram ON Affidavit.program_id = CollegeProgram.id 

      WHERE

        Affidavit.visible = true $date AND

        (
 
          Affidavit.code LIKE  '%$search%' OR

          Affidavit.student_no LIKE  '%$search%' OR

          Affidavit.student_name LIKE  '%$search%' OR

          Affidavit.or_no LIKE  '%$search%'

        )

      GROUP BY

        Affidavit.id

      ORDER BY 

        Affidavit.code DESC

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

    $result = $this->getAllAffidavit($conditions, $limit, $page)->fetchAll('assoc');

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

        affidavits as Affidavit LEFT JOIN

        college_programs as CollegeProgram ON Affidavit.program_id = CollegeProgram.id 

      WHERE

        Affidavit.visible = true $date AND

        (
 
          Affidavit.code LIKE  '%$search%' OR

          Affidavit.student_no LIKE  '%$search%' OR

          Affidavit.student_name LIKE  '%$search%' OR

          Affidavit.or_no LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
