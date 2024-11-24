<?php
include './../serveur/database.php';

session_start();

$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';

// Récupérer le `forum_id` de la requête GET
$forumId = isset($_GET['forum_id']) ? $_GET['forum_id'] : null;
$backgroundPath = null;

// Vérifiez si le forum_id est présent
if ($forumId) {
    // Préparer la requête pour récupérer les informations de fond pour ce forum
    $query = $pdo->prepare("SELECT background FROM forums WHERE id = :forum_id");
    $query->bindParam(':forum_id', $forumId, PDO::PARAM_INT);
    $query->execute();
    
    $forumData = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($forumData && !empty($forumData['background'])) {
        $backgroundPath = $forumData['background'];
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title id="page-title"></title>
    <link id="theme-stylesheet" rel="stylesheet" href="<?php echo isset($backgroundPath) && $backgroundPath ? $backgroundPath : ($darkMode ? './../public/css/darkmode.css' : './../public/css/style.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
</head>

<body class="indexBody">
    <?php require_once("./../composants/navbar_forum.php"); ?>
    <main class="container">
        <div class="black-frame">
            <h1 id="forum-name"></h1>
        </div>
        <div class="main-index">
            <?php include './../composants/white_content_left.php'; ?>
            <div class="">
                <div class="white-content-description">
                    <div class="iceberg-select-profile">
                        <img id="creator-profile-picture" src="./default-profile.png" class="user-avatar">
                        <h3 id="creator-username"></h3>
                    </div>
                    <p id="forum-description"></p>
                </div>

                <?php include './../composants/Post-form.php'; ?>
                <div id="posts-container">
                    <p id="no-posts-message">Chargement des posts...</p>
                </div>
            </div>
            <?php include './../composants/white_content_right.php'; ?>
        </div>
    </main>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!-- JavaScript pour le chargement dynamique -->
    <script>
        const forumId = new URLSearchParams(window.location.search).get('forum_id');
        // Fonction pour récupérer les données du forum et des posts
        async function fetchForumData() {
            try {
                const response = await fetch(`./requeteForum.php?forum_id=${forumId}`);
                const data = await response.json();

                if (data.success) {
                    updateForumInfo(data.forum);
                    updatePosts(data.posts);
                } else {
                    console.error(data.error);
                    alert(data.error);
                }
            } catch (error) {
                console.error('Erreur lors de la récupération des données :', error);
                document.getElementById('no-posts-message').textContent = 'Erreur lors du chargement des données.';
            }
        }

        // Mettre à jour les informations du forum
        function updateForumInfo(forum) {
            document.title = forum.name;
            document.getElementById('page-title').textContent = forum.name;
            document.getElementById('forum-name').textContent = forum.name;
            document.getElementById('forum-description').textContent = forum.description;
            document.getElementById('creator-username').textContent = forum.creator.username;
            document.getElementById('creator-profile-picture').src = forum.creator.profile_picture || './default-profile.png';
        }
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


        // Mettre à jour la liste des posts
        function updatePosts(posts) {
            const postsContainer = document.getElementById('posts-container');
            postsContainer.innerHTML = ''; // Vider le contenu précédent

            if (posts.length === 0) {
                document.getElementById('no-posts-message').textContent = 'Aucun post dans ce forum.';
                return;
            }

            posts.forEach(post => {
                // Créer la div principale du post
                const postElement = document.createElement('div');
                postElement.className = 'white-content';


                // Créer la div iceberg-select
                const icebergSelectDiv = document.createElement('div');
                icebergSelectDiv.className = 'iceberg-select';

                // Créer le profil de l'auteur
                const profileDiv = document.createElement('div');
                profileDiv.className = 'iceberg-select-profile';

                const profileImage = document.createElement('img');
                profileImage.src = post.author.profile_picture;
                profileImage.alt = 'Photo de profil';
                profileImage.className = 'user-avatar';

                const authorName = document.createElement('h3');
                authorName.className = 'creator-username';
                authorName.textContent = post.author.username;

                // Ajouter l'image de profil et le nom à la div profile
                profileDiv.appendChild(profileImage);
                profileDiv.appendChild(authorName);

                // Ajouter la div profile à la div iceberg-select
                icebergSelectDiv.appendChild(profileDiv);

                // Ajouter un saut de ligne
                icebergSelectDiv.appendChild(document.createElement('br'));

                // Créer le lien vers le post (pour rendre le titre et la description cliquables)
                const postLink = document.createElement('a');
                postLink.href = `./Abyss-Post.php?Post=${post.id}`;
                postLink.className = 'post-link userLien';

                // Créer le titre du post et l'ajouter au lien cliquable
                const titleH2 = document.createElement('h2');
                titleH2.textContent = `${post.title || 'Titre indisponible'}`;
                postLink.appendChild(titleH2);

                // Ajouter des sauts de ligne après le titre
                postLink.appendChild(document.createElement('br'));
                postLink.appendChild(document.createElement('br'));

                // Ajouter l'image du post s'il y en a une
                if (post.image) {
                    const postImage = document.createElement('img');
                    postImage.src = post.image;
                    postImage.alt = 'Image du post';
                    postImage.className = 'post-image';
                    postLink.appendChild(postImage);

                    // Ajouter des sauts de ligne après l'image
                    
                   
                }

                // Créer la description du post et l'ajouter au lien cliquable
                const description = document.createElement('p');
                description.className = 'username';
                description.innerHTML = `${post.content}`;
                postLink.appendChild(description);

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

                // Ajouter le bouton de like (si l'utilisateur est connecté)
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

                // Ajouter l'élément de post au conteneur des posts
                postsContainer.appendChild(postElement);
            });
        }


        // Charger les données initiales et les composants
        fetchForumData();

        // Actualiser les données toutes les 10 secondes
        setInterval(fetchForumData, 10000);
    </script>
    <style>

    </style>
    <?php include './../composants/script_link.php'; ?>
    <?php include './../composants/footer.php'; ?>
</body>

</html>