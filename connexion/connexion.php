<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign up in Abyss</title>


</head>

<body>
  <nav class="navbar">
    <img src="../img/icon.png" alt="Abyss" class="logo">
  </nav>
  <div class="container-sign">
    <div>
      <h3>Sign in</h3>
    </div>
    <form action="capcha.php" method="post">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="Email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" required>

      <button type="submit">Enter</button>

      <a href="../register/register.php">Resgister ?</a>
      <a href="../forguetPass/ForgetPass.php">Forget PassWord ?</a>
    </form>
  </div>
</body>

</html>