<?php

namespace App\Services\Generators;

class ProfileGenerator extends AbstractGenerator
{
    protected $command = 'generate-profiles';

    public function run()
    {
        $total = $this->db->query(
            "SELECT COUNT(u.user_id)
            FROM users u
            JOIN persons p on u.user_id <> p.user_id;"
        )->fetchColumn();

        $limit = 1000;
        for ($page = 1; $page <= (int)$total/$limit + 1; $page++) {
            $offset = $limit * $page - $limit;
            $userIds = $this->db->query(
                "SELECT u.user_id
            FROM users u
            JOIN persons p on u.user_id <> p.user_id
            LIMIT $limit OFFSET $offset;"
            )->fetchAll(\PDO::FETCH_COLUMN);



            $valiesString = '';
            $queryString = "INSERT INTO persons (user_id, first_name, last_name, date_birth, gender) VALUES ";
            $persons = $this->generatePersonInfo();
            $i = 0;
            foreach ($userIds as $userId) {
                $name = $persons[$i]['name'];
                $surname = $persons[$i]['surname'];
                $gender = $persons[$i]['gender'] === 1 ? 'male' : 'female';
                $dateBirth = $persons[$i]['date_birth'];
                $valiesString .= "($userId, '$name', '$surname', '$dateBirth', '$gender'),";
                $i++;
            }
            $valiesString = trim($valiesString, ',') . ';';

            $this->db->query($queryString . $valiesString);
        }

        return true;
    }

    public function generatePersonInfo(): array
    {
        $file = file_get_contents('App/Settings/DB/files/names.json');
        $names = json_decode($file);
        $onlyNames = [];

        foreach ($names as $name) {
            $onlyNames[] = $name;
        }
        shuffle($onlyNames);

        $file = file_get_contents('App/Settings/DB/files/surnames.json');
        $surnames = json_decode($file);
        $onlySurnames = [];

        foreach ($surnames as $surname) {
            $onlySurnames[] = $surname;
        }
        shuffle($onlySurnames);

        $persons = [];
        for ($i = 0; $i < 1000; $i++) {
            $persons[] = [
                'name' => $onlyNames[$i],
                'surname' => $onlySurnames[$i],
                'date_birth' => rand(1920, 2020) . '-' . rand(1, 12) . '-' . rand(1, 28),
                'gender' => rand(0, 1),
            ];
        }

        unset($file);
        unset($names);
        unset($onlyNames);
        unset($onlySurnames);

        return $persons;
    }
}