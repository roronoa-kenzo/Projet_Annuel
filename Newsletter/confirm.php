<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Récupération du token de confirmation via GET
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];

    // Vérification si le token est valide
    $stmt = mysqli_prepare($conn, "SELECT * FROM subscribers WHERE token = ?");
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        // Le token est valide, on met à jour le statut de l'abonné
        $stmt = mysqli_prepare($conn, "UPDATE subscribers SET confirmed = 1, token = NULL WHERE token = ?");
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
            <a href="index.php">Retour à l'accueil</a>
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
            <h1>Erreur : le token de confirmation est invalide ou déjà utilisé.</h1>
            <p>Veuillez vérifier le lien ou contacter notre équipe pour obtenir de l'aide.</p>
            <a href="index.php">Retour à l'accueil</a>
        </body>
        </html>
        <?php
    }
} else {
    // Si le token n'est pas fourni
    ?>
    <html>
    <head>
        <title>Erreur de confirmation</title>
    </head>
    <body>
        <h1>Erreur : aucun token de confirmation n'a été fourni.</h1>
        <p>Le lien que vous avez utilisé est invalide ou incomplet. Veuillez vérifier l'email ou contacter notre équipe pour obtenir de l'aide.</p>
        <a href="index.php">Retour à l'accueil</a>
    </body>
    </html>
    <?php
}

// Fermeture de la connexion
mysqli_close($conn);
