<?php

namespace App\Controllers;

use App\Models\Entities\EPerson;
use App\Models\Entities\Requests\ECreatePerson;
use App\Models\Entities\Requests\ELoginUser;
use App\Models\Entities\Responses\EPersonListResponse;
use App\Models\Entities\Responses\Response;
use App\Models\Person;
use App\Models\User;

/**
 * Class PersonsController
 * @package App\Controllers
 */
class PersonsController extends Controller
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'index' => !$this->isGuest,
            'view' => !$this->isGuest,
            'my' => !$this->isGuest,
            'create' => !$this->isGuest,
        ];
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $persons = (new Person())->getList();

        $response = new EPersonListResponse();
        $response->setPersons($persons);
        $response->setView('persons.index');

        return $this->render($response);
    }

    /**
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function view()
    {
        $id = $this->request['id'];

        $data = (new Person())->get($id);
        $response = new Response();

        if (count($data) > 0) {
            $person = new EPerson($data);
            $response->setModel($person);
        } else {
            $response->setErrors(['Персоны с текущим идентификатором не существует!']);
        }
        $response->setView('persons.view');

        return $this->render($response);
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function my()
    {
        $person = (new Person())->getByUserId($this->user->userId);

        if ($person instanceof EPerson) {
            $response = new Response();
            $response->setModel($person);
            $response->setView('persons.view');

            return $this->render($response);
        } else {
            $this->redirect('/persons/create');
        }
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create()
    {
        $person = (new Person())->getByUserId($this->user->userId);

        if ($person instanceof EPerson) {
            $this->redirect('/persons/my');
        }

        $request = $_POST['person'];
        $response = new Response();

        if (isset($request)) {
            $createPerson = new ECreatePerson($request);
            $createPerson->setFirstName($request['firstName']);
            $createPerson->setLastName($request['lastName']);
            $dateBirth = (new \DateTime())::createFromFormat('Y.m.d', $request['dateBirth']);
            $createPerson->setDateBirth($dateBirth === false ? new \DateTime() : $dateBirth);
            $createPerson->setGender($request['gender']);
            $createPerson->setUserId($this->user->userId);

            $personModel = new Person();
            $response = $personModel->create($createPerson);

            if ($response->getErrors() === null) {
                $this->redirect('/persons/my');
            }
        }

        $response->setView('persons.create');

        return $this->render($response, ['request' => $request]);
    }
}