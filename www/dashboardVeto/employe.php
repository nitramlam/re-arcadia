<?php 
require_once(__DIR__ . '/../includes/auth.php'); 
require_once(__DIR__ . '/../includes/header.php'); 
require '../config/db.php';


$pdo = getDatabaseConnection();

// Récupérer les données des animaux
$animalQuery = $pdo->query("SELECT * FROM animal");
$animals = $animalQuery->fetchAll(PDO::FETCH_ASSOC);
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
            <p>Cette page affiche en lecture seule les informations modifiées par les employés pour chaque animal.</p>
        </section>
        <section class="animal-list">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <h3><?php echo htmlspecialchars($animal['nom'] ?? ''); ?></h3>
                    <div class="animal-details">
                        <p><strong>Date et Heure de Passage:</strong> <?php echo htmlspecialchars($animal['date_heure_passage_employe'] ?? ''); ?></p>
                        <p><strong>Grammage Donné:</strong> <?php echo htmlspecialchars($animal['grammage_donne'] ?? ''); ?> kg</p>
                        <p><strong>Nourriture Donnée:</strong> <?php echo htmlspecialchars($animal['nourriture_donnee'] ?? ''); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>