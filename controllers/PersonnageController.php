<?php

namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;
use Helpers\Message;
use Services\PersonnageService;

/**
 * Contrôleur gérant :
 *  - L'affichage des formulaires (création / modification)
 *  - L'appel au service pour créer / modifier / supprimer les personnages
 *  - Le rendu des vues avec Plates
 */
class PersonnageController
{
    private Engine $templates;
    private PersonnageService $service;
    private MainController $mainController;

    public function __construct()
    {
        $this->templates      = new Engine(__DIR__ . '/../views');
        $this->service        = new PersonnageService();
        $this->mainController = new MainController();
    }

    /**
     * Affiche le formulaire d'ajout de personnage.
     *
     * @param Message|null $message Message facultatif (succès/erreur)
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
     * Affiche le formulaire d'édition d'un personnage pré-rempli.
     *
     * @param string      $idPerso  ID du personnage
     * @param Message|null $message Message facultatif
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

    /**
     * Affiche la page d'ajout d'un nouvel élément d'attribut.
     */
    public function displayAddPersoElement($message = null): void
    {
        echo $this->templates->render('add-perso-element', [
            'message' => $message
        ]);
    }

    /**
     * Création d'un personnage depuis un POST.
     *
     * @param array $data Données du formulaire
     */
    public function addPerso(array $data): void
    {
        $perso = new Personnage();
        $perso->setId(uniqid('', true));
        $perso->setName($data['name']);
        $perso->setRarity((int)$data['rarity']);
        $perso->setUrlImg($data['url_img']);

        $perso->setElementId((int)$data['element']);
        $perso->setUnitclassId((int)$data['unitclass']);
        $perso->setOriginId($data['origin'] !== '' ? (int)$data['origin'] : null);

        $ok = $this->service->create($perso);

        $message = $ok
            ? new Message("Personnage créé avec succès.", Message::COLOR_SUCCESS, "Création réussie")
            : new Message("Erreur lors de la création du personnage.", Message::COLOR_ERROR, "Erreur de création");

        $this->mainController->index($message);
    }

    /**
     * Mise à jour d'un personnage depuis un POST.
     *
     * @param array $data Données du formulaire
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
            ? new Message("Personnage modifié avec succès.", Message::COLOR_SUCCESS, "Modification réussie")
            : new Message("Aucune modification effectuée.", Message::COLOR_INFO, "Information");

        $this->mainController->index($message);
    }

    /**
     * Supprime un personnage puis retourne à l'index avec un message.
     *
     * @param string|null $idPerso ID du personnage ou null
     */
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
            ? new Message("Personnage supprimé avec succès.", Message::COLOR_SUCCESS, "Suppression réussie")
            : new Message("Aucun personnage supprimé (id introuvable ?).", Message::COLOR_ERROR, "Erreur de suppression");

        $this->mainController->index($message);
    }

    /**
     * Affiche le formulaire d'ajout de classe (UnitClass).
     */
    public function displayAddUnitClass($message = null): void
    {
        echo $this->templates->render('add-unitclass', [
            'message' => $message
        ]);
    }

    /**
     * Affiche le formulaire d'ajout d'origine.
     */
    public function displayAddOrigin($message = null): void
    {
        echo $this->templates->render('add-origin', [
            'message' => $message
        ]);
    }
}
