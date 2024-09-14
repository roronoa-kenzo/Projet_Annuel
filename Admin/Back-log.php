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
    <link rel="icon" type="../image/png" href="../public/img/abyssicon.png">
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
    <script src="../public/js/searchbar.js"></script>
    <script src="../public/js/darkmode.js"></script>

</body>
</html>