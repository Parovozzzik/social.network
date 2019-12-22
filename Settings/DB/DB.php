<?php

namespace Settings\DB;

use PDO;

/**
 * Class DB
 * @package Settings\DB
 */
class DB
{
    /** @var \PDO */
    protected static $connection;

    /**
     * @return \PDO
     */
    public static function connection(): PDO
    {
        //if (!self::$connection instanceof PDO) {
        $host = getenv('DB_HOST');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        $database = getenv('DB_DATABASE');
        $port = getenv('DB_PORT');

        $dns = 'mysql' . ':host=' . $host . ((!empty($port)) ? (';port=' . $port) : '') . ';dbname=' . $database;

        self::$connection = (new PDO($dns, $user, $password));
        //}

        return self::$connection;
    }
}