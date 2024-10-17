<?php
include './composant/database.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
if ($query) {
    // Préparez la requête pour rechercher les utilisateurs
    $stmt = $pdo->prepare("SELECT u.username, u.id, u.first_name, u.last_name, u.email, us.is_connected FROM users u LEFT JOIN user_sessions us ON u.id = us.user_id WHERE u.username LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ?");
    $stmt->execute(["%$query%", "%$query%", "%$query%"]);
} else {
    // Récupérer tous les utilisateurs
    $stmt = $pdo->query("SELECT u.username, u.id, u.first_name, u.last_name, u.email, us.is_connected FROM users u LEFT JOIN user_sessions us ON u.id = us.user_id");
}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($users);
?>
