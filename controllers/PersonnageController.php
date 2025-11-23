<?php

namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;

class PersonnageController
{
    private Engine $templates;
    private PersonnageDAO $dao;
    private MainController $mainController;

    public function __construct()
    {
        $this->templates      = new Engine(__DIR__ . '/../views');
        $this->dao            = new PersonnageDAO();
        $this->mainController = new MainController();
    }

    public function displayAddPerso(?string $message = null): void
    {
        echo $this->templates->render('add-perso', [
            'message' => $message,
            'mode'    => 'create',
        ]);
    }

    public function displayEditPerso(string $idPerso, ?string $message = null): void
    {
        $perso = $this->dao->getByID($idPerso);

        if ($perso === null) {
            $this->displayAddPerso("Personnage introuvable.");
            return;
        }

        echo $this->templates->render('add-perso', [
            'message' => $message,
            'mode'    => 'edit',
            'perso'   => $perso,
        ]);
    }

    public function displayAddPersoElement(): void
    {
        echo $this->templates->render('add-perso-element');
    }

    
    public function addPerso(array $data): void
    {
        $perso = new Personnage();
        $perso->setId(uniqid('', true));
        $perso->setName($data['name']);
        $perso->setElement($data['element']);
        $perso->setUnitclass($data['unitclass']);
        $perso->setRarity((int)$data['rarity']);
        $perso->setOrigin($data['origin'] ?: null);
        $perso->setUrlImg($data['url_img']);

        $ok = $this->dao->createPersonnage($perso);

        $message = $ok
            ? "Personnage créé avec succès."
            : "Erreur lors de la création du personnage.";

        $this->mainController->index($message);


    }

    public function deletePersoAndIndex(?string $idPerso = null): void
{
    if ($idPerso === null) {
        $this->mainController->index("Aucun identifiant de personnage fourni.");
        return;
    }

    $ok = $this->dao->deletePerso($idPerso);

    $message = $ok
        ? "Personnage supprimé avec succès."
        : "Aucun personnage supprimé (id introuvable ?).";

    $this->mainController->index($message);
}

    
}
