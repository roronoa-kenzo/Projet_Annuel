<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';
// Récupération des abonnés confirmés
$query = "SELECT * FROM subscribers WHERE confirmed = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($subscriber = $result->fetch_assoc()) {
    $to = $subscriber['email'];
    echo "Adresse e-mail : $to\n";
    $subject = 'Newsletter';
    $message = file_get_contents('newsletter.html');
    echo "Contenu du courriel : $message\n";
    $headers = array(
        'From: Abyss <notification@abyss.boats>',
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'Content-Transfer-Encoding: 7bit'
    );
    $headers = implode("\r\n", $headers);
    echo "En-têtes : $headers\n";

    // Envoi du courriel
    if (mail($to, $subject, $message, $headers)) {
        echo "Courriel envoyé avec succès à $to\n";
    } else {
        echo "Erreur lors de l'envoi du courriel à $to\n";
    }
}