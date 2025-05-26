<?php

require_once __DIR__ . '/Database.php';

class Animal {
    private mysqli $conn;
    private MongoDB\Driver\Manager $mongoManager;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->mongoManager = new MongoDB\Driver\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");
    }

    public function getAll(): array {
        $result = $this->conn->query("SELECT * FROM animal");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByHabitat(string $habitat): array {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE habitat = ?");
        $stmt->bind_param("s", $habitat);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function updatePassageEmploye(int $animalId, string $datetime, float $grammage, string $nourriture): bool {
        $stmt = $this->conn->prepare("UPDATE animal SET date_heure_passage_employe = ?, grammage_donne = ?, nourriture_donnee = ? WHERE animal_id = ?");
        $stmt->bind_param("sdsi", $datetime, $grammage, $nourriture, $animalId);
        return $stmt->execute();
    }

    public function add(array $data, ?string $imagePath): int {
        $stmt = $this->conn->prepare("INSERT INTO animal (nom, description, poids, sexe, continent_origine, age, habitat, espece, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsdssss",
            $data['nom'], $data['description'], $data['poids'], $data['sexe'],
            $data['continent_origine'], $data['age'], $data['habitat'], $data['espece'], $imagePath
        );
        $stmt->execute();

        $id = $this->conn->insert_id;
        $url = $this->generatePage($id);
        $this->syncToMongo($id, $data['nom']);

        $stmt = $this->conn->prepare("UPDATE animal SET page_personnalisee_url = ? WHERE animal_id = ?");
        $stmt->bind_param("si", $url, $id);
        $stmt->execute();

        return $id;
    }

    public function update(int $id, array $data, ?string $imagePath = null): bool {
        if ($imagePath) {
            $stmt = $this->conn->prepare("UPDATE animal SET nom = ?, description = ?, poids = ?, sexe = ?, continent_origine = ?, age = ?, habitat = ?, espece = ?, image_path = ? WHERE animal_id = ?");
            $stmt->bind_param("ssdsdsssii",
                $data['nom'], $data['description'], $data['poids'], $data['sexe'],
                $data['continent_origine'], $data['age'], $data['habitat'], $data['espece'],
                $imagePath, $id
            );
        } else {
            $stmt = $this->conn->prepare("UPDATE animal SET nom = ?, description = ?, poids = ?, sexe = ?, continent_origine = ?, age = ?, habitat = ?, espece = ? WHERE animal_id = ?");
            $stmt->bind_param("ssdsdsssi",
                $data['nom'], $data['description'], $data['poids'], $data['sexe'],
                $data['continent_origine'], $data['age'], $data['habitat'], $data['espece'], $id
            );
        }

        $success = $stmt->execute();

        if ($success) {
            $this->generatePage($id);
            $this->syncToMongo($id, $data['nom']);
        }

        return $success;
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM animal WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $deleted = $stmt->execute();

        if ($deleted) {
            $this->deleteFromMongo($id);
        }

        return $deleted;
    }

    public function syncToMongo(int $id, string $nom): void {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['animal_id' => (string)$id],
            ['$set' => ['animal_id' => (string)$id, 'animal_name' => $nom, 'view_count' => 0]],
            ['upsert' => true]
        );
        $this->mongoManager->executeBulkWrite('arcadia.animal_views', $bulk);
    }

    public function deleteFromMongo(int $id): void {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete(['animal_id' => (string)$id]);
        $this->mongoManager->executeBulkWrite('arcadia.animal_views', $bulk);
    }

    public function generatePage(int $id): string {
        $animal = $this->getById($id);
        if (!$animal) throw new Exception("Animal introuvable.");

        $uploadDir = __DIR__ . '/../animaux_pages/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $pagePath = $uploadDir . "animal_{$id}.php";
        $content = $this->buildPageHtml($animal);
        file_put_contents($pagePath, $content);

        return "/animaux_pages/animal_{$id}.php";
    }

    private function buildPageHtml(array $a): string {
        return <<<HTML
<?php
require_once (__DIR__ . '/../includes/header.php');
\$manager = new MongoDB\\Driver\\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");
\$bulk = new MongoDB\\Driver\\BulkWrite;
\$bulk->update(['animal_id' => "{$a['animal_id']}"], ['\$inc' => ['view_count' => 1]]);
\$manager->executeBulkWrite('arcadia.animal_views', \$bulk);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{$a['nom']} - Page Personnalisée</title>
    <link rel="stylesheet" href="animauxPage.css">
</head>
<body>
    <div class="animal-main">
        <h1 class="animal-title">{$a['nom']}</h1>
        <img class="animal-photo" src="{$a['image_path']}" alt="{$a['nom']}">
        <div class="info-section">
            <h2>Informations Générales</h2>
            <p><strong>Espèce :</strong> {$a['espece']}</p>
            <p><strong>Description :</strong> {$a['description']}</p>
            <p><strong>Poids :</strong> {$a['poids']} kg</p>
            <p><strong>Sexe :</strong> {$a['sexe']}</p>
            <p><strong>Continent d'origine :</strong> {$a['continent_origine']}</p>
            <p><strong>Habitat :</strong> {$a['habitat']}</p>
        </div>
        <div class="medical-section">
            <h2>Données Médicales</h2>
            <p><strong>Régime :</strong> {$a['regime']}</p>
            <p><strong>Dernière visite :</strong> {$a['derniere_visite']}</p>
            <p><strong>État général :</strong> {$a['etat_general']}</p>
            <p><strong>Grammage :</strong> {$a['grammage']} kg</p>
            <p><strong>Commentaire :</strong> {$a['commentaire']}</p>
        </div>
    </div>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>
HTML;
    }
}
