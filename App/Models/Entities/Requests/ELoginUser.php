<?php


namespace App\Models\Entities\Requests;


class ELoginUser extends Request
{
    /** @var string */
    protected $email;

    /** @var string */
    protected $password;

    /** @var bool */
    protected $remember;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function getRemember(): bool
    {
        return $this->remember;
    }

    /**
     * @param bool $remember
     */
    public function setRemember(bool $remember): void
    {
        $this->remember = $remember;
    }
}