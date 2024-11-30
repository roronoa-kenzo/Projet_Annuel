<?php
// Démarrer la session si ce n'est pas déjà fait
session_start();
include './serveur/database.php';

// Récupérer l'ID du forum à partir du paramètre GET s'il est présent
$forum_id = isset($_GET['forum_id']) ? intval($_GET['forum_id']) : null;
// Vérifiez si l'ID du forum est présent et mettez-le dans la session
if ($forum_id) {
    $_SESSION['forum_id'] = $forum_id;

}

// Vérifier si l'utilisateur est connecté et si l'ID du forum est bien en session
if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"]) && isset($_SESSION['forum_id'])) {
    ?>
    <!-- Formulaire de création de post -->
    <div class="white-content">
        <div class="post-header">
            <?php include './../composants/post-options.php'; ?>
            <div class="iceberg-select">
                <!-- Formulaire de création de post textuel -->
                <div id="textContent" class="post-creation">
                    <form action="./../controleur/TraitementPost.php" method="post">
                        <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
                        <textarea class="post-textarea" name="content" rows="4" placeholder="Write your description..." required></textarea>
                        <input type="hidden" name="texte" value="texte" id="texte">
                        <button class="btn-submit" type="submit">Post</button>
                    </form>
                </div>

                <!-- Formulaire de création de post avec fichier -->
                <div id="imageVideoContent" style="display: none;">
                    <form id="uploadForm" action="./../controleur/TraitementPostMedia.php" method="post" enctype="multipart/form-data">
                        <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
                        <textarea name="content" class="post-textarea" rows="4" placeholder="Write your description..." required></textarea>
                        <input type="file" id="fileToUpload" name="fileToUpload" accept=".png, .mp4" required>
                        <button type="submit" class="btn-submit">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        textarea {
            resize: none;
        }
    </style>
    <?php
} else {
    // Redirection ou message pour indiquer que l'utilisateur doit être connecté ou que le forum est non défini
}
?>
