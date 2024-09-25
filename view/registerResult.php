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
    $email = $_POST['email'];//doit etre unique
    $formusername = $_POST['username'];//doit etre unique
    $formpassword = $_POST['password'];
    $passwordbis = $_POST['passwordbis'];
    $xp = 10;
    $level = 1;
    $is_admin = 0;
    $is_banned = 0;

    if(empty($lastname))
    {
        $_SESSION['Errorlastname'] = 'Incorrect lastname';
        header('Location: register.php');
        exit(); 
    }
    else if(empty($firstname))
    {
        $_SESSION['Errorfirstname'] = 'Incorrect firstname';
        header('Location: register.php');
        exit(); 
    }
    else if(empty($gender))
    {
        $_SESSION['Errorgender'] = 'Incorrect gender';
        header('Location: register.php');
        exit(); 
    }
    else if(empty($datebrith))
    {
        $_SESSION['Errordatebrith'] = 'Incorrect birthday';
        header('Location: register.php');
        exit(); 
    }else if(!empty($datebrith))//verifier l'age de la personne
    {
        $calcAge = date('Y-m-d', strtotime('-18 years'));
        if($datebrith > $calcAge){
            $_SESSION['Errordatebrith'] = 'Too young';
            header('Location: register.php');
            exit(); 
        }
    }
    else if(empty($phone))
    {
        $_SESSION['Errorphone'] = 'Incorrect phone number';
        header('Location: register.php');
        exit(); 
    }
    else if(empty($email))// verification dans bdd aussi
    {
        $_SESSION['Erroremail'] = 'Incorrect email';
        header('Location: register.php');
        exit(); 
    }
    else if(empty($formusername))// verification dans bdd aussi
    {
        $_SESSION['Errorformusername'] = 'Incorrect username';
        header('Location: register.php');
        exit(); 
    }
    else if(empty($formpassword))
    {
        $_SESSION['Errorformpassword'] = 'Incorrect password';
        header('Location: register.php');
        exit(); 
    }
    else if(empty($passwordbis))
    {
        $_SESSION['Errorpasswordbis'] = 'Incorrect password';
        header('Location: register.php');
        exit(); 
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