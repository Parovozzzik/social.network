<?php

namespace App\Controllers;

use App\Models\Entities\Responses\Response;

class IndexController extends Controller
{
    public function index()
    {
        $response = new Response();
        $response->setView('index.index');

        return $this->render($response);
    }
}