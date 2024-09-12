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
    <?php include '../composants/navbar.php'; ?>
<div class="container-sign">
    <div>
      <h3>Register</h3>
    </div>
    <form action="capcha.php" method="post">
      <label for="Name">Name</label>
      <input type="text" name="Name" id="Name">

      <label for="FirstName">First Name</label>
      <input type="text" name="FirstName" id="FirstName">


<!--a faire autrement -->
      <label for="Gender">Gender</label>
      <input type="text" name="Gender" id="Gender">

      <!--a faire autrement -->
      <label for="Age">Age</label>
      <input type="text" name="Age" id="Age">
</body>
</html>