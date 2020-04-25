<?php

namespace App\Settings\DB;

use PDO;

/**
 * Class DB
 * @package App\Settings\DB
 */
class DB
{
    /** @var \PDO */
    protected static $connection;

    /**
     * @param string $host
     * @return PDO
     */
    public static function connection(string $host = ''): PDO
    {
        //if (!self::$connection instanceof PDO) {
        if ($host === '') {
            $host = getenv('DB_HOST_MASTER');
        }
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        $database = getenv('DB_DATABASE');
        $port = getenv('DB_PORT');

        $dns = 'mysql' . ':host=' . $host . ((!empty($port)) ? (';port=' . $port) : '') . ';dbname=' . $database;

        self::$connection = new PDO($dns, $user, $password);
        //}

        return self::$connection;
    }
}