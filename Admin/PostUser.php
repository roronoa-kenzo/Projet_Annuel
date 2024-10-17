<?php
// Inclure la connexion à la base de données
include './composant/database.php';
include './composant/sessionStart.php';

// Vérifier si l'ID de l'utilisateur est passé dans l'URL
if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $userId = $_GET['user'];

    // Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
    $query = "SELECT * FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user_id'] = $user['id'];

    // Si l'utilisateur existe, afficher ses informations
    if ($user) {
        // Préparer la requête pour récupérer tous les posts de l'utilisateur avec le forum correspondant
        $postsQuery = "
            SELECT p.id AS post_id, p.title AS post_title, p.content AS post_content, f.name AS forum_name, f.description AS forum_description
            FROM posts p
            JOIN forums f ON p.forum_id = f.id
            WHERE p.user_id = :userId
        ";
        $postsStmt = $pdo->prepare($postsQuery);
        $postsStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $postsStmt->execute();
        $posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../public/css/style.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <title>Profil de <?= htmlspecialchars($user['username']) ?></title>
            <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
                rel="stylesheet">
            <link rel="icon" type="../public/image/png" href="../public/img/abyssicon.png">
            <?php include './../composants/navbar.php'; ?>
        </head>

        <body>
            <main class="container">
                <div class="black-frame">
                    <h1>Posts de <?= htmlspecialchars($user['username']) ?></h1>
                </div>
                <div class="main-index">
                    <?php include './composant/white_content_left-admin.php'; ?>
                    <div class="white-content-admin">

                        <?php if (!empty($posts)) { ?>
                            <?php foreach ($posts as $post) { ?>
                                <div class="post-container-admin">
                                    <div class="iceberg-select">
                                        <h4>Forum : <?= htmlspecialchars($post['forum_name']) ?>
                                            <?= htmlspecialchars($post['forum_description']) ?>
                                        </h4>
                                        <p><?= htmlspecialchars($post['post_title']) ?></p>
                                        <p><?= htmlspecialchars($post['post_content']) ?></p>
                                        <form action="./composant/OptionUser.php" method="POST">
                                            <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                                            <button type="submit" name="delete_post" class="delete-button">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p>Aucun post trouvé pour cet utilisateur.</p>
                        <?php } ?>

                    </div>
                    <?php include './composant/white_content_right-admin.php'; ?>
                </div>
            </main>
        </body>

        </html>
        <?php
    } else {
        echo "Utilisateur introuvable.";
    }
} else {
    echo "ID utilisateur invalide.";
}
?>