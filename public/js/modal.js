document.querySelectorAll('.theme-option').forEach(option => {
    option.addEventListener('click', function() {
        // Supprimer la classe sélectionnée de tous les autres thèmes
        document.querySelectorAll('.theme-option').forEach(opt => opt.classList.remove('selected'));
        
        // Ajouter la classe sélectionnée à l'option cliquée
        this.classList.add('selected');
        
        // Mettre à jour la couleur de la bordure en fonction de la couleur du thème
        const themeColor = this.dataset.theme;
        document.documentElement.style.setProperty('--theme-color', getThemeColor(themeColor));
        
        // Mettre à jour la valeur du champ caché pour le thème sélectionné
        document.getElementById('selectedTheme').value = themeColor;
    });
});

// Fonction pour obtenir la couleur en fonction du thème
function getThemeColor(theme) {
    switch (theme) {
        case 'grey': return '#808080';
        case 'blue': return '#0000FF';
        case 'green': return '#008000';
        case 'red': return '#FF0000';
        case 'orange': return '#FFA500';
        case 'galaxy_red': return '#8B0000';
        case 'galaxy_blue': return '#1E90FF';
        default: return '#000';
    }
}

// Fonction pour ouvrir le modal
function openModal() {
    document.getElementById('createForumModal').style.display = 'flex';
}

// Attache l'événement click au bouton pour ouvrir le modal
document.getElementById('openModalButton').addEventListener('click', openModal);

// Ferme le modal quand on clique sur la croix
function closeModal() {
    document.getElementById('createForumModal').style.display = 'none';
}

// Ferme le modal en cliquant à l'extérieur du contenu
window.onclick = function(event) {
    const modal = document.getElementById('createForumModal');
    if (event.target === modal) {
        closeModal();
    }
};
