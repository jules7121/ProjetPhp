<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;
use Services\AuthService;
use Helpers\Message;

class RouteLogout extends Route
{
    private MainController $controller;
    private AuthService $auth;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
        $this->auth       = new AuthService();
    }

    /**
     * Déconnecte l'utilisateur et renvoie sur la page de login
     * avec un message d'information.
     *
     * @param array $params Paramètres GET (non utilisés)
     */
    public function get(array $params = []): void
    {
        $this->auth->logout();

        $this->controller->login(
            new Message("Déconnecté.", Message::COLOR_INFO)
        );
    }

    /**
     * Redirige simplement le POST vers GET.
     *
     * @param array $params Paramètres POST
     */
    public function post(array $params = []): void
    {
        $this->get($params);
    }
}
