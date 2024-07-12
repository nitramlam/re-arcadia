<?php require_once(__DIR__ . '/../includes/header.php'); ?>


<form action="https://formspree.io/f/mqazkvvd" method="POST">
    <label>
        votre mail:
        <input type="email" name="email" required>
    </label><br><br>

    <label>
        Sujet:
        <input type="text" name="subject" required>
    </label><br><br>

    <label>
        message:
        <textarea name="message" rows="4" cols="50" required></textarea>
    </label><br><br>

    <button type="submit">envoyer</button>
</form>