<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

// Requête SQL pour sélectionner tous les animaux
if ($pdo) {
    $sql = "SELECT * FROM animal";
    $stmt = $pdo->query($sql);
    $animaux = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Animaux</title>
    <link rel="stylesheet" href="animaux.css"> <!-- Remplacez par le chemin correct de votre fichier CSS -->
</head>
<body>

<main>
    <div class="intro">
        <h1>Nos Animaux</h1>
        <p>Au Zoo Écologique de la Forêt de Brocéliande, nous créons des habitats fidèles aux milieux naturels de nos animaux, assurant ainsi leur bien-être et contribuant à la préservation des écosystèmes. Rencontrez nos majestueux lions, éléphants, alligators et bien d'autres résidents fascinants au cœur de notre zoo.</p>
    </div>
    <div class="animaux">
        <?php foreach ($animaux as $animal): ?>
            <div class="animal">
                <h3><?= htmlspecialchars($animal['nom']) ?></h3>
                <p><?= htmlspecialchars($animal['espece']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>

</body>
</html>