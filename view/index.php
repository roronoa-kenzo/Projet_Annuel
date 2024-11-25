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
                    <?php include './../composants/post-options.php'; ?>
                    <div class="iceberg-select">
                        <!-- Formulaire de création de post textuel -->
                        <div id="textContent" class="post-creation">
                            <form action="create_post.php" method="post">
                                <select name="forum_id" required>
                                    <option value="" disabled selected>Select an iceberg</option>
                                    <?php
                                    if (isset($_SESSION["user_id"]) && isset($_SESSION['subscribed_forums'])) {
                                        foreach ($_SESSION['subscribed_forums'] as $forum) {
                                            echo '<option value="' . htmlspecialchars($forum['id']) . '">' . htmlspecialchars($forum['name']) . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Vous devez être connecté pour voir vos icebergs</option>';
                                    }
                                    ?>
                                </select>
                                <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
                                <textarea class="post-textarea" name="content" rows="4" placeholder="Write your description..." required></textarea>
                                <button class="btn-submit" type="submit">Post</button>
                            </form>
                        </div>

                        <!-- Formulaire de création de post avec fichier -->
                        <div id="imageVideoContent" style="display: none;">
                            <form id="uploadForm" action="./../controleur/upload_post.php" method="post" enctype="multipart/form-data">
                                <select name="forum_id" required>
                                    <option value="" disabled selected>Select an iceberg</option>
                                    <?php
                                    if (isset($_SESSION["user_id"]) && isset($_SESSION['subscribed_forums'])) {
                                        foreach ($_SESSION['subscribed_forums'] as $forum) {
                                            echo '<option value="' . htmlspecialchars($forum['id']) . '">' . htmlspecialchars($forum['name']) . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Vous devez être connecté pour voir vos icebergs</option>';
                                    }
                                    ?>
                                </select>
                                <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
                                <input type="file" id="fileToUpload" name="fileToUpload" accept=".png, .mp4" required>
                                <button type="submit" class="btn-submit">Post</button>
                            </form>
                        </div>
                    </div>
                </div>

               
                <style>
                    textarea {
                        resize: none;
                    }
                </style>
            </div>

            <!-- Affichage des posts -->
            <?php
            $query = $pdo->prepare('
                SELECT posts.id, posts.title, posts.content, posts.image, posts.created_at, forums.name AS forum_name, 
                users.username, users.user_profile
                FROM posts
                JOIN forums ON posts.forum_id = forums.id
                JOIN forum_subscribers ON forum_subscribers.forum_id = forums.id
                JOIN users ON posts.user_id = users.id
                WHERE forum_subscribers.user_id = :user_id
                ORDER BY posts.created_at DESC
            ');
            $query->execute(['user_id' => $_SESSION['user_id']]);
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
                                    <p class="p-forum"><strong>' . htmlspecialchars($post['forum_name']) . '</strong></p>
                                </div>
                            </div>
                            <div class="post-content">';
                    
                    // Différenciation des types de post
                    if (!empty($post['image'])) {
                        echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
                        $fileExtension = pathinfo($post['image'], PATHINFO_EXTENSION);
                        if ($fileExtension === 'mp4') {
                            echo '<video controls width="100%">
                                    <source src="' . htmlspecialchars($post['image']) . '" type="video/mp4">
                                  </video>';
                        } else {
                            echo '<img src="' . htmlspecialchars($post['image']) . '" alt="Post Image" class="post-image">';
                        }
                    } else {
                        echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
                        echo '<p>' . htmlspecialchars($post['content']) . '</p>';
                    }

                    echo '<small>Posted on ' . htmlspecialchars($post['created_at']) . '</small>
                            </div>
                        </div>
                    </div>';
                }
            }
            ?>
        </div>
        <?php include './../composants/white_content_right.php'; ?>
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
