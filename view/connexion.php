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
  <style>
    body {
      background-color: black;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      font-family: "Josefin Sans", sans-serif;
    }
    .FormSign{
      background-color: white;
      width: 29rem;
      position: relative;
      border-radius: 15px 15px 15px 15px;
      margin: -4px;
    }

    .Divtilte{
      background-color: white;
      width: 7rem;
      padding: 0 1vh 0 0;
      border-radius: 15px 15px 0 0;
      display: flex;
      justify-content: center;
      margin: -30px 0 0 -15rem;
      z-index: 200;
    }
    
    .DivAll {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .form{
      padding: 10%;
      
    }
    .inputText{
      border-radius: 10px;
      margin-top:5px;
      width: 20rem;
      padding: 2%;
      background-color: #e9ecef;
    }
  </style>
</head>

<body>
  <nav class="">
    <img src="../public/img/icon.png" alt="Abyss" class="logo">
  </nav>
  <div class="DivAll">
    <div class="Divtilte" >
      <h3>Login</h3>
    </div>
    <div class="FormSign">
      <form action="home-user.php" class="form" method="post">
        <div style="padding: 5%;">
          <label for="email">Email</label>
          <input class="inputText" type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div style="padding: 5%;">
          <label for="password">Password</label>
          <input class="inputText" type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div>
          <a href="register.php">Resgister ?</a>
          <a href="ForgetPass.php">Forget PassWord ?</a>
        </div>
        <button type="submit">Entre</button>


      </form>
    </div>
  </div>
</body>

</html>