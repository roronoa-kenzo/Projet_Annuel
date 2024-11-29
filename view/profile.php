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

              
                
                <div>
                    <h3>Level <?php echo $user['level']; ?></h3>
                    <h3>XP : <?php echo $user['xp']; ?></h3>
                </div>
                <?php include './../composants/xpBar_profile.php'; ?>
            </div>
            <div class="profile-section">
                
            <h2>Option</h2>

            <!-- Formulaire pour changer le nom d'utilisateur -->
            <div class="profile-actions">
                <form action="./../controleur/ChangeUsername.php" method="post">
                    <label for="new-username"><h3>Change Username :</h3></label>
                    <input type="text" class="inpuText2" name="new_username" id="new-username" required>

                    <button class="btn-menu" type="submit">Send</button>
                </form>
            </div>

            <!-- Formulaire pour changer d'image de profil -->
            <div class="profile-actions">
                <form action="./../controleur/ChangeProfilePicture.php" method="post" enctype="multipart/form-data">
                    <label for="profile-picture"><h3>Change Profile Picture :</h3></label>
                    <input type="file" name="profile_picture" id="profile-picture" accept="image/*" style="margin: 2em;" required>
                    <button class="btn-menu" type="submit">Mettre à jour l'image</button>
                </form>
            </div>

            <!-- Formulaire pour changer le mot de passe -->
            <div class="profile-actions">
                <form action="./../controleur/ChangePassword.php" method="post">
                    <h3>Change Password</h3>
                    <label for="current-password">Mot de passe actuel :</label>
                    <input type="password" class="inpuText2" name="current_password" id="current-password" required>

                    <label for="new-password">Nouveau mot de passe :</label>
                    <input type="password" class="inpuText2" name="new_password" id="new-password" required>

                    <label for="confirm-password">Confirmer le nouveau mot de passe :</label>
                    <input type="password" class="inpuText2" name="confirm_password" id="confirm-password" required>

                    <button class="btn-menu" type="submit" >Send</button>
                </form>
            </div>

            <!-- Formulaire pour supprimer le compte -->
            <div class="profile-actions">
                <form action="./../controleur/DeleteAccount.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    <button type="submit" class="btn-menu"style="background-color: red; color: white;">Supprimer le compte</button>
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
