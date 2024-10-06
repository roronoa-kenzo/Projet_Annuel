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

<body>
  <?php require_once('../serveur/sessionStart.php'); ?>
  <?php require_once('../serveur/database.php') ?>

  <?php
  $email = $_POST['email'];
  $formpassword = $_POST['password'];

  if (empty($email) || empty($formpassword)) {
    $_SESSION['ErrorLoginPass'] = 'Email or Password wrong';
    header('Location:connexion.php');
    $pdo = null;
    exit();
  }

  $request = $pdo->prepare("SELECT * FROM users WHERE email =:email");

  $request->bindParam(':email', $email);

  $request->execute();


  $result = $request->fetchAll();
  //verification mod de pass 
  
  if (count($result) > 0 && password_verify($formpassword, $result[0]["password_hash"])) {
    //verification captcha 
    if (isset($_POST['valid'])) {
      if (isset($_POST['captcha'], $_SESSION['code']) && $_POST['captcha'] == $_SESSION['code']) {
        $_SESSION["email"] = $result[0]["email"];
        //header("Location:index.php");      // a mettre a la fin si sa marche
        header("Location:index.php");
      } else {
        $_SESSION['ErrorCaptcha'] = 'Captcha wrong';
        $pdo = null;
        header("Location:connexion.php");
        exit();
      }
    }
  } else {

    $_SESSION['ErrorLoginPass'] = 'Email or Password wrong.';
    header('Location:connexion.php');
    $pdo = null;
    exit();
  }
  ?>
</body>

</html>