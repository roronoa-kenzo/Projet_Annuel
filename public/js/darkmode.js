function toggleDarkMode() {
    // Alterne la classe dark-mode sur le body
    document.body.classList.toggle('dark-mode');

    // Détermine si le mode sombre est activé
    const isDarkMode = document.body.classList.contains('dark-mode');

    // Met à jour la valeur du champ caché et soumet le formulaire
    document.getElementById('darkModeInput').value = isDarkMode ? 'on' : 'off';
    document.getElementById('darkModeForm').submit();
}