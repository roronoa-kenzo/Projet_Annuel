<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation du Signalement</title>
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
            <h3 class="h3Register">Ticket </h3>
        </div>

        <div class="confirmationMessage Form">
            <?php
            // Vérifier si un message de confirmation est présent dans la session
            if (isset($_SESSION['SuccessMessage'])) {
                echo "<p>" . $_SESSION['SuccessMessage'] . "</p>";
                unset($_SESSION['SuccessMessage']); // Supprimer le message après affichage
            } else {
                echo "<p>Votre ticket a bien été pris en compte. Merci pour votre contribution.</p>";
            }
            ?>

            <!-- Bouton pour retourner à l'accueil ou autre page -->
            <div class="button-Div">
                <a href="./../view/index.php" class="button-Submit">Retour à l'accueil</a>
                <a href="./Create_Tiket.php" class="button-Submit">Faire un autre signalement</a>
            </div>
        </div>
<style>
    .button-Div{
        display: flex;
        justify-content: space-between;
    }
    .button-Submit{
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