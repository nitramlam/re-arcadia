<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>rat - Page Personnalisée</title>
    <link rel='stylesheet' href='animauxPage.css'>
</head>
<body>
    <div class="animal-main">
        <h1 class="animal-title">rat</h1>
        <img class="animal-photo" src="/animaux/iconGuide-services.png" alt="rat">
        <div class="info-section">
            <h2>Informations Générales</h2>
            <div class="general-info">
                <p class="species-info"><strong>Espèce:</strong> 0</p>
                <p class="description-info"><strong>Description:</strong> rat</p>
                <p class="weight-info"><strong>Poids:</strong> 45.00 kg</p>
                <p class="sex-info"><strong>Sexe:</strong> F</p>
                <p class="origin-continent-info"><strong>Continent d'origine:</strong> etu</p>
                <p class="habitat-info"><strong>Habitat:</strong> jungle</p>
            </div>
        </div>

        <div class="medical-section">
            <h2>Données Médicales</h2>
            <div class="medical-info">
                <p class="diet-info"><strong>Régime:</strong> bien</p>
                <p class="last-visit-info"><strong>Dernière visite:</strong> 2025-06-07</p>
                <p class="general-state-info"><strong>État général:</strong> bien</p>
                <p class="weight-info"><strong>Grammage:</strong> 460.00 kg</p>
                <p class="comment-info"><strong>Commentaire:</strong> 0</p>
            </div>
        </div>
    </div>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>