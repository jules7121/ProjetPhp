<?php

namespace Controllers\Router;

use Controllers\MainController;
use Controllers\PersonnageController;
use Controllers\Router\Route\Route;
use Controllers\Router\Route\RouteIndex;
use Controllers\Router\Route\RouteAddPerso;
use Controllers\Router\Route\RouteAddPersoElement;
use Controllers\Router\Route\RouteLogs;
use Controllers\Router\Route\RouteLogin;
use Controllers\Router\Route\RouteLogout;
use Controllers\Router\Route\RouteEditPerso;
use Controllers\Router\Route\RouteDelPerso;
use Controllers\Router\Route\RouteAddUnitClass;
use Controllers\Router\Route\RouteAddOrigin;
use Controllers\Router\Route\RouteAddCollection;
use Controllers\Router\Route\RouteRemoveCollection;
use Controllers\Router\Route\RouteAllPerso;

use Services\AuthService;
use Helpers\Message;


class Router
{
    
    private array $routeList = [];

    private array $ctrlList  = [];

    private string $actionKey;

    /**
     * Initialise le router.
     *
     * @param string $name_of_action_key Nom de la variable GET indiquant l'action
     */
    public function __construct(string $name_of_action_key = 'action')
    {
        $this->actionKey = $name_of_action_key;

        $this->createControllerList();
        $this->createRouteList();
    }

    private function createControllerList(): void
    {
        $this->ctrlList['main']  = new MainController();
        $this->ctrlList['perso'] = new PersonnageController();
    }

    
    private function createRouteList(): void
    {
        $this->routeList['index']             = new RouteIndex($this->ctrlList['main']);
        $this->routeList['all-perso']         = new RouteAllPerso($this->ctrlList['main']);
        $this->routeList['add-perso']         = new RouteAddPerso($this->ctrlList['perso']);
        $this->routeList['add-perso-element'] = new RouteAddPersoElement($this->ctrlList['perso']);
        $this->routeList['logs']              = new RouteLogs($this->ctrlList['main']);
        $this->routeList['login']             = new RouteLogin($this->ctrlList['main']);
        $this->routeList['logout']            = new RouteLogout($this->ctrlList['main']);
        $this->routeList['edit-perso']        = new RouteEditPerso($this->ctrlList['perso']);
        $this->routeList['del-perso']         = new RouteDelPerso($this->ctrlList['perso']);
        $this->routeList['add-unitclass']     = new RouteAddUnitClass($this->ctrlList['perso']);
        $this->routeList['add-origin']        = new RouteAddOrigin($this->ctrlList['perso']);
        $this->routeList['add-collection']    = new RouteAddCollection($this->ctrlList['main']);
        $this->routeList['remove-collection'] = new RouteRemoveCollection($this->ctrlList['main']);
    }

    /**
     * Détermine la route à appeler, gère la sécurité,
     * puis exécute get() ou post() selon la méthode HTTP.
     *
     * @param array $get  Tableau $_GET
     * @param array $post Tableau $_POST
     */
    public function routing(array $get, array $post): void
    {
        
        $action = $get[$this->actionKey] ?? 'index';

        $route  = $this->routeList[$action] ?? $this->routeList['index'];
        $method = !empty($post) ? 'POST' : 'GET';

        $protected = [
            'add-collection',
            'remove-collection',
            'add-perso',
            'edit-perso',
            'del-perso',
            'add-origin',
            'add-unitclass',
            'add-perso-element',
            'logs',
        ];

        
        if (in_array($action, $protected, true)) {
            $auth = new AuthService();
            if (!$auth->isLogged()) {
                $msg = new Message(
                    "Vous devez être connecté pour accéder à cette page.",
                    Message::COLOR_ERROR,
                    "Accès refusé"
                );

                $this->ctrlList['main']->login($msg);
                return;
            }
        }
        
        if ($method === 'POST') {
            $route->action($post, 'POST');
        } else {
            $route->action($get, 'GET');
        }
    }
}
