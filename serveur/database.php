<?php

/* Ici, nous définissons les informations de connexion */
/* Ici, nous définissons les informations de connexion */
$host = "localhost";
$dbname = "Abyss";
$username = "bddAbyss";
$password = "Fraise200307";

/* Création d'une instance PDO */
/* https://www.php.net/manual/fr/pdo.connections.php */
/* Création d'une instance PDO */
/* https://www.php.net/manual/fr/pdo.connections.php */
try {
    /* Connexion à la base de données */
    /* Connexion à la base de données */
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    /* Si tout se passe bien, je n'affiche rien */
    /* Si tout se passe bien, je n'affiche rien */
} catch (PDOException $e) {
    /* Si la connexion échoue j'affiche un message d'erreur */
    /* Si la connexion échoue j'affiche un message d'erreur */
    echo "Échec de la connexion : " . $e->getMessage();
}