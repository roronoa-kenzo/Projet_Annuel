<?php
// Inclure la connexion à la base de données
include './composant/database.php';

// Vérifier si l'ID de l'utilisateur est passé dans l'URL
if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $userId = $_GET['user'];

    // Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
    $query = "SELECT * FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe, afficher ses informations
    if ($user) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <title>Profil de <?= htmlspecialchars($user['username']) ?></title>
        </head>

        <body>
            <h1>Profil de <?= htmlspecialchars($user['username']) ?></h1>
            <div class="user-details">
                <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p><strong>Prénom :</strong> <?= htmlspecialchars($user['first_name']) ?></p>
                <p><strong>Nom :</strong> <?= htmlspecialchars($user['last_name']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Date de naissance :</strong> <?= htmlspecialchars($user['date_of_birth']) ?></p>
                <p><strong>XP :</strong> <?= htmlspecialchars($user['xp']) ?></p>
                <p><strong>Niveau :</strong> <?= htmlspecialchars($user['level']) ?></p>
                <p><strong>Administrateur :</strong> <?= $user['is_admin'] ? 'Oui' : 'Non' ?></p>
                <p><strong>Banni :</strong> <?= $user['is_banned'] ? 'Oui' : 'Non' ?></p>
                <p><strong>Date de création :</strong> <?= htmlspecialchars($user['created_at']) ?></p>
                <p><strong>Dernière mise à jour :</strong> <?= htmlspecialchars($user['updated_at']) ?></p>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo "Utilisateur introuvable.";
    }
} else {
    echo "ID utilisateur invalide.";
}
?>