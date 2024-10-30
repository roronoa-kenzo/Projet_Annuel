<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
    <?php require_once("./../composants/ResquestDarkMode.php"); ?>

</head>

<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?> body_secondary">
    <?php include './../composants/no_user_navbar.php'; ?>
    <?php require_once('./../serveur/sessionStart.php'); ?>


    <div class="DivAllForm">
        <div class="h3Div">
            <h3 class="h3Register">Login</h3>
        </div>
        <form action="loginResult.php" class="Form" method="post">

            <div class="doubleDiv">
                <div>
                    <label for="email" class="labelRegister">Email</label>
                    <input type="email" class="demiInput" name="email" placeholder="Email" id="email" require>
                    <?php
                    if (isset($_SESSION['ErrorLoginPass'])) {
                        echo '<p style="color: red;">' . $_SESSION['ErrorLoginPass'] . '</p>';
                        unset($_SESSION['ErrorLoginPass']);
                    }
                    ?>
                </div>
                <div>
                    <label for="password" class="labelRegister">Password</label>
                    <input type="password" class="demiInput" name="password" placeholder="Password" id="password"
                        require>
                </div>
            </div></br>

            <div class="captchaDiv" id="captchaDiv" style="display: none;">

                <img src="./../capcha/captcha.php" alt="CAPTCHA" /><br />
                <input type="text" name="captcha" class="demiInput" placeholder="Captcha" required />


                <?php
                if (isset($_SESSION['ErrorCaptcha'])) {
                    echo '<p style="color: red;">' . $_SESSION['ErrorCaptcha'] . '</p>';
                    unset($_SESSION['ErrorCaptcha']);
                }
                ?>
            </div>
            <div>

                <a href="forgetPassWord.php" class="divLink">Forget password or email ?</a>

            </div>

            <button class="buttonSubmit" name="valid" onclick="showCaptcha()" type="submit">Login</button>
            <script>
                function showCaptcha() {

                    document.getElementById('captchaDiv').style.display = 'block';

                    document.getElementById('submitBtn').style.display = 'block';
                }
            </script>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.remove('no-transition');
        });
    </script>
</body>

</html>