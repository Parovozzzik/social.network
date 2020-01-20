<?php

namespace App\Models\Entities\Responses;

use App\Models\Entities\EUser;

/**
 * Class EUserListResponse
 * @package App\Models\Entities\Responses
 */
class EUserListResponse extends Response
{
    /** @var EUser[]|array */
    protected $users;

    /**
     * @return EUser[]|array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param EUser[]|array $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    /**
     * @param EUser $user
     */
    public function addUser(EUser $user): void
    {
        array_push($this->users, $user);
    }
}