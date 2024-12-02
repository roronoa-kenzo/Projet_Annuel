<?php
session_start();
require_once './../serveur/database.php'; // Connexion à la base de données

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ./../view/login.php');
    exit();
}

// Récupérer le niveau et l'XP de l'utilisateur depuis la base de données
try {
    $query = $pdo->prepare('SELECT level, xp FROM users WHERE id = :user_id');
    $query->execute(['user_id' => $_SESSION['user_id']]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $level = $user['level'];
        $xp = $user['xp'];
    } else {
        $level = 1; // Valeur par défaut si l'utilisateur n'est pas trouvé
        $xp = 0;
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des données utilisateur : " . $e->getMessage();
    exit();
}
?>

<?php include './../composants/header.php'; ?>
<?php include './../composants/navbar.php'; ?>
<main class="container">
    <div class="black-frame">
        <h1>Profile</h1>
    </div>
    <div class="main-index">
        <?php include './../composants/white_content_left.php'; ?>
        <div class="white-content">
            <div class="profile_first">
                <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="user-avatar">
                <h2><strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></h2>

                <!-- Affichage du niveau et de l'XP -->
                <p><strong>Niveau :</strong> <?php echo $level; ?></p>
                <p><strong>Expérience :</strong> <?php echo $xp; ?> XP</p>

                <?php include './../composants/xpBar_profile.php'; ?>
            </div>
            <div class="profile-section">
                <h2>Options</h2>

                <!-- Formulaire pour changer le nom d'utilisateur -->
                <div class="profile-actions">
                    <form action="./../controleur/ChangeUsername.php" method="post">
                        <label for="new-username"><h3>Changer le nom d'utilisateur :</h3></label>
                        <input type="text" class="inpuText2" name="new_username" id="new-username" required>
                        <button class="btn-menu" type="submit">Envoyer</button>
                    </form>
                </div>

                <!-- Formulaire pour changer l'image de profil -->
                <div class="profile-actions">
                    <form action="./../controleur/ChangeProfilePicture.php" method="post" enctype="multipart/form-data">
                        <label for="profile-picture"><h3>Changer l'image de profil :</h3></label>
                        <input type="file" name="profile_picture" id="profile-picture" accept="image/*" style="margin: 2em;" required>
                        <button class="btn-menu" type="submit">Mettre à jour l'image</button>
                    </form>
                </div>

                <!-- Formulaire pour changer le mot de passe -->
                <div class="profile-actions">
                    <form action="./../controleur/ChangePassword.php" method="post">
                        <h3>Changer le mot de passe</h3>
                        <label for="current-password">Mot de passe actuel :</label>
                        <input type="password" class="inpuText2" name="current_password" id="current-password" required>

                        <label for="new-password">Nouveau mot de passe :</label>
                        <input type="password" class="inpuText2" name="new_password" id="new-password" required>

                        <label for="confirm-password">Confirmer le nouveau mot de passe :</label>
                        <input type="password" class="inpuText2" name="confirm_password" id="confirm-password" required>

                        <button class="btn-menu" type="submit">Envoyer</button>
                    </form>
                </div>

                <!-- Formulaire pour supprimer le compte -->
                <div class="profile-actions">
                    <form action="./../controleur/DeleteAccount.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                        <button type="submit" class="btn-menu" style="background-color: red; color: white;">Supprimer le compte</button>
                    </form>
                </div>
            </div>

            <style>
                .profile-actions {
                    margin-top: 15px;
                    padding: 10px 0;
                }

                .profile-actions form {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    padding: 1em;
                }
            </style>
        </div>
        <?php include './../composants/white_content_right.php'; ?>
    </div>
</main>
<?php include './../composants/script_link.php'; ?>
<?php include './../composants/footer.php'; ?>
