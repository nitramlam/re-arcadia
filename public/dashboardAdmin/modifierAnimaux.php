<?php
session_start();
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/header.php');
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Animal.php';

// Authentification admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: /connexion/connexion.php");
    exit();
}

// Token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$animalManager = new Animal();

function uploadImage($file): ?string
{
    if (isset($file) && $file['error'] === 0) {
        $uploadDir = __DIR__ . '/../animaux/';
        if (!is_dir($uploadDir))
            mkdir($uploadDir, 0777, true);
        $uploadFile = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            return '/animaux/' . basename($file['name']);
        }
    }
    return null;
}

// Traitement formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF invalide');
    }

    $imagePath = uploadImage($_FILES['image'] ?? []);

    if (isset($_POST['add_animal'])) {
        $animalManager->add($_POST, $imagePath);
    } elseif (isset($_POST['update_animal'])) {
        $animalManager->update((int) $_POST['animal_id'], $_POST, $imagePath);
    } elseif (isset($_POST['delete_animal'])) {
        $animalManager->delete((int) $_POST['animal_id']);
    }
}

$animals = $animalManager->getAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Animaux</title>
    <link rel="stylesheet" href="modifierAnimaux.css">
</head>

<body>
    <main>
        <section class="intro">
            <h2>Nos Animaux</h2>
            <p>Au Zoo Écologique de la Forêt de Brocéliande...</p>
        </section>

        <section class="animal-list">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <h3><?= htmlspecialchars($animal['nom']) ?></h3>
                    <img src="<?= htmlspecialchars($animal['image_path'] ?? '/animaux/default.jpg') ?>"
                        alt="<?= htmlspecialchars($animal['nom']) ?>">
                    <button class="view-report">Afficher le compte rendu</button>
                    <div class="animal-details" style="display: none;">
                        <p><strong>État général:</strong> <?= htmlspecialchars($animal['etat_general'] ?? '') ?></p>
                        <p><strong>Nourriture proposée:</strong> <?= htmlspecialchars($animal['regime'] ?? '') ?></p>
                        <p><strong>Grammage proposé:</strong> <?= htmlspecialchars($animal['grammage'] ?? '') ?> kg</p>
                        <p><strong>Dernière visite:</strong> <?= htmlspecialchars($animal['derniere_visite'] ?? '') ?></p>
                        <p><strong>Commentaire:</strong> <?= htmlspecialchars($animal['commentaire'] ?? '') ?></p>
                    </div>
                    <button class="edit-toggle">✏️</button>
                    <form method="POST" class="animal-form" style="display: none;" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <input type="hidden" name="animal_id" value="<?= (int) $animal['animal_id'] ?>">
                        <label>Nom: <input type="text" name="nom" value="<?= htmlspecialchars($animal['nom']) ?>"
                                required></label>
                        <label>Description: <textarea name="description"
                                required><?= htmlspecialchars($animal['description']) ?></textarea></label>
                        <label>Poids: <input type="number" step="0.01" name="poids"
                                value="<?= htmlspecialchars($animal['poids']) ?>" required></label>
                        <label>Sexe: <input type="text" name="sexe" value="<?= htmlspecialchars($animal['sexe']) ?>"
                                required></label>
                        <label>Continent: <input type="text" name="continent_origine"
                                value="<?= htmlspecialchars($animal['continent_origine']) ?>" required></label>
                        <label>Âge: <input type="number" name="age" value="<?= htmlspecialchars($animal['age']) ?>"
                                required></label>
                        <label>Habitat: <input type="text" name="habitat"
                                value="<?= htmlspecialchars($animal['habitat']) ?>" required></label>
                        <label>Espèce: <input type="text" name="espece" value="<?= htmlspecialchars($animal['espece']) ?>"
                                required></label>
                        <label>Image: <input type="file" name="image" accept="image/*"></label>
                        <button type="submit" name="update_animal">Modifier</button>
                        <button type="submit" name="delete_animal">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>

        <button class="add-animal" onclick="openAddForm()">Ajouter un animal</button>
        <form method="POST" class="add-animal-form" id="add-animal-form" style="display: none;"
            enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <label>Nom: <input type="text" name="nom" required></label>
            <label>Description: <textarea name="description" required></textarea></label>
            <label>Poids: <input type="number" step="0.01" name="poids" required></label>
            <label>Sexe: <input type="text" name="sexe" required></label>
            <label>Continent: <input type="text" name="continent_origine" required></label>
            <label>Âge: <input type="number" name="age" required></label>
            <label>Habitat: <input type="text" name="habitat" required></label>
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