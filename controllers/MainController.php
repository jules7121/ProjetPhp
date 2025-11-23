<?php

namespace Controllers;

use League\Plates\Engine;
use Models\PersonnageDAO;

class MainController
{
    private Engine $templates;

    public function __construct()
    {
        $this->templates = new Engine(__DIR__ . '/../views');
    }

    public function index(?string $message = null): void
    {
        $dao = new PersonnageDAO();

        // Récupère tous les personnages
        $listPersonnage = $dao->getAll();

        echo $this->templates->render('home', [
            'gameName'       => 'Genshin Impact',
            'listPersonnage' => $listPersonnage,
            'message'        => $message,
        ]);
        
    }


    public function logs(): void
    {
    echo $this->templates->render('logs');
    }

    public function login(): void
    {
    echo $this->templates->render('login');
}

    
}
