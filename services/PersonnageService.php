<?php

namespace Services;

use Models\Personnage;
use Models\PersonnageDAO;
use Models\ElementDAO;
use Models\OriginDAO;
use Models\UnitClassDAO;

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
     * Retourne un tableau de Personnage COMPLETS (hydration objets incluse)
     */
    public function getAll(): array
    {
        return $this->persoDAO->getAll();
    }

    /**
     * Retourne un personnage COMPLET selon son ID
     */
    public function getById(string $id): ?Personnage
    {
        return $this->persoDAO->getByID($id);
    }

    /**
     * Crée un personnage (appel au DAO)
     */
    public function create(Personnage $p): bool
    {
        return $this->persoDAO->createPersonnage($p);
    }

    /**
     * Met à jour un personnage
     */
    public function update(Personnage $p): bool
    {
        return $this->persoDAO->updatePersonnage($p);
    }

    /**
     * Supprime un personnage par ID
     */
    public function delete(string $id): bool
    {
        return $this->persoDAO->deletePerso($id);
    }
}
