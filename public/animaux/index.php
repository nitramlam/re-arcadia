<?php 
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/AnimalManager.php';
require_once __DIR__ . '/../../classes/HabitatManager.php';

$conn = Database::getConnection();

// Managers
$animalManager = new AnimalManager($conn);
$habitatManager = new HabitatManager($conn);

// Données
$animaux = $animalManager->getAll();
$habitats = $habitatManager->getAll();

// Animaux par habitat
$animalsByHabitat = [];
foreach ($habitats as $habitat) {
    $animalsByHabitat[$habitat->getNom()] = $animalManager->getByHabitat($habitat->getNom());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Animaux</title>
    <link rel="stylesheet" href="animaux.css"> 
</head>
<body>

<main>
    <div class="intro">
        <h1>Nos Animaux</h1>
        <p>Au Zoo Écologique de la Forêt de Brocéliande, nous créons des habitats fidèles aux milieux naturels de nos animaux, assurant leur bien-être et contribuant à la préservation des écosystèmes. Rencontrez nos majestueux lions, éléphants, alligators et bien d'autres résidents fascinants au cœur de notre zoo.</p>
    </div>

    <div class="animaux">
        <?php foreach ($animaux as $animal): ?>
            <div class="animal">
                <h3><?= htmlspecialchars($animal->getNom()) ?></h3>
                <p><?= htmlspecialchars($animal->getEspece()) ?></p>
                <a href="<?= htmlspecialchars($animal->getPageUrl()) ?>">
                    <img src="<?= htmlspecialchars($animal->getImagePath() ?? '/animaux/default.jpg') ?>" alt="<?= htmlspecialchars($animal->getNom()) ?>" style="max-width: 200px;">
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="habitats">
        <h2>Habitats</h2>
        <?php foreach ($habitats as $habitat): ?>
            <div class="habitat">
                <h3><?= htmlspecialchars($habitat->getNom()) ?></h3>
                <div class="animals-in-habitat">
                    <?php foreach ($animalsByHabitat[$habitat->getNom()] as $animal): ?>
                        <div class="animal-in-habitat">
                            <a href="<?= htmlspecialchars($animal->getPageUrl()) ?>">
                                <img src="<?= htmlspecialchars($animal->getImagePath() ?? '/animaux/default.jpg') ?>" alt="<?= htmlspecialchars($animal->getNom()) ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>