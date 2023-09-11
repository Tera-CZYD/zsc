<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AwardeeManagement Entity
 *
 * @property int $id
 * @property string|null $student_name
 * @property int|null $student_id
 * @property string|null $student_no
 * @property string|null $date
 * @property string|null $section_id
 * @property string|null $course_id
 * @property string|null $college_id
 * @property string|null $program_id
 * @property string|null $program
 * @property string|null $award_id
 * @property string|null $year
 * @property string|null $semester
 * @property string|null $code
 * @property int $visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\College $college
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\Course $course
 */
class AwardeeManagement extends Entity
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
        'student_name' => true,
        'student_id' => true,
        'student_no' => true,
        'date' => true,
        'section_id' => true,
        'section' => true,
        'course_id' => true,
        'college_id' => true,
        'program_id' => true,
        'college' => true,
        'program' => true,
        'award_id' => true,
        'year' => true,
        'semester' => true,
        'code' => true,
        'visible' => true,
        'created' => true,
        'modified' => true,
        'student' => true,
        'course' => true,
    ];
}
