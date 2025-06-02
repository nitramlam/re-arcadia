<?php


class Service {
    private int $id;
    private string $nom;
    private string $description;
    private ?string $icons_path;

    public function __construct(array $data) {
        $this->id = (int)($data['service_id'] ?? 0);
        $this->nom = $data['nom'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->icons_path = $data['icons_path'] ?? null;
    }

    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getDescription(): string { return $this->description; }
    public function getIconsPath(): ?string { return $this->icons_path; }
}