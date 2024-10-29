<?php
// Inclusion du fichier de connexion à la base de données

$host = "localhost"; // Remplace par le nom de ton serveur
$dbname = "Abyss"; // Le nom de ta base de données
$username = "bddAbyss";
$password = "Fraise200307"; // Ton mot de passe MariaDB

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
    //echo "Échec de la connexion : " . $e->getMessage();

    // page d'eurreur
}

require_once './../serveur/sessionStart.php';

require_once './vendor/autoload.php'; // SwiftMailer


// Récupération de l'adresse e-mail (par exemple, à partir d'un formulaire)
$email = $_SESSION['email'];

// Validation de l'adresse e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Adresse e-mail invalide.');
    //eurreur
}

// Vérification si l'email existe déjà dans la base de données
$sql = "SELECT email FROM subscribers WHERE email = :email";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    //erreur page
}

// Récupérer le résultat
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // L'email existe dans la table
    echo "L'email existe déjà dans la base de données.";
    //erreur
} else {
    // L'email n'existe pas
    echo "L'email n'existe pas dans la base de données.";
    //eureur
}

// Génération du token de confirmation
$token = uniqid();
// Préparation de la requête d'insertion
$stmt = $pdo->prepare("INSERT INTO subscribers (email, confirmed, token) VALUES (:email, 0, :token)");
$stmt->bindParam(':email', $email);
$stmt->bindParam(':token', $token);
$stmt->execute();

// Configuration de SwiftMailer pour l'envoi des e-mails via SMTP
$transport = (new Swift_SmtpTransport('ssl0.ovh.net', 587, 'tls'))
    ->setUsername('notification@abyss.boats')
    ->setPassword('MomoMail?');
$mailer = new Swift_Mailer($transport);

// Création du message de confirmation
$subject = 'Confirmation de votre adresse email';

$message = 'Merci de confirmer votre adresse email en cliquant sur le lien suivant : <a href="https://abyss.boats/Newsletter/confirm.php?token=' . $token . '">cliquez pour confirmer</a>';


$body = '<html><body>';
$body .= '<p>' . $message . '</p>';
$body .= '</body></html>';

$emailMessage = (new Swift_Message($subject))
    ->setFrom(['notification@abyss.boats' => 'Abyss Boats'])
    ->setTo([$email])
    ->setBody($body, 'text/html'); // On envoie l'e-mail en HTML

// Envoi du message de confirmation
$result = $mailer->send($emailMessage);

if ($result) { ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./../public/css/style.css">
        <title>Envoyé</title>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100..700&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
    </head>

    <body class="body_secondary">
        <?php include './../composants/no_user_navbar.php'; ?>
        <div class="DivAllForm">
            <div class="h3Div">
                <h3 class="h3Register">Envoi de mail</h3>
            </div>
            <div class="Form">
                <div class="doubleDiv">
                    <div>
                        <label class="labelRegister">La confirmation est envoyée dans votre boîte mail</label>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>

    </html>
    <?php
} else {
    ?>
<!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./../public/css/style.css">
        <title>Eurrer Page</title>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100..700&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
    </head>

    <body class="body_secondary">
        <?php include './../composants/no_user_navbar.php'; ?>
        <div class="DivAllForm">
            <div class="h3Div">
                <h3 class="h3Register">Erreur Mail</h3>
            </div>
            <div class="Form">
                <div class="doubleDiv">
                    <div>
                        <label class="labelRegister">Contact support</label>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>

    </html>
    <?php

}

// Fermeture de la connexion à la base de données
$conn = null;

