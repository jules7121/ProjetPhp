<?php

namespace Models;


class Personnage
{
    
    private ?string $id = null;

   
    private string $name;

    
    private int $rarity;

    
    private string $urlImg;

    // --- IDs internes pour les relations (utilisés par le DAO/Service) ---

    
    private ?int $elementId = null;

    
    private ?int $unitclassId = null;

    
    private ?int $originId = null;

    // --- Objets liés hydratés (après passage par le Service) ---

    
    private ?Element $element = null;

   
    private ?UnitClass $unitclass = null;

    
    private ?Origin $origin = null;

    // ============================================================
    //                     GETTERS / SETTERS
    // ============================================================

    public function getId(): ?string { return $this->id; }

    public function getName(): string { return $this->name; }

    public function getRarity(): int { return $this->rarity; }

    public function getUrlImg(): string { return $this->urlImg; }

    public function setId(?string $id): void { $this->id = $id; }

    public function setName(string $name): void { $this->name = $name; }

    public function setRarity(int $rarity): void { $this->rarity = $rarity; }

    public function setUrlImg(string $urlImg): void { $this->urlImg = $urlImg; }

    // --- IDs relationnels (FK) ----------------------------------

    public function getElementId(): ?int { return $this->elementId; }

    public function getUnitclassId(): ?int { return $this->unitclassId; }

    public function getOriginId(): ?int { return $this->originId; }

    public function setElementId(?int $id): void { $this->elementId = $id; }

    public function setUnitclassId(?int $id): void { $this->unitclassId = $id; }

    public function setOriginId(?int $id): void { $this->originId = $id; }

    // --- Objets hydratés ----------------------------------------

    public function getElement(): ?Element { return $this->element; }

    public function getUnitclass(): ?UnitClass { return $this->unitclass; }

    public function getOrigin(): ?Origin { return $this->origin; }

    public function setElement(?Element $element): void { $this->element = $element; }
    
    public function setUnitclass(?UnitClass $unitclass): void { $this->unitclass = $unitclass; }

    public function setOrigin(?Origin $origin): void { $this->origin = $origin; }
}
