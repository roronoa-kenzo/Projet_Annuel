<?php 
include './database.php';
session_start();

$sql = "
SELECT * 
FROM tickets
ORDER BY 
    FIELD(priority, 'Critical', 'High', 'Medium', 'Low'),
    FIELD(status, 'Open', 'In Progress', 'Resolved', 'Closed'),
    created_at DESC
";

try {
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupérer tous les tickets
$tickets = $stmt->fetchAll();

// Retourner les données au format JSON
echo json_encode($tickets);

} catch (PDOException $e) {
die(json_encode(['error' => 'Erreur lors de la récupération des tickets : ' . $e->getMessage()]));
}