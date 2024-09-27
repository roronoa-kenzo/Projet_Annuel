
/*Ce fichier sert a mettre tt les fichier uploader dans le dossier upload
 mais aussi de les analyser pour inclure que les png ou les mp4 ainsi que 
 leur taille. En developpement..
*/

document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('fileToUpload');
    const uploadForm = document.getElementById('uploadForm');

    /* Écouter le changement sur l'input file*/
    fileInput.addEventListener('change', function () {
        /* Optionnel : Validation du fichier (ex: type, taille)*/
        const file = fileInput.files[0];
        if (file) {
            const fileType = file.type;
            const fileSize = file.size;
            
            /* analyse du type de fichier*/
            if (!fileType.match('image/png') && !fileType.match('video/mp4')) {
                alert('Seuls les fichiers PNG ou MP4 sont autorisés.');
                return;
            }

            /* analyse de la taille du fichier (5 Mo max)*/
            if (fileSize > 5000000) { // 5 Mo = 5 * 1024 * 1024
                alert('Le fichier est trop volumineux. La taille maximale autorisée est de 5 Mo.');
                return;
            }

            /* soumission du formulaire */
            uploadForm.submit();

            
        }
    });
});
