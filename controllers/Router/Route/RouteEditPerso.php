<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;

class RouteEditPerso extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        // Pour l’instant, on affiche simplement le formulaire d’ajout.
        // Plus tard, on pré-remplira avec le personnage à modifier.
        $this->controller->displayAddPerso();
    }

    public function post(array $params = []): void
    {
        // Pour la partie 3, on ne gère pas encore la soumission du form d’édition
        $this->controller->displayAddPerso();
    }
}
