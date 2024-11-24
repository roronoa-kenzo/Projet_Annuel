<?php
session_start();
require_once './../serveur/database.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ./../view/index.php');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM tickets ORDER BY created_at DESC');
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare('UPDATE tickets SET status = :status WHERE id = :id');
    $stmt->execute([
        ':status' => $status,
        ':id' => $ticket_id,
    ]);

    $_SESSION['SuccessManage'] = 'Le ticket a été mis à jour.';
    header('Location: ./../Report/manageTicket.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Tickets</title>
    <link rel="stylesheet" href="./../public/css/style.css">
</head>
<body>
    <h1>Gérer les Tickets</h1>

    <?php if (isset($_SESSION['SuccessManage'])): ?>
        <div class="success"><?php echo $_SESSION['SuccessManage']; unset($_SESSION['SuccessManage']); ?></div>
    <?php endif; ?>

    <ul>
        <?php foreach ($tickets as $ticket): ?>
            <li>
                <strong><?php echo htmlspecialchars($ticket['title']); ?></strong>
                <p><?php echo htmlspecialchars($ticket['description']); ?></p>
                <p>Statut actuel : <?php echo $ticket['status']; ?></p>
                <form action="manageTickets.php" method="POST">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                    <select name="status">
                        <option value="Open" <?php if ($ticket['status'] === 'Open') echo 'selected'; ?>>Open</option>
                        <option value="In Progress" <?php if ($ticket['status'] === 'In Progress') echo 'selected'; ?>>In Progress</option>
                        <option value="Resolved" <?php if ($ticket['status'] === 'Resolved') echo 'selected'; ?>>Resolved</option>
                        <option value="Closed" <?php if ($ticket['status'] === 'Closed') echo 'selected'; ?>>Closed</option>
                    </select>
                    <button type="submit">Mettre à jour</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
