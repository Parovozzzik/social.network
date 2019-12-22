<?php

use Dotenv\Dotenv;
use Settings\Routes\Routes;

include 'vendor/autoload.php';

define('DS', DIRECTORY_SEPARATOR);

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$routes = Routes::get();
$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$controllerName = null;
$actionName = null;
foreach ($routes as $pattern => $settings) {
    if (preg_match($pattern, $path, $matches)) {
        $controllerName = $settings['controller'];
        $actionName = mb_strtolower($settings['action']);
        /*if (array_key_exists('params', $settings) && $settings['params']) {
            foreach ($settings['params'] as $paramName) {
                if (array_key_exists($paramName, $matches)) {
                    $_REQUEST[$paramName] = filter_var($matches[$paramName], FILTER_SANITIZE_STRING); //add some safe mode
                }
            }
        }*/
        break;
    }
}

$controllerFullName = ucfirst($controllerName) . 'Controller';
if (!class_exists($controllerFullName)) {
    $controller = 'App\\Controllers\\' . $controllerFullName;
}

try {
    $class = new $controller();
    if (method_exists($class, $actionName)) {
        $class->$actionName();
    }
} catch (\Throwable $e) {
    echo json_encode($e->getMessage());
}