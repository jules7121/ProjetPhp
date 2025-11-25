<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\MainController;
use Controllers\Router\Route;
use Services\AuthService;
use Exception;

class RouteDelPerso extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        $auth = new AuthService();
        $msg = $auth->requireLogin();
        if ($msg !== null) {
            (new MainController())->login($msg);
            return;
        }

        try {
            $idPerso = $this->getParam($params, 'id', false);
            $this->controller->deletePersoAndIndex($idPerso);

        } catch (Exception $e) {
            $this->controller->deletePersoAndIndex(null);
        }
    }

    public function post(array $params = []): void
    {
        $this->get($params);
    }
}
