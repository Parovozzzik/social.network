<?php

namespace App\Settings\Routes;

/**
 * Class Routes
 * @package App\Settings\Routes
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
                ],
            ],
            '#^/users/restore-password$#' => [
                'controller' => 'Users',
                'action' => 'restorePassword',
            ],
            '#^/users/change-password$#' => [
                'controller' => 'Users',
                'action' => 'changePassword',
            ],
            '#^/users/confirm-email/(?P<email>.+)/(?P<code>.+)$#' => [
                'controller' => 'Users',
                'action' => 'confirmEmail',
                'params' => [
                    'email',
                    'code',
                ],
            ],
            '#^/users/resend-confirm-email$#' => [
                'controller' => 'Users',
                'action' => 'resendConfirmEmail',
            ],

            '#^/persons$#' => [
                'controller' => 'Persons',
                'action' => 'Index'
            ],
            '#^/persons/my$#' => [
                'controller' => 'Persons',
                'action' => 'my',
            ],
            '#^/persons/create$#' => [
                'controller' => 'Persons',
                'action' => 'create',
            ],
            '#^/persons/edit$#' => [
                'controller' => 'Persons',
                'action' => 'edit',
            ],
            '#^/persons/view/(?P<id>[0-9-]+)$#' => [
                'controller' => 'Persons',
                'action' => 'view',
                'params' => [
                    'id',
                ],
            ],
        ];
    }
}