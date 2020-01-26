<?php

namespace App\Models\Entities;

/**
 * Class EPerson
 * @package App\Models\Entities
 */
class EPerson extends Entity
{
    /** @var string */
    public static $table = 'persons';
    /** @var string */
    public static $idColumn = 'person_id';
}