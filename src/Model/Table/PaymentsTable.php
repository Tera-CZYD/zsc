<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class PaymentsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id'

    ]);

  }

  public function getAllPaymentPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        Payment.*,

        CollegeProgram.name as program

      FROM

        payments as Payment LEFT JOIN 

        college_programs as CollegeProgram ON CollegeProgram.id = Payment.program_id

      WHERE

        Payment.visible = true $date AND 

        (

          Payment.code LIKE  '%$search%' OR

          Payment.student_name LIKE  '%$search%' OR

          Payment.student_no LIKE  '%$search%' OR

          Payment.email LIKE  '%$search%' 

        )

      ORDER BY 

        Payment.code ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllPayment($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Payment.*,

        CollegeProgram.name as program

      FROM

        payments as Payment LEFT JOIN 

        college_programs as CollegeProgram ON CollegeProgram.id = Payment.program_id

      WHERE

        Payment.visible = true $date AND 

        (

          Payment.code LIKE  '%$search%' OR

          Payment.student_name LIKE  '%$search%' OR

          Payment.student_no LIKE  '%$search%' OR

          Payment.email LIKE  '%$search%' 

        )

      ORDER BY 

        Payment.code ASC

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

    $result = $this->getAllPayment($conditions, $limit, $page)->fetchAll('assoc');

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

        payments as Payment LEFT JOIN 

        college_programs as CollegeProgram ON CollegeProgram.id = Payment.program_id

      WHERE

        Payment.visible = true $date AND 

        (

          Payment.code LIKE  '%$search%' OR

          Payment.student_name LIKE  '%$search%' OR

          Payment.student_no LIKE  '%$search%' OR

          Payment.email LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
