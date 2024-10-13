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
                    <h1>Post créés par <?= htmlspecialchars($user['username']) ?>                    </h1>
                </div>
                <div class="main-index">
                    <?php include './composant/white_content_left-admin.php'; ?>
                    <div class="white-content-admin">
                        <div class="post-container-admin">
                            <div class="iceberg-select">
                                    <!-- tout les post du user afficher -->
                            </div>
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