<?php include '../composants/header.php'; ?>
<?php include '../composants/navbar.php'; ?>
<main class="container">
        <div class="black-frame">
            <h1>Profile</h1>
        </div>
        <div class="main-index">
            <?php include '../composants/white_content_left.php'; ?>
            <div class="white-content">
               <div class="profile_first">
                  <img src="<?php echo htmlspecialchars($_SESSION["user_profile"]); ?>" alt="User Avatar" class="user-avatar">
                  <h2><strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></h2>
               </div>
            </div>
            <?php include '../composants/white_content_right.php'; ?>
        </div>
    </main>
    <?php include '../composants/script_link.php'; ?>
<?php include '../composants/footer.php'; ?>