<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;
use Helpers\Message;
use Services\AuthService;
use Exception;

class RouteLogin extends Route
{
    private MainController $controller;
    private AuthService $auth;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
        $this->auth       = new AuthService();
    }

    /**
     * Affiche la page de connexion.
     *
     * @param array $params Paramètres GET
     */
    public function get(array $params = []): void
    {
        $this->controller->login();
    }

    /**
     * Tente une connexion utilisateur via POST.
     *
     * @param array $params Données envoyées par le formulaire
     */
    public function post(array $params = []): void
    {
        try {
            $username = $this->getParam($params, 'username', false);
            $password = $this->getParam($params, 'password', false);

            // Tentative de login
            if ($this->auth->login($username, $password)) {
                $msg = new Message("Connexion réussie !", Message::COLOR_SUCCESS);
                $this->controller->index($msg);
            } else {
                $msg = new Message("Identifiants incorrects.", Message::COLOR_ERROR);
                $this->controller->login($msg);
            }

        } catch (Exception $e) {
            $this->controller->login(
                new Message(
                    "Erreur : " . $e->getMessage(),
                    Message::COLOR_ERROR
                )
            );
        }
    }
}
