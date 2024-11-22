// Sélection des éléments
const modal = document.getElementById("createForumModal");
const openModalButton = document.getElementById("openModalButton");
const closeButton = document.querySelector(".close-button");

// Ouvrir le modal
openModalButton.onclick = function() {
    modal.style.display = "block";
}

// Fermer le modal en cliquant sur le bouton de fermeture
closeButton.onclick = function() {
    modal.style.display = "none";
}

// Fermer le modal en cliquant en dehors de la zone de contenu
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
