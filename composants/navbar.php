<!-- composants/navbar.php -->

<nav class="navbar">
    <img src="../public/img/icon.png" alt="Abyss" class="logo">
    <div id="searchBar" class="search-container">
        <input type="text" class="inpuText" placeholder="Rechercher...">
        <?php require_once "../serveur/database.php"; ?>
        <div class="suggestions" style='display : none;'>
            <p>Marvel</p>
            <p>Sonic</p>
        </div>
    </div>
    <button id="darkModeButton">Nuit</button>
    <a href="../view/connexion.php"><img src="../public/img/connexion.png" alt="lien page" class="logo-connexion"></a>
</nav>