<?php

namespace App\Services\Generators;

use App\Settings\DB\DB;

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