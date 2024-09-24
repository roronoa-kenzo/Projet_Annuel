<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Récupération de l'adresse e-mail (par exemple, à partir d'un formulaire)
$email = $_POST['email'];

// Génération du token de confirmation
$token = uniqid();

// Préparation de la requête d'insertion
$stmt = mysqli_prepare($conn, "INSERT INTO subscribers (email, confirmed, token) VALUES (?, 0, ?)");
mysqli_stmt_bind_param($stmt, "ss", $email, $token);
mysqli_stmt_execute($stmt);

// Envoi de l'email de confirmation
$subject = 'Confirmation de votre adresse email';
$message = 'Merci de confirmer votre adresse email en cliquant sur le lien suivant : https://www.abyss.boats/confirm.php?token=' . $token;
$headers = 'From:  Abyss <notification@abyss.boats>' . "\r\n";
mail($email, $subject, $message, $headers);