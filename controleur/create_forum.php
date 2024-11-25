<?php

// create_forum.php
session_start();
require_once './../serveur/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $forum_name = $_POST['forum_name'];
    $forum_description = $_POST['forum_description'];
    $selected_theme = $_POST['selected_theme'];
    $creator_id = $_SESSION['user_id'];

    // Insertion du nouveau forum dans la table forums
    $query = $pdo->prepare("INSERT INTO forums (name, description, background, creator_id) VALUES (:name, :description, :background, :creator_id)");

    // Définition du chemin vers le thème sélectionné
    $background_path = "./../public/css/" . $selected_theme . "_theme.css";

    // Lier les paramètres
    $query->bindParam(':name', $forum_name, PDO::PARAM_STR);
    $query->bindParam(':description', $forum_description, PDO::PARAM_STR);
    $query->bindParam(':background', $background_path, PDO::PARAM_STR);
    $query->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);

    // Exécuter la requête d'insertion
    $query->execute();

    // Récupérer l'ID du forum nouvellement créé
    $forum_id = $pdo->lastInsertId();

    // Insertion de l'abonnement de l'utilisateur créateur dans la table forum_subscribers
    $subscribeQuery = $pdo->prepare("INSERT INTO forum_subscribers (user_id, forum_id, subscribed_at) VALUES (:user_id, :forum_id, NOW())");
    $subscribeQuery->bindParam(':user_id', $creator_id, PDO::PARAM_INT);
    $subscribeQuery->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);

    // Exécuter l'insertion d'abonnement
    $subscribeQuery->execute();

    // Confirmation et redirection
    $_SESSION['SuccessForum'] = "Le forum a été créé avec succès et vous y êtes maintenant abonné!";
    header("Location: ./../view/index.php"); // Redirigez vers l'index ou un autre endroit
    exit;
}

?>