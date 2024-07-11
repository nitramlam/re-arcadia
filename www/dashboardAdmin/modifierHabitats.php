<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<?php
require '../config/db.php';

// Obtenir une connexion à la base de données
$pdo = getDatabaseConnection();

if ($pdo) {
    // Sélection et affichage des données des habitats
    $sql = "SELECT * FROM HABITAT";
    $stmt = $pdo->query($sql);
    $habitats = $stmt->fetchAll();

    // Sélection et affichage des données des animaux
    $sql_animals = "SELECT * FROM animal";
    $stmt_animals = $pdo->query($sql_animals);
    $animals = $stmt_animals->fetchAll(PDO::FETCH_ASSOC);
}
?>

<link rel="stylesheet" href="style.css">

<main>
    <div class="habitats">
        <div class="introHabitats">
            <h1 class="titreHabitats"> NOS HABITATS</h1>
            <p class="paragrapheHabitats">
                Découvrez nos trois habitats distincts : la jungle, les marais et la savane, conçus de manière
                écologique et adaptée. Chaque environnement offre à nos animaux un espace immersif qui respecte leur
                bien-être et leur comportement naturel. Notre engagement envers la préservation de la biodiversité se
                reflète dans chaque détail de ces écosystèmes uniques.
            </p>
            <img src="assets/panthere-habitats.png" alt="" class="panthere">
        </div>

        <div class="row m-0">
            <?php
            // Affichage des habitats et des animaux
            if (!empty($habitats)) {
                foreach ($habitats as $habitat) {
                    echo '<div class="col-md-12 p-0">';
                    echo '<h2>' . htmlspecialchars($habitat['nom']) . '</h2>';
                    echo '<p>' . htmlspecialchars($habitat['description']) . '</p>';
                    echo '<p><em>' . htmlspecialchars($habitat['commentaire_habitat']) . '</em></p>';

                    // Affichage des animaux pour chaque habitat
                    $hasAnimals = false;
                    echo '<ul>';
                    foreach ($animals as $animal) {
                        if ($animal['habitat'] === $habitat['nom']) {
                            $hasAnimals = true;
                            echo '<li>';
                            echo '<strong>' . htmlspecialchars($animal['nom']) . '</strong> (' . htmlspecialchars($animal['espece']) . ')';
                            
                            echo '<p><em>' . htmlspecialchars($animal['etat_general']) . '</em></p>';
                            echo '</li>';
                        }
                    }
                    echo '</ul>';
                    if (!$hasAnimals) {
                        echo '<p>Aucun animal dans cet habitat.</p>';
                    }

                    echo "</div>";
                }
            } else {
                echo '<p>Aucun habitat disponible.</p>';
            }
            ?>
        </div>
    </div>
</main>

<?php require_once (__DIR__ . '/../includes/footer.php'); ?>