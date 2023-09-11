<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Campus Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $short_name
 * @property string|null $address
 * @property int $active
 * @property int $visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Building[] $buildings
 */
class Campus extends Entity
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
        'address' => true,
        'active' => true,
        'visible' => true,
        'created' => true,
        'modified' => true,
        'buildings' => true,
    ];
}
