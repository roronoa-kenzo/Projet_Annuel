<?php
// Inclusion du fichier de connexion à la base de données
require_once './../serveur/database.php';
session_start();

// Initialisation des variables
$isSuccess = false;
$errorMessage = '';

// Vérification et récupération du token de confirmation via GET
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];

    // Préparation de la requête pour vérifier si le token est valide
    $stmt = $pdo->prepare("SELECT * FROM subscribers WHERE token = :token");
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Le token est valide, on met à jour le statut de l'abonné
        $stmt = $pdo->prepare("UPDATE subscribers SET confirmed = 1, token = NULL WHERE token = :token");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        // Récupérer l'ID de l'abonné
        $subscriber_id = $result['id'];

        // Préparer la requête SQL pour récupérer l'utilisateur
        $stmt = $pdo->prepare("
            SELECT 
                users.* 
            FROM 
                users
            JOIN 
                subscribers ON users.id = subscribers.id_user
            WHERE 
                subscribers.id = :subscriber_id
        ");
        $stmt->bindParam(':subscriber_id', $subscriber_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // L'utilisateur a été trouvé, on initialise la session
            $_SESSION["username"] = $user['username'];
            $_SESSION["user_profile"] = $user['user_profile'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["user_id"] = $user['id'];

            // Indiquer que l'opération a réussi
            $isSuccess = true;
        } else {
            // L'utilisateur n'a pas été trouvé
            $errorMessage = "Utilisateur introuvable.";
        }
    } else {
        // Le token est invalide ou n'existe pas dans la base de données
        $errorMessage = "Le lien de confirmation est invalide ou a déjà été utilisé.";
    }
} else {
    // Si le token n'est pas fourni
    session_unset();
    $_SESSION = [];
    session_destroy();
    $errorMessage = "Aucun token de confirmation n'a été fourni.";
}

// Affichage de la page correspondante
if ($isSuccess) {
    // Bloc de succès
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <!-- Vos balises head -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirmation réussie</title>
        <link rel="stylesheet" href="./../public/css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
            rel="stylesheet">
        <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
        <?php require_once("./../composants/ResquestDarkMode.php"); ?>
    </head>
    <body class="<?php echo $darkMode ? 'dark-mode' : ''; ?> body_secondary">
        <?php include './../composants/no_user_navbar.php'; ?>
        <?php require_once('./../serveur/sessionStart.php'); ?>

        <div class="DivAllForm" style="padding-top: 10rem;">
            <div class="h3Div">
                <h3 class="h3Register">Confirmation</h3>
            </div>

            <div class="confirmationMessage Form">
                <p>Votre adresse email a été confirmée avec succès</p>

                <!-- Bouton pour retourner à l'accueil ou autre page -->
                <div class="button-Div">
                    <a href="./../view/index.php" class="button-Submit">Retour à l'accueil</a>
                    <a href="./../view/Popular.php" class="button-Submit">Commencer à poster</a>
                </div>
            </div>
            <style>
                .button-Div {
                    display: flex;
                    justify-content: space-between;
                }
                .button-Submit {
                    margin-top: 30px;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.body.classList.remove('no-transition');
                });
            </script>
        </body>
    </html>
    <?php
} else {
    // Bloc d'erreur
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <!-- Vos balises head -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erreur de confirmation</title>
        <link rel="stylesheet" href="./../public/css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
            rel="stylesheet">
        <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
        <?php require_once("./../composants/ResquestDarkMode.php"); ?>
    </head>
    <body class="<?php echo $darkMode ? 'dark-mode' : ''; ?> body_secondary">
        <?php include './../composants/no_user_navbar.php'; ?>
        <?php require_once('./../serveur/sessionStart.php'); ?>

        <div class="DivAllForm" style="padding-top: 10rem;">
            <div class="h3Div">
                <h3 class="h3Register">Erreur</h3>
            </div>

            <div class="confirmationMessage Form">
                <p><?php echo htmlspecialchars($errorMessage); ?></p>

                <!-- Bouton pour retourner à l'accueil ou autre page -->
                <div class="button-Div">
                    <a href="./../view/Popular.php" class="button-Submit">Retour à l'accueil</a>
                </div>
            </div>
            <style>
                .button-Div {
                    display: flex;
                    justify-content: center;
                }
                .button-Submit {
                    margin-top: 30px;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.body.classList.remove('no-transition');
                });
            </script>
        </body>
    </html>
    <?php
}

// Fermeture de la connexion
$pdo = null;
?>
