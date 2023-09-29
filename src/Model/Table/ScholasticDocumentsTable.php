<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class ScholasticDocumentsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function getAllScholasticDocumentPrint($conditions){

    $search = @$conditions['search'];

    $sql = "

    	SELECT

          ScholasticDocument.*

      FROM

        scholastic_documents as ScholasticDocument 

      WHERE

      ScholasticDocument.visible = true AND

        (
 
          ScholasticDocument.code LIKE  '%$search%' OR

          ScholasticDocument.title LIKE  '%$search%'

        )

      ORDER BY 

      	ScholasticDocument.code DESC
        
    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllScholasticDocument($conditions, $limit, $page){

    $search = @$conditions['search'];

    $sql = "

    	SELECT

          ScholasticDocument.*

      FROM

        scholastic_documents as ScholasticDocument 

      WHERE

      ScholasticDocument.visible = true AND

        (
 
          ScholasticDocument.code LIKE  '%$search%' OR

          ScholasticDocument.title LIKE  '%$search%'

        )

      ORDER BY 

      	ScholasticDocument.code DESC
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

    $result = $this->getAllScholasticDocument($conditions, $limit, $page)->fetchAll('assoc');

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

        scholastic_documents as ScholasticDocument 

      WHERE

      ScholasticDocument.visible = true $date AND

        (
 
          ScholasticDocument.code LIKE  '%$search%' OR

          ScholasticDocument.title LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
