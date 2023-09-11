<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

class ReferralRecommendationsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('NurseProfiles', [

      'foreignKey' => 'attended_by_id', 

    ]);

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);

  }

    public function getAllReferralRecommendation($conditions, $limit, $page){

      $search = @$conditions['search'];

      $college_id = @$conditions['college_id'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $offset = ($page - 1) * $limit;

      $date = @$conditions['date'];

      $sql = "

        SELECT

        ReferralRecommendation.*,

        NurseProfile.name

        FROM

          referral_recommendations as ReferralRecommendation LEFT JOIN

          students as Student ON ReferralRecommendation.student_id = Student.id LEFT JOIN

          nurse_profiles as NurseProfile ON ReferralRecommendation.attended_by_id = NurseProfile.id

        WHERE

          ReferralRecommendation.visible = true $date   $status  $studentId  AND

          (
   
            ReferralRecommendation.code LIKE  '%$search%' OR

            ReferralRecommendation.student_no LIKE  '%$search%' OR

            ReferralRecommendation.student_name LIKE  '%$search%' OR

            ReferralRecommendation.complaints LIKE  '%$search%' OR

            ReferralRecommendation.recommendations LIKE  '%$search%'

          )

        ORDER BY 

          ReferralRecommendation.code DESC
          
      ";

      // var_dump($sql);

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllReferralRecommendationPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "

        SELECT

          ReferralRecommendation.*,

          NurseProfile.name

        FROM

          referral_recommendations as ReferralRecommendation LEFT JOIN

          students as Student ON ReferralRecommendation.student_id = Student.id LEFT JOIN

          nurse_profiles as NurseProfile ON ReferralRecommendation.attended_by_id = NurseProfile.id

        WHERE

          ReferralRecommendation.visible = true $date   $status  $studentId  AND

          (
   
            ReferralRecommendation.code LIKE  '%$search%' OR

            ReferralRecommendation.student_no LIKE  '%$search%' OR

            ReferralRecommendation.student_name LIKE  '%$search%' OR

            ReferralRecommendation.complaints LIKE  '%$search%' OR

            ReferralRecommendation.recommendations LIKE  '%$search%'

          )

        ORDER BY 

          ReferralRecommendation.code DESC
          
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

      $result = $this->getAllReferralRecommendation($conditions, $limit, $page)->fetchAll('assoc');

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

      $college_id = @$conditions['college_id'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studetnId'];

      $sql = "

        SELECT

          count(*) as total

        FROM

          referral_recommendations as ReferralRecommendation LEFT JOIN

          students as Student ON ReferralRecommendation.student_id = Student.id

        WHERE

          ReferralRecommendation.visible = true $date   $status $studentId AND

          (
   
              ReferralRecommendation.code LIKE  '%$search%' OR

              ReferralRecommendation.student_no LIKE  '%$search%' OR

              ReferralRecommendation.student_name LIKE  '%$search%' OR


              ReferralRecommendation.complaints LIKE  '%$search%' OR

              ReferralRecommendation.recommendations LIKE  '%$search%' 

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['total'];

    }

  }