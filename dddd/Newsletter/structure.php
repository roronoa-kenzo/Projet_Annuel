<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .newsletter {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        .post {
            margin-bottom: 15px;
        }
        .post h3 {
            font-size: 18px;
            color: #0079d3;
        }
        .post a {
            text-decoration: none;
            color: #0079d3;
        }
        .post a:hover {
            text-decoration: underline;
        }
    </style>
    <title>Newsletter ABYSS</title>
</head>
<body>

<div class="newsletter">
    <h1>Top 5 des posts les plus populaires sur ABYSS</h1>

    <?php
    // Boucle pour afficher les posts récupérés de la base de données
    foreach ($posts as $post) {
        echo '<div class="post">';
        echo '<h3>' . $post['title'] . '</h3>';
        echo '<p>Votes: ' . $post['votes'] . '</p>';
        echo '<a href="' . $post['link'] . '">Lire plus</a>';
        echo '</div>';
    }
    ?>
</div>

</body>
</html>
