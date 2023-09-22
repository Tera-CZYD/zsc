<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class BibliographiesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->belongsTo('MaterialTypes', [

      'foreignKey' => 'material_type_id', 

    ]);

    $this->belongsTo('CollectionTypes', [

      'foreignKey' => 'collection_type_id', 

    ]);

    $this->hasMany('InventoryBibliographies', [

      'foreignKey' => 'bibliography_id', 

    ]);

  }

  public function getAllBibliographyPrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $sql = "

      SELECT

        Bibliography.*,

        MaterialType.name as material_type,

        CollectionType.name as collection_type,

        IFNULL(InventoryBibliography.noOfCopy,0) as noOfCopy

      FROM

        bibliographies as Bibliography LEFT JOIN

        material_types as MaterialType ON MaterialType.id = Bibliography.material_type_id LEFT JOIN

        collection_types as CollectionType ON CollectionType.id = Bibliography.collection_type_id LEFT JOIN

        (

          SELECT InventoryBibliography.bibliography_id,

            COUNT(*) as noOfCopy

            FROM

            inventory_bibliographies as InventoryBibliography 

            WHERE InventoryBibliography.visible = true

            group by InventoryBibliography.bibliography_id

        ) as InventoryBibliography ON InventoryBibliography.bibliography_id = Bibliography.id 

      WHERE

        Bibliography.visible = true $date AND

        MaterialType.visible = true AND

        CollectionType.visible = true AND 

        (

          Bibliography.code LIKE '%$search%' OR

          Bibliography.author LIKE '%$search%' OR

          Bibliography.copyright LIKE '%$search%' OR

          Bibliography.call_number1 LIKE '%$search%' OR

          Bibliography.call_number2 LIKE '%$search%' OR

          Bibliography.call_number3 LIKE '%$search%' OR

          Bibliography.title LIKE '%$search%' OR 

          Bibliography.remainder_title LIKE '%$search%' OR

          Bibliography.statement_responsibility LIKE '%$search%' OR

          Bibliography.personal_name LIKE '%$search%' OR

          Bibliography.topical_term1 LIKE '%$search%' OR

          Bibliography.topical_term2 LIKE '%$search%' OR

          Bibliography.topical_term3 LIKE '%$search%' OR

          Bibliography.topical_term4 LIKE '%$search%' OR

          Bibliography.topical_term5 LIKE '%$search%' OR

          Bibliography.edition_statement LIKE '%$search%' OR

          Bibliography.lc_control_number LIKE '%$search%' OR

          Bibliography.isbn LIKE '%$search%' OR

          Bibliography.library_of_congress1 LIKE '%$search%' OR

          Bibliography.library_of_congress2 LIKE '%$search%' OR

          Bibliography.dewey_decimal1 LIKE '%$search%' OR

          Bibliography.dewey_decimal2 LIKE '%$search%' OR

          Bibliography.place_of_publication LIKE '%$search%' OR

          Bibliography.name_of_publisher LIKE '%$search%' OR

          Bibliography.summary LIKE '%$search%' OR

          Bibliography.physical_description1 LIKE '%$search%' OR

          Bibliography.physical_description2 LIKE '%$search%' OR

          Bibliography.physical_description3 LIKE '%$search%' OR

          Bibliography.physical_description4 LIKE '%$search%' OR

          Bibliography.terms_of_availability LIKE '%$search%' 

        )

      ORDER BY

        Bibliography.id ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllBibliography($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Bibliography.*,

        MaterialType.name as material_type,

        CollectionType.name as collection_type,

        IFNULL(InventoryBibliography.noOfCopy,0) as noOfCopy

      FROM

        bibliographies as Bibliography LEFT JOIN

        material_types as MaterialType ON MaterialType.id = Bibliography.material_type_id LEFT JOIN

        collection_types as CollectionType ON CollectionType.id = Bibliography.collection_type_id LEFT JOIN

        (

          SELECT InventoryBibliography.bibliography_id,

            COUNT(*) as noOfCopy

            FROM

            inventory_bibliographies as InventoryBibliography 

            WHERE InventoryBibliography.visible = true

            group by InventoryBibliography.bibliography_id

        ) as InventoryBibliography ON InventoryBibliography.bibliography_id = Bibliography.id 

      WHERE

        Bibliography.visible = true $date AND

        MaterialType.visible = true AND

        CollectionType.visible = true AND 

        (

          Bibliography.code LIKE '%$search%' OR

          Bibliography.author LIKE '%$search%' OR

          Bibliography.copyright LIKE '%$search%' OR

          Bibliography.call_number1 LIKE '%$search%' OR

          Bibliography.call_number2 LIKE '%$search%' OR

          Bibliography.call_number3 LIKE '%$search%' OR

          Bibliography.title LIKE '%$search%' OR 

          Bibliography.remainder_title LIKE '%$search%' OR

          Bibliography.statement_responsibility LIKE '%$search%' OR

          Bibliography.personal_name LIKE '%$search%' OR

          Bibliography.topical_term1 LIKE '%$search%' OR

          Bibliography.topical_term2 LIKE '%$search%' OR

          Bibliography.topical_term3 LIKE '%$search%' OR

          Bibliography.topical_term4 LIKE '%$search%' OR

          Bibliography.topical_term5 LIKE '%$search%' OR

          Bibliography.edition_statement LIKE '%$search%' OR

          Bibliography.lc_control_number LIKE '%$search%' OR

          Bibliography.isbn LIKE '%$search%' OR

          Bibliography.library_of_congress1 LIKE '%$search%' OR

          Bibliography.library_of_congress2 LIKE '%$search%' OR

          Bibliography.dewey_decimal1 LIKE '%$search%' OR

          Bibliography.dewey_decimal2 LIKE '%$search%' OR

          Bibliography.place_of_publication LIKE '%$search%' OR

          Bibliography.name_of_publisher LIKE '%$search%' OR

          Bibliography.summary LIKE '%$search%' OR

          Bibliography.physical_description1 LIKE '%$search%' OR

          Bibliography.physical_description2 LIKE '%$search%' OR

          Bibliography.physical_description3 LIKE '%$search%' OR

          Bibliography.physical_description4 LIKE '%$search%' OR

          Bibliography.terms_of_availability LIKE '%$search%' 

        )

      ORDER BY

        Bibliography.id ASC

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

    $result = $this->getAllBibliography($conditions, $limit, $page)->fetchAll('assoc');

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

        bibliographies as Bibliography LEFT JOIN

        material_types as MaterialType ON MaterialType.id = Bibliography.material_type_id LEFT JOIN

        collection_types as CollectionType ON CollectionType.id = Bibliography.collection_type_id

      WHERE

        Bibliography.visible = true $date AND

        MaterialType.visible = true AND

        CollectionType.visible = true AND 

        (

          Bibliography.code LIKE '%$search%' OR

          Bibliography.author LIKE '%$search%' OR

          Bibliography.copyright LIKE '%$search%' OR

          Bibliography.call_number1 LIKE '%$search%' OR

          Bibliography.call_number2 LIKE '%$search%' OR

          Bibliography.call_number3 LIKE '%$search%' OR

          Bibliography.title LIKE '%$search%' OR 

          Bibliography.remainder_title LIKE '%$search%' OR

          Bibliography.statement_responsibility LIKE '%$search%' OR

          Bibliography.personal_name LIKE '%$search%' OR

          Bibliography.topical_term1 LIKE '%$search%' OR

          Bibliography.topical_term2 LIKE '%$search%' OR

          Bibliography.topical_term3 LIKE '%$search%' OR

          Bibliography.topical_term4 LIKE '%$search%' OR

          Bibliography.topical_term5 LIKE '%$search%' OR

          Bibliography.edition_statement LIKE '%$search%' OR

          Bibliography.lc_control_number LIKE '%$search%' OR

          Bibliography.isbn LIKE '%$search%' OR

          Bibliography.library_of_congress1 LIKE '%$search%' OR

          Bibliography.library_of_congress2 LIKE '%$search%' OR

          Bibliography.dewey_decimal1 LIKE '%$search%' OR

          Bibliography.dewey_decimal2 LIKE '%$search%' OR

          Bibliography.place_of_publication LIKE '%$search%' OR

          Bibliography.name_of_publisher LIKE '%$search%' OR

          Bibliography.summary LIKE '%$search%' OR

          Bibliography.physical_description1 LIKE '%$search%' OR

          Bibliography.physical_description2 LIKE '%$search%' OR

          Bibliography.physical_description3 LIKE '%$search%' OR

          Bibliography.physical_description4 LIKE '%$search%' OR

          Bibliography.terms_of_availability LIKE '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
