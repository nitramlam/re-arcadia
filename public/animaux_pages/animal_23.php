<?php
require_once (__DIR__ . '/../includes/header.php');
$manager = new MongoDB\Driver\Manager("mongodb+srv://martinlamalle:456123Fx37!@arcadia.t7ei6.mongodb.net/?retryWrites=true&w=majority&appName=arcadia");
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(['animal_id' => "23"], ['$inc' => ['view_count' => 1]]);
$manager->executeBulkWrite('arcadia.animal_views', $bulk);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Narsil - Page Personnalisée</title>
    <link rel="stylesheet" href="animauxPage.css">
</head>
<body>
    <div class="animal-main">
        <h1 class="animal-title">Narsil</h1>
        <img class="animal-photo" src="/animaux/heron1.png" alt="Narsil">
        <div class="info-section">
            <h2>Informations Générales</h2>
            <p><strong>Espèce :</strong> 0</p>
            <p><strong>Description :</strong> Le héron cendré des Everglades, connu sous son nom scientifique Ardea herodias, est une espèce emblématique des marais et des zones humides de Floride. Reconnaissable à son plumage cendré, à son long cou et à ses pattes jaunes, il se nourrit principalement de poissons, de grenouilles et d’insectes qu’il chasse avec agilité dans les eaux peu profondes. Ce héron joue un rôle crucial dans l’écosystème en régulant les populations de poissons et en contribuant à la biodiversité des habitats aquatiques.</p>
            <p><strong>Poids :</strong> 10 kg</p>
            <p><strong>Sexe :</strong> M</p>
            <p><strong>Continent d'origine :</strong> Amérique du Nord</p>
            <p><strong>Habitat ID :</strong> 3</p>
        </div>
        <div class="medical-section">
            <h2>Données Médicales</h2>
            <p><strong>Régime :</strong> poisson</p>
            <p><strong>Dernière visite :</strong> 2024-07-19</p>
            <p><strong>État général :</strong> en bonne santé</p>
            <p><strong>Grammage :</strong> 4 kg</p>
            <p><strong>Commentaire :</strong> RAS</p>
        </div>
    </div>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>