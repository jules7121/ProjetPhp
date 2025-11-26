<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\MainController;
use Controllers\Router\Route;
use Services\AuthService;
use Exception;

class RouteAddPerso extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Affiche le formulaire d’ajout de personnage.
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

        $this->controller->displayAddPerso();
    }

    /**
     * Traite les données POST du formulaire et ajoute un nouveau personnage.
     *
     * @param array $params Données envoyées via le formulaire
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
            // Données du formulaire récupérées et validées
            $data = [
                'name'      => $this->getParam($params, 'perso-nom', false),
                'element'   => $this->getParam($params, 'perso-element', false),
                'unitclass' => $this->getParam($params, 'perso-unitclass', false),
                'rarity'    => $this->getParam($params, 'perso-rarity', false),
                'origin'    => $this->getParam($params, 'perso-origin', true),
                'url_img'   => $this->getParam($params, 'perso-url-img', false),
            ];

            $this->controller->addPerso($data);

        } catch (Exception $e) {
            $this->controller->displayAddPerso(
                "Erreur dans le formulaire : " . $e->getMessage()
            );
        }
    }
}
