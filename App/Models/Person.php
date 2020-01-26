<?php

namespace App\Models;

use App\Models\Entities\EPerson;

/**
 * Class Person
 * @package App\Models
 */
class Person extends Model
{
    /** @var string */
    public $entityName = EPerson::class;

    /**
     * @param int $userId
     * @return EPerson|null
     */
    public function getByUserId(int $userId): ?EPerson
    {
        $query = $this->connection->prepare("SELECT * FROM {$this->entity::$table} WHERE user_id = ?;");
        $query->bindParam(1, $userId);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result !== false ? new EPerson($result) : null;
    }
}