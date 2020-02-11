<?php

namespace App\Models\Entities;

/**
 * Class EPerson
 * @package App\Models\Entities
 *
 * @property integer $personId
 * @property integer $userId
 * @property string $firstName
 * @property string $lastName
 * @property integer $dateBirth
 * @property string $gender
 * @property string $hobbies
 * @property integer $deleted
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class EPerson extends Entity
{
    /** @var string */
    public static $table = 'persons';
    /** @var string */
    public static $idColumn = 'person_id';
}