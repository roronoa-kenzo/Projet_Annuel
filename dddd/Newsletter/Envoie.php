<?php
$to = 'utilisateur@example.com';
$subject = 'Newsletter ABYSS - Les posts les plus populaires';
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: abyss@example.com" . "\r\n";

// Contenu HTML de la newsletter
$message = '
<html>
<head>
  <title>Newsletter ABYSS</title>
</head>
<body>
  <div class="newsletter">
    <h1>Top 5 des posts les plus populaires sur ABYSS</h1>';

// Boucle pour inclure les posts dans l'email
foreach ($posts as $post) {
    $message .= '<div class="post">';
    $message .= '<h3>' . $post['title'] . '</h3>';
    $message .= '<p>Votes: ' . $post['votes'] . '</p>';
    $message .= '<a href="' . $post['link'] . '">Lire plus</a>';
    $message .= '</div>';
}

$message .= '
  </div>
</body>
</html>
';

// Envoi de l'email
mail($to, $subject, $message, $headers);
?>
