<?php

// create_forum.php
session_start();
require_once './../serveur/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $forum_name = $_POST['forum_name'];
    $forum_description = $_POST['forum_description'];
    $selected_theme = $_POST['selected_theme'];

    $query = $pdo->prepare("INSERT INTO forums (name, description, background) VALUES (:name, :description, :background)");
    $query->execute([
        'name' => $forum_name,
        'description' => $forum_description,
        'background' => "./../public/css/" . $selected_theme . "_theme.css" // Stocke le chemin vers le thème
    ]);

    $_SESSION['SuccessForum'] = "Le forum a été créé avec succès!";
    header("Location: ./../view/index.php"); // Redirigez vers l'index ou un autre endroit
    exit;
}

?>