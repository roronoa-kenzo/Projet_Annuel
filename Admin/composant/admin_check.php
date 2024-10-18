<?php
// Connexion à la base de données
require_once './composant/database.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si l'email est présent dans la session
if (!isset($_COOKIE['email'])) {
    // Si l'email n'est pas défini dans la session, rediriger vers la page d'accueil
    //session_unset();
    //session_destroy();
    header('Location: ./../view/index.php');
    exit();
}

// Récupérer l'email de l'utilisateur depuis la session
$user_email = $_COOKIE['email'];

// Préparer la requête pour récupérer les informations de l'utilisateur en fonction de son email
$query = "SELECT is_admin, email FROM users WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute(['email' => $user_email]);

// Récupérer les résultats
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe, s'il est admin et si l'email se termine par "@abyss.boats"
if (!$user || !$user['is_admin'] || !str_ends_with($user['email'], '@abyss.boats')) {
    // Si l'utilisateur n'existe pas, n'est pas admin ou n'a pas un email se terminant par "@abyss.boats"
    //session_unset();
    //session_destroy();
    header('Location: ./../view/index.php');
    exit();
}

// Le reste de votre code, si l'utilisateur est bien un admin avec une adresse email valide
?>
