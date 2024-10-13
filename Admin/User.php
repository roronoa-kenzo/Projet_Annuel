<?php
// Inclure la connexion à la base de données
include './composant/database.php';
include './composant/sessionStart.php';
// Vérifier si l'ID de l'utilisateur est passé dans l'URL
if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $userId = $_GET['user'];
    // Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
    $query = "SELECT * FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user_id'] = $user['id'];

    // Si l'utilisateur existe, afficher ses informations
    if ($user) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../public/css/style.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <title>Profil de <?= htmlspecialchars($user['username']) ?></title>
            <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
                rel="stylesheet">
            <link rel="icon" type="../public/image/png" href="../public/img/abyssicon.png">
            <?php include './../composants/navbar.php'; ?>
        </head>

        <body>
            <main class="container">
                <div class="black-frame">
                    <h1>Profil de <?= htmlspecialchars($user['username']) ?></h1>
                </div>
                <div class="main-index">
                    <?php include './composant/white_content_left-admin.php'; ?>
                    <div class="white-content-admin">
                        <div class="post-container-admin">
                            <div class="iceberg-select">
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
                        </div>

                        <div class="post-container-admin">
                            <h2>Forums créés par <?= htmlspecialchars($user['username']) ?></h2>

                            <?php
                            // Préparer et exécuter la requête pour récupérer les forums créés par l'utilisateur
                            $queryForums = "SELECT * FROM forums WHERE creator_id = :creator_id";
                            $stmtForums = $pdo->prepare($queryForums);
                            $stmtForums->bindParam(':creator_id', $userId, PDO::PARAM_INT);
                            $stmtForums->execute();
                            $forums = $stmtForums->fetchAll(PDO::FETCH_ASSOC);

                            if ($forums) {
                                // Si des forums existent, les afficher
                                foreach ($forums as $forum) {
                                    ?>
                                    <div class="forum">
                                        <hr>
                                        <p><strong>Nom du forum :</strong><br> <?= htmlspecialchars($forum['name']) ?></p> 
                                        <p><strong>Description :</strong> <br><?= htmlspecialchars($forum['description']) ?></p>
                                        <p><strong>Date de création :</strong> <br><?= htmlspecialchars($forum['created_at']) ?></p>
                                        <p><strong>Dernière mise à jour :</strong> <br><?= htmlspecialchars($forum['updated_at']) ?></p>
                                        <form action="./composant/OptionUser.php" method="POST">
                                        <input type="hidden" name="forum_id" value="<?= htmlspecialchars($forum['id']) ?>">
                                        <button type="submit">Supprimer ce forum</button>
                                    </div>
                                    <!-- -->
                                    <?php
                                }
                            } else {
                                echo "<p>Aucun forum créé par cet utilisateur.</p>";
                            }
                            ?>
                        </div>
                </div>
                <?php include './composant/white_content_right-admin.php'; ?>
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