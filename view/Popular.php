<?php
include './../serveur/database.php';

session_start();

$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link id="theme-stylesheet" rel="stylesheet"
        href="./../public/css/<?php echo $darkMode ? 'darkmode' : 'style'; ?>.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Popular</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
    <?php require_once("./../composants/ResquestDarkMode.php"); ?>

</head>

<body class="indexBody">
    <?php require_once("./../composants/navbarNav.php"); ?>
    <main class="container">
        <div class="black-frame">
            <h1>Most forums popular</h1>
        </div>
        <div class="main-index">
            <?php include './../composants/white_content_left.php'; ?>
            <div class="users-list" id="usersList">
                <!-- Actualisation des forum ici -->
            </div>
            <?php include './../composants/white_content_right.php'; ?>
        </div>
    </main>
    <?php include './../composants/script_link.php'; ?>
    <?php include './../composants/footer.php'; ?>

    <script>
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

        function fetchForums() {
            fetch('./requetePopular.php')
                .then(response => response.json())
                .then(forums => {
                    let usersList = document.getElementById('usersList');
                    usersList.textContent = '';  // Vide le contenu précédent

                    if (forums.length === 0) {
                        let noForumElement = document.createElement('div');
                        noForumElement.classList.add('post-container-admin');

                        let icebergSelectDiv = document.createElement('div');
                        icebergSelectDiv.classList.add('iceberg-select');

                        let noForumText = document.createElement('p');
                        noForumText.textContent = 'No Forum.';

                        icebergSelectDiv.appendChild(noForumText);
                        noForumElement.appendChild(icebergSelectDiv);
                        usersList.appendChild(noForumElement);
                    } else {
                        forums.forEach(forum => {
                            let forumElement = document.createElement('div');
                            forumElement.classList.add('white-content');

                            // Créer le bouton d'abonnement (si l'utilisateur est connecté)
                            <?php if (!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])): ?>
                                let buttonDiv = document.createElement('div');

                                buttonDiv.classList.add('buttonSubscrib');
                                buttonDiv.setAttribute('style', `margin: 0px 0px -35px 0px;`);

                                let subscribeButton = document.createElement('button');
                                subscribeButton.classList.add('post-forum');
                                subscribeButton.id = `subscribe-button-${encodeURIComponent(forum.forum_id)}`;
                                subscribeButton.setAttribute('onclick', `subrequette(${encodeURIComponent(forum.forum_id)}, <?php echo $_SESSION['user_id']; ?>)`);

                                subscribeButton.setAttribute('style', `cursor: pointer;`);

                                let buttonText = document.createElement('strong');
                                buttonText.classList.add('p-forum');
                                buttonText.textContent = 'Subscribe';

                                subscribeButton.appendChild(buttonText);
                                buttonDiv.appendChild(subscribeButton);
                                forumElement.appendChild(buttonDiv);

                                // creation du bouton de reports
                                let forumIdReport = forum.forum_id;
                                let forumUrlReport = `https://Abyss-Forum.php?forum_id=${forumIdReport}`;
                                reportPost(buttonDiv,forumUrlReport);
                            <?php endif; ?>

                            // Créer l'élément de profil de l'auteur
                            let icebergProfileDiv = document.createElement('div');
                            icebergProfileDiv.classList.add('iceberg-select-profile');

                            let profileImage = document.createElement('img');
                            profileImage.classList.add('user-avatar');
                            profileImage.src = forum.creator.profile_picture;
                            profileImage.alt = 'Profile Picture';

                            let creatorUsername = document.createElement('h3');
                            creatorUsername.classList.add('creator-username');
                            creatorUsername.textContent = forum.creator.username;

                            icebergProfileDiv.appendChild(profileImage);
                            icebergProfileDiv.appendChild(creatorUsername);
                            forumElement.appendChild(icebergProfileDiv);

                            // Créer une div cliquable pour le titre et la description
                            let forumId = encodeURIComponent(forum.forum_id);
                            let forumUrl = `Abyss-Forum.php?forum_id=${forumId}`;

                            let clickableDiv = document.createElement('div');
                            clickableDiv.classList.add('clickable-div');
                            clickableDiv.onclick = () => {
                                window.location.href = forumUrl;
                            };
                            clickableDiv.setAttribute('style', `cursor: pointer;`);

                            // Créer le titre du forum et l'ajouter à la div cliquable
                            let titleSpan = document.createElement('span');
                            titleSpan.textContent = `Title: ${forum.forum_name}`;
                            clickableDiv.appendChild(titleSpan);

                            // Saut de ligne
                            clickableDiv.appendChild(document.createElement('br'));
                            clickableDiv.appendChild(document.createElement('br'));

                            // Créer la description du forum et l'ajouter à la div cliquable
                            let descriptionSpan = document.createElement('span');
                            descriptionSpan.classList.add('username');
                            descriptionSpan.innerHTML = `Description:<br>${forum.forum_description}`;
                            clickableDiv.appendChild(descriptionSpan);

                            // Ajouter la div cliquable au forumElement
                            forumElement.appendChild(clickableDiv);

                            // Créer le nombre de posts
                            let postCountSpan = document.createElement('span');
                            postCountSpan.classList.add('post-nomber');
                            postCountSpan.textContent = `${forum.post_count} post(s)`;
                            forumElement.appendChild(postCountSpan);

                            // Ajouter l'élément principal à la liste des forums
                            usersList.appendChild(forumElement);
                        });
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des forums:', error));
        }

        function subrequette(forum_id, user_id) {
            // Préparer les données à envoyer
            let data = {
                forum_id: forum_id,
                user_id: user_id
            };
            let button = document.getElementById(`subscribe-button-${forum_id}`);

            // Vérifier si l'utilisateur est déjà abonné (en utilisant la classe ou le texte du bouton)
            let isSubscribed = button.classList.contains('subscribed');

            // Définir l'action à effectuer : abonnement ou désabonnement
            let action = isSubscribed ? 'unsubscribe' : 'subscribe';
            fetch('./../composants/requeteMenuSubsrip.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ...data, action: action }) // Ajouter l'action au body
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (action === 'subscribe') {
                            button.classList.add('subscribed');
                            button.innerHTML = '<strong class="p-forum">add sub</strong>';
                            console.log('Abonnement réussi');
                        } else if (action === 'unsubscribe') {
                            button.classList.remove('subscribed');
                            button.innerHTML = '<strong class="p-forum">Subscribe</strong>';
                            console.log('Désabonnement réussi');
                        }
                    } else {
                        console.error('Erreur:', data.message);
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de l\'envoi des données:', error);
                    alert('Erreur lors de l\'envoi des données');
                });
        }
        // Actualiser la liste toutes les 10 secondes
        setInterval(fetchForums, 10000);
        // Charger immédiatement au démarrage
        fetchForums();
    </script>
</body>
<style>
    .buttonSubscrib {
        display: flex;
        justify-content: end;
    }

    .buttonReport {
        padding-top: 3px;
        border: none;
        background: none;
    }

    .btnReport {
        height: 3.5vh;
        padding-left: 1rem;
    }
</style>

</html>