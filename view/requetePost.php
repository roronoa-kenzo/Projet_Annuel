<?php
include './../serveur/database.php';

header('Content-Type: application/json');

if (isset($_GET['Post'])) {
    $postId = $_GET['Post'];

    // Sécurité : Vérifier que l'ID est un entier positif
    if (!filter_var($postId, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        echo json_encode(['success' => false, 'error' => 'ID de post invalide.']);
        exit;
    }

    // Requête pour récupérer les informations du post et de l'utilisateur qui a créé le post
    $postQuery = "
        SELECT 
            posts.id,
            posts.title,
            posts.content,
            posts.image,
            posts.user_id,
            posts.forum_id,
            users.username AS post_author_username,
            users.user_profile AS post_author_profile_picture
        FROM 
            posts
        LEFT JOIN 
            users ON posts.user_id = users.id
        WHERE 
            posts.id = :Post
    ";
    $postStmt = $pdo->prepare($postQuery);
    $postStmt->execute(['Post' => $postId]);
    $post = $postStmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Récupérer les informations du forum
        $forumQuery = "SELECT * FROM forums WHERE id = :forum_id";
        $forumStmt = $pdo->prepare($forumQuery);
        $forumStmt->execute(['forum_id' => $post['forum_id']]);
        $forum = $forumStmt->fetch(PDO::FETCH_ASSOC);

        // Récupérer les commentaires associés au post
        $commentsQuery = "
            SELECT 
                comments.id,
                comments.content,
                comments.created_at,
                users.username AS author_username,
                users.user_profile AS author_profile_picture
            FROM 
                comments
            LEFT JOIN 
                users ON comments.user_id = users.id
            WHERE 
                comments.post_id = :post_id
            ORDER BY 
                created_at DESC
        ";
        $commentsStmt = $pdo->prepare($commentsQuery);
        $commentsStmt->execute(['post_id' => $postId]);
        $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Construire la réponse JSON
        $response = [
            'success' => true,
            'post' => [
                'id' => $post['id'],
                'title' => htmlspecialchars($post['title']),
                'content' => htmlspecialchars($post['content']),
                'image' => htmlspecialchars($post['image'] ?? ''),
                'user_id' => $post['user_id'],
                'forum_id' => $post['forum_id'],
                'author' => [
                    'username' => htmlspecialchars($post['post_author_username'] ?? 'Utilisateur supprimé'),
                    'profile_picture' => htmlspecialchars($post['post_author_profile_picture'] ?? './default-profile.png')
                ]
            ],
            'forum' => [
                'name' => htmlspecialchars($forum['name']),
                'description' => htmlspecialchars($forum['description']),
                'background' => htmlspecialchars($forum['background'])
            ],
            'comments' => array_map(function ($comment) {
                return [
                    'id' => $comment['id'],
                    'content' => htmlspecialchars($comment['content']),
                    'created_at' => $comment['created_at'],
                    'author_username' => htmlspecialchars($comment['author_username'] ?? 'Utilisateur supprimé'),
                    'author_profile_picture' => htmlspecialchars($comment['author_profile_picture'] ?? './default-profile.png')
                ];
            }, $comments)
        ];

        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'error' => 'Post non trouvé.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Aucun post spécifié.']);
}
?>
