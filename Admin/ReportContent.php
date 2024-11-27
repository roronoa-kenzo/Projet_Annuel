<?php
require_once './composant/admin_check.php';
include './../composants/header.php';
include './composant/database.php';
include './composant/sessionStart.php';
$Report_id = $_GET['Report_id'] ?? null;

?>

<body>
    <?php include './../composants/navbar.php'; 
    ?>
    <main class="container">
        <div class="black-frame">
            <h1>Reporte item</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

               
            </div>
            
        </div>
    </main>

    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>