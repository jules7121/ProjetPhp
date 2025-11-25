<?php

require_once 'helpers/Psr4AutoloaderClass.php';

$loader = new Helpers\Psr4AutoloaderClass();
$loader->register();

/**
 * Namespaces → dossiers (relatifs à index.php)
 */
$loader->addNamespace('Helpers', 'helpers');
$loader->addNamespace('League\\Plates', 'vendor/plates/src');
$loader->addNamespace('Controllers', 'controllers');
$loader->addNamespace('Models', 'models');
$loader->addNamespace('Config', 'config');
$loader->addNamespace('Services', 'services');





use Controllers\Router\Router;

// On délègue tout au routeur
$router = new Router();
$router->routing($_GET, $_POST);
