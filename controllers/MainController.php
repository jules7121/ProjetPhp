<?php

namespace Controllers;

use League\Plates\Engine;

class MainController
{
    private Engine $templates;

    public function __construct()
    {
        // __DIR__ = PROJETPHPBDD/controllers
        // On remonte d'un dossier (..) puis on va dans views
        $this->templates = new Engine(__DIR__ . '/../views');
    }

    public function index(): void
    {
        echo $this->templates->render('home', [
            'gameName' => 'Genshin Impact'
        ]);
    }
}
