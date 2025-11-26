<?php

namespace Services;

use Models\CollectionDAO;

class CollectionService
{
    private CollectionDAO $dao;

    public function __construct()
    {
        $this->dao = new CollectionDAO();
    }

    /**
     * Ajoute un personnage dans la collection d’un utilisateur.
     *
     * @param string $userId  ID utilisateur
     * @param string $persoId ID du personnage
     * @return bool Succès ou échec
     */
    public function addToCollection(string $userId, string $persoId): bool
    {
        return $this->dao->add($userId, $persoId);
    }

    /**
     * Retire un personnage de la collection d’un utilisateur.
     *
     * @param string $userId
     * @param string $persoId
     * @return bool Succès ou échec
     */
    public function removeFromCollection(string $userId, string $persoId): bool
    {
        return $this->dao->remove($userId, $persoId);
    }

    /**
     * Retourne tous les IDs de personnages appartenant à l'utilisateur.
     *
     * @param string $userId
     * @return array Liste des IDs de personnages
     */
    public function getUserCollection(string $userId): array
    {
        return $this->dao->getPersoIdsForUser($userId);
    }

    /**
     * Vérifie si un personnage est présent dans la collection d’un utilisateur.
     *
     * @param string $userId
     * @param string $persoId
     * @return bool True si présent, false sinon
     */
    public function isInCollection(string $userId, string $persoId): bool
    {
        return $this->dao->isInCollection($userId, $persoId);
    }
}
