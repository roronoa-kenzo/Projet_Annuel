<?php
// Inclure la connexion à la base de données
require_once './composant/admin_check.php'; // Inclure le fichier qui vérifie l'accès admin
include './composant/database.php';
include './composant/sessionStart.php';

// Vérifier si l'ID de l'utilisateur est passé dans l'URL
if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $userId = $_GET['user'];

    // Préparer la requête pour récupérer tous les commentaires de l'utilisateur
    $commentsQuery = "
        SELECT c.id AS comment_id, c.content AS comment_content, p.title AS post_title
        FROM comments c
        JOIN posts p ON c.post_id = p.id
        WHERE c.user_id = :userId
    ";
    $commentsStmt = $pdo->prepare($commentsQuery);
    $commentsStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $commentsStmt->execute();
    $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <?php
    include './../composants/header.php';
    ?>

    <body>
        <?php include './../composants/navbar.php'; ?>
        <main class="container">
            <div class="black-frame">
                <h1>Commentaires de <?= htmlspecialchars($user['username']) ?></h1>
            </div>
            <div class="main-index">
                <?php include './composant/white_content_left-admin.php'; ?>
                <div class="white-content-admin">
                    <?php if (!empty($comments)) { ?>
                        <?php foreach ($comments as $comment) { ?>
                            <div class="post-container-admin">
                                <div class="iceberg-select">
                                    <h4>Post : <?= htmlspecialchars($comment['post_title']) ?></h4>
                                    <p><?= htmlspecialchars($comment['comment_content']) ?></p>

                                    <!-- Formulaire de suppression du commentaire -->
                                    <form action="./composant/OptionUser.php" method="POST">
                                        <input type="hidden" name="comment_id" value="<?= $comment['comment_id'] ?>">
                                        <input type="hidden" name="clickComment" value="clickComment">
                                        <button type="submit" name="delete_comment" class="delete-button">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p>Aucun commentaire trouvé pour cet utilisateur.</p>
                    <?php } ?>
                </div>
                <?php include './composant/white_content_right-admin.php'; ?>
            </div>
        </main>
    </body>

    </html>
    <?php
} else {
    echo "ID utilisateur invalide.";
}
?>