<!-- Modal pour la création de forum -->
<div id="createForumModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        
        <form id="createForumForm" action="./../controleur/create_forum.php" method="POST">
            <!-- Nom du forum -->
            <label class="labelForum" for="forumName">Forum Name :</label>
            <input type="text" id="forumName" name="forum_name" class="inputTitle" placeholder="Entrez le nom du forum" required>
            
            <!-- Description -->
            <label class="labelForum" for="forumDescription">Description :</label>
            <textarea id="forumDescription" name="forum_description" class="post-textarea" placeholder="Entrez une description" required></textarea>
            
            <!-- Sélection de thème -->
            <h3>Themes</h3>
            <div class="theme-selection">
                <label class="theme-option" data-theme="grey">
                    <img src="./../public/img/grey_theme.png" alt="Grey Theme">
                    <span>Grey</span>
                </label>
                <label class="theme-option" data-theme="blue">
                    <img src="./../public/img/blue_theme.png" alt="Blue Theme">
                    <span>Blue</span>
                </label>
                <label class="theme-option" data-theme="green">
                    <img src="./../public/img/green_theme.png" alt="Green Theme">
                    <span>Green</span>
                </label>
                <label class="theme-option" data-theme="red">
                    <img src="./../public/img/red_theme.png" alt="Red Theme">
                    <span>Red</span>
                </label>
                <label class="theme-option" data-theme="orange">
                    <img src="./../public/img/orange_theme.png" alt="Orange Theme">
                    <span>Orange</span>
                </label>
                <label class="theme-option" data-theme="galaxy_red">
                    <img src="./../public/img/galaxyred_theme.png" alt="Galaxy Red Theme">
                    <span>Galaxy Red</span>
                </label>
                <label class="theme-option" data-theme="galaxy_blue">
                    <img src="./../public/img/galaxyblue_theme.png" alt="Galaxy Blue Theme">
                    <span>Galaxy Blue</span>
                </label>
            </div>
            
            <!-- Champ caché pour stocker le thème sélectionné -->
            <input type="hidden" id="selectedTheme" name="selected_theme">

            <!-- Bouton de création -->
            <button class="btn-submit" type="submit">Créer le Forum</button>
        </form>
    </div>
</div>

