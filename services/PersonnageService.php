<?php

namespace Services;

use Models\Personnage;
use Models\PersonnageDAO;
use Models\ElementDAO;
use Models\OriginDAO;
use Models\UnitClassDAO;

/**
 * Service chargé de centraliser la logique métier liée aux personnages.
 * Sert d'intermédiaire entre les contrôleurs et les DAO.
 *
 * Rôle :
 *  - Coordonner les DAO
 *  - Fournir des personnages COMPLETS (avec attributs hydratés)
 *  - Simplifier les appels CRUD effectués par les contrôleurs
 */
class PersonnageService
{
    private PersonnageDAO $persoDAO;
    private ElementDAO $elementDAO;
    private OriginDAO $originDAO;
    private UnitClassDAO $unitclassDAO;

    public function __construct()
    {
        $this->persoDAO      = new PersonnageDAO();
        $this->elementDAO    = new ElementDAO();
        $this->originDAO     = new OriginDAO();
        $this->unitclassDAO  = new UnitClassDAO();
    }

    /**
     * Retourne tous les personnages COMPLETS.
     *
     * @return Personnage[]
     */
    public function getAll(): array
    {
        return $this->persoDAO->getAll();
    }

    /**
     * Retourne un personnage COMPLET via son ID.
     *
     * @param string $id
     * @return Personnage|null
     */
    public function getById(string $id): ?Personnage
    {
        return $this->persoDAO->getByID($id);
    }

    /**
     * Crée un personnage via le DAO.
     *
     * @param Personnage $p
     * @return bool
     */
    public function create(Personnage $p): bool
    {
        return $this->persoDAO->createPersonnage($p);
    }

    /**
     * Met à jour un personnage existant.
     *
     * @param Personnage $p
     * @return bool
     */
    public function update(Personnage $p): bool
    {
        return $this->persoDAO->updatePersonnage($p);
    }

    /**
     * Supprime un personnage via son ID.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->persoDAO->deletePerso($id);
    }
}
