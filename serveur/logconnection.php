<?php
// Fonction pour enregistrer la connexion de l'utilisateur
function loginUser($pdo, $user_id) {
    try {
        // Vérifier si l'utilisateur a déjà une session
        $stmt = $pdo->prepare("SELECT * FROM user_sessions WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($session) {
            // Mettre à jour la session si elle existe déjà
            $sql = "UPDATE user_sessions SET last_login = CURRENT_TIMESTAMP, is_connected = TRUE WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
        } else {
            // Créer une nouvelle session si elle n'existe pas
            $sql = "INSERT INTO user_sessions (user_id, last_login, is_connected) VALUES (:user_id, CURRENT_TIMESTAMP, TRUE)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
        }

        echo "Utilisateur connecté avec succès !";
    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
    }
}

// Fonction pour enregistrer la déconnexion de l'utilisateur
function logoutUser($pdo, $user_id) {
    try {
        // Mettre à jour la session pour marquer l'utilisateur comme déconnecté
        $sql = "UPDATE user_sessions SET is_connected = FALSE WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);

        echo "Utilisateur déconnecté avec succès !";
    } catch (PDOException $e) {
        echo "Erreur lors de la déconnexion : " . $e->getMessage();
    }
}


