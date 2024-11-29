<?php
// Démarrage de la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signalement de Contenu</title>
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

    <div class="DivAllForm">
        <div class="h3Div">
            <h3 class="h3Register">Crée tickets</h3>
        </div>

        <!-- Formulaire de signalement -->
        <form action="./../composants/TraitementTickets.php" class="Form" method="post">
            <!-- Champ lien du contenu à signaler -->
            <div style="margin-top: 1rem;">
                <label for="emailTiket" class="labelRegister">Votre email :</label>
                <input type="email" class="demiInput" name="emailTiket" placeholder="Email de contact"
                    id="emailTiket" required>
            </div>

            <!-- Champ raison du signalement -->
            <div style="margin-top: 2rem;">
                <label for="reason" class="labelRegister">Priorite du tikets</label>

                <select name="priority" id="priority" class="demiInput" required>
                    <option value="Low" selected >Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Critical">Critical</option>
                </select>
            </div>
            <div style="margin-top: 2rem;">
                <label for="tilte" class="labelRegister">Objet du ticket :</label>
                <input type="text" class="demiInput" name="tilte" placeholder="Titre" id="tilte" required>
            </div>
            <!-- Champ détails supplémentaires -->
            <div style="margin-top: 2rem;">
                <label for="tiket" class="labelRegister">Détails du tikets</label>
                <textarea class="demiInput" name="tiket" placeholder="Description du ticket" id="tiket" rows="4" required></textarea>
            </div>

            <!-- Bouton de soumission -->
            <button class="buttonSubmit" type="submit">Envoyer le ticket</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.remove('no-transition');
        });
    </script>
</body>

</html>