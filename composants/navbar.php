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
        <a href="../view/connexion.php">
            <img src="../public/img/connexion.png" alt="lien page" class="logo-connexion">
        </a>
    </div>
</nav>