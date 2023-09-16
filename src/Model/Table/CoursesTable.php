<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CoursesTable extends Table
{
    
    public function initialize(array $config): void {

        parent::initialize($config);

        $this->addBehavior('Timestamp');

        $this->hasMany('AddingDroppingSubjectSubs', [
            'foreignKey' => 'course_id',
        ]);
        $this->belongsTo('YearLevelTerms',[
            'foreignKey' => 'year_term_id',
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

    public function getAllCoursePrint($conditions){

        $date = @$conditions['date'];

        $search = @$conditions['search'];

        $course = @$conditions['course'];

        $sql = "

          SELECT

            Course.*

          FROM

            courses as Course

          WHERE

            Course.visible = true $date $course AND

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

        $date = @$conditions['date'];

        $search = @$conditions['search'];

        $year = @$conditions['year'];

        // $college_id = @$conditions['college_id'];

        $offset = ($page - 1) * $limit;

        $sql = "

          SELECT

            Course.*,

            YearLevelTerm.description as yearDescription

          FROM

            courses as Course LEFT JOIN 

            year_level_terms as YearLevelTerm ON YearLevelTerm.id = Course.year_term_id

          WHERE

            Course.visible = true $date $year AND 

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

        $date = @$conditions['date'];

        $search = @$conditions['search'];

        $course = @$conditions['course'];

        // $college_id = @$conditions['college_id'];

        $sql = "

          SELECT

            count(*) as count

           FROM

            courses as Course 

          WHERE

            Course.visible = true $date $course AND 

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
