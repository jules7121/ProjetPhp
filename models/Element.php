<?php

namespace Models;

class Element
{
    private ?int $id = null;
    private string $name;
    private ?string $urlImg = null;

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getUrlImg(): ?string { return $this->urlImg; }
    

    public function setId(?int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setUrlImg(?string $urlImg): void { $this->urlImg = $urlImg; }
}
