// Fonction pour ouvrir le modal
function openModal() {
    document.getElementById('editForumModal').style.display = 'flex';
}

// Attache l'événement click au bouton pour ouvrir le modal
document.getElementById('openModalEditButton').addEventListener('click', openModal);

// Ferme le modal quand on clique sur la croix
function closeModal() {
    document.getElementById('editForumModal').style.display = 'none';
}

// Ferme le modal en cliquant à l'extérieur du contenu
window.onclick = function(event) {
    const modal = document.getElementById('editForumModal');
    if (event.target === modal) {
        closeModal();
    }
};