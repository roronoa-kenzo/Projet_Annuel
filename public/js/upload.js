document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('fileToUpload');
    const uploadForm = document.getElementById('uploadForm');

    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (file) {
            const fileType = file.type;
            const fileSize = file.size;

            if (!fileType.match('image/png') && !fileType.match('video/mp4')) {
                alert('Seuls les fichiers PNG ou MP4 sont autorisés.');
                fileInput.value = ''; // Réinitialise l'input
                return;
            }

            if (fileSize > 5000000) {
                alert('Le fichier est trop volumineux. La taille maximale autorisée est de 5 Mo.');
                fileInput.value = ''; // Réinitialise l'input
                return;
            }
        }
    });
});
