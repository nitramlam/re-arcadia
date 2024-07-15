
    <?php
    require '../config/db.php';
    
    $pdo = getDatabaseConnection();
    
    // Requête pour récupérer les informations de l'animal
    $stmt = $pdo->prepare('SELECT * FROM animal WHERE animal_id = ?');
    $stmt->execute([3]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$animal) {
        echo 'Animal not found.';
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <title><?php echo htmlspecialchars($animal['nom']); ?></title>
        <link rel='stylesheet' href='../styles.css'> <!-- Assurez-vous d'avoir le bon chemin pour votre fichier CSS -->
    </head>
    <body>
        <?php require_once (__DIR__ . '/../includes/header.php'); ?>
        <main>
            <h1><?php echo htmlspecialchars($animal['nom']); ?></h1>
            <img src='<?php echo htmlspecialchars($animal['image_path'] ?? '/animaux/default.jpg'); ?>' alt='<?php echo htmlspecialchars($animal['nom']); ?>' style='max-width: 300px;'>
            <p><strong>Espèce:</strong> <?php echo htmlspecialchars($animal['espece']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
            <p><strong>Poids:</strong> <?php echo htmlspecialchars($animal['poids']); ?> kg</p>
            <p><strong>Sexe:</strong> <?php echo htmlspecialchars($animal['sexe']); ?></p>
            <p><strong>Continent d'origine:</strong> <?php echo htmlspecialchars($animal['continent_origine']); ?></p>
            <p><strong>Âge:</strong> <?php echo htmlspecialchars($animal['age']); ?> ans</p>
            <p><strong>Habitat:</strong> <?php echo htmlspecialchars($animal['habitat']); ?></p>
        </main>
        <?php require_once (__DIR__ . '/../includes/footer.php'); ?>
    </body>
    </html>
    