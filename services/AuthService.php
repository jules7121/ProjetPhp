<?php

namespace Services;

use Models\User;
use Models\UserDAO;
use Helpers\Message;

/**
 * Service responsable de la gestion de l'authentification :
 *  - Connexion / déconnexion
 *  - Vérification d'une session active
 *  - Récupération de l'utilisateur connecté
 *  - Protection d'accès aux pages sensibles
 */
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

    /**
     * Tente une connexion utilisateur.
     *
     * @param string $username Identifiant de connexion
     * @param string $password Mot de passe en clair
     * @return bool Succès ou échec de la connexion
     */
    public function login(string $username, string $password): bool
    {
        $user = $this->dao->findByUsername($username);
        if (!$user) return false;

        if (!password_verify($password, $user->getHashPwd())) {
            return false;
        }

        $_SESSION['user_id']  = $user->getId();
        $_SESSION['username'] = $user->getUsername();

        return true;
    }

    /**
     * Déconnecte l'utilisateur courant
     * (supprime les données de session).
     */
    public function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['username']);
    }

    /**
     * Indique si un utilisateur est connecté.
     *
     * @return bool
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Retourne l'utilisateur actuellement connecté.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (!$this->isLogged()) return null;

        return $this->dao->findByUsername($_SESSION['username']);
    }

    /**
     * Vérifie si l'accès est protégé et retourne un Message
     * d'erreur si l'utilisateur n'est pas connecté.
     *
     * @return Message|null Message d'erreur ou null si accès autorisé
     */
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
