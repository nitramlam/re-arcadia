<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

// Requête SQL pour sélectionner tous les utilisateurs
if ($pdo) {
    try {
        // Sélection et affichage des utilisateurs
        $sql = "SELECT email, role FROM utilisateurs";
        $stmt = $pdo->query($sql);
        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des utilisateurs: " . $e->getMessage();
        exit;
    }
} else {
    echo "Erreur: Impossible de se connecter à la base de données.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    <ul>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <li><?= htmlspecialchars($utilisateur['email']); ?> (<?= htmlspecialchars($utilisateur['role']); ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

