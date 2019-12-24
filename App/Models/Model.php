<?php

namespace App\Models;

use App\Models\Entities\Entity;
use Settings\DB\DB;

/**
 * Class Model
 * @package App\Models
 */
class Model
{
    /** @var Entity */
    protected $entity;
    /** @var string */
    protected $entityName;
    /** @var false|\mysqli */
    protected $connection;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->connection = DB::connection();
        $this->entity = new $this->entityName();
    }

    /**
     * @param string $query
     * @return array
     */
    public function query(string $query): array
    {
        $this->connection->query($query);
    }

    /**
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        $query = $this->connection->prepare(
            "SELECT * 
            FROM {$this->entity::$table} 
            WHERE {$this->entity::$idColumn} = ?");
        $query->bindParam(1, $id);
        $query->execute();

        return $query->fetch(\PDO::FETCH_ASSOC);
    }
}