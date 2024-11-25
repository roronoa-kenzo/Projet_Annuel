<?php

// create_forum.php
session_start();
require_once './../serveur/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $forum_name = $_POST['forum_name'];
    $forum_description = $_POST['forum_description'];
    $selected_theme = $_POST['selected_theme'];
    $creator_id = $_SESSION['user_id'];
    
    $query = $pdo->prepare("INSERT INTO forums (name, description, background, creator_id) VALUES (:name, :description, :background, :creator_id)");
    
    // Liez chaque paramètre séparément avec bindParam
    $background_path = "./../public/css/" . $selected_theme . "_theme.css"; // Stocke le chemin vers le thème

    $query->bindParam(':name', $forum_name, PDO::PARAM_STR);
    $query->bindParam(':description', $forum_description, PDO::PARAM_STR);
    $query->bindParam(':background', $background_path, PDO::PARAM_STR);
    $query->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);

    // Exécute la requête
    $query->execute();

    $_SESSION['SuccessForum'] = "Le forum a été créé avec succès!";
    header("Location: ./../view/index.php"); // Redirigez vers l'index ou un autre endroit
    exit;
}

?>