<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Signaler un contenu</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="./../public/img/abyssicon.png">
    <?php require_once("./../composants/ResquestDarkMode.php"); ?>
</head>

<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?> body_secondary">
    <?php include './../composants/no_user_navbar.php'; ?>
    <?php require_once('./../serveur/sessionStart.php'); ?>

    <div class="DivAllForm">
        <div class="h3Div">
            <h3 class="h3Register">Report</h3>
        </div>

        <form action="reportTraitement.php" class="Form" method="post">
            <div class="doubleDiv">
                <!-- Email du rapporteur -->
                <div>
                    <label for="email" class="labelRegister">Votre email</label>
                    <input type="email" class="demiInput" name="email" placeholder="Votre email" id="email" required>
                    <?php
                    // Affiche un message d'erreur si l'email n'est pas valide ou manquant
                    if (isset($_SESSION['ErrorEmail'])) {
                        echo '<p style="color: red;">' . $_SESSION['ErrorEmail'] . '</p>';
                        unset($_SESSION['ErrorEmail']);
                    }
                    ?>
                </div>

                <!-- URL ou ID du contenu signalé -->
                <div>
                    <label for="content-id" class="labelRegister">URL du contenu</label>
                    <input type="text" class="demiInput" name="content_id" placeholder="URL du contenu" id="content-id" required>
                    <?php
                    // Affiche un message d'erreur si l'ID ou l'URL est manquant
                    if (isset($_SESSION['ErrorContentID'])) {
                        echo '<p style="color: red;">' . $_SESSION['ErrorContentID'] . '</p>';
                        unset($_SESSION['ErrorContentID']);
                    }
                    ?>
                </div>
            </div>

            <!-- Raison du signalement -->
            <div class="doubleDiv">
                <div>
                    <label for="reason" class="labelRegister">Raison du signalement</label>
                    <select name="reason" id="reason" class="demiInput" required>
                        <option value="hate-speech">Discours de haine</option>
                        <option value="harassment">Harcèlement</option>
                        <option value="spam">Spam</option>
                        <option value="nudity">Nudité/Contenu adulte</option>
                        <option value="violence">Violence</option>
                        <option value="misinformation">Désinformation</option>
                        <option value="other">Autre</option>
                    </select>
                    <?php
                    // Affiche un message d'erreur si la raison est manquante
                    if (isset($_SESSION['ErrorReason'])) {
                        echo '<p style="color: red;">' . $_SESSION['ErrorReason'] . '</p>';
                        unset($_SESSION['ErrorReason']);
                    }
                    ?>
                </div>
            </div>

            <!-- Détails supplémentaires -->
            <div>
                <label for="details" class="labelRegister">Détails supplémentaires</label>
                <textarea class="post-textarea" name="details" id="details" placeholder="Fournissez plus de détails sur les raisons de ce signalement" required></textarea>
                <?php
                // Affiche un message d'erreur si les détails sont manquants
                if (isset($_SESSION['ErrorDetails'])) {
                    echo '<p style="color: red;">' . $_SESSION['ErrorDetails'] . '</p>';
                    unset($_SESSION['ErrorDetails']);
                }
                ?>
            </div>

            <!-- Bouton de soumission -->
            <button class="buttonSubmit" name="valid" type="submit">Soumettre le signalement</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.remove('no-transition');
        });
    </script>
</body>

</html>
