<?php

namespace Models;

use Config\Config;
use PDO;
use PDOException;
use PDOStatement;

class BasePDODAO
{
    private ?PDO $db = null;

    protected function getDB(): PDO
    {
        if ($this->db === null) {
            $dsn  = Config::get('dsn');
            $user = Config::get('user');
            $pass = Config::get('pass');

            try {
                $this->db = new PDO($dsn, $user, $pass);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion à la base : " . $e->getMessage());
            }
        }

        return $this->db;
    }

    /**
     * Exécute une requête SQL
     */
    protected function execRequest(string $sql, array $params = null): PDOStatement|false
    {
        $db = $this->getDB();

        if ($params === null) {
            // Requête simple
            return $db->query($sql);
        } else {
            // Requête préparée
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
    }
}
