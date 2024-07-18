<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

if ($pdo) {
    // Sélection et affichage des données des habitats
    $sql = "SELECT * FROM HABITAT";
    $stmt = $pdo->query($sql);
    $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Récupérer les animaux par habitat
    $animalsByHabitat = [];
    foreach ($habitats as $habitat) {
        $stmt = $pdo->prepare("SELECT * FROM ANIMAL WHERE habitat = ?");
        $stmt->execute([$habitat['nom']]);
        $animalsByHabitat[$habitat['nom']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
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
            <?php
            // Affichage des habitats dans une liste
            foreach ($habitats as $habitat) {
                echo '<div class="habitat" onclick="showHabitatDetails(' . htmlspecialchars(json_encode($habitat)) . ', ' . htmlspecialchars(json_encode($animalsByHabitat[$habitat['nom']])) . ')">';
                echo '<img class="habitat-image" src="' . $habitat['image_path'] . '" alt="' . htmlspecialchars($habitat['nom']) . '"/>';
                echo '<div class="habitat-overlay">';
                echo '<span class="habitat-link">' . htmlspecialchars($habitat['nom']) . "</span>";
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div id="habitat-details" class="habitat-details" style="display:none;">
        <span class="close-btn" onclick="closeHabitatDetails()">&times;</span>
        <h2 id="habitat-name"></h2>
        <p id="habitat-description"></p>
        <div id="habitat-animals">
            <h3>Animaux dans cet habitat :</h3>
            <div id="animal-list" class="animal-list"></div>
        </div>
    </div>
</main>

<script>
function showHabitatDetails(habitat, animals) {
    document.getElementById('habitat-name').textContent = habitat.nom;
    document.getElementById('habitat-description').textContent = habitat.description;

    var animalList = document.getElementById('animal-list');
    animalList.innerHTML = ''; // Clear the previous list
    animals.forEach(function(animal) {
        var div = document.createElement('div');
        div.className = 'animal-item';
        var img = document.createElement('img');
        img.src = animal.image_path || 'default-animal.jpg'; // Chemin de l'image de l'animal
        img.alt = animal.nom;
        img.className = 'animal-image';
        div.appendChild(img);
        animalList.appendChild(div);
    });

    document.getElementById('habitat-details').style.display = 'block';
    document.getElementById('habitat-details').classList.add('show');
}

function closeHabitatDetails() {
    document.getElementById('habitat-details').classList.remove('show');
    setTimeout(() => {
        document.getElementById('habitat-details').style.display = 'none';
    }, 300);
}
</script>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>