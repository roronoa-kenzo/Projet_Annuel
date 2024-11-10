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
        function fetchForums() {
            fetch('./requetePopular.php')
                .then(response => response.json())
                .then(forums => {
                    const usersList = document.getElementById('usersList');
                    usersList.innerHTML = '';

                    if (forums.length === 0) {
                        usersList.innerHTML = '<div class="post-container-admin"><div class="iceberg-select"><p>No Forum.</p></div></div>';
                    } else {
                        forums.forEach(forum => {
                            const forumElement = document.createElement('div');
                            forumElement.classList.add('white-content');

                            const forumId = encodeURIComponent(forum.forum_id);
                            const forumUrl = `Abyss-Forum.php?forum_id=${forumId}`;

                            forumElement.innerHTML = `
                                <a class="userLien " href="./${forumUrl}">
                                    <div class="iceberg-select-profile ">
                                            <img src="${forum.creator.profile_picture}" alt="Profile Picture" class="user-avatar">
                                            <h3 class="creator-username">${forum.creator.username}</h3>
                                        </div></br>
                                        <span class="">Title: ${forum.forum_name}</span><br><br>
                                        <span class="username">Description:<br>${forum.forum_description}</span><br>
                                        <span class="post-nomber">${forum.post_count} post(s)</span>
                                    </div>
                                </a>
                                `;
                            usersList.appendChild(forumElement);


                        });
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des forums:', error));
        }
        // Actualiser la liste toutes les 10 secondes
        setInterval(fetchForums, 10000);
        // Charger immédiatement au démarrage
        fetchForums();
    </script>
</body>

</html>