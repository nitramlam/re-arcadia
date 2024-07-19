<?php 
require_once(__DIR__ . '/../includes/auth.php'); 
require_once(__DIR__ . '/../includes/header.php'); 
require '../config/db.php';


$pdo = getDatabaseConnection();

// Fonction pour gérer l'upload d'image
function uploadImage($file) {
    if (isset($file) && $file['error'] == 0) {
        $uploadDir = __DIR__ . '/../imageServices/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            return '/imageServices/' . basename($file['name']);
        } else {
            error_log("Erreur lors du déplacement du fichier.");
        }
    } else {
        error_log("Erreur lors de l'upload du fichier : " . $file['error']);
    }
    return null;
}

// Gestion des soumissions des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_service'])) {
        // Ajouter un service
        $nom = $_POST['nom'];
        $description = $_POST['description'];

        // Gestion du téléchargement de l'image
        $imagePath = uploadImage($_FILES['image']);
        if ($imagePath === null) {
            $imagePath = '/imageServices/default.jpg'; // Chemin par défaut si le téléchargement échoue
        }

        $stmt = $pdo->prepare("INSERT INTO service (nom, description, icons_path) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $description, $imagePath]);

    } elseif (isset($_POST['update_service'])) {
        // Modifier un service
        $service_id = $_POST['service_id'];
        $nom = $_POST['nom'];
        $description = $_POST['description'];

        // Vérifier s'il y a une nouvelle image téléchargée
        $imagePath = uploadImage($_FILES['image']);
        if ($imagePath) {
            $stmt = $pdo->prepare("UPDATE service SET nom = ?, description = ?, icons_path = ? WHERE service_id = ?");
            $stmt->execute([$nom, $description, $imagePath, $service_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE service SET nom = ?, description = ? WHERE service_id = ?");
            $stmt->execute([$nom, $description, $service_id]);
        }

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
    <link rel="stylesheet" href="modifierServices.css">
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
            <h3><?php echo htmlspecialchars($service['nom'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <img src="<?php echo htmlspecialchars($service['icons_path'] ?? '/imageServices/default.jpg'); ?>" alt="<?php echo htmlspecialchars($service['nom'] ?? ''); ?>">
            <p><?php echo nl2br(htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8')); ?></p>
           
            <form id="form-<?php echo $service['service_id']; ?>" class="hidden" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service['service_id'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="nom" value="<?php echo htmlspecialchars($service['nom'], ENT_QUOTES, 'UTF-8'); ?>" required>
                <textarea name="description" required><?php echo htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                <label>Image: <input type="file" name="image" accept="image/*"></label>
                <button type="submit" name="update_service">Modifier</button>
                <button type="submit" name="delete_service" class="delete">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>

    <h2>Ajouter un Service</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <label>Image: <input type="file" name="image" accept="image/*"></label>
        <button type="submit" name="add_service">Ajouter</button>
    </form>
</div>

<div class="horaires">
    <h2>Horaires d'ouverture</h2>
    <form method="POST">
        <label for="ouverture">Ouverture :</label>
        <input type="time" id="ouverture" name="ouverture" value="<?php echo htmlspecialchars($horaires['ouverture'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <label for="fermeture">Fermeture :</label>
        <input type="time" id="fermeture" name="fermeture" value="<?php echo htmlspecialchars($horaires['fermeture'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <button type="submit" name="update_horaire">Modifier les horaires</button>
    </form>
</div>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>