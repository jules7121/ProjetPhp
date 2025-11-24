<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;
use Models\Origin;
use Models\OriginDAO;
use Helpers\Message;
use Exception;

class RouteAddOrigin extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        $this->controller->displayAddOrigin();
    }

    public function post(array $params = []): void
    {
        try {
            $name   = $this->getParam($params, 'origin-name', false);
            $imgUrl = $this->getParam($params, 'origin-img', true);

            $origin = new Origin();
            $origin->setName($name);
            $origin->setUrlImg($imgUrl ?: null);

            $dao = new OriginDAO();
            $ok = $dao->createOrigin($origin);

            $message = $ok
                ? new Message("Origine ajoutée avec succès.", Message::COLOR_SUCCESS, "Succès")
                : new Message("Erreur lors de l’ajout de l’origine.", Message::COLOR_ERROR, "Erreur");

            $this->controller->displayAddOrigin($message);

        } catch (Exception $e) {
            $this->controller->displayAddOrigin(
                new Message("Erreur : " . $e->getMessage(), Message::COLOR_ERROR, "Erreur")
            );
        }
    }
}
