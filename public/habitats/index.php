<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Habitat.php';

$conn = Database::getConnection();
if (!$conn) {
    die("Erreur de connexion à la base de données");
}

$habitatManager = new Habitat($conn);
$habitats = $habitatManager->getAll();

$animalsByHabitat = [];
foreach ($habitats as $habitat) {
    $animalsByHabitat[$habitat['nom']] = $habitatManager->getAnimalsByHabitat($habitat['nom']);
}
?>

<link rel="stylesheet" href="style.css">

<main>
    <div class="habitats">
        <div class="introHabitats">
            <h1 class="titreHabitats">NOS HABITATS</h1>
            <p class="paragrapheHabitats">
                Découvrez nos trois habitats distincts : la jungle, les marais et la savane, conçus de manière
                écologique et adaptée. Chaque environnement offre à nos animaux un espace immersif qui respecte leur
                bien-être et leur comportement naturel. Notre engagement envers la préservation de la biodiversité se
                reflète dans chaque détail de ces écosystèmes uniques.
            </p>
            <img src="assets/panthere-habitats.png" alt="" class="panthere">
        </div>

        <div class="habitats-list">
            <?php foreach ($habitats as $index => $habitat): ?>
                <div class="habitat" id="habitat-<?= $index ?>">
                    <div class="habitat-header" onclick="toggleHabitatDetails(<?= $index ?>)">
                        <img class="habitat-image" src="<?= htmlspecialchars($habitat['image_path']) ?>"
                             alt="<?= htmlspecialchars($habitat['nom']) ?>"/>
                        <div class="habitat-overlay">
                            <span class="habitat-link"><?= htmlspecialchars($habitat['nom']) ?></span>
                        </div>
                    </div>
                    <div id="habitat-details-<?= $index ?>" class="habitat-details" style="display:none;">
                        <h2><?= htmlspecialchars($habitat['nom']) ?></h2>
                        <p><?= htmlspecialchars($habitat['description']) ?></p>
                        <div class="animal-list-header">Animaux dans cet habitat :</div>
                        <div class="animal-list">
                            <?php foreach ($animalsByHabitat[$habitat['nom']] as $animal): ?>
                                <div class="animal-item">
                                    <img src="<?= htmlspecialchars($animal['image_path'] ?: 'default-animal.jpg') ?>"
                                         alt="<?= htmlspecialchars($animal['nom']) ?>" class="animal-image"/>
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










