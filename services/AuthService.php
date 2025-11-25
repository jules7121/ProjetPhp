<?php

namespace Services;

use Models\User;
use Models\UserDAO;
use Helpers\Message;

class AuthService
{
    private UserDAO $dao;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->dao = new UserDAO();
    }

    public function login(string $username, string $password): bool
    {
        $user = $this->dao->findByUsername($username);

        if (!$user) return false;

        if (!password_verify($password, $user->getHashPwd())) {
            return false;
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();

        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['username']);
    }

    public function isLogged(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function getUser(): ?User
    {
        if (!$this->isLogged()) return null;

        return $this->dao->findByUsername($_SESSION['username']);
    }

    /** 🔒 Fonction de protection */
    public function requireLogin(): ?Message
    {
        if (!$this->isLogged()) {
            return new Message(
                "Vous devez être connecté.",
                Message::COLOR_ERROR
            );
        }
        return null;
    }
}
