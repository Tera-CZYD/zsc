<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CollegeProgramSub Entity
 *
 * @property int $id
 * @property int|null $college_program_id
 * @property string|null $requirement
 * @property int $visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CollegeProgram $college_program
 */
class CollegeProgramSub extends Entity
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
        'requirement' => true,
        'visible' => true,
        'created' => true,
        'modified' => true,
        'college_program' => true,
    ];
}
