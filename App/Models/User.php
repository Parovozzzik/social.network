<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Entities\EUser;
use App\Models\Entities\Requests\ELoginUser;
use App\Models\Entities\Requests\ERegistrationUser;
use App\Models\Entities\Responses\EUserResponse;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    /** @var string */
    public $entityName = EUser::class;

    /**
     * @param ERegistrationUser $registrationUser
     * @return EUserResponse
     */
    public function registration(ERegistrationUser $registrationUser)
    {
        $response = new EUserResponse();
        if ($this->existsByEmail($registrationUser->getEmail()) === false) {
            $query = $this->connection->prepare("INSERT INTO {$this->entity::$table} (email, password) VALUES (?, ?);");
            $query->bindParam(1, $registrationUser->getEmail());
            $query->bindParam(2, Helper::passwordHash($registrationUser->getPassword()));
            $query->execute();
            $response->setMessage('Учетная запись успешко зарегистрирована!');
        } else {
            $response->setErrors(['Данный пользователь уже зарегистрирован!']);
        }
        $user = $this->getByEmail($registrationUser->getEmail());
        $response->setUserId($user->userId);
        $response->setEmail($user->email);

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
     * @param ELoginUser $loginUser
     * @return EUserResponse
     */
    public function login(ELoginUser $loginUser)
    {
        $response = new EUserResponse();
        if ($this->existsByEmail($loginUser->getEmail()) === true) {
            $user = $this->getByEmail($loginUser->getEmail());

            if (Helper::passwordVerify($loginUser->getPassword(), $user->password)) {
                $response->setUserId($user->userId);
                $response->setEmail($user->email);
                $response->setMessage('Авторизация прошла успешно!');
            } else {
                $response->setErrors(['Ошибка ввода логина или пароля!']);
            }
        } else {
            $response->setErrors(['Данный пользователь не зарегистрирован!']);
        }

        return $response;
    }
}