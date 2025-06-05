<?php
require_once (__DIR__ . '/../includes/header.php');
$manager = new MongoDB\Driver\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(['animal_id' => "29"], ['$inc' => ['view_count' => 1]]);
$manager->executeBulkWrite('arcadia.animal_views', $bulk);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ferf - Page Personnalisée</title>
    <link rel="stylesheet" href="animauxPage.css">
</head>
<body>
    <div class="animal-main">
        <h1 class="animal-title">ferf</h1>
        <img class="animal-photo" src="/animaux/iconGuide-services.png" alt="ferf">
        <div class="info-section">
            <h2>Informations Générales</h2>
            <p><strong>Espèce :</strong> ergre</p>
            <p><strong>Description :</strong> reg</p>
            <p><strong>Poids :</strong> 45 kg</p>
            <p><strong>Sexe :</strong> f</p>
            <p><strong>Continent d'origine :</strong> fr</p>
            <p><strong>Habitat ID :</strong> 3</p>
        </div>
        <div class="medical-section">
            <h2>Données Médicales</h2>
            <p><strong>Régime :</strong> </p>
            <p><strong>Dernière visite :</strong> </p>
            <p><strong>État général :</strong> </p>
            <p><strong>Grammage :</strong>  kg</p>
            <p><strong>Commentaire :</strong> </p>
        </div>
    </div>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>