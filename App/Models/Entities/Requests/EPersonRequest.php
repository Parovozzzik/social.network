<?php

namespace App\Models\Entities\Requests;

/**
 * Class ECreatePerson
 * @package App\Models\Entities\Requests
 */
class EPersonRequest extends Request
{
    /** @var int|null */
    protected $personId;

    /** @var string|null */
    protected $firstName;

    /** @var string|null */
    protected $lastName;

    /** @var \DateTime|null */
    protected $dateBirth;

    /** @var string|null */
    protected $gender;

    /** @var int|null */
    protected $userId;

    /** @var string|null */
    protected $hobbies;

    /**
     * @return int|null
     */
    public function getPersonId(): ?int
    {
        return $this->personId;
    }

    /**
     * @param int|null $personId
     */
    public function setPersonId(?int $personId): void
    {
        $this->personId = $personId;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateBirth(): ?\DateTime
    {
        return $this->dateBirth;
    }

    /**
     * @param \DateTime|null $dateBirth
     */
    public function setDateBirth(?\DateTime $dateBirth): void
    {
        $this->dateBirth = $dateBirth;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string|null
     */
    public function getHobbies(): ?string
    {
        return $this->hobbies;
    }

    /**
     * @param string|null $hobbies
     */
    public function setHobbies(?string $hobbies): void
    {
        $this->hobbies = $hobbies;
    }
}