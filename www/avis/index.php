<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

$pseudo = "";
$commentaire = "";
$isFormSubmitted = false;

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $commentaire = $_POST['commentaire'];
    $isVisible = true; // Par défaut, le nouvel avis est visible
    $isApproved = false; // Nouvel avis non validé par défaut

    // Insertion des données dans la base de données
    $pdo = getDatabaseConnection();
    if ($pdo) {
        $sql = "INSERT INTO AVIS (pseudo, commentaire, isVisible, isApproved) VALUES (:pseudo, :commentaire, :isVisible, :isApproved)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $stmt->bindParam(':isVisible', $isVisible, PDO::PARAM_BOOL);
        $stmt->bindParam(':isApproved', $isApproved, PDO::PARAM_BOOL);

        if ($stmt->execute()) {
            // Envoyer un email de confirmation
            $to = 'josearcadia33@gmail.com';
            $subject = 'Nouveau commentaire en attente de validation';
            $message = "Un nouveau commentaire a été soumis par $pseudo.\n\nCommentaire : $commentaire\n\n";

            $headers = 'From: no-reply@votre-domaine.com' . "\r\n" .
                'Reply-To: no-reply@votre-domaine.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Envoi de l'email
            if (mail($to, $subject, $message, $headers)) {
                $isFormSubmitted = true;
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                echo "Erreur lors de l'envoi de l'email.";
            }
        } else {
            echo "Erreur lors de l'ajout de votre avis.";
        }
    }
}

// Sélection et affichage des avis existants
$pdo = getDatabaseConnection();
if ($pdo) {
    $sql_avis = "SELECT * FROM AVIS WHERE isVisible = true AND isApproved = true"; // Sélectionner uniquement les avis visibles et approuvés
    $stmt_avis = $pdo->query($sql_avis);
    $avis = $stmt_avis->fetchAll();
}
?>

<?php require_once (__DIR__ . '/../includes/header.php'); ?>

<link rel="stylesheet" href="style.css">

<main>
    <div class="avis">
        <div class="introAvis">
            <h1 class="titreAvis"> NOS AVIS</h1>
            <p class="paragrapheAvis">
                Découvrez les avis de nos visiteurs sur notre zoo et nos services. Votre opinion compte pour nous!
            </p>
        </div>

        <!-- Formulaire pour laisser un avis -->
        <div class="nouvelAvis">
            <h2 class="sousTitreAvis"> Laissez votre avis</h2>
            <?php if ($isFormSubmitted) : ?>
                <p>Merci pour votre avis!</p>
            <?php else : ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="pseudo">Pseudo :</label><br>
                    <input type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($pseudo); ?>" required><br><br>

                    <label for="commentaire">Commentaire :</label><br>
                    <textarea id="commentaire" name="commentaire" rows="4" required><?php echo htmlspecialchars($commentaire); ?></textarea><br><br>

                    <input type="submit" value="Laisser un avis">
                </form>
            <?php endif; ?>
        </div>

        <!-- Affichage des avis existants -->
        <div class="row m-0">
            <?php foreach ($avis as $avis_item) : ?>
                <div class="col-md-4 p-0">
                    <h3 class="avis-titre"><?php echo htmlspecialchars($avis_item['pseudo']); ?></h3>
                    <p class="avis-description"><?php echo htmlspecialchars($avis_item['commentaire']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>
