<?php
session_start();
require_once './../serveur/database.php'; // Connexion à la base de données

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ./../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $imagePath = null;

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2000000; // Taille maximale : 2 Mo

        // Validation du type de fichier et de la taille
        if (!in_array($fileExtension, $allowedExtensions)) {
            $_SESSION['ErrorProfilePicture'] = 'Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.';
            header('Location: ./../view/profile.php');
            exit();
        }

        if ($fileSize > $maxFileSize) {
            $_SESSION['ErrorProfilePicture'] = 'Le fichier est trop volumineux. La taille maximale autorisée est de 2 Mo.';
            header('Location: ./../view/profile.php');
            exit();
        }

        // Chemin du dossier de téléchargement
        $uploadFolder = './../public/upload/profile_pictures/';
        $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
        $destination = $uploadFolder . $newFileName;

        // Déplacement du fichier vers le dossier
        if (move_uploaded_file($fileTmpPath, $destination)) {
            $imagePath = $destination; // Chemin de l'image sauvegardée
        } else {
            $_SESSION['ErrorProfilePicture'] = "Erreur lors de l'enregistrement du fichier.";
            header('Location: ./../view/profile.php');
            exit();
        }
    } else {
        $_SESSION['ErrorProfilePicture'] = "Aucun fichier n'a été téléchargé.";
        header('Location: ./../view/profile.php');
        exit();
    }

    // Mise à jour du chemin de l'image dans la base de données
    if ($imagePath) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET user_profile = ? WHERE id = ?");
            $stmt->execute([$imagePath, $user_id]);

            // Mise à jour de la session avec le nouveau chemin d'image
            $_SESSION['user_profile'] = $imagePath;
            $_SESSION['SuccessProfilePicture'] = 'Votre photo de profil a été mise à jour avec succès.';
        } catch (PDOException $e) {
            $_SESSION['ErrorProfilePicture'] = 'Erreur lors de la mise à jour de votre profil : ' . $e->getMessage();
        }
    }

    header('Location: ./../view/profile.php');
    exit();
} else {
    header('Location: ./../view/profile.php');
    exit();
}
?>
