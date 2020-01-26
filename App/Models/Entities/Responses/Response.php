<?php

namespace App\Models\Entities\Responses;

use App\Models\Entities\Entity;

/**
 * Class Response
 * @package App\Models\Entities\Requests
 */
class Response extends Entity
{
    /** @var string|null */
    protected $message;

    /** @var Entity|null */
    protected $model;

    /** @var Entity[]|array|null */
    protected $models;

    /** @var array|null */
    protected $errors;

    /** @var string|null */
    protected $view;

    /** @var int|null */
    protected $userId;

    /** @var string|null */
    protected $email;

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return Entity|null
     */
    public function getModel(): ?Entity
    {
        return $this->model;
    }

    /**
     * @param Entity|null $model
     */
    public function setModel(?Entity $model): void
    {
        $this->model = $model;
    }

    /**
     * @return Entity[]|array|null
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param Entity[]|array|null $models
     */
    public function setModels($models): void
    {
        $this->models = $models;
    }

    /**
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param array|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @param $field
     * @param $message
     */
    public function addError($field, $message): void
    {
        $this->errors = array_merge([$field => $message], $this->errors ?? []);
    }

    /**
     * @return string|null
     */
    public function getView(): ?string
    {
        return $this->view;
    }

    /**
     * @param string|null $view
     */
    public function setView(?string $view): void
    {
        $this->view = $view;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $id
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}