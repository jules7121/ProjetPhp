<?php

namespace Config;

use Exception;

class Config
{
    private static ?array $param = null;

    // Renvoie la valeur d'un paramètre de configuration
    public static function get(string $nom, $valeurParDefaut = null)
    {
        if (isset(self::getParameter()[$nom])) {
            $valeur = self::getParameter()[$nom];
        } else {
            $valeur = $valeurParDefaut;
        }
        return $valeur;
    }

    // Charge le fichier ini (prod.ini si existe, sinon dev.ini)
    private static function getParameter(): array
    {
        if (self::$param === null) {

            // On cherche d'abord un prod.ini puis un dev.ini
            $cheminFichier = __DIR__ . '/prod.ini';
            if (!file_exists($cheminFichier)) {
                $cheminFichier = __DIR__ . '/dev.ini';
            }

            if (!file_exists($cheminFichier)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            } else {
                // [DB] dsn=... user=... pass=...
                // parse_ini_file sans 2e param => les clés sont 'dsn','user','pass'
                self::$param = parse_ini_file($cheminFichier);
            }
        }

        return self::$param;
    }
}




