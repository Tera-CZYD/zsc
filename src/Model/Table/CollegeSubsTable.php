<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CollegeSubs Model
 *
 * @property \App\Model\Table\CollegesTable&\Cake\ORM\Association\BelongsTo $Colleges
 *
 * @method \App\Model\Entity\CollegeSub newEmptyEntity()
 * @method \App\Model\Entity\CollegeSub newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeSub[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeSub get($primaryKey, $options = [])
 * @method \App\Model\Entity\CollegeSub findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CollegeSub patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeSub[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeSub|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeSub saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeSub[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeSub[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeSub[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeSub[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CollegeSubsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('college_subs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Colleges', [
            'foreignKey' => 'college_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('college_id')
            ->allowEmptyString('college_id');

        $validator
            ->integer('program_id')
            ->allowEmptyString('program_id');

        $validator
            ->scalar('program')
            ->maxLength('program', 255)
            ->allowEmptyString('program');

        $validator
            ->notEmptyString('visible');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('college_id', 'Colleges'), ['errorField' => 'college_id']);

        return $rules;
    }
}
