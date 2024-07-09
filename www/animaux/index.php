<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

// Requête SQL pour sélectionner tous les animaux
if ($pdo) {
    // Sélection et affichage des données
    $sql = "SELECT * FROM animal";
    $stmt = $pdo->query($sql);
    $animaux = $stmt->fetchAll();
}
?>
<?php require_once (__DIR__ . '/../includes/header.php'); ?>

<head>

    <title>Liste des animaux</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<main>
    <div class="animaux">
        <h1>Liste des animaux</h1>
        <div class="row">
            <?php foreach ($animaux as $animal): ?>
                <div class="col-md-4">
                    <div class="animal-card">
                        <h3><?= htmlspecialchars($animal['nom']) ?></h3>
                        <p><strong>Espèce:</strong> <?= htmlspecialchars($animal['espece']) ?></p>
                        <p><strong>État général:</strong> <?= htmlspecialchars($animal['etat_general']) ?></p>
                        <p><strong>Régime:</strong> <?= htmlspecialchars($animal['regime']) ?></p>
                        <p><strong>Poids:</strong> <?= $animal['poids'] ?> kg</p>
                        <p><strong>Sexe:</strong> <?= htmlspecialchars($animal['sexe']) ?></p>
                        <p><strong>Dernière visite:</strong> <?= $animal['derniere_visite'] ?></p>
                         <?php if (isset($animal['commentaire'])): ?>
                <p><strong>Commentaire:</strong> <?= htmlspecialchars($animal['commentaire']) ?></p>
            <?php else: ?>
                <p><strong>Commentaire:</strong> Aucun commentaire disponible</p>
            <?php endif; ?>
                        <p><strong>Continent d'origine:</strong> <?= htmlspecialchars($animal['continent_origine']) ?></p>
                        <p><strong>Âge:</strong> <?= $animal['age'] ?> ans</p>
                        <p><strong>Habitat:</strong> <?= htmlspecialchars($animal['habitat']) ?></p>
                        <p><strong>Grammage:</strong> <?= $animal['grammage'] ?> kg</p>
                        <p><strong>Description:</strong> <?= htmlspecialchars($animal['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php require_once (__DIR__ . '/../includes/footer.php'); ?>

</body>
</html>
