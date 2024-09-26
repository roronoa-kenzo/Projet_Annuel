<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Abyss</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="../public/img/abyssicon.png">
    <?php require_once("../composants/ResquestDarkMode.php"); ?>
</head>

<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?> indexBody">
    
    <?php include '../composants/navbar.php'; ?>

    <main class="container">
        <div class="black-frame">
            <h1>Welcome in Abyss</h1>
        </div>
        <div class="main-index">
            <?php include '../composants/white_content_left.php'; ?>
            <div class="white-content">
                <div class="post-container">
                    <div class="post-header">
                        <img src="../public/img/user-avatar.png" alt="User Avatar" class="user-avatar">
                        <?php include '../composants/post-options.php'; ?>
                        <div class="iceberg-select">
                            <select>
                                
                            </select>
                        </div>
                    </div>

                    <div id="textContent" style="display: none;">
                        <textarea class="post-textarea" placeholder="Text..."></textarea>
                    </div>

                    <div id="imageVideoContent" style="display: none;">
                        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                            <textarea class="post-textarea" name="description" placeholder="Description..."></textarea>
                            <input type="file" id="fileToUpload" name="fileToUpload" accept=".png, .mp4">
                            <button type="submit" name="submit">Upload</button>
                        </form>
                    </div>

                    <div id="linkContent" style="display: none;">
                        <textarea class="post-textarea" placeholder="Lien..."></textarea>
                    </div>

                    <style>
                        textarea {
                            resize: none;
                        }
                    </style>
                </div>
            </div>
            <?php include '../composants/white_content_right.php'; ?>
        </div>
    </main>
    <script src="../public/js/searchbar.js"></script>
    <script src="../public/js/darkmode.js"></script>
    <script src="../public/js/upload.js"></script>
    <script src="../public/js/createpost.js"></script>

    <!-- Ajout du script pour gérer l'affichage dynamique -->
    <script>
        document.getElementById("textButton").addEventListener("click", function () {
            document.getElementById("textContent").style.display = "block";
            document.getElementById("imageVideoContent").style.display = "none";
            document.getElementById("linkContent").style.display = "none";
        });

        document.getElementById("imageVideoButton").addEventListener("click", function () {
            document.getElementById("textContent").style.display = "none";
            document.getElementById("imageVideoContent").style.display = "block";
            document.getElementById("linkContent").style.display = "none";
        });

        document.getElementById("linkButton").addEventListener("click", function () {
            document.getElementById("textContent").style.display = "none";
            document.getElementById("imageVideoContent").style.display = "none";
            document.getElementById("linkContent").style.display = "block";
        });
        document.addEventListener('DOMContentLoaded', function () {
        // Supprime la classe qui empêche la transition après le chargement de la page
        document.body.classList.remove('no-transition');
        });
    </script>
</body>

</html>