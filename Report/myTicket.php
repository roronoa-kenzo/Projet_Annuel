<?php
session_start();
require_once './../serveur/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ./../view/login.php');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM tickets WHERE user_id = :user_id ORDER BY created_at DESC');
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Tickets</title>
    <link rel="stylesheet" href="./../public/css/style.css">
</head>
<body>
    <h1>Mes Tickets</h1>
    <a href="./../Report/createTicket.php">Créer un nouveau ticket</a>

    <?php if (empty($tickets)): ?>
        <p>Aucun ticket trouvé.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tickets as $ticket): ?>
                <li>
                    <strong><?php echo htmlspecialchars($ticket['title']); ?></strong>
                    <p><?php echo htmlspecialchars($ticket['description']); ?></p>
                    <p>Statut : <?php echo $ticket['status']; ?></p>
                    <p>Créé le : <?php echo $ticket['created_at']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
