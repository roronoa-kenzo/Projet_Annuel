<?php
// Démarrer la session si ce n'est pas déjà fait
session_start();
include './serveur/database.php';

// Vérifier si l'utilisateur est connecté
if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])) {
    $forum_id = isset($_GET['forum_id']) ? intval($_GET['forum_id']) : null;

    ?>
    <!-- mettre le form de remplissage-->
    <div class="white-content">

        <div class="post-header">
            <?php include './../composants/post-options.php'; ?>

        </div>

        <div id='textContent' class="post-creation">
            <form action="./../composants/TraitementPost.php" method="post">
                <input type="hidden" name="forum_id" value="<?php echo $forum_id; ?>">
                <input type="hidden" name="texte" value="texte">
                <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
                <textarea class="post-textarea" name="content" rows="4" placeholder="Write your post..."
                    required></textarea>
                <button class="btn-submit" type="submit">Post</button>
            </form>
        </div>
        <!-- Post Textuel et images -->
        <div id="imageVideoContent" style="display: none;">
            <form id="uploadForm" action="./../composants/TraitementPost.php" method="post" enctype="multipart/form-data">
                <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
                <textarea class="post-textarea" name="description" placeholder="Description..."></textarea>
                <input type="file" id="fileToUpload" name="fileToUpload" required accept=".png, .mp4, .jpg">
                <input type="hidden" name="file" value="file">
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