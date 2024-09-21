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

<body>
    <?php require_once("../serveur/database.php"); ?>

    <?php require_once('../serveur/sessionStart.php'); ?>

    <?php

    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $gender = $_POST['gender'];
    $datebrith = $_POST['date'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $formusername = $_POST['username'];
    $formpassword = $_POST['password'];
    $passwordbis = $_POST['passwordbis'];
    $xp = 10;
    $level = 1;
    $is_admin = 0;
    $is_banned = 0;

    require_once('../serveur/sessionStart.php');
    if(){}else if(){}else if(){}else if(){}else if(){}else if(){}else if(){}
    if (empty($lastname) || empty($firstName) || empty($gender) || empty($datebrith) || empty($phone) || empty($email) || empty($formusername) || empty($formpassword) || empty($passwordbis)) {
        echo "Tous les champs sont obligatoires.";
    }

    if ($formpassword == $passwordbis) {

        // Préparation de la requête
        $formpassword = password_hash($formpassword, PASSWORD_DEFAULT);

        $request = $pdo->prepare('INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, xp, level, is_admin, is_banned) VALUES (:username, :email, :password_hash, :first_name, :last_name, :date_of_birth, :xp, :level, :is_admin, :is_banned)');
        $request->bindParam(':username', $formusername);
        $request->bindParam(':email', $email);
        $request->bindParam(':password_hash', $formpassword);
        $request->bindParam(':first_name', $firstname);
        $request->bindParam(':last_name', $lastname);
        $request->bindParam(':date_of_birth', $datebrith);
        $request->bindParam(':xp', $xp);
        $request->bindParam(':level', $level);
        $request->bindParam(':is_admin', $is_admin);
        $request->bindParam(':is_banned', $is_banned);
        echo "sa marche";
        // assure-toi que la date est au bon format (YYYY-MM-DD)
        try {
            $request->execute();
            if ($request->rowCount() === 1) {
                // Redirection avant tout affichage
                header('Location: homeUser.php');
                exit(); // Assurez-vous de terminer le script après la redirection
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        }
    } else {
        echo 'Les mots de passe ne correspondent pas';
    }

    /* On ferme la connexion à la base de données */


    ?>
    <!-- 
INSERT INTO users (username, email, password_hash, first_name, last_name, date_of_birth, xp, level, is_admin, is_banned) VALUES
('john_doe', 'john@example.com', 'hash_password_1', 'John', 'Doe', '1990-01-01', 150, 2, FALSE, FALSE), 
-->
</body>