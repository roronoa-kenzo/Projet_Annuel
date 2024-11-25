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


    </script>
</body>

</html>