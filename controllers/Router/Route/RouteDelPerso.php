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

    /**
     * Supprimer un personnage via son ID passé en GET.
     *
     * @param array $params Paramètres GET, dont 'id' est obligatoire
     */
    public function get(array $params = []): void
    {
        $auth = new AuthService();
        $msg  = $auth->requireLogin();

        if ($msg !== null) {
            (new MainController())->login($msg);
            return;
        }

        try {
            // Récupération de l'identifiant
            $idPerso = $this->getParam($params, 'id', false);

            // Suppression + redirection avec message
            $this->controller->deletePersoAndIndex($idPerso);

        } catch (Exception $e) {
            // En cas d'erreur ou id manquant
            $this->controller->deletePersoAndIndex(null);
        }
    }

    /**
     * Le POST réutilise le comportement du GET.
     *
     * @param array $params Paramètres POST
     */
    public function post(array $params = []): void
    {
        $this->get($params);
    }
}
