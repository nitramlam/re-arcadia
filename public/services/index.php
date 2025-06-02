<?php
require_once(__DIR__ . '/../includes/header.php');
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/ServiceManager.php';

$conn = Database::getConnection();
if (!$conn) {
    die("Erreur de connexion à la base de données");
}

$serviceManager = new ServiceManager($conn);
$services = $serviceManager->getAll();
$horaires = $serviceManager->getHoraires();
?>

<link rel="stylesheet" href="services.css">

<main>
    <div class="services">
        <div class="introServices">
            <h1 class="titreServices">NOS SERVICES</h1>
            <p class="paragrapheServices">
                Découvrez notre zoo de manière enrichissante avec un restaurant proposant des produits locaux et
                biologiques, des visites guidées interactives gratuites qui vous plongent dans l'univers captivant de
                nos animaux, et des circuits en petit train électrique respectueux de notre écosystème.
            </p>
            <img src="assets/restaurant-services.png" alt="Zoo Map" class="zoo-map">
        </div>

        <div class="icons-services">
            <img src="assets/icons-services.png" alt="Icons Services">
        </div>

        <div class="opening-hours">
            <h2>HORAIRES D'OUVERTURE</h2>
            <?php if ($horaires): ?>
                <p>Ouvert tous les jours de <?= htmlspecialchars($horaires['ouverture']) ?> à
                    <?= htmlspecialchars($horaires['fermeture']) ?></p>
            <?php else: ?>
                <p>Horaires non disponibles</p>
            <?php endif; ?>
        </div>

        <div class="services-list">
            <?php foreach ($services as $service): ?>
                <div class="service-item">
                    <h3 class="service-titre"><?= htmlspecialchars($service->getNom()) ?></h3>
                    <img src="<?= htmlspecialchars($service->getIconsPath() ?? '/imageServices/default.jpg') ?>"
                         alt="<?= htmlspecialchars($service->getNom()) ?>" class="service-image">
                    <p class="service-description"><?= nl2br(htmlspecialchars($service->getDescription())) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>