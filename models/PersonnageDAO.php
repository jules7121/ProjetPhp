<?php

namespace Models;

use PDO;

class PersonnageDAO extends BasePDODAO
{
    /**
     * Retourne tous les personnages
     * @return Personnage[]
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM personnage";
        $stmt = $this->execRequest($sql);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            $p = new Personnage();
            $p->setId($row['id']);
            $p->setName($row['name']);
            $p->setElement($row['element']);
            $p->setUnitclass($row['unitclass']);
            $p->setRarity((int)$row['rarity']);
            $p->setOrigin($row['origin']);
            $p->setUrlImg($row['urlImg']);

            $result[] = $p;
        }

        return $result;
    }

    /**
     * Retourne un personnage par son id ou null
     */
    public function getByID(string $idPersonnage): ?Personnage
    {
        $sql = "SELECT * FROM personnage WHERE id = ?";
        $stmt = $this->execRequest($sql, [$idPersonnage]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $p = new Personnage();
        $p->setId($row['id']);
        $p->setName($row['name']);
        $p->setElement($row['element']);
        $p->setUnitclass($row['unitclass']);
        $p->setRarity((int)$row['rarity']);
        $p->setOrigin($row['origin']);
        $p->setUrlImg($row['urlImg']);

        return $p;
    }
    public function createPersonnage(Personnage $p): bool
{
    $sql = "INSERT INTO personnage (id, name, element, unitclass, rarity, origin, urlImg)
            VALUES (:id, :name, :element, :unitclass, :rarity, :origin, :urlImg)";

    $params = [
        ':id'        => $p->getId(),
        ':name'      => $p->getName(),
        ':element'   => $p->getElement(),
        ':unitclass' => $p->getUnitclass(),
        ':rarity'    => $p->getRarity(),
        ':origin'    => $p->getOrigin(),
        ':urlImg'   => $p->getUrlImg(),
    ];

    $stmt = $this->execRequest($sql, $params);
    return $stmt !== false && $stmt->rowCount() === 1;
}

    public function deletePerso(string $idPerso): bool
{
    $sql = "DELETE FROM personnage WHERE id = ?";
    $stmt = $this->execRequest($sql, [$idPerso]);

    return $stmt !== false && $stmt->rowCount() === 1;
}

}


