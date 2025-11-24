<?php

namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;
use Helpers\Message;
use Services\PersonnageService;




class PersonnageController
{
    private Engine $templates;
    private PersonnageService $service;
    private MainController $mainController;

    public function __construct()
    {
        $this->templates      = new Engine(__DIR__ . '/../views');
        $this->service = new PersonnageService();
        $this->mainController = new MainController();
    }

    /**
     * Affiche le formulaire d'ajout de personnage
     */
    public function displayAddPerso($message = null): void
    {
        $elementDAO   = new \Models\ElementDAO();
        $originDAO    = new \Models\OriginDAO();
        $unitclassDAO = new \Models\UnitClassDAO();

        echo $this->templates->render('add-perso', [
            'message'     => $message,
            'mode'        => 'create',
            'elements'    => $elementDAO->getAll(),
            'origins'     => $originDAO->getAll(),
            'unitclasses' => $unitclassDAO->getAll(),
        ]);
    }

    /**
     * Affiche le formulaire d'édition pré-rempli
     */
    public function displayEditPerso(string $idPerso, $message = null): void
    {
        $perso = $this->service->getById($idPerso);

        if ($perso === null) {
            $this->mainController->index(
                new Message("Personnage introuvable.", Message::COLOR_ERROR, "Erreur")
            );
            return;
        }

        $elementDAO   = new \Models\ElementDAO();
        $originDAO    = new \Models\OriginDAO();
        $unitclassDAO = new \Models\UnitClassDAO();

        echo $this->templates->render('add-perso', [
            'message'     => $message,
            'mode'        => 'edit',
            'perso'       => $perso,
            'elements'    => $elementDAO->getAll(),
            'origins'     => $originDAO->getAll(),
            'unitclasses' => $unitclassDAO->getAll(),
        ]);
    }

    public function displayAddPersoElement($message = null): void
{
    echo $this->templates->render('add-perso-element', [
        'message' => $message
    ]);
}

    /**
     * Création d'un personnage (POST)
     */
    public function addPerso(array $data): void
    {
        $perso = new Personnage();
        $perso->setId(uniqid('', true));
        $perso->setName($data['name']);
        $perso->setRarity((int)$data['rarity']);
        $perso->setUrlImg($data['url_img']);

        // IDs venant des <select>
        $perso->setElementId((int)$data['element']);
        $perso->setUnitclassId((int)$data['unitclass']);
        $perso->setOriginId($data['origin'] !== '' ? (int)$data['origin'] : null);

        $ok = $this->service->create($perso);

        $message = $ok
            ? new Message(
                "Personnage créé avec succès.",
                Message::COLOR_SUCCESS,
                "Création réussie"
            )
            : new Message(
                "Erreur lors de la création du personnage.",
                Message::COLOR_ERROR,
                "Erreur de création"
            );

        $this->mainController->index($message);
    }

    /**
     * Mise à jour d'un personnage existant (POST)
     */
    public function editPerso(array $data): void
    {
        $perso = $this->service->getById($data['idPerso']);

        if ($perso === null) {
            $message = new Message(
                "Personnage introuvable pour modification.",
                Message::COLOR_ERROR,
                "Erreur"
            );
            $this->mainController->index($message);
            return;
        }

        $perso->setName($data['name']);
        $perso->setRarity((int)$data['rarity']);
        $perso->setUrlImg($data['url_img']);

        $perso->setElementId((int)$data['element']);
        $perso->setUnitclassId((int)$data['unitclass']);
        $perso->setOriginId($data['origin'] !== '' ? (int)$data['origin'] : null);

        $ok = $this->service->update($perso);

        $message = $ok
            ? new Message(
                "Personnage modifié avec succès.",
                Message::COLOR_SUCCESS,
                "Modification réussie"
            )
            : new Message(
                "Aucune modification effectuée (vérifiez les données).",
                Message::COLOR_INFO,
                "Information"
            );

        $this->mainController->index($message);
    }

    public function deletePersoAndIndex(?string $idPerso = null): void
    {
        if ($idPerso === null) {
            $message = new Message(
                "Aucun identifiant de personnage fourni.",
                Message::COLOR_ERROR,
                "Erreur de suppression"
            );
            $this->mainController->index($message);
            return;
        }

        $ok = $this->service->delete($idPerso);

        $message = $ok
            ? new Message(
                "Personnage supprimé avec succès.",
                Message::COLOR_SUCCESS,
                "Suppression réussie"
            )
            : new Message(
                "Aucun personnage supprimé (id introuvable ?).",
                Message::COLOR_ERROR,
                "Erreur de suppression"
            );

        $this->mainController->index($message);
    }

    public function displayAddUnitClass($message = null): void
{
    echo $this->templates->render('add-unitclass', [
        'message' => $message
    ]);
}

    public function displayAddOrigin($message = null): void
{
    echo $this->templates->render('add-origin', [
        'message' => $message
    ]);
}



    
}
