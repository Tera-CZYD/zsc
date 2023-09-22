<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class InventoryBibliographiesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('MaterialTypes', [

      'foreignKey' => 'material_type_id', 

    ]);

    $this->belongsTo('CollectionTypes', [

      'foreignKey' => 'collection_type_id', 

    ]);

  }

  public function getAllInventoryBibliographyPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $material_type = @$conditions['material_type'];

    $collection_type = @$conditions['collection_type'];

    $sql = "

      SELECT

        Bibliography.id,

        Bibliography.code,

        Bibliography.title,

        Bibliography.author,

        Bibliography.terms_of_availability,

        IFNULL(InventoryBibliography.noOfCopy,0) as noOfCopy

      FROM

      bibliographies as Bibliography LEFT JOIN

      (

        SELECT InventoryBibliography.bibliography_id,

          COUNT(*) as noOfCopy

          FROM

          inventory_bibliographies as InventoryBibliography 

          WHERE InventoryBibliography.visible = true

          group by InventoryBibliography.bibliography_id

      ) as InventoryBibliography ON InventoryBibliography.bibliography_id = Bibliography.id 

      WHERE

        Bibliography.visible = true $date $material_type $collection_type AND

        (

          InventoryBibliography.bibliography_id  LIKE   '%$search%'  OR 

          Bibliography.author LIKE '%$search%' OR

          Bibliography.terms_of_availability LIKE '%$search%' OR

          Bibliography.copyright LIKE '%$search%' 

        )

      ORDER BY 

        InventoryBibliography.bibliography_id DESC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllInventoryBibliography($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $material_type = @$conditions['material_type'];

    $collection_type = @$conditions['collection_type'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Bibliography.id,

        Bibliography.code,

        Bibliography.title,

        Bibliography.author,

        Bibliography.terms_of_availability,

        IFNULL(InventoryBibliography.noOfCopy,0) as noOfCopy

      FROM

      bibliographies as Bibliography LEFT JOIN

      (

        SELECT InventoryBibliography.bibliography_id,

          COUNT(*) as noOfCopy

          FROM

          inventory_bibliographies as InventoryBibliography 

          WHERE InventoryBibliography.visible = true

          group by InventoryBibliography.bibliography_id

      ) as InventoryBibliography ON InventoryBibliography.bibliography_id = Bibliography.id 

      WHERE

        Bibliography.visible = true $date $material_type $collection_type AND

        (

          InventoryBibliography.bibliography_id  LIKE   '%$search%'  OR 

          Bibliography.author LIKE '%$search%' OR

          Bibliography.terms_of_availability LIKE '%$search%' OR

          Bibliography.copyright LIKE '%$search%' 

        )

      ORDER BY 

        InventoryBibliography.bibliography_id DESC

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

    $result = $this->getAllInventoryBibliography($conditions, $limit, $page)->fetchAll('assoc');

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

        inventory_bibliographies as InventoryBibliography LEFT JOIN 

        bibliographies as Bibliography ON Bibliography.id = InventoryBibliography.bibliography_id 

      WHERE 

        InventoryBibliography.visible = true AND 

        Bibliography.visible = true AND

        (

          InventoryBibliography.id  LIKE   '%$search%'  OR 

          Bibliography.author LIKE '%$search%' OR

          Bibliography.copyright LIKE '%$search%' OR

          InventoryBibliography.quantity   LIKE  '%$search%' OR 

          InventoryBibliography.barcode_no   LIKE  '%$search%'  OR

          InventoryBibliography.status       LIKE  '%$search%'  OR 

          InventoryBibliography.description  LIKE  '%$search%'  OR 

          InventoryBibliography.status_dt    LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
