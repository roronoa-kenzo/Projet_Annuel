<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="../image/png" href="../public/img/abyssicon.png">
</head>

<body class="body_secondary">
    <?php include '../composants/no_user_navbar.php'; ?>
    <?php require_once('../serveur/sessionStart.php'); ?>
    <?php require_once("../serveur/database.php") ?>

    <div class="DivAllForm">
        <div class="h3Div">
            <h3 class="h3Register">Register</h3>
        </div>
        <form action="registerResult.php" class="Form" method="post">

            <div class="doubleDiv">
                <div>
                    <label for="lastname" class="labelRegister">Last Name</label>
                    <input type="text" class="demiInput" name="lastname" placeholder="Last Name" id="lastname" required>
                    <?php
                    if (isset($_SESSION['Errorlastname'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errorlastname'] . '</p>';
                        unset($_SESSION['Errorlastname']);
                    }
                    ?>
                </div>
                <div>
                    <label for="firstname" class="labelRegister">First Name</label>
                    <input type="text" class="demiInput" name="firstname" placeholder="First Name" id="firstname"
                        required>
                    <?php
                    if (isset($_SESSION['Errorfirstname'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errorfirstname'] . '</p>';
                        unset($_SESSION['Errorfirstname']);
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
                    if (isset($_SESSION['Errorgender'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errorgender'] . '</p>';
                        unset($_SESSION['Errorgender']);
                    }
                    ?>
                </div>

                <!--a faire autrement -->
                <div style="">
                    <label for="age" class="labelRegister">Date of birth</label>
                    <input type="Date" class="triDiv" style="width:11vh" name="date" placeholder="Birth" id="date"
                        required>
                    <?php
                    if (isset($_SESSION['Errordatebrith'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errordatebrith'] . '</p>';
                        unset($_SESSION['Errordatebrith']);
                    }
                    ?>
                </div>
                <div>
                    <label for="phone" class="labelRegister">Phone Number</label>
                    <input type="text" name="phone" class="triDiv" placeholder="Phone Number" id="phone" required>
                    <?php
                    if (isset($_SESSION['Errorphone'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errorphone'] . '</p>';
                        unset($_SESSION['Errorphone']);
                    }
                    ?>
                </div>
            </div>

            <div class="doubleDiv">
                <div>
                    <label for="email" class="labelRegister">Email</label>
                    <input type="email" class="demiInput" name="email" placeholder="Email" id="email" required>
                    <?php
                    if (isset($_SESSION['Erroremail'])) {
                        echo '<p style="color: red;">' . $_SESSION['Erroremail'] . '</p>';
                        unset($_SESSION['Erroremail']);
                    }
                    ?>
                </div>

                <div>
                    <label for="username" class="labelRegister">Username</label>
                    <input type="text" class="demiInput" name="username" placeholder="Username" id="username" required>
                    <?php
                    if (isset($_SESSION['Errorformusername'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errorformusername'] . '</p>';
                        unset($_SESSION['Errorformusername']);
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
                    if (isset($_SESSION['Errorformpassword'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errorformpassword'] . '</p>';
                        unset($_SESSION['Errorformpassword']);
                    }
                    ?>
                </div>
                <div>
                    <label for="passwordbis" class="labelRegister">Passeword confirm</label>
                    <input type="password" class="demiInput" name="passwordbis" placeholder="Passeword confirm"
                        id="passwordbis" required>
                    <?php
                    if (isset($_SESSION['Errorpasswordbis'])) {
                        echo '<p style="color: red;">' . $_SESSION['Errorpasswordbis'] . '</p>';
                        unset($_SESSION['Errorpasswordbis']);
                    }
                    ?>
                </div>
            </div>

            <div class="LastDiv">
                <input type="checkbox" name="condition" id="condition" required>
                <label for="condition">Accept conditions</label>
            </div>
            <button class="buttonSubmit" type="submit">Sign up</button>
        </form>
    </div>
</body>

</html>