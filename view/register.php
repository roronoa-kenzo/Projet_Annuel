<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="../image/png" href="../public/img/abyssicon.png">
    <style>
        .FormRegister {
            background-color: white;
            border-radius: 0 15px 15px 15px;
            width: 50%;
            padding: 2%;
        }

        .FormRegister{
            
        }
        label {
            display: flex;
            padding: 4%;
            margin: 10%;
        }

        body {
            background-color: black;
            width: 100%;
            height: 100%;
        }

        .containerSign {
            width: 40vh;
        }

        .h3 {
            background-color: white;
            width: 12vh;
            padding: 5px;
            border-radius: 15px 15px 0 0;

        }

        .divcenter {
            display: flex;
            align-items: center;
            justify-content: center;

        }
    </style>
</head>

<body>
    <nav>
        <img src="../public/img/icon.png" class="logo" alt="">
    </nav>
    <div class="divcenter">
        <div class="h3">
            <h3>Register</h3>
        </div>
        <form action="login.php" class="FormRegister" method="post">

            <div>
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Name" id="name">

                <label for="firstname">First Name</label>
                <input type="text" name="firstname" placeholder="First Name" id="firstname">
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
                <label for="age">Age</label>
                <input type="text" name="age" placeholder="Age" id="age" required>

                <label for="phone">Phone Number</label>
                <input type="text" name="phone" placeholder="Phone Number" id="phone" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" id="email" required>

                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" id="username" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" id="password">

                <label for="passwordbis">Passeword confirm</label>
                <input type="password" name="passwordbis" placeholder="Passeword confirm" id="passwordbis" required>
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