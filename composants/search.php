<?php
// Récupérer la requête utilisateur
include "./../serveur/database.php";
header('Content-Type: application/json');

$query = $_GET['q'] ?? '';
if (empty($query)) {
    echo json_encode([]);
    exit;
}
$resultsForums = [];
$resultsPosts = [];
$resultsComments = [];
try {
    // Rechercher dans les forums
    if (strpos($query, 'i/') === 0) {
        // Supprimer "i/" pour rechercher uniquement dans les forums
        $query = substr($query, 2);

        $stmtForums = $pdo->prepare("SELECT id, name AS title, 'forum' AS type FROM forums WHERE name LIKE :query LIMIT 5");
        $stmtForums->execute(['query' => '%' . $query . '%']);
        $resultsForums = $stmtForums->fetchAll();

    } else if (strpos($query, 'p/') === 0) {
        // Rechercher dans les posts (titre et contenu)
        $query = substr($query, 2);

        $stmtPosts = $pdo->prepare("
        SELECT id, title, 'post' AS type 
        FROM posts 
        WHERE title LIKE :query OR content LIKE :query 
        LIMIT 5
    ");
        $stmtPosts->execute(['query' => '%' . $query . '%']);
        $resultsPosts = $stmtPosts->fetchAll();
    } else if (strpos($query, 'c/') === 0) {
        $query = substr($query, 2);

        // Rechercher dans les commentaires (contenu uniquement)
        $stmtComments = $pdo->prepare("
        SELECT id, content AS title, 'comment' AS type 
        FROM comments 
        WHERE content LIKE :query 
        LIMIT 5
    ");
        $stmtComments->execute(['query' => '%' . $query . '%']);
        $resultsComments = $stmtComments->fetchAll();
    } else {
        $stmtForums = $pdo->prepare("SELECT id, name AS title, 'forum' AS type FROM forums WHERE name LIKE :query LIMIT 5");
        $stmtForums->execute(['query' => '%' . $query . '%']);
        $resultsForums = $stmtForums->fetchAll();
        $stmtPosts = $pdo->prepare("
        SELECT id, title, 'post' AS type 
        FROM posts 
        WHERE title LIKE :query OR content LIKE :query 
        LIMIT 5
    ");
        $stmtPosts->execute(['query' => '%' . $query . '%']);
        $resultsPosts = $stmtPosts->fetchAll();
        $stmtComments = $pdo->prepare("
        SELECT id, content AS title, 'comment' AS type 
        FROM comments 
        WHERE content LIKE :query 
        LIMIT 5
    ");
        $stmtComments->execute(['query' => '%' . $query . '%']);
        $resultsComments = $stmtComments->fetchAll();
    }
    // Combiner les résultats
    $results = array_merge($resultsForums, $resultsPosts, $resultsComments);

    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>