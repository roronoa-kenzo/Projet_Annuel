<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, détruire la session et rediriger vers l'index
    session_unset();
    session_destroy();
    header('Location: ./../view/index.php');
    exit();
}

// Connexion à la base de données
require_once './composant/database.php'; // Votre fichier de connexion à la base de données

// Récupérer l'ID de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];

// Préparer la requête pour récupérer les informations de l'utilisateur
$query = "SELECT is_admin, email FROM users WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $user_id]);

// Récupérer les résultats
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe, s'il est admin et si l'email se termine par "@abyss.boats"
if (!$user || !$user['is_admin'] || !str_ends_with($user['email'], '@abyss.boats')) {
    // Si l'utilisateur n'existe pas, n'est pas admin ou n'a pas un email se terminant par "@abyss.boats"
    session_unset();
    session_destroy();
    header('Location: ./../view/index.php');
    exit();
}

// Si l'utilisateur est admin, on continue normalement
