<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class BlockSectionSchedulesTable extends Table{

    public function initialize(array $config): void {

     $this->addBehavior('Timestamp');

    }

  }