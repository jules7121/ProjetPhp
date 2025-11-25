<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;

class RouteAllPerso extends Route
{
    private MainController $controller;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        // Appelle la nouvelle méthode du MainController
        $this->controller->allPerso();
    }

    public function post(array $params = []): void
    {
        // Pas de POST spécifique ici, on fait la même chose
        $this->get($params);
    }
}
