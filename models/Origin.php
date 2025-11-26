<?php

namespace Models;

/**
 * Classe représentant une origine / région / faction
 * à laquelle appartient un personnage.
 *
 * Correspond à la table ORIGIN :
 *  - id (int, PK, auto-incrément)
 *  - name (string)
 *  - url_img (string|null)
 */
class Origin
{
    /** @var int|null Identifiant unique de l'origine (BD) */
    private ?int $id = null;

    /** @var string Nom de l'origine (ex : Mondstadt, Belobog...) */
    private string $name;

    /** @var string|null URL de l'image associée */
    private ?string $urlImg = null;

    // ============================================================
    //                           GETTERS
    // ============================================================

    /**
     * Retourne l'ID de l'origine.
     *
     * @return int|null
     */
    public function getId(): ?int { return $this->id; }

    /**
     * Retourne le nom de l'origine.
     *
     * @return string
     */
    public function getName(): string { return $this->name; }

    /**
     * Retourne l'URL de l'image associée.
     *
     * @return string|null
     */
    public function getUrlImg(): ?string { return $this->urlImg; }

    // ============================================================
    //                           SETTERS
    // ============================================================

   
    public function setId(?int $id): void { $this->id = $id; }

    
    public function setName(string $name): void { $this->name = $name; }

    
    public function setUrlImg(?string $urlImg): void { $this->urlImg = $urlImg; }
}
