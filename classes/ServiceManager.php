<?php
// classes/ServiceManager.php

require_once __DIR__ . '/Service.php';

class ServiceManager {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $result = $this->conn->query("SELECT * FROM service");
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = new Service($row);
        }
        return $services;
    }

    public function add(Service $service): bool {
        $stmt = $this->conn->prepare("INSERT INTO service (nom, description, icons_path) VALUES (?, ?, ?)");
        $nom = $service->getNom();
        $description = $service->getDescription();
        $icons_path = $service->getIconsPath();
        $stmt->bind_param("sss", $nom, $description, $icons_path);
        return $stmt->execute();
    }

    public function update(Service $service): bool {
        $nom = $service->getNom();
        $description = $service->getDescription();
        $id = $service->getId();

        if ($service->getIconsPath()) {
            $icons_path = $service->getIconsPath();
            $stmt = $this->conn->prepare("UPDATE service SET nom = ?, description = ?, icons_path = ? WHERE service_id = ?");
            $stmt->bind_param("sssi", $nom, $description, $icons_path, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE service SET nom = ?, description = ? WHERE service_id = ?");
            $stmt->bind_param("ssi", $nom, $description, $id);
        }
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM service WHERE service_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getHoraires(): ?array {
        $result = $this->conn->query("SELECT * FROM horaires LIMIT 1");
        return $result ? $result->fetch_assoc() : null;
    }

    public function updateHoraires(string $ouverture, string $fermeture): bool {
        $stmt = $this->conn->prepare("UPDATE horaires SET ouverture = ?, fermeture = ? WHERE horaire_id = 1");
        $stmt->bind_param("ss", $ouverture, $fermeture);
        return $stmt->execute();
    }
}