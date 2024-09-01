<!-- composants/navbar.php -->
<nav class="navbar">
    <img src="img/icon.png" alt="Abyss" class="logo">
    <div id="searchBar" class="search-container">
        <input type="text" placeholder="Rechercher...">
        <?php require_once "serveur/database.php"; ?>
        <div class="suggestions">
            <p>Marvel</p>
            <p>Sonic</p>
        </div>
    </div>
    <button id="darkModeButton">Nuit</button>
</nav>
