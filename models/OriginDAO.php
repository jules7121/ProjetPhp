<?php

namespace Models;

use PDO;

class OriginDAO extends BasePDODAO
{
    public function createOrigin(Origin $origin): bool
    {
        $sql = "INSERT INTO origin (name, urlImg)
                VALUES (:name, :urlImg)";

        $params = [
            ':name' => $origin->getName(),
            ':urlImg' => $origin->getUrlImg()
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt !== false && $stmt->rowCount() === 1;
    }

    /**
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
