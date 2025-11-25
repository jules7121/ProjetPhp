<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\MainController;
use Controllers\Router\Route;
use Services\AuthService;
use Exception;

class RouteEditPerso extends Route
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
            $this->controller->displayEditPerso($idPerso);
        } catch (Exception $e) {
            $this->controller->displayAddPerso("Aucun identifiant pour la modification.");
        }
    }

    public function post(array $params = []): void
    {
        $auth = new AuthService();
        $msg = $auth->requireLogin();
        if ($msg !== null) {
            (new MainController())->login($msg);
            return;
        }

        try {
            $data = [
                'idPerso'   => $this->getParam($params, 'idPerso', false),
                'name'      => $this->getParam($params, 'perso-nom', false),
                'element'   => $this->getParam($params, 'perso-element', false),
                'unitclass' => $this->getParam($params, 'perso-unitclass', false),
                'rarity'    => $this->getParam($params, 'perso-rarity', false),
                'origin'    => $this->getParam($params, 'perso-origin', true),
                'url_img'   => $this->getParam($params, 'perso-url-img', false),
            ];

            $this->controller->editPerso($data);

        } catch (Exception $e) {
            $idPerso = $params['idPerso'] ?? null;

            if ($idPerso) {
                $this->controller->displayEditPerso($idPerso, "Erreur : " . $e->getMessage());
            } else {
                $this->controller->displayAddPerso("Erreur : " . $e->getMessage());
            }
        }
    }
}
