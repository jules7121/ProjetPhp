<?php
require_once 'helpers/Psr4AutoloaderClass.php';

$loader = new Helpers\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('\Helpers', '/helpers');
$loader->addNamespace('\League\Plates', 'vendor/plates/src');

use League\Plates\Engine;

$templates = new Engine( '/Views');

echo $templates->render('home', [
    'gameName' => 'Genshin Impact'
]);
