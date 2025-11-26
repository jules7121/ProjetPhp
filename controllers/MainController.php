<?php

namespace Controllers;

use League\Plates\Engine;
use Models\PersonnageDAO;
use Services\CollectionService;
use Helpers\Message;

class MainController
{
    private Engine $templates;

    public function __construct()
    {
        $this->templates = new Engine(__DIR__ . '/../views');
    }

    /**
     * Page d’accueil : liste des personnages de la collection de l’utilisateur s’il est connecté sinon tous les personnages
     *
     * @param mixed $message Peut être null, string ou Helpers\Message
     */
    public function index($message = null): void
    {
        $dao = new PersonnageDAO();
        
        // Récupère tous les personnages
        $listPersonnage = $dao->getAll();

        // Collection de l'utilisateur si connecté
        $auth = new \Services\AuthService();

        if ($auth->isLogged()) {
            $cs = new \Services\CollectionService();
            $collection = $cs->getUserCollection($_SESSION['user_id']);

            echo $this->templates->render('home', [
                'listPersonnage' => $listPersonnage,
                'collection'     => $collection,
                'onlyCollection' => true,
                'message'        => $message,
                'pageTitle'      => 'Collection Genshin Impact',
            ]);
            return;
        }

        echo $this->templates->render('home', [
            'listPersonnage' => $listPersonnage,
            'message'        => $message,
            'pageTitle'      => 'Collection Genshin Impact',
        ]);
    }

    /**
     * Page dédiée : liste complète de tous les personnages
     */
    public function allPerso($message = null): void
    {
        $dao = new PersonnageDAO();
        
        // Récupère tous les personnages
        $listPersonnage = $dao->getAll();

        // Collection de l'utilisateur si connecté
        $auth = new \Services\AuthService();

        if ($auth->isLogged()) {
            $cs = new \Services\CollectionService();
            $collection = $cs->getUserCollection($_SESSION['user_id']);

            echo $this->templates->render('home', [
                'listPersonnage' => $listPersonnage,
                'collection'     => $collection,
                'message'        => $message,
                'pageTitle'      => 'Tous les personnages - Genshin Impact',
            ]);
            return;
        }

        echo $this->templates->render('home', [
            'listPersonnage' => $listPersonnage,
            'message'        => $message,
            'pageTitle'      => 'Tous les personnages - Genshin Impact',
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
