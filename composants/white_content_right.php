
<div class="white-content-secondary">
    <h3>Mes Forum</h3>

    <?php
                        // Vérifiez si l'utilisateur est connecté
                        if (isset($_SESSION["user_id"]) && isset($_SESSION['subscribed_forums'])) {
                            $subscribedForums = $_SESSION['subscribed_forums'];
                
                            // Vérifiez si l'utilisateur a des forums abonnés
                            if (empty($subscribedForums)) {
                                echo '<p>Aucun iceberg trouvé</p>';
                            } else {
                                // Boucle pour générer les options
                                foreach ($subscribedForums as $forum) {
                                    echo '<div class="button-forum">';
                                    echo '<button class="btn-menu" value="' . htmlspecialchars($forum['id']) . '">' . htmlspecialchars($forum['name']) . '</button>';
                                    echo '</div>';
                                }
                            }
                        } else {
                            echo '<p>Vous devez être connecté pour voir vos icebergs</p>';
                        }
                        ?>
        <a href="./../Admin/Back-log.php">
            <button class="btn-menu"> Admin </button>
        </a>
</div>