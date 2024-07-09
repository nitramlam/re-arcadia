<?php
// Récupérer les données du formulaire
$destinataire = $_POST['destinataire'];
$sujet = $_POST['sujet'];
$message = $_POST['message'];

// Paramètres pour l'e-mail
$headers = "From: webmaster@example.com"; // L'adresse email qui envoie (doit être une adresse validée sur ton serveur)
$headers .= "Reply-To: webmaster@example.com"; // Adresse de réponse
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Envoyer l'e-mail
$result = mail($destinataire, $sujet, $message, $headers);

// Vérifier si l'e-mail a été envoyé avec succès
if ($result) {
    echo "L'e-mail a été envoyé avec succès.";
} else {
    echo "Erreur lors de l'envoi de l'e-mail. Veuillez réessayer.";
}
?>
