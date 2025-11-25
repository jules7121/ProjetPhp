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

    public function addToCollection(string $userId, string $persoId): bool
    {
        return $this->dao->add($userId, $persoId);
    }

    public function removeFromCollection(string $userId, string $persoId): bool
    {
        return $this->dao->remove($userId, $persoId);
    }

    public function getUserCollection(string $userId): array
    {
        return $this->dao->getPersoIdsForUser($userId);
    }

    public function isInCollection(string $userId, string $persoId): bool
    {
        return $this->dao->isInCollection($userId, $persoId);
    }
}
