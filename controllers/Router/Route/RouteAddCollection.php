<?php

namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\MainController;
use Services\AuthService;
use Services\CollectionService;
use Helpers\Message;
use Exception;

class RouteAddCollection extends Route
{
    private MainController $controller;
    private AuthService $auth;

    public function __construct(MainController $controller)
    {
        $this->controller = $controller;
        $this->auth       = new AuthService();
    }

    /**
     * Ajoute un personnage à la collection de l'utilisateur via GET.
     *
     * @param array $params Paramètres GET contenant au minimum 'id'
     */
    public function get(array $params = []): void
    {
        try {
            if (!$this->auth->isLogged()) {
                $msg = new Message(
                    "Veuillez vous connecter pour ajouter à votre collection.",
                    Message::COLOR_ERROR
                );
                $this->controller->login($msg);
                return;
            }

            // ID du personnage requis
            $persoId = $this->getParam($params, 'id', false);

            $cs = new CollectionService();
            $cs->addToCollection($_SESSION['user_id'], $persoId);

            $msg = new Message(
                "Personnage ajouté à votre collection !",
                Message::COLOR_SUCCESS
            );

            $this->controller->index($msg);

        } catch (Exception $e) {
            $this->controller->index(
                new Message("Erreur : " . $e->getMessage(), Message::COLOR_ERROR)
            );
        }
    }

    /**
     * Redirige simplement le POST vers GET.
     */
    public function post(array $params = []): void
    {
        $this->get($params);
    }
}
