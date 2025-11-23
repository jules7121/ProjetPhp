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
use Controllers\Router\Route\RouteEditPerso;
use Controllers\Router\Route\RouteDelPerso;




class Router
{
    /** @var array<string, Route> */
    private array $routeList = [];

    /** @var array<string, object> */
    private array $ctrlList  = [];

    private string $actionKey;

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
    $this->routeList['add-perso']         = new RouteAddPerso($this->ctrlList['perso']);
    $this->routeList['add-perso-element'] = new RouteAddPersoElement($this->ctrlList['perso']);
    $this->routeList['logs']              = new RouteLogs($this->ctrlList['main']);
    $this->routeList['login']             = new RouteLogin($this->ctrlList['main']);

    
    $this->routeList['edit-perso']        = new RouteEditPerso($this->ctrlList['perso']);
    $this->routeList['del-perso']         = new RouteDelPerso($this->ctrlList['perso']);
}



public function routing(array $get, array $post): void
{
    $action = $get[$this->actionKey] ?? 'index';
    
    $route = $this->routeList[$action] ?? $this->routeList['index'];
    
    $method = !empty($post) ? 'POST' : 'GET';

    if ($method === 'POST') {
        $route->action($post, 'POST');
    } else {
        $route->action($get, 'GET');
    }
}
}