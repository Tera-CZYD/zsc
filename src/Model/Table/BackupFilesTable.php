<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class BackupFilesTable extends Table{

  public function initialize(array $config): void{
    $this->addBehavior('Timestamp');
    }

  public function getAllFile($conditions, $limit, $page){

    $date = $conditions['date'];

    $offset = ($page - 1) * $limit;


    $sql = "SELECT * FROM (SELECT

        Backup.*,

        User.username,

        CONCAT(User.last_name, ' ', User.first_name,'', IFNULL(CONCAT(', ',User.middle_name), '')) as full_name

      FROM

        backup_files as Backup LEFT JOIN

        users as User on User.id = Backup.user_id

      $date

      ORDER BY

        created DESC

              LIMIT

        $limit OFFSET $offset

      ) as Backup ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

    }

  public function paginate($query, array $options = []){

    $extra = isset($options['extra']) ? $options['extra'] : [];

    $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

    $page = $options['page'];

    $limit = $options['limit'];

    $result = $this->getAllFile($conditions, $limit, $page)->fetchAll('assoc');

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

    $date = $conditions['date'];

    $sql = "SELECT

        count(*) as count

      FROM

        backup_files as Backup

      $date  

      ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
