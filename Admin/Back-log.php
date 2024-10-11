<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Back Log</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="../public/image/png" href="../public/img/abyssicon.png">
</head>

<body>
    <?php include './../composants/navbar.php'; ?>
    <?php include './composant/database.php'; ?>
    <?php include './composant/Countsite.php'; ?>

    <main class="container">
        <div class="black-frame">
            <h1>Admin</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

                <a href="./UserInfo.php">
                    <div class="post-container-admin">

                        <div class="iceberg-select">
                            <p>Nombre de user totale: <?php echo $userCount ?></p>
                        </div>
                    </div>
                </a>
                <div class="post-container-admin">

                    <a href="#">
                        <div class="iceberg-select">
                            <p>Nombre de user connecter: <?php echo $useconnectCount ?></p>
                        </div>
                </div>
                </a>
                <a href="#">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Message: <?php echo $commentsCount ?></p>

                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Post : <?php echo $postCount ?></p>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Iceberg : <?php echo $icebergCount ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>