<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/header.php');
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/AnimalManager.php';
require_once __DIR__ . '/../../classes/HabitatManager.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: /connexion/connexion.php");
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$conn = Database::getConnection();
$animalManager = new AnimalManager($conn);
$habitatManager = new HabitatManager($conn);
$habitats = $habitatManager->getAll();

function uploadImage($file): ?string {
    if (isset($file) && $file['error'] === 0) {
        $uploadDir = __DIR__ . '/../animaux/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $uploadFile = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            return '/animaux/' . basename($file['name']);
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF invalide');
    }

    $imagePath = uploadImage($_FILES['image'] ?? []);

    // Convertit le nom d'habitat en ID
    $habitatNom = $_POST['habitat'] ?? '';
    $habitatId = null;
    foreach ($habitats as $h) {
        if ($h->getNom() === $habitatNom) {
            $habitatId = $h->getId();
            break;
        }
    }

    // Préparation des données propres à envoyer
    $data = [
        'nom' => $_POST['nom'] ?? '',
        'description' => $_POST['description'] ?? '',
        'poids' => $_POST['poids'] ?? '',
        'sexe' => $_POST['sexe'] ?? '',
        'continent_origine' => $_POST['continent_origine'] ?? '',
        'age' => $_POST['age'] ?? '',
        'habitat_id' => $habitatId,
        'espece' => $_POST['espece'] ?? '',
    ];

    if (isset($_POST['add_animal'])) {
        $animalManager->add($data, $imagePath);
    } elseif (isset($_POST['update_animal'])) {
        $animalManager->update((int) $_POST['animal_id'], $data, $imagePath);
    } elseif (isset($_POST['delete_animal'])) {
        $animalManager->delete((int) $_POST['animal_id']);
    }
}

$animals = $animalManager->getAll();
?>

<!-- Le reste du HTML reste inchangé -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Animaux</title>
    <link rel="stylesheet" href="modifierAnimaux.css">
</head>
<body>
<main>

    <section class="animal-list">
        <?php foreach ($animals as $animal): ?>
            <div class="animal-card">
                <h3><?= htmlspecialchars($animal->getNom()) ?></h3>
                <img src="<?= htmlspecialchars($animal->getImagePath() ?? '/animaux/default.jpg') ?>"
                     alt="<?= htmlspecialchars($animal->getNom()) ?>">
                <button class="view-report">Afficher le compte rendu</button>
                <div class="animal-details" style="display: none;">
                    <p><strong>État général:</strong> <?= htmlspecialchars($animal->getEtatGeneral() ?? '') ?></p>
                    <p><strong>Nourriture proposée:</strong> <?= htmlspecialchars($animal->getRegime() ?? '') ?></p>
                    <p><strong>Grammage proposé:</strong> <?= htmlspecialchars($animal->getGrammage() ?? '') ?> kg</p>
                    <p><strong>Dernière visite:</strong> <?= htmlspecialchars($animal->getDerniereVisite() ?? '') ?></p>
                    <p><strong>Commentaire:</strong> <?= htmlspecialchars($animal->getCommentaire() ?? '') ?></p>
                </div>
                <button class="edit-toggle">✏️</button>
                <form method="POST" class="animal-form" style="display: none;" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <input type="hidden" name="animal_id" value="<?= $animal->getId() ?>">
                    <label>Nom: <input type="text" name="nom" value="<?= htmlspecialchars($animal->getNom()) ?>" required></label>
                    <label>Description: <textarea name="description" required><?= htmlspecialchars($animal->getDescription()) ?></textarea></label>
                    <label>Poids: <input type="number" step="0.01" name="poids" value="<?= htmlspecialchars($animal->getPoids()) ?>" required></label>
                    <label>Sexe: <input type="text" name="sexe" value="<?= htmlspecialchars($animal->getSexe()) ?>" required></label>
                    <label>Continent: <input type="text" name="continent_origine" value="<?= htmlspecialchars($animal->getContinentOrigine()) ?>" required></label>
                    <label>Âge: <input type="number" name="age" value="<?= htmlspecialchars($animal->getAge()) ?>" required></label>
                    <label>Habitat: 
                        <select name="habitat" required>
                            <?php foreach ($habitats as $habitat): ?>
                                <option value="<?= htmlspecialchars($habitat->getNom()) ?>" <?= $habitat->getId() === $animal->getHabitatId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($habitat->getNom()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>Espèce: <input type="text" name="espece" value="<?= htmlspecialchars($animal->getEspece()) ?>" required></label>
                    <label>Image: <input type="file" name="image" accept="image/*"></label>
                    <button type="submit" name="update_animal">Modifier</button>
                    <button type="submit" name="delete_animal">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </section>

    <button class="add-animal" onclick="openAddForm()">Ajouter un animal</button>
    <form method="POST" class="add-animal-form" id="add-animal-form" style="display: none;" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <label>Nom: <input type="text" name="nom" required></label>
        <label>Description: <textarea name="description" required></textarea></label>
        <label>Poids: <input type="number" step="0.01" name="poids" required></label>
        <label>Sexe: <input type="text" name="sexe" required></label>
        <label>Continent: <input type="text" name="continent_origine" required></label>
        <label>Âge: <input type="number" name="age" required></label>
        <label>Habitat:
            <select name="habitat" required>
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?= htmlspecialchars($habitat->getNom()) ?>"><?= htmlspecialchars($habitat->getNom()) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Espèce: <input type="text" name="espece" required></label>
        <label>Image: <input type="file" name="image" accept="image/*"></label>
        <button type="submit" name="add_animal">Ajouter</button>
        <button type="button" onclick="closeAddForm()">Annuler</button>
    </form>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.view-report').forEach(button => {
            button.addEventListener('click', () => {
                const details = button.nextElementSibling;
                details.style.display = details.style.display === 'block' ? 'none' : 'block';
            });
        });
        document.querySelectorAll('.edit-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const form = button.nextElementSibling;
                form.style.display = form.style.display === 'block' ? 'none' : 'block';
            });
        });
    });
    function openAddForm() {
        document.getElementById('add-animal-form').style.display = 'block';
    }
    function closeAddForm() {
        document.getElementById('add-animal-form').style.display = 'none';
    }
</script>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>