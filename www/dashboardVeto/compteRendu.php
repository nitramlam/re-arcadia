<?php 
require_once(__DIR__ . '/../includes/auth.php'); 
require_once(__DIR__ . '/../includes/header.php'); 
require '../config/db.php';
 

$pdo = getDatabaseConnection();

// Fonction pour créer une page personnalisée pour chaque animal
function createAnimalPage($animalId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM animal WHERE animal_id = ?");
    $stmt->execute([$animalId]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        throw new Exception("Animal not found");
    }

    $uploadDir = __DIR__ . '/../animaux_pages/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $pageContent = <<<PHP
<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>{$animal['nom']} - Page Personnalisée</title>
    <link rel='stylesheet' href='animauxPage.css'>
</head>
<body>
    <div class="animal-main">
        <h1 class="animal-title">{$animal['nom']}</h1>
        <img class="animal-photo" src="{$animal['image_path']}" alt="{$animal['nom']}">
        <div class="info-section">
            <h2>Informations Générales</h2>
            <div class="general-info">
                <p class="species-info"><strong>Espèce:</strong> {$animal['espece']}</p>
                <p class="description-info"><strong>Description:</strong> {$animal['description']}</p>
                <p class="weight-info"><strong>Poids:</strong> {$animal['poids']} kg</p>
                <p class="sex-info"><strong>Sexe:</strong> {$animal['sexe']}</p>
                <p class="origin-continent-info"><strong>Continent d'origine:</strong> {$animal['continent_origine']}</p>
                <p class="habitat-info"><strong>Habitat:</strong> {$animal['habitat']}</p>
            </div>
        </div>

        <div class="medical-section">
            <h2>Données Médicales</h2>
            <div class="medical-info">
                <p class="diet-info"><strong>Régime:</strong> {$animal['regime']}</p>
                <p class="last-visit-info"><strong>Dernière visite:</strong> {$animal['derniere_visite']}</p>
                <p class="general-state-info"><strong>État général:</strong> {$animal['etat_general']}</p>
                <p class="weight-info"><strong>Grammage:</strong> {$animal['grammage']} kg</p>
                <p class="comment-info"><strong>Commentaire:</strong> {$animal['commentaire']}</p>
            </div>
        </div>
    </div>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>
PHP;

    $pagePath = __DIR__ . "/../animaux_pages/animal_{$animalId}.php";
    file_put_contents($pagePath, $pageContent);

    return "/animaux_pages/animal_{$animalId}.php";
}

// Gestion des soumissions des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_animal'])) {
        // Mettre à jour les informations vétérinaires de l'animal
        $animal_id = $_POST['animal_id'];
        $etat_general = $_POST['etat_general'];
        $regime = $_POST['regime'];
        $grammage = $_POST['grammage'];
        $derniere_visite = $_POST['derniere_visite'];
        $commentaire = $_POST['commentaire'];
        $stmt = $pdo->prepare("UPDATE animal SET etat_general = ?, regime = ?, grammage = ?, derniere_visite = ?, commentaire = ? WHERE animal_id = ?");
        $stmt->execute([$etat_general, $regime, $grammage, $derniere_visite, $commentaire, $animal_id]);

        // Recréer la page personnalisée
        createAnimalPage($animal_id);
    }
}

// Récupérer les données des animaux
$animalQuery = $pdo->query("SELECT * FROM animal");
$animals = $animalQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Vétérinaire</title>
    <link rel="stylesheet" href="compteRendu.css">
</head>
<body>
    <main>
        <section class="intro">
            <h2>Suivi Vétérinaire des Animaux</h2>
            <p>Sur cette page, les vétérinaires peuvent mettre à jour l'état général des animaux, leur régime alimentaire, le grammage de nourriture, la date de visite et ajouter des commentaires.</p>
        </section>
        <section class="animal-list">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <h3><?php echo htmlspecialchars($animal['nom'] ?? ''); ?></h3>
                    <button class="edit-toggle">✏️</button>
                    <form method="POST" class="animal-form" style="display: none;">
                        <input type="hidden" name="animal_id" value="<?php echo htmlspecialchars($animal['animal_id'] ?? ''); ?>">
                        <label>État général: <input type="text" name="etat_general" value="<?php echo htmlspecialchars($animal['etat_general'] ?? ''); ?>" required></label>
                        <label>Nourriture proposée: <input type="text" name="regime" value="<?php echo htmlspecialchars($animal['regime'] ?? ''); ?>" required></label>
                        <label>Grammage proposé: <input type="number" step="0.01" name="grammage" value="<?php echo htmlspecialchars($animal['grammage'] ?? ''); ?>" required></label>
                        <label>Date de visite: <input type="date" name="derniere_visite" value="<?php echo htmlspecialchars($animal['derniere_visite'] ?? ''); ?>" required></label>
                        <label>Commentaire: <textarea name="commentaire"><?php echo htmlspecialchars($animal['commentaire'] ?? ''); ?></textarea></label>
                        <button type="submit" name="update_animal" class="edit-btn">Mettre à jour</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editToggles = document.querySelectorAll('.edit-toggle');
            editToggles.forEach(button => {
                button.addEventListener('click', () => {
                    const form = button.nextElementSibling;
                    form.style.display = form.style.display === 'block' ? 'none' : 'block';
                });
            });
        });
    </script>
</body>
</html>