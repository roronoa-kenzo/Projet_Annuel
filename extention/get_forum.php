<?php
require_once './../serveur/database.php'; // Remplacez par le chemin réel vers votre connexion PDO

try {

    // Requête pour récupérer les 3 premiers forums
    $stmt = $pdo->query("SELECT id, name, description, background, wallpaper FROM forums ORDER BY created_at ASC LIMIT 3");
    $forums = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les données en JSON
    header('Content-Type: application/json');
    echo json_encode($forums);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur du serveur : ' . $e->getMessage()]);
}
