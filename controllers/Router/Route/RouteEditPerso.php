<?php

namespace Controllers\Router\Route;

use Controllers\PersonnageController;
use Controllers\MainController;
use Controllers\Router\Route;
use Services\AuthService;
use Exception;

class RouteEditPerso extends Route
{
    private PersonnageController $controller;

    public function __construct(PersonnageController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Affiche le formulaire de modification d’un personnage.
     *
     * @param array $params Paramètres GET (doit contenir 'id')
     */
    public function get(array $params = []): void
    {
        $auth = new AuthService();
        $msg  = $auth->requireLogin();

        if ($msg !== null) {
            (new MainController())->login($msg);
            return;
        }

        try {
            // Récupère l’ID du personnage
            $idPerso = $this->getParam($params, 'id', false);

            // Affiche le formulaire d’édition
            $this->controller->displayEditPerso($idPerso);

        } catch (Exception $e) {
            // En cas d'ID manquant
            $this->controller->displayAddPerso(
                "Aucun identifiant pour la modification."
            );
        }
    }

    /**
     * Traite la modification d’un personnage via POST.
     *
     * @param array $params Données du formulaire POST
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
            // Récupération des valeurs envoyées par le formulaire
            $data = [
                'idPerso'   => $this->getParam($params, 'idPerso', false),
                'name'      => $this->getParam($params, 'perso-nom', false),
                'element'   => $this->getParam($params, 'perso-element', false),
                'unitclass' => $this->getParam($params, 'perso-unitclass', false),
                'rarity'    => $this->getParam($params, 'perso-rarity', false),
                'origin'    => $this->getParam($params, 'perso-origin', true),
                'url_img'   => $this->getParam($params, 'perso-url-img', false),
            ];

            // Applique la modification via le contrôleur
            $this->controller->editPerso($data);

        } catch (Exception $e) {
            // Cas d'erreur : on tente d'afficher la bonne vue
            $idPerso = $params['idPerso'] ?? null;

            if ($idPerso) {
                $this->controller->displayEditPerso(
                    $idPerso,
                    "Erreur : " . $e->getMessage()
                );
            } else {
                $this->controller->displayAddPerso(
                    "Erreur : " . $e->getMessage()
                );
            }
        }
    }
}
