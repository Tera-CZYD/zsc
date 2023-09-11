<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Room Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $short_name
 * @property int|null $building_id
 * @property int|null $room_type_id
 * @property string|null $size
 * @property int|null $capacity
 * @property string|null $remarks
 * @property int|null $active
 * @property int $visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Building $building
 * @property \App\Model\Entity\RoomType $room_type
 * @property \App\Model\Entity\BlockSectionCourse[] $block_section_courses
 * @property \App\Model\Entity\ClassScheduleDay[] $class_schedule_days
 * @property \App\Model\Entity\ClassScheduleTmp[] $class_schedule_tmps
 * @property \App\Model\Entity\StudentEnrolledSchedule[] $student_enrolled_schedules
 */
class Room extends Entity
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
        'name' => true,
        'short_name' => true,
        'building_id' => true,
        'room_type_id' => true,
        'size' => true,
        'capacity' => true,
        'remarks' => true,
        'active' => true,
        'visible' => true,
        'created' => true,
        'modified' => true,
        'building' => true,
        'room_type' => true,
        'block_section_courses' => true,
        'class_schedule_days' => true,
        'class_schedule_tmps' => true,
        'student_enrolled_schedules' => true,
    ];
}
