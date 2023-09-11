<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CollegeProgramPrerequisite Entity
 *
 * @property int $id
 * @property int|null $college_program_id
 * @property int|null $college_program_course_id
 * @property int|null $course_id
 * @property int $visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\CollegeProgram $college_program
 * @property \App\Model\Entity\CollegeProgramCourse $college_program_course
 */
class CollegeProgramPrerequisite extends Entity
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
        'college_program_course_id' => true,
        'course_id' => true,
        'course' => true,
        'visible' => true,
        'created' => true,
        'modified' => true,
        'college_program' => true,
        'college_program_course' => true,
    ];
}
