<?php
require '../config/db.php';

$pdo = getDatabaseConnection();

$message = ""; // Message de confirmation

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $avisId = $_GET['id'];

    // Récupérer les détails de l'avis à valider
    $sql = "SELECT * FROM AVIS WHERE avis_id = :avisId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':avisId', $avisId, PDO::PARAM_INT);
    $stmt->execute();
    $avis = $stmt->fetch();

    if (!$avis) {
        die("Avis non trouvé.");
    }
} else {
    die("Accès non autorisé.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action === "approve") {
        // Mettre à jour la visibilité de l'avis
        $sql = "UPDATE AVIS SET isVisible = true, isApproved = true WHERE avis_id = :avisId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':avisId', $avisId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $message = "L'avis a été approuvé et publié.";
        } else {
            $message = "Erreur lors de l'approbation de l'avis.";
        }
    } elseif ($action === "reject") {
        // Supprimer l'avis
        $sql = "DELETE FROM AVIS WHERE avis_id = :avisId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':avisId', $avisId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $message = "L'avis a été rejeté.";
        } else {
            $message = "Erreur lors du rejet de l'avis.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de l'Avis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Validation de l'Avis</h2>
    <h3><?php echo htmlspecialchars($avis['pseudo']); ?></h3>
    <p><?php echo htmlspecialchars($avis['commentaire']); ?></p>

    <?php if (!empty($message)) : ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$avisId"; ?>" method="post">
        <input type="hidden" name="action" value="approve">
        <button type="submit">Approuver et Publier</button>
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$avisId"; ?>" method="post">
        <input type="hidden" name="action" value="reject">
        <button type="submit">Rejeter</button>
    </form>
</body>
</html>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de l'Avis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Validation de l'Avis</h2>
    <h3><?php echo htmlspecialchars($avis['pseudo']); ?></h3>
    <p><?php echo htmlspecialchars($avis['commentaire']); ?></p>

    <?php if (!empty($message)) : ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$avisId"; ?>" method="post">
        <input type="hidden" name="action" value="approve">
        <button type="submit">Approuver et Publier</button>
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$avisId"; ?>" method="post">
        <input type="hidden" name="action" value="reject">
        <button type="submit">Rejeter</button>
    </form>
</body>
</html>
