<?php

namespace App\Auth;

use App\Core\IAuthenticator;
use App\Models\User;

class Authenticator implements IAuthenticator
{
    public function __construct()
    {
        session_start();
    }

    /**
     * @inheritDoc
     */
    public function login($login, $password): bool
    {
        $user = User::getAll("email=?", [$login]);
        if (count($user) > 0) {
            $user = $user[0];
            if (password_verify($password, $user->getPasswordHash())) {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['login'] = $login;
                $_SESSION['role'] = $user->getRole();
                return true;
            }

        }
        return false;

    }

    /**
     * @inheritDoc
     */
    public function logout(): void
    {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            session_destroy();
        }
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserName(): string
    {
        return $_SESSION['login'] ?? throw new \Exception("User not logged in");
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserId(): mixed
    {
        return $_SESSION['user_id'] ?? throw new \Exception("User not logged in");
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function getLoggedUserContext(): mixed
    {
        return $_SESSION['user_id'] ? ["user_id" => $_SESSION["user_id"], "login" => $_SESSION["login"], "role" => $_SESSION["role"]] : throw new \Exception("User not logged in");
    }

    /**
     * @inheritDoc
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['user_id']);
    }
}