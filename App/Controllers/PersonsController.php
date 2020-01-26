<?php

namespace App\Controllers;

use App\Models\Entities\EPerson;
use App\Models\Entities\Responses\EPersonListResponse;
use App\Models\Entities\Responses\Response;
use App\Models\Person;

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

    public function create()
    {
        $response = new Response();
        $response->setView('persons.create');

        return $this->render($response);
    }
}