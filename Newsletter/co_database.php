<?php
// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "root", "abyss");

// Vérification de la connexion
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
