<?php
require_once(__DIR__ . '/../includes/header.php');

// Connexion MongoDB
$manager = new MongoDB\Driver\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");
$query = new MongoDB\Driver\Query([]);
$rows = $manager->executeQuery('arcadia.animal_views', $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Animaux et Compteur de Vues</title>
    <link rel="stylesheet" href="animal_detail.css"> 
</head>
<body>
<main>
    <h1>Liste des Animaux et Compteur de Vues</h1>
    <div class="animaux">
        <?php foreach ($rows as $animal): ?>
            <div class="animal">
                <h3><?= htmlspecialchars($animal->animal_name ?? '') ?></h3>
                <p>Nombre de vues : <?= htmlspecialchars($animal->view_count ?? 0) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>