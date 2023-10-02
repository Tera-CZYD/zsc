<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class AnnouncementsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

    $this->hasMany('AnnouncementImages', [

      'foreignKey' => 'announcement_id', 

    ]);

  }

  public function getAllAnnouncementPrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        Announcement.*

      FROM

        announcements as Announcement 

      WHERE

        Announcement.visible = true AND

        (
 
          Announcement.title           LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

  public function getAllAnnouncement($conditions, $limit, $page){

    $search = @$conditions['search'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Announcement.*

      FROM

        announcements as Announcement 

      WHERE

        Announcement.visible = true AND

        (
 
          Announcement.title           LIKE  '%$search%' 

        )

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

    $result = $this->getAllAnnouncement($conditions, $limit, $page)->fetchAll('assoc');

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

    $sql = "

      SELECT

        count(*) as count

       FROM

        announcements as Announcement 

      WHERE

        Announcement.visible = true AND

        (
 
          Announcement.title           LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
