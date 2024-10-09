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
    <link rel="icon" type="image/png" href="../public/img/abyssicon.png">
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
    $imgprofile = !empty($_POST['user_profile']) ? $_POST['user_profile'] : '../public/img/abyssicon.png';
    $xp = 10;
    $level = 1;
    $is_admin = 0;
    $is_banned = 0;

    if (empty($lastname) || empty($firstname) || empty($gender) || empty($datebrith) || empty($phone) || empty($email) || empty($formusername) || empty($formpassword) || empty($passwordbis)) {
        $_SESSION['Error'] = 'All fields are required.';
        //header('Location: register.php');
        exit();
    }

    // Vérification de l'âge
    $calcAge = date('Y-m-d', strtotime('-18 years'));
    if ($datebrith > $calcAge) {
        $_SESSION['Errordatebrith'] = 'Too young.';
        //header('Location: register.php');
        exit();
    }

    // Vérification si l'email existe déjà
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $_SESSION['Erroremail'] = 'This email is already registered.';
        //header('Location: register.php');
        exit();
    }

    // Vérification si le username existe déjà
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $formusername);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $_SESSION['Errorformusername'] = 'This username is already registered.';
        //header('Location: register.php');
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
                $userId = $pdo->lastInsertId();try {
                    if ($userId) {
                        // Inscrire l'utilisateur au forum "Abyss"
                        $forumAbyssId = 1;
                
                        // Vérifier si le forum avec forum_id = 1 existe
                        $checkForumQuery = $pdo->prepare('SELECT id FROM forums WHERE id = :forum_id');
                        $checkForumQuery->bindParam(':forum_id', $forumAbyssId);
                        $checkForumQuery->execute();
                
                        if ($checkForumQuery->rowCount() === 0) {
                            // Si le forum n'existe pas, le créer
                            $createForumQuery = $pdo->prepare('INSERT INTO forums (name) VALUES (:forum_name)');
                            $forumName = 'Abyss'; // Nom du forum à créer
                            $createForumQuery->bindParam(':forum_name', $forumName);
                
                            if ($createForumQuery->execute()) {
                                $forumAbyssId = $pdo->lastInsertId(); // Récupérer l'ID du forum nouvellement créé
                                echo "Forum créé avec succès, ID: $forumAbyssId";
                            } else {
                                echo "Erreur lors de la création du forum.";
                                exit();
                            }
                        }
                
                        // Inscription de l'utilisateur au forum
                        var_dump($userId); // Debug : est-ce que userId est correct ?
                        $subscribeQuery = $pdo->prepare('INSERT INTO forum_subscribers (user_id, forum_id) VALUES (:user_id, :forum_id)');
                        $subscribeQuery->bindParam(':user_id', $userId);
                        $subscribeQuery->bindParam(':forum_id', $forumAbyssId);
                
                        // Exécution et vérification de la requête
                        if ($subscribeQuery->execute()) {
                            echo "Utilisateur inscrit au forum avec succès.";
                        } else {
                            echo "Erreur lors de l'inscription au forum : ";
                            print_r($subscribeQuery->errorInfo()); // Affiche les erreurs SQL
                        }
                
                        // Stocker les informations de l'utilisateur dans la session
                        $_SESSION["username"] = $formusername;
                        $_SESSION["user_profile"] = $imgprofile;
                        $_SESSION["email"] = $email;
                        $_SESSION["user_id"] = $userId;
                        
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
                
                        // Redirection vers l'index après le succès
                        header('Location: index.php');
                        exit();
                    } else {
                        echo "Erreur: userId non défini.";
                    }
                } catch (PDOException $e) {
                    echo "Erreur lors de l'inscription au forum : " . $e->getMessage();
                }

            } else {
                $_SESSION['ErrorCaptcha'] = 'Captcha wrong';
                //header("Location:register.php");
                exit();
            }
        }
    } else {
        $_SESSION['Errorformpassword'] = 'Passwords do not match.';
        //header('Location: register.php');
        exit();
    }
    
    ?>
</body>