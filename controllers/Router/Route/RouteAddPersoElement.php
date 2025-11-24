<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;
use Exception;
use Models\Element;
use Models\ElementDAO;
use Helpers\Message;

class RouteAddPersoElement extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        $this->controller->displayAddPersoElement();
    }

    public function post(array $params = []): void
    {
        try {
            $name   = $this->getParam($params, 'element-name', false);
            $imgUrl = $this->getParam($params, 'element-img', false);

            $element = new Element();
            $element->setName($name);
            $element->setUrlImg($imgUrl);

            $dao = new ElementDAO();
            $ok = $dao->createElement($element);

            $message = $ok
                ? new Message("Élément ajouté avec succès.", Message::COLOR_SUCCESS, "Succès")
                : new Message("Erreur lors de l’ajout de l’élément.", Message::COLOR_ERROR, "Erreur");

            // On retourne au formulaire
            $this->controller->displayAddPersoElement($message);

        } catch (Exception $e) {
            $this->controller->displayAddPersoElement(
                new Message("Erreur dans le formulaire : " . $e->getMessage(), Message::COLOR_ERROR, "Erreur")
            );
        }
    }
}
