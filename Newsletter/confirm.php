<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Récupération du token de confirmation
$token = $_GET['token'];

// Vérification du token de confirmation
$query = "SELECT * FROM subscribers WHERE token = '$token'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Mise à jour de la colonne confirmed à 1
    $query = "UPDATE subscribers SET confirmed = 1 WHERE token = '$token'";
    mysqli_query($conn, $query);
    echo 'Votre adresse email a été confirmée avec succès !';
} else {
    echo 'Erreur : token de confirmation invalide';
}
?>