<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();
$services = [];

if ($pdo) {
    // Sélection et affichage des données
    $sql = "SELECT * FROM service";
    $stmt = $pdo->query($sql);
    $services = $stmt->fetchAll();
}
?>

<link rel="stylesheet" href="services.css">

<main>
    <div class="services">
        <div class="introServices">
            <h1 class="titreServices">NOS SERVICES</h1>
            <p class="paragrapheServices">
                Découvrez notre zoo de manière enrichissante avec un restaurant proposant des produits locaux et biologiques, des visites guidées interactives gratuites qui vous plongent dans l'univers captivant de nos animaux, et des circuits en petit train électrique respectueux de notre écosystème.
            </p>
            <img src="assets/restaurant-services.png" alt="Zoo Map" class="zoo-map">
        </div>
        <div class="icons-services">
            <img src="assets/icons-services.png" alt="Icons Services">
        </div>
        <div class="opening-hours">
            <h2>HORAIRES D'OUVERTURE</h2>
            <p>Ouvert tous les jours de 10h à 20h</p>
        </div>
        <div class="services-list">
            <?php foreach ($services as $service): ?>
                <div class="service-item">
                    <h3 class="service-titre"><?= htmlspecialchars($service['nom']) ?></h3>
                    <img src="<?= htmlspecialchars($service['icons_path'] ?? '/imageServices/default.jpg') ?>" alt="<?= htmlspecialchars($service['nom']) ?>" class="service-image">
                    <p class="service-description"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?> 