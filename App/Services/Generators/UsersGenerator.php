<?php

namespace App\Services\Generators;

use App\Helpers\Helper;

/**
 * Class UsersGenerator
 * @package App\Services\Generators
 */
class UsersGenerator extends AbstractGenerator
{
    /**
     * @return bool
     */
    public function run()
    {
        $password = '1234567';
        $passwordHash = Helper::passwordHash($password);

        $total = 1000000;
        $limit = 1000;
        for ($page = 1; $page <= (int)$total/$limit + 1; $page++) {

            $emailLogins = $this->generateEmailLogins();
            $valiesString = '';
            $queryString = "INSERT INTO users (email, password) VALUES ";
            foreach ($emailLogins as $emailLogin) {
                $email = $emailLogin . '@parovozzzik.ru';
                $valiesString .= "('$email', '$passwordHash'),";
            }
            $valiesString = trim($valiesString, ',') . ';';

            $this->db->query($queryString . $valiesString);
        }

        return true;
    }

    /**
     * @return array
     */
    protected function generateEmailLogins(): array
    {
        $emailLogins = [];
        for ($i = 0; $i < 1000; $i++) {
            $emailLogins[] = Helper::generateConfirmCode(7);
        }

        return $emailLogins;
    }
}