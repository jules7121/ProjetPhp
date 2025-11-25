<?php

namespace Models;

use PDO;

class CollectionDAO extends BasePDODAO
{
    /**
     * Ajoute un personnage à la collection d'un utilisateur
     */
    public function add(string $userId, string $persoId): bool
    {
        // INSERT IGNORE pour éviter l'erreur si déjà présent
        $sql = "INSERT IGNORE INTO collection (user_id, perso_id)
                VALUES (:user_id, :perso_id)";

        $stmt = $this->execRequest($sql, [
            ':user_id'  => $userId,
            ':perso_id' => $persoId,
        ]);

        // On considère que si la requête s'exécute, c'est OK
        return $stmt !== false;
    }

    /**
     * Supprime un personnage de la collection d'un utilisateur
     */
    public function remove(string $userId, string $persoId): bool
    {
        $sql = "DELETE FROM collection
                WHERE user_id = :user_id AND perso_id = :perso_id";

        $stmt = $this->execRequest($sql, [
            ':user_id'  => $userId,
            ':perso_id' => $persoId,
        ]);

        return $stmt !== false && $stmt->rowCount() === 1;
    }

    /**
     * Récupère la liste des IDs de personnages possédés par un utilisateur
     *
     * @return string[] liste d'id de personnages
     */
    public function getPersoIdsForUser(string $userId): array
    {
        $sql = "SELECT perso_id
                FROM collection
                WHERE user_id = :user_id";

        $stmt = $this->execRequest($sql, [':user_id' => $userId]);

        if (!$stmt) {
            return [];
        }

        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        return $rows ?: [];
    }

    /**
     * Vérifie si un perso est déjà dans la collection de l'utilisateur
     */
    public function isInCollection(string $userId, string $persoId): bool
    {
        $sql = "SELECT 1
                FROM collection
                WHERE user_id = :user_id
                  AND perso_id = :perso_id
                LIMIT 1";

        $stmt = $this->execRequest($sql, [
            ':user_id'  => $userId,
            ':perso_id' => $persoId,
        ]);

        if (!$stmt) {
            return false;
        }

        return $stmt->fetchColumn() !== false;
    }
}
