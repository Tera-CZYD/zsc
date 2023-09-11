<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class StudentClubsTable extends Table {

  public function initialize(array $config): void{
    $this->setTable('student_clubs');
    $this->setDisplayField('id');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');
    
    $this->belongsTo('Students', ['foreignKey' => 'student_id']);
    $this->belongsTo('Clubs', ['foreignKey' => 'club_id']);

  }

  public function getAllStudentClubPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        StudentClub.*,

        Club.title

      FROM

        student_clubs as StudentClub LEFT JOIN

        students as Student ON StudentClub.student_id = Student.id LEFT JOIN

        clubs as Club ON StudentClub.club_id = Club.id

      WHERE

        StudentClub.visible = true $date $status $studentId AND

        (
 
          StudentClub.code LIKE  '%$search%' OR

          StudentClub.student_no LIKE  '%$search%' OR

          StudentClub.student_name LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllStudentClub($conditions=array()){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        StudentClub.*,

        Club.title

      FROM

        student_clubs as StudentClub LEFT JOIN

        students as Student ON StudentClub.student_id = Student.id LEFT JOIN

        clubs as Club ON StudentClub.club_id = Club.id

      WHERE

        StudentClub.visible = true $date $status $studentId AND

        (
 
          StudentClub.code LIKE  '%$search%' OR

          StudentClub.student_no LIKE  '%$search%' OR

          StudentClub.student_name LIKE  '%$search%' 


        )

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

    $result = $this->getAllStudentClub($conditions, $limit, $page)->fetchAll('assoc');

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

        student_clubs as StudentClub LEFT JOIN

        students as Student ON StudentClub.student_id = Student.id LEFT JOIN

        clubs as Club ON StudentClub.club_id = Club.id

      WHERE

        StudentClub.visible = true $date $status $studentId AND

        (
 
          StudentClub.code LIKE  '%$search%' OR

          StudentClub.student_no LIKE  '%$search%' OR

          StudentClub.student_name LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}