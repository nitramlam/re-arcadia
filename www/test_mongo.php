<?php
require 'vendor/autoload.php'; // Charge l'autoloader de Composer

try {
    // Connexion à MongoDB
    $client = new MongoDB\Client("mongodb://mongodb:27017");
    $collection = $client->arcadia->animal_views;

    echo "Connexion à MongoDB réussie.<br>";

    // Test de l'insertion d'un document
    $result = $collection->insertOne(['animal_id' => 2, 'views' => 1]);
    echo "Document inséré avec l'ID : " . $result->getInsertedId();
} catch (Exception $e) {
    echo "Erreur de connexion à MongoDB : " . $e->getMessage();
}