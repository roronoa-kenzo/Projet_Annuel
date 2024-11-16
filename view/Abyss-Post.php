<?php
include './../serveur/database.php';

session_start();

$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo $postTitle; ?></title>
    <link id="theme-stylesheet" rel="stylesheet"
        href="./../public/css/<?php echo $darkMode ? 'darkmode' : 'style'; ?>.css">
    <!-- Autres balises head -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
    <?php require_once("./../composants/ResquestDarkMode.php"); ?>
</head>

<body class="indexBody">
    <?php require_once("./../composants/navbarNav.php"); ?>
    <main class="container">
        <div class="black-frame">
            <h1 id="forum-name"><!--         
                <h2>Forum: ${forum.name}</h2>
            <p>${forum.description}</p> 
        --></h1>
        </div>
        <div class="main-index">
            <?php include './../composants/white_content_left.php'; ?>
            <div class="">
                <div class="white-content">
                    <div id="post-content"></div>
                </div>
                <!--Composant pour mettre des commentaire au post-->
                <?php include './../composants/Comment-form.php'; ?>

                <div id="comments-container"></div>

            </div>
            <?php include './../composants/white_content_right.php'; ?>
        </div>
        </div>
    </main>
    <?php include './../composants/footer.php'; ?>
    <!-- Vos scripts -->
    <script>
        async function fetchPostData() {
            const postId = new URLSearchParams(window.location.search).get('Post');

            try {
                const response = await fetch(`./requetePost.php?Post=${postId}`);
                const data = await response.json();

                if (data.success) {
                    displayPost(data.post, data.forum);
                    titleForum(data.forum);
                    displayComments(data.comments);
                } else {
                    console.error(data.error);
                    document.getElementById('post-content').textContent = 'Erreur lors du chargement du post.';
                }
            } catch (error) {
                console.error('Erreur lors de la récupération des données :', error);
            }
        }

        // Fonction pour afficher le post
        function displayPost(post, forum) {
            const postContent = document.getElementById('post-content');
            postContent.innerHTML = `
        <div class="iceberg-select-profile">
            <img src="${post.author.profile_picture}" alt="Photo de profil" class="user-avatar">
            <h3 class="creator-username">${post.author.username}</h3>
        </div></br>
        <span>${post.title}</span></br>
        ${post.image ? `<img src="${post.image}" alt="Image du post" class="post-image">` : ''}
        <p>${post.content.replace(/\n/g, '<br>')}</p>

    `;
        }

        // Fonction pour afficher les commentaires
        function displayComments(comments) {
            const commentsContainer = document.getElementById('comments-container');
            commentsContainer.innerHTML = '';

            if (comments.length === 0) {
                commentsContainer.innerHTML = '<p>Aucun commentaire pour ce post.</p>';
                return;
            }

            comments.forEach(comment => {

                const commentElement = document.createElement('div');
                commentElement.classList.add('white-content');
                commentElement.innerHTML = `
            <div class="iceberg-select-profile">
                <img src="${comment.author_profile_picture}" alt="Photo de profil" class="user-avatar">
                <h3 class="creator-username">${comment.author_username}</h3></br>
                </div>
                <p>${comment.content.replace(/\n/g, '<br>')}</p>
        `;
                commentsContainer.appendChild(commentElement);
            });
        }
        function titleForum(forum) {
            document.getElementById('forum-name').textContent = forum.name;
        }

        // Charger les données du post au démarrage
        fetchPostData();
        setInterval(fetchPostData, 10000);
    </script>
</body>

</html>