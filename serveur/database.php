<?php

$host = "localhost";
$dbname = "Abyss";
$username = "bddAbyss";
$password = "Fraise200307";

// Vérifier la connexion
try {
    /* Connexion à la base de données */
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    /* Si tout se passe bien, je n'affiche rien */
} catch (PDOException $e) {
    /* Si la connexion échoue j'affiche un message d'erreur */
    echo "Échec de la connexion : " . $e->getMessage();
}
