<?php
// like_post.php

header('Content-Type: application/json');
include './../serveur/database.php';

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['post_id'])) {
    $postId = $input['post_id'];

    // Remplacez ceci par l'ID de l'utilisateur connecté.
    // Par exemple, récupérez l'utilisateur à partir de la session PHP.
    $userId = 1; // Remplacez par la valeur appropriée.

    try {
        // Vérifiez d'abord si l'utilisateur a déjà liké ce post.
        $checkQuery = "SELECT * FROM post_reactions WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $pdo->prepare($checkQuery);
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        $existingReaction = $stmt->fetch();

        if ($existingReaction) {
            // Supprimer le like si l'utilisateur a déjà liké ce post
            $deleteQuery = "DELETE FROM post_reactions WHERE user_id = :user_id AND post_id = :post_id";
            $stmt = $pdo->prepare($deleteQuery);
            $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        
            echo json_encode(['success' => true, 'message' => 'Le like a été retiré.']);
        } else {
            // Insérer un like dans la table post_reactions.
            $insertQuery = "INSERT INTO post_reactions (user_id, post_id, is_like) VALUES (:user_id, :post_id, 1)";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        
            echo json_encode(['success' => true, 'message' => 'Like ajouté avec succès.']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du like.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Paramètre post_id manquant.']);
}
