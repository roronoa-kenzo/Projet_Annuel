<?php
session_start();
require_once './serveur/database.php'; // Adapter le chemin vers votre fichier de configuration

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php');
    exit();
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $forum_id = $_POST['forum_id'];

     // Validation : vérifier que le titre n'est pas vide
     if (empty($title)) {
        $_SESSION['ErrorTitle'] = 'Le titre du post ne peut pas être vide.';
        header('Location: ./index.php');
        exit();
    }

    // Validation : vérifier que le contenu n'est pas vide
    if (empty($content)) {
        $_SESSION['ErrorContent'] = 'Le contenu du post ne peut pas être vide.';
        header('Location: ./index.php');
        exit();
    }

    // Validation : vérifier qu'un forum a bien été sélectionné
    if (empty($forum_id)) {
        $_SESSION['ErrorForum'] = 'Veuillez sélectionner un forum pour votre post.';
        header('Location: ./index.php');
        exit();
    }

    // Insertion du post dans la base de données
    try {
        $query = $pdo->prepare('INSERT INTO posts (title, content, user_id, forum_id, created_at) VALUES (:title, :content, :user_id, :forum_id, NOW())');
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':content', $content, PDO::PARAM_STR);
        $query->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $query->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
        
        if ($query->execute()) {
            $_SESSION['SuccessPost'] = 'Votre post a été créé avec succès.';
        } else {
            $_SESSION['ErrorPost'] = 'Une erreur est survenue lors de la création de votre post.';
        }
    } catch (PDOException $e) {
        $_SESSION['ErrorPost'] = 'Erreur de connexion à la base de données : ' . $e->getMessage();
    }

    header('Location: ./index.php');
    exit();
} else {
    // Rediriger si la méthode n'est pas POST
    header('Location: ./index.php');
    exit();
}
