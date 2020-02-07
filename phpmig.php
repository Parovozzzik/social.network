<?php

include 'vendor/autoload.php';

use Dotenv\Dotenv;
use Phpmig\Adapter;
use App\Settings\DB\DB;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new ArrayObject();

$db = DB::connection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');

$container['db'] = $db;
$container['phpmig.adapter'] = new Adapter\PDO\Sql($container['db'], 'migrations');
$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;