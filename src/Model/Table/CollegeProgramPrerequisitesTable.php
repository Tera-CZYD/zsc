<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CollegeProgramPrerequisites Model
 *
 * @property \App\Model\Table\CollegeProgramsTable&\Cake\ORM\Association\BelongsTo $CollegePrograms
 * @property \App\Model\Table\CollegeProgramCoursesTable&\Cake\ORM\Association\BelongsTo $CollegeProgramCourses
 * @property \App\Model\Table\CoursesTable&\Cake\ORM\Association\BelongsTo $Courses
 *
 * @method \App\Model\Entity\CollegeProgramPrerequisite newEmptyEntity()
 * @method \App\Model\Entity\CollegeProgramPrerequisite newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite get($primaryKey, $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramPrerequisite[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CollegeProgramPrerequisitesTable extends Table
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

        $this->setTable('college_program_prerequisites');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CollegePrograms', [
            'foreignKey' => 'college_program_id',
        ]);
        $this->belongsTo('CollegeProgramCourses', [
            'foreignKey' => 'college_program_course_id',
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'propertyName' => 'course_data',
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
            ->integer('college_program_course_id')
            ->allowEmptyString('college_program_course_id');

        $validator
            ->integer('course_id')
            ->allowEmptyString('course_id');

        $validator
            ->scalar('course')
            ->maxLength('course', 255)
            ->allowEmptyString('course');

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
        $rules->add($rules->existsIn('college_program_course_id', 'CollegeProgramCourses'), ['errorField' => 'college_program_course_id']);
        $rules->add($rules->existsIn('course_id', 'Courses'), ['errorField' => 'course_id']);

        return $rules;
    }
}
