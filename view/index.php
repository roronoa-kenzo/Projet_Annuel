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
                                <textarea class="post-textarea" name="content" rows="4"
                                    placeholder="Write your description..." required></textarea>
                                <button class="btn-submit" type="submit">Post</button>
                            </form>
                        </div>

                        <!-- Formulaire de création de post avec fichier -->
                        <div id="imageVideoContent" style="display: none;">
                            <form id="uploadForm" action="./../controleur/upload_post.php" method="post"
                                enctype="multipart/form-data">
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

                                <!-- Nouveau champ de description -->
                                <textarea name="content" class="post-textarea" rows="4"
                                    placeholder="Write your description..." required></textarea>

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
            <!-- Affichage des posts récents -->
            <div id="posts-container"></div>

            <!-- Affichage des messages d'erreur ou de succès -->
            <script>
                // URL de l'API PHP
                const apiUrl = `./../composants/TraitementIndex.php`;

                function clickLike(button, postId) {
                    fetch('./like_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ post_id: postId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Ajoutez la classe 'liked' au bouton
                                button.classList.toggle('liked');
                            } else {
                                alert('Erreur lors de l\'ajout du like.');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                        });
                }

                // Fonction pour récupérer et afficher les posts
                async function fetchPosts() {
                    try {
                        const response = await fetch(apiUrl);

                        if (!response.ok) {
                            throw new Error(`Erreur HTTP : ${response.status}`);
                        }

                        const posts = await response.json();

                        // Sélection du conteneur des posts
                        const container = document.getElementById('posts-container');

                        // Vérification des données reçues
                        if (posts.length === 0) {
                            container.innerHTML = '<p>Aucune publication trouvée.</p>';
                            return;
                        }

                        // Affichage des posts
                        posts.forEach(post => {

                            let postsContainer = document.getElementById('posts-container');
                            const postElement = document.createElement('div');
                            postElement.className = 'white-content';

                            let iceberg = document.createElement('div');
                            iceberg.className = 'forum_name';

                            let iceP = document.createElement('p');
                            iceP.textContent = post.forum_name;
                            iceberg.appendChild(iceP);
                            postElement.appendChild(iceberg);


                            const icebergSelectDiv = document.createElement('div');
                            icebergSelectDiv.className = 'iceberg-select';
                            iceP.className = 'forum_left';
                            // Créer le profil de l'auteur
                            const profileDiv = document.createElement('div');
                            profileDiv.className = 'iceberg-select-profile';

                            const profileImage = document.createElement('img');
                            profileImage.src = post.user_profile;
                            profileImage.alt = 'Photo de profil';
                            profileImage.className = 'user-avatar';

                            const authorName = document.createElement('h3');
                            authorName.className = 'creator-username';
                            authorName.textContent = post.username;

                            // Ajouter l'image de profil et le nom à la div profile
                            profileDiv.appendChild(profileImage);
                            profileDiv.appendChild(authorName);

                            // Ajouter la div profile à la div iceberg-select
                            icebergSelectDiv.appendChild(profileDiv);

                            // Ajouter un saut de ligne
                            icebergSelectDiv.appendChild(document.createElement('br'));

                            const postLink = document.createElement('a');
                            postLink.href = `./Abyss-Post.php?Post=${post.id}`;
                            postLink.className = 'post-link userLien';

                            // Créer le titre du post et l'ajouter au lien cliquable
                            const titleSpan = document.createElement('h2');
                            titleSpan.textContent = `${post.title || 'Titre indisponible'}`;
                            postLink.appendChild(titleSpan);

                            // Créer la description du post et l'ajouter au lien cliquable
                            const descriptionSpan = document.createElement('p');
                            descriptionSpan.className = 'username';
                            descriptionSpan.innerHTML = `${post.content}`;
                            postLink.appendChild(descriptionSpan);

                            // Vérifier le fichier et afficher l'image ou la vidéo
                            if (post.image) {
                                const fileExtension = post.image.split('.').pop().toLowerCase();

                                if (fileExtension === 'mp4') {
                                    // Afficher une vidéo
                                    const video = document.createElement('video');
                                    video.src = post.image;
                                    video.controls = true; // Ajouter les contrôles
                                    video.className = 'post-video';
                                    postLink.appendChild(video);
                                } else if (fileExtension === 'png') {
                                    // Afficher une image
                                    const image = document.createElement('img');
                                    image.src = post.image;
                                    image.alt = 'Image du post';
                                    image.className = 'post-image';
                                    postLink.appendChild(image);
                                }
                            }


                            // Ajouter une ligne horizontale
                            const hrElement = document.createElement('hr');
                            postLink.appendChild(hrElement);

                            // Ajouter le nombre de commentaires
                            const commentCountSpan = document.createElement('span');
                            commentCountSpan.className = 'post-nomber';
                            commentCountSpan.textContent = `${post.comment_count} comment(s)`;
                            postLink.appendChild(commentCountSpan);

                            // Ajouter le lien vers le post à la div iceberg-select
                            icebergSelectDiv.appendChild(postLink);

                            // Ajouter un saut de ligne après le lien
                            icebergSelectDiv.appendChild(document.createElement('br'));

                            // Ajouter la div iceberg-select au postElement
                            postElement.appendChild(icebergSelectDiv);

                            <?php if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])): ?>
                                const likeButtonContainer = document.createElement('div');
                                likeButtonContainer.style.display = 'flex';
                                likeButtonContainer.style.justifyContent = 'end';
                                likeButtonContainer.style.marginTop = '-1rem';

                                const likeButton = document.createElement('button');
                                likeButton.className = 'likebutton';
                                likeButton.setAttribute('onclick', `clickLike(this, ${post.id})`);
                                likeButton.innerHTML = `${post.like_count} <img src="./../public/img/likebutton.png" alt="Like" class="likeicon <?php echo $_SESSION['buttonred']; ?>">`;

                                likeButtonContainer.appendChild(likeButton);
                                postElement.appendChild(likeButtonContainer);

                            <?php endif; ?>

                            postsContainer.appendChild(postElement);
                        });
                    } catch (error) {
                        console.error("Erreur lors de la récupération des posts :", error);
                        document.getElementById('posts-container').innerHTML = `<p>Erreur : ${error.message}</p>`;
                    }
                }


                // Charger les posts au chargement de la page

                fetchPosts();
                setInterval(fetchPostData, 10000);
            </script>
        </div>
        <?php include './../composants/white_content_right.php'; ?>
    </div>
    </div>
</main>

<?php include './../composants/script_link.php'; ?>
<?php include './../composants/footer.php'; ?>
<style>
    .forum_name {
        display: flex;
        justify-content: end;
        margin: 0px 0px -55px 4px;
    }

    .forum_left {
        background-color: black;
        height: 4vh;
        width: 14vh;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        color: white;
    }
</style>
<script>
    document.getElementById('icebergSelect').addEventListener('change', function () {
        var selectedForumId = this.value;
        document.getElementById('selectedForumId').value = selectedForumId;
    });
</script>