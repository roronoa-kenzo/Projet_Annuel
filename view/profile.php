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

                <?php
                // Récupérer les informations de l'utilisateur
                $stmt = $pdo->prepare("SELECT xp, level FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                
                <div>
                    <h3>Level <?php echo $user['level']; ?></h3>
                    <h3>XP : <?php echo $user['xp']; ?></h3>
                </div>
                <?php include './../composants/xpBar.php'; ?>
            </div>

            <!-- Formulaire pour changer d'image de profil -->
            <div class="profile-actions">
                <form action="./../controleur/ChangeProfilePicture.php" method="post" enctype="multipart/form-data">
                    <label for="profile-picture">Changer d'image de profil :</label>
                    <input type="file" name="profile_picture" id="profile-picture" accept="image/*" required>
                    <button class="btn-menu" type="submit">Mettre à jour l'image</button>
                </form>
            </div>

            <!-- Formulaire pour changer le mot de passe -->
            <div class="profile-actions">
                <form action="./../controleur/ChangePassword.php" method="post">
                    <label for="current-password">Mot de passe actuel :</label>
                    <input type="password" class="inpuText2" name="current_password" id="current-password" required>

                    <label for="new-password">Nouveau mot de passe :</label>
                    <input type="password" name="new_password" id="new-password" required>

                    <label for="confirm-password">Confirmer le nouveau mot de passe :</label>
                    <input type="password" name="confirm_password" id="confirm-password" required>

                    <button type="submit">Changer le mot de passe</button>
                </form>
            </div>

            <!-- Formulaire pour supprimer le compte -->
            <div class="profile-actions">
                <form action="./../controleur/DeleteAccount.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    <button type="submit" class="btn-submit"style="background-color: red; color: white;">Supprimer le compte</button>
                </form>
            </div>

            <style>
                .profile-actions {
    margin-top: 15px;
    padding: 10px 0;
}

.profile-actions form {
    margin-bottom: 20px;
}

            </style>
        </div>
        <?php include './../composants/white_content_right.php'; ?>
    </div>
</main>
<?php include './../composants/script_link.php'; ?>
<?php include './../composants/footer.php'; ?>
