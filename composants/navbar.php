<!-- composants/navbar.php -->
<?php 
    session_start(); 
    
    ?>
<nav class="navbar">
    <img src="../public/img/icon.png" alt="Abyss" class="logo">
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
        <button id="darkModeButton">Nuit</button>
        <a href="../view/profile.php">
            <img src="../public/img/connexion.png" alt="lien page" class="logo-connexion">
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