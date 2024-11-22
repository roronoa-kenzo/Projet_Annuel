<?php
include './../serveur/database.php';

session_start();

$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title id="page-title"></title>
    <link id="theme-stylesheet" rel="stylesheet"
        href="./../public/css/<?php echo $darkMode ? 'darkmode' : 'style'; ?>.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
</head>

<body class="indexBody">
    <?php require_once("./../composants/navbarNav.php"); ?>
    <main class="container">
        <div class="black-frame">
            <h1 id="forum-name"></h1>
        </div>
        <div class="main-index">
            <?php include './../composants/white_content_left.php'; ?>
            <div class="">
                <div class="white-content">
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
            postsContainer.innerHTML = '';

            if (posts.length === 0) {
                document.getElementById('no-posts-message').textContent = 'Aucun post dans ce forum.';
                return;
            }

            posts.forEach(post => {
                const postElement = document.createElement('div');
                postElement.className = 'white-content';

                postElement.innerHTML = `
            <div class="iceberg-select">
                <div class="iceberg-select-profile">
                    <img src="${post.author.profile_picture}" alt="Photo de profil" class="user-avatar">
                    <h3 class="creator-username">${post.author.username}</h3>
                </div></br>
                <span>Title: ${post.title || 'Titre indisponible'}</span><br><br>
                <a href="./Abyss-Post.php?Post=${post.id}" class="post-link userLien">
                    ${post.image ? `<img src="${post.image}" alt="Image du post" class="post-image"> <br><br>` : ''}
                    <span class="username">Description:<br>${post.content}</span><br>
                     <hr>
                    <span class="post-nomber">${post.comment_count} comment(s)</span>
                </a><br/>
               
                <?php
                if(!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])){
                ?>
                <div style="display: flex; justify-content: end; margin-top: -1rem;">
                <button onclick="clickLike(this, ${post.id})" class="likebutton">${post.like_count}<img src="./../public/img/likebutton.png" alt="Like" class="likeicon <?php echo $_SESSION['buttonred'];?>"></button>
                </div>
                <?php
                }
                ?>
            </div>
        `;

                postsContainer.appendChild(postElement);
            });
        }
        // Charger les données initiales et les composants
        fetchForumData();

        // Actualiser les données toutes les 10 secondes
        setInterval(fetchForumData, 10000);
    </script>
    <style>
        .likebutton {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 22px;
            display: flex;
        }
        .likeicon{
            padding-left: 5px;
            padding-top: 1px;
        }
        .likebutton .likeicon {
            width:22px;
            /* Ajustez la taille de l'image si nécessaire */
            height: 22px;
            transition: filter 0.3s ease;
            /* Animation de transition */
        }
        .liked{
            filter: invert(17%) sepia(95%) saturate(7486%) hue-rotate(0deg) brightness(100%) contrast(115%);
        }
        .likebutton.liked .likeicon {
            filter: invert(17%) sepia(95%) saturate(7486%) hue-rotate(0deg) brightness(100%) contrast(115%);
        }
    </style>
    <?php include './../composants/script_link.php'; ?>
    <?php include './../composants/footer.php'; ?>
</body>

</html>