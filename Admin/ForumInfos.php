<?php
require_once './composant/admin_check.php'; // Inclure le fichier qui vérifie l'accès admin
 include './../composants/header.php';
 include './composant/database.php';
 include './composant/sessionStart.php'; 
// Inclure la connexion à la base de données
// Préparer la requête pour récupérer tous les utilisateurs avec leur statut de connexion
$query = "
SELECT f.id, f.name, f.description, f.background, f.created_at, f.creator_id, u.username 
FROM forums f
LEFT JOIN users u ON f.creator_id = u.id";

// Exécuter la requête
$stmt = $pdo->prepare($query);
$stmt->execute();
$forums = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
<?php include './../composants/navbar.php'; ?>
    <main class="container">
        <div class="black-frame">
            <h1>All Forums by users</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

                <div class="post-container-admin">
                    <div class="iceberg-select">
                        <p>Recherche Forums</p>
                        <input type="text" class="inpuTextAdmin" id="searchInput"
                            placeholder="Rechercher un utilisateur...">
                        <button id="searchButton">Rechercher</button> <!-- Bouton de recherche -->
                    </div>
                </div>

                <div class="users-list" id="usersList">
                    <!-- Les résultats de la recherche seront insérés ici via JavaScript -->
                    <?php
                    if (empty($forums)) { ?>
                        <div class="post-container-admin">
                            <div class="iceberg-select">
                                <p>No Forum.</p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($forums as $forums): ?>
                            <div class="post-container-admin">
                                <a class="userLien" href="User.php?user=<?= $forums['creator_id'] ?>">
                                    <div class="iceberg-select">
                                        <span class="">
                                            Forum by:<?= htmlspecialchars($forums['username']) ?>
                                        </span><br>
                                        <span class="username">Tilte forum : <?= htmlspecialchars($forums['name']) ?></span><br>
                                        <span class="username">Description :
                                            <?= htmlspecialchars($forums['description']) ?></span><br>
                                        <span class="username">Date creation :
                                            <?= htmlspecialchars($forums['created_at']) ?></span>
                                    </div>
                            </div>
                            </a>
                        <?php endforeach;
                    } ?>
                </div>
            </div>
        </div>
    </main>
    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>