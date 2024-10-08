<!-- index.php -->
<?php include '../composants/header.php'; ?>
<?php include '../composants/navbar.php'; ?>

<main class="container">
    <div class="black-frame">
        <h1>Welcome in Abyss</h1>
    </div>
    <div class="main-index">
        <?php include '../composants/white_content_left.php'; ?>
        <div class="center-content">

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
            <!-- Formulaire de création de post -->
            <div id='textContent' class="post-creation">
                <form action="create_post.php" method="post">
                    <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
                    <textarea class="post-textarea" name="content" rows="4" placeholder="Write your post..." required></textarea>
                    <input type="hidden" name="forum_id" id="selectedForumId">
                    <button type="submit">Post</button>
                </form>
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

            <!-- Affichage des messages d'erreur ou de succès -->
            <?php
            if (isset($_SESSION['ErrorForum'])) {
                echo '<p class="error-message">' . $_SESSION['ErrorForum'] . '</p>';
                unset($_SESSION['ErrorForum']);
            }

            if (isset($_SESSION['ErrorContent'])) {
                echo '<p class="error-message">' . $_SESSION['ErrorContent'] . '</p>';
                unset($_SESSION['ErrorContent']);
            }

            if (isset($_SESSION['SuccessPost'])) {
                echo '<p class="success-message">' . $_SESSION['SuccessPost'] . '</p>';
                unset($_SESSION['SuccessPost']);
            }

            if (isset($_SESSION['ErrorPost'])) {
                echo '<p class="error-message">' . $_SESSION['ErrorPost'] . '</p>';
                unset($_SESSION['ErrorPost']);
            }
            ?>

            

        </div>
        <!-- Affichage des posts récents -->
        <div class="posts-list">
                <?php
                // Récupération et affichage des posts
                $query = $pdo->prepare('
                    SELECT posts.content, posts.created_at, forums.name AS forum_name 
                    FROM posts 
                    JOIN forums ON posts.forum_id = forums.id 
                    WHERE posts.user_id = :user_id
                    ORDER BY posts.created_at DESC
                ');
                $query->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $query->execute();
                $posts = $query->fetchAll(PDO::FETCH_ASSOC);

                if (empty($posts)) {
                    echo '<p class="no-posts">No posts yet. Start posting!</p>';
                } else {
                    foreach ($posts as $post) {
                        echo '<div class="post">';
                        echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
                        echo '<p><strong>Forum:</strong> ' . htmlspecialchars($post['forum_name']) . '</p>';
                        echo '<p>' . htmlspecialchars($post['content']) . '</p>';
                        echo '<small>Posted on ' . htmlspecialchars($post['created_at']) . '</small>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <?php include '../composants/white_content_right.php'; ?>
    </div>
</main>
<?php include '../composants/script_link.php'; ?>
<?php include '../composants/footer.php'; ?>

<script>
    document.getElementById('icebergSelect').addEventListener('change', function () {
        var selectedForumId = this.value;
        document.getElementById('selectedForumId').value = selectedForumId;
    });
</script>

