<?php
class Habitat
{
    private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // Récupérer tous les habitats
    public function getAll(): array
    {
        $result = $this->conn->query("SELECT * FROM habitat");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Récupérer les animaux pour un habitat donné (par nom)
    public function getAnimalsByHabitat(string $habitatNom): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE habitat = ?");
        $stmt->bind_param("s", $habitatNom);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Ajouter un nouvel habitat
    public function add(string $nom, string $description, ?string $commentaire, ?string $imagePath): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO habitat (nom, description, commentaire_habitat, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $description, $commentaire, $imagePath);
        return $stmt->execute();
    }

    // Modifier un habitat
    public function update(int $id, string $nom, string $description, ?string $commentaire, ?string $imagePath = null): bool
    {
        if ($imagePath) {
            $stmt = $this->conn->prepare("UPDATE habitat SET nom = ?, description = ?, commentaire_habitat = ?, image_path = ? WHERE habitat_id = ?");
            $stmt->bind_param("ssssi", $nom, $description, $commentaire, $imagePath, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE habitat SET nom = ?, description = ?, commentaire_habitat = ? WHERE habitat_id = ?");
            $stmt->bind_param("sssi", $nom, $description, $commentaire, $id);
        }
        return $stmt->execute();
    }

    // Supprimer un habitat
    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM habitat WHERE habitat_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}