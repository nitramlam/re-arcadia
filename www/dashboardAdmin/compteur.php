<?php
require_once 'mongo_connect.php';

// Connexion à MongoDB
$db = getMongoConnection();
$collection = $db->animal_views;

// Récupérer les compteurs de clics
$views = $collection->find();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Admin</title>
</head>
<body>
    <h1>Compteurs de clics par animal</h1>
    <table border="1">
        <tr>
            <th>Nom de l'animal</th>
            <th>Nombre de clics</th>
        </tr>
        <?php foreach ($views as $view): ?>
            <tr>
                <td><?= htmlspecialchars($view['animal_nom']) ?></td>
                <td><?= htmlspecialchars($view['views']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>