<?php

namespace Models;

use PDO;

/**
 * DAO chargé de gérer les opérations CRUD liées aux origines des personnages.
 * Correspond à la table ORIGIN.
 */
class OriginDAO extends BasePDODAO
{
    /**
     * Crée une nouvelle origine dans la base.
     *
     * @param Origin $origin
     * @return bool Succès ou échec de l'insertion
     */
    public function createOrigin(Origin $origin): bool
    {
        $sql = "INSERT INTO origin (name, urlImg)
                VALUES (:name, :urlImg)";

        $params = [
            ':name'   => $origin->getName(),
            ':urlImg' => $origin->getUrlImg()
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt !== false && $stmt->rowCount() === 1;
    }

    /**
     * Retourne toutes les origines triées par nom.
     *
     * @return Origin[]
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM origin ORDER BY name ASC";
        $stmt = $this->execRequest($sql);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];

        foreach ($rows as $row) {
            $o = new Origin();
            $o->setId((int)$row['id']);
            $o->setName($row['name']);
            $o->setUrlImg($row['urlImg'] ?? null);
            $list[] = $o;
        }

        return $list;
    }

    /**
     * Récupère une origine via son ID.
     *
     * @param int $id
     * @return Origin|null Retourne null si aucune origine trouvée
     */
    public function getById(int $id): ?Origin
    {
        $sql = "SELECT * FROM origin WHERE id = ?";
        $stmt = $this->execRequest($sql, [$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $o = new Origin();
        $o->setId((int)$row['id']);
        $o->setName($row['name']);
        $o->setUrlImg($row['urlImg'] ?? null);

        return $o;
    }
}
