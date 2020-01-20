<?php

namespace App\Controllers;

use App\Models\Entities\Responses\Response;

/**
 * Class IndexController
 * @package App\Controllers
 */
class IndexController extends Controller
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'index' => true,
        ];
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $response = new Response();
        $response->setView('index.index');

        return $this->render($response);
    }
}