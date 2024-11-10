<?php

// create_forum.php
session_start();
require_once './../serveur/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['forum_name']) && isset($_POST['forum_background'])) {
    $forumName = $_POST['forum_name'];
    $forumBackground = $_POST['forum_background']; // Ex: "css/themes/red.css"

    // Insertion du forum dans la base de données avec le chemin du fichier CSS dans 'background'
    $query = $pdo->prepare("INSERT INTO forums (name, background) VALUES (:name, :background)");
    $query->execute(['name' => $forumName, 'background' => $forumBackground]);

    $_SESSION['forum_background'] = $forumBackground; // Enregistrer en session pour l'utiliser immédiatement
    header('Location: index.php');
    exit;
}

?>