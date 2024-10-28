<!-- index.php -->
<?php include './../composants/header.php'; ?>
<?php include './../composants/navbar.php'; ?>
<main class="container">
    <!-- Conteneur pour la notification -->
    <div id="notificationContainer" class="notification-container"></div>
    <?php
        if (isset($_SESSION['SuccessPost'])) {
            echo '<p id="successMessage" class="success-message">' . htmlspecialchars($_SESSION['SuccessPost']) . '</p>';
            echo '<script>showNotification("success", "' . htmlspecialchars($_SESSION['SuccessPost']) . '");</script>';
            unset($_SESSION['SuccessPost']);
        }
            
        if (isset($_SESSION['ErrorForum'])) {
            echo '<p id="errorMessage" class="error-message">' . htmlspecialchars($_SESSION['ErrorForum']) . '</p>';
            echo '<script>showNotification("error", "' . htmlspecialchars($_SESSION['ErrorForum']) . '");</script>';
            unset($_SESSION['ErrorForum']);
        }
            
        if (isset($_SESSION['ErrorContent'])) {
            echo '<p id="errorMessage" class="error-message">' . htmlspecialchars($_SESSION['ErrorContent']) . '</p>';
            echo '<script>showNotification("error", "' . htmlspecialchars($_SESSION['ErrorContent']) . '");</script>';
            unset($_SESSION['ErrorContent']);
        }
            
        if (isset($_SESSION['ErrorPost'])) {
            echo '<p id="errorMessage" class="error-message">' . htmlspecialchars($_SESSION['ErrorPost']) . '</p>';
            echo '<script>showNotification("error", "' . htmlspecialchars($_SESSION['ErrorPost']) . '");</script>';
            unset($_SESSION['ErrorPost']);
        }
    ?>
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
            

            

        </div>
        <!-- Affichage des posts récents -->
        
                <?php
                // Récupération et affichage des posts
                $query = $pdo->prepare('
                    SELECT posts.content, posts.created_at, posts.title, forums.name, users.username, users.user_profile
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
                        echo '<div class="posts-list">
                        <div class="post">
                            <div class="post-head">
                                <div class="post-head-first">
                                    <img src="' . htmlspecialchars($post['user_profile']) . '" alt="User Avatar" class="user-avatar">
                                    <p><strong>' . htmlspecialchars($post['username']) . '</strong></p>
                                </div>
                                <div class="post-forum">
                                    <p class="p-forum"><strong>' . htmlspecialchars($forum['name']) . '</strong></p>
                                </div>
                            </div>
                            <div class="post-content">
                                <h2>' . htmlspecialchars($post['title']) . '</h2>
                                <p>' . htmlspecialchars($post['content']) . '</p>
                                <small>Posted on ' . htmlspecialchars($post['created_at']) . '</small>
                                <br>';
                                
                            $query = $pdo->prepare('SELECT is_like FROM post_reactions WHERE post_id = :postId AND user_id = :userId');
                            $query->execute(['postId' => $post['id'], 'userId' => $userId]);
                            $reaction = $query->fetch();
                            $isLiked = $reaction && $reaction['is_like'] == 1;

                            echo '<form method="POST" action="like.php" style="display: inline;">
                                <input type="hidden" name="post_id" value="' . htmlspecialchars($post['id']) . '">
                                <button type="submit" class="like-button' . ($isLiked ? ' liked' : '') . '">
                                    <div class="like-wrapper">
                                        <div class="ripple"></div>
                                        <svg class="heart" width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"></path>
                                        </svg>
                                        <div class="particles" style="--total-particles: 6">
                                            <div class="particle" style="--i: 1; --color: #7642F0"></div>
                                            <div class="particle" style="--i: 2; --color: #AFD27F"></div>
                                            <div class="particle" style="--i: 3; --color: #DE8F4F"></div>
                                            <div class="particle" style="--i: 4; --color: #D0516B"></div>
                                            <div class="particle" style="--i: 5; --color: #5686F2"></div>
                                            <div class="particle" style="--i: 6; --color: #D53EF3"></div>
                                        </div>
                                    </div>
                                </button>
                            </form>;
                        </div>
                    </div>
                    </div>'
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