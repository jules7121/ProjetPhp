<?php

namespace Models;

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
