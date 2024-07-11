<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/includes/header.css">
    <link rel="stylesheet" href="/includes/footer.css">
</head>
<body>
    <header>
        <div class="container header-container">
            <a href="/">
                <img class="logo" src="/includes/imgHeader/logo.png" alt="logo">
            </a>
            <nav>
                <ul>
                    <li><a href="/animaux/index.php">Les animaux</a></li>
                    <li><a href="/habitats/index.php">Les habitats</a></li>
                    <li><a href="/services/index.php">Les Services</a></li>
                    <li><a href="/contact/index.php">Contact</a></li>
                    <?php if (isset($_SESSION['email'])) : ?>
                        <?php if ($_SESSION['role'] == 'administateur') : ?>
                            <li><a href="/dashboard/dashboardAdmin.php">Tableau de bord</a></li>
                        <?php elseif ($_SESSION['role'] == 'employe') : ?>
                            <li><a href="/dashboard/dashboardEmploye.php">Tableau de bord</a></li>
                        <?php elseif ($_SESSION['role'] == 'veterinaire') : ?>
                            <li><a href="/dashboard/dashboardVeto.php">Tableau de bord</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </nav>
               
            <div class="connexion">
                <?php if (isset($_SESSION['email'])) : ?>
                    <a href="/connexion/logout.php">
                        <img class="connexionImg" src="/includes/imgHeader/deconnecter.png" alt="se déconnecter">
                    </a>
                <?php else : ?>
                    <a href="/connexion/connexion.php">
                        <img class="connexionImg" src="/includes/imgHeader/connecter.png" alt="se connecter">
                    </a>
                <?php endif; ?>
            </div>
            <div class="mobile-link">
                <?php if (isset($_SESSION['email'])) : ?>
                    <a href="connexion/logout.php" class="connect-link">Se déconnecter</a>
                <?php else : ?>
                    <a href="/login" class="connect-link">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
</body>
</html>