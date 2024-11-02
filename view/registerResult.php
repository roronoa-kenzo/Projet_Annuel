<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
</head>

<body>
    <?php require_once("./../serveur/database.php"); ?>
    <?php require_once('./../serveur/sessionStart.php'); ?>

    <?php require_once('./../serveur/logconnection.php');?>

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

    
    $imgprofile = !empty($_POST['user_profile']) ? $_POST['user_profile'] : './../public/img/abyssicon.png';
    
    $xp = 10;
    $level = 1;
    $is_admin = 0;
    $is_banned = 0;
    
    if (empty($lastname) || empty($firstname) || empty($gender) || empty($datebrith) || empty($phone) || empty($email) || empty($formusername) || empty($formpassword) || empty($passwordbis)) {
        $_POST['Error'] = 'All fields are required.';
        header('Location: ./register.php');
        exit();
    }
    
    // Vérification de l'âge
    $calcAge = date('Y-m-d', strtotime('-18 years'));
    if ($datebrith > $calcAge) {
        $_POST['Errordatebrith'] = 'Too young.';
        header('Location: ./register.php');
        exit();
    }
    
    // Vérification si l'email existe déjà
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $_POST['Erroremail'] = 'This email is already registered.';
        header('Location: ./register.php');
        exit();
    }

    // Vérification si le username existe déjà
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $formusername);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $_POST['Errorformusername'] = 'This username is already registered.';
        header('Location: ./register.php');
        exit();
    }
    
    if ($formpassword == $passwordbis) {
        if (isset($_POST['valid'])) {
            if (isset($_POST['captcha'], $_SESSION['code']) && $_POST['captcha'] == $_SESSION['code']) {
                $formpassword = password_hash($formpassword, PASSWORD_DEFAULT);
                
                $request = $pdo->prepare('INSERT INTO users (username, email, password_hash, first_name, last_name, user_profile, date_of_birth, xp, level, is_admin, is_banned) VALUES (:username, :email, :password_hash, :first_name, :last_name, :user_profile, :date_of_birth, :xp, :level, :is_admin, :is_banned)');
                $request->bindParam(':username', $formusername);
                $request->bindParam(':email', $email);
                $request->bindParam(':password_hash', $formpassword);
                $request->bindParam(':user_profile', $imgprofile);
                $request->bindParam(':first_name', $firstname);
                $request->bindParam(':last_name', $lastname);
                $request->bindParam(':date_of_birth', $datebrith);
                $request->bindParam(':xp', $xp);
                $request->bindParam(':level', $level);
                $request->bindParam(':is_admin', $is_admin);
                $request->bindParam(':is_banned', $is_banned);

                $request->execute();
                
                // Récupérer l'ID de l'utilisateur nouvellement créé
                $userId = $pdo->lastInsertId();
                
                try {
                    if ($userId) {
                        // Inscrire l'utilisateur au forum "Abyss"
                        $forumAbyssId = 1;

                        // Vérifier si le forum avec forum_id = 1 existe
                        $checkForumQuery = $pdo->prepare('SELECT id FROM forums WHERE id = :forum_id');
                        $checkForumQuery->bindParam(':forum_id', $forumAbyssId);
                        $checkForumQuery->execute();
                        if ($checkForumQuery->rowCount() === 0) {
                            var_dump($checkForumQuery);
                            // Si le forum n'existe pas, le créer
                            $createForumQuery = $pdo->prepare('INSERT INTO forums (id, name) VALUES (:forum_id, :forum_name)');
                            
                            $forumName = 'Abyss'; // Nom du forum à créer
                            $createForumQuery->bindParam(':forum_id', $forumAbyssId);
                            $createForumQuery->bindParam(':forum_name', $forumName);
                            
                            if ($createForumQuery->execute()) {
                                echo "laaaaaaaaaa";
                                echo "Le forum a été créé avec succès avec l'ID : " . $forumAbyssId;
                            } else {
                                // Gestion d'erreur
                                header("Location:./index.php");
                                exit();
                            }
                        }
                        
                        // Inscription de l'utilisateur au forum
                        $subscribeQuery = $pdo->prepare('INSERT INTO forum_subscribers (user_id, forum_id) VALUES (:user_id, :forum_id)');
                        $subscribeQuery->bindParam(':user_id', $userId);
                        $subscribeQuery->bindParam(':forum_id', $forumAbyssId);
                
                        // Exécution et vérification de la requête
                        if ($subscribeQuery->execute()) {

                        } else {
                            // page d'erreur
                        }
                
                        // Stocker les informations de l'utilisateur dans la session
                        $_SESSION["username"] = $formusername;
                        $_SESSION["user_profile"] = $imgprofile;
                        $_SESSION["email"] = $email;
                        $_SESSION["user_id"] = $userId;
                        
                        $durerDuCookie = time() + (7 * 24 * 3600); 

                        // Créer les cookies
                        setcookie('formusername', $formusername, $durerDuCookie, "/");
                        setcookie('imgprofile', $imgprofile, $durerDuCookie, "/");
                        setcookie('email', $email, $durerDuCookie, "/");
                        setcookie('userId', $userId, $durerDuCookie, "/");
                    
                        // Récupérer les forums auxquels l'utilisateur est abonné
                        $query = $pdo->prepare('
                            SELECT forums.id, forums.name 
                            FROM forum_subscribers
                            JOIN forums ON forum_subscribers.forum_id = forums.id
                            WHERE forum_subscribers.user_id = :user_id
                        ');
                        $query->bindParam(':user_id', $userId);
                        $query->execute();
                
                        $subscribedForums = $query->fetchAll(PDO::FETCH_ASSOC);
                        $_SESSION['subscribed_forums'] = $subscribedForums;
                        loginUser($_SESSION["user_id"]);
                        // Redirection vers l'index après le succès
                        header('Location: ./../Newsletter/subscribe.php');
                        exit();
                    } else {
                        // page d'erreur
                    }
                } catch (PDOException $e) {
                    // page d'erreur
                }

            } else {
                $_POST['ErrorCaptcha'] = 'Captcha wrong';
                header("Location:./register.php");
                exit();
            }
        }
    } else {
        $_POST['Errorformpassword'] = 'Passwords do not match.';
        header('Location: ./register.php');
        exit();
    }
    
    ?>
</body>