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

    /**
     * Affiche le formulaire d’ajout d’une classe/unité.
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

        $this->controller->displayAddUnitClass();
    }

    /**
     * Traite l’ajout d’une nouvelle classe/unité (POST).
     *
     * @param array $params Données POST
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
            // Récupération des valeurs du formulaire
            $name   = $this->getParam($params, 'unitclass-name', false);
            $imgUrl = $this->getParam($params, 'unitclass-img', true);

            // Création de l'objet
            $uc = new UnitClass();
            $uc->setName($name);
            $uc->setUrlImg($imgUrl ?: null);

            // DAO
            $dao = new UnitClassDAO();
            $ok  = $dao->createUnitClass($uc);

            // Message retour
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
