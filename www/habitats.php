<?php
require 'config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

if ($pdo) {
    // Sélection et affichage des données
    $sql = "SELECT * FROM HABITAT";
    $stmt = $pdo->query($sql);
    $habitats = $stmt->fetchAll();

    foreach ($habitats as $habitat) {
        echo "<h2>" . htmlspecialchars($habitat['nom']) . "</h2>";
        echo "<p>" . htmlspecialchars($habitat['description']) . "</p>";
        echo "<p><strong>Commentaire:</strong> " . htmlspecialchars($habitat['commentaire_habitat']) . "</p>";
    }
}
?>