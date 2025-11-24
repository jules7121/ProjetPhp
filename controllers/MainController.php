<?php

namespace Controllers;

use League\Plates\Engine;
use Models\PersonnageDAO;
use Helpers\Message;

class MainController
{
    private Engine $templates;

    public function __construct()
    {
        $this->templates = new Engine(__DIR__ . '/../views');
    }

    /**
     * Page d’accueil : liste des personnages
     *
     * @param mixed $message Peut être null, string ou Helpers\Message
     */
    public function index($message = null): void
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

    public function logs($message = null): void
{
    $service = new \Services\LogService();

    $files = $service->listLogs();
    $content = null;

    if (isset($_GET['file'])) {
        $content = $service->read($_GET['file']);
    }

    echo $this->templates->render('logs', [
        'message' => $message,
        'files'   => $files,
        'content' => $content
    ]);
}


    public function login($message = null): void
    {
        echo $this->templates->render('login', [
            'message' => $message,
        ]);
    }
}
