<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\MainController;
use Controllers\Router\Route;
use Models\UnitClass;
use Models\UnitClassDAO;
use Helpers\Message;
use Services\AuthService;
use Exception;

class RouteAddUnitClass extends Route
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

        $this->controller->displayAddUnitClass();
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
            $name   = $this->getParam($params, 'unitclass-name', false);
            $imgUrl = $this->getParam($params, 'unitclass-img', true);

            $uc = new UnitClass();
            $uc->setName($name);
            $uc->setUrlImg($imgUrl ?: null);

            $dao = new UnitClassDAO();
            $ok = $dao->createUnitClass($uc);

            $message = $ok
                ? new Message("Classe ajoutée avec succès.", Message::COLOR_SUCCESS)
                : new Message("Erreur lors de l’ajout.", Message::COLOR_ERROR);

            $this->controller->displayAddUnitClass($message);

        } catch (Exception $e) {
            $this->controller->displayAddUnitClass(
                new Message("Erreur : " . $e->getMessage(), Message::COLOR_ERROR)
            );
        }
    }
}
