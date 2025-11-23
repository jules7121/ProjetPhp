<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Exception;
use Controllers\Router\Route;


class RouteAddPerso extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    public function get(array $params = []): void
    {
        // Affiche simplement le formulaire vide
        $this->controller->displayAddPerso();
    }

    public function post(array $params = []): void
    {
        try {
            // On récupère les champs (obligatoires sauf origin)
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
            // En cas de champ manquant ou vide
            $this->controller->displayAddPerso("Erreur dans le formulaire : " . $e->getMessage());
        }
    }
}
