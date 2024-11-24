<!-- composants/navbar.php -->
<?php
// Vérifiez si le formulaire a été soumis pour activer/désactiver le mode sombre
if (isset($_POST['darkMode'])) {
    $_SESSION['darkMode'] = $_POST['darkMode'];
    header("Location: " . $_SERVER['PHP_SELF']);
}
$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';
?>

<header>
    <nav class="navbar" role="navigation">
        <a href="./../view/index.php">
            <img src="./../public/img/icon.png" alt="Abyss" class="logo">
        </a>

        <?php if (isset($_SESSION['LevelUp'])): ?>
            <div class="notification level-up">
                <?php echo $_SESSION['LevelUp']; ?>
                <button onclick="this.parentElement.style.display='none';">X</button>
            </div>
            <?php unset($_SESSION['LevelUp']); // Supprimez la notification après affichage ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['email'])): ?>
            <div id="searchBar" class="search-container">
                <input type="text" class="inpuText" placeholder="Rechercher...">
                <?php require_once "./../serveur/database.php"; ?>
                <div class="suggestions" style='display : none;'>
                    <p>Marvel</p>
                    <p>Sonic</p>
                </div>
            </div>
            <div class="nav_third">
                <form id="darkModeForm" method="POST">
                    <input type="hidden" name="darkMode" id="darkModeInput" value="<?php echo $darkMode ? 'on' : 'off'; ?>">
                    <button type="button" onclick="toggleDarkMode()">Nuit</button>
                </form>
                <script>
                    function toggleDarkMode() {
                        // Alterne la classe dark-mode sur le body
                        document.body.classList.toggle('dark-mode');

                        // Met à jour la valeur du champ caché et soumet le formulaire
                        const isDarkMode = document.body.classList.contains('dark-mode');
                        document.getElementById('darkModeInput').value = isDarkMode ? 'on' : 'off';
                        document.getElementById('darkModeForm').submit();
                    }

                    // Applique la classe 'dark-mode' si le mode sombre est activé
                    if (<?php echo json_encode($darkMode); ?>) {
                        document.body.classList.add('dark-mode');
                    }
                </script>

                <a href="./../view/profile.php">
                    <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="profile-button">
                </a>
                <!-- Si l'utilisateur est connecté, affiche le bouton de déconnexion -->
                <form action="./../serveur/logout.php" method="post" style="display: inline;">
                    <button type="submit" name="logout" class="nav_btn">Déconnexion</button>
                </form>
            <?php else: ?>
                <!-- Si l'utilisateur n'est pas connecté, affiche le lien vers la connexion -->
                <div class='nav_buttons'>
                    <button class='nav_btn' onclick="window.location.href='./../view/register.php'">Sign Up</button>
                    <button class='nav_btn' onclick="window.location.href='./../view/connexion.php'">Sign In</button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Menu Burger (mobile) -->
        <div id="menuToggle">
            <input type="checkbox" id="menuCheckbox" />
            <span></span>
            <span></span>
            <span></span>
            <ul id="menu">
            <?php if (isset($_SESSION['email'])): ?>
                <li>
                    <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="profile-button">
                    <p class="profile_name"><strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></p>
                </li>
                <li>
                   <div class="burger-navigation">
                      <h3>Menu</h3>
                      <a class="btn-menu" href="./Popular.php">Popular Forum</a>
                      <a class="btn-menu" href="./Abyss-Recent.php">Recent</a>
                      <a class="btn-menu" href="./kinglike.php">king of Like</a>
                   </div>
                </li>
                <li>
                    <form id="darkModeForm" method="POST">
                       <input type="hidden" name="darkMode" id="darkModeInput" value="<?php echo $darkMode ? 'on' : 'off'; ?>">
                       <button type="button" onclick="toggleDarkMode()">Nuit</button>
                    </form>
                </li>
                <li>
                <form action="./../serveur/logout.php" method="post" style="display: inline;">
                    <button type="submit" name="logout" class="nav_btn">Déconnexion</button>
                </form>
                </li>
                <?php else: ?>
                <li >
                    <button class='nav_btn' onclick="window.location.href='./../view/register.php'">Sign Up</button>
                </li>
                <li>
                    <button class='nav_btn' onclick="window.location.href='./../view/connexion.php'">Sign In</button>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
