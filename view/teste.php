<?php
session_start();

// Si l'utilisateur soumet le formulaire avec la valeur de darkMode
if (isset($_POST['darkMode'])) {
    $_SESSION['darkMode'] = $_POST['darkMode'];
}

// Définir la variable pour savoir si le mode sombre est activé
$darkMode = isset($_SESSION['darkMode']) && $_SESSION['darkMode'] === 'on';
?>

<!DOCTYPE html>
<html lang="fr" class="<?php echo $darkMode ? 'dark-mode' : ''; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode Sombre</title>
    <style>
        /* Exemple simple de style pour le mode sombre */
        body.dark-mode {
            background-color: #121212;
            color: white;
        }
        /* Styles par défaut (mode clair) */
        body {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?>">

    <form id="darkModeForm" method="POST">
        <input type="hidden" name="darkMode" id="darkModeInput" value="<?php echo $darkMode ? 'on' : 'off'; ?>">
        <button type="button" onclick="toggleDarkMode()">Nuit</button>
    </form>
        <?php
        var_dump($darkMode);
        var_dump($_SESSION['darkMode']);
        
        ?>
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
