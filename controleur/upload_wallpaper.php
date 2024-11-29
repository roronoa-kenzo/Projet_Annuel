<?php
include './../serveur/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['wallpaper'], $_POST['forum_id'])) {
    $forumId = intval($_POST['forum_id']);

    // Vérification si l'ID du forum existe dans la base de données
    $query = $pdo->prepare("SELECT COUNT(*) FROM forums WHERE id = :forum_id");
    $query->bindParam(':forum_id', $forumId, PDO::PARAM_INT);
    $query->execute();
    $forumExists = $query->fetchColumn();

    if ($forumExists) {
        $uploadedFile = $_FILES['wallpaper'];

        // Vérifiez les erreurs de téléchargement
        if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
            // Définir le répertoire d'upload relatif à la racine du serveur
            $uploadDir = './../public/upload/wallpapers/'; // Nouveau répertoire d'upload
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  // Crée le dossier s'il n'existe pas
            }

            $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('wallpaper_') . '.' . $fileExtension; // Crée un nom de fichier unique
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($uploadedFile['tmp_name'], $uploadPath)) {
                // Stocker le chemin avec './../' dans la base de données
                $relativePath = './../public/upload/wallpapers/' . $fileName;  // Chemin avec './../'

                // Mettre à jour la base de données avec le chemin relatif du wallpaper
                $query = $pdo->prepare("UPDATE forums SET wallpaper = :wallpaper WHERE id = :forum_id");
                $query->bindParam(':wallpaper', $relativePath, PDO::PARAM_STR);
                $query->bindParam(':forum_id', $forumId, PDO::PARAM_INT);
                $query->execute();

                $_SESSION['success'] = "Wallpaper mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors du déplacement du fichier.";
            }
        } else {
            $_SESSION['error'] = "Erreur lors de l'upload du fichier.";
        }
    } else {
        $_SESSION['error'] = "ID de forum invalide.";
    }
} else {
    $_SESSION['error'] = "Requête invalide.";
}

header('Location: ./../view/Abyss-Forum.php?forum_id=' . $forumId);
exit;
?>
