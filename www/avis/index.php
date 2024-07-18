<?php require_once (__DIR__ . '/../includes/header.php'); ?><!-- index.php -->
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
    $isVisible = false; // Par défaut, le nouvel avis est visible
    $isApproved = false; // Nouvel avis non validé par défaut

    // Insertion des données dans la base de données
    if ($pdo) {
        $sql = "INSERT INTO AVIS (pseudo, commentaire, isVisible, isApproved) VALUES (:pseudo, :commentaire, :isVisible, :isApproved)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $stmt->bindParam(':isVisible', $isVisible, PDO::PARAM_BOOL);
        $stmt->bindParam(':isApproved', $isApproved, PDO::PARAM_BOOL);

        if ($stmt->execute()) {
            $isFormSubmitted = true;
            $confirmationMessage = "Votre avis a été pris en compte. Il sera traité bientôt.";
        } else {
            echo "Erreur lors de l'ajout de votre avis.";
        }
    }
}

// Sélection et affichage des avis existants (visible et approuvés)
$sql_avis = "SELECT * FROM AVIS WHERE isVisible = true AND isApproved = true"; 
$stmt_avis = $pdo->query($sql_avis);
$avis = $stmt_avis->fetchAll();
?>




<head>

<link rel="stylesheet" href="/avis/avis.css">
</head>

 <div class="avis">
        

        <!-- Formulaire pour laisser un avis -->
       
            <h2 class="sousTitreAvis"> Laissez votre avis</h2>
            <?php if ($isFormSubmitted) : ?>
                <p id="confirmationMessage"><?php echo htmlspecialchars($confirmationMessage); ?></p>
            <?php else : ?>
                <form id="avisForm" class="avisForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                    <div class="pseudoForm">
                        <label for="pseudo"   >Pseudo :</label><br>
                        <input type="text" id="pseudo" name="pseudo" value="" maxlength="15" style="border-radius: 10px"<?php echo htmlspecialchars($pseudo); ?>" required><br><br>
                    </div>
                    <div class="commentairePseudo">
                        <label for="commentaire">Commentaire :</label><br>
                         <textarea id="commentaire" name="commentaire" rows="4" maxlength="50"  style="resize: none; border-radius: 10px" required><?php echo htmlspecialchars($commentaire); ?></textarea><br><br>
                     </div>

                         <input type="submit" id="input" class="input" value="Laisser un avis">
                </form>
            <?php endif; ?>
      

       
        <div class="avisCarousel">
        <?php if (!empty($avis)) : ?>
      
            <?php foreach ($avis as $avisItem) : ?>
                <div class="avisSlide">
                    <h3 class="avisTitre"><?php echo htmlspecialchars($avisItem['pseudo']); ?></h3>
                    <p class="avisDescription"><?php echo htmlspecialchars($avisItem['commentaire']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>Aucun avis validé pour le moment.</p>
    <?php endif; ?>
</div>

<!-- Script JavaScript pour le carrousel -->
<script>
    let slideIndex = 0;
    carousel();

    function carousel() {
        let slides = document.getElementsByClassName("avisSlide");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        slides[slideIndex - 1].style.display = "flex";
        setTimeout(carousel, 2000);
        
    }

</script>
