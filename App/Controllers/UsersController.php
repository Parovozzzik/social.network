<?php

namespace App\Controllers;

use App\Models\Entities\EUser;
use App\Models\Entities\Requests\ELoginUser;
use App\Models\Entities\Requests\ERegistrationUser;
use App\Models\Entities\Responses\EUserResponse;
use App\Models\Entities\Responses\Response;
use App\Models\User;

/**
 * Class UsersController
 * @package App\Controllers
 */
class UsersController extends Controller
{
    public function index()
    {
        $response = new EUserResponse();
        $response->setView('users.index');
        return $this->render($response);
    }

    public function view(int $id)
    {
        $userModel = new User();
        $data = $userModel->get($id);
        $response = new EUserResponse();

        if (count($data) > 0) {
            $user = new EUser($data);
            $response->setModel($user);
        } else {
            $response->setErrors(['Пользователя с текущим идентификатором не существует!']);
        }
        $response->setView('users.view');

        return $this->render($response);
    }

    public function login()
    {
        $request = $_POST['user'];
        if (isset($request)) {
            $loginDto = new ELoginUser($request);
            $loginDto->setEmail($request['email']);
            $loginDto->setPassword($request['password']);

            $userModel = new User();
            $response = $userModel->login($loginDto);
            $response->setView('users.login');
        } else {
            $response = new EUserResponse();
            $response->setView('users.login');
        }

        return $this->render($response);
    }

    public function registration(): Response
    {
        $request = $_POST['user'];
        if (isset($request)) {
            $registrationDto = new ERegistrationUser();
            $registrationDto->setEmail($request['email']);
            $registrationDto->setPassword($request['password']);

            $userModel = new User();
            $response = $userModel->registration($registrationDto);
        }
        $response->setView('users.registration');

        return $response;
    }

    public function restorePassword()
    {


    }

    public function resetPassword()
    {

    }
}