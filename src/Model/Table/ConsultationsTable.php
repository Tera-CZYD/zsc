<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class ConsultationsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('ConsultationSubs', [

      'foreignKey' => 'consultation_id', 

    ]);

    $this->belongsTo('Students', [

      'foreignKey' => 'student_id', 

    ]);

  }

  public function getAllConsultationPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        Consultation.*,

        NurseProfile.name

      FROM

        consultations as Consultation LEFT JOIN

        students as Student ON Consultation.student_id = Student.id LEFT JOIN 

        nurse_profiles as NurseProfile ON Consultation.nurse_id = NurseProfile.id

      WHERE

      Consultation.visible = true $date $status $studentId AND

      NurseProfile.visible = true AND
      

      (

        Consultation.code LIKE  '%$search%' OR

        Consultation.student_no LIKE  '%$search%' OR

        Consultation.student_name LIKE  '%$search%' 

      )

      ORDER BY 

      Consultation.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllConsultation($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Consultation.*,

        NurseProfile.name

      FROM

        consultations as Consultation LEFT JOIN

        students as Student ON Consultation.student_id = Student.id LEFT JOIN 

        nurse_profiles as NurseProfile ON Consultation.nurse_id = NurseProfile.id

      WHERE

      Consultation.visible = true $date $status $studentId AND

      NurseProfile.visible = true AND
      

        (

          Consultation.code LIKE  '%$search%' OR

          Consultation.student_no LIKE  '%$search%' OR

          Consultation.student_name LIKE  '%$search%' 

        )

      ORDER BY 

        Consultation.code DESC

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

    $result = $this->getAllConsultation($conditions, $limit, $page)->fetchAll('assoc');

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

        consultations as Consultation LEFT JOIN

        students as Student ON Consultation.student_id = Student.id LEFT JOIN 

        nurse_profiles as NurseProfile ON Consultation.nurse_id = NurseProfile.id

      WHERE

      Consultation.visible = true $date $status $studentId AND

      NurseProfile.visible = true AND

      (

        Consultation.code LIKE  '%$search%' OR

        Consultation.student_no LIKE  '%$search%' OR

        Consultation.student_name LIKE  '%$search%'

      )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
