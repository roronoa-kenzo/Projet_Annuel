<?php
// Inclure la connexion à la base de données
include './composant/database.php';

// Vérifier si le paramètre 'query' est passé
if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];

    // Préparer la requête SQL avec LIKE pour rechercher dans plusieurs colonnes
    $query = "
        SELECT u.username, u.id, u.first_name, u.last_name, u.email, us.is_connected
        FROM users u
        LEFT JOIN user_sessions us ON u.id = us.user_id
        WHERE u.username LIKE :searchTerm
        OR u.first_name LIKE :searchTerm
        OR u.last_name LIKE :searchTerm
        OR u.email LIKE :searchTerm
    ";

    // Exécuter la requête avec le terme de recherche
    $stmt = $pdo->prepare($query);
    $likeSearchTerm = '%' . $searchTerm . '%';
    $stmt->bindParam(':searchTerm', $likeSearchTerm, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les résultats au format JSON
    echo json_encode($users);
}
?>
