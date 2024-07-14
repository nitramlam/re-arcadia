<?php 
require_once (__DIR__ . '/../includes/header.php');
require '../config/db.php';

$pdo = getDatabaseConnection();

// Gestion des soumissions des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_animal'])) {
        // Modifier un animal
        $animal_id = $_POST['animal_id'];
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $poids = $_POST['poids'];
        $sexe = $_POST['sexe'];
        $continent_origine = $_POST['continent_origine'];
        $age = $_POST['age'];
        $habitat = $_POST['habitat'];
        $espece = $_POST['espece'];
        $stmt = $pdo->prepare("UPDATE animal SET nom = ?, description = ?, poids = ?, sexe = ?, continent_origine = ?, age = ?, habitat = ?, espece = ? WHERE animal_id = ?");
        $stmt->execute([$nom, $description, $poids, $sexe, $continent_origine, $age, $habitat, $espece, $animal_id]);
    } elseif (isset($_POST['delete_animal'])) {
        // Supprimer un animal
        $animal_id = $_POST['animal_id'];
        $stmt = $pdo->prepare("DELETE FROM animal WHERE animal_id = ?");
        $stmt->execute([$animal_id]);
    } elseif (isset($_POST['add_animal'])) {
        // Ajouter un nouvel animal
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $poids = $_POST['poids'];
        $sexe = $_POST['sexe'];
        $continent_origine = $_POST['continent_origine'];
        $age = $_POST['age'];
        $habitat = $_POST['habitat'];
        $espece = $_POST['espece']; // Nouveau champ
        $stmt = $pdo->prepare("INSERT INTO animal (nom, description, poids, sexe, continent_origine, age, habitat, espece) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $poids, $sexe, $continent_origine, $age, $habitat, $espece]); // Nouveau champ
    }
}

// Récupérer les données des animaux
$animalQuery = $pdo->query("SELECT * FROM animal");
$animals = $animalQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Animaux</title>
    <link rel="stylesheet" href="modifierAnimaux.css">
</head>
<body>
    <main>
        <section class="intro">
            <h2>Nos Animaux</h2>
            <p>Au Zoo Écologique de la Forêt de Brocéliande, nous créons des habitats fidèles aux milieux naturels de nos animaux, assurant ainsi leur bien-être et contribuant à la préservation de l'écosystème. Rencontrez nos majestueux lions, éléphants, alligators et bien d'autres résidents fascinants au cœur de notre zoo.</p>
        </section>
        <section class="animal-list">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <h3><?php echo htmlspecialchars($animal['nom'] ?? ''); ?></h3>
                    <button class="view-report">Afficher le compte rendu</button>
                    <div class="animal-details" style="display: none;">
                        <p><strong>État général:</strong> <?php echo htmlspecialchars($animal['etat_general'] ?? ''); ?></p>
                        <p><strong>Nourriture proposée:</strong> <?php echo htmlspecialchars($animal['regime'] ?? ''); ?></p>
                        <p><strong>Grammage proposé:</strong> <?php echo htmlspecialchars($animal['grammage'] ?? ''); ?> kg</p>
                        <p><strong>Dernière visite:</strong> <?php echo htmlspecialchars($animal['derniere_visite'] ?? ''); ?></p>
                        <p><strong>Commentaire:</strong> <?php echo htmlspecialchars($animal['commentaire'] ?? ''); ?></p>
                    </div>
                    <button class="edit-toggle">✏️</button>
                    <form method="POST" class="animal-form" style="display: none;">
                        <input type="hidden" name="animal_id" value="<?php echo htmlspecialchars($animal['animal_id'] ?? ''); ?>">
                        <label>Nom: <input type="text" name="nom" value="<?php echo htmlspecialchars($animal['nom'] ?? ''); ?>" required></label>
                        <label>Description: <textarea name="description" required><?php echo htmlspecialchars($animal['description'] ?? ''); ?></textarea></label>
                        <label>Poids: <input type="number" step="0.01" name="poids" value="<?php echo htmlspecialchars($animal['poids'] ?? ''); ?>" required></label>
                        <label>Sexe: <input type="text" name="sexe" value="<?php echo htmlspecialchars($animal['sexe'] ?? ''); ?>" required></label>
                        <label>Continent d'origine: <input type="text" name="continent_origine" value="<?php echo htmlspecialchars($animal['continent_origine'] ?? ''); ?>" required></label>
                        <label>Âge: <input type="number" name="age" value="<?php echo htmlspecialchars($animal['age'] ?? ''); ?>" required></label>
                        <label>Habitat: <input type="text" name="habitat" value="<?php echo htmlspecialchars($animal['habitat'] ?? ''); ?>" required></label>
                        <label>Espèce: <input type="text" name="espece" value="<?php echo htmlspecialchars($animal['espece'] ?? ''); ?>" required></label> <!-- Nouveau champ -->
                        <button type="submit" name="update_animal" class="edit-btn">Modifier</button>
                        <button type="submit" name="delete_animal" class="delete-btn">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- Formulaire d'ajout d'un nouvel animal -->
        <button class="add-animal" onclick="openAddForm()">Ajouter un animal</button>
        <form method="POST" class="add-animal-form" id="add-animal-form" style="display: none;">
            <label>Nom: <input type="text" name="nom" required></label>
            <label>Description: <textarea name="description" required></textarea></label>
            <label>Poids: <input type="number" step="0.01" name="poids" required></label>
            <label>Sexe: <input type="text" name="sexe" required></label>
            <label>Continent d'origine: <input type="text" name="continent_origine" required></label>
            <label>Âge: <input type="number" name="age" required></label>
            <label>Habitat: <input type="text" name="habitat" required></label>
            <label>Espèce: <input type="text" name="espece" required></label> <!-- Nouveau champ obligatoire -->
            <button type="submit" name="add_animal">Ajouter</button>
            <button type="button" onclick="closeAddForm()">Annuler</button>
        </form>

    </main>
    <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const viewReportButtons = document.querySelectorAll('.view-report');
            viewReportButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const details = button.nextElementSibling;
                    details.style.display = details.style.display === 'block' ? 'none' : 'block';
                });
            });

            const editToggles = document.querySelectorAll('.edit-toggle');
            editToggles.forEach(button => {
                button.addEventListener('click', () => {
                    const form = button.nextElementSibling;
                    form.style.display = form.style.display === 'block' ? 'none' : 'block';
                });
            });

            const addAnimalButton = document.querySelector('.add-animal');
            addAnimalButton.addEventListener('click', () => {
                document.getElementById('add-animal-form').style.display = 'block';
            });
        });

        function closeAddForm() {
            document.getElementById('add-animal-form').style.display = 'none';
        }
    </script>
</body>
</html>