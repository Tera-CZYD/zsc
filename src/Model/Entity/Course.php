<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Course Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $code_old
 * @property string|null $title
 * @property string|null $description
 * @property string|null $credit_hours
 * @property string|null $lecture_hours
 * @property string|null $laboratory_hours
 * @property string|null $credit_unit
 * @property string|null $lecture_unit
 * @property string|null $laboratory_unit
 * @property int $active
 * @property int $visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\AddingDroppingSubjectSub[] $adding_dropping_subject_subs
 * @property \App\Model\Entity\AwardeeManagement[] $awardee_managements
 * @property \App\Model\Entity\BlockSectionCourse[] $block_section_courses
 * @property \App\Model\Entity\ClassScheduleSub[] $class_schedule_subs
 * @property \App\Model\Entity\CollegeProgramCorequisite[] $college_program_corequisites
 * @property \App\Model\Entity\CollegeProgramCourse[] $college_program_courses
 * @property \App\Model\Entity\CollegeProgramPrerequisite[] $college_program_prerequisites
 * @property \App\Model\Entity\CounselingIntake[] $counseling_intakes
 * @property \App\Model\Entity\CurriculumCourseCorequisite[] $curriculum_course_corequisites
 * @property \App\Model\Entity\CurriculumCourseEquivalency[] $curriculum_course_equivalencies
 * @property \App\Model\Entity\CurriculumCoursePrerequisite[] $curriculum_course_prerequisites
 * @property \App\Model\Entity\CurriculumCourse[] $curriculum_courses
 * @property \App\Model\Entity\Dental[] $dentals
 * @property \App\Model\Entity\Evaluation[] $evaluations
 * @property \App\Model\Entity\FacultyEvaluation[] $faculty_evaluations
 * @property \App\Model\Entity\GcoEvaluation[] $gco_evaluations
 * @property \App\Model\Entity\MedicalCertificate[] $medical_certificates
 * @property \App\Model\Entity\MedicalConsent[] $medical_consents
 * @property \App\Model\Entity\MedicalStudentProfile[] $medical_student_profiles
 * @property \App\Model\Entity\ParticipantEvaluationActivity[] $participant_evaluation_activities
 * @property \App\Model\Entity\QuestionnaireEvaluated[] $questionnaire_evaluateds
 * @property \App\Model\Entity\ReferralSlip[] $referral_slips
 * @property \App\Model\Entity\RequestForm[] $request_forms
 * @property \App\Model\Entity\StudentBehavior[] $student_behaviors
 * @property \App\Model\Entity\StudentClearance[] $student_clearances
 * @property \App\Model\Entity\StudentEnrolledCourse[] $student_enrolled_courses
 * @property \App\Model\Entity\StudentEnrolledSchedule[] $student_enrolled_schedules
 * @property \App\Model\Entity\StudentExit[] $student_exits
 */
class Course extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'code' => true,
        'code_old' => true,
        'title' => true,
        'description' => true,
        'credit_hours' => true,
        'lecture_hours' => true,
        'laboratory_hours' => true,
        'credit_unit' => true,
        'lecture_unit' => true,
        'laboratory_unit' => true,
        'active' => true,
        'visible' => true,
        'created' => true,
        'modified' => true,
        'adding_dropping_subject_subs' => true,
        'awardee_managements' => true,
        'block_section_courses' => true,
        'class_schedule_subs' => true,
        'college_program_corequisites' => true,
        'college_program_courses' => true,
        'college_program_prerequisites' => true,
        'counseling_intakes' => true,
        'curriculum_course_corequisites' => true,
        'curriculum_course_equivalencies' => true,
        'curriculum_course_prerequisites' => true,
        'curriculum_courses' => true,
        'dentals' => true,
        'evaluations' => true,
        'faculty_evaluations' => true,
        'gco_evaluations' => true,
        'medical_certificates' => true,
        'medical_consents' => true,
        'medical_student_profiles' => true,
        'participant_evaluation_activities' => true,
        'questionnaire_evaluateds' => true,
        'referral_slips' => true,
        'request_forms' => true,
        'student_behaviors' => true,
        'student_clearances' => true,
        'student_enrolled_courses' => true,
        'student_enrolled_schedules' => true,
        'student_exits' => true,
    ];
}
