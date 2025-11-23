<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;

class RouteIndex extends Route
{
    private MainController $controller;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        // Page d'accueil
        $this->controller->index();
    }

    public function post(array $params = []): void
    {
        // Pour l’instant, même chose
        $this->controller->index();
    }
}
