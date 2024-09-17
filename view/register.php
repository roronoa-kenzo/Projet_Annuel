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
            font-family: "Josefin Sans", sans-serif;
            padding: 3rem;
        }

        label {
            display: flex;
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
            width: 7rem;
            padding: 4px;
            border-radius: 15px 15px 0 0;
            height: 2rem;
            display: flex;
            justify-content: center;
        }

        .divcenter {
            display: grid;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .doubleDiv {
            display: flex;
            gap: 2vh;
            margin-top: 3vh;
            justify-content: space-between;
        }

        .inputSign {
            border-radius: 10px;
            margin-top: 5px;
            width: 68vh;
            padding: 1vh;
            background-color: #e9ecef;
            font-size: 20px;
            font-family: "Josefin Sans", sans-serif;
            border: none;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        .demiInput {
            border-radius: 10px;
            margin-top: 7px;
            width: 36vh;
            padding: 1vh;
            background-color: #e9ecef;
            font-size: 20px;
            font-family: "Josefin Sans", sans-serif;
            border: none;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }
        .triDiv{
            border-radius: 10px;
            margin-top: 7px;
            width: 30vh;
            padding: 1vh;
            background-color: #e9ecef;
            font-size: 20px;
            font-family: "Josefin Sans", sans-serif;
            border: none;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }
        .LastDiv{
            display: flex;
            gap: 1vh;
            margin-top: 3vh;
        }
    </style>
</head>

<body>
    <nav>
        <img src="../public/img/icon.png" class="logo" alt="">
    </nav>
    <div class="DivAll">
        <div class="h3">
            <h3>Register</h3>
        </div>
        <form action="login.php" class="FormRegister" method="post">

            <div class="doubleDiv">
                <div>
                    <label for="name">Name</label>
                    <input type="text" class="demiInput" name="name" placeholder="Name" id="name">
                </div>
                <div>
                    <label for="firstname">First Name</label>
                    <input type="text" class="demiInput" name="firstname" placeholder="First Name" id="firstname">
                </div>
            </div>

            <!--a faire autrement -->
            <div class="doubleDiv">
                <div>
                    <label for="gender">Gender</label>

                    <select name="gender" class="triDiv" required>
                        <option value="man">man</option>
                        <option value="woman">woman</option>
                        <option value="other">other</option>
                    </select>
                </div>

                <!--a faire autrement -->
                <div style="">
                    <label for="age">Date</label>
                    <input type="text"  class="triDiv" style="width:4.3rem" name="age" placeholder="Age" id="age" required>
                </div>
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone"  class="triDiv" placeholder="Phone Number" id="phone" required>
                </div>
            </div>

            <div class="doubleDiv">
                <div>
                    <label for="email">Email</label>
                    <input type="email" class="demiInput" name="email" placeholder="Email" id="email" required>
                </div>

                <div>
                    <label for="username">Username</label>
                    <input type="text" class="demiInput" name="username" placeholder="Username" id="username" required>
                </div>
            </div>

            <div class="doubleDiv">
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="demiInput" name="password" placeholder="Password" id="password">
                </div>
                <div>
                    <label for="passwordbis">Passeword confirm</label>
                    <input type="password" class="demiInput" name="passwordbis" placeholder="Passeword confirm"
                        id="passwordbis" required>
                </div>
            </div>

            <div class="LastDiv">
                <input type="checkbox" name="condition" id="condition" required>
                <label for="condition">Accept conditions</label>
            </div>
            <button class="buttonSubmit" type="submit">Sign up</button>
        </form>
    </div>
</body>

</html>