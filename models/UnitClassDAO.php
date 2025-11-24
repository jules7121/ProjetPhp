<?php

namespace Models;

use PDO;

class UnitClassDAO extends BasePDODAO
{
    public function createUnitClass(UnitClass $u): bool
    {
        $sql = "INSERT INTO unitclass (name, urlImg)
                VALUES (:name, :urlImg)";

        $params = [
            ':name' => $u->getName(),
            ':urlImg' => $u->getUrlImg()
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt !== false && $stmt->rowCount() === 1;
    }

    /**
     * @return UnitClass[]
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM unitclass ORDER BY name ASC";
        $stmt = $this->execRequest($sql);

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

    public function getById(int $id): ?UnitClass
    {
        $sql = "SELECT * FROM unitclass WHERE id = ?";
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
