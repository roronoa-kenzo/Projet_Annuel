<?php 
include './database.php';

session_start(); 

try {
    // Connexion à la base de données via PDO
    if (!isset($_SESSION['user_id'])) {
        echo "Utilisateur non connecté.";
        exit();
    }
    $userId = intval($_SESSION['user_id']);  // Convertit en entier pour éviter les injections SQL
    if(isset(($_POST['CommentUser']))) {
        header('Location: ./../CommentUser.php?user='.$userId);
    }
    if(isset(($_POST['PostUser']))) {
        header('Location: ./../PostUser.php?user='.$userId);
    }

    // Vérifie si l'ID de l'utilisateur est envoyé via POST pour suppression
    if (isset($_POST['delete'])) {
        // Prépare la requête SQL pour vérifier si l'utilisateur existe
        $sql = "SELECT id FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Vérifie si l'utilisateur a été trouvé
        if ($stmt->rowCount() > 0) {
            // Prépare la requête pour supprimer l'utilisateur
            $sqlDelete = "DELETE FROM users WHERE id = :id";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->bindParam(':id', $userId, PDO::PARAM_INT);

            // Exécute la requête de suppression
            if ($stmtDelete->execute()) {
                header('Location: ./../UserInfo.php');
                exit();
            } else {
                echo "Erreur lors de la suppression de l'utilisateur.";
            }
        } else {
            echo "Utilisateur non trouvé.";
        }
    }

    // Vérifie si la demande concerne la mise à jour du statut d'administrateur
    if (isset($_POST['admin'])) {
        // Prépare la requête SQL pour récupérer l'état actuel de is_admin
        $sql = "SELECT is_admin FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $currentStatus = $stmt->fetchColumn();

        // Inverser l'état actuel de is_admin (0 -> 1, 1 -> 0)
        $newStatus = $currentStatus ? 0 : 1;

        // Prépare la requête pour mettre à jour la colonne is_admin
        $sqlUpdate = "UPDATE users SET is_admin = :newStatus WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':newStatus', $newStatus, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id', $userId, PDO::PARAM_INT);

        // Exécute la requête de mise à jour
        if ($stmtUpdate->execute()) {
            header('Location: ./../User.php?user=' . $userId);
            exit();
        } else {
            echo "Erreur lors de la mise à jour du statut administrateur.";
        }
    }

    // Vérifie si la demande concerne le bannissement
    if (isset($_POST['banni'])) {
        // Prépare la requête SQL pour récupérer l'état actuel de is_banned
        $sql = "SELECT is_banned FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $currentStatus = $stmt->fetchColumn();

        // Inverser l'état actuel de is_banned (0 -> 1, 1 -> 0)
        $newStatus = $currentStatus ? 0 : 1;

        // Prépare la requête pour mettre à jour la colonne is_banned
        $sqlUpdate = "UPDATE users SET is_banned = :newStatus WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':newStatus', $newStatus, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id', $userId, PDO::PARAM_INT);

        // Exécute la requête de mise à jour
        if ($stmtUpdate->execute()) {
            header('Location: ./../User.php?user=' . $userId);
            exit();
        } else {
            echo "Erreur lors de la mise à jour du statut de bannissement.";
        }
    }
    if (isset($_POST['forum_id'])) {
        // Récupérer l'ID du forum à supprimer
        $forumId = $_POST['forum_id'];
    
        // Préparer la requête de suppression
        $deleteQuery = "DELETE FROM forums WHERE id = :forum_id";
    
        // Préparer et exécuter la requête
        $stmtDelete = $pdo->prepare($deleteQuery);
        $stmtDelete->bindParam(':forum_id', $forumId, PDO::PARAM_INT);
    
        // Exécuter la requête et vérifier si la suppression a réussi
        if ($stmtDelete->execute()) {
            header('Location: ./../User.php?user=' . $userId);
        } else {
            echo "Une erreur est survenue lors de la suppression du forum.";
        }
    }

    if(isset($_POST['home'])){
        header('Location: ./../User.php?user=' . $userId);
    }
    if (isset($_POST['delete_post']) && isset($_POST['post_id'])) {
        $postId = $_POST['post_id'];
    
        // Préparer la requête de suppression
        $deleteQuery = "DELETE FROM posts WHERE id = :postId";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    
        var_dump($postId) ;
        if ($stmt->execute()) {
            header('Location: ./../User.php?user=' . $userId);
        } else {
            echo "Erreur lors de la suppression du post.";
        }
    }

    if (isset($_POST['delete_comment']) && isset($_POST['comment_id'])) {
        $commentId = $_POST['comment_id'];
    
        // Préparer la requête de suppression du commentaire
        $deleteCommentQuery = "DELETE FROM comments WHERE id = :commentId";
        $stmt = $pdo->prepare($deleteCommentQuery);
        $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo "Le commentaire a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du commentaire.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
