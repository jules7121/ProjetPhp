<?php
require_once 'helpers/Psr4AutoloaderClass.php';

$loader = new Helpers\Psr4AutoloaderClass();
$loader->register();

// namespaces -> dossiers (relatifs à index.php)
$loader->addNamespace('Helpers', 'helpers');
$loader->addNamespace('League\Plates', 'vendor/plates/src');
$loader->addNamespace('Controllers', 'controllers');

use Controllers\MainController;

$controller = new MainController();
$controller->index();
