<?php
// Inclure la connexion à la base de données
session_start();
include './../../serveur/database.php';

if (isset($postId)) {
    $userId = $_SESSION['user_id'];
    try {
        // Requête pour vérifier si l'utilisateur a déjà liké ce post
        $checkQuery = "SELECT * FROM post_reactions WHERE user_id = :user_id AND post_id = :post_id AND is_like = 1";
        $stmt = $pdo->prepare($checkQuery);
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        $existingReaction = $stmt->fetch();

        if ($existingReaction) {
            $_SESSION['buttonred'] = "liked"; // Ajoute la classe 'liked' si le like existe
        }
    } catch (Exception $e) {
        // Gérer l'erreur si nécessaire (par exemple, enregistrer dans un journal)
    }
}
