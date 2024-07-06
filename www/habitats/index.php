<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

if ($pdo) {
    // Sélection et affichage des données
    $sql = "SELECT * FROM HABITAT";
    $stmt = $pdo->query($sql);
    $habitats = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    // Affichage des habitats dans une liste
    foreach ($habitats as $habitat) {
        echo "<article>";
        echo "<h2>" . htmlspecialchars($habitat['nom']) . "</h2>";
        echo "<p>" . htmlspecialchars($habitat['description']) . "</p>";
        echo "<p><strong>Commentaire:</strong> " . htmlspecialchars($habitat['commentaire_habitat']) . "</p>";
        echo "</article>";
    }
    ?>
    <div class="habitats">
        <div class="introHabitats">
            <h1 class="titreHabitats"> NOS HABITATS</h1>
            <p class="paragrapheHabitats">
                Découvrez nos trois habitats distincts : la jungle, les marais et la savane, conçus de manière
                écologique et adaptée. Chaque environnement offre à nos animaux un espace immersif qui respecte leur
                bien-être et leur comportement naturel. Notre engagement envers la préservation de la biodiversité se
                reflète dans chaque détail de ces écosystèmes uniques.

            </p>
            <img src="habitats/panthere-habitats.png" alt="" class="panthere">
        </div>
        <div class="hoverHabitats">
            <div class="savane">
                <img src="habitats/savane-habitats.png" alt="" class="imageSavane">
                <h3 class="titreSavane">
                    LA SAVANE
                </h3>
            </div>
            <div class="marais">
                <img src="habitats/marais-habitats.png" alt="" class="imageMarais">
                <h3 class="titreMarais"> LES MARAIS </h3>
            </div>
            <div class="jungle">
                <img src="habitats/jungle-habitats.png" alt="" class="imageJungle">
                <h3 class="titreJungle">LA JUNGLE</h3>
            </div>
        </div>

    </div>

</body>

</html>