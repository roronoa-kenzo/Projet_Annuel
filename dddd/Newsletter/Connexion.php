<?php
// Connexion à la base de données
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "Abyss";

$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour obtenir les 5 derniers posts
$sql = "SELECT title, text, image FROM post ORDER BY idpost DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialisation du contenu de la newsletter
    $message = '
    <html>
    <head>
      <title>Newsletter ABYSS</title>
      <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .newsletter { max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 8px; }
        h2 { font-size: 20px; color: #0079d3; }
        p { font-size: 16px; color: #333; }
        img { max-width: 100%; height: auto; margin-top: 10px; }
        .post { margin-bottom: 30px; }
      </style>
    </head>
    <body>
      <div class="newsletter">
        <h1>Top 5 des derniers posts sur ABYSS</h1>';

    // Boucle pour ajouter chaque post à l'email
    while ($row = $result->fetch_assoc()) {
        $message .= '
        <div class="post">
          <h2>' . htmlspecialchars($row['title']) . '</h2>
          <p>' . nl2br(htmlspecialchars($row['text'])) . '</p>';
        if (!empty($row['image'])) {
            $message .= '<img src="' . htmlspecialchars($row['image']) . '" alt="Image du post">';
        }
        $message .= '</div>';
    }

    // Fermeture du HTML
    $message .= '
      </div>
    </body>
    </html>';
    
    // Requête pour récupérer tous les abonnés
    $sql_subscribers = "SELECT mail FROM users";
    $result_subscribers = $conn->query($sql_subscribers);

    if ($result_subscribers->num_rows > 0) {
        // Boucle pour envoyer l'email à chaque abonné
        while ($subscriber = $result_subscribers->fetch_assoc()) {
            $to = $subscriber['mail'];
            $subject = 'Newsletter ABYSS - Les derniers posts';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: abyss@example.com" . "\r\n";  // Remplace par une adresse valide

            // Envoi de l'email
            if (mail($to, $subject, $message, $headers)) {
                echo 'Newsletter envoyée avec succès à ' . $to . '<br>';
            } else {
                echo 'Échec de l\'envoi à ' . $to . '<br>';
            }
        }
    } else {
        echo "Aucun abonné trouvé.";
    }

} else {
    echo "Aucun post trouvé.";
}

$conn->close();
?>