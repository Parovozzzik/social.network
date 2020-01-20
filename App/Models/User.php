<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Entities\EUser;
use App\Models\Entities\Requests\EChangePasswordUser;
use App\Models\Entities\Requests\ELoginUser;
use App\Models\Entities\Requests\ERegistrationUser;
use App\Models\Entities\Responses\EUserResponse;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    /** @var int */
    const USER_DELETED = 1;
    /** @var int */
    const USER_NOT_DELETED = 0;

    /** @var string */
    public $entityName = EUser::class;

    /**
     * @param ERegistrationUser $registrationUser
     * @return EUserResponse
     */
    public function registration(ERegistrationUser $registrationUser): EUserResponse
    {
        $response = new EUserResponse();
        if (trim($registrationUser->getEmail()) === '' || trim($registrationUser->getNewPassword()) === '') {
            if (trim($registrationUser->getEmail()) === '') {
                $response->addError('email', 'Поле Email обязательно для заполнения!');
            }
            if (trim($registrationUser->getNewPassword()) === '') {
                $response->addError('password', 'Поле Password обязательно для заполнения!');
            } elseif (trim($registrationUser->getNewPassword()) !== trim($registrationUser->getRepeatPassword())) {
                $message = 'Введенные пароли должны совпадать!';
                $response->addError('repeatPassword', $message);
                $response->addError('password', $message);
            }

            return $response;
        }

        if ($this->existsByEmail($registrationUser->getEmail()) === false) {
            $query = $this->connection->prepare("INSERT INTO {$this->entity::$table} (email, password) VALUES (?, ?);");
            $query->bindParam(1, $registrationUser->getEmail());
            $query->bindParam(2, Helper::passwordHash($registrationUser->getNewPassword()));
            $query->execute();
            $response->setMessage('Учетная запись успешко зарегистрирована!');
        } else {
            $response->addError('email', 'Данный пользователь уже зарегистрирован!');
        }
        $user = $this->getByEmail($registrationUser->getEmail());
        $response->setUserId($user->userId);
        $response->setEmail($user->email);

        return $response;
    }

    /**
     * @param EChangePasswordUser $changePasswordUser
     * @return EUserResponse
     */
    public function changePassword(EChangePasswordUser $changePasswordUser): EUserResponse
    {
        $response = new EUserResponse();
        $currentPassword = trim($changePasswordUser->getCurrentPassword());

        $newPassword = trim($changePasswordUser->getNewPassword());
        $repeatPassword = trim($changePasswordUser->getRepeatPassword());

        if ($currentPassword === '') {
            $response->addError('currentPassword', 'Поле Current Password обязательно для заполнения!');
        } else {
            $user = (new User())->get($_SESSION['id']);
            if (Helper::passwordVerify($currentPassword, $user['password']) === false) {
                $response->addError('currentPassword', 'Введен неверный текущий пароль.');
            }

        }

        if ($newPassword === '') {
            $response->addError('newPassword', 'Поле New Password обязательно для заполнения!');
        }
        if ($repeatPassword === '') {
            $response->addError('repeatPassword', 'Поле Repeat Password обязательно для заполнения!');
        }
        if ($newPassword !== $repeatPassword) {
            $message = 'Введенные новые пароли должны совпадать!';
            $response->addError('repeatPassword', $message);
            $response->addError('password', $message);
        }

        if ($response->getErrors() === null || count($response->getErrors()) === 0) {
            $query = $this->connection->prepare("UPDATE {$this->entity::$table} SET password = ? WHERE user_id = ?;");
            $query->bindParam(1, Helper::passwordHash($newPassword));
            $query->bindParam(2, $user['user_id']);
            $query->execute();
            $response->setMessage('Пароль успешно изменен!');
        }

        return $response;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool
    {
        $query = $this->connection->prepare("SELECT COUNT(*) FROM {$this->entity::$table} WHERE email = ?;");
        $query->bindParam(1, $email);
        $query->execute();
        $count = $query->fetchColumn();

        return $count > 0;
    }

    /**
     * @param string $email
     * @return EUser
     */
    public function getByEmail(string $email): EUser
    {
        $query = $this->connection->prepare("SELECT * FROM {$this->entity::$table} WHERE email = ?;");
        $query->bindParam(1, $email);
        $query->execute();

        return new EUser($query->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @return EUser[]|array
     */
    public function getList(): array
    {
        $query = $this->connection->prepare("SELECT * FROM {$this->entity::$table} WHERE deleted = 0;");
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $users = [];
        foreach ($result as $item) {
            $users[] = new EUser($item);
        }

        return $users;
    }

    /**
     * @param ELoginUser $loginUser
     * @return EUserResponse
     */
    public function login(ELoginUser $loginUser): EUserResponse
    {
        $response = new EUserResponse();

        if (trim($loginUser->getEmail()) === '' || trim($loginUser->getPassword()) === '') {
            if (trim($loginUser->getEmail()) === '') {
                $response->addError('email', 'Поле Email обязательно для заполнения!');
            }
            if (trim($loginUser->getPassword()) === '') {
                $response->addError('password', 'Поле Password обязательно для заполнения!');
            }

            return $response;
        }

        if ($this->existsByEmail($loginUser->getEmail())) {
            $user = $this->getByEmail($loginUser->getEmail());

            if (Helper::passwordVerify($loginUser->getPassword(), $user->password)) {
                $response->setUserId($user->userId);
                $response->setEmail($user->email);

                $_SESSION['id'] = $user->userId;
                setcookie('email', $user->email, time() + 50000, '/');
                setcookie('password', $user->password, time() + 50000, '/');

                $response->setMessage('Авторизация прошла успешно!');
            } else {
                $response->setErrors(['password' => 'Ошибка ввода логина или пароля!']);
            }
        } else {
            $response->setErrors(['email' => 'Данный пользователь не зарегистрирован!']);
        }

        return $response;
    }

    /**
     * @return bool
     */
    public function isLogin(): bool
    {
        session_start();

        if (isset($_SESSION['id'])) {
            if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
                setcookie('email', "", time() - 1, '/');
                setcookie('password', "", time() - 1, '/');
                setcookie('email', $_COOKIE['login'], time() + 50000, '/');
                setcookie('password', $_COOKIE['password'], time() + 50000, '/');

                return true;
            } else {
                $user = $this->get($_SESSION['id']);
                if ($user['user_id'] === $_SESSION['id']) {
                    setcookie('email', $user['email'], time() + 50000, '/');
                    setcookie('password', $user['password'], time() + 50000, '/');

                    return true;
                }
            }
        } else {
            if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
                if ($this->existsByEmail($_COOKIE['email'])) {
                    $user = $this->getByEmail($_COOKIE['email']);
                    if (Helper::passwordVerify($_COOKIE['password'], $user->password)) {
                        $_SESSION['id'] = $user->userId;

                        return true;
                    }
                }

                setcookie('email', '', time() - 360000, '/');
                setcookie('password', '', time() - 360000, '/');
            }
        }

        return false;
    }
}