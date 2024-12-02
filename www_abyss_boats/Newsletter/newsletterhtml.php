<?php
// Inclusion du fichier de connexion à la base de données et des dépendances
require_once './../serveur/database.php';
require_once './vendor/autoload.php'; // SwiftMailer

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

// Récupération des posts populaires
$query = "
    SELECT p.*, COALESCE(pr.likes_count, 0) as likes_count 
    FROM posts p 
    LEFT JOIN (
        SELECT post_id, COUNT(*) as likes_count 
        FROM post_reactions 
        WHERE is_like = 1 
        GROUP BY post_id
    ) pr ON p.id = pr.post_id 
    ORDER BY pr.likes_count DESC 
    LIMIT 5
";
$stmt = $pdo->query($query);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Génération du contenu HTML de la newsletter
ob_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Abyss</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #fff;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
        }
        h2 {
            margin: 0;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Top 5 des posts populaires</h1>
    <ul>
        <?php foreach ($posts as $post) { ?>
            <li>
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <p><strong>Likes :</strong> <?= $post['likes_count'] ?></p>
            </li>
        <?php } ?>
    </ul>
</body>
</html>
<?php
$messageContent = ob_get_clean();

// Configuration de SwiftMailer pour l'envoi d'e-mails
$transport = (new Swift_SmtpTransport('ssl0.ovh.net', 587, 'tls'))
    ->setUsername('notification@abyss.boats')
    ->setPassword('MomoMail?');
$mailer = new Swift_Mailer($transport);

// Récupération des abonnés confirmés
$query = "SELECT email FROM subscribers WHERE confirmed = 1";
$stmt = $pdo->query($query);
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Envoi de la newsletter à chaque abonné
foreach ($subscribers as $subscriber) {
    $to = $subscriber['email'];

    // Création de l'e-mail avec SwiftMailer
    $message = (new Swift_Message('Votre newsletter Abyss'))
        ->setFrom(['notification@abyss.boats' => 'Abyss Boats'])
        ->setTo([$to])
        ->setBody($messageContent, 'text/html');
        
    try {
        $result = $mailer->send($message);
        if ($result) {
            echo "Newsletter envoyée à $to<br>";
        } else {
            echo "Erreur lors de l'envoi à $to<br>";
        }
    } catch (Exception $e) {
        echo "Erreur d'envoi pour $to : " . $e->getMessage() . "<br>";
    }
}

// Fermeture de la connexion à la base de données
$pdo = null;