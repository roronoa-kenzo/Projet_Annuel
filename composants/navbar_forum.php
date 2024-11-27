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

        <?php if (isset($_SESSION['email'])): ?>
            <div id="searchBar" class="search-container">
                <input type="text" class="inpuText" placeholder="Research..." oninput="fetchRecherche(this.value)">
                <div class="suggestions" style="display : none;" id="suggestions">

                </div>
            </div>
            <style>
                .suggestions {
                    max-height: 150px;
                    /* Hauteur maximale pour la liste */
                    overflow-y: auto;
                    /* Activer le défilement vertical si le contenu dépasse */
                }
            </style>
            <script>
                function fetchRecherche(query) {
                    const suggestionsDiv = document.getElementById('suggestions');

                    if (query.length === 0) {
                        // Cacher les suggestions si la barre est vide
                        suggestionsDiv.style.display = 'none';
                        suggestionsDiv.innerHTML = '';
                        return;
                    }

                    // Effectuer une requête au serveur
                    fetch('./../composants/search.php?q=' + encodeURIComponent(query))
                        .then(response => response.json())
                        .then(data => {
                            suggestionsDiv.style.display = 'block';
                            suggestionsDiv.innerHTML = '';

                            if (data.length === 0) {
                                suggestionsDiv.innerHTML = '<p>Aucun résultat trouvé.</p>';
                                return;
                            }

                            // Générer une liste de suggestions
                            data.forEach(item => {
                                const p = document.createElement('p'); // Utilisation de <p>
                                p.className = 'suggestion-item';
                                p.textContent = item.title; // Affiche le titre ou le contenu
                                p.onclick = () => {
                                    // Rediriger selon le type (forum, post, ou commentaire)
                                    if (item.type === 'forum') {
                                        window.location.href = `Abyss-Forum.php?forum_id=${item.id}`;
                                    } else if (item.type === 'post') {
                                        window.location.href = `Abyss-Post.php?Post=${item.id}`;
                                    } else if (item.type === 'comment') {
                                        // Redirection vers le post parent du commentaire
                                        window.location.href = `Abyss-Post.php?Post=${item.id}`;
                                    }
                                };
                                suggestionsDiv.appendChild(p);
                            });
                        })
                        .catch(error => {
                            console.error('Erreur lors de la recherche :', error);
                        });
                }
            </script>
            <div class="nav_third">
                <a href="./../view/profile.php">
                    <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar"
                        class="profile-button">
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
                        <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar"
                            class="profile-button">
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
                        <form action="./../serveur/logout.php" method="post" style="display: inline;">
                            <button type="submit" name="logout" class="nav_btn">Déconnexion</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li>
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