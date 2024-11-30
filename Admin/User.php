<?php
// Inclure la connexion à la base de données
require_once './composant/admin_check.php'; // Inclure le fichier qui vérifie l'accès admin
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
        $user_email = $user['email'];
        $user_username  =$user['username'];
        $user_first_name  =$user['first_name'];
        $user_last_name  =$user['last_name'];
        $user_date_of_birth  =$user['date_of_birth'];
        $user_created_at  =$user['created_at'];
        $user_updated_at  =$user['updated_at'];
        $userxp = $user['xp'];

        ?>

        <?php include './../composants/header.php'; ?>

        <body>
            <?php include './../composants/navbar.php'; ?>
            <main class="container">
                <div class="black-frame">
                    <h1>Profil de <?= htmlspecialchars($user['username']) ?></h1>
                </div>
                <div class="main-index">
                    <?php include './composant/white_content_left-admin.php'; ?>
                    <div class="white-content-admin">
                        <div class="post-container-admin">
                            <div class="iceberg-select">
                                <p><strong>Nom d'utilisateur :</strong> <?php echo $user_username; ?></p>
                                <p><strong>Prénom :</strong> <?php echo $user_first_name; ?></p>
                                <p><strong>Nom :</strong> <?php echo $user_last_name; ?></p>
                                <p><strong>Email :</strong> <?php echo $user_email; ?></p>
                                <p><strong>Date de naissance :</strong> <?php echo $user_date_of_birth; ?></p>
                                <p><strong>XP :</strong> <?php echo $userxp; ?></p>
                                <p><strong>Niveau :</strong> <?php echo $user['level']; ?></p>
                                <p><strong>Administrateur :</strong> <?= $user['is_admin'] ? 'Oui' : 'Non' ?></p>
                                <p><strong>Banni :</strong> <?= $user['is_banned'] ? 'Oui' : 'Non' ?></p>
                                <p><strong>Date de création :</strong> <?php echo $user_created_at; ?></p>
                                <p><strong>Dernière mise à jour :</strong> <?php echo $user_updated_at;  ?></p>
                            </div>
                        </div>



                        <?php
                        // Préparer et exécuter la requête pour récupérer les forums créés par l'utilisateur
                        $queryForums = "SELECT * FROM forums WHERE creator_id = :creator_id";
                        $stmtForums = $pdo->prepare($queryForums);
                        $stmtForums->bindParam(':creator_id', $userId, PDO::PARAM_INT);
                        $stmtForums->execute();
                        $forums = $stmtForums->fetchAll(PDO::FETCH_ASSOC);

                        if ($forums) { ?>
                            <div class="post-container-admin">
                                <h2>Forums créés par <?= htmlspecialchars($user['username']) ?></h2>
                            </div>
                            <?php
                            // Si des forums existent, les afficher
                            foreach ($forums as $forum) {
                                ?>
                                <div class="post-container-admin">
                                    <div class="iceberg-select">
                                        <p><strong>Nom du forum :</strong><br> <?= htmlspecialchars($forum['name']) ?></p>
                                        <p><strong>Description :</strong> <br><?= htmlspecialchars($forum['description']) ?></p>
                                        <p><strong>Date de création :</strong> <br><?= htmlspecialchars($forum['created_at']) ?></p>
                                        <p><strong>Dernière mise à jour :</strong> <br><?= htmlspecialchars($forum['updated_at']) ?></p>
                                        <form action="./composant/OptionUser.php" method="POST">
                                            <input type="hidden" name="clickForum" value="clickForum">
                                            <input type="hidden" name="forum_id" value="<?= htmlspecialchars($forum['id']) ?>">
                                            <button type="submit">Supprimer ce forum</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- -->
                                <?php
                            }
                        } else {
                            echo "<p>Aucun forum créé par cet utilisateur.</p>";
                        }
                        ?>
                    </div>
                    <?php include './composant/white_content_right-admin.php'; ?>
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