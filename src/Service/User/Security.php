<?php

declare(strict_types = 1);

namespace Service\User;

use Model;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Security
{
    private const SESSION_USER_IDENTITY = 'userId';

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Получаем сущность пользователя по сессии
     *
     * @return Model\Entity\User|null
     */
    public function getUser(): ?Model\Entity\User
    {
        $userId = $this->session->get(self::SESSION_USER_IDENTITY);

        return $userId ? (new Model\Repository\User())->getById($userId) : null;
    }

    /**
     * Проверяет, является ли пользователь авторизованным
     *
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->getUser() instanceof Model\Entity\User;
    }

    /**
     * Производим операцию аутентификации
     *
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function authentication(string $login, string $password): bool
    {
        $user = $this->getUserRepository()->getByLogin($login);

        if ($user === null) {
            return false;
        }

        if (!password_verify($password, $user->getPasswordHash())) {
            return false;
        }

        $this->session->set(self::SESSION_USER_IDENTITY, $user->getId());

        return true;
    }

    /**
     * Выход из системы
     *
     * @return void
     */
    public function logout(): void
    {
        $this->session->set(self::SESSION_USER_IDENTITY, null);
    }

    /**
     * Фабричный метод для репозитория User
     *
     * @return Model\Repository\User
     */
    protected function getUserRepository(): Model\Repository\User
    {
        return new Model\Repository\User();
    }
}
