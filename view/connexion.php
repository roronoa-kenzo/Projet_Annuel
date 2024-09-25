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
        <form action="loginResult.php" class="Form" method="post">

            <div class="doubleDiv">
                <div>
                    <label for="email" class="labelRegister">Email</label>
                    <input type="email" class="demiInput" name="email" placeholder="Email" id="email" required>
                </div>
                <div>
                    <label for="password" class="labelRegister">Password</label>
                    <input type="password" class="demiInput" name="password" placeholder="Password" id="password" required>
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