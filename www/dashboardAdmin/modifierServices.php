<?php 
require_once (__DIR__ . '/../includes/header.php');
require '../config/db.php';

$pdo = getDatabaseConnection();

// Gestion des soumissions des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_service'])) {
        // Ajouter un service
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $icons_path = $_POST['icons_path'];
        $stmt = $pdo->prepare("INSERT INTO service (nom, description, icons_path) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $description, $icons_path]);
    } elseif (isset($_POST['update_service'])) {
        // Modifier un service
        $service_id = $_POST['service_id'];
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $icons_path = $_POST['icons_path'];
        $stmt = $pdo->prepare("UPDATE service SET nom = ?, description = ?, icons_path = ? WHERE service_id = ?");
        $stmt->execute([$nom, $description, $icons_path, $service_id]);
    } elseif (isset($_POST['delete_service'])) {
        // Supprimer un service
        $service_id = $_POST['service_id'];
        $stmt = $pdo->prepare("DELETE FROM service WHERE service_id = ?");
        $stmt->execute([$service_id]);
    } elseif (isset($_POST['update_horaire'])) {
        // Modifier les horaires
        $ouverture = $_POST['ouverture'];
        $fermeture = $_POST['fermeture'];
        $stmt = $pdo->prepare("UPDATE horaires SET ouverture = ?, fermeture = ? WHERE horaire_id = 1");
        $stmt->execute([$ouverture, $fermeture]);
    }
}

// Récupérer les données des services
$serviceQuery = $pdo->query("SELECT * FROM service");
$services = $serviceQuery->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données des horaires
$horaireQuery = $pdo->query("SELECT * FROM horaires");
$horaires = $horaireQuery->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Services et Horaires</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
    <script>
        function toggleForm(id) {
            var form = document.getElementById(id);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }
    </script>
</head>
<body>
<div class="services">
    <h2>Nos Services</h2>
    <?php foreach ($services as $service): ?>
        <div class="service">
            <h3><?php echo htmlspecialchars(mb_convert_encoding($service['nom'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></h3>
            <p><?php echo nl2br(htmlspecialchars(mb_convert_encoding($service['description'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8')); ?></p>
            <?php if (!empty($service['icons_path'])): ?>
                <img src="<?php echo htmlspecialchars(mb_convert_encoding($service['icons_path'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(mb_convert_encoding($service['nom'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>">
            <?php endif; ?>
            <button onclick="toggleForm('form-<?php echo $service['service_id']; ?>')">Modifier</button>
            <form id="form-<?php echo $service['service_id']; ?>" class="hidden" method="POST">
                <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service['service_id'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="nom" value="<?php echo htmlspecialchars(mb_convert_encoding($service['nom'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>" required>
                <textarea name="description" required><?php echo htmlspecialchars(mb_convert_encoding($service['description'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></textarea>
                <input type="text" name="icons_path" value="<?php echo htmlspecialchars(mb_convert_encoding($service['icons_path'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" name="update_service">Modifier</button>
                <button type="submit" name="delete_service" class="delete">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>

    <h2>Ajouter un Service</h2>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="text" name="icons_path" placeholder="Chemin de l'icône">
        <button type="submit" name="add_service">Ajouter</button>
    </form>
</div>

<div class="horaires">
    <h2>Horaires d'ouverture</h2>
    <form method="POST">
        <label for="ouverture">Ouverture :</label>
        <input type="time" id="ouverture" name="ouverture" value="<?php echo htmlspecialchars(mb_convert_encoding($horaires['ouverture'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>" required>
        <label for="fermeture">Fermeture :</label>
        <input type="time" id="fermeture" name="fermeture" value="<?php echo htmlspecialchars(mb_convert_encoding($horaires['fermeture'], 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>" required>
        <button type="submit" name="update_horaire">Modifier les horaires</button>
    </form>
</div>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>