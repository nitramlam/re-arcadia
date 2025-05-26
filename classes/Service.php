<?php

class Service
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // Récupère tous les services
    public function getAll(): array
    {
        $sql = "SELECT * FROM service";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Ajoute un service
    public function add(string $nom, string $description, string $imagePath): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO service (nom, description, icons_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $description, $imagePath);
        return $stmt->execute();
    }

    // Modifie un service
    public function update(int $id, string $nom, string $description, ?string $imagePath = null): bool
    {
        if ($imagePath) {
            $stmt = $this->conn->prepare("UPDATE service SET nom = ?, description = ?, icons_path = ? WHERE service_id = ?");
            $stmt->bind_param("sssi", $nom, $description, $imagePath, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE service SET nom = ?, description = ? WHERE service_id = ?");
            $stmt->bind_param("ssi", $nom, $description, $id);
        }
        return $stmt->execute();
    }

    // Supprime un service
    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM service WHERE service_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Récupère les horaires
    public function getHoraires(): ?array
    {
        $result = $this->conn->query("SELECT * FROM horaires LIMIT 1");
        return $result ? $result->fetch_assoc() : null;
    }

    // Met à jour les horaires
    public function updateHoraires(string $ouverture, string $fermeture): bool
    {
        $stmt = $this->conn->prepare("UPDATE horaires SET ouverture = ?, fermeture = ? WHERE horaire_id = 1");
        $stmt->bind_param("ss", $ouverture, $fermeture);
        return $stmt->execute();
    }
}