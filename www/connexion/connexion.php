<?php
// Vérification du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../config/db.php'; // Inclure le fichier de configuration de la base de données

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Obtenir une connexion à la base de données
    $pdo = getDatabaseConnection();

    if ($pdo) {
        try {
            // Requête SQL pour vérifier les informations d'authentification
            $sql = "SELECT email, role FROM utilisateurs WHERE email = :email AND password = :password";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email, 'password' => $password]);
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($utilisateur) {
                // Authentification réussie, rediriger vers une page connectée
                header("Location: processConnexion.php");
                exit;
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <style>
        /* Styles CSS optionnels pour la mise en forme */
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
