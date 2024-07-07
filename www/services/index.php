<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

if ($pdo) {
    // Sélection et affichage des données
    $sql = "SELECT * FROM service";
    $stmt = $pdo->query($sql);
    $services = $stmt->fetchAll();
}
?>

<?php require_once (__DIR__ . '/../includes/header.php'); ?>

<link rel="stylesheet" href="style.css">

<main>
    <div class="services">
        <div class="introServices">
            <h1 class="titreServices"> NOS SERVICES</h1>
            <p class="paragrapheServices">
            Découvrez notre zoo de manière enrichissante avec un restaurant proposant des produits locaux et biologiques, des visites guidées interactives gratuites qui vous plongent dans l'univers captivant de nos animaux. et des circuits en petit train électrique respectueux de notre écosystème.
            </p>
            <img src="assets/restaurant-services.png" alt="" class="restaurant">
        </div>
        <div class="icons-services">
            <img src="assets/icons-services.png" alt="">
        </div>

        <div class="row m-0">
            <?php
            // Affichage des habitats dans une liste
            foreach ($services as $service) {
                echo '<div class="col-md-4 p-0">';
                echo '<h3 class="service-titre">' . htmlspecialchars($service['nom']) . "</h3>";
                echo '<p class="service.description">' .
                htmlspecialchars($service['description']) . "</p>";
                

                echo "</div>";
            }
            ?>
        </div>
    </div>
</main>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>