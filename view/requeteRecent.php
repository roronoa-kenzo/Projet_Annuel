<?php

header('Content-Type: application/json');


include './../serveur/database.php';

$query = "
SELECT 
    id,
    name,
    description,
    background,
    creator_id,
    created_at
FROM 
    forums
ORDER BY 
    created_at DESC
LIMIT 20;

SELECT 
    id,
    title,
    content,
    image,
    user_id,
    forum_id,
    created_at
FROM 
    posts
ORDER BY 
    created_at DESC
LIMIT 20;
";

$queryII = $pdo->query($query);
$ForumPost = $queryII ->fetchAll(PDO::FETCH_ASSOC);

$response = [];

foreach($ForumPost as $ForumPosts){
    $response = [
        ''
    ];
}