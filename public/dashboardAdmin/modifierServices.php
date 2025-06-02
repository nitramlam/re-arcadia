<?php
session_start();
require_once __DIR__ . '/../../classes/SessionManager.php';
SessionManager::requireAuth();

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['administrateur', 'employe'])) {
    header("Location: /connexion/connexion.php");
    exit();
}
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/ServiceManager.php';
require_once __DIR__ . '/../../classes/Service.php';
require_once(__DIR__ . '/../includes/header.php');

$conn = Database::getConnection();
if (!$conn) {
    die("Erreur de connexion à la base de données");
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function uploadImage($image): ?string
{
    if ($image['error'] === UPLOAD_ERR_OK) {
        $targetDir = __DIR__ . "/../imageServices/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($image["name"]);
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($ext, $validExtensions))
            return null;

        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            return "/imageServices/" . basename($image["name"]);
        }
    }
    return null;
}

$serviceManager = new ServiceManager($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Validation CSRF échouée.');
    }

    $nom = $_POST['nom'] ?? '';
    $description = $_POST['description'] ?? '';
    $imagePath = uploadImage($_FILES['image'] ?? []);

    if (isset($_POST['add_service'])) {
        if (!$imagePath)
            $imagePath = '/imageServices/default.jpg';
        $service = new Service([
            'nom' => $nom,
            'description' => $description,
            'icons_path' => $imagePath
        ]);
        $serviceManager->add($service);
    } elseif (isset($_POST['update_service'])) {
        $id = (int) $_POST['service_id'];
        $service = new Service([
            'service_id' => $id,
            'nom' => $nom,
            'description' => $description,
            'icons_path' => $imagePath
        ]);
        $serviceManager->update($service);
    } elseif (isset($_POST['delete_service'])) {
        $id = (int) $_POST['service_id'];
        $serviceManager->delete($id);
    } elseif (isset($_POST['update_horaire'])) {
        $ouverture = $_POST['ouverture'];
        $fermeture = $_POST['fermeture'];
        $serviceManager->updateHoraires($ouverture, $fermeture);
    }
}

$services = $serviceManager->getAll();
$horaires = $serviceManager->getHoraires();
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
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</head>

<body>
    <div class="services">
        <h2>Nos Services</h2>
        <?php foreach ($services as $service): ?>
            <div class="service">
                <h3><?= htmlspecialchars($service->getNom()) ?></h3>
                <img src="<?= htmlspecialchars($service->getIconsPath() ?? '/imageServices/default.jpg') ?>"
                    alt="<?= htmlspecialchars($service->getNom()) ?>">
                <p><?= nl2br(htmlspecialchars($service->getDescription())) ?></p>

                <form id="form-<?= $service->getId() ?>" class="hidden" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <input type="hidden" name="service_id" value="<?= $service->getId() ?>">
                    <input type="text" name="nom" value="<?= htmlspecialchars($service->getNom()) ?>" required>
                    <textarea name="description" required><?= htmlspecialchars($service->getDescription()) ?></textarea>
                    <label>Image: <input type="file" name="image" accept="image/*"></label>
                    <button type="submit" name="update_service">Modifier</button>
                    <button type="submit" name="delete_service" class="delete">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>

        <h2>Ajouter un Service</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="text" name="nom" placeholder="Nom" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <label>Image: <input type="file" name="image" accept="image/*"></label>
            <button type="submit" name="add_service">Ajouter</button>
        </form>
    </div>

    <div class="horaires">
        <h2>Horaires d'ouverture</h2>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <label for="ouverture">Ouverture :</label>
            <input type="time" id="ouverture" name="ouverture" value="<?= htmlspecialchars($horaires['ouverture']) ?>" required>
            <label for="fermeture">Fermeture :</label>
            <input type="time" id="fermeture" name="fermeture" value="<?= htmlspecialchars($horaires['fermeture']) ?>" required>
            <button type="submit" name="update_horaire">Modifier les horaires</button>
        </form>
    </div>

    <?php require_once(__DIR__ . '/../includes/footer.php'); ?>
</body>

</html>