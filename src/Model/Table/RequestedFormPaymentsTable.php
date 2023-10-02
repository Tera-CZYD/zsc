<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class RequestedFormPaymentsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('RequestedFormPaymentSubs', [

      'foreignKey' => 'requested_form_payment_id', 

    ]);

    $this->belongsTo('AffidavitOfLosses', [

      'foreignKey' => 'affidavit_of_loss_id', 

    ]);

    $this->belongsTo('RequestForms', [

      'foreignKey' => 'request_form_id', 

    ]);

    // $this->belongsTo('Students', [

    //   'foreignKey' => 'student_id', 

    // ]);

  }

  public function getAllRequestedFormPaymentPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $sql = "

      SELECT 

        RequestedFormPayment.*

      FROM 

        requested_form_payments as RequestedFormPayment 

      WHERE 

        RequestedFormPayment.visible = true $date $status AND

      (

        RequestedFormPayment.code LIKE '%$search%' OR

        RequestedFormPayment.student_name LIKE '%$search%' OR

        RequestedFormPayment.student_no LIKE '%$search%' OR

        RequestedFormPayment.email LIKE '%$search%' OR

        RequestedFormPayment.contact_no LIKE '%$search%' 

      )

      ORDER BY 

      RequestedFormPayment.code DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllRequestedFormPayment($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $status = @$conditions['status'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT 

        RequestedFormPayment.*

      FROM 

        requested_form_payments as RequestedFormPayment 

      WHERE 

        RequestedFormPayment.visible = true $date $status AND

      (

        RequestedFormPayment.code LIKE '%$search%' OR

        RequestedFormPayment.student_name LIKE '%$search%' OR

        RequestedFormPayment.student_no LIKE '%$search%' OR

        RequestedFormPayment.email LIKE '%$search%' OR

        RequestedFormPayment.contact_no LIKE '%$search%' 

      )

      ORDER BY 

        RequestedFormPayment.code DESC

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

    $result = $this->getAllRequestedFormPayment($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT 

        count(*) as count

      FROM 

        requested_form_payments as RequestedFormPayment 

      WHERE

        RequestedFormPayment.visible = true $date $status AND

      (

        RequestedFormPayment.code LIKE '%$search%' OR

        RequestedFormPayment.student_name LIKE '%$search%' OR

        RequestedFormPayment.student_no LIKE '%$search%' OR

        RequestedFormPayment.email LIKE '%$search%' OR

        RequestedFormPayment.contact_no LIKE '%$search%' 

      )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
