<?php

namespace Models;

use PDO;

/**
 * DAO chargé de gérer les opérations CRUD liées aux classes/unités
 * (ex : Sword, Mage, Destruction, Harmony...).
 * Correspond à la table UNITCLASS.
 */
class UnitClassDAO extends BasePDODAO
{
    /**
     * Crée une nouvelle classe/unité en base.
     *
     * @param UnitClass $u
     * @return bool Succès ou échec de l'insertion
     */
    public function createUnitClass(UnitClass $u): bool
    {
        $sql = "INSERT INTO unitclass (name, urlImg)
                VALUES (:name, :urlImg)";

        $params = [
            ':name'   => $u->getName(),
            ':urlImg' => $u->getUrlImg()
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt !== false && $stmt->rowCount() === 1;
    }

    /**
     * Retourne toutes les classes triées par nom.
     *
     * @return UnitClass[]
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM unitclass ORDER BY name ASC";
        $stmt  = $this->execRequest($sql);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];

        foreach ($rows as $row) {
            $u = new UnitClass();
            $u->setId((int)$row['id']);
            $u->setName($row['name']);
            $u->setUrlImg($row['urlImg'] ?? null);
            $list[] = $u;
        }

        return $list;
    }

    /**
     * Récupère une classe via son ID.
     *
     * @param int $id
     * @return UnitClass|null Retourne null si non trouvée
     */
    public function getById(int $id): ?UnitClass
    {
        $sql  = "SELECT * FROM unitclass WHERE id = ?";
        $stmt = $this->execRequest($sql, [$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $u = new UnitClass();
        $u->setId((int)$row['id']);
        $u->setName($row['name']);
        $u->setUrlImg($row['urlImg'] ?? null);

        return $u;
    }
}
