<?php
session_start(); // Assurez-vous de démarrer la session en haut du script

require '../config/db.php'; // Inclure le fichier de configuration de la base de données

$error_message = ''; // Initialisation du message d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = getDatabaseConnection();

    if ($pdo) {
        try {
            $sql = "SELECT email, password, role FROM utilisateurs WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($utilisateur && $utilisateur['password'] === $password) { // Comparaison directe ici
                $_SESSION['email'] = $utilisateur['email'];
                $_SESSION['role'] = $utilisateur['role'];

                // Rediriger chaque rôle vers son dashboard respectif
                switch ($_SESSION['role']) {
                    case 'administateur':
                        header("Location: ../dashboard/dashboardAdmin.php"); // Assurez-vous que le chemin est correct
                        exit;
                    case 'employe':
                        header("Location: ../dashboard/dashboardEmploye.php"); // Assurez-vous que le chemin est correct
                        exit;
                    case 'veterinaire':
                        header("Location: ../dashboard/dashboardVeto.php"); // Assurez-vous que le chemin est correct
                        exit;
                    default:
                        $error_message = "Accès non autorisé pour ce rôle.";
                        break;
                }
            } else {
                $error_message = "Identifiants incorrects. Veuillez réessayer.";
            }
        } catch (PDOException $e) {
            $error_message = "Erreur lors de l'authentification: " . $e->getMessage();
        }
    } else {
        $error_message = "Erreur: Impossible de se connecter à la base de données.";
    }
}
?>

<?php require_once (__DIR__ . '/../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <style>
        form { max-width: 300px; margin: auto; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (!empty($error_message)) : ?>
        <p class="error"><?= $error_message; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
