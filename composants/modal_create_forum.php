<div id="createForumModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Create a Forum</h2>
        <form id="createForumForm">
            <label for="forumName">Forum Name:</label>
            <input type="text" id="forumName" name="forumName" required>

            <label for="forumColor">Choose a Color:</label>
            <div class="color-selection">
                <?php
                // Liste des couleurs à proposer
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
                            <input type="radio" name="forumColor" value="' . $color . '" required>
                            <span class="color-label">' . htmlspecialchars($name) . '</span>
                          </label>';
                }
                ?>
            </div>

            <button type="submit" class="btn-submit">Create Forum</button>
        </form>
    </div>
</div>

<!-- Bouton pour ouvrir le modal -->
<button id="openModalButton" class="btn-open-modal">Create Forum</button>
