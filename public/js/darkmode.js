function toggleDarkMode() {
    // Récupère l'élément du lien de la feuille de style
    const link = document.getElementById('theme-stylesheet');
    
    // Vérifie si le lien pointe vers style.css ou darkmode.css
    const isDarkMode = link.getAttribute('href').includes('darkmode.css');
    
    // Alterne entre style.css et darkmode.css
    link.setAttribute('href', isDarkMode ? './../public/css/style.css' : './../public/css/darkmode.css');

    // Optionnel : Si vous avez un champ caché pour enregistrer l'état
    document.getElementById('darkModeInput').value = isDarkMode ? 'off' : 'on';

    // Ne soumettez pas le formulaire si ce n'est pas nécessaire
    // document.getElementById('darkModeForm').submit();
}

