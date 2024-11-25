<?php
include './../serveur/database.php';

session_start();

$backgroundPath = $_SESSION['background'];

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
            postContent.innerHTML = ''; // Vider le contenu précédent

            // Créer la div de profil de l'auteur
            const profileDiv = document.createElement('div');
            profileDiv.className = 'iceberg-select-profile';

            const profileImage = document.createElement('img');
            profileImage.src = post.author.profile_picture;
            profileImage.alt = 'Photo de profil';
            profileImage.className = 'user-avatar';

            const authorName = document.createElement('h3');
            authorName.className = 'creator-username';
            authorName.textContent = `${post.author.username}`;

            // Ajouter l'image de profil et le nom de l'auteur à la div profile
            profileDiv.appendChild(profileImage);
            profileDiv.appendChild(authorName);

            // Ajouter la div de profil à la div postContent
            postContent.appendChild(profileDiv);

            // Créer le titre du post
            const titleSpan = document.createElement('span');
            titleSpan.textContent = `Tilte :${post.title}`;
            postContent.appendChild(titleSpan);

            // Ajouter un saut de ligne après le titre
            postContent.appendChild(document.createElement('br'));

            // Ajouter l'image du post s'il y en a une
            if (post.image) {
                const postImage = document.createElement('img');
                postImage.src = post.image;
                postImage.alt = 'Image du post';
                postImage.className = 'post-image';
                postContent.appendChild(postImage);
            }

            // Créer la description du post
            const postDescription = document.createElement('p');
            postDescription.innerHTML = `Description:<br>${post.content}`;
            postContent.appendChild(postDescription);
        }
        function reportPost(buttonDiv, forumUrlReport) {
            // Créer un bouton de rapport
            let buttonReport = document.createElement('button'); // Utilisez 'button', pas 'bouton'
            buttonReport.classList.add('buttonReport');
            buttonReport.setAttribute('style', 'cursor: pointer;');
            // Ajouter une image au bouton
            let imgReport = document.createElement('img');
            imgReport.setAttribute('src', './../public/img/reportButton.png');
            imgReport.setAttribute('class', 'btnReport');
            buttonReport.appendChild(imgReport);

            // Ajouter un événement click au bouton
            buttonReport.addEventListener('click', function () {
                // Créer un formulaire caché dynamiquement
                let hiddenForm = document.createElement('form');
                hiddenForm.setAttribute('method', 'POST');
                hiddenForm.setAttribute('action', './../Report/ReportContent.php');
                hiddenForm.style.display = 'none';

                // Créer un champ input caché contenant l'URL du forum
                let hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'forumUrl');
                hiddenInput.setAttribute('value', forumUrlReport);

                // Ajouter l'input caché au formulaire
                hiddenForm.appendChild(hiddenInput);

                // Ajouter le formulaire au document
                document.body.appendChild(hiddenForm);

                // Soumettre le formulaire
                hiddenForm.submit();
            });

            // Ajouter le bouton au conteneur spécifié
            buttonDiv.appendChild(buttonReport);
        }

        // Fonction pour afficher les commentaires
        function displayComments(comments) {
            const commentsContainer = document.getElementById('comments-container');
            commentsContainer.innerHTML = ''; // Vider le contenu précédent

            if (comments.length === 0) {
                const noCommentsMessage = document.createElement('p');
                noCommentsMessage.textContent = 'Aucun commentaire pour ce post.';
                commentsContainer.appendChild(noCommentsMessage);
                return;
            }

            comments.forEach(comment => {
                // Créer la div principale pour chaque commentaire
                const commentElement = document.createElement('div');
                commentElement.classList.add('white-content');
                <?php if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])): ?>
                    const ReportDiv = document.createElement('div');
                    ReportDiv.setAttribute('style', `margin: 0px 0px -35px 0px;`);
                    ReportDiv.classList.add('PalceReport');
                    ReportDiv.setAttribute('style', `margin: 0px 0px -35px 0px;`);
                    commentElement.appendChild(ReportDiv);
                    let reportmessage = comment.author_username + " have comment : " + comment.content;

                    reportPost(ReportDiv, reportmessage);
                <?php endif; ?>
                // Créer la div pour le profil de l'auteur
                const profileDiv = document.createElement('div');
                profileDiv.classList.add('iceberg-select-profile');

                const profileImage = document.createElement('img');
                profileImage.src = comment.author_profile_picture;
                profileImage.alt = 'Photo de profil';
                profileImage.classList.add('user-avatar');

                const authorName = document.createElement('h3');
                authorName.classList.add('creator-username');
                authorName.textContent = `${comment.author_username}`;

                // Ajouter l'image de profil et le nom de l'auteur à la div profile
                profileDiv.appendChild(profileImage);
                profileDiv.appendChild(authorName);

                // Ajouter la div de profil au commentaire
                commentElement.appendChild(profileDiv);

                // Créer le contenu du commentaire
                const commentContent = document.createElement('p');
                commentContent.textContent = comment.content; // Remplacer les retours à la ligne par <br> pour l'affichage

                // Ajouter le contenu du commentaire à l'élément du commentaire
                commentElement.appendChild(commentContent);

                // Ajouter l'élément du commentaire au conteneur des commentaires
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
    <style>
        .buttonReport {
            padding-top: 3px;
            border: none;
            background: none;
        }

        .PalceReport {
            display: flex;
            justify-content: end;
        }

        .btnReport {
            height: 3.5vh;
            padding-left: 1rem;
        }
    </style>
</body>

</html>