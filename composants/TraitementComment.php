<?php
session_start();
require_once('./../serveur/database.php');
//recuperation du post de l'user
$Post_id = $_POST['Post_id'];
$content = $_POST['content'];
$user_id = $_COOKIE['userId'];
$texte = $_POST['texte'];
$file = $_POST['file'];
$parent_comment_id = isset($_POST['parent_comment_id']) ? $_POST['parent_comment_id'] : null;

if ($texte == "texte") {
    //verification
    if (empty($content) || $user_id) {
        //header('Location:./../view/Abyss-Post.php?Post='.$Post_id);
        //$pdo = null;
        //exit();
    } else if (empty($Post_id)) {
        //header('Location:./../view/Popular.php');
        //$pdo = null;
        //exit();
    }

    //verification
    $queryPost = $pdo->prepare('
        SELECT id, title, content 
        FROM posts 
        WHERE id = :post_id
    ');
    $queryPost->bindParam(':post_id', $Post_id);
    $queryPost->execute();
    $post = $queryPost->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        $queryComment = $pdo->prepare('
        INSERT INTO 
        comments (content, user_id, post_id, parent_comment_id)
        VALUES 
        (:content, :user_id, :post_id, :parent_comment_id)
    ');

        // Liaison des paramètres
        $queryComment->bindParam(':content', $content);
        $queryComment->bindParam(':user_id', $user_id);
        $queryComment->bindParam(':post_id', $Post_id);
        $queryComment->bindValue(':parent_comment_id', $parent_comment_id);


        if ($queryComment->execute()) {
            header('Location:./../view/Abyss-Post.php?Post='.$Post_id);
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
} elseif ($file == "file") {

} else {
    //header('Location:./../view/Popular.php');
    //$pdo = null;
    //exit();
}