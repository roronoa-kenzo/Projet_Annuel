<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <title>Back Log</title>
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
    rel="stylesheet">
  <link rel="icon" type="../image/png" href="../img/abyssicon.png">

</head>

<body>
  <nav class="navbar">

    <img src="../img/icon.png" alt="Abyss" class="logo">
  </nav>
  <div class="containerForm">
    <div>

      <h1 class="fontSignIn">Sign in</h1>
    </div>
    <div>
      <form action="home-user.php" method="post">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Enter</button>

        <a href="../register/register.php">Resgister ?</a>
        <a href="../forguetPass/ForgetPass.php">Forget PassWord ?</a>

      </form>
    </div>
  </div>
</body>
</html>