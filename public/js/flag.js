// ../public/js/flag.js

/**
 * Affiche un message sous forme de notification en haut à droite de l'écran.
 * @param {string} type - Le type de notification ('success' ou 'error').
 * @param {string} message - Le message à afficher.
 */
function showNotification(type, message) {
    const notificationContainer = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    // Ajoute la notification au conteneur
    notificationContainer.appendChild(notification);

    // Masque la notification après 5 secondes
    setTimeout(function () {
        notificationContainer.removeChild(notification);
    }, 5000);
}

/**
 * Masque un élément après un certain temps.
 * @param {string} elementId - L'identifiant de l'élément à masquer.
 * @param {number} duration - La durée en millisecondes avant de masquer l'élément.
 */
function hideAfterDelay(elementId, duration) {
    const element = document.getElementById(elementId);
    if (element) {
        setTimeout(function () {
            element.style.display = 'none';
        }, duration);
    }
}

// Masquer automatiquement les messages de succès ou d'erreur après 5 secondes
document.addEventListener('DOMContentLoaded', function () {
    hideAfterDelay('successMessage', 5000);
    hideAfterDelay('errorMessage', 5000);
});
