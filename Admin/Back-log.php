
<?php
require_once './composant/admin_check.php'; // Inclure le fichier qui vérifie l'accès admin
?>

<?php include './../composants/header.php'; ?>

<body>
    <?php include './../composants/navbar.php'; ?>
    <?php include './composant/database.php'; ?>
    <?php  include './composant/Countsite.php'; ?>


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
                <a href="./ForumInfos.php">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Iceberg : <?php echo $icebergCount ?></p>
                        </div>
                    </div>
                </a>
                <a href="./PostInfos.php">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Post : <?php echo $postCount ?></p>
                        </div>
                    </div>
                </a>
                <a href="./CommentInfos.php">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Message: <?php echo $commentsCount ?></p>

                        </div>
                    </div>
                </a>
                <a href="./ReportPage.php">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Report a resoudre: <?php echo $totalPendingReports ?></p>
                        </div>
                    </div>
                </a>

                <a href="./Ticket_page.php">
                    <div class="post-container-admin">
                        <div class="iceberg-select">
                            <p>Nombre de Tiket a resoudre: <?php echo $tiketCount ?></p>

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