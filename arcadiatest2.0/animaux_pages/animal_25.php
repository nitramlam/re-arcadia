<?php
require_once (__DIR__ . '/../includes/header.php');

// Connexion à MongoDB pour incrémenter le compteur de vues
$manager = new MongoDB\Driver\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");

// Incrémentation du view_count dans MongoDB
$bulk = new MongoDB\Driver\BulkWrite;
$filter = ['animal_id' => "25"];
$update = [
    '$inc' => ['view_count' => 1]  // Incrémenter de 1 à chaque accès
];
$bulk->update($filter, $update);
$manager->executeBulkWrite('arcadia.animal_views', $bulk);

?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>ergt - Page Personnalisée</title>
    <link rel='stylesheet' href='animauxPage.css'>
</head>
<body>
    <div class="animal-main">
        <h1 class="animal-title">ergt</h1>
        <img class="animal-photo" src="/animaux/Capture d’écran 2025-05-21 à 15.15.33.png" alt="ergt">
        <div class="info-section">
            <h2>Informations Générales</h2>
            <div class="general-info">
                <p class="species-info"><strong>Espèce:</strong> erze</p>
                <p class="description-info"><strong>Description:</strong> getrger</p>
                <p class="weight-info"><strong>Poids:</strong> 45.00 kg</p>
                <p class="sex-info"><strong>Sexe:</strong> F</p>
                <p class="origin-continent-info"><strong>Continent d'origine:</strong> 0</p>
                <p class="habitat-info"><strong>Habitat:</strong> REGERger</p>
            </div>
        </div>

        <div class="medical-section">
            <h2>Données Médicales</h2>
            <div class="medical-info">
                <p class="diet-info"><strong>Régime:</strong> </p>
                <p class="last-visit-info"><strong>Dernière visite:</strong> </p>
                <p class="general-state-info"><strong>État général:</strong> </p>
                <p class="weight-info"><strong>Grammage:</strong>  kg</p>
                <p class="comment-info"><strong>Commentaire:</strong> </p>
            </div>
        </div>
    </div>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>