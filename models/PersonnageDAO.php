<?php

namespace Models;

use PDO;
use Services\LogService;


class PersonnageDAO extends BasePDODAO
{
    /**
     * Retourne tous les personnages avec leurs attributs hydratés
     *
     * @return Personnage[]
     */
    public function getAll(): array
    {
        $sql = "
            SELECT 
                p.*,
                e.name  AS element_name,
                e.urlImg AS element_img,
                o.name  AS origin_name,
                o.urlImg AS origin_img,
                u.name  AS unitclass_name,
                u.urlImg AS unitclass_img
            FROM personnage p
            LEFT JOIN element   e ON p.element_id   = e.id
            LEFT JOIN origin    o ON p.origin_id    = o.id
            LEFT JOIN unitclass u ON p.unitclass_id = u.id
        ";

        $stmt = $this->execRequest($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $list = [];

        foreach ($rows as $row) {
            $p = new Personnage();
            $p->setId($row['id']);
            $p->setName($row['name']);
            $p->setRarity((int)$row['rarity']);
            $p->setUrlImg($row['urlImg']);

            $p->setElementId($row['element_id']);
            $p->setUnitclassId($row['unitclass_id']);
            $p->setOriginId($row['origin_id']);

            // Hydratation des objets liés
            if ($row['element_id'] !== null) {
                $e = new Element();
                $e->setId((int)$row['element_id']);
                $e->setName($row['element_name']);
                $e->setUrlImg($row['element_img']);
                $p->setElement($e);
            }

            if ($row['unitclass_id'] !== null) {
                $u = new UnitClass();
                $u->setId((int)$row['unitclass_id']);
                $u->setName($row['unitclass_name']);
                $u->setUrlImg($row['unitclass_img']);
                $p->setUnitclass($u);
            }

            if ($row['origin_id'] !== null) {
                $o = new Origin();
                $o->setId((int)$row['origin_id']);
                $o->setName($row['origin_name']);
                $o->setUrlImg($row['origin_img']);
                $p->setOrigin($o);
            }

            $list[] = $p;
        }

        return $list;
    }

    /**
     * Récupère un personnage par ID avec attributs hydratés
     */
    public function getByID(string $id): ?Personnage
    {
        $sql = "
            SELECT 
                p.*,
                e.name  AS element_name,
                e.urlImg AS element_img,
                o.name  AS origin_name,
                o.urlImg AS origin_img,
                u.name  AS unitclass_name,
                u.urlImg AS unitclass_img
            FROM personnage p
            LEFT JOIN element   e ON p.element_id   = e.id
            LEFT JOIN origin    o ON p.origin_id    = o.id
            LEFT JOIN unitclass u ON p.unitclass_id = u.id
            WHERE p.id = ?
        ";

        $stmt = $this->execRequest($sql, [$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $p = new Personnage();
        $p->setId($row['id']);
        $p->setName($row['name']);
        $p->setRarity((int)$row['rarity']);
        $p->setUrlImg($row['urlImg']);

        $p->setElementId($row['element_id']);
        $p->setUnitclassId($row['unitclass_id']);
        $p->setOriginId($row['origin_id']);

        if ($row['element_id'] !== null) {
            $e = new Element();
            $e->setId((int)$row['element_id']);
            $e->setName($row['element_name']);
            $e->setUrlImg($row['element_img']);
            $p->setElement($e);
        }

        if ($row['unitclass_id'] !== null) {
            $u = new UnitClass();
            $u->setId((int)$row['unitclass_id']);
            $u->setName($row['unitclass_name']);
            $u->setUrlImg($row['unitclass_img']);
            $p->setUnitclass($u);
        }

        if ($row['origin_id'] !== null) {
            $o = new Origin();
            $o->setId((int)$row['origin_id']);
            $o->setName($row['origin_name']);
            $o->setUrlImg($row['origin_img']);
            $p->setOrigin($o);
        }

        return $p;
    }

    /**
     * Création d'un personnage
     */
    public function createPersonnage(Personnage $p): bool
{
    $sql = "INSERT INTO personnage (id, name, element_id, unitclass_id, origin_id, rarity, urlImg)
            VALUES (:id, :name, :element_id, :unitclass_id, :origin_id, :rarity, :urlImg)";

    $params = [
        ':id'            => $p->getId(),
        ':name'          => $p->getName(),
        ':element_id'    => $p->getElementId(),
        ':unitclass_id'  => $p->getUnitclassId(),
        ':origin_id'     => $p->getOriginId(),
        ':rarity'        => $p->getRarity(),
        ':urlImg'        => $p->getUrlImg(),
    ];

    $stmt = $this->execRequest($sql, $params);
    $success = $stmt !== false && $stmt->rowCount() === 1;

    (new LogService())->write(
        "CREATE",
        $success
            ? "Personnage '{$p->getName()}' créé (ID={$p->getId()})"
            : "Échec création personnage '{$p->getName()}'"
    );

    return $success;
}

    /**
     * Mise à jour d'un personnage
     */
    public function updatePersonnage(Personnage $p): bool
{
    $sql = "UPDATE personnage
            SET name = :name,
                element_id = :element_id,
                unitclass_id = :unitclass_id,
                origin_id = :origin_id,
                rarity = :rarity,
                urlImg = :urlImg
            WHERE id = :id";

    $params = [
        ':id'            => $p->getId(),
        ':name'          => $p->getName(),
        ':element_id'    => $p->getElementId(),
        ':unitclass_id'  => $p->getUnitclassId(),
        ':origin_id'     => $p->getOriginId(),
        ':rarity'        => $p->getRarity(),
        ':urlImg'        => $p->getUrlImg(),
    ];

    $stmt = $this->execRequest($sql, $params);
    $success = $stmt !== false && $stmt->rowCount() === 1;

    (new LogService())->write(
        "UPDATE",
        $success
            ? "Personnage '{$p->getName()}' mis à jour (ID={$p->getId()})"
            : "Échec update personnage '{$p->getName()}' (ID={$p->getId()})"
    );

    return $success;
}

    /**
     * Suppression simple
     */
    public function deletePerso(string $id): bool
{
    $perso = $this->getByID($id);
    $name = $perso ? $perso->getName() : "INCONNU";

    $sql = "DELETE FROM personnage WHERE id = ?";
    $stmt = $this->execRequest($sql, [$id]);
    $success = $stmt !== false && $stmt->rowCount() === 1;

    (new LogService())->write(
        "DELETE",
        $success
            ? "Personnage '$name' supprimé (ID=$id)"
            : "Échec suppression personnage (ID=$id)"
    );

    return $success;
} 
}