<?php
// Inclusion du fichier de connexion à la base de données
require_once '../serveur/database.php';
require_once 'vendor/autoload.php'; // SwiftMailer

// Récupération de l'adresse e-mail (par exemple, à partir d'un formulaire)
$email = $_POST['email'];

// Validation de l'adresse e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Adresse e-mail invalide.');
}

// Vérification si l'email existe déjà dans la base de données
$query = "SELECT id FROM subscribers WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die('Cette adresse e-mail est déjà inscrite.');
}

// Génération du token de confirmation
$token = uniqid();

// Préparation de la requête d'insertion
$stmt = $conn->prepare("INSERT INTO subscribers (email, confirmed, token) VALUES (?, 0, ?)");
$stmt->bind_param("ss", $email, $token);
$stmt->execute();

// Configuration de SwiftMailer pour l'envoi des e-mails via SMTP
$transport = (new Swift_SmtpTransport('ssl0.ovh.net', 587, 'tls'))
    ->setUsername('notification@abyss.boats')
    ->setPassword('MomoMail?');
$mailer = new Swift_Mailer($transport);

// Création du message de confirmation
$subject = 'Confirmation de votre adresse email';
// $message = 'Merci de confirmer votre adresse email en cliquant sur le lien suivant : https://abyss.boats/confirm.php?token=' . $token;
$message = 'Merci de confirmer votre adresse email en cliquant sur le lien suivant : http://localhost/Newsletter/confirm.php?token=' . $token;
$body = '<html><body>';
$body .= '<p>' . $message . '</p>';
$body .= '</body></html>';

$emailMessage = (new Swift_Message($subject))
    ->setFrom(['notification@abyss.boats' => 'Abyss Boats'])
    ->setTo([$email])
    ->setBody($body, 'text/html'); // On envoie l'e-mail en HTML

// Envoi du message de confirmation
$result = $mailer->send($emailMessage);

if ($result) {
    echo 'Un e-mail de confirmation a été envoyé à votre adresse.';
} else {
    echo 'Erreur lors de l\'envoi de l\'e-mail.';
}

// Fermeture de la connexion à la base de données
$stmt->close();
$conn->close();
?>
