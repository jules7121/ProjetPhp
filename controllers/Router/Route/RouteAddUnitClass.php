<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;
use Models\UnitClass;
use Models\UnitClassDAO;
use Helpers\Message;
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
        $this->controller->displayAddUnitClass();
    }

    public function post(array $params = []): void
    {
        try {
            $name   = $this->getParam($params, 'unitclass-name', false);
            $imgUrl = $this->getParam($params, 'unitclass-img', true);

            $uc = new UnitClass();
            $uc->setName($name);
            $uc->setUrlImg($imgUrl ?: null);

            $dao = new UnitClassDAO();
            $ok = $dao->createUnitClass($uc);

            $message = $ok
                ? new Message("Classe ajoutée avec succès.", Message::COLOR_SUCCESS, "Succès")
                : new Message("Erreur lors de l’ajout de la classe.", Message::COLOR_ERROR, "Erreur");

            $this->controller->displayAddUnitClass($message);

        } catch (Exception $e) {
            $this->controller->displayAddUnitClass(
                new Message("Erreur : " . $e->getMessage(), Message::COLOR_ERROR, "Erreur")
            );
        }
    }
}
