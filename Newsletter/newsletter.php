<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Requête pour récupérer les 5 posts les plus populaires
$query = "
    SELECT p.* 
    FROM posts p 
    LEFT JOIN (
        SELECT post_id, COUNT(*) as likes_count 
        FROM post_reactions 
        WHERE is_like = 1 
        GROUP BY post_id
    ) pr ON p.id = pr.post_id 
    ORDER BY pr.likes_count DESC LIMIT 5
";
$result = mysqli_query($conn, $query);

// Stockage des résultats dans un tableau
$posts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

// Fermeture de la connexion
mysqli_close($conn);