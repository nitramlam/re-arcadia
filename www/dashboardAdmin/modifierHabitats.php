<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<?php
require '../config/db.php';

$pdo = getDatabaseConnection();

// Suppression d'un habitat
if (isset($_POST['delete_habitat'])) {
    $habitat_id = $_POST['habitat_id'];
    $stmt = $pdo->prepare("DELETE FROM HABITAT WHERE habitat_id = :habitat_id");
    $stmt->execute([':habitat_id' => $habitat_id]);
}

// Ajout d'un nouvel habitat
if (isset($_POST['add_habitat'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $commentaire_habitat = $_POST['commentaire_habitat'];
    $stmt = $pdo->prepare("INSERT INTO HABITAT (nom, description, commentaire_habitat) VALUES (:nom, :description, :commentaire_habitat)");
    $stmt->execute([':nom' => $nom, ':description' => $description, ':commentaire_habitat' => $commentaire_habitat]);
}

// Modification d'un habitat
if (isset($_POST['edit_habitat'])) {
    $habitat_id = $_POST['habitat_id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $commentaire_habitat = $_POST['commentaire_habitat'];
    $stmt = $pdo->prepare("UPDATE HABITAT SET nom = :nom, description = :description, commentaire_habitat = :commentaire_habitat WHERE habitat_id = :habitat_id");
    $stmt->execute([':nom' => $nom, ':description' => $description, ':commentaire_habitat' => $commentaire_habitat, ':habitat_id' => $habitat_id]);
}

// Sélection et affichage des données des habitats
$sql = "SELECT * FROM HABITAT";
$stmt = $pdo->query($sql);
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sélection et affichage des données des animaux
$sql_animals = "SELECT * FROM animal";
$stmt_animals = $pdo->query($sql_animals);
$animals = $stmt_animals->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="modifierHabitats.css">

<main>
    <div class="habitats">
        <div class="introHabitats">
            <h1 class="titreHabitats">MODIFIER LES HABITATS</h1>
        </div>

        <div class="row m-0">
            <?php
            // Affichage des habitats et des animaux
            if (!empty($habitats)) {
                foreach ($habitats as $habitat) {
                    echo '<div class="col-md-12 p-0 habitat-card">';
                    echo '<h2>' . htmlspecialchars($habitat['nom']) . '</h2>';
                    echo '<p>' . htmlspecialchars($habitat['description']) . '</p>';
                    echo '<p><em>' . htmlspecialchars($habitat['commentaire_habitat']) . '</em></p>';

                    // Affichage des animaux pour chaque habitat
                    $hasAnimals = false;
                    echo '<ul>';
                    foreach ($animals as $animal) {
                        if ($animal['habitat'] === $habitat['nom']) {
                            $hasAnimals = true;
                            echo '<li>';
                            echo '<strong>' . htmlspecialchars($animal['nom']) . '</strong> (' . htmlspecialchars($animal['espece']) . ')';
                            echo '<p><em>' . htmlspecialchars($animal['etat_general']) . '</em></p>';
                            echo '</li>';
                        }
                    }
                    echo '</ul>';
                    if (!$hasAnimals) {
                        echo '<p>Aucun animal dans cet habitat.</p>';
                    }

                    // Boutons de modification et de suppression
                    echo '<button class="edit-btn" onclick="openEditForm(' . htmlspecialchars($habitat['habitat_id']) . ')">Modifier</button>';
                    echo '<form method="post" class="delete-form">';
                    echo '<input type="hidden" name="habitat_id" value="' . htmlspecialchars($habitat['habitat_id']) . '">';
                    echo '<button type="submit" name="delete_habitat">Supprimer</button>';
                    echo '</form>';

                    echo "</div>";
                }
            } else {
                echo '<p>Aucun habitat disponible.</p>';
            }
            ?>

            <!-- Formulaire d'ajout d'un nouvel habitat -->
            <div class="col-md-12 p-0 add-habitat">
                <h2>Ajouter un nouvel habitat</h2>
                <button class="add-btn" onclick="openAddForm()">Ajouter un habitat</button>
                <form method="post" class="add-form" id="add-form" style="display: none;">
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" required>
                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea>
                    <label for="commentaire_habitat">Commentaire:</label>
                    <textarea name="commentaire_habitat"></textarea>
                    <button type="submit" name="add_habitat">Ajouter</button>
                    <button type="button" onclick="closeAddForm()">Annuler</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Formulaire de modification caché -->
    <div class="edit-form-container" id="edit-form-container" style="display: none;">
        <form method="post" class="edit-form">
            <input type="hidden" name="habitat_id" id="edit-habitat-id">
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="edit-nom" required>
            <label for="description">Description:</label>
            <textarea name="description" id="edit-description" required></textarea>
            <label for="commentaire_habitat">Commentaire:</label>
            <textarea name="commentaire_habitat" id="edit-commentaire_habitat"></textarea>
            <button type="submit" name="edit_habitat">Modifier</button>
            <button type="button" onclick="closeEditForm()">Annuler</button>
        </form>
    </div>
</main>

<script>
function openEditForm(habitatId) {
    document.getElementById('edit-form-container').style.display = 'block';
    // Fetch habitat data and fill the form
    var habitat = <?php echo json_encode($habitats); ?>.find(h => h.habitat_id == habitatId);
    document.getElementById('edit-habitat-id').value = habitat.habitat_id;
    document.getElementById('edit-nom').value = habitat.nom;
    document.getElementById('edit-description').value = habitat.description;
    document.getElementById('edit-commentaire_habitat').value = habitat.commentaire_habitat;
}

function closeEditForm() {
    document.getElementById('edit-form-container').style.display = 'none';
}

function openAddForm() {
    document.getElementById('add-form').style.display = 'block';
}

function closeAddForm() {
    document.getElementById('add-form').style.display = 'none';
}
</script>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>