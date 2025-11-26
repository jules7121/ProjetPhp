<?php

namespace Controllers\Router;

use Exception;

abstract class Route
{
    /**
     * Méthode principale appelée par le router.
     * Redirige automatiquement vers get() ou post() selon la méthode HTTP.
     *
     * @param array  $params Paramètres GET ou POST
     * @param string $method Méthode HTTP ("GET" ou "POST")
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
     * Récupère un paramètre dans un tableau (GET ou POST).
     *
     * @param array  $array      Tableau source (ex : $_GET ou $_POST)
     * @param string $paramName  Nom du paramètre à récupérer
     * @param bool   $canBeEmpty True si la valeur peut être vide
     *
     * @return mixed La valeur du paramètre
     *
     * @throws Exception Si le paramètre est absent ou vide selon le cas
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

    /**
     * Méthode exécutée lorsque la route est appelée en GET.
     */
    abstract public function get(array $params = []): void;

    /**
     * Méthode exécutée lorsque la route est appelée en POST.
     */
    abstract public function post(array $params = []): void;
}
