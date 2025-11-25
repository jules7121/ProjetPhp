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
        $this->auth = new AuthService();
    }

    public function get(array $params = []): void
    {
        $this->auth->logout();
        $this->controller->login(
            new Message("Déconnecté.", Message::COLOR_INFO)
        );
    }

    public function post(array $params = []): void
    {
        $this->get($params);
    }
}
