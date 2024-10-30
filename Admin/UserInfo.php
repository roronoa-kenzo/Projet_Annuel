<?php
require_once './composant/admin_check.php'; // Inclure le fichier qui vérifie l'accès admin
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Back Log</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
    <?php include './../composants/navbar.php'; ?>
    <?php include './composant/database.php'; ?>
    <?php include './composant/sessionStart.php'; ?>

</head>
<?php
    // Inclure la connexion à la base de données
// Préparer la requête pour récupérer tous les utilisateurs avec leur statut de connexion
    $query = "
    SELECT u.username,u.id, u.first_name, u.last_name, u.email, us.is_connected
    FROM users u
    LEFT JOIN user_sessions us ON u.id = us.user_id";

    // Exécuter la requête
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
<body>
    <main class="container">
        <div class="black-frame">
            <h1>All users</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

                <div class="post-container-admin">
                    <div class="iceberg-select">
                    <p>Recherche User</p>
                    <input type="text" class="inpuTextAdmin" id="searchInput" placeholder="Rechercher un utilisateur...">
                    <button id="searchButton">Rechercher</button> <!-- Bouton de recherche -->
                    </div>
                </div>

                <div class="users-list" id="usersList">
                    <!-- Les résultats de la recherche seront insérés ici via JavaScript -->

                    <?php 
                    foreach ($users as $user): 
                    ?>
                        <div class="post-container-admin">
                            <a class="userLien" href="./User.php?user=<?= $user['id'] ?>">
                            <div class="iceberg-select">
                                <span class="username status <?= $user['is_connected'] ? '' : 'not-connected' ?>">
                                    <?= $user['is_connected'] ? 'Connecté :' : 'Non connecté :' ?>
                                </span>
                                <span class="username"><?= htmlspecialchars($user['username']) ?></span><br>                                
                                <span class="username" >Prénom : <?= htmlspecialchars($user['first_name']) ?></span><br>
                                <span class="username">Nom : <?= htmlspecialchars($user['last_name']) ?></span><br>
                                <span class="username">Email : <?= htmlspecialchars($user['email']) ?></span>
                            </div>
                        </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>