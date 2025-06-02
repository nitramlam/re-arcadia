<?php

require_once 'Habitat.php';

class HabitatManager {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $result = $this->conn->query("SELECT * FROM habitat");
        $habitats = [];
        while ($row = $result->fetch_assoc()) {
            $habitats[] = new Habitat($row);
        }
        return $habitats;
    }

    public function getById(int $id): ?Habitat {
        $stmt = $this->conn->prepare("SELECT * FROM habitat WHERE habitat_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $data = $res->fetch_assoc();
        return $data ? new Habitat($data) : null;
    }

    public function getAnimalsByHabitat(string $habitatNom): array {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE habitat = ?");
        $stmt->bind_param("s", $habitatNom);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function add(Habitat $habitat): bool {
        $nom = $habitat->getNom();
        $description = $habitat->getDescription();
        $commentaire = $habitat->getCommentaire();
        $imagePath = $habitat->getImagePath();

        $stmt = $this->conn->prepare("INSERT INTO habitat (nom, description, commentaire_habitat, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $description, $commentaire, $imagePath);
        return $stmt->execute();
    }

    public function update(Habitat $habitat): bool {
        $nom = $habitat->getNom();
        $description = $habitat->getDescription();
        $commentaire = $habitat->getCommentaire();
        $id = $habitat->getId();

        if ($habitat->getImagePath()) {
            $imagePath = $habitat->getImagePath();
            $stmt = $this->conn->prepare("UPDATE habitat SET nom = ?, description = ?, commentaire_habitat = ?, image_path = ? WHERE habitat_id = ?");
            $stmt->bind_param("ssssi", $nom, $description, $commentaire, $imagePath, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE habitat SET nom = ?, description = ?, commentaire_habitat = ? WHERE habitat_id = ?");
            $stmt->bind_param("sssi", $nom, $description, $commentaire, $id);
        }

        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM habitat WHERE habitat_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}