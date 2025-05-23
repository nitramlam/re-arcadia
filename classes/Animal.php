<?php

require_once __DIR__ . '/Database.php';

class Animal {
    private mysqli $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM animal";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByHabitat(string $habitat): array {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE habitat = ?");
        $stmt->bind_param("s", $habitat);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }
}