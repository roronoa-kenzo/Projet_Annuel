<?php
session_start();
<<<<<<< HEAD
require_once './../serveur/database.php';
require_once './../composants/expSysteme/xpSystem.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php');
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $postId = intval($_POST['post_id']); // Assurez-vous que c'est un entier valide

    try {
        // Vérifier si une réaction existe déjà pour cet utilisateur et ce post
        $query = $pdo->prepare('SELECT is_like FROM post_reactions WHERE post_id = :postId AND user_id = :userId');
        $query->execute(['postId' => $postId, 'userId' => $userId]);
        $reaction = $query->fetch(PDO::FETCH_ASSOC);
        if (!$reaction) {
            // Si aucune réaction n'existe, insérer une nouvelle avec le statut "like"
            $insert = $pdo->prepare('INSERT INTO post_reactions (post_id, user_id, is_like) VALUES (:postId, :userId, 1)');
            echo "oui";
            $success = $insert->execute(['postId' => $postId, 'userId' => $userId]);

            if ($success) {
                // Attribuer de l'XP pour un nouveau "like"
                $xpReward = 5; // XP gagnée pour un "like"
                updateXP($userId, $xpReward, $pdo);
                $_SESSION['XPNotification'] = "Vous avez gagné $xpReward XP pour votre like !";
            }
        } else {
            // Si une réaction existe déjà, aucun traitement supplémentaire
            $_SESSION['InfoLike'] = 'Vous avez déjà réagi à ce post.';
        }

        // Message de succès
        $_SESSION['Successlike'] = 'Votre réaction a été enregistrée.';
    } catch (PDOException $e) {
        error_log('Erreur lors de la gestion du like : ' . $e->getMessage());
        $_SESSION['Errorlike'] = "Une erreur est survenue. Veuillez réessayer.";
    }

    // Rediriger vers la page précédente
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
    //exit();
} else {
    // Rediriger si la méthode n'est pas POST ou si post_id est manquant
    //header('Location: ./index.php');
    //exit();
}
?>
=======
include './../serveur/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    $_SESSION['like_message'] = "Requête non valide.";
    header('Location: index.php');
    exit;
}

$userId = $_SESSION['user_id'];
$postId = intval($_POST['post_id']);

// Vérifie si l'utilisateur a déjà liké
$query = $pdo->prepare('SELECT is_like FROM post_reactions WHERE post_id = :postId AND user_id = :userId');
$query->execute(['postId' => $postId, 'userId' => $userId]);
$reaction = $query->fetch();

if ($reaction && $reaction['is_like'] == 1) {
    // Si déjà liké, on supprime le "like"
    $query = $pdo->prepare('DELETE FROM post_reactions WHERE post_id = :postId AND user_id = :userId');
    $query->execute(['postId' => $postId, 'userId' => $userId]);
} else {
    // Ajout d'un "like"
    $query = $pdo->prepare('REPLACE INTO post_reactions (post_id, user_id, is_like) VALUES (:postId, :userId, 1)');
    $query->execute(['postId' => $postId, 'userId' => $userId]);
}

header('Location: index.php');
exit;

>>>>>>> 6c5918325d16a837befc5505171ae0c6bd844591
