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
</head>
<htm>

    <?php

    require_once('../serveur/database.php');
    require_once('../serveur/sessionStart.php');

    $lastname = $_POST['lastname'];
    $firstName = $_POST['firstname'];
    $gender = $_POST['gender'];
    $date = $_POST['date'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordbis = $_POST['passwordbis'];
    $xp = 10;
    $level = 1;
    $is_admin = FALSE;
    $is_banned = FALSE;

    if (empty($lastname) || empty($firstName) || empty($gender) || empty($date) || empty($phone) || empty($email) || empty($username) || empty($password) || empty($passwordbis)) {
        header:
        ('Locacation: registerResult.php');
    }

    if ($password == $passwordbis) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $request = $pdo->prepare('INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, xp, level, is_admin, is_banned) VALUES (:username, :email, :password, :firstname, :lastname, :date , :xp, :level, :is_admin, :is_banned)');
        $request->bindParam(':username', $username);
        $request->bindParam(':email', $email);
        $request->bindParam(':password', $password_hash);
        $request->bindParam(':firstname', $first_name);
        $request->bindParam(':lastname', $last_name);
        $request->bindParam(':date_of_birth', $date_of_birth);
        $request->bindParam(':xp', $xp);
        $request->bindParam(':level', $level);
        $request->bindParam(':is_admin', $is_admin);
        $request->bindParam(':is_banned', $is_banned);

        // assure-toi que la date est au bon format (YYYY-MM-DD)
        $request->execute();


        if ($request->rowCount() === 1) {
            /* Si l'utilisateur a bien été crée, j'affiche un message de succès */
            echo "L'utilisateur a été ajouté avec succès.";
        } else {
            /* Sinon j'affiche un message d'erreur */
            echo "Une erreur est survenue lors de l'ajout de l'utilisateur.";
        }
    } else {
        /* J'affiche un message d'erreur si les mots de passe ne correspondent pas */
        echo 'Les mots de passe ne correspondent pas';
    }

    /* On ferme la connexion à la base de données */
    $pdo = null;


    ?>
    <!-- 
INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, xp, level, is_admin, is_banned) VALUES
('john_doe', 'john@example.com', 'hash_password_1', 'John', 'Doe', '1990-01-01', 150, 2, FALSE, FALSE), 
-->
    </body>

</html>