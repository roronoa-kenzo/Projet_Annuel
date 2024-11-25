document.addEventListener('DOMContentLoaded', function () {
    const likeForms = document.querySelectorAll('.like-form');

    likeForms.forEach(form => {
        const postId = new FormData(form).get('post_id');
        const likeButton = form.querySelector('.like-button');

        // Vérification initiale de l'état de like
        checkLikeStatus(postId, likeButton);

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Envoi de la requête pour liker ou unliker le post
            fetch('like.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le compteur de likes
                    updateLikeCount(likeButton, data.likeCount);

                    // Modifier l'apparence du bouton en fonction du statut de like
                    likeButton.classList.toggle('liked', data.isLiked);
                } else {
                    console.error('Erreur:', data.message);
                }
            })
            .catch(error => console.error('Erreur de requête:', error));
        });

        // Met à jour le compteur de likes toutes les 3 secondes
        setInterval(() => checkLikeStatus(postId, likeButton), 3000);
    });

    function updateLikeCount(likeButton, likeCount) {
        const likeCountSpan = likeButton.querySelector('.like-count');
        likeCountSpan.textContent = likeCount;
    }

    function checkLikeStatus(postId, likeButton) {
        fetch('like_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ post_id: postId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateLikeCount(likeButton, data.likeCount);
                likeButton.classList.toggle('liked', data.isLiked);
            }
        })
        .catch(error => console.error('Erreur de vérification de statut:', error));
    }
});

