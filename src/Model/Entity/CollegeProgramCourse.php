<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CollegeProgramCourse Entity
 *
 * @property int $id
 * @property int|null $college_program_id
 * @property int $course_id
 * @property int|null $year_term_id
 * @property int $visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\CollegeProgram $college_program
 * @property \App\Model\Entity\CollegeProgramCorequisite[] $college_program_corequisites
 * @property \App\Model\Entity\CollegeProgramPrerequisite[] $college_program_prerequisites
 */
class CollegeProgramCourse extends Entity
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
        'college_program_id' => true,
        'course_id' => true,
        'course' => true,
        'year_term_id' => true,
        'visible' => true,
        'created' => true,
        'modified' => true,
        'college_program' => true,
        'college_program_corequisites' => true,
        'college_program_prerequisites' => true,
    ];
}
