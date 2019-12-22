<?php

namespace App\Helpers;


class Helper
{
    const DEFAULT_VIEWS_PATH = 'App' . DS . 'Views';
    const DEFAULT_VIEWS_EXT = 'twig';

    public static function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function getViewPath(string $path): string
    {
        $paths = explode('.', $path);
        $paths = array_map(
            function ($path) use ($paths) {
                if ($path !== end($paths)) {
                    $path = ucfirst($path);
                }
                return $path;
            }, $paths
        );
        $systemPath = implode(DS, $paths);

        return self::DEFAULT_VIEWS_PATH . DS . $systemPath . '.' . self::DEFAULT_VIEWS_EXT;
    }
}