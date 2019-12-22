<?php

namespace Settings\Routes;

/**
 * Class Routes
 * @package Settings\Routes
 */
class Routes
{
    /**
     * @return array
     */
    public static function get(): array
    {
        return [
            '#^/$#' => [
                'controller' => 'Index',
                'action' => 'Index'
            ],
            '#^/users$#' => [
                'controller' => 'Users',
                'action' => 'Index'
            ],
            '#^/users/registration$#' => [
                'controller' => 'Users',
                'action' => 'registration'
            ],
            '#^/users/login$#' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            '#^/users/view$#' => [
                'controller' => 'Users',
                'action' => 'login',
                'params' => [
                    'id'
                ]
            ],
            '#^/users/restore-password$#' => [
                'controller' => 'Users',
                'action' => 'restorePassword'
            ],
            '#^/users/reset-password$#' => [
                'controller' => 'User',
                'action' => 'resetPassword'
            ],
        ];
    }
}