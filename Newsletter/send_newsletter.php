<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Récupération des abonnés confirmés
$query = "SELECT * FROM subscribers WHERE confirmed = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Envoi de la newsletter à chaque abonné confirmé
while ($subscriber = $result->fetch_assoc()) {
    $to = $subscriber['email'];
    $subject = 'Newsletter';
    $message = file_get_contents('newsletter.html');
    $headers = 'From: Abyss <your_email@example.com>' . "\r\n";

    // Envoi de l'email
    if (!mail($to, $subject, $message, $headers)) {
        echo "Error sending email to $to";
    }
}
?>