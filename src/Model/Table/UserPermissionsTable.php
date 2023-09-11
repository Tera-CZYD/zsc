<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class UserPermissionsTable extends Table{

    public function initialize(array $config): void {

      $this->belongsTo('Users', [

        'foreignKey' => 'user_id', 

      ]);

      $this->belongsTo('Permissions', [

        'foreignKey' => 'permission_id', 

      ]);

    }

  }