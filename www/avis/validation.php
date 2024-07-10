<?php
require '../config/db.php';

$pdo = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['avis_id'])) {
    $avis_id = $_POST['avis_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $sql = "UPDATE AVIS SET isApproved = true, isVisible = true WHERE avis_id = :avis_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':avis_id', $avis_id, PDO::PARAM_INT);
        $stmt->execute();
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM AVIS WHERE avis_id = :avis_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':avis_id', $avis_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

$sql_pending_avis = "SELECT * FROM AVIS WHERE isApproved = false";
$stmt_pending_avis = $pdo->query($sql_pending_avis);
$pending_avis = $stmt_pending_avis->fetchAll();
?>

<?php require_once (__DIR__ . '/../includes/header.php'); ?>

<link rel="stylesheet" href="style.css">

<main>
    <div class="validation">
        <h1>Validation des Avis</h1>
        <?php if (empty($pending_avis)) : ?>
            <p>Aucun avis en attente de validation.</p>
        <?php else : ?>
            <ul>
                <?php foreach ($pending_avis as $avis) : ?>
                    <li>
                        <p><strong>Pseudo:</strong> <?php echo htmlspecialchars($avis['pseudo']); ?></p>
                        <p><strong>Commentaire:</strong> <?php echo htmlspecialchars($avis['commentaire']); ?></p>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="avis_id" value="<?php echo $avis['avis_id']; ?>">
                            <button type="submit" name="action" value="approve">Oui</button>
                            <button type="submit" name="action" value="delete">Non</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</main>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>
