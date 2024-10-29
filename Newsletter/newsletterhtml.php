<?php
// Inclusion du fichier de connexion à la base de données
require_once './../serveur/database.php';
require_once 'vendor/autoload.php'; // SwiftMailer

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

$result = $conn->query($query);
$posts = array();
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

// Fermeture de la connexion à la base de données
$conn->close();

// Génération du contenu HTML de la newsletter
ob_start(); // Démarre la capture du tampon de sortie
?>
<html>
  <head>
    <title>Newsletter</title>
    <style>
      body {
        font-family: Arial, sans-serif;
      }
      ul {
        list-style: none;
        padding: 0;
        margin: 0;
      }
      li {
        padding: 10px;
        border-bottom: 1px solid #ccc;
      }
      h2 {
        font-weight: bold;
        margin-top: 0;
      }
    </style>
  </head>
  <body>
    <h1>Newsletter</h1>
    <ul>
      <?php foreach ($posts as $post) { ?>
        <li>
          <h2><?= htmlspecialchars($post['title']) ?></h2>
          <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        </li>
      <?php } ?>
    </ul>
  </body>
</html>
<?php
// Capture et assignation du contenu HTML généré
$messageContent = ob_get_clean();

// Configuration de SwiftMailer pour l'envoi d'e-mails via SMTP
$transport = (new Swift_SmtpTransport('ssl0.ovh.net', 587, 'tls'))
    ->setUsername('notification@abyss.boats')
    ->setPassword('MomoMail?');
$mailer = new Swift_Mailer($transport);

// Envoi à tous les abonnés confirmés
$query = "SELECT email FROM subscribers WHERE confirmed = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Envoi de la newsletter à chaque abonné
while ($subscriber = $result->fetch_assoc()) {
    $to = $subscriber['email'];

    // Création de l'e-mail avec SwiftMailer
    $message = (new Swift_Message('Votre newsletter Abyss'))
        ->setFrom(['notification@abyss.boats' => 'Abyss Boats'])
        ->setTo([$to])
        ->setBody($messageContent, 'text/html');

    // Envoi du message
    $result = $mailer->send($message);

    if ($result) {
        echo "Newsletter envoyée à $to<br>";
    } else {
        echo "Erreur lors de l'envoi à $to<br>";
    }
}
