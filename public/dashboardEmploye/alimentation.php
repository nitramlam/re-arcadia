<?php
session_start();

require_once __DIR__ . '/../../classes/SessionManager.php';
SessionManager::requireAuth();

require_once(__DIR__ . '/../includes/header.php');
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/AnimalManager.php';

// Vérification du rôle employé
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employe') {
    header("Location: /connexion/connexion.php");
    exit();
}

// CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$animalManager = new AnimalManager(Database::getConnection());

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Échec de la validation CSRF.');
    }

    if (isset($_POST['update_animal'])) {
        $animalManager->updatePassageEmploye(
            (int) $_POST['animal_id'],
            $_POST['date_heure_passage_employe'],
            (float) $_POST['grammage_donne'],
            $_POST['nourriture_donnee']
        );
    }
}

$animals = $animalManager->getAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Employé</title>
    <link rel="stylesheet" href="alim.css">
</head>
<body>
<main>
    <section class="intro">
        <h2>Gestion des Passages des Employés</h2>
    </section>

    <section class="animal-list">
        <?php foreach ($animals as $animal): ?>
            <div class="animal-card">
                <h3><?= htmlspecialchars($animal->getNom()) ?></h3>
                <button class="edit-toggle">✏️</button>
                <form method="POST" class="animal-form" style="display: none;">
                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="animal_id" value="<?= $animal->getId() ?>">

                    <label>Date et Heure de Passage:
                        <input type="datetime-local" name="date_heure_passage_employe"
                               value="<?= htmlspecialchars($animal->getDatePassageEmploye() ?? '') ?>" required>
                    </label>

                    <label>Grammage Donné:
                        <input type="number" step="0.01" name="grammage_donne"
                               value="<?= htmlspecialchars($animal->getGrammageDonne() ?? '') ?>" required>
                    </label>

                    <label>Nourriture Donnée:
                        <input type="text" name="nourriture_donnee"
                               value="<?= htmlspecialchars($animal->getNourritureDonnee() ?? '') ?>" required>
                    </label>

                    <button type="submit" name="update_animal" class="edit-btn">Mettre à jour</button>
                </form>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const form = button.nextElementSibling;
                form.style.display = form.style.display === 'block' ? 'none' : 'block';
            });
        });
    });
</script>
</body>
</html>