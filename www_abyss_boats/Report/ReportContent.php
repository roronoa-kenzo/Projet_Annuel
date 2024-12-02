<?php
// Démarrage de la session
session_start();

//Vérification si l'utilisateur est connecté
if (!isset($_COOKIE['email'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    //header("Location: ./../view/connexion.php");
    //exit();
}

$userID = $_SESSION["user_id"]; // Récupération de l'ID utilisateur

$forumUrl = $_POST['forumUrl'];
$forumUrl = htmlspecialchars($forumUrl);
var_dump($_SESSION);
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
            <h3 class="h3Register">Report</h3>
        </div>

        <!-- Formulaire de signalement -->
        <form action="./ReportTraitement.php" class="Form" method="post">
            <!-- Champ ID utilisateur (caché) -->
            <input type="hidden" name="userID" value="<?php echo $userID; ?>">

            <!-- Champ lien du contenu à signaler -->
            <div>
                <label for="contentLink" class="labelRegister">Lien du Contenu</label>
                <input type="text" class="demiInput" name="contentLink" value="<?php echo $forumUrl; ?>"
                    placeholder="Lien du contenu à signaler" id="contentLink" required>
            </div>

            <!-- Champ raison du signalement -->
            <div>
                <label for="reason" class="labelRegister">Raison du Signalement</label>

                <select name="reason" id="reason" class="demiInput" required>
                    <option value="" disabled selected>Choisissez une raison</option>
                    <option value="Contenu inapproprié">Contenu inapproprié</option>
                    <option value="Spam ou publicité non désirée">Spam ou publicité non désirée</option>
                    <option value="Discours haineux">Discours haineux</option>
                    <option value="Violence ou menaces">Violence ou menaces</option>
                    <!-- Ajouter d'autres options de raisons si nécessaire -->
                </select>
            </div>

            <!-- Champ détails supplémentaires -->
            <div>
                <label for="additionalDetails" class="labelRegister">Détails Supplémentaires</label>
                <textarea class="demiInput" name="additionalDetails"
                    placeholder="Ajoutez des détails supplémentaires (optionnel)" id="additionalDetails"
                    rows="4"></textarea>
            </div>

            <!-- Bouton de soumission -->
            <button class="buttonSubmit" type="submit">Envoyer le Signalement</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.remove('no-transition');
        });
    </script>
</body>

</html>