<?php
require_once './composant/admin_check.php'; // Inclure le fichier qui vérifie l'accès admin

 include './../composants/header.php';
 include './../composants/navbar.php';
 include './composant/database.php';
 include './composant/sessionStart.php'; 
?>
<?php
// Inclure la connexion à la base de données
// Préparer la requête pour récupérer tous les utilisateurs avec leur statut de connexion
$query = "
    SELECT p.id AS post_id, p.title AS post_title, p.content, p.created_at AS post_created_at, p.user_id AS creator_id,
           f.name AS forum_title, u.username
    FROM posts p
    LEFT JOIN forums f ON p.forum_id = f.id
    LEFT JOIN users u ON p.user_id = u.id";

// Exécuter la requête
$stmt = $pdo->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <main class="container">
        <div class="black-frame">
            <h1>All posts by users</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

                <div class="post-container-admin">
                    <div class="iceberg-select">
                        <p>Recherche Post</p>
                        <input type="text" class="inpuTextAdmin" id="searchInput"
                            placeholder="Rechercher un utilisateur...">
                        <button id="searchButton">Rechercher</button> <!-- Bouton de recherche -->
                    </div>
                </div>

                <div class="users-list" id="usersList">
                    <!-- Les résultats de la recherche seront insérés ici via JavaScript -->

                    <?php
                    if (empty($posts)) { ?>
                        <div class="post-container-admin">
                            <div class="iceberg-select">
                                <p>No Post.</p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php
                        foreach ($posts as $post): ?>
                            <div class="post-container-admin">
                                <a class="userLien" href="./PostUser.php?user=<?= $post['creator_id'] ?>">
                                    <div class="iceberg-select">
                                        <span class="">
                                            Post by:<?= htmlspecialchars($post['username']) ?>
                                        </span><br>
                                        <span class="username">Tilte post :
                                            <?= htmlspecialchars($post['post_title']) ?></span><br>
                                        <span class="username">Description :
                                            <?= htmlspecialchars($post['content']) ?></span><br>
                                        <span class="username">Tilte forum :
                                            <?= htmlspecialchars($post['forum_title']) ?></span><br>
                                        <span class="username">Date creation :
                                            <?= htmlspecialchars($post['post_created_at']) ?></span>
                                    </div>
                            </div>
                            </a>
                        <?php endforeach;
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>