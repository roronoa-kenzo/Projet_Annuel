<?php
session_start();
require_once('./../serveur/database.php');

//recuperation du post de l'user
$forum_id = $_SESSION['forum_id'];
$title = $_POST['title'];
$content = $_POST['content'];
$user_id = $_COOKIE['userId'];
$texte = $_POST['texte'];
$file = $_POST['file'];

var_dump($texte);
//debug 
if ($texte == "texte") {
    //verification
    if (empty($title) || empty($content) || $user_id) {
        //header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
        //$pdo = null;
        //exit();
    } else if (empty($form_id)) {
        //header('Location:./../view/Popular.php');
        //$pdo = null;
        //exit();
    }

    //verification

    $queryForum = $pdo->prepare('
                             SELECT 
                             id, name, description, background 
                             FROM 
                             forums 
                             WHERE 
                             id = :forum_id');

    $queryForum->bindValue(':forum_id', $forum_id, PDO::PARAM_INT);
    $queryForum->execute();
    $forum = $queryForum->fetch(PDO::FETCH_ASSOC);
    //verification

    if ($forum) {
        $queryPost = $pdo->prepare('
                    INSERT INTO 
                    posts (title, content, user_id, forum_id) 
                    VALUES 
                    (:title, :content, :user_id, :forum_id)');

        // Lier les paramètres
        $queryPost->bindParam(':title', $title);
        $queryPost->bindParam(':content', $content);
        $queryPost->bindParam(':user_id', $user_id);
        $queryPost->bindParam(':forum_id', $forum_id);

        if ($queryPost->execute()) {
            header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
            //$pdo = null;
            //exit();
        } else {
            //header('Location:./../view/Popular.php');
            //$pdo = null;
            //exit();
        }
    } else {
        //header('Location:./../view/Popular.php');
        //$pdo = null;
        //exit();
    }
} elseif ($file== "file") {
    
} else {
    //header('Location:./../view/Popular.php');
    //$pdo = null;
    //exit();
}