// URL de votre API
const API_URL = "https://abyss.boats/extention/get_forum.php";

// Fonction pour charger les forums
async function loadForums() {
    const container = document.getElementById('forums-container');
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error(`Erreur HTTP : ${response.status}`);

        const forums = await response.json();

        // Afficher les forums
        container.innerHTML = '';
        forums.forEach(forum => {
            const forumElement = document.createElement('div');
            forumElement.className = 'forum';

            // Vérification et valeurs par défaut
            const forumName = forum.name ? forum.name : 'Nom non spécifié';
            const forumDescription = forum.description ? forum.description : 'Description non spécifiée';

            forumElement.innerHTML = `
            <a href="https://abyss.boats/view/Abyss-Forum.php?forum_id=${forum.id}">
                <h3>${forumName}</h3>
                <p>${forumDescription}</p>
            </a>
            `;
            container.appendChild(forumElement);
        });
    } catch (error) {
        container.innerHTML = `<p>Erreur : ${error.message}</p>`;
    }
}

// Charger les forums au chargement de la popup
loadForums();
