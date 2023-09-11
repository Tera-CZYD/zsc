<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CollegeProgramCourses Model
 *
 * @property \App\Model\Table\CollegeProgramsTable&\Cake\ORM\Association\BelongsTo $CollegePrograms
 * * @property \App\Model\Table\CollegeProgramsTable&\Cake\ORM\Association\BelongsTo $YearLevelTerms
 * @property \App\Model\Table\CoursesTable&\Cake\ORM\Association\BelongsTo $Courses
 * @property \App\Model\Table\CollegeProgramCorequisitesTable&\Cake\ORM\Association\HasMany $CollegeProgramCorequisites
 * @property \App\Model\Table\CollegeProgramPrerequisitesTable&\Cake\ORM\Association\HasMany $CollegeProgramPrerequisites
 *
 * @method \App\Model\Entity\CollegeProgramCourse newEmptyEntity()
 * @method \App\Model\Entity\CollegeProgramCourse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse get($primaryKey, $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CollegeProgramCourse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CollegeProgramCoursesTable extends Table
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

        $this->setTable('college_program_courses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CollegePrograms', [
            'foreignKey' => 'college_program_id',
            'propertyName' => 'CollegeProgram',
        ]);
        $this->belongsTo('YearLevelTerms', [
            'foreignKey' => 'year_term_id',
            'propertyName' => 'YearLevelTerm',
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER',
            'propertyName' => 'course_data',
        ]);
        $this->hasMany('CollegeProgramCorequisites', [
            'foreignKey' => 'college_program_course_id',
            'propertyName' => 'CollegeProgramCorequisite',

        ]);
        $this->hasMany('CollegeProgramPrerequisites', [
            'foreignKey' => 'college_program_course_id',
            'propertyName' => 'CollegeProgramPrerequisite',
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
            ->integer('course_id')
            ->notEmptyString('course_id');

        $validator
            ->scalar('course')
            ->maxLength('course', 255)
            ->requirePresence('course', 'create')
            ->notEmptyString('course');

        $validator
            ->integer('year_term_id')
            ->allowEmptyString('year_term_id');

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
        $rules->add($rules->existsIn('course_id', 'Courses'), ['errorField' => 'course_id']);

        return $rules;
    }
}
