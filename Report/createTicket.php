<?php
session_start();
require_once './../serveur/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ./../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (empty($title) || empty($description)) {
        $_SESSION['ErrorTicket'] = 'Veuillez remplir tous les champs.';
        header('Location: ./../Report/createTicket.php');
        exit();
    }

    try {
        // Vérifier que l'utilisateur existe
        $stmt = $pdo->prepare('SELECT id FROM users WHERE id = :user_id');
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        if ($stmt->rowCount() === 0) {
            $_SESSION['ErrorTicket'] = 'Utilisateur introuvable. Impossible de créer un ticket.';
            header('Location: ./../Report/createTicket.php');
            exit();
        }

        // Insérer le ticket
        $stmt = $pdo->prepare('INSERT INTO ticket (user_id, title, description) VALUES (:user_id, :title, :description)');
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':title' => $title,
            ':description' => $description,
        ]);

        $_SESSION['SuccessTicket'] = 'Votre ticket a été créé avec succès.';
        header('Location: ./../Report/myTicket.php');
        exit();
    } catch (PDOException $e) {
        error_log('Erreur SQL lors de la création du ticket : ' . $e->getMessage());
        echo 'Erreur SQL : ' . $e->getMessage(); // À retirer en production
        $_SESSION['ErrorTicket'] = 'Une erreur est survenue lors de la création du ticket. Veuillez réessayer plus tard.';
        header('Location: ./../Report/createTicket.php');
        exit();
    }
}
?>
