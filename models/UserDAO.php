<?php

namespace Models;

use PDO;

class UserDAO extends BasePDODAO
{
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

    public function findByUsername(string $username): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->execRequest($sql, [':username' => $username]);

        if (!$stmt) return null;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return $this->map($row);
    }

    private function map(array $row): User
    {
        $u = new User();
        $u->setId($row['id']);
        $u->setUsername($row['username']);
        $u->setHashPwd($row['hash_pwd']);
        return $u;
    }
}
