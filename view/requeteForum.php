<?php
header('Content-Type: application/json');

if (isset($_GET['forum_id'])) {
    $forumId = $_GET['forum_id'];

    if (!filter_var($forumId, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        echo json_encode(['error' => 'ID de forum invalide.']);
        exit;
    }

    include './../serveur/database.php';

    // Requête pour récupérer les informations du forum
    $query = "
        SELECT 
            forums.id AS forum_id,
            forums.name AS forum_name,
            forums.description AS forum_description,
            forums.background AS forum_background,
            forums.creator_id,
            users.username AS creator_username,
            users.user_profile AS creator_profile_picture
        FROM 
            forums
        LEFT JOIN 
            users ON forums.creator_id = users.id
        WHERE 
            forums.id = :forum_id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['forum_id' => $forumId]);
    $forum = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($forum) {
        // Requête pour récupérer les posts avec le nombre de commentaires, nom d'utilisateur et photo de profil de l'auteur
        $postsQuery = "
        SELECT 
            posts.id,
            posts.title,
            posts.content,
            posts.image,
            posts.created_at,
            (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comment_count,
            (SELECT COUNT(*) FROM post_reactions WHERE post_reactions.post_id = posts.id AND is_like = 1) AS like_count,
            users.username AS author_username,
            users.user_profile AS author_profile_picture
        FROM 
            posts
        LEFT JOIN 
            users ON posts.user_id = users.id
        WHERE 
            forum_id = :forum_id
        ORDER BY 
            like_count DESC, created_at DESC
    ";
    

        $postsStmt = $pdo->prepare($postsQuery);
        $postsStmt->execute(['forum_id' => $forumId]);
        $posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Construction de la réponse JSON
        $response = [
            'success' => true,
            'forum' => [
                'id' => $forum['forum_id'],
                'name' => htmlspecialchars($forum['forum_name']),
                'description' => htmlspecialchars($forum['forum_description']),
                'creator' => [
                    'username' => htmlspecialchars($forum['creator_username'] ?? 'Utilisateur supprimé'),
                    'profile_picture' => htmlspecialchars($forum['creator_profile_picture'] ?? './default-profile.png')
                ]
            ],
            'posts' => []
        ];

        // Ajout des informations des posts dans la réponse JSON
        foreach ($posts as $post) {
            $response['posts'][] = [
                'id' => $post['id'],
                'title' => htmlspecialchars($post['title']),
                'content' => htmlspecialchars($post['content']),
                'image' => htmlspecialchars($post['image'] ?? ''),
                'created_at' => $post['created_at'],
                'comment_count' => $post['comment_count'],
                'like_count' => $post['like_count'],
                'author' => [
                    'username' => htmlspecialchars($post['author_username'] ?? 'Utilisateur supprimé'),
                    'profile_picture' => htmlspecialchars($post['author_profile_picture'] ?? './default-profile.png')
                ]
            ];
        }

        echo json_encode($response);

    } else {
        echo json_encode(['success' => false, 'error' => 'Forum non trouvé.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Aucun forum spécifié.']);
}
?>