
<?php include './../composants/header.php'; ?>
<?php include './../composants/navbar.php'; ?>

<main class="container">
    <?php include './../composants/notification.php'; ?>
    <?php include './../composants/modal_create_forum.php'; ?>
    
    <div class="black-frame">
        <h1>Welcome in Abyss</h1>
    </div>
    <div class="main-index">
        <?php include './../composants/white_content_left.php'; ?>
        <div class="center-content">

        <div class="white-content">

            <div class="post-header">
                <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="user-avatar">
                <?php include './../composants/post-options.php'; ?>
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
                    <button class="btn-submit" type="submit">Post</button>
                </form>
            </div>
            <!-- Post Textuel et images -->
            <div id="imageVideoContent" style="display: none;">
                <form id="uploadForm" action="./upload.php" method="post" enctype="multipart/form-data">
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
            

            

        </div>
          <!-- Affichage des posts récents -->
          <?php
                // Récupération et affichage des posts
                $query = $pdo->prepare('
                    SELECT posts.id, posts.content, posts.created_at, posts.title, forums.name, users.username, users.user_profile
                    FROM posts
                    JOIN forums ON posts.forum_id = forums.id
                    JOIN forum_subscribers ON forum_subscribers.forum_id = forums.id
                    JOIN users ON posts.user_id = users.id
                    WHERE forum_subscribers.user_id = :user_id
                    ORDER BY posts.created_at DESC;
                ');
                $query->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $query->execute();
                $posts = $query->fetchAll(PDO::FETCH_ASSOC);

                if (empty($posts)) {
                    echo '<p class="no-posts">No posts yet. Start posting!</p>';
                } else {
                    foreach ($posts as $post) {
                        // Récupération du nombre de likes et statut de like de l'utilisateur
                        $query = $pdo->prepare('SELECT COUNT(*) as like_count FROM post_reactions WHERE post_id = :postId AND is_like = 1');
                        $query->execute(['postId' => $post['id']]);
                        $likeCount = $query->fetchColumn();

                        $query = $pdo->prepare('SELECT COUNT(*) FROM post_reactions WHERE post_id = :postId AND user_id = :userId AND is_like = 1');
                        $query->execute(['postId' => $post['id'], 'userId' => $_SESSION['user_id']]);
                        $isLiked = $query->fetchColumn() > 0;
                        
                        echo '<div class="posts-list">
                                <div class="post">
                                    <div class="post-head">
                                        <div class="post-head-first">
                                            <img src="' . htmlspecialchars($post['user_profile']) . '" alt="User Avatar" class="user-avatar">
                                            <p><strong>' . htmlspecialchars($post['username']) . '</strong></p>
                                        </div>
                                        <div class="post-forum">
                                            <p class="p-forum"><strong>' . htmlspecialchars($post['name']) . '</strong></p>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <h2>' . htmlspecialchars($post['title']) . '</h2>
                                        <p>' . htmlspecialchars($post['content']) . '</p>
                                        <small>Posted on ' . htmlspecialchars($post['created_at']) . '</small>
                                        <br>
                                        <form method="POST" action="like.php" class="like-form" style="display: inline;">
                                            <input type="hidden" name="post_id" value="' . htmlspecialchars($post['id']) . '">
                                            <button type="submit" class="like-button' . ($isLiked ? ' liked' : '') . '">
                                                <div class="like-wrapper">
                                                    <div class="ripple"></div>
                                                    <svg class="heart" width="24" height="24" viewBox="0 0 24 24">
                                                        <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"></path>
                                                    </svg>
                                                    <span class="like-count">' . htmlspecialchars($likeCount) . '</span>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                    }
                }
                ?>
            </div>
            <?php include './../composants/white_content_right.php'; ?>
        </div>
    </div>
</main>
<?php include './../composants/script_link.php'; ?>
<?php include './../composants/footer.php'; ?>

<script>
    document.getElementById('icebergSelect').addEventListener('change', function () {
        var selectedForumId = this.value;
        document.getElementById('selectedForumId').value = selectedForumId;
    });
</script>

