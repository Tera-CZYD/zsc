<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class TransfereesTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('TransfereeImages', [

      'foreignKey' => 'transferee_id', 

    ]);

    // $this->belongsTo('Students', [

    //   'foreignKey' => 'transferee_id', 

    // ]);

    $this->belongsTo('YearLevelTerms', [

      'foreignKey' => 'year_term_id', 

    ]);

    $this->belongsTo('CollegePrograms', [

      'foreignKey' => 'program_id', 

    ]);

    $this->belongsTo('Colleges', [

      'foreignKey' => 'college_id', 

    ]);          

  }

  public function getAllTransfereePrint($conditions){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        Transferee.*,

        College.name as college,

        CollegeProgram.name as program,

        YearLevelTerm.year as year,

        IFNULL(CONCAT(Transferee.last_name,', ',Transferee.first_name,' ',IFNULL(Transferee.middle_name,' ')),' ') AS full_name

      FROM

        transferees as Transferee LEFT JOIN

        colleges as College ON College.id = Transferee.college_id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Transferee.program_id LEFT JOIN

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = Transferee.year_term_id

      WHERE

        Transferee.visible = true $date $studentId AND

        (
 
          Transferee.first_name           LIKE  '%$search%' OR

          Transferee.middle_name          LIKE  '%$search%' OR

          Transferee.last_name            LIKE  '%$search%' OR

          Transferee.year_level           LIKE  '%$search%' OR

          Transferee.email                LIKE  '%$search%' OR

          Transferee.date                 LIKE  '%$search%'

        )

      ORDER BY 

        full_name ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllTransferee($conditions, $limit, $page){

    $search = @$conditions['search'];

    $date = @$conditions['date'];

    $studentId = @$conditions['studentId'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Transferee.*,

        College.name as college,

        CollegeProgram.name as program,

        YearLevelTerm.year as year,        

        IFNULL(CONCAT(Transferee.last_name,', ',Transferee.first_name,' ',IFNULL(Transferee.middle_name,' ')),' ') AS full_name

      FROM

        transferees as Transferee LEFT JOIN

        colleges as College ON College.id = Transferee.college_id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Transferee.program_id LEFT JOIN

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = Transferee.year_term_id


      WHERE

        Transferee.visible = true $date $studentId AND

        (
 
          Transferee.first_name           LIKE  '%$search%' OR

          Transferee.middle_name          LIKE  '%$search%' OR

          Transferee.last_name            LIKE  '%$search%' OR

          Transferee.year_level           LIKE  '%$search%' OR

          Transferee.email                LIKE  '%$search%' OR

          Transferee.date                 LIKE  '%$search%'

        )

      ORDER BY 

        full_name ASC

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

    $result = $this->getAllTransferee($conditions, $limit, $page)->fetchAll('assoc');

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

    $studentId = @$conditions['studentId'];

    $sql = "

      SELECT

        count(*) as count

       FROM

        transferees as Transferee LEFT JOIN

        colleges as College ON College.id = Transferee.college_id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Transferee.program_id LEFT JOIN

        year_level_terms as YearLevelTerm ON YearLevelTerm.id = Transferee.year_term_id 

      WHERE

        Transferee.visible = true $date $studentId AND

        (
 
          Transferee.first_name           LIKE  '%$search%' OR

          Transferee.middle_name          LIKE  '%$search%' OR

          Transferee.last_name            LIKE  '%$search%' OR

          Transferee.year_level           LIKE  '%$search%' OR

          Transferee.email                LIKE  '%$search%' OR

          Transferee.date                 LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
