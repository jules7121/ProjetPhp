<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Exception;
use Controllers\Router\Route;

class RouteDelPerso extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    { 
        try {
            $idPerso = $this->getParam($params, 'id', false);
            $this->controller->deletePersoAndIndex($idPerso);
        } catch (Exception $e) {
            // Pas d’id dans l’URL → message générique
            $this->controller->deletePersoAndIndex(null);
        }
    }

    public function post(array $params = []): void
    {
        // On ne supprime qu’en GET dans ce TP
        $this->get($params);
    }
}
