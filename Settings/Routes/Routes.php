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
            '#^/users/logout$#' => [
                'controller' => 'Users',
                'action' => 'logout'
            ],
            '#^/users/view/(?P<id>[0-9-]+)$#' => [
                'controller' => 'Users',
                'action' => 'view',
                'params' => [
                    'id',
                ]
            ],
            '#^/users/restore-password$#' => [
                'controller' => 'Users',
                'action' => 'restorePassword',
            ],
            '#^/users/change-password$#' => [
                'controller' => 'Users',
                'action' => 'changePassword',
            ],
        ];
    }
}