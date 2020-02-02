<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Entities\EUser;
use App\Models\Entities\Responses\Response;
use App\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /** @var string */
    const HEAD_LAYOUT = 'App/Views/Templates/layout.twig';

    /** @var EUser */
    protected $user;

    /** @var bool */
    protected $isGuest = true;

    /** @var array */
    protected $request;

    /**
     * Controller constructor.
     * @param bool $sessionCheck
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __construct()
    {
        $this->request = $_REQUEST;

        if ((new User())->isLogin()) {
            $this->isGuest = false;
            $this->user = new EUser((new User())->get($_SESSION['id']));
        }
    }

    /**
     * @param Response $response
     * @param array $params
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(Response $response, array $params = [])
    {
        $loader = new FilesystemLoader('/');
        $twig = new Environment($loader);

        $path = Helper::getViewPath($response->getView());

        $user = $_SESSION['id'] ? (new User())->get($_SESSION['id']) : null;

        echo $twig->render(self::HEAD_LAYOUT,
            [
                'user' => $user,
                'data' => $response->toArray(),
                'content' => $path,
                'params' => $params,
            ]
        );
    }

    /**
     * @param string $path
     */
    public function redirect(string $path): void
    {
        echo header('Location: ' . $path);
    }
}