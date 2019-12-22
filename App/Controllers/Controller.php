<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Entities\Responses\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    const HEAD_LAYOUT = 'App/Views/Templates/layout.twig';

    /**
     * @param Response $response
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(Response $response)
    {
        $loader = new FilesystemLoader('/');
        $twig = new Environment($loader);

        $path = Helper::getViewPath($response->getView());
        echo $twig->render(self::HEAD_LAYOUT,
            [
                'name' => 'John Doe',
                'occupation' => 'gardener',
                'data' => $response->toArray(),
                'content' => $path,
            ]
        );
    }
}