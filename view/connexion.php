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
    body{
      background-color: black;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      font-family: "Josefin Sans", sans-serif;
    }

    .FormSign{
      background-color: white;
      border-radius: 0 15px 15px 15px;
      margin: -4px;
      width: 80vh;
    }

    .Divtilte{
      background-color: white;
      width: 10rem;
      border-radius: 15px 15px 0 0;
      display: flex;
      justify-content: center;
      margin: -45px 0 0 0;
      padding-top: 1rem;
    }
    
    .DivAll {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .form{
      margin: 0% 0 5% 5%;
    }
    .inputText{
      border-radius: 10px;
      margin-top:5px;
      width: 68vh;
      padding: 1vh;
      background-color: #e9ecef;
      font-size: 20px;
      font-family: "Josefin Sans", sans-serif;
      border: none;
      box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
    }
    .h3{
      margin-top: 2%;
      font-size: 30px;
    }
    .label{
      font-size: 20px;
      font-weight: bolder;
    }
    .a{
      display: inline-block;
      color: black;
    }
    .divLink{
      display: flex;
      justify-content: space-between;
      gap:10vh;
      font-size: 16px;
      color: black;
      padding-top:1vh;
    }
    .buttonSubmit{
      margin: 5% 0% 0% 17%;
      padding: 1vh;
      width: 60%;
      font-family: "Josefin Sans", sans-serif;
      font-size: 20px;
      background-color: black;
      color: white;
      border-radius: 10px;
      font-weight: bolder;
      border: none;
    }
    .inputText:hover{
      color:black;
    }
    .buttonSubmit:hover{
      background-color: grey;
    }
  </style>
</head>

<body>
  <nav class="">
    <img src="../public/img/icon.png" alt="Abyss" class="logo">
  </nav>
  <div class="DivAll">
    <div class="FormSign">
        <div class="Divtilte" >
          <h3 class="h3">Login</h3>
          </div>
      <form action="home-user.php" class="form" method="post">
        <div style="margin-top:5%;">
          <label class="label" for="email">Email</label>
          <input class="inputText" type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div style="padding-top:7%;">
          <label class="label" for="password">Password</label>
          <input class="inputText" type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="divLink" style="">
          <a href="register.php" >Resgister ?</a>
          <a href="ForgetPass.php" style="margin-right:8%;">Forget PassWord ?</a>
        </div>
        <button type="submit" class="buttonSubmit">Login</button>


      </form>
    </div>
  </div>
</body>

</html>