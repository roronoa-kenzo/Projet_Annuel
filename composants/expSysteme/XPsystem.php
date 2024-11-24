<?php

function updateXP($userId, $xpToAdd, $pdo) {
    // Démarrer la session si elle n'est pas déjà démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Récupérer l'XP et le niveau actuels de l'utilisateur
    $stmt = $pdo->prepare("SELECT xp, level FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $currentXP = $user['xp'];
        $currentLevel = $user['level'];

        // Ajouter l'XP
        $newXP = $currentXP + $xpToAdd;

        // Calculer le nouveau niveau en fonction de l'XP
        $newLevel = calculateLevel($newXP);

        // Vérifiez si l'utilisateur monte de niveau
        $levelUp = $newLevel > $currentLevel;

        // Mettre à jour l'utilisateur dans la base de données
        $stmt = $pdo->prepare("UPDATE users SET xp = ?, level = ? WHERE id = ?");
        $stmt->execute([$newXP, $newLevel, $userId]);

        // Si l'utilisateur monte de niveau, enregistrer une notification en session
        if ($levelUp) {
            $_SESSION['levelUpNotification'] = [
                'newLevel' => $newLevel,
                'message' => "Félicitations ! Vous avez atteint le niveau $newLevel 🎉",
            ];
        }

        return [
            'xp' => $newXP,
            'level' => $newLevel,
            'levelUp' => $levelUp,
        ];
    }

    return null;
}

function calculateLevel($xp) {
    $maxLevel = 100; // Niveau maximum
    // Exemple : niveau = racine carrée de l'XP divisé par 10
    return floor(sqrt($xp) / 10) + 1;
}

?>
