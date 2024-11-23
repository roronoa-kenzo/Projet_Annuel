<?php
// Démarrer la session si ce n'est pas déjà fait
session_start();
include './serveur/database.php';

// Vérifier si l'utilisateur est connecté
if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])) {
    
    $Post_id = isset($_GET['Post']) ? intval($_GET['Post']) : null;
    ?>
    <!-- mettre le form de remplissage-->
    <div class="white-content">

        <div class="post-header">
            <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="user-avatar">
            <?php include './../composants/post-options.php'; ?>

        </div>

        <div id='textContent' class="post-creation">
            <form action="./../composants/TraitementComment.php" method="post">
                <input type="hidden" name="texte" value="texte">
                <input type="hidden" name="Post_id" value="<?php echo $Post_id; ?>">
                <textarea class="post-textarea" name="content" rows="4" placeholder="Write your comment..."
                    required></textarea>
                <button class="btn-submit" type="submit">Comment</button>
            </form>
        </div>
        <!-- Post Textuel et images -->
        <div id="imageVideoContent" style="display: none;">
            <form id="uploadForm" action="./../composants/TraitementComment.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="file" value="file">
                <textarea class="post-textarea" name="description" placeholder="Description..."></textarea>
                <input type="file" id="fileToUpload" name="fileToUpload" required accept=".png, .mp4, .jpg">
                <button type="submit" name="submit">Upload</button>
            </form>
        </div>
        <style>
            textarea {
                resize: none;
            }
        </style>


    </div>
    <?php
} else {

}
?>