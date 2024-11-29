<?php
include './database.php';
require './../../vendor/autoload.php'; // Charge les dépendances installées via Composer

$email_ticket = $_POST['email_ticket'];

$Objet_reponse = $_POST['Objet_reponse'];

$contenu = $_POST['contenu'];


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    // Configuration du serveur SMTP
    $mail->isSMTP();                                            // Utiliser le SMTP
    $mail->Host = 'smtp.example.com';                     // Adresse du serveur SMTP
    $mail->SMTPAuth = true;                                   // Activer l'authentification SMTP
    $mail->Username = 'votre_email@example.com';              // Nom d'utilisateur SMTP
    $mail->Password = 'votre_mot_de_passe';                   // Mot de passe SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Activer le cryptage TLS
    $mail->Port = 587;                                    // Port SMTP (TLS)

    // Destinataire
    $mail->setFrom('votre_email@example.com', 'Votre Nom');     // Adresse de l'expéditeur
    $mail->addAddress($email_ticket);                           // Adresse du destinataire

    // Contenu de l'email
    $mail->isHTML(true);                                        // Activer le format HTML
    $mail->Subject = $Objet_reponse;                            // Objet de l'email
    $mail->Body = $contenu;                                  // Corps de l'email
    $mail->AltBody = strip_tags($contenu);                      // Version texte brut (alternative)

    // Envoyer l'email
    $mail->send();
    echo 'L\'email a été envoyé avec succès.';
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
}
?>