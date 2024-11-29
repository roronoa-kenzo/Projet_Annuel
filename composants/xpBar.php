<?php
// Inclure la connexion à la base de données
include './../serveur/database.php'; // Assure-toi que cette ligne contient la bonne configuration pour te connecter à la base de données

// Supposons que tu passes l'ID de l'utilisateur via un formulaire ou une autre méthode
$userId = $_SESSION['user_id']; // Remplace par l'ID réel de l'utilisateur

// Récupérer les données d'XP et de niveau depuis la base de données
$stmt = $pdo->prepare("SELECT xp, level FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $xp = $user['xp']; // L'XP actuel de l'utilisateur
    $level = $user['level']; // Le niveau actuel de l'utilisateur
} else {
    $xp = 0;
    $level = 1;
}

// Fonction pour calculer l'XP nécessaire pour le prochain niveau
function getNextLevelXP($level) {
    return pow(($level - 1) * 10, 2);
}

$currentLevelXP = getNextLevelXP($level); // XP au début du niveau actuel
$nextLevelXP = getNextLevelXP($level + 1); // XP nécessaire pour atteindre le niveau suivant

// Progression actuelle dans ce niveau
$xpForCurrentLevel = $nextLevelXP - $currentLevelXP;
$xpProgressInLevel = $xp - $currentLevelXP;
$xpPercentage = min(($xpProgressInLevel / $xpForCurrentLevel) * 100, 100); // Clamp à 100%

?>
<style>
        .xp-bar-container {
            width: 75%;
            height: 12px;
            background-color: #cccccc; /* Fond gris */
            border-radius: 8px;
            overflow: hidden;
            margin: 20px 0;
            position: relative;
        }

        .xp-bar-fill {
            height: 100%;
            background-color: #000000; /* Barre noire */
            width: <?php echo $xpPercentage; ?>%; /* Mise à jour dynamique */
            transition: width 0.3s ease;
        }

        #xp-bar-text {
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
    <div class="xp-bar-container">
        <div class="xp-bar-fill"></div>
    </div>


