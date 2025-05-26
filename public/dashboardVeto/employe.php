<?php
session_start();
require_once __DIR__ . '/../../classes/SessionManager.php';
SessionManager::requireAuth();
require_once(__DIR__ . '/../includes/header.php');
require_once __DIR__ . '/../../classes/Database.php';
$conn = Database::getConnection(); // Inclure le fichier de configuration de la base de données

// Vérification du rôle de l'utilisateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'veterinaire') {
    header("Location: /connexion/connexion.php");
    exit();
}


// Récupérer les données des animaux
$animalQuery = $conn->query("SELECT * FROM animal");
$animals = $animalQuery->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page Vétérinaire - Lecture Seule</title>
    <link rel="stylesheet" href="employe.css">
</head>

<body>
    <main>
        <section class="intro">
            <h2>Suivi des Informations Modifiées par les Employés</h2>

        </section>
        <section class="animal-list">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <h3><?= htmlspecialchars($animal['nom'] ?? ''); ?></h3>
                    <div class="animal-details">
                        <p><strong>Date et Heure de Passage:</strong>
                            <?= htmlspecialchars($animal['date_heure_passage_employe'] ?? ''); ?></p>
                        <p><strong>Grammage Donné:</strong> <?= htmlspecialchars($animal['grammage_donne'] ?? ''); ?> kg</p>
                        <p><strong>Nourriture Donnée:</strong> <?= htmlspecialchars($animal['nourriture_donnee'] ?? ''); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <?php require_once(__DIR__ . '/../includes/footer.php'); ?>
</body>

</html>