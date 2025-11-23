<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;

class RouteAddPersoElement extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        $this->controller->displayAddPersoElement();
    }

    public function post(array $params = []): void
    {
        $this->controller->displayAddPersoElement();
    }
}
