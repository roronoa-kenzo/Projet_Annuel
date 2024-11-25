<?php
session_start();
require_once('./../serveur/database.php');
//recuperation du post de l'user
if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])) {
    $user_id = $_COOKIE['userId'];

    // Préparation de la requête SQL
    $stmt = $pdo->prepare("
            SELECT 
                posts.id, 
                posts.content, 
                posts.created_at, 
                posts.title, 
                forums.id AS forum_id, 
                forums.name AS forum_name, 
                users.username, 
                users.user_profile, 
                COUNT(DISTINCT comments.id) AS comment_count, 
                SUM(CASE WHEN post_reactions.is_like = TRUE THEN 1 ELSE 0 END) AS like_count
            FROM posts
            JOIN forums ON posts.forum_id = forums.id
            JOIN forum_subscribers ON forum_subscribers.forum_id = forums.id
            JOIN users ON posts.user_id = users.id
            LEFT JOIN comments ON comments.post_id = posts.id
            LEFT JOIN post_reactions ON post_reactions.post_id = posts.id
            WHERE forum_subscribers.user_id = :user_id
            GROUP BY posts.id, forums.id, users.id
            ORDER BY posts.created_at DESC
        ");
    $stmt->bindParam(':user_id', $user_id);

    // Exécution de la requête
    $stmt->execute();

    // Récupération des résultats
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Envoi des données sous forme JSON
    header('Content-Type: application/json');
    echo json_encode($posts);

    // Récupération des résultats
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    //redirection
}

