<?php

namespace App\Models\Entities\Requests;

class EChangePasswordUser extends Request
{
    /** @var string */
    protected $currentPassword;

    /** @var string */
    protected $newPassword;

    /** @var string */
    protected $repeatPassword;

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     */
    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return string
     */
    public function getRepeatPassword(): string
    {
        return $this->repeatPassword;
    }

    /**
     * @param string $repeatPassword
     */
    public function setRepeatPassword(string $repeatPassword): void
    {
        $this->repeatPassword = $repeatPassword;
    }

    /**
     * @return string
     */
    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    /**
     * @param string $currentPassword
     */
    public function setCurrentPassword(string $currentPassword): void
    {
        $this->currentPassword = $currentPassword;
    }
}