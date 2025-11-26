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

    /**
     * Affiche la liste de tous les personnages.
     *
     * @param array $params Paramètres GET (non utilisés ici)
     */
    public function get(array $params = []): void
    {
        $this->controller->allPerso();
    }

    /**
     * Pour un POST, on réutilise simplement le même comportement que GET.
     *
     * @param array $params Paramètres POST
     */
    public function post(array $params = []): void
    {
        $this->get($params);
    }
}
