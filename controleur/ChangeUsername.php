<?php
session_start();
include './../serveur/database.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Vous devez être connecté pour changer votre nom d'utilisateur.";
    header('Location: ./../view/profile.php');
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_username'])) {
    // Récupérer l'ID de l'utilisateur et le nouveau nom d'utilisateur
    $userId = $_SESSION['user_id'];
    $newUsername = trim($_POST['new_username']);

    // Validation du nouveau nom d'utilisateur
    if (empty($newUsername)) {
        $_SESSION['error_message'] = "Le nom d'utilisateur ne peut pas être vide.";
        header('Location: ./../view/profile.php');
        exit();
    }

    // Préparer la requête SQL pour vérifier si le nom d'utilisateur existe déjà
    $checkQuery = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :new_username");
    $checkQuery->bindParam(':new_username', $newUsername);
    $checkQuery->execute();

    if ($checkQuery->fetchColumn() > 0) {
        $_SESSION['error_message'] = "Ce nom d'utilisateur est déjà pris. Veuillez en choisir un autre.";
        header('Location: ./../view/profile.php');
        exit();
    }

    // Requête SQL pour mettre à jour le nom d'utilisateur dans la base de données
    $query = $pdo->prepare("UPDATE users SET username = :new_username WHERE id = :user_id");
    $query->bindParam(':new_username', $newUsername);
    $query->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($query->execute()) {
        // Mise à jour réussie
        $_SESSION['success_message'] = "Votre nom d'utilisateur a été mis à jour avec succès.";
        $_SESSION['username'] = $newUsername;  // Mettre à jour le username en session
        header('Location: ./../view/profile.php');
        exit();
    } else {
        // Erreur lors de la mise à jour
        $_SESSION['error_message'] = "Erreur lors de la mise à jour du nom d'utilisateur. Veuillez réessayer.";
        header('Location: ./../view/profile.php');
        exit();
    }
} else {
    // Si la méthode n'est pas POST ou le champ new_username n'est pas défini, rediriger
    $_SESSION['error_message'] = "Action invalide. Veuillez réessayer.";
    header('Location: ./../view/profile.php');
    exit();
}
