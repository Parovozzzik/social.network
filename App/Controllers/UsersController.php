<?php

namespace App\Controllers;

use App\Models\Entities\EUser;
use App\Models\Entities\Requests\EChangePasswordUser;
use App\Models\Entities\Requests\ELoginUser;
use App\Models\Entities\Requests\ERegistrationUser;
use App\Models\Entities\Responses\EUserListResponse;
use App\Models\Entities\Responses\EUserResponse;
use App\Models\User;

/**
 * Class UsersController
 * @package App\Controllers
 */
class UsersController extends Controller
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'index' => !$this->isGuest,
            'view' => !$this->isGuest,
            'login' => $this->isGuest,
            'registration' => $this->isGuest,
            'logout' => !$this->isGuest,
            'restorePassword' => !$this->isGuest,
            'changePassword' => !$this->isGuest,
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
        $users = (new User())->getList();

        $response = new EUserListResponse();
        $response->setUsers($users);
        $response->setView('users.index');

        return $this->render($response);
    }

    /**
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function view()
    {
        $id = $this->request['id'];

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

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {
        $request = $_POST['user'];

        if (isset($request)) {
            $request['remember'] = $request['remember'] === 'on' ? true : false;

            $loginDto = new ELoginUser($request);
            $loginDto->setEmail($request['email']);
            $loginDto->setPassword($request['password']);
            $loginDto->setRemember($request['remember']);

            $userModel = new User();
            $response = $userModel->login($loginDto);

            if ($response->getErrors() === null) {
                $this->redirect('/users/view/' . $response->getUserId());
            }
        } else {
            $response = new EUserResponse();
        }
        $response->setView('users.login');

        return $this->render($response, ['request' => $request]);
    }

    /**
     * logout
     */
    public function logout()
    {
        session_start();
        unset($_SESSION['id']);
        setcookie('email', '');
        setcookie('password', '');

        $this->redirect('/');
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function registration()
    {
        $request = $_POST['user'];

        if (isset($request)) {
            $registrationDto = new ERegistrationUser();
            $registrationDto->setEmail($request['email']);
            $registrationDto->setNewPassword($request['password']);
            $registrationDto->setRepeatPassword($request['repeatPassword']);

            $userModel = new User();
            $response = $userModel->registration($registrationDto);
        } else {
            $response = new EUserResponse();
        }
        $response->setView('users.registration');

        return $this->render($response, ['request' => $request]);
    }

    /**
     *
     */
    public function restorePassword()
    {

    }

    /**
     *
     */
    public function changePassword()
    {
        $request = $_POST['user'];

        if (isset($request)) {
            $changePasswordDto = new EChangePasswordUser();
            $changePasswordDto->setCurrentPassword($request['currentPassword']);
            $changePasswordDto->setNewPassword($request['newPassword']);
            $changePasswordDto->setRepeatPassword($request['repeatPassword']);

            $userModel = new User();
            $response = $userModel->changePassword($changePasswordDto);
        } else {
            $userModel = new User();
            $data = $userModel->get($_SESSION['id']);
            $response = new EUserResponse();

            if (count($data) > 0) {
                $user = new EUser($data);
                $response->setModel($user);
            } else {
                $response->setErrors(['Пользователя с текущим идентификатором не существует!']);
            }
            $response->setView('users.view');
        }
        $response->setView('users.view_change_password');

        return $this->render($response, ['request' => $request]);
    }
}