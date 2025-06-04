<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/HabitatManager.php';

$conn = Database::getConnection();
if (!$conn) {
    die("Erreur de connexion à la base de données");
}

$habitatManager = new HabitatManager($conn);
$habitats = $habitatManager->getAll();

$animalsByHabitat = [];
foreach ($habitats as $habitat) {
    $animalsByHabitat[$habitat->getId()] = $habitatManager->getAnimalsByHabitat($habitat->getId());
}
?>

<link rel="stylesheet" href="style.css">

<main>
    <div class="habitats">
        <div class="introHabitats">
            <h1 class="titreHabitats">NOS HABITATS</h1>
            <p class="paragrapheHabitats">
                Découvrez nos trois habitats distincts : la jungle, les marais et la savane, conçus de manière
                écologique et adaptée...
            </p>
            <img src="assets/panthere-habitats.png" alt="" class="panthere">
        </div>

        <div class="habitats-list">
            <?php foreach ($habitats as $index => $habitat): ?>
                <div class="habitat" id="habitat-<?= $index ?>">
                    <div class="habitat-header" onclick="toggleHabitatDetails(<?= $index ?>)">
                        <img class="habitat-image" src="<?= htmlspecialchars($habitat->getImagePath()) ?>"
                             alt="<?= htmlspecialchars($habitat->getNom()) ?>"/>
                        <div class="habitat-overlay">
                            <span class="habitat-link"><?= htmlspecialchars($habitat->getNom()) ?></span>
                        </div>
                    </div>
                    <div id="habitat-details-<?= $index ?>" class="habitat-details" style="display:none;">
                        <h2><?= htmlspecialchars($habitat->getNom()) ?></h2>
                        <p><?= htmlspecialchars($habitat->getDescription()) ?></p>
                        <div class="animal-list-header">Animaux dans cet habitat :</div>
                        <div class="animal-list">
                            <?php foreach ($animalsByHabitat[$habitat->getId()] as $animal): ?>
                                <div class="animal-item">
                                    <img src="<?= htmlspecialchars($animal->getImagePath() ?? 'default-animal.jpg') ?>"
                                         alt="<?= htmlspecialchars($animal->getNom()) ?>" class="animal-image"/>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script>
function toggleHabitatDetails(index) {
    const habitat = document.getElementById(`habitat-${index}`);
    const details = document.getElementById(`habitat-details-${index}`);
    if (details.style.display === 'none') {
        details.style.display = 'block';
        habitat.classList.add('expanded');
    } else {
        details.style.display = 'none';
        habitat.classList.remove('expanded');
    }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>