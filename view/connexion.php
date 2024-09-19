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

<body class="Loginbody">
  <nav class="">
    <img src="../public/img/icon.png" alt="Abyss" class="logo">
  </nav>
  <div class="DivAll">
    <div class="FormSign">
        <div class="Divtilte" >
          <h3 class="h3Login">Login</h3>
          </div>
      <form action="home-user.php" class="formLogin" method="post">
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


      </form>
    </div>
  </div>
</body>

</html>