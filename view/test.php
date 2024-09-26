<?php
session_start();

// Vérifie si le mode a été envoyé par POST
if (isset($_POST['darkMode'])) {
    // Sauvegarde la préférence dans la session
    $_SESSION['darkMode'] = $_POST['darkMode'];
}

// Détermine le mode actuel (clair par défaut)
$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Mode with PHP</title>
    <style>
        /* Styles de base pour le mode clair */
        body {
            background-color: white;
            color: black;
            transition: background-color 0.5s, color 0.5s;
        }

        /* Styles appliqués pour le mode sombre */
        body.dark-mode {
            background-color: #121212;
            color: white;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?>">

    <h1>Welcome to the Dark Mode Page</h1>
    <p>Click the button below to toggle between Dark and Light mode.</p>

    <!-- Formulaire caché pour soumettre le mode -->
    <form id="darkModeForm" method="POST">
        <input type="hidden" name="darkMode" id="darkModeInput" value="<?php echo $darkMode ? 'on' : 'off'; ?>">
        <button type="button" onclick="toggleDarkMode()">Toggle Dark Mode</button>
    </form>

    <script>
        function toggleDarkMode() {
            // Alterne la classe dark-mode sur le body
            document.body.classList.toggle('dark-mode');

            // Détermine si le mode sombre est activé
            const isDarkMode = document.body.classList.contains('dark-mode');

            // Met à jour la valeur du champ caché et soumet le formulaire
            document.getElementById('darkModeInput').value = isDarkMode ? 'on' : 'off';
            document.getElementById('darkModeForm').submit();
        }
    </script>

</body>
</html>
