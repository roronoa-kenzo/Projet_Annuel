<?php require_once './composant/admin_check.php'; ?>

<?php include './../composants/header.php'; ?>

<?php
include './composant/database.php';
session_start();
$id_ticket = $_GET['ticket'];

$sql = "SELECT * FROM tickets WHERE id = :id_ticket";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_ticket', $id_ticket, PDO::PARAM_INT);
    $stmt->execute();

    $ticket = $stmt->fetch();

    if (!$ticket) {
        die("Erreur : Aucun ticket trouvé avec l'ID $id_ticket.");
    }

} catch (PDOException $e) {
    die("Erreur lors de la récupération du ticket : " . $e->getMessage());
}
?>

<body>
    <?php
    include './../composants/navbar.php';
    ?>

    <main class="container">
        <div class="black-frame">
            <h1>tickets numero : <?php echo $ticket['id'] ?></h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">
                <div class="post-container-admin">

                    <form action="./composant/update_ticket.php" method="POST">
                    <input type="hidden" name="ticket_id" id="ticket_id" value="<?= $ticket['id'] ?>">

                        <h3>Titre du ticket : <?php echo '<br><br>' . $ticket['title']; ?></h3>

                        <p>Detaille du ticket :<br>
                            <?php echo $ticket['description']; ?>
                        </p>
                        <div style="display: flex;justify-content: space-between;">
                            <div>
                                <p>Statut du ticket :</p>
                                <p class="<?php echo htmlspecialchars($ticket['status']) ?>">
                                    <?php echo htmlspecialchars($ticket['status']) ?>
                                </p>
                                <select name="statut" style="height: 2rem;" id="statut" required>
                                    <option value="Open" <?php echo ($ticket['status'] === 'Open') ? 'selected' : '' ?>>
                                        Open</option>
                                    <option value="In Progress" <?php echo ($ticket['status'] === 'In Progress') ? 'selected' : '' ?>>In Progress</option>
                                    <option value="Resolved" <?php echo ($ticket['status'] === 'Resolved') ? 'selected' : '' ?>>Resolved</option>
                                    <option value="Closed" <?php echo ($ticket['status'] === 'Closed') ? 'selected' : '' ?>>Closed</option>
                                </select>

                            </div>
                            <div>

                                <p>Priorité du ticket :</p>
                                <p class="<?php echo htmlspecialchars($ticket['priority']) ?>">
                                    <?php echo htmlspecialchars($ticket['priority']) ?>
                                </p>
                                <select style="height: 2rem;" name="priority" id="priority" required>
                                    <option value="Low" <?php echo ($ticket['priority'] === 'Low') ? 'selected' : '' ?>>
                                        Low</option>
                                    <option value="Medium" <?php echo ($ticket['priority'] === 'Medium') ? 'selected' : '' ?>>Medium</option>
                                    <option value="High" <?php echo ($ticket['priority'] === 'High') ? 'selected' : '' ?>>
                                        High</option>
                                    <option value="Critical" <?php echo ($ticket['priority'] === 'Critical') ? 'selected' : '' ?>>Critical</option>
                                </select>

                            </div>

                        </div>
                        <div style="display: flex;justify-content: space-between;">
                            <p>Cree le :<br> <?php echo $ticket['created_at'] ?></p>
                            <p>Mise à jour le :<br> <?php echo $ticket['updated_at'] ?></p>
                        </div>
                        <div style="display: flex;justify-content: center;padding-top:20px">
                            <button class="btn-menu-admin" type="submit">mettre à jours</button>
                        </div>
                    </form>
                </div>

                <div class="post-container-admin">

                    <form action="./composant/reponse_ticket.php" method="POST">
                    <input type="hidden" name="email_ticket" id="email_ticket" value="<?= $ticket['email'] ?>">

                        <h3>Reponse à : <?php echo '<br><br>' . $ticket['email'] ?></h3>

                        <p>Objet de la reponse :<br></p>

                        <input name="Objet_reponse" type="text" class="inputTitle" required>

                        <p>Reponse au ticket :<br></p>

                        <textarea name="contenu" class="post-textarea" style="" required></textarea>

                        <div style="display: flex;justify-content: center;padding-top:20px">
                            <button class="btn-menu-admin" type="submit">envoyer mail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>