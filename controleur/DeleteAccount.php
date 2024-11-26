<?php
session_start();
include './../serveur/database.php';

if (!empty($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$userId])) {
        session_unset();
        session_destroy();
        header("Location: ../index.php?status=account_deleted");
        exit();
    } else {
        echo "Erreur lors de la suppression du compte.";
    }
} else {
    echo "Utilisateur non connecté.";
}
?>
