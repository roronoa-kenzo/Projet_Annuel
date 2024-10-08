<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

try {
    // Préparation de la requête pour récupérer les 5 posts les plus populaires
    $query = "
        SELECT p.*, COALESCE(pr.likes_count, 0) as likes_count 
        FROM posts p 
        LEFT JOIN (
            SELECT post_id, COUNT(*) as likes_count 
            FROM post_reactions 
            WHERE is_like = 1 
            GROUP BY post_id
        ) pr ON p.id = pr.post_id 
        ORDER BY pr.likes_count DESC 
        LIMIT 5
    ";
    
    // Exécution de la requête
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification s'il y a des résultats
    if ($result->num_rows > 0) {
        // Stockage des résultats dans un tableau
        $posts = array();
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        // Affichage des posts (exemple)
        foreach ($posts as $post) {
            echo "Titre : " . htmlspecialchars($post['title']) . "<br>";
            echo "Contenu : " . htmlspecialchars($post['content']) . "<br>";
            echo "Nombre de likes : " . $post['likes_count'] . "<br><br>";
        }
    } else {
        echo "Aucun post trouvé.";
    }
} catch (Exception $e) {
    // Gestion des erreurs
    echo "Erreur : " . $e->getMessage();
} finally {
    // Fermeture de la connexion
    $conn->close();
}
