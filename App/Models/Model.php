<?php

namespace App\Models;

use App\Models\Entities\Entity;
use App\Settings\DB\DB;

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
     * @return array|null
     */
    public function get(int $id): ?array
    {
        $query = $this->connection->prepare(
            "SELECT * 
            FROM {$this->entity::$table} 
            WHERE {$this->entity::$idColumn} = ?");
        $query->bindParam(1, $id);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            $result = null;
        }
        return $result;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getList(array $params = []): array
    {
        $queryWhere = '';
        if (count($params) > 0) {
            if (isset($params['limit'])) {
                $queryLimit = 'LIMIT ' . $params['limit'];
            }
            if (isset($params['offset'])) {
                $queryOffset = 'OFFSET ' . $params['offset'];
            }
        }

        $query = $this->connection->prepare(
            "SELECT * 
            FROM {$this->entity::$table} 
            WHERE deleted = 0 $queryWhere
            $queryLimit
            $queryOffset;"
        );
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $items = [];
        foreach ($result as $item) {
            $items[] = new $this->entity($item);
        }

        return $items;
    }
}