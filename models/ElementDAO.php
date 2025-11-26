<?php

namespace Models;

use PDO;

/**
 * DAO chargé de gérer les opérations CRUD pour les éléments.
 * Correspond à la table ELEMENT.
 */
class ElementDAO extends BasePDODAO
{
    /**
     * Insère un nouvel élément en base.
     *
     * @param Element $e Élément à créer
     * @return bool Succès ou échec de l'insertion
     */
    public function createElement(Element $e): bool
    {
        $sql = "INSERT INTO element (name, urlImg)
                VALUES (:name, :urlImg)";

        $params = [
            ':name'   => $e->getName(),
            ':urlImg' => $e->getUrlImg()
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt !== false && $stmt->rowCount() === 1;
    }

    /**
     * Retourne tous les éléments triés par nom.
     *
     * @return Element[]
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM element ORDER BY name ASC";
        $stmt = $this->execRequest($sql);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];

        foreach ($rows as $row) {
            $e = new Element();
            $e->setId((int)$row['id']);
            $e->setName($row['name']);
            $e->setUrlImg($row['urlImg'] ?? null);
            $list[] = $e;
        }

        return $list;
    }

    /**
     * Récupère un élément via son ID.
     *
     * @param int $id
     * @return Element|null Retourne null si non trouvé
     */
    public function getById(int $id): ?Element
    {
        $sql = "SELECT * FROM element WHERE id = ?";
        $stmt = $this->execRequest($sql, [$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $e = new Element();
        $e->setId((int)$row['id']);
        $e->setName($row['name']);
        $e->setUrlImg($row['urlImg'] ?? null);

        return $e;
    }
}
