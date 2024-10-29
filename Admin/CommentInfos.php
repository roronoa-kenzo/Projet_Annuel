<?php
require_once './composant/admin_check.php'; // Inclure le fichier qui vérifie l'accès admin
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Back Log</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="../public/image/png" href="../public/img/abyssicon.png">
    <?php include './../composants/navbar.php'; ?>
    <?php include './composant/database.php'; ?>
    <?php include './composant/sessionStart.php'; ?>

</head>
<?php
// Inclure la connexion à la base de données
// Préparer la requête pour récupérer tous les utilisateurs avec leur statut de connexion
$query = "
    SELECT c.content AS comment_content, c.created_at AS comment_date, u.id AS user_id, u.username, p.title AS post_title
    FROM comments c
    LEFT JOIN users u ON c.user_id = u.id
    LEFT JOIN posts p ON c.post_id = p.id
    ORDER BY c.created_at DESC";;

// Exécuter la requête
$stmt = $pdo->prepare($query);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <main class="container">
        <div class="black-frame">
            <h1>All comments by users</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

                <div class="post-container-admin">
                    <div class="iceberg-select">
                        <p>Recherche comments</p>
                        <input type="text" class="inpuTextAdmin" id="searchInput"
                            placeholder="Rechercher un utilisateur...">
                        <button id="searchButton">Rechercher</button> <!-- Bouton de recherche -->
                    </div>
                </div>

                <div class="users-list" id="usersList">
                    <!-- Les résultats de la recherche seront insérés ici via JavaScript -->
                    <?php
                    if (empty($comments)) { ?>
                        <div class="post-container-admin">
                            <div class="iceberg-select">
                                <p>No comments.</p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="post-container-admin">
                                <a class="userLien" href="CommentUser.php?user=<?= $comment['user_id'] ?>">
                                    <div class="iceberg-select">
                                        <span class="">
                                            Comment by:<?= htmlspecialchars($comment['username']) ?>
                                        </span><br>
                                        <span class="username">Tilte Post : <?= htmlspecialchars($comment['post_title']) ?></span><br>
                                        <span class="username">Description comment:
                                            <?= htmlspecialchars($comment['comment_content']) ?></span><br>
                                        <span class="username">Date creation :
                                            <?= htmlspecialchars($comment['comment_date']) ?></span>
                                    </div>
                            </div>
                            </a>
                        <?php endforeach;
                    } ?>
                </div>
            </div>
        </div>
    </main>
    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>