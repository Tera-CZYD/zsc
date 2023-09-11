<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;

class ClassScheduleTmpsTable extends Table{

  public function initialize(array $config): void{

      $this->addBehavior('Timestamp');

      $this->hasMany('ClassScheduleDays', [

        'foreignKey' => 'class_schedule_subs_id', 

      ]);

    }

}
