// Script pour gérer l'ouverture et la fermeture du modal
const modal = document.getElementById("createForumModal");
const openModalButton = document.getElementById("openModalButton");
const closeButton = document.querySelector(".close-button");

openModalButton.onclick = function() {
    modal.style.display = "block";
}

closeButton.onclick = function() {
    modal.style.display = "none";
}

// Ferme le modal lorsque l'utilisateur clique à l'extérieur
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Soumission du formulaire
document.getElementById("createForumForm").onsubmit = function(e) {
    e.preventDefault();
    // Ajoutez ici votre code AJAX pour soumettre le formulaire et créer le forum
    const forumName = document.getElementById("forumName").value;
    const forumColor = document.querySelector('input[name="forumColor"]:checked').value;

    console.log("Forum Name: ", forumName);
    console.log("Forum Color: ", forumColor);

    // Fermez le modal après la soumission
    modal.style.display = "none";

    // Optionnel: Ajoutez une notification ou un rafraîchissement pour afficher le forum nouvellement créé
};