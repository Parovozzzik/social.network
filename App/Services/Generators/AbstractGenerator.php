<?php

namespace App\Services\Generators;

use App\Settings\DB\DB;

/**
 * Class AbstractGenerator
 * @package App\Services\Generators
 */
abstract class AbstractGenerator
{
    /** @var \PDO */
    protected $db;

    /**
     * AbstractGenerator constructor.
     */
    public function __construct()
    {
        $this->db = DB::connection();
    }

    /**
     * @return mixed
     */
    abstract public function run();
}