<?php
include './database.php';


$ticket_id = $_POST['ticket_id'];

$statut = $_POST['statut'];

$priority = $_POST['priority'];

if (empty($ticket_id)) {
    //erreur 

} else if (empty($statut)) {
    //erreur 

} else if (empty($priority)) {
    //erreur 

}

$sql = "
    UPDATE tickets
    SET status = :status, 
        priority = :priority
    WHERE id = :ticket_id
";

try {
    $stmt = $pdo->prepare($sql);

    // Lier les paramètres avec bindParam
    $stmt->bindParam(':status', $statut, PDO::PARAM_STR);
    $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);

    // Exécuter la requête
    $stmt->execute();

    // Vérifier si la mise à jour a réussi
    if ($stmt->rowCount() > 0) {
        echo "Le ticket a été mis à jour avec succès.";
        header('Location: ./../Ticket_details.php?ticket=' .$ticket_id);

    } else {
        header('Location: ./../Ticket_details.php?ticket=' .$ticket_id);
    }
} catch (PDOException $e) {
    header('Location: ./../Ticket_details.php?ticket=' .$ticket_id);
}