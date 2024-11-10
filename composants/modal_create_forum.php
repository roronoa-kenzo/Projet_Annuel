<!-- Modal pour la création de forum -->
<div id="createForumModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <form id="createForumForm" action="./../controleur/create_forum.php" method="POST">
            <label for="forumName">Nom du Forum :</label>
            <input type="text" id="forumName" name="forum_name" required>

            <label for="forumColor">Choisissez une couleur :</label>
            <div class="color-selection">
                <?php
                $colors = [
                    'red' => 'Rouge',
                    'black' => 'Noir',
                    'green' => 'Vert',
                    'blue' => 'Bleu',
                    'yellow' => 'Jaune',
                    'orange' => 'Orange',
                    'purple' => 'Violet',
                    'pink' => 'Rose',
                    'brown' => 'Marron',
                    'gray' => 'Gris'
                ];
                foreach ($colors as $color => $name) {
                    echo '<label class="color-option" style="background-color: ' . $color . ';">
                            <input type="radio" name="forum_color" value="' . $color . '" required>
                            <span class="color-label">' . htmlspecialchars($name) . '</span>
                          </label>';
                }
                ?>
            </div>

            <button type="submit" class="btn-submit">Créer le Forum</button>
        </form>
    </div>
</div>
