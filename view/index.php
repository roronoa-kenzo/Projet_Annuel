<!-- index.php -->
<?php include '../composants/header.php'; ?>
<?php include '../composants/navbar.php'; ?>
<main class="container">
    <div class="black-frame">
        <h1>Welcome in Abyss</h1>
    </div>
    <div class="main-index">
        <?php include '../composants/white_content_left.php'; ?>
        <div class="white-content">

            <div class="post-header">
                <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="user-avatar">
                <?php include '../composants/post-options.php'; ?>
                <div class="iceberg-select">
                    <select name="iceberg" id="icebergSelect">
                        <option value="" disabled selected>
                            Select an iceberg
                        </option>
                        <?php
                        // Vérifiez si l'utilisateur est connecté
                        if (isset($_SESSION["user_id"]) && isset($_SESSION['subscribed_forums'])) {
                            $subscribedForums = $_SESSION['subscribed_forums'];
                
                            // Vérifiez si l'utilisateur a des forums abonnés
                            if (empty($subscribedForums)) {
                                echo '<option value="">Aucun iceberg trouvé</option>';
                            } else {
                                // Boucle pour générer les options
                                foreach ($subscribedForums as $forum) {
                                    echo '<option value="' . htmlspecialchars($forum['id']) . '">' . htmlspecialchars($forum['name']) . '</option>';
                                }
                            }
                        } else {
                            echo '<option value="">Vous devez être connecté pour voir vos icebergs</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Contenus à afficher selon le bouton cliqué -->
            <!-- Post Textuel -->
            <div id="textContent">
                <textarea class="post-textarea" placeholder="Text..."></textarea>
            </div>
            <!-- Post Textuel et images -->
            <div id="imageVideoContent" style="display: none;">
                <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                    <textarea class="post-textarea" name="description" placeholder="Description..."></textarea>
                    <input type="file" id="fileToUpload" name="fileToUpload" accept=".png, .mp4">
                    <button type="submit" name="submit">Upload</button>
                </form>
            </div>
            <style>
                textarea {
                    resize: none;
                }
            </style>

        </div>
        <?php include '../composants/white_content_right.php'; ?>
    </div>
</main>
<?php include '../composants/script_link.php'; ?>
<?php include '../composants/footer.php'; ?>