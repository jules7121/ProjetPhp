<?php

namespace Controllers\Router;

use Exception;

abstract class Route
{
    /**
     * Méthode principale appelée par le router
     */
    public function action(array $params = [], string $method = 'GET'): void
    {
        if ($method === 'POST') {
            $this->post($params);
        } else {
            $this->get($params);
        }
    }

    /**
     * Récupère un paramètre dans un tableau (GET ou POST)
     */
    protected function getParam(array $array, string $paramName, bool $canBeEmpty = true): mixed
    {
        if (isset($array[$paramName])) {
            if (!$canBeEmpty && empty($array[$paramName])) {
                throw new Exception("Paramètre '$paramName' vide");
            }
            return $array[$paramName];
        }

        throw new Exception("Paramètre '$paramName' absent");
    }

    abstract public function get(array $params = []): void;

    abstract public function post(array $params = []): void;
}
