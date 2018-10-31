<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class User
{
    /**
     * Получаем пользователя по идентификатору
     *
     * @param int $id
     * @return Entity\User|null
     */
    public function getById(int $id): ?Entity\User
    {
        return $this->fetchAll()[$id] ?? null;
    }

    /**
     * Получаем пользователя по логину
     *
     * @param string $login
     * @return Entity\User
     */
    public function getByLogin(string $login): ?Entity\User
    {
        foreach ($this->fetchAll() as $user) {
            if ($user->getLogin() === $login) {
                return $user;
            }
        }

        return null;
    }

    /**
     * Получаем всех пользователей
     *
     * @return Entity\User[]
     */
    private function fetchAll(): array
    {
        $admin = new Entity\Role(1, 'Super Admin', 'admin');
        $user = new Entity\Role(1, 'Main user', 'user');
        $test = new Entity\Role(1, 'For test needed', 'test');

        return [
            1 => new Entity\User(
                1,
                'Super Admin',
                'root',
                '$2y$10$GnZbayyccTIDIT5nceez7u7z1u6K.znlEf9Jb19CLGK0NGbaorw8W', // 1234
                $admin
            ),
            2 => new Entity\User(
                2,
                'Doe John',
                'doejohn',
                '$2y$10$j4DX.lEvkVLVt6PoAXr6VuomG3YfnssrW0GA8808Dy5ydwND/n8DW', // qwerty
                $user
            ),
            3 => new Entity\User(
                3,
                'Ivanov Ivan Ivanovich',
                'i**3',
                '$2y$10$TcQdU.qWG0s7XGeIqnhquOH/v3r2KKbes8bLIL6NFWpqfFn.cwWha', // PaSsWoRd
                $user
            ),
            4 => new Entity\User(
                4,
                'Test Testov Testovich',
                'testok',
                '$2y$10$vQvuFc6vQQyon0IawbmUN.3cPBXmuaZYsVww5csFRLvLCLPTiYwMa', // testss
                $test
            ),
        ];
    }
}
