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
        $stmt = $pdo->prepare('INSERT INTO tickets (user_id, title, description) VALUES (:user_id, :title, :description)');
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':title' => $title,
            ':description' => $description,
        ]);

        $_SESSION['SuccessTicket'] = 'Votre ticket a été créé avec succès.';
        header('Location: ./../Report/myTicket.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['ErrorTicket'] = 'Erreur lors de la création du ticket : ' . $e->getMessage();
        header('Location: ./../Report/createTicket.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Ticket</title>
    <link rel="stylesheet" href="./../public/css/style.css">
</head>
<body>
    <h1>Créer un nouveau ticket</h1>

    <?php if (isset($_SESSION['ErrorTicket'])): ?>
        <div class="error"><?php echo $_SESSION['ErrorTicket']; unset($_SESSION['ErrorTicket']); ?></div>
    <?php endif; ?>

    <form action="createTicket.php" method="POST">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>
        
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
        
        <button type="submit">Soumettre</button>
    </form>
</body>
</html>
