<?php
// Paramètres de connexion
$servername = "arcadia-db";
$username = "KeeperAdmin";
$password = "WildLifeSecure33!";
$dbname = "arcadia";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
?>