<?php

  namespace App\Model\Table;

  use Cake\ORM\Table;

  class AddingDroppingSubjectSubsTable extends Table{

    public function initialize(array $config): void {

     $this->belongsTo('AddingDroppingSubjectSubs', [

      'foreignKey' => 'adding_dropping_subject_id',

    ]);

    }

  }