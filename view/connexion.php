<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
    rel="stylesheet">
  <link rel="icon" type="image/png" href="../public/img/abyssicon.png">
</head>

<body class="body_secondary">
    <?php include '../composants/no_user_navbar.php'; ?>
    <div class="DivAllForm">
        <div class="h3Div">
            <h3 class="h3Register">Login</h3>
        </div>
        <form action="login.php" class="Form" method="post">

            <div class="doubleDiv">
                <div>
                    <label for="EmaiLogin" class="labelRegister">Email</label>
                    <input type="text" class="demiInput" name="EmaiLogin" placeholder="Email" id="EmaiLogin">
                </div>
                <div>
                    <label for="PasswordLogin" class="labelRegister">Password</label>
                    <input type="password" class="demiInput" name="PasswordLogin" placeholder="Password" id="PasswordLogin">
                </div>
            </div>
            <div>
              <a href="forgetaccount.php" class="divLink">Forget password or email ?</a>
            </div>
            <button class="buttonSubmit" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
<!-- /
 <form action="login.php" class="formRegistero" method="post">
        <div style="margin-top:5%;">
          <label class="labeLogin" for="email">Email</label>
          <input class="inputText" type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div style="padding-top:7%;">
          <label class="labeLogin" for="password">Password</label>
          <input class="inputText" type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="divLink" style="">
          <a href="register.php" class="alogin">Resgister ?</a>
          <a href="ForgetPass.php" class="alogin" style="margin-right:8%;">Forget PassWord ?</a>
        </div>
        <button type="submit" class="buttonSubmit">Login</button>


      </form> -->