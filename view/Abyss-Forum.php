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
    $query = $pdo->prepare("SELECT background, wallpaper, creator_id FROM forums WHERE id = :forum_id");
    $query->bindParam(':forum_id', $forumId, PDO::PARAM_INT);
    $query->execute();



    $forumData = $query->fetch(PDO::FETCH_ASSOC);
    if($forumData){
        if ($forumData && !empty($forumData['background'])) {
            $backgroundPath = $forumData['background'];
            $_SESSION['background'] = $backgroundPath;
            $wallpaperPath = !empty($forumData['wallpaper']) ? $forumData['wallpaper'] : null;
            $forumCreatorId = $forumData['creator_id']; // ID du créateur

        }
    }else if($forumData == null){
        echo "null";
    }else{
        echo "mauvais data";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title id="page-title"></title>
    <link id="theme-stylesheet" rel="stylesheet"
        href="<?php echo isset($backgroundPath) && $backgroundPath ? $backgroundPath : ($darkMode ? './../../public/css/darkmode.css' : './../../public/css/style.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
</head>

<body class="indexBody">
    <?php require_once("./../composants/navbar_forum.php"); ?>
    <main class="container">
        <?php include './../composants/modal_edit_forum.php'; ?>
        <?php include './../composants/modal_create_forum.php'; ?>
        <?php include './../composants/notification.php'; ?>
        <div class="black-frame">
        <?php if ($wallpaperPath): ?>
        <img src="<?php echo htmlspecialchars($wallpaperPath); ?>" style="position: fixed; height: 100%; width: 100%; filter: blur(7px) brightness(0.4);" alt="Background">
    <?php endif; ?>
            <h1 id="forum-name"  style="position: absolute;"></h1>
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
                    <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] === $forumCreatorId): ?>
                        <button id="openModalEditButton" onclick="openModalEdit()" class="btn-menu">Edit Iceberg</button>
                    <?php endif; ?>
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
                    alert(data.error+"Page d'eurrer");
                    
                    //page erreur 
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
            document.getElementById('forum-name').innerHTML = forum.name;
            document.getElementById('forum-description').textContent = forum.description;
            document.getElementById('creator-username').textContent = forum.creator.username;
            document.getElementById('creator-profile-picture').src = forum.creator.profile_picture || './default-profile.png';
        }
        function reportPost(buttonDiv, forumUrlReport) {
            // Créer un bouton de rapport
            let buttonReport = document.createElement('button'); // Utilisez 'button', pas 'bouton'
            buttonReport.classList.add('buttonReport');
            buttonReport.setAttribute('style', 'cursor: pointer;');
            // Ajouter une image au bouton
            let imgReport = document.createElement('img');
            imgReport.setAttribute('src', './../../public/img/reportButton.png');
            imgReport.setAttribute('class', 'btnReport');
            buttonReport.appendChild(imgReport);

            // Ajouter un événement click au bouton
            buttonReport.addEventListener('click', function () {
                // Créer un formulaire caché dynamiquement
                let hiddenForm = document.createElement('form');
                hiddenForm.setAttribute('method', 'POST');
                hiddenForm.setAttribute('action', './../../Report/ReportContent.php');
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
        function clickLike(button, postId) {
            fetch('./../controleur/like_post.php', {
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
                <?php if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])): ?>

                    const ReportDiv = document.createElement('div');
                    ReportDiv.setAttribute('style', `margin: 0px 0px -45px 0px;`);
                    ReportDiv.classList.add('PalceReport');
                    ReportDiv.setAttribute('style', `margin: 0px 0px -45px 0px;`);
                    postElement.appendChild(ReportDiv);
                <?php endif; ?>
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

                // Créer la description du post et l'ajouter au lien cliquable
                const description = document.createElement('p');
                description.className = 'username';
                description.innerHTML = `${post.content}`;
                postLink.appendChild(description);

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

                    reportPost(ReportDiv, postLink.href);
                <?php endif; ?>

                // Ajouter l'élément de post au conteneur des posts
                postsContainer.appendChild(postElement);
            });
        }


        // Charger les données initiales et les composants
        fetchForumData();

        // Actualiser les données toutes les 10 secondes
        
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

    </style>
    <?php include './../composants/script_link.php'; ?>
    <?php include './../composants/footer.php'; ?>
</body>

</html>