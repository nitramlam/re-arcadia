<?php
require_once(__DIR__ . '/../includes/header.php'); 
require '../config/db.php';

$pdo = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['animal_id'])) {
    $animal_id = $_POST['animal_id'];
    $derniere_visite = $_POST['derniere_visite'];
    $regime = $_POST['regime'];
    $grammage = $_POST['grammage'];

    $stmt = $pdo->prepare("UPDATE animal SET derniere_visite = ?, regime = ?, grammage = ? WHERE animal_id = ?");
    $stmt->execute([$derniere_visite, $regime, $grammage, $animal_id]);
}

$animalQuery = $pdo->query("SELECT * FROM animal");
$animals = $animalQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Animaux</title>
    <link rel="stylesheet" href="alimentation.css">
</head>
<body>
<div class="animals">
    <h2>Gestion des Animaux</h2>
    <?php foreach ($animals as $animal): ?>
        <div class="animal">
            <h3><?php echo htmlspecialchars($animal['nom']); ?> - <?php echo htmlspecialchars($animal['espece']); ?></h3>
            <p><strong>État général :</strong> <?php echo htmlspecialchars($animal['etat_general']); ?></p>
            <p><strong>Description :</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
            <form method="POST">
                <input type="hidden" name="animal_id" value="<?php echo htmlspecialchars($animal['animal_id']); ?>">
                <label for="derniere_visite_<?php echo $animal['animal_id']; ?>">Date de la dernière visite :</label>
                <input type="date" id="derniere_visite_<?php echo $animal['animal_id']; ?>" name="derniere_visite" value="<?php echo htmlspecialchars($animal['derniere_visite']); ?>" required>
                <label for="regime_<?php echo $animal['animal_id']; ?>">Nourriture donnée :</label>
                <input type="text" id="regime_<?php echo $animal['animal_id']; ?>" name="regime" value="<?php echo htmlspecialchars($animal['regime']); ?>" required>
                <label for="grammage_<?php echo $animal['animal_id']; ?>">Grammage :</label>
                <input type="number" id="grammage_<?php echo $animal['animal_id']; ?>" name="grammage" value="<?php echo htmlspecialchars($animal['grammage']); ?>" step="0.01" required>
                <button type="submit">Mettre à jour</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>