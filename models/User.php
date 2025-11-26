<?php

namespace Models;

/**
 * Modèle représentant un utilisateur authentifiable.
 *
 * Correspond à la table USERS :
 *  - id (varchar)
 *  - username (varchar)
 *  - hash_pwd (varchar)
 *
 * Utilisé par AuthService pour gérer la connexion/destruction de session.
 */
class User
{
    private ?string $id = null;
    private string $username;
    private string $hashPwd;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getHashPwd(): string
    {
        return $this->hashPwd;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setHashPwd(string $hash): void
    {
        $this->hashPwd = $hash;
    }
}
