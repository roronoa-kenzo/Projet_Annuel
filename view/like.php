<?php
session_start();
include './../serveur/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    $_SESSION['like_message'] = "Requête non valide.";
    header('Location: index.php');
    exit;
}

$userId = $_SESSION['user_id'];
$postId = intval($_POST['post_id']);

// Vérifie si l'utilisateur a déjà liké
$query = $pdo->prepare('SELECT is_like FROM post_reactions WHERE post_id = :postId AND user_id = :userId');
$query->execute(['postId' => $postId, 'userId' => $userId]);
$reaction = $query->fetch();

if ($reaction && $reaction['is_like'] == 1) {
    // Si déjà liké, on supprime le "like"
    $query = $pdo->prepare('DELETE FROM post_reactions WHERE post_id = :postId AND user_id = :userId');
    $query->execute(['postId' => $postId, 'userId' => $userId]);
} else {
    // Ajout d'un "like"
    $query = $pdo->prepare('REPLACE INTO post_reactions (post_id, user_id, is_like) VALUES (:postId, :userId, 1)');
    $query->execute(['postId' => $postId, 'userId' => $userId]);
}

header('Location: index.php');
exit;

