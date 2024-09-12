<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Back Log</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="../image/png" href="../img/abyssicon.png">
</head>

<body>
    <?php include '../composants/navbar.php'; ?>
    <main class="container">
        <div class="black-frame">
            <h1>Admin</h1>
        </div>
        <div class="main-index">
            <?php include '../composants/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

                <div class="post-container-admin">
                    <div class="iceberg-select">
                        <p>Nombre de user:</p>
                    </div>
                </div>

                <div class="post-container-admin">
                    <div class="iceberg-select">
                        <p>Nombre de Message:</p>
                    </div>
                </div>

                <div class="post-container-admin">
                    <div class="iceberg-select">
                        <p>Nombre de Post :</p>
                    </div>
                </div>

                <div class="post-container-admin">
                    <div class="iceberg-select">
                        <p>Nombre de Iceberg :</p>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script src="../js/searchbar.js"></script>
    <script src="../js/darkmode.js"></script>
    <script src="../js/upload.js"></script>

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
    </script>
</body>