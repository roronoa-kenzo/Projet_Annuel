<?php
session_start();
include './../serveur/database.php';

if (!empty($_SESSION['user_id']) && !empty($_POST['current_password']) && !empty($_POST['new_password'])) {
    $userId = $_SESSION['user_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($currentPassword, $user['password_hash'])) {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$newPasswordHash, $userId]);
        header("Location: ../profile.php?status=password_updated");
        exit();
    } else {
        echo "Mot de passe actuel incorrect.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}
?>
