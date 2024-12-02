<!-- Modal pour la création de forum -->
<div id="editForumModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        
        <form action="./../controleur/upload_wallpaper.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="forum_id" value="<?php echo $forumId; ?>">
            <label for="wallpaper">Choisissez un wallpaper :</label>
            <input type="file" name="wallpaper" id="wallpaper" accept="image/*" required>
            <button type="submit">Uploader</button>
        </form>


    </div>
</div>

