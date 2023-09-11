<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Courses Model
 *
 * @property \App\Model\Table\AddingDroppingSubjectSubsTable&\Cake\ORM\Association\HasMany $AddingDroppingSubjectSubs
 * @property \App\Model\Table\AwardeeManagementsTable&\Cake\ORM\Association\HasMany $AwardeeManagements
 * @property \App\Model\Table\BlockSectionCoursesTable&\Cake\ORM\Association\HasMany $BlockSectionCourses
 * @property \App\Model\Table\ClassScheduleSubsTable&\Cake\ORM\Association\HasMany $ClassScheduleSubs
 * @property \App\Model\Table\CollegeProgramCorequisitesTable&\Cake\ORM\Association\HasMany $CollegeProgramCorequisites
 * @property \App\Model\Table\CollegeProgramCoursesTable&\Cake\ORM\Association\HasMany $CollegeProgramCourses
 * @property \App\Model\Table\CollegeProgramPrerequisitesTable&\Cake\ORM\Association\HasMany $CollegeProgramPrerequisites
 * @property \App\Model\Table\CounselingIntakesTable&\Cake\ORM\Association\HasMany $CounselingIntakes
 * @property \App\Model\Table\CurriculumCourseCorequisitesTable&\Cake\ORM\Association\HasMany $CurriculumCourseCorequisites
 * @property \App\Model\Table\CurriculumCourseEquivalenciesTable&\Cake\ORM\Association\HasMany $CurriculumCourseEquivalencies
 * @property \App\Model\Table\CurriculumCoursePrerequisitesTable&\Cake\ORM\Association\HasMany $CurriculumCoursePrerequisites
 * @property \App\Model\Table\CurriculumCoursesTable&\Cake\ORM\Association\HasMany $CurriculumCourses
 * @property \App\Model\Table\DentalsTable&\Cake\ORM\Association\HasMany $Dentals
 * @property \App\Model\Table\EvaluationsTable&\Cake\ORM\Association\HasMany $Evaluations
 * @property \App\Model\Table\FacultyEvaluationsTable&\Cake\ORM\Association\HasMany $FacultyEvaluations
 * @property \App\Model\Table\GcoEvaluationsTable&\Cake\ORM\Association\HasMany $GcoEvaluations
 * @property \App\Model\Table\MedicalCertificatesTable&\Cake\ORM\Association\HasMany $MedicalCertificates
 * @property \App\Model\Table\MedicalConsentsTable&\Cake\ORM\Association\HasMany $MedicalConsents
 * @property \App\Model\Table\MedicalStudentProfilesTable&\Cake\ORM\Association\HasMany $MedicalStudentProfiles
 * @property \App\Model\Table\ParticipantEvaluationActivitiesTable&\Cake\ORM\Association\HasMany $ParticipantEvaluationActivities
 * @property \App\Model\Table\QuestionnaireEvaluatedsTable&\Cake\ORM\Association\HasMany $QuestionnaireEvaluateds
 * @property \App\Model\Table\ReferralSlipsTable&\Cake\ORM\Association\HasMany $ReferralSlips
 * @property \App\Model\Table\RequestFormsTable&\Cake\ORM\Association\HasMany $RequestForms
 * @property \App\Model\Table\StudentBehaviorsTable&\Cake\ORM\Association\HasMany $StudentBehaviors
 * @property \App\Model\Table\StudentClearancesTable&\Cake\ORM\Association\HasMany $StudentClearances
 * @property \App\Model\Table\StudentEnrolledCoursesTable&\Cake\ORM\Association\HasMany $StudentEnrolledCourses
 * @property \App\Model\Table\StudentEnrolledSchedulesTable&\Cake\ORM\Association\HasMany $StudentEnrolledSchedules
 * @property \App\Model\Table\StudentExitsTable&\Cake\ORM\Association\HasMany $StudentExits
 *
 * @method \App\Model\Entity\Course newEmptyEntity()
 * @method \App\Model\Entity\Course newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Course[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Course get($primaryKey, $options = [])
 * @method \App\Model\Entity\Course findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Course patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Course[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Course|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CoursesTable extends Table
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

        $this->setTable('courses');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('AddingDroppingSubjectSubs', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('AwardeeManagements', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('BlockSectionCourses', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('ClassScheduleSubs', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CollegeProgramCorequisites', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CollegeProgramCourses', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CollegeProgramPrerequisites', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CounselingIntakes', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CurriculumCourseCorequisites', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CurriculumCourseEquivalencies', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CurriculumCoursePrerequisites', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('CurriculumCourses', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('Dentals', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('Evaluations', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('FacultyEvaluations', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('GcoEvaluations', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('MedicalCertificates', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('MedicalConsents', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('MedicalStudentProfiles', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('ParticipantEvaluationActivities', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('QuestionnaireEvaluateds', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('ReferralSlips', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('RequestForms', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('StudentBehaviors', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('StudentClearances', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('StudentEnrolledCourses', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('StudentEnrolledSchedules', [
            'foreignKey' => 'course_id',
        ]);
        $this->hasMany('StudentExits', [
            'foreignKey' => 'course_id',
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
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->scalar('code_old')
            ->maxLength('code_old', 255)
            ->allowEmptyString('code_old');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 1000)
            ->allowEmptyString('description');

        $validator
            ->scalar('credit_hours')
            ->maxLength('credit_hours', 10)
            ->allowEmptyString('credit_hours');

        $validator
            ->scalar('lecture_hours')
            ->maxLength('lecture_hours', 10)
            ->allowEmptyString('lecture_hours');

        $validator
            ->scalar('laboratory_hours')
            ->maxLength('laboratory_hours', 10)
            ->allowEmptyString('laboratory_hours');

        $validator
            ->scalar('credit_unit')
            ->maxLength('credit_unit', 10)
            ->allowEmptyString('credit_unit');

        $validator
            ->scalar('lecture_unit')
            ->maxLength('lecture_unit', 10)
            ->allowEmptyString('lecture_unit');

        $validator
            ->scalar('laboratory_unit')
            ->maxLength('laboratory_unit', 10)
            ->allowEmptyString('laboratory_unit');

        $validator
            ->notEmptyString('active');

        $validator
            ->notEmptyString('visible');

        return $validator;
    }

    public function getAllCoursePrint($conditions){

    $search = @$conditions['search'];

    $sql = "

      SELECT

        Course.*

      FROM

        courses as Course

      WHERE

        Course.visible = true AND

        (
 
          Course.code LIKE '%$search%' OR

          Course.title     LIKE  '%$search%' OR

          Course.description    LIKE  '%$search%' 

        )

      ORDER BY 

        Course.code ASC

    ";

    $query = $this->getConnection()->prepare($sql);

    $query->execute();

    return $query;

  }

    public function getAllCourse($conditions, $limit, $page){

    $search = @$conditions['search'];

    // $college_id = @$conditions['college_id'];

    $offset = ($page - 1) * $limit;

    $sql = "

      SELECT

        Course.*

      FROM

        courses as Course

      WHERE

        Course.visible = true AND 

        (


          Course.code         LIKE  '%$search%' OR

          Course.title         LIKE  '%$search%' OR

          Course.description         LIKE  '%$search%' 

        )

      GROUP BY

        Course.id

      ORDER BY 

        Course.code ASC

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

    $result = $this->getAllCourse($conditions, $limit, $page)->fetchAll('assoc');

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

    // $college_id = @$conditions['college_id'];

    $sql = "

      SELECT

        count(*) as count

       FROM

        courses as Course 

      WHERE

        Course.visible = true AND 

        (

          Course.code         LIKE  '%$search%' OR

          Course.title         LIKE  '%$search%' OR

          Course.description         LIKE  '%$search%' 

        )

    ";

    $query = $this->getConnection()->execute($sql)->fetch('assoc');

    return $query['count'];

  }

}
