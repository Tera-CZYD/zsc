<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class UsersTable extends Table{

  public function initialize(array $config): void {

    $this->addBehavior('Timestamp');

    $this->hasMany('UserPermissions', [

      'foreignKey' => 'user_id', 

    ]);

    $this->belongsTo('Roles', [

      'foreignKey' => 'roleId', 

    ]);

    $this->belongsTo('Students', [

      'foreignKey' => 'studentId', 

    ]);

    $this->belongsTo('Employees', [

      'foreignKey' => 'employeeId', 

    ]);

  }

  public function beforeSave($event, $entity, $options){

    if ($entity->isDirty('password')) {

      $passwordHasher = new DefaultPasswordHasher();

      $entity->password = $passwordHasher->hash($entity->password);

    }

  }

  public function validSave($data){

    
    $result = [];

    $data['lastName'] = ucwords(@$data['lastName']);

    $data['firstName'] = ucwords(@$data['firstName']);

    if (isset($data['password'])) {

      $data['mobile_password'] = md5($data['password']);

    }

    $existingConditions = [];

    $existingConditions['username'] = @$data['username'];

    $existingConditions['visible'] = true;

    if (isset($data['id'])) {

      $existingConditions['id !='] = $data['id'];

    }



    $existing = $this->find()

    ->where($existingConditions)

    ->first();

    if ($existing) {

      $result = [

        'data' => $data,

        'ok' => false,

        'msg' => 'User account already exists.'

      ];

    } else {

      $entity = $this->newEntity($data);

      if ($this->save($entity)) {

        $data['id'] = $entity->id;

        $result = [

          'data' => $data,

          'ok' => true,

          'msg' => 'User account has been successfully saved.'

        ];

      }

    }

    return $result;

  }

  public function getAllUser($conditions, $limit, $page){

    $search = @$conditions['search'];

    $role = @$conditions['User'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        User.id,

        CONCAT(IFNULL(User.first_name,''),' ',IFNULL(User.last_name,'')) as full_name,

        User.username,

        User.first_name,

        User.last_name,

        Role.name,

        User.developer,

        User.active

        FROM

          users as User LEFT JOIN roles as Role ON User.roleId = Role.id 

         WHERE

          User.visible = true $role AND 

          (

            User.username LIKE '%$search%' OR

            User.first_name LIKE '%$search%' OR

            User.last_name LIKE '%$search%' OR

            Role.name LIKE '%$search%'

          )
          
        ORDER BY 

        User.first_name ASC,

        User.last_name ASC

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

    $result = $this->getAllUser($conditions, $limit, $page)->fetchAll('assoc');

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

    $role = @$conditions['User'];

    $sql = "

      SELECT

        count(*) as count

      FROM

        users as User LEFT JOIN roles as Role ON User.roleId = Role.id 

      WHERE

        User.visible = true $role AND 

        (

          User.username LIKE '%$search%' OR

          User.first_name LIKE '%$search%' OR

          User.last_name LIKE '%$search%' OR

          Role.name LIKE '%$search%'

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}