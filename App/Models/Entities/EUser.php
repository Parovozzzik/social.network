<?php

namespace App\Models\Entities;

/**
 * Class EUser
 * @package App\Models\Entities
 *
 * @property integer $userId
 * @property string $email
 * @property string $password
 * @property integer $deleted
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class EUser extends Entity
{
    /** @var string */
    public static $table = 'users';
    /** @var string */
    public static $idColumn = 'user_id';
}