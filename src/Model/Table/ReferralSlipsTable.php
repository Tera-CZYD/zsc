<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;


/**
 * CollegeProgramCourses Model
 *
 * @property \App\Model\Table\CollegeProgramCorequisitesTable&\Cake\ORM\Association\HasMany $CollegeProgramCourses
 *
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReferralSlipsTable extends Table
{
   public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'course_id',

      'propertyName' => 'CollegeProgram'

    ]);

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id',

      'propertyName' => 'Student'

    ]);


  }

  public function getAllReferralSlipPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        ReferralSlip.*,

        ReferralSlip.reason,

        ReferralSlip.remarks,

        ReferralSlip.year,

        CollegeProgram.name,

        CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name

      FROM

        referral_slips as ReferralSlip LEFT JOIN

        college_programs as CollegeProgram ON ReferralSlip.course_id = CollegeProgram.id LEFT JOIN

        students as Student ON ReferralSlip.student_id = Student.id


      WHERE

        ReferralSlip.visible = true $date AND

        (
 

          ReferralSlip.code              LIKE  '%$search%' OR

          ReferralSlip.remarks             LIKE  '%$search%' OR

          ReferralSlip.reason              LIKE  '%$search%' OR

          ReferralSlip.student_name             LIKE  '%$search%' 


        )

      ORDER BY 

        ReferralSlip.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllReferralSlip($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        ReferralSlip.*,

        ReferralSlip.reason,

        ReferralSlip.remarks,

        ReferralSlip.year,

        CollegeProgram.name,

        CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name

      FROM

        referral_slips as ReferralSlip LEFT JOIN

        college_programs as CollegeProgram ON ReferralSlip.course_id = CollegeProgram.id LEFT JOIN

        students as Student ON ReferralSlip.student_id = Student.id


      WHERE

        ReferralSlip.visible = true $date AND

        (
 

          ReferralSlip.code              LIKE  '%$search%' OR

          ReferralSlip.remarks             LIKE  '%$search%' OR

          ReferralSlip.reason              LIKE  '%$search%' OR

          ReferralSlip.student_name             LIKE  '%$search%' 


        )

      GROUP BY

        ReferralSlip.id

      ORDER BY 

        ReferralSlip.code DESC

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

    $result = $this->getAllReferralSlip($conditions, $limit, $page)->fetchAll('assoc');

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

        referral_slips as ReferralSlip LEFT JOIN

        college_programs as CollegeProgram ON ReferralSlip.course_id = CollegeProgram.id LEFT JOIN

        students as Student ON ReferralSlip.student_id = Student.id


      WHERE

        ReferralSlip.visible = true $date AND

        (
 

          ReferralSlip.code              LIKE  '%$search%' OR

          ReferralSlip.remarks             LIKE  '%$search%' OR

          ReferralSlip.reason              LIKE  '%$search%' OR

          ReferralSlip.student_name             LIKE  '%$search%' 


        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }



}
