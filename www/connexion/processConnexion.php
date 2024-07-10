<?php
session_start();
include 'dh.php'; // Assurez-vous que ce fichier est correctement inclus sans sortie HTML avant <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Votre logique de vérification des identifiants ici
        // Assurez-vous que session_start() est avant toute sortie vers le navigateur
    }
}
?>
