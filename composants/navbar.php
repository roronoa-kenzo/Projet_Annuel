<!-- composants/navbar.php -->
<?php
session_start();

?>
<header>
    <nav class="navbar">

    <a href="../view/index.php">
        <img src="../public/img/icon.png" alt="Abyss" class="logo">
    </a>

        <?php if (isset($_SESSION['email'])): ?>
            <div id="searchBar" class="search-container">
                <input type="text" class="inpuText" placeholder="Rechercher...">
                <?php require_once "../serveur/database.php"; ?>
                <div class="suggestions" style='display : none;'>
                    <p>Marvel</p>
                    <p>Sonic</p>
                </div>
            </div>
            <div class='nav_third'>
                <form id="darkModeForm" method="POST">
                    <input type="hidden" name="darkMode" id="darkModeInput" value="<?php echo $darkMode ? 'on' : 'off'; ?>">
                    <button type="button" onclick="toggleDarkMode()">Nuit</button>
                </form>
                <script>
                    function toggleDarkMode() {
                        // Alterne la classe dark-mode sur le body
                        document.body.classList.toggle('dark-mode');

                        // Détermine si le mode sombre est activé
                        const isDarkMode = document.body.classList.contains('dark-mode');

                        // Met à jour la valeur du champ caché et soumet le formulaire
                        document.getElementById('darkModeInput').value = isDarkMode ? 'on' : 'off';
                        document.getElementById('darkModeForm').submit();
                    }
                </script>
                <a href="../view/profile.php">

               <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="profile-button">

                </a>
                <!-- Si l'utilisateur est connecté, affiche le bouton de déconnexion -->
                <form action="../serveur/logout.php" method="post" style="display: inline;">
                    <button type="submit" name="logout" class="nav_btn">Déconnexion</button>
                </form>
            <?php else: ?>
                <!-- Si l'utilisateur n'est pas connecté, affiche le lien vers la connexion -->
                <div class='nav_buttons'>
                    <button class='nav_btn' onclick="window.location.href='../view/register.php'">Sign Up</button>
                    <button class='nav_btn' onclick="window.location.href='../view/connexion.php'">Sign In</button>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>