<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Animal.php';

class AnimalManager {
    private mysqli $conn;
    private MongoDB\Driver\Manager $mongo;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
        $this->mongo = new MongoDB\Driver\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");
    }

    public function getAll(): array {
        $result = $this->conn->query("SELECT * FROM animal");
        $animaux = [];
        while ($row = $result->fetch_assoc()) {
            $animaux[] = new Animal($row);
        }
        return $animaux;
    }

    public function getById(int $id): ?Animal {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data ? new Animal($data) : null;
    }

    public function getByHabitat(string $habitat): array {
        $stmt = $this->conn->prepare("SELECT * FROM animal WHERE habitat = ?");
        $stmt->bind_param("s", $habitat);
        $stmt->execute();
        $result = $stmt->get_result();
        $animaux = [];
        while ($row = $result->fetch_assoc()) {
            $animaux[] = new Animal($row);
        }
        return $animaux;
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

        $this->syncToMongo($id, $data['nom']);
        $url = $this->generatePage($id);

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
            $this->syncToMongo($id, $data['nom']);
            $this->generatePage($id);
        }
        return $success;
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM animal WHERE animal_id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        if ($success) {
            $this->deleteFromMongo($id);
        }
        return $success;
    }

    private function syncToMongo(int $id, string $nom): void {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['animal_id' => (string) $id],
            ['$set' => ['animal_id' => (string) $id, 'animal_name' => $nom, 'view_count' => 0]],
            ['upsert' => true]
        );
        $this->mongo->executeBulkWrite('arcadia.animal_views', $bulk);
    }

    private function deleteFromMongo(int $id): void {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete(['animal_id' => (string) $id]);
        $this->mongo->executeBulkWrite('arcadia.animal_views', $bulk);
    }

    
    private function generatePage(int $id): string {
    $animal = $this->getById($id);
    if (!$animal) throw new Exception("Animal introuvable.");

    $uploadDir = __DIR__ . '/../public/animaux_pages/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $pagePath = $uploadDir . "animal_{$id}.php";
    $html = $this->buildPageHtml($animal);
    file_put_contents($pagePath, $html);

    return "/animaux_pages/animal_{$id}.php";
}

    private function buildPageHtml(Animal $a): string {
        return <<<HTML
<?php
require_once (__DIR__ . '/../includes/header.php');
\$manager = new MongoDB\\Driver\\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");
\$bulk = new MongoDB\\Driver\\BulkWrite;
\$bulk->update(['animal_id' => "{$a->getId()}"], ['\$inc' => ['view_count' => 1]]);
\$manager->executeBulkWrite('arcadia.animal_views', \$bulk);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{$a->getNom()} - Page Personnalisée</title>
    <link rel="stylesheet" href="animauxPage.css">
</head>
<body>
    <div class="animal-main">
        <h1 class="animal-title">{$a->getNom()}</h1>
        <img class="animal-photo" src="{$a->getImagePath()}" alt="{$a->getNom()}">
        <div class="info-section">
            <h2>Informations Générales</h2>
            <p><strong>Espèce :</strong> {$a->getEspece()}</p>
            <p><strong>Description :</strong> {$a->getDescription()}</p>
            <p><strong>Poids :</strong> {$a->getPoids()} kg</p>
            <p><strong>Sexe :</strong> {$a->getSexe()}</p>
            <p><strong>Continent d'origine :</strong> {$a->getContinentOrigine()}</p>
            <p><strong>Habitat :</strong> {$a->getHabitat()}</p>
        </div>
        <div class="medical-section">
            <h2>Données Médicales</h2>
            <p><strong>Régime :</strong> {$a->getRegime()}</p>
            <p><strong>Dernière visite :</strong> {$a->getDerniereVisite()}</p>
            <p><strong>État général :</strong> {$a->getEtatGeneral()}</p>
            <p><strong>Grammage :</strong> {$a->getGrammage()} kg</p>
            <p><strong>Commentaire :</strong> {$a->getCommentaire()}</p>
        </div>
    </div>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>
HTML;
    }
}
