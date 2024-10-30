<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="./../image/png" href="./../public/img/abyssicon.png">
    <?php require_once("./../composants/ResquestDarkMode.php"); ?>

</head>


<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?> body_secondary">
    <?php include './../composants/no_user_navbar.php'; ?>
    <?php require_once('./../serveur/sessionStart.php'); ?>


    <div class="DivAllForm">
        <div class="h3Div">
            <h3 class="h3Register">Register</h3>
        </div>
        <form action="./registerResult.php" class=" Form" method="post">

            <div class="doubleDiv">
                <div>
                    <label for="lastname" class="labelRegister">Last Name</label>
                    <input type="text" class="demiInput" name="lastname" placeholder="Last Name" id="lastname" required>
                    <?php
                    if (isset($_POST['Errorlastname'])) {
                        echo '<p style="color: red;">' . $_POST['Errorlastname'] . '</p>';
                        unset($_POST['Errorlastname']);
                    }
                    ?>
                </div>
                <div>
                    <label for="firstname" class="labelRegister">First Name</label>
                    <input type="text" class="demiInput" name="firstname" placeholder="First Name" id="firstname"
                        required>
                    <?php
                    if (isset($_POST['Errorfirstname'])) {
                        echo '<p style="color: red;">' . $_POST['Errorfirstname'] . '</p>';
                        unset($_POST['Errorfirstname']);
                    }
                    ?>
                </div>
            </div>

            <!--a faire autrement -->
            <div class="doubleDiv">
                <div>
                    <label for="gender" class="labelRegister">Gender</label>

                    <select name="gender" class="triDiv" required>
                        <option value="man">man</option>
                        <option value="woman">woman</option>
                        <option value="other">other</option>
                    </select>
                    <?php
                    if (isset($_POST['Errorgender'])) {
                        echo '<p style="color: red;">' . $_POST['Errorgender'] . '</p>';
                        unset($_POST['Errorgender']);
                    }
                    ?>
                </div>

                <!--a faire autrement -->
                <div style="">
                    <label for="age" class="labelRegister">Date of birth</label>
                    <input type="Date" class="triDiv" style="width:11vh" name="date" placeholder="Birth" id="date"
                        required>
                    <?php
                    if (isset($_POST['Errordatebrith'])) {
                        echo '<p style="color: red;">' . $_POST['Errordatebrith'] . '</p>';
                        unset($_POST['Errordatebrith']);
                    }
                    ?>
                </div>
                <div>
                    <label for="phone" class="labelRegister">Phone Number</label>
                    <input type="text" name="phone" class="triDiv" placeholder="Phone Number" id="phone" required>
                    <?php
                    if (isset($_POST['Errorphone'])) {
                        echo '<p style="color: red;">' . $_POST['Errorphone'] . '</p>';
                        unset($_POST['Errorphone']);
                    }
                    ?>
                </div>
            </div>

            <div class="doubleDiv">
                <div>
                    <label for="email" class="labelRegister">Email</label>
                    <input type="email" class="demiInput" name="email" placeholder="Email" id="email" required>
                    <?php
                    if (isset($_POST['Erroremail'])) {
                        echo '<p style="color: red;">' . $_POST['Erroremail'] . '</p>';
                        unset($_POST['Erroremail']);
                    }
                    ?>
                </div>

                <div>
                    <label for="username" class="labelRegister">Username</label>
                    <input type="text" class="demiInput" name="username" placeholder="Username" id="username" required>
                    <?php
                    if (isset($_POST['Errorformusername'])) {
                        echo '<p style="color: red;">' . $_POST['Errorformusername'] . '</p>';
                        unset($_POST['Errorformusername']);
                    }
                    ?>
                </div>
            </div>

            <div class="doubleDiv">
                <div>
                    <label for="password" class="labelRegister">Password</label>
                    <input type="password" class="demiInput" name="password" placeholder="Password" id="password"
                        required>
                    <?php
                    if (isset($_POST['Errorformpassword'])) {
                        echo '<p style="color: red;">' . $_POST['Errorformpassword'] . '</p>';
                        unset($_POST['Errorformpassword']);
                    }
                    ?>
                </div>
                <div>
                    <label for="passwordbis" class="labelRegister">Passeword confirm</label>
                    <input type="password" class="demiInput" name="passwordbis" placeholder="Passeword confirm"
                        id="passwordbis" required>
                    <?php
                    if (isset($_POST['Errorpasswordbis'])) {
                        echo '<p style="color: red;">' . $_POST['Errorpasswordbis'] . '</p>';
                        unset($_POST['Errorpasswordbis']);
                    }
                    ?>
                </div>
            </div><br />
            <div class="captchaDiv" id="captchaDiv" style="display: none;">

                <img src="./../capcha/captcha.php" alt="CAPTCHA" /><br />

                <input type="text" name="captcha" class="demiInput" placeholder="Captcha" required />

                <?php
                if (isset($_POST['ErrorCaptcha'])) {
                    echo '<p style="color: red;">' . $_POST['ErrorCaptcha'] . '</p>';
                    unset($_POST['ErrorCaptcha']);
                }
                ?>
            </div>
            <div class="LastDiv">
                <input type="checkbox" onclick="showCaptcha()" name="condition" id="condition" required>
                <label for="condition">Accept conditions</label>
            </div>
            <button class="buttonSubmit" name="valid" type="submit">Sign up</button>
        </form>
    </div>
    <script>
        function showCaptcha() {
            document.getElementById('captchaDiv').style.display = 'block';
            document.getElementById('submitBtn').style.display = 'block';

        }
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.remove('no-transition');
        });
    </script>
</body>

</html>