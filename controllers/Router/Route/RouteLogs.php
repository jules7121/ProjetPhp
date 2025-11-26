<?php

namespace Controllers\Router\Route;

use Controllers\MainController;
use Controllers\Router\Route;
use Services\AuthService;

class RouteLogs extends Route
{
    private MainController $controller;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Affiche la page contenant l'historique des logs.
     *
     * @param array $params Paramètres GET (non utilisés)
     */
    public function get(array $params = []): void
    {
        $auth = new AuthService();
        $msg  = $auth->requireLogin();

        if ($msg !== null) {
            $this->controller->login($msg);
            return;
        }

        $this->controller->logs();
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
