// Fonction pour effectuer la recherche
function searchUsers() {
    const searchTerm = document.getElementById('searchInput').value;

    if (searchTerm.length > 0) {
        fetch(`./searchUsers.php?query=${encodeURIComponent(searchTerm)}`)
            .then(response => {
                // Vérifiez que la réponse est correcte avant de la convertir en JSON
                if (!response.ok) {
                    throw new Error('Erreur réseau lors de la recherche');
                }
                return response.json();
            })
            .then(data => {
                const usersList = document.getElementById('usersList');
                usersList.innerHTML = ''; // Vider la liste actuelle

                if (data.length > 0) {
                    data.forEach(user => {
                        const userDiv = document.createElement('div');
                        userDiv.classList.add('post-container-admin');
                        userDiv.innerHTML = `
                            <a class="userLien" href="User.php?user=${user.id}">
                                <div class="iceberg-select">
                                    <span class="username status ${user.is_connected ? '' : 'not-connected'}">
                                        ${user.is_connected ? 'Connecté :' : 'Non connecté :'}
                                    </span>
                                    <span class="username">${user.username}</span><br>
                                    <span class="username">Prénom : ${user.first_name}</span><br>
                                    <span class="username">Nom : ${user.last_name}</span><br>
                                    <span class="username">Email : ${user.email}</span>
                                </div>
                            </a>
                        `;
                        usersList.appendChild(userDiv);
                    });
                } else {
                    usersList.innerHTML = '<p>Aucun utilisateur trouvé.</p>';
                }
            })
            .catch(error => console.error('Erreur:', error));
    } else {
        document.getElementById('usersList').innerHTML = ''; // Vider la liste si le champ est vide
    }
}

// Ajout d'un écouteur d'événement sur le bouton de recherche
document.getElementById('searchButton').addEventListener('click', searchUsers);

// Optionnel : Déclencher la recherche aussi à la saisie dans le champ de texte
document.getElementById('searchInput').addEventListener('input', searchUsers);
