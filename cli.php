<?php

include 'vendor/autoload.php';

define('DS', DIRECTORY_SEPARATOR);

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $workerDir = realpath(__DIR__) . '/App/Services/Generators';
    $workerName = array_key_exists(1, $argv) ? $argv[1] : null;
    $workerPath = search_file($workerDir, $workerName);
    if (!$workerPath) {
        throw new Exception('Bad arguments: worker name not set' . PHP_EOL);
    }

    require 'App/Services/Generators/' . $workerName . '.php';
    $workerClass = "App\\Services\\Generators\\" . $workerName;

    $worker = new $workerClass();
    $worker->run();

} catch (\Throwable $e) {
    echo $e->getMessage();
}

/**
 * @param $folderName
 * @param $fileName
 * @return bool
 */
function search_file($folderName, $fileName) {
    $Directory = new RecursiveDirectoryIterator($folderName);
    $Iterator = new RecursiveIteratorIterator($Directory);

    foreach ($Iterator as $name => $object) {
        if (strnatcmp($fileName . '.php', $object->getFilename()) == 0) {
            return $object->getPathname();
        }
    }

    return false;
}
