<?php

namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\MainController;
use Services\AuthService;
use Services\CollectionService;
use Helpers\Message;
use Exception;

class RouteRemoveCollection extends Route
{
    private MainController $controller;
    private AuthService $auth;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
        $this->auth       = new AuthService();
    }

    /**
     * Retire un personnage de la collection de l'utilisateur via GET.
     *
     * @param array $params Paramètres GET, dont 'id' est obligatoire
     */
    public function get(array $params = []): void
    {
        try {
            // Vérification de connexion
            if (!$this->auth->isLogged()) {
                $msg = new Message(
                    "Veuillez vous connecter pour retirer de votre collection.",
                    Message::COLOR_ERROR
                );
                $this->controller->login($msg);
                return;
            }

            // Récupération de l'ID du personnage
            $persoId = $this->getParam($params, 'id', false);

            // Suppression dans la collection
            $cs = new CollectionService();
            $cs->removeFromCollection($_SESSION['user_id'], $persoId);

            $msg = new Message(
                "Personnage retiré de votre collection.",
                Message::COLOR_INFO
            );

            $this->controller->index($msg);

        } catch (Exception $e) {
            // Gestion d'erreur générique
            $this->controller->index(
                new Message("Erreur : " . $e->getMessage(), Message::COLOR_ERROR)
            );
        }
    }

    /**
     * Redirige simplement le POST vers GET.
     *
     * @param array $params Paramètres POST
     */
    public function post(array $params = []): void
    {
        $this->get($params);
    }
}
