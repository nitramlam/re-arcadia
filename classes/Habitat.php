<?php

class Habitat {
    public int $id;
    public string $nom;
    public string $description;
    public ?string $commentaire;
    public ?string $imagePath;

    public function __construct(array $data) {
        $this->id = (int)($data['habitat_id'] ?? 0);
        $this->nom = $data['nom'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->commentaire = $data['commentaire_habitat'] ?? null;
        $this->imagePath = $data['image_path'] ?? null;
    }

    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getDescription(): string { return $this->description; }
    public function getCommentaire(): ?string { return $this->commentaire; }
    public function getImagePath(): ?string { return $this->imagePath; }
}