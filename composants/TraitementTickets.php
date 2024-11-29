<?php

include './../serveur/database.php';

$email = $_POST['emailTiket'];
$priority = $_POST['priority'];
$ticket_tilte = $_POST['tilte'];
$tiket_content = $_POST['tiket'];

echo $email . '<br>';
echo $priority . '<br>';
echo $ticket_tilte . '<br>';
echo $tiket_content . '<br>';

if (empty($email)) {
    //renvoye page tikets
} elseif (empty($priority)) {
    //renvoye page tikets
} elseif (empty($ticket_tilte)) {
    //renvoye page tikets
} elseif (empty($tiket_content)) {
    //renvoye page tikets
}
$sql = "
    INSERT INTO tickets (email, title, description, priority) 
    VALUES (:email, :title, :description, :priority);
";

try {
    $stmt = $pdo->prepare($sql);

    // Lier les paramètres avec bindParam
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':title', $ticket_tilte);
    $stmt->bindParam(':description', $tiket_content);
    $stmt->bindParam(':priority', $priority);

    // Exécuter la requête
    $stmt->execute();

    // Vérifier si l'insertion a réussi
    if ($stmt->rowCount() > 0) {
        header('Location: ./../view/Ticket_complets.php');
        exit;
    } else {
        $_SESSION['SuccessMessage'] = 'Eurreur lors du remplissage du champs veuilliez resaisir le ticket';
        header('Location: ./../view/Ticket_complets.php');
        // pas bon revoyer erreur        exit;
        exit;

    }
} catch (PDOException $e) {
    $_SESSION['SuccessMessage'] = 'Eurreur lors du remplissage du champs veuilliez resaisir le ticket';
    header('Location: ./../view/Ticket_complets.php');
    exit;

}
?>