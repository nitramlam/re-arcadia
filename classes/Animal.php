<?php

class Animal {
    private int $id;
    private string $nom;
    private string $espece;
    private ?string $etat_general;
    private ?string $regime;
    private float $poids;
    private string $sexe;
    private ?string $derniere_visite;
    private ?string $commentaire;
    private string $continent_origine;
    private int $age;
    private string $habitat;
    private ?float $grammage;
    private ?string $description;
    private ?string $date_heure_passage_employe;
    private ?float $grammage_donne;
    private ?string $nourriture_donnee;
    private ?string $image_path;
    private ?string $page_personnalisee_url;

    public function __construct(array $data) {
        $this->id = (int)($data['animal_id'] ?? 0);
        $this->nom = $data['nom'] ?? '';
        $this->espece = $data['espece'] ?? '';
        $this->etat_general = $data['etat_general'] ?? null;
        $this->regime = $data['regime'] ?? null;
        $this->poids = (float)($data['poids'] ?? 0);
        $this->sexe = $data['sexe'] ?? '';
        $this->derniere_visite = $data['derniere_visite'] ?? null;
        $this->commentaire = $data['commentaire'] ?? null;
        $this->continent_origine = $data['continent_origine'] ?? '';
        $this->age = (int)($data['age'] ?? 0);
        $this->habitat = $data['habitat'] ?? '';
        $this->grammage = isset($data['grammage']) ? (float)$data['grammage'] : null;
        $this->description = $data['description'] ?? null;
        $this->date_heure_passage_employe = $data['date_heure_passage_employe'] ?? null;
        $this->grammage_donne = isset($data['grammage_donne']) ? (float)$data['grammage_donne'] : null;
        $this->nourriture_donnee = $data['nourriture_donnee'] ?? null;
        $this->image_path = $data['image_path'] ?? null;
        $this->page_personnalisee_url = $data['page_personnalisee_url'] ?? null;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getEspece(): string { return $this->espece; }
    public function getEtatGeneral(): ?string { return $this->etat_general; }
    public function getRegime(): ?string { return $this->regime; }
    public function getPoids(): float { return $this->poids; }
    public function getSexe(): string { return $this->sexe; }
    public function getDerniereVisite(): ?string { return $this->derniere_visite; }
    public function getCommentaire(): ?string { return $this->commentaire; }
    public function getContinentOrigine(): string { return $this->continent_origine; }
    public function getAge(): int { return $this->age; }
    public function getHabitat(): string { return $this->habitat; }
    public function getGrammage(): ?float { return $this->grammage; }
    public function getDescription(): ?string { return $this->description; }
    public function getDatePassageEmploye(): ?string { return $this->date_heure_passage_employe; }
    public function getGrammageDonne(): ?float { return $this->grammage_donne; }
    public function getNourritureDonnee(): ?string { return $this->nourriture_donnee; }
    public function getImagePath(): ?string { return $this->image_path; }
    public function getPageUrl(): ?string { return $this->page_personnalisee_url; }
}