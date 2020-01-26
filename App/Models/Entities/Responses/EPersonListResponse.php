<?php

namespace App\Models\Entities\Responses;

use App\Models\Entities\EPerson;

/**
 * Class EPersonListResponse
 * @package App\Models\Entities\Responses
 */
class EPersonListResponse extends Response
{
    /** @var EPerson[]|array */
    protected $persons;

    /**
     * @return EPerson[]|array
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * @param EPerson[]|array $persons
     */
    public function setPersons($persons): void
    {
        $this->persons = $persons;
    }

    /**
     * @param EPerson $persons
     */
    public function addPerson(EPerson $persons): void
    {
        array_push($this->persons, $persons);
    }
}