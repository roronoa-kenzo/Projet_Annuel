<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="../image/png" href="../public/img/abyssicon.png">
</head>

<body>
    <nav>
        <img src="../public/img/icon.png" alt="">
    </nav>
    <div class="container-sign">
        <div>
            <h3>Register</h3>
        </div>
        <form action="login.php" method="post">

            <div>
                <label for="name">Name</label>
                <input type="text" name="name" id="name">

                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname">
            </div>

            <!--a faire autrement -->
            <div>
                <label for="gender">Gender</label>
                <select name="gender" required>
                    <option value="man">man</option>
                    <option value="woman">woman</option>
                    <option value="other">other</option>
                </select>

                <!--a faire autrement -->
                <label for="Age">Age</label>

                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">

                <label for="passwordbis">Passeword confirm</label>
                <input type="password" name="passwordbis" id="passwordbis" required>
            </div>

            <div>
                <input type="checkbox" name="condition" id="condition" required>
                <label for="condition">Accept terms and conditions</label>
            </div>
            <button type="submit">Sign up</button>
        </form>
    </div>
</body>

</html>