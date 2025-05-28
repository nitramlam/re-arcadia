<?php 
require_once (__DIR__ . '/../includes/header.php');
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/AnimalManager.php';
require_once __DIR__ . '/../../classes/Habitat.php';

// Connexion à la base de données
$conn = Database::getConnection();

// Gestionnaire des animaux
$animalManager = new AnimalManager($conn);

// Gestionnaire des habitats
$habitatManager = new Habitat($conn);

// Récupération de tous les animaux et des habitats
$animaux = $animalManager->getAll();
$habitats = $habitatManager->getAll();

// Organisation des animaux par habitat
$animalsByHabitat = [];
foreach ($habitats as $habitat) {
    $animalsByHabitat[$habitat['nom']] = $animalManager->getByHabitat($habitat['nom']);
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
                <h3><?= htmlspecialchars($habitat['nom']) ?></h3>
                <div class="animals-in-habitat">
                    <?php foreach ($animalsByHabitat[$habitat['nom']] as $animal): ?>
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