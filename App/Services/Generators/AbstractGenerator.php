<?php


namespace App\Services\Generators;


use App\Settings\DB\DB;

abstract class AbstractGenerator
{
    protected $db;

    public function __construct()
    {
        $this->db = DB::connection();
    }

    abstract public function run();
}