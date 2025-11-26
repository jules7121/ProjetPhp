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

    /**
     * Affiche la page d'accueil.
     *
     * @param array $params Paramètres GET (non utilisés ici)
     */
    public function get(array $params = []): void
    {
        $this->controller->index();
    }

    /**
     * Comportement identique à GET :
     * affichage de la page d'accueil.
     *
     * @param array $params Paramètres POST (non utilisés ici)
     */
    public function post(array $params = []): void
    {
        $this->controller->index();
    }
}
