<?php

namespace Models;

use PDO;

/**
 * DAO responsable de la gestion des utilisateurs.
 * Permet :
 *  - la création d’un utilisateur
 *  - la recherche par username
 *
 * Utilisé principalement par AuthService.
 */
class UserDAO extends BasePDODAO
{
    /**
     * Insère un nouvel utilisateur dans la base.
     *
     * @param User $u
     * @return bool Succès ou échec de l'insertion
     */
    public function create(User $u): bool
    {
        $sql = "INSERT INTO users (id, username, hash_pwd)
                VALUES (:id, :username, :hash_pwd)";

        $params = [
            ':id'       => $u->getId(),
            ':username' => $u->getUsername(),
            ':hash_pwd' => $u->getHashPwd(),
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt !== false && $stmt->rowCount() === 1;
    }

    /**
     * Recherche un utilisateur via son username.
     *
     * @param string $username
     * @return User|null Retourne null si aucun utilisateur trouvé
     */
    public function findByUsername(string $username): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->execRequest($sql, [':username' => $username]);

        if (!$stmt) return null;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return $this->map($row);
    }

    /**
     * Transforme un tableau associatif SQL en objet User.
     *
     * @param array $row
     * @return User
     */
    private function map(array $row): User
    {
        $u = new User();
        $u->setId($row['id']);
        $u->setUsername($row['username']);
        $u->setHashPwd($row['hash_pwd']);
        return $u;
    }
}
