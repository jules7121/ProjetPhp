<?php

namespace Models;

use Config\Config;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Classe mère pour tous les DAO utilisant PDO.
 * Fournit l'accès à la base de données et une méthode générique
 * pour exécuter des requêtes SQL (simples ou préparées).
 */
class BasePDODAO
{
    /** @var PDO|null Instance PDO utilisée par les DAO */
    private ?PDO $db = null;

    /**
     * Retourne l'instance PDO connectée à la BD.
     * Initialise la connexion au premier appel.
     *
     * @return PDO
     */
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
     * Exécute une requête SQL (préparée si $params est fourni).
     *
     * @param string $sql    Requête SQL à exécuter
     * @param array|null $params Paramètres pour requête préparée
     * @return PDOStatement|false
     */
    protected function execRequest(string $sql, array $params = null): PDOStatement|false
    {
        $db = $this->getDB();

        // Requête simple
        if ($params === null) {
            return $db->query($sql);
        }

        // Requête préparée
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
