<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Récupération du token de confirmation
$token = $_GET['token'];

// Vérification si le token est valide
$stmt = mysqli_prepare($conn, "SELECT * FROM subscribers WHERE token = ?");
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result->num_rows > 0) {
    // Le token est valide, on met à jour le statut de l'abonné
    $stmt = mysqli_prepare($conn, "UPDATE subscribers SET confirmed = 1 WHERE token = ?");
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);

    // Affichage d'un message de confirmation
    ?>
    <html>
    <head>
        <title>Confirmation d'adresse email</title>
    </head>
    <body>
        <h1>Votre adresse email a été confirmée avec succès !</h1>
        <p>Merci de vous être inscrit à notre newsletter. Vous recevrez désormais nos dernières actualités et offres spéciales.</p>
    </body>
    </html>
    <?php
} else {
    // Le token est invalide, on affiche un message d'erreur
    ?>
    <html>
    <head>
        <title>Erreur de confirmation</title>
    </head>
    <body>
        <h1>Erreur : le token de confirmation est invalide.</h1>
        <p>Veuillez réessayer ou contacter notre équipe pour obtenir de l'aide.</p>
    </body>
    </html>
    <?php
}