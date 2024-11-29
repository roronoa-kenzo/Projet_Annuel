<?php 

session_start();
include './../serveur/database.php'; // Connexion à la base de données via PDO

$user_id = $_SESSION['user_id']; // Récupération de l'ID utilisateur depuis la session
try {
    // Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
    $sql = "
        SELECT email, is_admin 
        FROM users 
        WHERE id = :user_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Récupérer les résultats
    $user = $stmt->fetch();

    $email = $user['email'];
    $is_admin = (int)$user['is_admin'];

    // Vérifier si l'email se termine par @abyss.boats
    if (str_ends_with($email, '@abyss.boats') && $is_admin === 1) {
        echo '<a class="btn-menu" href="./../Admin/Back-log.php">Back-log</a>';
    } 

} catch (PDOException $e) {
}
