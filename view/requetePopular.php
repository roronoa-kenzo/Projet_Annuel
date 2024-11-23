<?php
include './../serveur/database.php';

header('Content-Type: application/json');

// Requête pour obtenir les 10 forums les plus populaires
$query = "
    SELECT 
        forums.id AS forum_id, 
        forums.name AS forum_name, 
        forums.description AS forum_description, 
        forums.background, 
        COUNT(posts.id) AS post_count,
        users.username AS creator_username,
        users.user_profile AS creator_profile_picture
    FROM 
        forums
    LEFT JOIN 
        posts ON forums.id = posts.forum_id
    LEFT JOIN 
        users ON forums.creator_id = users.id
    GROUP BY 
        forums.id
    ORDER BY 
        post_count DESC
    LIMIT 10
";

$stmt = $pdo->query($query);
$forums = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Construction de la réponse JSON
$response = [];

foreach ($forums as $forum) {
    $response[] = [
        'forum_id' => $forum['forum_id'],
        'forum_name' => htmlspecialchars($forum['forum_name']),
        'forum_description' => htmlspecialchars($forum['forum_description']),
        'post_count' => $forum['post_count'],
        'creator' => [
            'username' => htmlspecialchars($forum['creator_username'] ?? 'Utilisateur supprimé'),
            'profile_picture' => htmlspecialchars($forum['creator_profile_picture'] ?? './default-profile.png')
        ]
    ];
}

echo json_encode($response);
?>
