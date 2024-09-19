<?php

$host = "localhost";
$dbname = "abyss";
$username = "root";
$password = "root";

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configuration des options PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Requête pour récupérer les pseudos des utilisateurs
    $sql = "SELECT pseudo FROM Utilisateurs";
    $stmt = $pdo->query($sql);
    
    // Récupération des résultats
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Gestion des erreurs
    echo "Échec de la connexion : " . $e->getMessage();
}

