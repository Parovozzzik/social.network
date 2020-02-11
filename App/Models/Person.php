<?php

namespace App\Models;

use App\Models\Entities\EPerson;
use App\Models\Entities\Requests\EPersonRequest;
use App\Models\Entities\Responses\Response;

/**
 * Class Person
 * @package App\Models
 */
class Person extends Model
{
    /** @var array */
    const GENDERS = [
        'male',
        'female',
    ];

    /** @var string */
    public $entityName = EPerson::class;

    /**
     * @param int $userId
     * @return EPerson|null
     */
    public function getByUserId(int $userId): ?EPerson
    {
        $query = $this->connection->prepare("SELECT * FROM {$this->entity::$table} WHERE user_id = ?;");
        $query->bindParam(1, $userId);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result !== false ? new EPerson($result) : null;
    }

    /**
     * @param EPersonRequest $person
     * @return Response
     * @throws \Exception
     */
    public function save(EPersonRequest $person)
    {
        $response = $this->validate($person);

        if ($response->getErrors() === null) {
            if ($person->getPersonId() === null) {
                $personId = $this->insert($person);
                $person->setPersonId($personId);
            } else {
                $this->update($person);
            }
            $response->setModel($person);
            $response->setMessage('Персональные данные успешно сохранены!');
        }

        return $response;
    }

    /**
     * @param EPersonRequest $person
     * @return Response
     * @throws \Exception
     */
    protected function validate(EPersonRequest $person): Response
    {
        $response = new Response();
        if (trim($person->getFirstName()) === '') {
            $response->addError('firstName', 'Поле firstName обязательно для заполнения!');
        }
        if (trim($person->getLastName()) === '') {
            $response->addError('lastName', 'Поле lastName обязательно для заполнения!');
        }
        if (!in_array($person->getGender(), self::GENDERS)) {
            $response->addError('gender', 'Поле Gender обязательно для заполнения!');
        }
        $interval = new \DateInterval('P18Y');
        $interval->invert = 1;
        $date18 = (new \DateTime())->add($interval);
        if ($person->getDateBirth()->diff($date18)->invert === 1) {
            $response->addError('dateBirth', '18+');
        }

        return $response;
    }

    /**
     * @param EPersonRequest $person
     * @return int|null
     */
    protected function insert(EPersonRequest $person): ?int
    {
        $query = $this->connection->prepare(
            "INSERT INTO {$this->entity::$table} 
                (user_id, first_name, last_name, date_birth, gender, hobbies) 
                VALUES (?, ?, ?, ?, ?, ?);"
        );
        $query->bindParam(1, $person->getUserId());
        $query->bindParam(2, $person->getFirstName());
        $query->bindParam(3, $person->getLastName());
        $query->bindParam(4, $person->getDateBirth()->format('Y-m-d'));
        $query->bindParam(5, $person->getGender());
        $query->bindParam(6, $person->getHobbies());


        if ($query->execute() !== false) {
            return $query->insert_id;
        }

        return null;
    }

    /**
     * @param EPersonRequest $person
     * @return int|null
     */
    protected function update(EPersonRequest $person): ?int
    {
        $query = $this->connection->prepare(
            "UPDATE {$this->entity::$table} 
                SET first_name = ?, last_name = ?, date_birth = ?, gender = ?, hobbies = ? 
                WHERE person_id = ?;"
        );

        $query->bindParam(1, $person->getFirstName());
        $query->bindParam(2, $person->getLastName());
        $query->bindParam(3, $person->getDateBirth()->format('Y-m-d'));
        $query->bindParam(4, $person->getGender());
        $query->bindParam(5, $person->getHobbies());
        $query->bindParam(6, $person->getPersonId());

        if ($query->execute() !== false) {
            return $query->id;
        }

        return null;
    }
}