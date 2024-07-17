<?php require_once(__DIR__ . '/../includes/header.php'); ?>
<form action="envois.php" method="POST">
    <label>
        Votre mail:
        <input type="email" name="email" required>
    </label><br><br>

    <label>
        Sujet:
        <input type="text" name="subject" required>
    </label><br><br>

    <label>
        Message:
        <textarea name="message" rows="4" cols="50" required></textarea>
    </label><br><br>

    <button type="submit">Envoyer</button>
</form>