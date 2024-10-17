// Fonction pour effectuer la recherche
function searchUsers() {
    const searchTerm = document.getElementById('searchInput').value;

    if (searchTerm.length > 0) {
        fetch(`./searchUsers.php?query=${encodeURIComponent(searchTerm)}`)
            .then(response => {
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
                    usersList.innerHTML = '<div class="iceberg-select"><p>Aucun utilisateur trouvé.</p></div>';
                }
            })
            .catch(error => console.error('Erreur:', error));
    } else {
        // Quand le champ de recherche est vide, on réaffiche tous les utilisateurs
        resetUserList();
    }
}

// Fonction pour réinitialiser la liste des utilisateurs
function resetUserList() {
    // Cette fonction pourrait être améliorée pour faire une requête AJAX pour obtenir tous les utilisateurs à nouveau
    const usersList = document.getElementById('usersList');
    usersList.innerHTML = ''; // Vider la liste actuelle

    // Requête pour récupérer tous les utilisateurs
    fetch('./searchUsers.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau lors de la récupération de tous les utilisateurs');
            }
            return response.json();
        })
        .then(data => {
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
        })
        .catch(error => console.error('Erreur:', error));
}

// Ajout d'un écouteur d'événement sur le bouton de recherche
document.getElementById('searchButton').addEventListener('click', searchUsers);

// Optionnel : Déclencher la recherche aussi à la saisie dans le champ de texte
document.getElementById('searchInput').addEventListener('input', searchUsers);
