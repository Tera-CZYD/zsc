<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CollegeProgramSubs Model
 *
 * @property \App\Model\Table\CollegeProgramsTable&\Cake\ORM\Association\BelongsTo $CollegePrograms
 *
 * @method \App\Model\Entity\CollegeProgramSub newEmptyEntity()
 * @method \App\Model\Entity\CollegeProgramSub newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramSub[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramSub get($primaryKey, $options = [])
 * @method \App\Model\Entity\CollegeProgramSub findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CollegeProgramSub patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramSub[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramSub|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeProgramSub saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeProgramSub[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramSub[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramSub[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramSub[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CollegeProgramSubsTable extends Table
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

        $this->setTable('college_program_subs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CollegePrograms', [
            'foreignKey' => 'college_program_id',
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
            ->integer('college_program_id')
            ->allowEmptyString('college_program_id');

        $validator
            ->scalar('requirement')
            ->maxLength('requirement', 255)
            ->allowEmptyString('requirement');

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
        $rules->add($rules->existsIn('college_program_id', 'CollegePrograms'), ['errorField' => 'college_program_id']);

        return $rules;
    }
}
