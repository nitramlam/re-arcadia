<?php require_once(__DIR__ . '/../includes/header.php'); ?>
<?php require '../config/db.php'; ?>

<?php
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $roles = isset($_POST['role']) ? $_POST['role'] : [];

    if ($password !== $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } elseif (empty($roles)) {
        $error_message = "Veuillez sélectionner au moins un rôle.";
    } else {
        $role = implode(',', $roles); // Concatène les rôles sélectionnés en une chaîne
        $pdo = getDatabaseConnection();

        if ($pdo) {
            try {
                $sql = "INSERT INTO utilisateurs (email, password, role) VALUES (:email, :password, :role)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'email' => $email,
                    'password' => $password, // Mot de passe non haché
                    'role' => $role
                ]);
                $success_message = "Utilisateur créé avec succès.";
                echo "<script>alert('Utilisateur créé avec succès.');</script>";

                // Envoi de l'email
                $to = $email;
                $subject = "Votre compte utilisateur a été créé";
                $message = "Votre compte utilisateur a été créé avec succès. Veuillez contacter votre administrateur pour obtenir votre mot de passe.";
                $headers = "From: josearcadia33@gmail.com";

                if (mail($to, $subject, $message, $headers)) {
                    echo "<script>alert('Email envoyé avec succès.');</script>";
                } else {
                    echo "<script>alert('Échec de l'envoi de l'email.');</script>";
                }
            } catch (PDOException $e) {
                $error_message = "Erreur lors de la création de l'utilisateur: " . $e->getMessage();
            }
        } else {
            $error_message = "Erreur: Impossible de se connecter à la base de données.";
        }
    }
}
?>

<header>
    <link rel="stylesheet" href="creerCompte.css">
</header>
<body>
    <main>
        <section class="create-account">
            <h1>CRÉER UN COMPTE UTILISATEUR</h1>
            <?php if ($error_message): ?>
                <p class="error-message"><?= $error_message ?></p>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <p class="success-message"><?= $success_message ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="role">Créer un compte:</label>
                    <div class="role-options">
                        <label><input type="checkbox" name="role[]" value="veterinaire"> Vétérinaire</label>
                        <label><input type="checkbox" name="role[]" value="employe"> Employé</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Adresse mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mots de passe:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('password')">👁️</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirmer le mots de passe:</label>
                    <div class="password-container">
                        <input type="password" id="confirm-password" name="confirm-password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password')">👁️</span>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Valider</button>
            </form>
        </section>
    </main>
    <script>
        function togglePasswordVisibility(id) {
            var input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
<?php require_once (__DIR__ . '/../includes/footer.php'); ?>