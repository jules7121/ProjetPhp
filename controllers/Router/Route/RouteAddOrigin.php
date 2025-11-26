<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\MainController;
use Controllers\Router\Route;
use Models\Origin;
use Models\OriginDAO;
use Helpers\Message;
use Services\AuthService;
use Exception;

class RouteAddOrigin extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Affiche le formulaire d’ajout d’origine.
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

        $this->controller->displayAddOrigin();
    }

    /**
     * Traite l’ajout d’une nouvelle origine (POST).
     *
     * @param array $params Données envoyées via formulaire
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
            // Récupération des champs (nom obligatoire, image optionnelle)
            $name   = $this->getParam($params, 'origin-name', false);
            $imgUrl = $this->getParam($params, 'origin-img', true);

            $origin = new Origin();
            $origin->setName($name);
            $origin->setUrlImg($imgUrl ?: null);

            $dao = new OriginDAO();
            $ok  = $dao->createOrigin($origin);

            // Génération du message de retour
            $message = $ok
                ? new Message("Origine ajoutée avec succès.", Message::COLOR_SUCCESS)
                : new Message("Erreur lors de l’ajout de l’origine.", Message::COLOR_ERROR);

            $this->controller->displayAddOrigin($message);

        } catch (Exception $e) {
            $this->controller->displayAddOrigin(
                new Message(
                    "Erreur : " . $e->getMessage(),
                    Message::COLOR_ERROR
                )
            );
        }
    }
}
