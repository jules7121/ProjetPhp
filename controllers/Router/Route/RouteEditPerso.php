<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\Router\Route;
use Exception;

class RouteEditPerso extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Affiche le formulaire d’édition pré-rempli
     */
    public function get(array $params = []): void
    {
        try {
            // On récupère l’id du personnage dans l’URL
            $idPerso = $this->getParam($params, 'id', false);
            $this->controller->displayEditPerso($idPerso);
        } catch (Exception $e) {
            // Pas d’id → on renvoie simplement sur le formulaire d’ajout
            $this->controller->displayAddPerso("Aucun identifiant de personnage pour la modification.");
        }
    }

    /**
     * Traite la soumission du formulaire d’édition
     */
    public function post(array $params = []): void
    {
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
            // Si erreur dans les champs, on essaie de réafficher le form d’édition
            $idPerso = $params['idPerso'] ?? null;

            $message = "Erreur dans le formulaire : " . $e->getMessage();

            if ($idPerso !== null) {
                $this->controller->displayEditPerso($idPerso, $message);
            } else {
                $this->controller->displayAddPerso($message);
            }
        }
    }
}
