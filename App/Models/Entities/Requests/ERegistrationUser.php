<?php

namespace App\Models\Entities\Requests;

class ERegistrationUser extends EChangePasswordUser
{
    /** @var string */
    protected $email;

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
}