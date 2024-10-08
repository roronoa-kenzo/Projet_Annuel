<?php
// Inclusion de l'autoload de SwiftMailer et du fichier de connexion à la base de données
require_once 'vendor/autoload.php';
require_once 'co_database.php';

// Configuration du transport SMTP via SwiftMailer
$transport = (new Swift_SmtpTransport('ssl0.ovh.net', 587))
    ->setUsername('notification@abyss.boats')
    ->setPassword('MomoMail?');

// Création de l'instance Swift_Mailer avec le transport SMTP
$mailer = new Swift_Mailer($transport);

try {
    // Récupération des abonnés confirmés
    $query = "SELECT email FROM subscribers WHERE confirmed = 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification s'il y a des abonnés confirmés
    if ($result->num_rows > 0) {
        while ($subscriber = $result->fetch_assoc()) {
            $to = filter_var($subscriber['email'], FILTER_VALIDATE_EMAIL);
            
            if ($to) {
                echo "Adresse e-mail : $to\n";
                $subject = 'Newsletter';

                // Lecture du fichier HTML contenant le contenu de la newsletter
                $messageContent = file_get_contents('newsletter.html');
                if ($messageContent === false) {
                    throw new Exception('Erreur lors de la lecture du fichier de la newsletter.');
                }

                // Création du message avec SwiftMailer
                $message = (new Swift_Message($subject))
                    ->setFrom(['notification@abyss.boats' => 'Abyss Boats'])
                    ->setTo([$to])
                    ->setBody($messageContent, 'text/html');

                // Envoi du message via SwiftMailer
                $result = $mailer->send($message);

                if ($result) {
                    echo "Courriel envoyé avec succès à $to\n";
                } else {
                    echo "Erreur lors de l'envoi du courriel à $to\n";
                }
            } else {
                echo "Adresse e-mail invalide pour l'abonné : {$subscriber['email']}\n";
            }
        }
    } else {
        echo "Aucun abonné confirmé trouvé.\n";
    }
} catch (Exception $e) {
    // Gestion des erreurs de base de données ou de lecture de fichier
    echo "Erreur : " . $e->getMessage() . "\n";
} finally {
    // Fermeture de la connexion à la base de données
    $stmt->close();
    $conn->close();
}
