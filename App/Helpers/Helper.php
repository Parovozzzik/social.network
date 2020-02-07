<?php

namespace App\Helpers;

/**
 * Class Helper
 * @package App\Helpers
 */
class Helper
{
    /** @var string */
    const DEFAULT_VIEWS_PATH = 'App' . DS . 'Views';
    /** @var string */
    const DEFAULT_VIEWS_EXT = 'twig';

    /**
     * @param string $password
     * @return string
     */
    public static function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function getViewPath(string $path): string
    {
        $paths = explode('.', $path);

        $newPath = [];
        $last = array_key_last($paths);
        foreach ($paths as $key => $path) {
            if ($key !== $last) {
                $newPath[] = ucfirst($path);
            } else {
                $newPath[] = $path;
            }
        }

        $systemPath = implode(DS, $newPath);

        return self::DEFAULT_VIEWS_PATH . DS . $systemPath . '.' . self::DEFAULT_VIEWS_EXT;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generateConfirmCode(int $length = 16): string
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }

        return $string;
    }
}