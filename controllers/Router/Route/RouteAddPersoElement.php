<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\MainController;
use Controllers\Router\Route;
use Models\Element;
use Models\ElementDAO;
use Helpers\Message;
use Services\AuthService;
use Exception;


class RouteAddPersoElement extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Affiche le formulaire d’ajout d’un élément.
     *
     * @param array $params Paramètres GET
     */
    public function get(array $params = []): void
    {
        $auth = new AuthService();
        $msg  = $auth->requireLogin();

        if ($msg !== null) {
            (new MainController())->login($msg);
            return;
        }

        $this->controller->displayAddPersoElement();
    }

    /**
     * Traite l’ajout d’un nouvel élément (POST).
     *
     * @param array $params Données POST du formulaire
     */
    public function post(array $params = []): void
    {
        $auth = new AuthService();
        $msg  = $auth->requireLogin();

        if ($msg !== null) {
            (new MainController())->login($msg);
            return;
        }

        try {
            // Champs du formulaire
            $name   = $this->getParam($params, 'element-name', false);
            $imgUrl = $this->getParam($params, 'element-img', false);

            // Création de l'objet Element
            $element = new Element();
            $element->setName($name);
            $element->setUrlImg($imgUrl);

            // Appel DAO
            $dao = new ElementDAO();
            $ok  = $dao->createElement($element);

            // Message en fonction du résultat
            $message = $ok
                ? new Message("Élément ajouté avec succès.", Message::COLOR_SUCCESS)
                : new Message("Erreur lors de l’ajout.", Message::COLOR_ERROR);

            $this->controller->displayAddPersoElement($message);

        } catch (Exception $e) {
            $this->controller->displayAddPersoElement(
                new Message(
                    "Erreur : " . $e->getMessage(),
                    Message::COLOR_ERROR
                )
            );
        }
    }
}
