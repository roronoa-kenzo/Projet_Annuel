<?php
// Activer l'affichage des erreurs (à désactiver en production)


// Inclure la connexion à la base de données
include './../serveur/database.php';

// Lire les données JSON envoyées
$input = json_decode(file_get_contents('php://input'), true);

// Vérifier si les données nécessaires sont présentes
if (isset($input['forum_id']) && isset($input['user_id']) && isset($input['action'])) {
    $forumId = $input['forum_id'];
    $userId = $input['user_id'];
    $action = $input['action'];

    try {
        if ($action === 'subscribe') {
            // Insérer l'abonnement dans la table forum_subscribers
            $insertQuery = "INSERT IGNORE INTO forum_subscribers (user_id, forum_id) VALUES (:user_id, :forum_id)";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->execute(['user_id' => $userId, 'forum_id' => $forumId]);
            echo json_encode(['success' => true, 'message' => 'Abonnement ajouté avec succès.']);
        } else if ($action === 'unsubscribe') {
            // Supprimer l'abonnement de la table forum_subscribers
            $deleteQuery = "DELETE FROM forum_subscribers WHERE user_id = :user_id AND forum_id = :forum_id";
            $stmt = $pdo->prepare($deleteQuery);
            $stmt->execute(['user_id' => $userId, 'forum_id' => $forumId]);
            echo json_encode(['success' => true, 'message' => 'Abonnement supprimé avec succès.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Action non reconnue.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'abonnement : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Paramètres manquants.']);
}
?>
