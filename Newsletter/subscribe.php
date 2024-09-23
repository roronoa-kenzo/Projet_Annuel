<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Génération du token de confirmation
$token = uniqid();

// Insertion de l'abonné dans la table subscribers
$query = "INSERT INTO subscribers (email, confirmed, token) VALUES ('$email', 0, '$token')";
mysqli_query($conn, $query);

// Envoi de l'email de confirmation
$subject = 'Confirmation de votre adresse email';
$message = 'Merci de confirmer votre adresse email en cliquant sur le lien suivant : http://example.com/confirm.php?token=' . $token;
$headers = 'From:  Abyss <your_email@example.com>' . "\r\n";
mail($email, $subject, $message, $headers);
?>