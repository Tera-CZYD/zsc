<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class RoomsTable extends Table{

  public function initialize(array $config): void{
    $this->setTable('rooms');
    $this->setDisplayField('name');
    $this->setPrimaryKey('id');

    $this->addBehavior('Timestamp');

    $this->belongsTo('Buildings', [
        'foreignKey' => 'building_id',
    ]);
    $this->belongsTo('RoomTypes', [
        'foreignKey' => 'room_type_id',
    ]);
    $this->hasMany('BlockSectionCourses', [
        'foreignKey' => 'room_id',
    ]);
    $this->hasMany('ClassScheduleDays', [
        'foreignKey' => 'room_id',
    ]);
    $this->hasMany('ClassScheduleTmps', [
        'foreignKey' => 'room_id',
    ]);
    $this->hasMany('StudentEnrolledSchedules', [
        'foreignKey' => 'room_id',
    ]);

    $this->addBehavior('Timestamp');

  }

  public function getAllRoom($conditions, $limit, $page){

    $search = @$conditions['search'];

    $college_id = @$conditions['college_id'];

    $building_id = @$conditions['building_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Room.*,

        Building.name as building_name,

        RoomType.room_type,

        College.name as CollegeName,

        College.code as CollegeCode

      FROM

        rooms as Room LEFT JOIN

        buildings as Building ON Room.building_id = Building.id LEFT JOIN

        room_types as RoomType ON Room.room_type_id = RoomType.id LEFT JOIN 

        colleges as College ON Room.college_id = College.id

      WHERE

      Room.visible = true $college_id $building_id AND

        (

          Room.code       LIKE  '%$search%' OR

          Room.name       LIKE  '%$search%' OR

          Room.size        LIKE  '%$search%' OR

          Room.capacity        LIKE  '%$search%' OR

          Building.name          LIKE  '%$search%'

        )


      ORDER BY 

        Room.code ASC

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

    $result = $this->getAllRoom($conditions, $limit, $page)->fetchAll('assoc');

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

    $college_id = @$conditions['college_id'];

    $building_id = @$conditions['building_id'];

    $sql = "SELECT

        count(*) as count

       FROM

        rooms as Room LEFT JOIN

        buildings as Building ON Room.building_id = Building.id LEFT JOIN

        room_types as RoomType ON Room.room_type_id = RoomType.id

      WHERE

        Room.visible = true $college_id $building_id AND

        (

          Room.code       LIKE  '%$search%' OR

          Room.name       LIKE  '%$search%' OR

          Room.size        LIKE  '%$search%' OR

          Room.capacity        LIKE  '%$search%' OR

          Building.name          LIKE  '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
