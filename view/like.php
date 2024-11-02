<?php
session_start();
require_once './../serveur/database.php'; // Adapter le chemin vers votre fichier de configuration

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['user_id'];

// Si le formulaire de like est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];

    // Vérifier si l'utilisateur a déjà liké le post
    $query = $pdo->prepare('SELECT is_like FROM post_reactions WHERE post_id = :postId AND user_id = :userId');
    $query->execute(['postId' => $postId, 'userId' => $userId]);
    $reaction = $query->fetch();

    if ($reaction) {
        // Si l'utilisateur a déjà liké, inverser le statut (1 devient 0 et 0 devient 1)
        $newStatus = $reaction['is_like'] == 1 ? 0 : 1;
        $update = $pdo->prepare('UPDATE post_reactions SET is_like = :status WHERE post_id = :postId AND user_id = :userId');
        $update->execute(['status' => $newStatus, 'postId' => $postId, 'userId' => $userId]);
    } else {
        // Si c'est le premier like, insérer un nouveau like avec le statut 1
        $newStatus = 1;
        $insert = $pdo->prepare('INSERT INTO post_reactions (post_id, user_id, is_like) VALUES (:postId, :userId, :status)');
        $insert->execute(['postId' => $postId, 'userId' => $userId, 'status' => $newStatus]);
    }

    // Rediriger pour éviter la resoumission du formulaire
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>